<?php
/**
 * Page body: faq (also prints FAQPage structured data from the same list).
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

$help_ext = static function ( $url, $label ) {
	return '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html( $label ) . '</a>';
};
$help_int = static function ( $key, $label ) {
	return '<a href="' . esc_url( help_url( $key ) ) . '">' . esc_html( $label ) . '</a>';
};

$help_faqs = array(
	array(
		'Is this the USPTO?',
		'No. Texas IP Law Help is an educational site by Texas IP Law Group. Filing happens on ' . $help_ext( 'https://www.uspto.gov/', 'uspto.gov' ) . ' or ' . $help_ext( 'https://www.copyright.gov/', 'copyright.gov' ) . '.',
	),
	array(
		'Patent, trademark, or copyright — which one?',
		'Invention / how it works → ' . $help_int( 'guides-patent', 'patent' ) . '. Name or logo you sell under → ' . $help_int( 'guides-trademark', 'trademark' ) . '. Writing, art, music, code as expression → ' . $help_int( 'guides-copyright', 'copyright' ) . '. Many businesses need more than one. The ' . $help_int( 'guides', 'guides overview' ) . ' has a side-by-side comparison.',
	),
	array(
		'Can I file myself?',
		'The USPTO allows it. Forms, fees, and claims are easy to get wrong. Use our guides to reach the official pages; use a consultation if the invention, a deadline, or investors are in the mix.',
	),
	array(
		'Does the AI give legal advice?',
		'No. It explains general concepts and links to guides and USPTO pages. See the ' . $help_int( 'disclaimer', 'disclaimer' ) . '.',
	),
	array(
		'I cannot afford a lawyer. What then?',
		'See ' . $help_int( 'resources', 'official resources' ) . ' for the Inventors Assistance Center and TALA Patent Pro Bono (income limits, waitlist). We do not operate those programs.',
	),
	array(
		'How do I hire Texas IP Law Group?',
		$help_int( 'contact', 'Contact' ) . ' or use Free consultation. The firm site is ' . $help_ext( 'https://texasiplawgroup.com/', 'texasiplawgroup.com' ) . '.',
	),
	array(
		'What is a provisional patent application?',
		'A lower-cost first filing that can establish an early U.S. filing date. It is not examined and does not become a patent on its own. You have 12 months to follow up with a non-provisional application. See the ' . $help_int( 'guides-provisional', 'provisional guide' ) . '.',
	),
	array(
		'How long does a patent last?',
		'A U.S. utility patent generally lasts 20 years from the filing date of the earliest non-provisional application it relies on, if maintenance fees are paid. Design patents follow a different rule. Read ' . $help_int( 'a-patent-basics', 'patent basics' ) . '.',
	),
	array(
		'How long does it take to get a patent?',
		'It varies by technology and workload, but a decision commonly takes more than a year after a non-provisional application is filed. The USPTO publishes current processing times on its site.',
	),
	array(
		'How much does a patent cost?',
		'It depends on the invention. You pay USPTO fees, which are lower for small and micro entities, plus attorney or agent fees if you hire help. Complex inventions and office actions cost more. See the ' . $help_ext( 'https://www.uspto.gov/learning-and-resources/fees-and-payment/uspto-fee-schedule', 'USPTO fee schedule' ) . ' and ask any attorney for a written quote before you start.',
	),
	array(
		'Can I show my invention before I file?',
		'Be careful. Public demos, posts, sales, and offers can start deadlines and may harm your rights, especially outside the United States. Read ' . $help_int( 'a-disclosure', 'public disclosure before you file' ) . ' and talk to an attorney if you already shared it.',
	),
	array(
		'What does “patent pending” mean?',
		'It means a patent application has been filed. It does not mean you have a patent, and it does not let you sue anyone yet. See ' . $help_int( 'a-patent-pending', 'what “patent pending” means' ) . '.',
	),
	array(
		'Does a U.S. patent protect me in other countries?',
		'No. Patents are territorial. Protection abroad needs separate applications, and strict deadlines apply. Ask early if you plan to sell outside the United States.',
	),
	array(
		'How do I check whether a business name is already taken?',
		'Search the USPTO trademark database, the web, social media, and state business records, and look at similar names in related fields. Follow our ' . $help_int( 'guides-trademark-search', 'trademark search guide' ) . '. A business or domain registration does not by itself give you trademark rights.',
	),
	array(
		'Do I have to register a copyright?',
		'Copyright exists automatically when you create and fix an original work. Registration is optional but is generally required before you can sue for infringement of a U.S. work, and early registration can help with damages. See ' . $help_int( 'a-copyright-basics', 'copyright basics' ) . '.',
	),
	array(
		'Who can represent me at the USPTO?',
		'An individual inventor can file and handle their own application. Representing others in patent matters generally requires a registered patent attorney or agent. Confirm the current rules on the USPTO website.',
	),
	array(
		'Does this site save my questions?',
		'The Ask AI chat does not save your questions or the answers. The consultation form emails your message to Texas IP Law Group. See the ' . $help_int( 'privacy', 'privacy notice' ) . '.',
	),
);

$help_faq_ld = array(
	'@context'   => 'https://schema.org',
	'@type'      => 'FAQPage',
	'mainEntity' => array(),
);
foreach ( $help_faqs as $help_faq ) {
	$help_faq_ld['mainEntity'][] = array(
		'@type'          => 'Question',
		'name'           => $help_faq[0],
		'acceptedAnswer' => array(
			'@type' => 'Answer',
			'text'  => html_entity_decode( wp_strip_all_tags( $help_faq[1] ), ENT_QUOTES, 'UTF-8' ),
		),
	);
}
?>
  <main class="mock-guide-page" id="main">
    <p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · FAQ</p>
    <h1>Frequently asked questions</h1>
    <p>Short answers. Guides and official sites have the steps. None of this is legal advice for your facts.</p>
    <div class="help-faq">
<?php foreach ( $help_faqs as $help_i => $help_faq ) : ?>
      <details<?php echo 0 === $help_i ? ' open' : ''; ?>>
        <summary><?php echo esc_html( $help_faq[0] ); ?></summary>
        <p><?php echo wp_kses( $help_faq[1], array( 'a' => array( 'href' => true, 'target' => true, 'rel' => true ) ) ); ?></p>
      </details>
<?php endforeach; ?>
    </div>
    <p style="margin-top:28px">Still stuck? <a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask the AI</a> a general question, or <button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;font:inherit;text-decoration:underline">request a free consultation</button>.</p>
    <script type="application/ld+json"><?php echo wp_json_encode( $help_faq_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP ); // phpcs:ignore WordPress.Security.EscapeOutput ?></script>
  </main>
