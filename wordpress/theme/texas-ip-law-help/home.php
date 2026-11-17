<?php
/**
 * Articles list (the "posts page").
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
  <main class="mock-content-page" id="main">
    <p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · Articles</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Articles for inventors</h1>
    <p style="color:var(--muted);max-width:640px">Help-focused explainers — not legal advice. When you need counsel for your invention, Texas IP Law Group offers a free consultation.</p>
	<?php
	if ( have_posts() ) {
		global $wp_query;
		help_render_post_cards( $wp_query, 'list' );
		the_posts_pagination(
			array(
				'mid_size'  => 1,
				'prev_text' => __( '← Newer', 'texas-ip-law-help' ),
				'next_text' => __( 'Older →', 'texas-ip-law-help' ),
			)
		);
	} else {
		echo '<p>' . esc_html__( 'Articles are coming soon.', 'texas-ip-law-help' ) . '</p>';
	}
	?>
  </main>
<?php
get_footer();
