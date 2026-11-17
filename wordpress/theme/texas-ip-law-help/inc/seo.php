<?php
/**
 * SEO: titles, meta descriptions, canonical, Open Graph, robots, and JSON-LD.
 *
 * All SEO output lives here (not scattered across templates).
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Titles and descriptions carried over from the approved mock.
 *
 * @return array<string,array<string,string>>
 */
function help_seo_data() {
	static $data = null;
	if ( null === $data ) {
		$data = require get_theme_file_path( 'inc/seo-data.php' );
	}
	return $data;
}

/**
 * SEO values for the current request.
 *
 * @return array{title:string,description:string,canonical:string,type:string,image:string,noindex:bool}
 */
function help_seo_current() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}

	$data  = help_seo_data();
	$site  = 'Texas IP Law Help';
	$out   = array(
		'title'       => $site,
		'description' => get_bloginfo( 'description' ),
		'canonical'   => home_url( '/' ),
		'type'        => 'website',
		'image'       => '',
		'noindex'     => false,
	);
	$front = isset( $data[''] ) ? $data[''] : array();

	if ( is_front_page() ) {
		$out['title']       = isset( $front['title'] ) ? $front['title'] : $site;
		$out['description'] = isset( $front['description'] ) ? $front['description'] : $out['description'];
	} elseif ( is_home() ) {
		$row = $data['articles'];
		$out['title']       = $row['title'];
		$out['description'] = $row['description'];
		$page_id            = (int) get_option( 'page_for_posts' );
		$out['canonical']   = $page_id ? get_permalink( $page_id ) : home_url( '/articles/' );
		if ( get_query_var( 'paged' ) > 1 ) {
			$out['canonical'] = get_pagenum_link( (int) get_query_var( 'paged' ) );
		}
	} elseif ( is_singular( 'post' ) ) {
		$id    = get_queried_object_id();
		$title = (string) get_post_meta( $id, 'help_seo_title', true );
		$desc  = (string) get_post_meta( $id, 'help_seo_desc', true );
		if ( '' === $desc ) {
			$desc = wp_strip_all_tags( get_the_excerpt( $id ) );
		}
		$out['title']       = '' !== $title ? $title : get_the_title( $id ) . ' | ' . $site;
		$out['description'] = $desc;
		$out['canonical']   = get_permalink( $id );
		$out['type']        = 'article';
		$out['image']       = (string) get_the_post_thumbnail_url( $id, 'large' );
	} elseif ( is_page() ) {
		$id  = get_queried_object_id();
		$uri = get_page_uri( $id );
		if ( isset( $data[ $uri ] ) ) {
			$out['title']       = $data[ $uri ]['title'];
			$out['description'] = $data[ $uri ]['description'];
		} else {
			$out['title']       = get_the_title( $id ) . ' | ' . $site;
			$out['description'] = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', $id ) ), 28, '…' );
		}
		$out['canonical'] = get_permalink( $id );
		if ( 'search-results' === $uri ) {
			$out['noindex'] = true;
		}
	} elseif ( is_404() ) {
		$out['title']   = 'Page not found | ' . $site;
		$out['noindex'] = true;
	} elseif ( is_archive() ) {
		$out['title']     = wp_strip_all_tags( get_the_archive_title() ) . ' | ' . $site;
		$out['canonical'] = get_pagenum_link( max( 1, (int) get_query_var( 'paged' ) ) );
	}

	if ( '' === $out['description'] ) {
		$out['description'] = 'Patent, trademark, and copyright guides for inventors, by Texas IP Law Group. Educational only; not legal advice.';
	}

	$cache = $out;
	return $cache;
}

/**
 * Document title.
 *
 * @return string
 */
function help_document_title() {
	$seo = help_seo_current();
	return $seo['title'];
}
add_filter( 'pre_get_document_title', 'help_document_title' );

/**
 * Robots: keep the search page and 404s out of the index.
 *
 * @param array<string,mixed> $robots Directives.
 * @return array<string,mixed>
 */
function help_robots( $robots ) {
	$seo = help_seo_current();
	if ( $seo['noindex'] ) {
		$robots['noindex'] = true;
		$robots['follow']  = true;
		unset( $robots['max-image-preview'] );
	}
	return $robots;
}
add_filter( 'wp_robots', 'help_robots' );

