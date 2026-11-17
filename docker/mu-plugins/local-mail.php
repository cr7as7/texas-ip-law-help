<?php
/**
 * Local development only: send all WordPress mail to the Mailpit container.
 * Mounted by docker-compose.yml; never deployed (not inside the theme folder).
 *
 * Plugin Name: Local mail to Mailpit
 */

// "wordpress@localhost" is not a valid address for PHPMailer.
add_filter(
	'wp_mail_from',
	static function () {
		return 'wordpress@help.test';
	}
);

add_action(
	'phpmailer_init',
	static function ( $mailer ) {
		$mailer->isSMTP();
		$mailer->Host        = 'mailpit';
		$mailer->Port        = 1025;
		$mailer->SMTPAuth    = false;
		$mailer->SMTPAutoTLS = false;
	}
);
