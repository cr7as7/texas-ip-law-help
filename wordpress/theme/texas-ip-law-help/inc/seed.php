<?php
/**
 * First-run setup: creates the pages and starter articles, sets the front page,
 * permalinks, and site title. Safe to run again (it only creates what is missing).
 *
 * Runs on theme activation. Run manually with:
 *   wp eval 'help_seed_site();'
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages the theme expects. Layout and copy for each lives in template-parts/pages/.
 *
 * @return array<string,string> uri => admin title
 */
function help_seed_pages() {
	return array(
		'home'              => 'Home',
		'guides'            => 'Guides',
		'guides/patent'     => 'How to file a patent — overview for inventors',
		'guides/trademark'  => 'How to file a trademark — overview',
		'guides/copyright'  => 'How to file a copyright — overview',
		'articles'          => 'Articles',
		'resources'         => 'Official resources',
		'ask'               => 'Ask Texas IP Law Help AI',
		'faq'               => 'Frequently asked questions',
		'about'             => 'About Texas IP Law Help',
		'disclaimer'        => 'Disclaimer',
		'privacy'           => 'Privacy notice',
		'contact'           => 'Contact Texas IP Law Group',
		'search-results'    => 'Search results',
	);
}

/**
 * Create any missing pages. Parents are created before children.
 *
 * @return array<string,int> uri => page ID
 */
function help_seed_create_pages() {
	$ids = array();
	foreach ( help_seed_pages() as $uri => $title ) {
		$existing = get_page_by_path( $uri, OBJECT, 'page' );
		if ( $existing ) {
			$ids[ $uri ] = (int) $existing->ID;
			continue;
		}
		$parts  = explode( '/', $uri );
		$slug   = array_pop( $parts );
		$parent = $parts ? ( isset( $ids[ implode( '/', $parts ) ] ) ? $ids[ implode( '/', $parts ) ] : 0 ) : 0;
		$id     = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => wp_slash( $title ),
				'post_name'    => $slug,
				'post_parent'  => $parent,
				'post_content' => '',
			),
			true
		);
		if ( ! is_wp_error( $id ) ) {
			$ids[ $uri ] = (int) $id;
		}
	}
	return $ids;
}

/**
 * Replace {{help_url:key}} tokens in stored article content.
 *
 * @param string $content Raw content.
 * @return string
 */
function help_seed_resolve_tokens( $content ) {
	return preg_replace_callback(
		'/\{\{help_url:([a-z\-]+)\}\}/',
		static function ( $m ) {
			return esc_url_raw( help_url( $m[1] ) );
		},
		$content
	);
}

/**
 * Attach a theme image to a post as its featured image.
 *
 * @param int    $post_id Post ID.
 * @param string $file    File name in assets/images/blog/.
 * @param string $alt     Alt text.
 */
function help_seed_attach_image( $post_id, $file, $alt ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return;
	}
	$src = get_theme_file_path( 'assets/images/blog/' . $file );
	if ( ! file_exists( $src ) ) {
		return;
	}
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$tmp = wp_tempnam( $file );
	if ( ! $tmp || ! copy( $src, $tmp ) ) {
		return;
	}
	$attachment = media_handle_sideload(
		array(
			'name'     => $file,
			'tmp_name' => $tmp,
		),
		$post_id,
		$alt
	);
	if ( is_wp_error( $attachment ) ) {
		if ( file_exists( $tmp ) ) {
			wp_delete_file( $tmp );
		}
		return;
	}
	update_post_meta( $attachment, '_wp_attachment_image_alt', $alt );
	set_post_thumbnail( $post_id, $attachment );
}

/**
 * Create any missing starter articles.
 */
