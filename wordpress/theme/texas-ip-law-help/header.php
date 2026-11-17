<?php
/**
 * Site header.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

$help_active = help_active_nav();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'texas-ip-law-help' ); ?></a>
  <header class="mock-site-header">
    <div class="mock-site-header__inner">
      <a class="mock-logo" href="<?php echo esc_url( help_url( 'home' ) ); ?>">
        <span class="mock-logo__mark" aria-hidden="true">⌕</span>
        <span class="mock-logo__text">
          <strong class="help-site-name">Texas IP Law Help</strong>
          <span class="help-site-byline">by Texas IP Law Group</span>
        </span>
      </a>
      <nav class="mock-nav" aria-label="<?php esc_attr_e( 'Primary', 'texas-ip-law-help' ); ?>">
<?php foreach ( help_nav_items() as $help_key => $help_label ) : ?>
        <a href="<?php echo esc_url( help_url( $help_key ) ); ?>"<?php echo $help_key === $help_active ? ' class="is-active" aria-current="page"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $help_label ); ?></a>
<?php endforeach; ?>
      </nav>
      <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button>
    </div>
  </header>
