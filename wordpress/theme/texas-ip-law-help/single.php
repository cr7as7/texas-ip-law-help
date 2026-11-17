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
  <main class="mock-guide-page help-longform" id="main">
    <?php the_content(); ?>
    <div class="help-cta-band">
      <h2>Questions about your own situation?</h2>
      <p>This article is general information. Texas IP Law Group can look at your facts.</p>
      <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button>
    </div>
    <?php
    $help_related = new WP_Query(
      array(
        'post_type'           => 'post',
        'posts_per_page'      => 3,
        'post__not_in'        => array( get_the_ID() ),
        'ignore_sticky_posts' => true,
        'no_found_rows'       => true,
      )
    );
    if ( $help_related->have_posts() ) {
      echo '<h2>More articles</h2>';
      help_render_post_cards( $help_related, 'list' );
    }
    ?>
    <p style="margin-top:28px"><a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">All articles</a> · <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">Guides</a> · <a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a></p>
  </main>
	<?php
}

get_footer();
