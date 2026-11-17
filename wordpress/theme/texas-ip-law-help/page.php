<?php
/**
 * Pages. Pages created by the theme use a matching file in template-parts/pages/
 * (so layout and copy are versioned in git). Any other page falls back to the editor content.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	$help_key  = str_replace( '/', '-', get_page_uri() );
	$help_part = locate_template( 'template-parts/pages/' . sanitize_file_name( $help_key ) . '.php' );

	if ( $help_part ) {
		load_template( $help_part, false );
		continue;
	}
	?>
  <main class="mock-guide-page" id="main">
    <?php get_template_part( 'template-parts/breadcrumb' ); ?>
    <h1><?php the_title(); ?></h1>
    <?php the_content(); ?>
  </main>
	<?php
}

get_footer();
