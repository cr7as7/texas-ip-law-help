<?php
/**
 * Texas IP Law Help — Step 1 intake before AI chat.
 *
 * @package Texas_IP_Law
 */
?>
<div class="ip-law-help-form-block contact-form-block" id="ip-law-help-step-1">
	<p class="ip-law-help-step-badge"><?php esc_html_e( 'Step 1', 'texas-ip-law' ); ?></p>
	<h2 id="ip-law-help-form-heading" class="section-title section-title--left"><?php esc_html_e( 'Your contact information', 'texas-ip-law' ); ?></h2>
	<p class="ip-law-help-form__lead">
		<?php esc_html_e( 'We ask for your name and email so we can follow up if needed. Next, Texas IP Law Help AI will answer your intellectual property question and any follow-ups in the chat below.', 'texas-ip-law' ); ?>
	</p>
	<form class="contact-form ip-law-help-form" id="ip-law-help-form" action="<?php echo esc_url( get_permalink() ); ?>" method="post" novalidate data-ip-law-help-form>
		<p>
			<label for="ip-law-help-name"><?php esc_html_e( 'Name', 'texas-ip-law' ); ?></label>
			<input type="text" id="ip-law-help-name" name="ip_law_help_name" required autocomplete="name">
		</p>
		<p>
			<label for="ip-law-help-email"><?php esc_html_e( 'Email*', 'texas-ip-law' ); ?></label>
			<input type="email" id="ip-law-help-email" name="ip_law_help_email" required autocomplete="email">
			<span class="field-error" role="alert" hidden><?php esc_html_e( 'Please enter a valid email address.', 'texas-ip-law' ); ?></span>
		</p>
		<p>
			<label for="ip-law-help-phone"><?php esc_html_e( 'Phone (optional)', 'texas-ip-law' ); ?></label>
			<input type="tel" id="ip-law-help-phone" name="ip_law_help_phone" autocomplete="tel">
		</p>
		<p class="ip-law-help-form__row--static">
			<label for="ip-law-help-topic"><?php esc_html_e( 'Topic', 'texas-ip-law' ); ?></label>
			<select id="ip-law-help-topic" name="ip_law_help_topic" required>
				<option value=""><?php esc_html_e( 'Select a topic', 'texas-ip-law' ); ?></option>
				<option value="patent"><?php esc_html_e( 'Patents & inventions', 'texas-ip-law' ); ?></option>
				<option value="trademark"><?php esc_html_e( 'Trademarks & branding', 'texas-ip-law' ); ?></option>
				<option value="licensing"><?php esc_html_e( 'Licensing & agreements', 'texas-ip-law' ); ?></option>
				<option value="strategy"><?php esc_html_e( 'IP strategy for my business', 'texas-ip-law' ); ?></option>
				<option value="other"><?php esc_html_e( 'General IP question', 'texas-ip-law' ); ?></option>
			</select>
		</p>
		<p class="ip-law-help-form__row--static">
			<label for="ip-law-help-question"><?php esc_html_e( 'Your first question for the AI', 'texas-ip-law' ); ?></label>
			<textarea id="ip-law-help-question" name="ip_law_help_question" rows="4" required placeholder="<?php esc_attr_e( 'Example: Should I file a provisional patent before my product launch?', 'texas-ip-law' ); ?>"></textarea>
		</p>
		<p><button type="submit" class="btn btn--primary"><?php esc_html_e( 'Start AI help', 'texas-ip-law' ); ?></button></p>
	</form>
</div>
