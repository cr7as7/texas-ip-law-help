<?php
/**
 * Single article.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	?>
  <header class="help-article-hero">
    <div class="help-article-hero__inner">
      <?php get_template_part( 'template-parts/breadcrumb-article' ); ?>
      <h1><?php the_title(); ?></h1>
      <p>Educational explainer by Texas IP Law Group. Not legal advice for your facts.</p>
    </div>
  </header>
  <main class="mock-guide-page" id="main">
    <?php the_content(); ?>
    <p style="margin-top:28px"><a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">All articles</a> · <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">Guides</a> · <a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a></p>
  </main>
	<?php
}

get_footer();
