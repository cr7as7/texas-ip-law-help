<?php
/**
 * 404 page.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
  <main class="mock-guide-page" id="main">
    <h1>Page not found</h1>
    <p>That page does not exist or has moved. Try the <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">guides</a>, <a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">articles</a>, or <a href="<?php echo esc_url( help_url( 'search-results' ) ); ?>">search</a>.</p>
    <p style="margin-top:24px"><a class="mock-btn mock-btn--gold" href="<?php echo esc_url( help_url( 'home' ) ); ?>">Back to home</a></p>
  </main>
<?php
get_footer();
