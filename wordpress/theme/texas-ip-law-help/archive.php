<?php
/**
 * Category, tag, and date archives.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
  <main class="mock-content-page" id="main">
    <p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · <a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">Articles</a></p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)"><?php the_archive_title(); ?></h1>
	<?php
	if ( have_posts() ) {
		global $wp_query;
		help_render_post_cards( $wp_query, 'list' );
		the_posts_pagination();
	} else {
		echo '<p>' . esc_html__( 'Nothing here yet.', 'texas-ip-law-help' ) . '</p>';
	}
	?>
  </main>
<?php
get_footer();
