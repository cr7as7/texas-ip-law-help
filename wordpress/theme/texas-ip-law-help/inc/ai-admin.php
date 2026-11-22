<?php
/**
 * "Help AI" page in wp-admin: paste the xAI key, pause the AI, change the caps, test the
 * connection, and watch live usage. Meant for the site owner (Susan) to use with her own login.
 *
 * - Who can open it: administrators, and the "Help AI manager" role (this page only).
 * - The API key is encrypted in the database and is never shown again (only the last 4 characters).
 * - Anything set in wp-config.php wins and is shown as locked.
 * - Only counters are stored. No questions or answers.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Role for someone who should only manage the AI (not the rest of the site).
 */
function help_ai_ensure_role() {
	if ( ! get_role( 'help_ai_manager' ) ) {
		add_role(
			'help_ai_manager',
			__( 'Help AI manager', 'texas-ip-law-help' ),
			array(
				'read'           => true,
				'help_manage_ai' => true,
			)
		);
	}
}
add_action( 'admin_init', 'help_ai_ensure_role' );

/**
 * Administrators can always manage the AI.
 *
 * @param array<string,bool> $allcaps All capabilities of the user.
 * @return array<string,bool>
 */
function help_ai_grant_cap( $allcaps ) {
	if ( ! empty( $allcaps['manage_options'] ) ) {
		$allcaps['help_manage_ai'] = true;
	}
	return $allcaps;
}
add_filter( 'user_has_cap', 'help_ai_grant_cap' );

/**
 * AI managers land on the AI page after login.
 *
 * @param string           $redirect Default redirect.
 * @param string           $request  Requested redirect.
 * @param WP_User|WP_Error $user     User.
 * @return string
 */
function help_ai_login_redirect( $redirect, $request, $user ) {
	if ( $user instanceof WP_User && in_array( 'help_ai_manager', (array) $user->roles, true ) ) {
		return admin_url( 'admin.php?page=help-ai' );
	}
	return $redirect;
}
add_filter( 'login_redirect', 'help_ai_login_redirect', 10, 3 );

/**
 * Menu entry.
 */
function help_ai_admin_menu() {
	add_menu_page(
		__( 'Help AI', 'texas-ip-law-help' ),
		__( 'Help AI', 'texas-ip-law-help' ),
		'help_manage_ai',
		'help-ai',
		'help_ai_admin_page',
		'dashicons-format-chat',
		58
	);
}
add_action( 'admin_menu', 'help_ai_admin_menu' );

/**
 * Limits for each number field: min, max.
 *
 * @return array<string,array{0:int,1:int}>
 */
function help_ai_field_limits() {
	return array(
		'daily_cap'    => array( 1000, 3000000 ),
		'monthly_cap'  => array( 10000, 50000000 ),
		'reply_tokens' => array( 100, 1200 ),
		'ip_hourly'    => array( 1, 100 ),
		'ip_daily'     => array( 1, 500 ),
	);
}

/**
 * Last four characters of the saved key, for display ('' if none).
 *
 * @return string
 */
function help_ai_key_hint() {
	$config = help_ai_config();
	return '' === $config['key'] ? '' : substr( $config['key'], -4 );
}

/**
 * Everything the page shows, as one array (also returned by the live-refresh AJAX call).
 *
 * @return array<string,mixed>
 */
