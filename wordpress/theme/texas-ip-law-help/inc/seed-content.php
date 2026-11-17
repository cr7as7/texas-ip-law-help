<?php
/**
 * Starter articles carried over from the approved mock.
 * Stored in the database on first activation, then edited in WordPress.
 *
 * @package Texas_IP_Law_Help
 */

return array(
	array(
		'slug'       => 'patent-basics',
		'title'      => 'Patent basics for inventors',
		'seo_title'  => 'Patent basics for inventors | Texas IP Law Help',
		'seo_desc'   => 'What Texas inventors should document and understand before filing a U.S. patent application.',
		'excerpt'    => 'What to document before filing with the USPTO.',
		'home_blurb' => 'What to document before you file.',
		'featured'   => true,
		'image'      => 'blog-post-basics.jpg',
		'age_days'   => 0,
		'content'    => <<<'HTMLEOT'
    <p>A patent is a time-limited right to exclude others from making, using, selling, or importing what the claims cover. It is not a permission slip to commercialize, and it is not the same as a trademark or copyright.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">Before you file</h2>
    <ul>
      <li>Write a dated description and sketches of how the invention works — not just that it exists.</li>
      <li>List everyone who contributed to the inventive idea (inventorship is a legal question).</li>
      <li>Note every public disclosure: pitches, demos, papers, Kickstarter, GitHub.</li>
      <li>Read the USPTO <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">patent basics</a> so the forms make sense.</li>
    </ul>
    <p>Then follow the <a href="{{help_url:guides-patent}}">patent guide</a>. If the facts are messy (investors, a looming show, a co-founder), <button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;font:inherit;text-decoration:underline">talk to Texas IP Law Group</button>.</p>
HTMLEOT,
	),
	array(
		'slug'       => 'provisional-vs-non-provisional',
		'title'      => 'Provisional vs. non-provisional',
		'seo_title'  => 'Provisional vs. non-provisional patents | Texas IP Law Help',
		'seo_desc'   => 'How provisional applications relate to a later non-provisional filing, the 12-month clock, and public disclosure.',
		'excerpt'    => 'Investor meetings and public disclosure timing.',
		'home_blurb' => 'Timing before public disclosure.',
		'featured'   => true,
		'image'      => 'blog-post-provisional.jpg',
		'age_days'   => 1,
		'content'    => <<<'HTMLEOT'
    <p>A <strong>provisional</strong> application can establish an early U.S. filing date. It is not examined, does not become a patent by itself, and expires at 12 months unless you file a matching non-provisional that claims its benefit.</p>
    <p>A <strong>non-provisional</strong> (utility) application is examined. Claims get written, the examiner searches, and you may receive office actions.</p>
    <p>Inventors often ask about provisionals before an investor meeting. Timing around <strong>public disclosure</strong> is fact-specific — this article cannot tell you whether your demo last month still leaves a path. Use the <a href="{{help_url:guides-patent}}">patent guide</a> and official <a href="https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application" target="_blank" rel="noopener">USPTO provisional page ↗</a>, then consult if the date is close.</p>
HTMLEOT,
	),
	array(
		'slug'       => 'is-my-idea-patentable',
		'title'      => 'Is my idea patentable?',
		'seo_title'  => 'Is my idea patentable? | Texas IP Law Help',
		'seo_desc'   => 'High-level look at novelty, obviousness, and subject matter — educational only, not an opinion on your invention.',
		'excerpt'    => 'Novelty and obviousness at a high level.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-patentability.jpg',
		'age_days'   => 2,
		'content'    => <<<'HTMLEOT'
    <p>U.S. utility patents generally require patent-eligible subject matter, novelty, and non-obviousness, plus an enabling description. Whether <em>your</em> idea qualifies is a legal and technical judgment — the AI and this article will not declare it patentable.</p>
    <p>At a high level: if the public already has the same invention, or if it would have been obvious to a skilled person in view of what already exists, a patent is unlikely. Abstract ideas, laws of nature, and natural phenomena have extra eligibility issues.</p>
    <p>A prior-art search is a start; an attorney opinion is different. See the <a href="{{help_url:guides-patent}}">patent guide</a> or <a href="{{help_url:ask}}">ask a general question</a>.</p>
HTMLEOT,
	),
	array(
		'slug'       => 'licensing-your-ip',
		'title'      => 'Licensing your IP',
		'seo_title'  => 'Licensing your IP | Texas IP Law Help',
		'seo_desc'   => 'Key licensing terms inventors should recognize before signing — field, territory, exclusive, royalties.',
		'excerpt'    => 'Key deal terms for inventors.',
		'home_blurb' => 'Terms every inventor should know.',
		'featured'   => true,
		'image'      => 'blog-post-licensing.jpg',
		'age_days'   => 3,
		'content'    => <<<'HTMLEOT'
    <p>A license lets someone else use your IP on terms you set. Assignment transfers ownership. Mixing those up in an email to a manufacturer is a common way inventors lose control.</p>
    <p>Terms to recognize: exclusive vs. non-exclusive, field of use, territory, royalties vs. lump sum, improvements, and who enforces against copycats. This is not a contract template.</p>
    <p>If someone sent you a term sheet, that is a <a href="{{help_url:contact}}">consultation</a> moment — not an AI moment.</p>
HTMLEOT,
	),
);
