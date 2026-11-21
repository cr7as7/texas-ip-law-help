<?php
/**
 * Texas IP Law Help theme setup.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

define( 'HELP_THEME_VERSION', '1.2.1' );

require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/seo.php' );
require_once get_theme_file_path( 'inc/search.php' );
require_once get_theme_file_path( 'inc/consult.php' );
require_once get_theme_file_path( 'inc/ai.php' );
require_once get_theme_file_path( 'inc/seed.php' );

/**
 * Theme supports.
 */
function help_setup() {
	load_theme_textdomain( 'texas-ip-law-help', get_theme_file_path( 'languages' ) );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	set_post_thumbnail_size( 640, 360, true );
}
add_action( 'after_setup_theme', 'help_setup' );

/**
 * Styles and script. Fonts are self-hosted from style.css.
 */
function help_enqueue_assets() {
	wp_enqueue_style( 'texas-ip-law-help', get_stylesheet_uri(), array(), HELP_THEME_VERSION );
	wp_enqueue_script(
		'texas-ip-law-help',
		get_theme_file_uri( 'assets/js/help.js' ),
		array(),
		HELP_THEME_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_localize_script(
		'texas-ip-law-help',
		'helpSite',
		array(
			'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
			'consultEmail' => help_consult_email(),
			'firmUrl'      => 'https://texasiplawgroup.com/',
			'ai'           => array( 'live' => help_ai_is_live() ),
			'urls'         => array(
				'ask'         => help_url( 'ask' ),
				'guidePatent' => help_url( 'guides-patent' ),
				'guideMark'   => help_url( 'guides-trademark' ),
				'guideCopy'   => help_url( 'guides-copyright' ),
				'provisional' => help_url( 'a-provisional' ),
				'privacy'     => help_url( 'privacy' ),
			),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'help_enqueue_assets' );

/**
 * Remove block-library CSS the mock design does not use (page speed).
 */
function help_trim_default_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'help_trim_default_styles', 100 );

/**
 * Turn off WordPress emoji conversion. It swaps "↗" and similar characters for emoji
 * images (changing the design) and adds a render-blocking script and inline CSS.
 */
function help_disable_emoji() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'help_disable_emoji' );

/**
 * Preload the two self-hosted fonts.
 */
function help_preload_fonts() {
	foreach ( array( 'cinzel-latin.woff2', 'source-sans-3-latin.woff2' ) as $font ) {
		printf(
			'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
			esc_url( get_theme_file_uri( 'assets/fonts/' . $font ) )
		);
	}
}
add_action( 'wp_head', 'help_preload_fonts', 2 );

/**
 * Plain WordPress search -> our search results page.
 */
function help_redirect_core_search() {
	if ( is_search() && ! is_admin() ) {
		$term = get_search_query( false );
		wp_safe_redirect( add_query_arg( 'q', rawurlencode( $term ), help_url( 'search-results' ) ), 302 );
		exit;
	}
}
add_action( 'template_redirect', 'help_redirect_core_search' );

/**
 * Excerpt tweaks.
 */
add_filter(
	'excerpt_more',
	static function () {
		return '…';
	}
);