/**
 * Meta description, canonical, Open Graph, Twitter, JSON-LD.
 */
function help_head_seo() {
	if ( is_admin() ) {
		return;
	}
	$seo = help_seo_current();

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	if ( ! $seo['noindex'] ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $seo['canonical'] ) );
	}

	$og = array(
		'og:locale'      => 'en_US',
		'og:type'        => $seo['type'],
		'og:site_name'   => 'Texas IP Law Help',
		'og:title'       => $seo['title'],
		'og:description' => $seo['description'],
		'og:url'         => $seo['canonical'],
	);
	if ( $seo['image'] ) {
		$og['og:image'] = $seo['image'];
	}
	foreach ( $og as $property => $content ) {
		printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $property ), esc_attr( $content ) );
	}
	printf( '<meta name="twitter:card" content="%s">' . "\n", esc_attr( $seo['image'] ? 'summary_large_image' : 'summary' ) );
	printf( '<meta name="twitter:title" content="%s">' . "\n", esc_attr( $seo['title'] ) );
	printf( '<meta name="twitter:description" content="%s">' . "\n", esc_attr( $seo['description'] ) );
	if ( $seo['image'] ) {
		printf( '<meta name="twitter:image" content="%s">' . "\n", esc_url( $seo['image'] ) );
	}

	$graph = help_json_ld_graph( $seo );
	printf(
		'<script type="application/ld+json">%s</script>' . "\n",
		wp_json_encode( array( '@context' => 'https://schema.org', '@graph' => $graph ), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ) // phpcs:ignore WordPress.Security.EscapeOutput
	);
}
add_action( 'wp_head', 'help_head_seo', 3 );
remove_action( 'wp_head', 'rel_canonical' );

/**
 * Structured data.
 *
 * @param array<string,mixed> $seo Current SEO values.
 * @return array<int,array<string,mixed>>
 */
function help_json_ld_graph( $seo ) {
	$home  = home_url( '/' );
	$graph = array(
		array(
			'@type'          => 'Organization',
			'@id'            => $home . '#organization',
			'name'           => 'Texas IP Law Help',
			'url'            => $home,
			'parentOrganization' => array(
				'@type'     => 'LegalService',
				'name'      => 'Texas IP Law Group',
				'url'       => 'https://texasiplawgroup.com/',
				'telephone' => '+1-713-518-8837',
				'email'     => 'contact@texasiplawgroup.com',
				'areaServed' => 'US',
			),
		),
		array(
			'@type'           => 'WebSite',
			'@id'             => $home . '#website',
			'url'             => $home,
			'name'            => 'Texas IP Law Help',
			'description'     => 'Patent, trademark, and copyright guides for inventors, by Texas IP Law Group.',
			'inLanguage'      => 'en-US',
			'publisher'       => array( '@id' => $home . '#organization' ),
			'potentialAction' => array(
				'@type'       => 'SearchAction',
				'target'      => array(
					'@type'       => 'EntryPoint',
					'urlTemplate' => help_url( 'search-results' ) . '?q={search_term_string}',
				),
				'query-input' => 'required name=search_term_string',
			),
		),
	);

	if ( ! is_front_page() && ( is_singular() || is_home() ) ) {
		$items = array();
		$pos   = 1;
		foreach ( help_breadcrumbs() as $crumb ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $pos++,
				'name'     => wp_strip_all_tags( $crumb[0] ),
				'item'     => $crumb[1] ? $crumb[1] : $seo['canonical'],
			);
		}
		$graph[] = array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
	}

	if ( is_singular( 'post' ) ) {
		$id      = get_queried_object_id();
		$article = array(
			'@type'            => 'Article',
			'@id'              => $seo['canonical'] . '#article',
			'mainEntityOfPage' => $seo['canonical'],
			'headline'         => get_the_title( $id ),
			'description'      => $seo['description'],
			'datePublished'    => get_post_time( 'c', true, $id ),
			'dateModified'     => get_post_modified_time( 'c', true, $id ),
			'inLanguage'       => 'en-US',
			'author'           => array( '@id' => $home . '#organization' ),
			'publisher'        => array( '@id' => $home . '#organization' ),
		);
		if ( $seo['image'] ) {
			$article['image'] = $seo['image'];
		}
		$graph[] = $article;
	}

	return $graph;
}