function help_seed_create_posts() {
	$articles = require get_theme_file_path( 'inc/seed-content.php' );
	foreach ( $articles as $article ) {
		$existing = get_page_by_path( $article['slug'], OBJECT, 'post' );
		if ( $existing ) {
			// Retry the image if an earlier run could not attach it.
			help_seed_attach_image( $existing->ID, $article['image'], $article['title'] );
			continue;
		}
		$when    = gmdate( 'Y-m-d H:i:s', time() - ( (int) $article['age_days'] * DAY_IN_SECONDS ) );
		$content = "<!-- wp:html -->\n" . help_seed_resolve_tokens( $article['content'] ) . "\n<!-- /wp:html -->";
		$post_id = wp_insert_post(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'post_title'    => wp_slash( $article['title'] ),
				'post_name'     => $article['slug'],
				'post_excerpt'  => wp_slash( $article['excerpt'] ),
				'post_content'  => wp_slash( $content ),
				'post_date_gmt' => $when,
				'post_date'     => get_date_from_gmt( $when ),
			),
			true
		);
		if ( is_wp_error( $post_id ) ) {
			continue;
		}
		update_post_meta( $post_id, 'help_seo_title', $article['seo_title'] );
		update_post_meta( $post_id, 'help_seo_desc', $article['seo_desc'] );
		if ( '' !== $article['home_blurb'] ) {
			update_post_meta( $post_id, 'help_home_blurb', $article['home_blurb'] );
		}
		if ( $article['featured'] ) {
			update_post_meta( $post_id, 'help_featured', '1' );
		}
		help_seed_attach_image( $post_id, $article['image'], $article['title'] );
	}
}

/**
 * Remove the stock WordPress sample content if untouched.
 */
function help_seed_remove_defaults() {
	$post = get_page_by_path( 'hello-world', OBJECT, 'post' );
	if ( $post && 'Hello world!' === $post->post_title ) {
		wp_delete_post( $post->ID, true );
	}
	$page = get_page_by_path( 'sample-page', OBJECT, 'page' );
	if ( $page && 'Sample Page' === $page->post_title ) {
		wp_delete_post( $page->ID, true );
	}
}

/**
 * Run the whole setup.
 */
function help_seed_site() {
	// Starter copy contains buttons and inline styles; skip kses while we write it.
	kses_remove_filters();

	help_seed_remove_defaults();
	$pages = help_seed_create_pages();
	help_seed_create_posts();

	kses_init_filters();

	if ( isset( $pages['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
	}
	if ( isset( $pages['articles'] ) ) {
		update_option( 'page_for_posts', $pages['articles'] );
	}

	update_option( 'blogname', 'Texas IP Law Help' );
	update_option( 'blogdescription', 'Patent, trademark, and copyright help for inventors — by Texas IP Law Group' );

	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/articles/%postname%/' );
	$wp_rewrite->flush_rules( false );

	update_option( 'help_seed_version', HELP_THEME_VERSION );
}
add_action( 'after_switch_theme', 'help_seed_site' );

/**
 * Self-heal after a deploy: when the theme version changes, an admin visit fills in anything
 * missing (pages, articles, article images). Never overwrites content that exists and never
 * touches settings the owner may have changed, except to set a missing front page.
 */
function help_seed_repair() {
	if ( ! current_user_can( 'manage_options' ) || get_option( 'help_seed_version' ) === HELP_THEME_VERSION ) {
		return;
	}
	if ( ! get_option( 'help_seed_version' ) ) {
		return; // Never activated: after_switch_theme does the first full setup.
	}
	kses_remove_filters();
	$pages = help_seed_create_pages();
	help_seed_create_posts();
	kses_init_filters();

	if ( ! get_option( 'page_on_front' ) && isset( $pages['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $pages['home'] );
	}
	if ( ! get_option( 'page_for_posts' ) && isset( $pages['articles'] ) ) {
		update_option( 'page_for_posts', $pages['articles'] );
	}
	update_option( 'help_seed_version', HELP_THEME_VERSION );
}
add_action( 'admin_init', 'help_seed_repair' );
