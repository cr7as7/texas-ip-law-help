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
    <p style="max-width:640px">Looking for step-by-step help instead? Open the <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">guides</a>. For official forms and search tools, see <a href="<?php echo esc_url( help_url( 'resources' ) ); ?>">official resources</a>.</p>
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
    <div class="help-cta-band" style="margin-top:48px">
      <h2>Have a question these articles do not answer?</h2>
      <p>Try the Ask AI chat for general questions, or request a free consultation for your own facts.</p>
      <a class="mock-btn mock-btn--gold" href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a>
      <button type="button" class="mock-btn mock-btn--gold" data-open-consult style="margin-left:8px">Free consultation</button>
    </div>
  </main>
<?php
get_footer();
