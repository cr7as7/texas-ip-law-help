<?php
/**
 * Fallback template.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
  <main class="mock-guide-page" id="main">
	<?php if ( have_posts() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			?>
    <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
			<?php the_excerpt(); ?>
		<?php endwhile; ?>
		<?php the_posts_pagination(); ?>
	<?php else : ?>
    <h1><?php esc_html_e( 'Nothing found', 'texas-ip-law-help' ); ?></h1>
	<?php endif; ?>
  </main>
<?php
get_footer();
