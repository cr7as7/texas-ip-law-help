<?php
/**
 * Free-consultation form: emails Texas IP Law Group.
 *
 * Public (logged-out) endpoint, so no nonce (page caching makes nonces unreliable).
 * Protection: honeypot, per-IP rate limit, strict validation, header-safe fields.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Where consultation requests go. Override with the help_consult_email filter or the
 * HELP_CONSULT_EMAIL constant in wp-config.php.
 *
 * @return string
 */
function help_consult_email() {
	$email = defined( 'HELP_CONSULT_EMAIL' ) ? HELP_CONSULT_EMAIL : 'contact@texasiplawgroup.com';
	return (string) apply_filters( 'help_consult_email', $email );
}

/**
 * Handle the AJAX submission.
 */
function help_consult_handler() {
	// Honeypot: bots fill hidden fields. Pretend success so they move on.
	// phpcs:ignore WordPress.Security.NonceVerification.Missing
	if ( ! empty( $_POST['website'] ) ) {
		wp_send_json_success();
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing
	$name      = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone     = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$invention = isset( $_POST['invention'] ) ? sanitize_textarea_field( wp_unslash( $_POST['invention'] ) ) : '';
	$interest  = isset( $_POST['interest'] ) ? array_map( 'sanitize_key', (array) wp_unslash( $_POST['interest'] ) ) : array();
	// phpcs:enable

	$interest = array_values( array_intersect( $interest, array( 'patent', 'trademark', 'copyright', 'licensing' ) ) );

	if ( '' === $name || strlen( $name ) > 120 || ! is_email( $email ) || '' === $invention || strlen( $invention ) > 5000 || ! $interest ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in your name, a valid email, your question, and at least one interest.', 'texas-ip-law-help' ) ), 400 );
	}

	$ip    = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key   = 'help_consult_' . md5( $ip );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		wp_send_json_error( array( 'message' => __( 'Too many requests. Please call 713-518-8837 or email contact@texasiplawgroup.com.', 'texas-ip-law-help' ) ), 429 );
	}
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );

	$lines = array(
		'New free-consultation request from texasiplawhelp.com',
		'',
		'Name: ' . $name,
		'Email: ' . $email,
		'Phone: ' . ( '' !== $phone ? $phone : '(not given)' ),
		'Interested in: ' . implode( ', ', $interest ),
		'',
		'Question:',
		$invention,
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $name . ' <' . $email . '>',
	);

	$sent = wp_mail(
		help_consult_email(),
		'Texas IP Law Help — consultation — ' . $name,
		implode( "\n", $lines ),
		$headers
	);

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => __( 'We could not send your request. Please call 713-518-8837 or email contact@texasiplawgroup.com.', 'texas-ip-law-help' ) ), 500 );
	}

	wp_send_json_success();
}
add_action( 'wp_ajax_nopriv_help_consult', 'help_consult_handler' );
add_action( 'wp_ajax_help_consult', 'help_consult_handler' );