function help_ai_stats_payload() {
	$config  = help_ai_config();
	$usage   = help_ai_usage();
	$days    = help_ai_history();
	$status  = get_option( 'help_ai_status', array() );
	$status  = is_array( $status ) ? $status : array();
	$today   = wp_date( 'Y-m-d' );
	$month   = wp_date( 'Y-m' );
	$default = array( 'tokens' => 0, 'calls' => 0, 'cap' => 0, 'limit' => 0, 'error' => 0 );
	$row     = isset( $days[ $today ] ) ? wp_parse_args( $days[ $today ], $default ) : $default;

	$month_calls = 0;
	foreach ( $days as $date => $d ) {
		if ( 0 === strpos( (string) $date, $month ) && isset( $d['calls'] ) ) {
			$month_calls += (int) $d['calls'];
		}
	}

	$last_ok    = isset( $status['last_ok'] ) ? (int) $status['last_ok'] : 0;
	$last_error = isset( $status['last_error'] ) ? (int) $status['last_error'] : 0;
	$err_code   = isset( $status['last_error_code'] ) ? $status['last_error_code'] : 0;
	$problem    = isset( $status['state'] ) && 'error' === $status['state'];

	$has_key = '' !== $config['key'];
	if ( ! $has_key ) {
		$level = 'warn';
		$label = __( 'Demo mode. No API key yet, so visitors see sample answers.', 'texas-ip-law-help' );
	} elseif ( ! $config['enabled'] ) {
		$level = 'warn';
		$label = __( 'Paused. Visitors see knowledge-base answers.', 'texas-ip-law-help' );
	} elseif ( $problem ) {
		$level = 'bad';
		$label = help_ai_error_text( $err_code );
	} elseif ( ! help_ai_within_budget( $config['reply_tokens'] + 600 ) ) {
		$level = 'warn';
		$label = __( 'Cap reached. Visitors get knowledge-base answers until the counter resets.', 'texas-ip-law-help' );
	} else {
		$level = 'ok';
		$label = __( 'Live. Grok is answering visitors.', 'texas-ip-law-help' );
	}

	$price = isset( help_ai_saved_settings()['price'] ) ? (float) help_ai_saved_settings()['price'] : 0.0;

	$history = array();
	for ( $i = 0; $i < 14; $i++ ) {
		$date      = wp_date( 'Y-m-d', time() - $i * DAY_IN_SECONDS );
		$d         = isset( $days[ $date ] ) ? wp_parse_args( $days[ $date ], $default ) : $default;
		$history[] = array(
			'date'    => $date,
			'tokens'  => (int) $d['tokens'],
			'calls'   => (int) $d['calls'],
			'visitor' => (int) $d['cap'] + (int) $d['limit'] + (int) $d['error'],
		);
	}

	return array(
		'level'        => $level,
		'label'        => $label,
		'day_tokens'   => (int) $usage['day_tokens'],
		'day_cap'      => (int) $config['daily_cap'],
		'month_tokens' => (int) $usage['month_tokens'],
		'month_cap'    => (int) $config['monthly_cap'],
		'day_calls'    => (int) $row['calls'],
		'month_calls'  => $month_calls,
		'fallbacks'    => array(
			'cap'   => (int) $row['cap'],
			'limit' => (int) $row['limit'],
			'error' => (int) $row['error'],
		),
		'cost_day'     => $price > 0 ? round( $usage['day_tokens'] / 1000000 * $price, 4 ) : null,
		'cost_month'   => $price > 0 ? round( $usage['month_tokens'] / 1000000 * $price, 2 ) : null,
		'last_ok'      => $last_ok,
		'last_error'   => $last_error,
		'last_problem' => $problem ? help_ai_error_text( $err_code ) : '',
		'history'      => $history,
		'server_time'  => time(),
	);
}

/**
 * Plain-English reason for an xAI failure.
 *
 * @param int|string $code HTTP status or 'network'.
 * @return string
 */
function help_ai_error_text( $code ) {
	$code = (string) $code;
	if ( in_array( $code, array( '401', '403' ), true ) ) {
		return __( 'xAI rejected the API key. Paste a new key below.', 'texas-ip-law-help' );
	}
	if ( '404' === $code || '400' === $code ) {
		return __( 'xAI did not accept the model name. Check the model name in the xAI console.', 'texas-ip-law-help' );
	}
	if ( '429' === $code ) {
		return __( 'xAI says the account is out of credits or rate limited. Check billing in the xAI console.', 'texas-ip-law-help' );
	}
	if ( 'network' === $code ) {
		return __( 'The site could not reach xAI.', 'texas-ip-law-help' );
	}
	return __( 'xAI returned an error. Visitors are getting knowledge-base answers.', 'texas-ip-law-help' );
}

