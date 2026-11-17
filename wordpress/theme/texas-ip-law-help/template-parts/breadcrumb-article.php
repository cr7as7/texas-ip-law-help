<?php
/**
 * Breadcrumb for an article hero: "Home · Articles" (the title is the H1 right below).
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
<p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · <a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">Articles</a></p>
