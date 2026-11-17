<?php
/**
 * Texas IP Law Help — intake then AI Q&A chat (design mock).
 *
 * @package Texas_IP_Law
 */

get_header();

$banner_candidates = array(
	'ip-law-help-office-lobby.png',
	'blog-banner-live.jpg',
);
$banner_image      = '';
foreach ( $banner_candidates as $banner_file ) {
	$banner_path = get_template_directory() . '/assets/images/' . $banner_file;
	if ( file_exists( $banner_path ) ) {
		$banner_image = get_template_directory_uri() . '/assets/images/' . $banner_file;
		break;
	}
}
$has_banner = (bool) $banner_image;

$default_intro = '<p>' . esc_html__(
	'Ask intellectual property questions in your own words. Our AI assistant explains patents, trademarks, licensing, and strategy in plain language — then connect with Texas IP Law Group when you need personal legal advice.',
	'texas-ip-law'
) . '</p>';

$sample_video = content_url( 'uploads/2026/09/sample-video.mp4' );
$has_sample   = file_exists( WP_CONTENT_DIR . '/uploads/2026/09/sample-video.mp4' );
?>
<div class="page-ip-law-help">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<section class="ip-law-help-banner"<?php echo $has_banner ? ' style="background-image:url(' . esc_url( $banner_image ) . ');"' : ''; ?> aria-labelledby="ip-law-help-title">
			<div class="ip-law-help-banner__overlay">
				<div class="container--inset ip-law-help-banner__inner">
					<h1 id="ip-law-help-title" class="entry__title ip-law-help-banner__title"><?php the_title(); ?></h1>
					<div class="ip-law-help-banner__intro entry__content">
						<?php
						$content = get_the_content();
						if ( trim( wp_strip_all_tags( $content ) ) ) {
							the_content();
						} else {
							echo $default_intro; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
						}
						?>
					</div>
					<ul class="ip-law-help-banner__steps">
						<li><?php esc_html_e( 'Step 1 — Contact info + your question', 'texas-ip-law' ); ?></li>
						<li><?php esc_html_e( 'Step 2 — AI answers & follow-up chat', 'texas-ip-law' ); ?></li>
						<li><?php esc_html_e( 'Step 3 — Free consultation with an attorney', 'texas-ip-law' ); ?></li>
					</ul>
				</div>
			</div>
		</section>
		<?php
	endwhile;
	?>

	<section class="ip-law-help-flow-guide section" aria-labelledby="ip-law-help-flow-guide-heading">
		<div class="container--inset">
			<h2 id="ip-law-help-flow-guide-heading" class="section-title"><?php esc_html_e( 'How it works', 'texas-ip-law' ); ?></h2>
			<ol class="ip-law-help-flow-guide__list">
				<li class="ip-law-help-flow-guide__item">
					<span class="ip-law-help-flow-guide__num" aria-hidden="true">1</span>
					<h3 class="ip-law-help-flow-guide__title"><?php esc_html_e( 'You arrive', 'texas-ip-law' ); ?></h3>
					<p><?php esc_html_e( 'Open Texas IP Law Help from the menu to ask an IP question.', 'texas-ip-law' ); ?></p>
				</li>
				<li class="ip-law-help-flow-guide__item">
					<span class="ip-law-help-flow-guide__num" aria-hidden="true">2</span>
					<h3 class="ip-law-help-flow-guide__title"><?php esc_html_e( 'You tell us who you are', 'texas-ip-law' ); ?></h3>
					<p><?php esc_html_e( 'Name, email, topic, and your first question (Step 1 on the left).', 'texas-ip-law' ); ?></p>
				</li>
				<li class="ip-law-help-flow-guide__item">
					<span class="ip-law-help-flow-guide__num" aria-hidden="true">3</span>
					<h3 class="ip-law-help-flow-guide__title"><?php esc_html_e( 'AI answers', 'texas-ip-law' ); ?></h3>
					<p><?php esc_html_e( 'Texas IP Law Help AI replies in the chat with plain-language education.', 'texas-ip-law' ); ?></p>
				</li>
				<li class="ip-law-help-flow-guide__item">
					<span class="ip-law-help-flow-guide__num" aria-hidden="true">4</span>
					<h3 class="ip-law-help-flow-guide__title"><?php esc_html_e( 'You ask follow-ups', 'texas-ip-law' ); ?></h3>
					<p><?php esc_html_e( 'Keep chatting in the same thread — patents, trademarks, timing, costs.', 'texas-ip-law' ); ?></p>
				</li>
				<li class="ip-law-help-flow-guide__item">
					<span class="ip-law-help-flow-guide__num" aria-hidden="true">5</span>
					<h3 class="ip-law-help-flow-guide__title"><?php esc_html_e( 'Free consultation', 'texas-ip-law' ); ?></h3>
					<p><?php esc_html_e( 'When you need advice for your situation, schedule time with our attorneys.', 'texas-ip-law' ); ?></p>
				</li>
			</ol>
			<p class="ip-law-help-flow-guide__ref">
				<?php
				printf(
					/* translators: %s: reference site URL */
					esc_html__( 'Inspired by the help experience at %s — redesigned for Texas IP Law Group.', 'texas-ip-law' ),
					'texasiplaw.org'
				);
				?>
			</p>
		</div>
	</section>

	<div class="ip-law-help-main section">
		<div class="container--inset ip-law-help-layout">
			<div class="ip-law-help-layout__intake">
				<?php get_template_part( 'template-parts/ip-law-help', 'form' ); ?>
			</div>
			<div class="ip-law-help-layout__chat" id="ip-law-help-step-2">
				<p class="ip-law-help-step-badge ip-law-help-step-badge--chat"><?php esc_html_e( 'Step 2', 'texas-ip-law' ); ?></p>
				<?php get_template_part( 'template-parts/ip-law-help', 'chat' ); ?>
			</div>
		</div>
	</div>

	<section class="section ip-law-help-weekly" aria-labelledby="ip-law-help-weekly-heading">
		<div class="container--inset">
			<h2 id="ip-law-help-weekly-heading" class="section-title"><?php esc_html_e( 'Video updates from our team', 'texas-ip-law' ); ?></h2>
			<p class="ip-law-help-weekly__lead"><?php esc_html_e( 'Like texasiplaw.org-style help content — short explainers alongside the AI chat.', 'texas-ip-law' ); ?></p>
			<?php if ( $has_sample ) : ?>
				<div class="ip-law-help-update__video-wrap">
					<video class="ip-law-help-update__video" controls preload="metadata" poster="<?php echo esc_url( $banner_image ); ?>">
						<source src="<?php echo esc_url( $sample_video ); ?>" type="video/mp4">
					</video>
				</div>
				<div class="ip-law-help-update__meta">
					<h3 class="ip-law-help-update__title"><?php esc_html_e( 'Welcome to Texas IP Law Help', 'texas-ip-law' ); ?></h3>
					<p class="ip-law-help-update__date"><?php echo esc_html( gmdate( 'F j, Y' ) ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<section class="section section--tint ip-law-help-cta-band" aria-labelledby="ip-law-help-cta-heading">
		<div class="container--inset ip-law-help-cta-band__inner">
			<h2 id="ip-law-help-cta-heading" class="section-title"><?php esc_html_e( 'Need advice for your specific situation?', 'texas-ip-law' ); ?></h2>
			<p><?php esc_html_e( 'The AI cannot replace an attorney. When you are ready, schedule a free consultation with Texas IP Law Group.', 'texas-ip-law' ); ?></p>
			<a class="btn btn--primary" href="<?php echo esc_url( home_url( '/free-consultation/' ) ); ?>"><?php esc_html_e( 'Free consultation', 'texas-ip-law' ); ?></a>
		</div>
	</section>
</div>
<?php
get_footer();