/**
 * Live refresh.
 */
function help_ai_stats_ajax() {
	check_ajax_referer( 'help_ai_admin', 'nonce' );
	if ( ! current_user_can( 'help_manage_ai' ) ) {
		wp_send_json_error( null, 403 );
	}
	wp_send_json_success( help_ai_stats_payload() );
}
add_action( 'wp_ajax_help_ai_stats', 'help_ai_stats_ajax' );

/**
 * Send one tiny request to xAI to prove the key and model work.
 */
function help_ai_test_ajax() {
	check_ajax_referer( 'help_ai_admin', 'nonce' );
	if ( ! current_user_can( 'help_manage_ai' ) ) {
		wp_send_json_error( null, 403 );
	}

	// At most 10 tests an hour per person.
	$limit_key = 'help_ai_test_' . get_current_user_id();
	$count     = (int) get_transient( $limit_key );
	if ( $count >= 10 ) {
		wp_send_json_error( array( 'message' => __( 'Too many tests. Try again in an hour.', 'texas-ip-law-help' ) ) );
	}
	set_transient( $limit_key, $count + 1, HOUR_IN_SECONDS );

	$config = help_ai_config();
	$key    = isset( $_POST['key'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['key'] ) ) ) : '';
	$model  = isset( $_POST['model'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['model'] ) ) ) : '';
	$key    = '' !== $key ? $key : $config['key'];
	$model  = '' !== $model ? $model : $config['model'];

	if ( '' === $key ) {
		wp_send_json_error( array( 'message' => __( 'Paste an API key first.', 'texas-ip-law-help' ) ) );
	}
	if ( ! preg_match( '/^[A-Za-z0-9._\-:]{2,80}$/', $model ) ) {
		wp_send_json_error( array( 'message' => __( 'That model name has characters we do not accept.', 'texas-ip-law-help' ) ) );
	}

	$response = wp_remote_post(
		$config['endpoint'],
		array(
			'timeout'     => 25,
			'redirection' => 0,
			'headers'     => array(
				'Authorization' => 'Bearer ' . $key,
				'Content-Type'  => 'application/json',
			),
			'body'        => wp_json_encode(
				array(
					'model'      => $model,
					'messages'   => array( array( 'role' => 'user', 'content' => 'Reply with the single word OK.' ) ),
					'max_tokens' => 16,
					'stream'     => false,
				)
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		wp_send_json_error( array( 'message' => help_ai_error_text( 'network' ) ) );
	}
	$code = (int) wp_remote_retrieve_response_code( $response );
	$data = json_decode( wp_remote_retrieve_body( $response ), true );
	if ( 200 !== $code || ! is_array( $data ) ) {
		wp_send_json_error( array( 'message' => help_ai_error_text( $code ) . ' (' . $code . ')' ) );
	}

	$tokens = isset( $data['usage']['total_tokens'] ) ? (int) $data['usage']['total_tokens'] : 20;
	help_ai_record_usage( $tokens );
	help_ai_note_status( true );

	wp_send_json_success(
		array(
			'message' => sprintf(
				/* translators: 1: model name, 2: token count */
				__( 'It works. xAI answered using %1$s (%2$d tokens used).', 'texas-ip-law-help' ),
				$model,
				$tokens
			),
		)
	);
}
add_action( 'wp_ajax_help_ai_test', 'help_ai_test_ajax' );

/**
 * Save the form.
 */
function help_ai_save_settings() {
	check_admin_referer( 'help_ai_save' );
	if ( ! current_user_can( 'help_manage_ai' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'texas-ip-law-help' ), '', array( 'response' => 403 ) );
	}

	$saved  = help_ai_saved_settings();
	$errors = array();

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- verified above.
	if ( ! defined( 'HELP_AI_ENABLED' ) ) {
		$saved['enabled'] = ! empty( $_POST['enabled'] );
	}

	if ( ! empty( $_POST['remove_key'] ) ) {
		unset( $saved['key'] );
	}
	$key = isset( $_POST['key'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['key'] ) ) ) : '';
	if ( '' !== $key ) {
		if ( preg_match( '/^[A-Za-z0-9_\-]{20,200}$/', $key ) ) {
			$saved['key'] = help_ai_encrypt( $key );
		} else {
			$errors[] = __( 'That does not look like an xAI API key, so the old key was kept.', 'texas-ip-law-help' );
		}
	}

	$model = isset( $_POST['model'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['model'] ) ) ) : '';
	if ( defined( 'HELP_XAI_MODEL' ) ) {
		$model = '';
	} elseif ( preg_match( '/^[A-Za-z0-9._\-:]{2,80}$/', $model ) ) {
		$saved['model'] = $model;
	} else {
		$errors[] = __( 'The model name was not saved because it has characters we do not accept.', 'texas-ip-law-help' );
	}

	foreach ( help_ai_field_limits() as $field => $limits ) {
		if ( ! isset( $_POST[ $field ] ) ) {
			continue;
		}
		$value = (int) $_POST[ $field ];
		if ( $value < $limits[0] || $value > $limits[1] ) {
			/* translators: 1: field label, 2: min, 3: max */
			$errors[] = sprintf( __( '%1$s must be between %2$s and %3$s. It was not changed.', 'texas-ip-law-help' ), help_ai_field_label( $field ), number_format_i18n( $limits[0] ), number_format_i18n( $limits[1] ) );
			continue;
		}
		$saved[ $field ] = $value;
	}

	if ( isset( $saved['daily_cap'], $saved['monthly_cap'] ) && $saved['monthly_cap'] < $saved['daily_cap'] ) {
		$saved['monthly_cap'] = $saved['daily_cap'];
		$errors[]             = __( 'The monthly cap cannot be lower than the daily cap, so it was raised to match.', 'texas-ip-law-help' );
	}

	if ( isset( $_POST['price'] ) && '' !== trim( (string) wp_unslash( $_POST['price'] ) ) ) {
		$price = (float) wp_unslash( $_POST['price'] );
		if ( $price >= 0 && $price <= 1000 ) {
			$saved['price'] = $price;
		}
	} else {
		unset( $saved['price'] );
	}
	// phpcs:enable

	update_option( 'help_ai_settings', $saved, false );
	set_transient(
		'help_ai_notice_' . get_current_user_id(),
		array(
			'ok'     => ! $errors,
			'errors' => $errors,
		),
		60
	);
	wp_safe_redirect( admin_url( 'admin.php?page=help-ai' ) );
	exit;
}
add_action( 'admin_post_help_ai_save', 'help_ai_save_settings' );

