<?php
/**
 * Breadcrumb line (matches the mock: "Home · Guides · Patent").
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

$help_crumbs = help_breadcrumbs();
$help_last   = count( $help_crumbs ) - 1;
?>
<nav class="mock-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'texas-ip-law-help' ); ?>">
<?php
foreach ( $help_crumbs as $help_i => $help_crumb ) {
	if ( $help_i > 0 ) {
		echo ' · ';
	}
	if ( $help_i < $help_last && $help_crumb[1] ) {
		printf( '<a href="%s">%s</a>', esc_url( $help_crumb[1] ), esc_html( $help_crumb[0] ) );
	} else {
		echo '<span aria-current="page">' . esc_html( $help_crumb[0] ) . '</span>';
	}
}
?>
</nav>
