<?php
/**
 * Texas IP Law Help — AI chat UI (design mock; live LLM after approval).
 *
 * @package Texas_IP_Law
 */

$avatar_url = get_template_directory_uri() . '/assets/images/susan-avatar-cartoon.png';
$has_avatar = file_exists( get_template_directory() . '/assets/images/susan-avatar-cartoon.png' );
?>
<section class="ip-law-help-chat" id="ip-law-help-chat" aria-labelledby="ip-law-help-chat-heading" data-ip-law-help-chat>
	<div class="ip-law-help-chat__header">
		<?php if ( $has_avatar ) : ?>
			<img class="ip-law-help-chat__avatar" src="<?php echo esc_url( $avatar_url ); ?>" alt="" width="48" height="48" loading="lazy">
		<?php endif; ?>
		<div class="ip-law-help-chat__header-text">
			<h2 id="ip-law-help-chat-heading" class="ip-law-help-chat__title"><?php esc_html_e( 'Texas IP Law Help AI', 'texas-ip-law' ); ?></h2>
			<p class="ip-law-help-chat__status">
				<span class="ip-law-help-chat__status-dot" aria-hidden="true"></span>
				<?php esc_html_e( 'Answers your IP questions in plain language (education only)', 'texas-ip-law' ); ?>
			</p>
		</div>
	</div>

	<p class="ip-law-help-chat__demo-label" data-ip-law-help-demo-label>
		<?php esc_html_e( 'Example below — after you complete Step 1, the AI will answer your question and you can ask follow-ups.', 'texas-ip-law' ); ?>
	</p>

	<div class="ip-law-help-chat__messages" data-ip-law-help-messages role="log" aria-live="polite" aria-relevant="additions">
		<div class="ip-law-help-chat__bubble ip-law-help-chat__bubble--user" data-ip-law-help-demo="1">
			<p class="ip-law-help-chat__bubble-label"><?php esc_html_e( 'You', 'texas-ip-law' ); ?></p>
			<p><?php esc_html_e( 'I have a new medical device idea. Should I file a provisional patent before talking to investors?', 'texas-ip-law' ); ?></p>
		</div>
		<div class="ip-law-help-chat__bubble ip-law-help-chat__bubble--ai" data-ip-law-help-demo="1">
			<p class="ip-law-help-chat__bubble-label"><?php esc_html_e( 'Texas IP Law Help AI', 'texas-ip-law' ); ?></p>
			<div class="ip-law-help-chat__bubble-body">
				<p><?php esc_html_e( 'Many inventors in your position consider a provisional patent application to establish an early filing date while they refine the device and prepare for fundraising. A provisional is typically lower cost than a non-provisional and gives you up to 12 months to file the full application.', 'texas-ip-law' ); ?></p>
				<p><?php esc_html_e( 'Before any pitch, avoid disclosing enabling details without a plan — NDAs help but do not replace patent strategy. This is general information, not legal advice for your specific device.', 'texas-ip-law' ); ?></p>
			</div>
		</div>
		<div class="ip-law-help-chat__bubble ip-law-help-chat__bubble--user" data-ip-law-help-demo="1">
			<p class="ip-law-help-chat__bubble-label"><?php esc_html_e( 'You', 'texas-ip-law' ); ?></p>
			<p><?php esc_html_e( 'What happens if I publicly demo the prototype at a trade show?', 'texas-ip-law' ); ?></p>
		</div>
		<div class="ip-law-help-chat__bubble ip-law-help-chat__bubble--ai" data-ip-law-help-demo="1">
			<p class="ip-law-help-chat__bubble-label"><?php esc_html_e( 'Texas IP Law Help AI', 'texas-ip-law' ); ?></p>
			<div class="ip-law-help-chat__bubble-body">
				<p><?php esc_html_e( 'Public disclosure can start a clock in many countries — in the U.S., you generally have a limited grace period after your own disclosure, but relying on grace periods is risky if you plan international protection.', 'texas-ip-law' ); ?></p>
				<p><?php esc_html_e( 'If a trade show is soon, speak with a patent attorney about filing timing, what to show versus keep confidential, and whether a provisional should be filed first.', 'texas-ip-law' ); ?></p>
			</div>
		</div>
	</div>

	<div class="ip-law-help-chat__typing" data-ip-law-help-typing hidden aria-hidden="true">
		<span class="ip-law-help-chat__typing-dots" aria-hidden="true"></span>
		<?php esc_html_e( 'Texas IP Law Help AI is typing…', 'texas-ip-law' ); ?>
	</div>

	<form class="ip-law-help-chat__composer" data-ip-law-help-chat-form novalidate>
		<label class="screen-reader-text" for="ip-law-help-chat-input"><?php esc_html_e( 'Ask a follow-up question', 'texas-ip-law' ); ?></label>
		<textarea
			id="ip-law-help-chat-input"
			data-ip-law-help-chat-input
			rows="2"
			placeholder="<?php esc_attr_e( 'Complete Step 1 above, then ask your question or a follow-up here…', 'texas-ip-law' ); ?>"
			disabled
		></textarea>
		<button type="submit" class="btn btn--primary ip-law-help-chat__send" data-ip-law-help-chat-send disabled>
			<?php esc_html_e( 'Send', 'texas-ip-law' ); ?>
		</button>
	</form>

	<p class="ip-law-help-chat__disclaimer">
		<?php esc_html_e( 'AI responses are for general education only and are not legal advice. No attorney–client relationship is formed by using this chat.', 'texas-ip-law' ); ?>
		<a href="<?php echo esc_url( home_url( '/free-consultation/' ) ); ?>"><?php esc_html_e( 'Schedule a free consultation', 'texas-ip-law' ); ?></a>
	</p>
</section>