/**
 * Label for a number field.
 *
 * @param string $field Field.
 * @return string
 */
function help_ai_field_label( $field ) {
	$labels = array(
		'daily_cap'    => __( 'Daily cap', 'texas-ip-law-help' ),
		'monthly_cap'  => __( 'Monthly cap', 'texas-ip-law-help' ),
		'reply_tokens' => __( 'Longest answer', 'texas-ip-law-help' ),
		'ip_hourly'    => __( 'Questions per visitor per hour', 'texas-ip-law-help' ),
		'ip_daily'     => __( 'Questions per visitor per day', 'texas-ip-law-help' ),
	);
	return isset( $labels[ $field ] ) ? $labels[ $field ] : $field;
}

/**
 * Render the page.
 */
function help_ai_admin_page() {
	if ( ! current_user_can( 'help_manage_ai' ) ) {
		return;
	}

	$config = help_ai_config();
	$notice = get_transient( 'help_ai_notice_' . get_current_user_id() );
	delete_transient( 'help_ai_notice_' . get_current_user_id() );

	$locked = array(
		'key'          => defined( 'HELP_XAI_API_KEY' ),
		'model'        => defined( 'HELP_XAI_MODEL' ),
		'enabled'      => defined( 'HELP_AI_ENABLED' ),
		'daily_cap'    => defined( 'HELP_AI_DAILY_TOKEN_CAP' ),
		'monthly_cap'  => defined( 'HELP_AI_MONTHLY_TOKEN_CAP' ),
		'reply_tokens' => defined( 'HELP_AI_MAX_REPLY_TOKENS' ),
		'ip_hourly'    => defined( 'HELP_AI_IP_HOURLY' ),
		'ip_daily'     => defined( 'HELP_AI_IP_DAILY' ),
	);
	$saved  = help_ai_saved_settings();
	$hint   = help_ai_key_hint();
	$tz     = wp_timezone_string();
	$limits = help_ai_field_limits();
	$boot   = array(
		'ajax'  => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'help_ai_admin' ),
		'stats' => help_ai_stats_payload(),
	);
	?>
	<div class="wrap" id="help-ai-page">
		<h1><?php esc_html_e( 'Help AI', 'texas-ip-law-help' ); ?></h1>

		<?php if ( is_array( $notice ) ) : ?>
			<?php if ( $notice['ok'] ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Saved.', 'texas-ip-law-help' ); ?></p></div>
			<?php else : ?>
				<div class="notice notice-warning is-dismissible"><p><strong><?php esc_html_e( 'Saved, with notes:', 'texas-ip-law-help' ); ?></strong></p>
				<ul style="list-style:disc;margin-left:20px"><?php foreach ( $notice['errors'] as $e ) { echo '<li>' . esc_html( $e ) . '</li>'; } ?></ul></div>
			<?php endif; ?>
		<?php endif; ?>

		<style>
			#help-ai-page .hai-status{display:flex;gap:10px;align-items:center;padding:14px 16px;border-radius:6px;border:1px solid #c3c4c7;background:#fff;font-size:15px;max-width:900px}
			#help-ai-page .hai-dot{width:12px;height:12px;border-radius:50%;background:#999;flex:none}
			#help-ai-page .hai-status.ok .hai-dot{background:#00a32a}
			#help-ai-page .hai-status.warn .hai-dot{background:#dba617}
			#help-ai-page .hai-status.bad .hai-dot{background:#d63638}
			#help-ai-page .hai-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:12px;max-width:900px;margin:14px 0}
			#help-ai-page .hai-card{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:14px 16px}
			#help-ai-page .hai-card h3{margin:0 0 6px;font-size:13px;color:#50575e;font-weight:600}
			#help-ai-page .hai-big{font-size:24px;font-weight:600;line-height:1.2}
			#help-ai-page .hai-sub{color:#50575e;font-size:12px;margin-top:4px}
			#help-ai-page .hai-bar{height:8px;background:#e0e0e0;border-radius:4px;margin-top:8px;overflow:hidden}
			#help-ai-page .hai-bar>span{display:block;height:100%;background:#2271b1;width:0}
			#help-ai-page .hai-bar.hot>span{background:#d63638}
			#help-ai-page table.hai-days{max-width:900px}
			#help-ai-page .hai-form{background:#fff;border:1px solid #c3c4c7;border-radius:6px;padding:8px 18px 18px;max-width:900px;margin-top:18px}
			#help-ai-page .hai-form th{width:260px}
			#help-ai-page .hai-lock{color:#996800;font-size:12px}
			#help-ai-page #hai-test-result{margin-left:10px;font-weight:600}
			#help-ai-page .hai-live{color:#50575e;font-size:12px}
		</style>

		<div id="hai-status" class="hai-status warn"><span class="hai-dot"></span><strong id="hai-status-text">&hellip;</strong></div>

		<div class="hai-grid">
			<div class="hai-card"><h3><?php esc_html_e( 'Tokens used today', 'texas-ip-law-help' ); ?></h3><div class="hai-big" id="hai-day">0</div><div class="hai-sub" id="hai-day-sub"></div><div class="hai-bar" id="hai-day-bar"><span></span></div></div>
			<div class="hai-card"><h3><?php esc_html_e( 'Tokens used this month', 'texas-ip-law-help' ); ?></h3><div class="hai-big" id="hai-month">0</div><div class="hai-sub" id="hai-month-sub"></div><div class="hai-bar" id="hai-month-bar"><span></span></div></div>
			<div class="hai-card"><h3><?php esc_html_e( 'AI answers', 'texas-ip-law-help' ); ?></h3><div class="hai-big" id="hai-calls">0</div><div class="hai-sub" id="hai-calls-sub"></div></div>
			<div class="hai-card"><h3><?php esc_html_e( 'Visitors sent to the knowledge base today', 'texas-ip-law-help' ); ?></h3><div class="hai-big" id="hai-fallbacks">0</div><div class="hai-sub" id="hai-fallbacks-sub"></div></div>
			<div class="hai-card" id="hai-cost-card" hidden><h3><?php esc_html_e( 'Estimated cost', 'texas-ip-law-help' ); ?></h3><div class="hai-big" id="hai-cost">$0</div><div class="hai-sub" id="hai-cost-sub"></div></div>
			<div class="hai-card"><h3><?php esc_html_e( 'Health', 'texas-ip-law-help' ); ?></h3><div id="hai-health" class="hai-sub" style="font-size:13px"></div></div>
		</div>
		<p class="hai-live"><?php esc_html_e( 'This page refreshes by itself every 30 seconds. Questions and answers are never stored, only counts.', 'texas-ip-law-help' ); ?>
			<?php if ( in_array( strtoupper( $tz ), array( 'UTC', '+00:00', 'UTC+0' ), true ) ) : ?>
				<br><strong><?php esc_html_e( 'The counters reset at midnight in the site time zone, which is UTC right now. Set it to Chicago in Settings, General so "today" matches your day.', 'texas-ip-law-help' ); ?></strong>
			<?php else : ?>
				<?php echo esc_html( sprintf( /* translators: %s: time zone */ __( 'Counters reset at midnight %s.', 'texas-ip-law-help' ), $tz ) ); ?>
			<?php endif; ?>
		</p>

		<h2><?php esc_html_e( 'Last 14 days', 'texas-ip-law-help' ); ?></h2>
		<table class="widefat striped hai-days">
			<thead><tr><th><?php esc_html_e( 'Day', 'texas-ip-law-help' ); ?></th><th><?php esc_html_e( 'AI answers', 'texas-ip-law-help' ); ?></th><th><?php esc_html_e( 'Tokens', 'texas-ip-law-help' ); ?></th><th><?php esc_html_e( 'Sent to knowledge base', 'texas-ip-law-help' ); ?></th></tr></thead>
			<tbody id="hai-days"></tbody>
		</table>

		<form class="hai-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" autocomplete="off">
			<input type="hidden" name="action" value="help_ai_save">
			<?php wp_nonce_field( 'help_ai_save' ); ?>
			<h2><?php esc_html_e( 'Settings', 'texas-ip-law-help' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<tr>
					<th scope="row"><?php esc_html_e( 'AI on', 'texas-ip-law-help' ); ?></th>
					<td>
						<label><input type="checkbox" name="enabled" value="1" <?php checked( $config['enabled'] ); disabled( $locked['enabled'] ); ?>> <?php esc_html_e( 'Let visitors talk to the AI. Untick to pause it at once (visitors then get knowledge-base answers).', 'texas-ip-law-help' ); ?></label>
						<?php if ( $locked['enabled'] ) : ?><p class="hai-lock"><?php esc_html_e( 'Locked by wp-config.php.', 'texas-ip-law-help' ); ?></p><?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hai-key"><?php esc_html_e( 'xAI API key', 'texas-ip-law-help' ); ?></label></th>
					<td>
						<?php if ( $locked['key'] ) : ?>
							<p><?php echo esc_html( sprintf( /* translators: %s: last four characters */ __( 'Set in wp-config.php (ends in %s). Change it there.', 'texas-ip-law-help' ), $hint ) ); ?></p>
						<?php else : ?>
							<?php if ( $hint ) : ?><p style="margin-top:0"><?php echo esc_html( sprintf( /* translators: %s: last four characters */ __( 'A key is saved (ends in %s). Leave the box empty to keep it.', 'texas-ip-law-help' ), $hint ) ); ?></p><?php endif; ?>
							<input type="password" id="hai-key" name="key" class="regular-text" placeholder="xai-..." autocomplete="new-password" spellcheck="false">
							<p class="description"><?php esc_html_e( 'Create a key in the xAI console (console.x.ai, API Keys). It is encrypted before it is saved and is never shown again.', 'texas-ip-law-help' ); ?></p>
							<?php if ( $hint ) : ?><label><input type="checkbox" name="remove_key" value="1"> <?php esc_html_e( 'Remove the saved key (back to demo mode)', 'texas-ip-law-help' ); ?></label><?php endif; ?>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="hai-model"><?php esc_html_e( 'Model', 'texas-ip-law-help' ); ?></label></th>
					<td>
						<input type="text" id="hai-model" name="model" class="regular-text" value="<?php echo esc_attr( $config['model'] ); ?>" <?php disabled( $locked['model'] ); ?>>
						<p class="description"><?php esc_html_e( 'Copy the exact model name from the xAI console. Use "Test connection" below to check it.', 'texas-ip-law-help' ); ?></p>
						<?php if ( $locked['model'] ) : ?><p class="hai-lock"><?php esc_html_e( 'Locked by wp-config.php.', 'texas-ip-law-help' ); ?></p><?php endif; ?>
					</td>
				</tr>
				<?php foreach ( $limits as $field => $range ) : ?>
					<tr>
						<th scope="row"><label for="hai-<?php echo esc_attr( $field ); ?>"><?php echo esc_html( help_ai_field_label( $field ) ); ?></label></th>
						<td>
							<input type="number" id="hai-<?php echo esc_attr( $field ); ?>" name="<?php echo esc_attr( $field ); ?>" min="<?php echo (int) $range[0]; ?>" max="<?php echo (int) $range[1]; ?>" step="1" value="<?php echo (int) $config[ $field ]; ?>" <?php disabled( $locked[ $field ] ); ?>>
							<span class="description"><?php echo esc_html( sprintf( /* translators: 1: min 2: max */ __( 'between %1$s and %2$s', 'texas-ip-law-help' ), number_format_i18n( $range[0] ), number_format_i18n( $range[1] ) ) ); ?></span>
							<?php if ( $locked[ $field ] ) : ?><p class="hai-lock"><?php esc_html_e( 'Locked by wp-config.php.', 'texas-ip-law-help' ); ?></p><?php endif; ?>
							<?php if ( 'daily_cap' === $field ) : ?><p class="description"><?php esc_html_e( 'The most tokens the whole site can use in a day. At the cap, visitors get knowledge-base answers.', 'texas-ip-law-help' ); ?></p><?php endif; ?>
							<?php if ( 'monthly_cap' === $field ) : ?><p class="description"><?php esc_html_e( 'The most tokens the whole site can use in a month.', 'texas-ip-law-help' ); ?></p><?php endif; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<th scope="row"><label for="hai-price"><?php esc_html_e( 'Price per 1 million tokens (USD)', 'texas-ip-law-help' ); ?></label></th>
					<td>
						<input type="number" id="hai-price" name="price" min="0" max="1000" step="0.01" value="<?php echo isset( $saved['price'] ) ? esc_attr( (string) $saved['price'] ) : ''; ?>">
						<span class="description"><?php esc_html_e( 'Optional. Enter the price from your xAI console to see an estimated cost above.', 'texas-ip-law-help' ); ?></span>
					</td>
				</tr>
			</tbody></table>
			<p>
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Save settings', 'texas-ip-law-help' ); ?></button>
				<button type="button" class="button" id="hai-test"><?php esc_html_e( 'Test connection', 'texas-ip-law-help' ); ?></button>
				<span id="hai-test-result" role="status"></span>
			</p>
			<p class="description"><?php esc_html_e( 'Test connection uses the key typed above if there is one, otherwise the saved key. A test uses about 20 tokens.', 'texas-ip-law-help' ); ?></p>
		</form>
	</div>

	<script>
	(function () {
		var boot = <?php echo wp_json_encode( $boot ); ?>;
		function $(id) { return document.getElementById(id); }
		function n(v) { return Number(v).toLocaleString(); }
		function ago(ts) {
			if (!ts) { return 'never'; }
			var s = Math.max(0, boot.stats.server_time - ts);
			if (s < 90) { return 'just now'; }
			if (s < 5400) { return Math.round(s / 60) + ' min ago'; }
			if (s < 129600) { return Math.round(s / 3600) + ' hours ago'; }
			return new Date(ts * 1000).toLocaleDateString();
		}
		function bar(id, used, cap) {
			var pct = cap > 0 ? Math.min(100, Math.round(used / cap * 100)) : 0;
			$(id).firstElementChild.style.width = pct + '%';
			$(id).classList.toggle('hot', pct >= 85);
			return pct;
		}
		function render(p) {
			boot.stats = p;
			$('hai-status').className = 'hai-status ' + p.level;
			$('hai-status-text').textContent = p.label;
			$('hai-day').textContent = n(p.day_tokens);
			$('hai-day-sub').textContent = bar('hai-day-bar', p.day_tokens, p.day_cap) + '% of the daily cap (' + n(p.day_cap) + ')';
			$('hai-month').textContent = n(p.month_tokens);
			$('hai-month-sub').textContent = bar('hai-month-bar', p.month_tokens, p.month_cap) + '% of the monthly cap (' + n(p.month_cap) + ')';
			$('hai-calls').textContent = n(p.day_calls);
			$('hai-calls-sub').textContent = 'today. ' + n(p.month_calls) + ' this month.';
			var f = p.fallbacks;
			$('hai-fallbacks').textContent = n(f.cap + f.limit + f.error);
			$('hai-fallbacks-sub').textContent = f.cap + ' hit the cap, ' + f.limit + ' hit a visitor limit, ' + f.error + ' xAI errors';
			if (p.cost_day !== null) {
				$('hai-cost-card').hidden = false;
				$('hai-cost').textContent = '$' + p.cost_month.toFixed(2);
				$('hai-cost-sub').textContent = 'this month. About $' + p.cost_day.toFixed(4) + ' today (estimate).';
			}
			$('hai-health').textContent = 'Last good answer: ' + ago(p.last_ok) + (p.last_problem ? '. Last problem: ' + p.last_problem + ' (' + ago(p.last_error) + ')' : '. No current problems.');
			var tb = $('hai-days');
			while (tb.firstChild) { tb.removeChild(tb.firstChild); }
			p.history.forEach(function (d) {
				var tr = document.createElement('tr');
				[d.date, n(d.calls), n(d.tokens), n(d.visitor)].forEach(function (t) {
					var td = document.createElement('td');
					td.textContent = t;
					tr.appendChild(td);
				});
				tb.appendChild(tr);
			});
		}
		function post(action, extra) {
			var fd = new FormData();
			fd.append('action', action);
			fd.append('nonce', boot.nonce);
			Object.keys(extra || {}).forEach(function (k) { fd.append(k, extra[k]); });
			return fetch(boot.ajax, { method: 'POST', body: fd, credentials: 'same-origin' }).then(function (r) { return r.json(); });
		}
		render(boot.stats);
		setInterval(function () {
			post('help_ai_stats').then(function (j) { if (j && j.success) { render(j.data); } });
		}, 30000);
		$('hai-test').addEventListener('click', function () {
			var out = $('hai-test-result');
			var key = $('hai-key');
			out.style.color = '#50575e';
			out.textContent = 'Testing...';
			post('help_ai_test', { key: key ? key.value : '', model: $('hai-model').value }).then(function (j) {
				var ok = !!(j && j.success);
				out.style.color = ok ? '#00a32a' : '#d63638';
				out.textContent = j && j.data && j.data.message ? j.data.message : (ok ? 'It works.' : 'The test failed.');
				post('help_ai_stats').then(function (s) { if (s && s.success) { render(s.data); } });
			}).catch(function () {
				out.style.color = '#d63638';
				out.textContent = 'Could not run the test.';
			});
		});
	})();
	</script>
	<?php
}
