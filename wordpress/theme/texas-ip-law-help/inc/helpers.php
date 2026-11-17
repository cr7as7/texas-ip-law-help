<?php
/**
 * URL map, navigation, and card helpers.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site paths by key. Keep in sync with the pages created in inc/seed.php.
 *
 * @return array<string,string>
 */
function help_url_map() {
	return array(
		'home'             => '',
		'guides'           => 'guides/',
		'guides-patent'    => 'guides/patent/',
		'guides-trademark' => 'guides/trademark/',
		'guides-copyright' => 'guides/copyright/',
		'articles'         => 'articles/',
		'a-patent-basics'  => 'articles/patent-basics/',
		'a-provisional'    => 'articles/provisional-vs-non-provisional/',
		'a-patentability'  => 'articles/is-my-idea-patentable/',
		'a-licensing'      => 'articles/licensing-your-ip/',
		'resources'        => 'resources/',
		'ask'              => 'ask/',
		'faq'              => 'faq/',
		'about'            => 'about/',
		'disclaimer'       => 'disclaimer/',
		'privacy'          => 'privacy/',
		'contact'          => 'contact/',
		'search-results'   => 'search-results/',
	);
}

/**
 * Absolute URL for a site key (never hardcodes the domain).
 *
 * @param string $key Key from help_url_map().
 * @return string
 */
function help_url( $key ) {
	$map  = help_url_map();
	$path = isset( $map[ $key ] ) ? $map[ $key ] : '';
	return home_url( '/' . $path );
}

/**
 * Primary navigation (label by key), same order as the approved mock.
 *
 * @return array<string,string>
 */
function help_nav_items() {
	return array(
		'home'      => __( 'Home', 'texas-ip-law-help' ),
		'guides'    => __( 'Guides', 'texas-ip-law-help' ),
		'articles'  => __( 'Articles', 'texas-ip-law-help' ),
		'resources' => __( 'Resources', 'texas-ip-law-help' ),
		'ask'       => __( 'Ask AI', 'texas-ip-law-help' ),
		'faq'       => __( 'FAQ', 'texas-ip-law-help' ),
		'about'     => __( 'About', 'texas-ip-law-help' ),
	);
}

/**
 * Which nav item is active on the current request.
 *
 * @return string Nav key or empty string.
 */
function help_active_nav() {
	if ( is_front_page() ) {
		return 'home';
	}
	if ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_archive() ) {
		return 'articles';
	}
	if ( is_page() ) {
		$uri = get_page_uri( get_queried_object_id() );
		$top = strtok( $uri, '/' );
		$map = array(
			'guides'         => 'guides',
			'resources'      => 'resources',
			'ask'            => 'ask',
			'faq'            => 'faq',
			'about'          => 'about',
			'disclaimer'     => 'about',
			'privacy'        => 'about',
			'contact'        => 'about',
			'search-results' => 'home',
		);
		return isset( $map[ $top ] ) ? $map[ $top ] : '';
	}
	return '';
}

/**
 * Featured articles for the home page (flag set in seed or via the help_featured meta).
 * Falls back to the latest three posts.
 *
 * @return WP_Query
 */
function help_featured_posts() {
	$featured = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'meta_key'            => 'help_featured',
			'meta_value'          => '1',
		)
	);
	if ( $featured->have_posts() ) {
		return $featured;
	}
	return new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
}

/**
 * Card image URL: featured image, else empty.
 *
 * @param int $post_id Post ID.
 * @return string
 */
function help_card_image( $post_id ) {
	$url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
	return $url ? $url : '';
}

/**
 * Article cards, same markup as the approved mock.
 *
 * @param WP_Query $query   Posts to show.
 * @param string   $variant 'home' or 'list'.
 */
function help_render_post_cards( $query, $variant = 'list' ) {
	$grid_style = ( 'list' === $variant ) ? ' style="margin-top:32px"' : '';
	echo '<div class="mock-blog-grid"' . $grid_style . '>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
	while ( $query->have_posts() ) {
		$query->the_post();
		$id    = get_the_ID();
		$image = help_card_image( $id );
		$blurb = '';
		if ( 'home' === $variant ) {
			$blurb = (string) get_post_meta( $id, 'help_home_blurb', true );
		}
		if ( '' === $blurb ) {
			$blurb = get_the_excerpt();
		}
		$p_style = ( 'home' === $variant ) ? 'font-size:13px;color:var(--muted);margin:0' : 'font-size:13px;color:var(--muted)';
		?>
		<a class="mock-blog-card mock-blog-card--link" href="<?php echo esc_url( get_permalink() ); ?>">
			<div class="mock-blog-card__img"<?php echo $image ? ' style="background-image:url(' . esc_url( $image ) . ')"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>></div>
			<div class="mock-blog-card__body">
				<h4><?php the_title(); ?></h4>
				<p style="<?php echo esc_attr( $p_style ); ?>"><?php echo esc_html( $blurb ); ?></p>
			</div>
		</a>
		<?php
	}
	echo '</div>' . "\n";
	wp_reset_postdata();
}

/**
 * Breadcrumb trail for pages and posts as [ label, url|'' ].
 *
 * @return array<int,array{0:string,1:string}>
 */
function help_breadcrumbs() {
	$crumbs = array( array( __( 'Home', 'texas-ip-law-help' ), help_url( 'home' ) ) );
	if ( is_singular( 'post' ) ) {
		$crumbs[] = array( __( 'Articles', 'texas-ip-law-help' ), help_url( 'articles' ) );
		$crumbs[] = array( get_the_title(), '' );
	} elseif ( is_home() ) {
		$crumbs[] = array( __( 'Articles', 'texas-ip-law-help' ), '' );
	} elseif ( is_page() && ! is_front_page() ) {
		$ancestors = array_reverse( get_post_ancestors( get_queried_object_id() ) );
		foreach ( $ancestors as $ancestor_id ) {
			$crumbs[] = array( get_the_title( $ancestor_id ), get_permalink( $ancestor_id ) );
		}
		$crumbs[] = array( get_the_title( get_queried_object_id() ), '' );
	}
	return $crumbs;
}
