<?php
/**
 * Starter articles. Stored in the database by help_seed_site(), then edited in WordPress.
 * When the theme ships a newer version of an article the owner has NOT edited, the repair
 * routine refreshes it (see help_seed_create_posts()). Edited articles are never touched.
 *
 * Tokens in content:
 *   {{help_url:key}}        URL from help_url_map() (root-relative when it is on this site)
 *   {{consult:Button text}} a "free consultation" link-style button
 *
 * Educational, general information only. Have the attorney review before launch.
 *
 * @package Texas_IP_Law_Help
 */

return array(

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'patent-basics',
		'title'      => 'Patent basics for inventors',
		'seo_title'  => 'Patent basics for inventors | Texas IP Law Help',
		'seo_desc'   => 'What a U.S. patent is, what it can cover, how long it lasts, and what Texas inventors should document before filing.',
		'excerpt'    => 'What a patent is, what it covers, and what to document before filing with the USPTO.',
		'home_blurb' => 'What to document before you file.',
		'featured'   => true,
		'image'      => 'blog-post-basics.jpg',
		'age_days'   => 0,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>A patent is a time-limited right to stop other people from making, using, selling, or importing what your patent claims cover. It is not a permission slip to sell your product, and it is not the same thing as a trademark or a copyright. If you are still deciding which kind of protection fits, start with the <a href="{{help_url:guides}}">guides overview</a>.</p>

<div class="help-toc"><strong>In this article</strong><ol>
<li><a href="#kinds">The three kinds of U.S. patent</a></li>
<li><a href="#covers">What can be patented</a></li>
<li><a href="#lasts">How long a patent lasts</a></li>
<li><a href="#before">What to document before you file</a></li>
<li><a href="#after">What happens after you file</a></li>
</ol></div>

<h2 id="kinds">The three kinds of U.S. patent</h2>
<ul>
<li><strong>Utility patents</strong> cover how something works or is made: machines, processes, manufactured products, and compositions of matter, plus new and useful improvements of those. This is what most inventors mean by &ldquo;a patent.&rdquo;</li>
<li><strong>Design patents</strong> cover the ornamental look of a useful object, such as the shape of a bottle or the appearance of an icon on a device.</li>
<li><strong>Plant patents</strong> cover certain new varieties of plants that are reproduced without seeds.</li>
</ul>

<h2 id="covers">What can be patented</h2>
<p>For a utility patent the invention generally has to fall in an eligible category, be new, not be an obvious step from what already exists, and be described well enough that a skilled person could make and use it. Laws of nature, natural phenomena, and abstract ideas are not eligible on their own. Software and business methods are a frequent gray area. Our article <a href="{{help_url:a-patentability}}">Is my idea patentable?</a> explains the three big tests in plain language.</p>

<h2 id="lasts">How long a patent lasts</h2>
<p>A U.S. utility patent generally lasts 20 years from the filing date of the earliest non-provisional application it relies on, and the owner has to pay maintenance fees to the USPTO to keep it in force. Design patents run for a shorter, fixed period counted from the grant date. A patent is also <strong>territorial</strong>: a U.S. patent only gives rights in the United States. Protection in other countries needs separate applications, and the timing rules are strict, so ask early if you plan to sell abroad.</p>

<h2 id="before">What to document before you file</h2>
<ul>
<li>Write a dated description and sketches of <em>how</em> the invention works, not just that it exists. Include versions and alternatives you considered.</li>
<li>List everyone who contributed to the inventive idea. Inventorship is a legal question, and naming the wrong people can cause trouble later.</li>
<li>Write down every public disclosure so far: pitches, demos, trade shows, papers, crowdfunding pages, public code repositories, and any offers to sell. See <a href="{{help_url:a-disclosure}}">public disclosure before you file</a>.</li>
<li>Gather what is already out there. The <a href="{{help_url:guides-patent-search}}">patent search guide</a> shows how to use free tools.</li>
<li>Read the USPTO <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">patent basics</a> so the forms make sense.</li>
</ul>

<h2 id="after">What happens after you file</h2>
<p>An examiner at the USPTO reviews a non-provisional application, searches for prior art, and often sends one or more office actions explaining why some claims are not allowed yet. You respond, sometimes several times. Reaching a decision commonly takes more than a year. A <a href="{{help_url:a-provisional}}">provisional application</a> is different: it is never examined and simply holds an early filing date for 12 months.</p>

<div class="help-callout">
<p><strong>Not sure where your facts land?</strong> Investors, a coming trade show, a co-founder, or a deadline can change the best first step. {{consult:Talk to Texas IP Law Group}} before you decide.</p>
</div>

<p class="help-source-links">Official sources: <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">USPTO patent basics ↗</a> · <a href="https://www.uspto.gov/patents/apply" target="_blank" rel="noopener">How to apply ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'provisional-vs-non-provisional',
		'title'      => 'Provisional vs. non-provisional',
		'seo_title'  => 'Provisional vs. non-provisional patents | Texas IP Law Help',
		'seo_desc'   => 'How a provisional patent application differs from a non-provisional one, the 12-month clock, and what a provisional can and cannot do for you.',
		'excerpt'    => 'The 12-month clock, what each filing does, and why timing around public disclosure matters.',
		'home_blurb' => 'Timing before public disclosure.',
		'featured'   => true,
		'image'      => 'blog-post-provisional.jpg',
		'age_days'   => 1,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>Inventors ask this question more than any other: should I file a provisional first? The honest answer is &ldquo;it depends on your facts,&rdquo; but you can understand the tools before you decide. This article explains what each filing is. For a step-by-step walk-through, see the <a href="{{help_url:guides-provisional}}">provisional application guide</a>.</p>

<h2>Provisional application</h2>
<ul>
<li>It <strong>establishes an early filing date</strong> in the United States.</li>
<li>It is <strong>never examined</strong> and <strong>never becomes a patent by itself</strong>.</li>
<li>It <strong>expires after 12 months</strong>. To keep the benefit of that date you must file a non-provisional application (or an eligible international application) within the 12 months and claim the earlier filing.</li>
<li>It does not require formal patent claims, which usually makes it cheaper and faster to prepare than a non-provisional.</li>
</ul>

<h2>Non-provisional (utility) application</h2>
<ul>
<li>It is <strong>examined</strong> by the USPTO. It must include claims, which define what you are asking to protect.</li>
<li>The examiner searches for prior art and often issues office actions, which you answer.</li>
<li>If it is allowed, it can <strong>issue as a patent</strong>.</li>
</ul>

<h2>The catch: a provisional only protects what it describes</h2>
<p>A provisional helps for exactly the subject matter it describes in enough detail. A one-page sketch or a marketing summary may not support the claims you later want. If a provisional is thin, the filing date you thought you had can fall away for the parts it did not cover. That is why careful drafting matters even though no examiner reads it.</p>

<h2>What a provisional does <em>not</em> do</h2>
<ul>
<li>It does not give you an enforceable patent.</li>
<li>It does not stop anyone from copying you while it is pending, although you may use &ldquo;patent pending&rdquo; (see <a href="{{help_url:a-patent-pending}}">what &ldquo;patent pending&rdquo; means</a>).</li>
<li>It does not extend the 12-month deadline. Missing it can end your priority date.</li>
<li>It does not cancel the effect of public disclosures you made <em>before</em> filing. Read <a href="{{help_url:a-disclosure}}">public disclosure before you file</a>.</li>
</ul>

<h2>When people usually consider each</h2>
<div class="help-compare-wrap"><table class="help-compare">
<thead><tr><th scope="col"></th><th scope="col">Provisional</th><th scope="col">Non-provisional</th></tr></thead>
<tbody>
<tr><th scope="row">Examined?</th><td>No</td><td>Yes</td></tr>
<tr><th scope="row">Becomes a patent?</th><td>No, not on its own</td><td>Yes, if allowed</td></tr>
<tr><th scope="row">Claims required?</th><td>No</td><td>Yes</td></tr>
<tr><th scope="row">Lifespan</th><td>12 months</td><td>Until a final decision, then up to about 20 years from filing if issued</td></tr>
<tr><th scope="row">Often used when…</th><td>You want an early date while you refine the product, seek funding, or test the market</td><td>The invention is ready and you want to start examination</td></tr>
</tbody></table></div>

<div class="help-callout">
<p>Investor meeting or demo coming up? Whether a provisional still helps depends on what has already been shown and when. {{consult:Ask the firm about timing}}.</p>
</div>

<p class="help-source-links">Official source: <a href="https://www.uspto.gov/patents/basics/apply/provisional-application" target="_blank" rel="noopener">USPTO provisional application overview ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'is-my-idea-patentable',
		'title'      => 'Is my idea patentable?',
		'seo_title'  => 'Is my idea patentable? | Texas IP Law Help',
		'seo_desc'   => 'A plain-language look at the tests for a U.S. utility patent: eligible subject matter, novelty, non-obviousness, and a clear description.',
		'excerpt'    => 'Eligibility, novelty, and non-obviousness explained at a high level.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-patentability.jpg',
		'age_days'   => 2,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>No article, and no AI chat, can tell you that <em>your</em> idea is or is not patentable. That takes a technical and legal review of your actual invention against what already exists. What this article can do is explain the questions an examiner will ask, so you know what to prepare.</p>

<h2>Test 1: Is it the right kind of thing?</h2>
<p>A U.S. utility patent can cover a process, a machine, a manufactured article, or a composition of matter, and improvements to them. Three categories are generally off limits on their own: laws of nature, natural phenomena, and abstract ideas. Courts have applied that last rule to many software and business-method inventions, so these are often the hardest to assess. A computer-implemented invention is not automatically excluded. How it is described and what technical problem it solves both matter.</p>

<h2>Test 2: Is it new?</h2>
<p>If the same invention was already public before you filed, a patent is unlikely. &ldquo;Public&rdquo; is broad: patents and published applications anywhere in the world, articles, websites, conference talks, products on sale, and sometimes your own earlier disclosures. The U.S. gives inventors a limited grace period for their own disclosures, but many other countries do not (see <a href="{{help_url:a-disclosure}}">public disclosure before you file</a>).</p>

<h2>Test 3: Is it more than an obvious step?</h2>
<p>Even if nothing identical exists, a patent can be refused when the invention would have been obvious to an ordinary person in your field, given what was already known. Examiners often combine two or three earlier references to argue obviousness. Showing an unexpected result or a clear technical advantage can help, but that is exactly where an attorney earns their fee.</p>

<h2>Test 4: Can you describe it well enough?</h2>
<p>The application has to explain the invention so that someone skilled in the field could make and use it, and it has to show that you actually had the invention when you filed. Vague descriptions cause problems later.</p>

<h2>A practical way to start</h2>
<ol>
<li>Write one page describing the problem, your solution, and what is different from what exists today.</li>
<li>Run a first search with free tools. Our <a href="{{help_url:guides-patent-search}}">patent search guide</a> shows how.</li>
<li>List every disclosure and sale so far.</li>
<li>Take those notes to an attorney or registered patent agent for an opinion on your facts.</li>
</ol>

<div class="help-callout">
<p>A search you do yourself is a useful first look, but it cannot prove that nothing similar exists. {{consult:Request a free consultation}} to discuss your invention.</p>
</div>

<p class="help-source-links">Official source: <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">USPTO patent basics ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'licensing-your-ip',
		'title'      => 'Licensing your IP',
		'seo_title'  => 'Licensing your IP: basics for inventors | Texas IP Law Help',
		'seo_desc'   => 'How IP licensing works: exclusive and non-exclusive licenses, field of use, royalties, and the questions to settle before you sign.',
		'excerpt'    => 'Exclusive vs. non-exclusive, field of use, royalties, and what to settle before you sign.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-licensing.jpg',
		'age_days'   => 3,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>A license lets someone else use your patent, trademark, copyright, or know-how under conditions you set, while you keep ownership. Licensing can bring income without building a factory or a sales team. It can also lock you in for years, so the terms matter far more than the headline royalty rate.</p>

<h2>License or assignment?</h2>
<p>A <strong>license</strong> gives permission to use something. An <strong>assignment</strong> transfers ownership. People sometimes use the two words loosely, and a contract that says &ldquo;assign&rdquo; can hand over everything. Read for that word. If someone asks you to sign, find out which one it is before anything else.</p>

<h2>Key terms to understand</h2>
<ul>
<li><strong>Exclusive vs. non-exclusive.</strong> An exclusive license means you promise not to license the same rights to anyone else, and sometimes not to use them yourself. A non-exclusive license lets you license many companies.</li>
<li><strong>Field of use.</strong> You can limit a license to an industry, product type, or use. A medical-device company and a consumer-gadget company might each license the same patent for different fields.</li>
<li><strong>Territory.</strong> The countries or regions covered.</li>
<li><strong>Term and termination.</strong> How long it lasts, and what lets either side end it early (unpaid royalties, missed sales targets, bankruptcy, a breach).</li>
<li><strong>Royalties and fees.</strong> A one-time payment, a percentage of sales, a fixed amount per unit, minimum yearly payments, or a mix. Define clearly what &ldquo;sales&rdquo; means.</li>
<li><strong>Improvements.</strong> Who owns changes either side makes later? This clause is often overlooked and often disputed.</li>
<li><strong>Quality control.</strong> For trademarks especially, the owner generally must control the quality of goods sold under the mark, or the mark can weaken.</li>
</ul>

<h2>Before you talk to a licensee</h2>
<ol>
<li>Know what you own. Is the patent granted, or only filed? See <a href="{{help_url:a-patent-basics}}">patent basics</a>. Have co-inventors or employers any claim?</li>
<li>Protect early conversations with a written non-disclosure agreement where it makes sense, and share only what the other side needs.</li>
<li>Keep your filings in order. A weak or lapsed filing weakens your bargaining position.</li>
<li>Get the terms reviewed by a lawyer before signing. Mistakes here are expensive to fix.</li>
</ol>

<div class="help-callout">
<p>Received a license offer or term sheet? {{consult:Have the firm review it}} before you respond.</p>
</div>

<p class="help-source-links">Official sources: <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">USPTO patent basics ↗</a> · <a href="https://www.copyright.gov/" target="_blank" rel="noopener">U.S. Copyright Office ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'patent-pending-what-it-means',
		'title'      => 'What “patent pending” really means',
		'seo_title'  => 'What “patent pending” means | Texas IP Law Help',
		'seo_desc'   => 'What “patent pending” does and does not protect, when you may use it, and the mistakes inventors make with it.',
		'excerpt'    => 'When you may say it, what it does and does not protect, and common mistakes.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-pending.jpg',
		'age_days'   => 4,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>You see &ldquo;patent pending&rdquo; on products everywhere. It sounds powerful. In reality it is simply a notice that an application has been filed. It protects nothing by itself. Here is what it does and does not mean.</p>

<h2>When may you use it?</h2>
<p>Generally, once a patent application has been filed with the USPTO. A provisional application counts. Before you file anything, you should not use it. Knowingly using a patent notice on a product when it is not true can create legal problems, so use the phrase only when it is accurate. If your application is later abandoned, stop using it.</p>

<h2>What it does</h2>
<ul>
<li>It tells competitors and investors that you are taking steps to protect the product.</li>
<li>It can discourage some copying.</li>
<li>For a regular application, a patent may eventually issue and give you enforceable rights.</li>
</ul>

<h2>What it does not do</h2>
<ul>
<li><strong>No enforcement yet.</strong> You cannot sue someone for infringing a patent that has not been granted. Rights come when the patent issues.</li>
<li><strong>No guarantee a patent will issue.</strong> The application may be narrowed or rejected.</li>
<li><strong>No cover for earlier disclosures.</strong> If you showed the product publicly before filing, that can already hurt your rights. See <a href="{{help_url:a-disclosure}}">public disclosure before you file</a>.</li>
<li><strong>No protection from a competitor&rsquo;s earlier filing.</strong> Someone else may have filed before you.</li>
</ul>

<h2>Common mistakes</h2>
<ol>
<li>Using &ldquo;patent pending&rdquo; before any application exists.</li>
<li>Relying on a thin provisional that does not really describe the product (see <a href="{{help_url:a-provisional}}">provisional vs. non-provisional</a>).</li>
<li>Letting the 12-month provisional clock run out without a follow-up filing.</li>
<li>Assuming &ldquo;patent pending&rdquo; makes it safe to share everything with manufacturers. Use written confidentiality agreements anyway.</li>
</ol>

<div class="help-callout">
<p>Not sure whether you can say it, or whether your filing is strong enough to rely on? {{consult:Ask Texas IP Law Group}}.</p>
</div>

<p class="help-source-links">Official source: <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">USPTO patent basics ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'public-disclosure-before-you-file',
		'title'      => 'Public disclosure before you file a patent',
		'seo_title'  => 'Public disclosure before you file a patent | Texas IP Law Help',
		'seo_desc'   => 'How demos, sales, posts, and pitches can affect your patent rights, the U.S. one-year grace period, and why other countries are stricter.',
		'excerpt'    => 'Demos, posts, sales, and pitches can start clocks. Here is what to know first.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-disclosure.jpg',
		'age_days'   => 5,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>Many inventors lose or weaken patent rights not because their idea was weak, but because they talked about it too early. This article explains the basic rules so you can pause before the next demo, post, or pitch.</p>

<h2>What counts as a public disclosure?</h2>
<ul>
<li>Showing the invention at a trade show, meetup, or demo day.</li>
<li>Posting about it online: your website, social media, a crowdfunding page, a video, or a public code repository.</li>
<li>Publishing a paper, thesis, or conference abstract.</li>
<li>Selling the product or <strong>offering</strong> it for sale, even if you have not delivered any.</li>
<li>Giving it to customers or testers without a confidentiality agreement.</li>
<li>Describing it to investors or manufacturers without a written NDA (the facts here matter a lot).</li>
</ul>

<h2>The U.S. grace period</h2>
<p>In the United States an inventor generally has <strong>one year</strong> after their own public disclosure to file a patent application. That is a safety net, not a plan. Filing sooner usually keeps more options open and avoids arguments about exactly what was disclosed and when.</p>

<h2>Other countries are stricter</h2>
<p>Many countries require &ldquo;absolute novelty,&rdquo; meaning a public disclosure before the filing date can end your chance for a patent there, with no grace period. If you want protection abroad, the safest approach is to file before disclosing. A U.S. <a href="{{help_url:a-provisional}}">provisional application</a> can sometimes support later foreign filings, but only within the strict deadlines.</p>

<h2>Disclosure checklist</h2>
<ol>
<li>Write down every disclosure so far: what was shown, to whom, on what date, and whether there was an NDA.</li>
<li>Write down any sales or offers, including quotes and pre-orders.</li>
<li>Pause new public sharing until you know your plan.</li>
<li>Use written confidentiality agreements for investors, manufacturers, and testers.</li>
<li>Talk to an attorney about dates that are close to a deadline.</li>
</ol>

<div class="help-callout">
<p><strong>Already disclosed something?</strong> Do not panic, and do not guess about the deadline. {{consult:Talk to Texas IP Law Group}} with your dates.</p>
</div>

<p>Related: <a href="{{help_url:guides-patent}}">How to file a patent</a> · <a href="{{help_url:a-patent-basics}}">Patent basics</a></p>
<p class="help-source-links">Official source: <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">USPTO patent basics ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'trademark-clearance-before-you-launch',
		'title'      => 'Trademark clearance before you launch a brand',
		'seo_title'  => 'Trademark clearance before you launch a brand | Texas IP Law Help',
		'seo_desc'   => 'Why to search before you commit to a name or logo, how to check the USPTO database, and what “likelihood of confusion” means.',
		'excerpt'    => 'Check a name before you print the boxes. A short search can save a rebrand.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-clearance.jpg',
		'age_days'   => 6,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>A brand name is one of the most expensive things to change after launch. Signs, packaging, domain names, and customer memory all follow the name. A short search <em>before</em> you commit can prevent a forced rebrand or a demand letter. This article gives the overview. For the step-by-step process, use the <a href="{{help_url:guides-trademark-search}}">trademark search guide</a>.</p>

<h2>What a trademark protects</h2>
<p>A trademark protects a word, name, logo, slogan, or other marker that tells customers who is behind goods or services. Rights in the United States come from <strong>using</strong> the mark in business. Registering with the USPTO adds important advantages, such as nationwide priority and a public record of ownership. The <a href="{{help_url:guides-trademark}}">trademark guide</a> explains the filing path.</p>

<h2>The test: likelihood of confusion</h2>
<p>The core question is whether your mark is so similar to someone else&rsquo;s, for related goods or services, that customers would likely be confused about who is behind them. Examiners and courts look at how the marks <strong>look, sound, and mean</strong>, how closely the goods or services relate, and who the customers are. Marks do not have to be identical. A similar-sounding name in a related field can still be a problem.</p>

<h2>Stronger and weaker names</h2>
<ul>
<li><strong>Fanciful or invented</strong> (a made-up word) and <strong>arbitrary</strong> (a real word unrelated to the product): generally the strongest.</li>
<li><strong>Suggestive</strong>: hints at a quality without describing it directly.</li>
<li><strong>Descriptive</strong>: describes the product itself. Often hard to register without proof customers recognize it as a brand.</li>
<li><strong>Generic</strong>: the common name of the product. Cannot be a trademark.</li>
</ul>

<h2>A first clearance check</h2>
<ol>
<li>Search the USPTO trademark database for your exact name and for variations, including spelling, sound, and meaning.</li>
<li>Look at the <strong>goods and services</strong> of anything similar, not only the name.</li>
<li>Search the web, app stores, social media, and state records for businesses using the name without a federal registration. Those unregistered users can still have rights.</li>
<li>Check the domain name and social handles.</li>
<li>Keep dated notes of what you found.</li>
</ol>

<div class="help-callout">
<p>A DIY search is a good first filter, but a missed conflict can be costly. For a name you are about to spend real money on, {{consult:ask the firm for a clearance review}}.</p>
</div>

<p class="help-source-links">Official sources: <a href="https://www.uspto.gov/trademarks/search" target="_blank" rel="noopener">USPTO trademark search ↗</a> · <a href="https://www.uspto.gov/trademarks" target="_blank" rel="noopener">USPTO trademarks ↗</a></p>
HTMLEOT,
	),

	// ---------------------------------------------------------------------------------------
	array(
		'slug'       => 'copyright-basics-for-creators-and-software',
		'title'      => 'Copyright basics for creators and software',
		'seo_title'  => 'Copyright basics for creators and software | Texas IP Law Help',
		'seo_desc'   => 'What copyright protects, when it starts, why registration still matters, and how it applies to writing, art, music, and code.',
		'excerpt'    => 'What copyright covers, when it starts, and why registering still helps.',
		'home_blurb' => '',
		'featured'   => false,
		'image'      => 'blog-post-copyright.jpg',
		'age_days'   => 7,
		'content'    => <<<'HTMLEOT'
<p class="help-updated">Last reviewed November 2026 · General information, not legal advice.</p>
<p>Copyright protects original creative expression: writing, art, photographs, music, film, and software code. It does <strong>not</strong> protect ideas, facts, methods, or names. Those belong to other areas of IP. If you are unsure which applies, start with the <a href="{{help_url:guides}}">guides overview</a>.</p>

<h2>When does copyright start?</h2>
<p>Automatically. Copyright exists as soon as an original work is fixed in a tangible form, such as written down, recorded, saved to a file, or drawn. You do not have to register or add a notice for the work to be protected.</p>

<h2>Why register anyway?</h2>
<ul>
<li>For works of U.S. origin, you generally must register (or have a pending application decided) <strong>before you can file an infringement lawsuit</strong> in federal court.</li>
<li>Registering early, or within a short window after publication, can make you eligible for statutory damages and attorney&rsquo;s fees, which matter when actual losses are hard to prove.</li>
<li>A registration is a public record of your claim.</li>
</ul>
<p>Registration is handled by the U.S. Copyright Office, not the USPTO. The <a href="{{help_url:guides-copyright}}">copyright guide</a> walks through the path.</p>

<h2>Who owns the copyright?</h2>
<p>Usually the person who created the work. Two big exceptions: a <strong>work made for hire</strong> (for example, created by an employee as part of the job) is owned by the employer, and a creator can sign away or license rights by contract. If you hired a freelancer or contractor, do not assume you own what they made. Get a written agreement.</p>

<h2>What about software?</h2>
<p>Source code and object code are protected as written works. That covers the code itself, not the underlying idea or function. Open-source licenses are copyright licenses, so check the terms of any code you reuse. How the software works may be protectable in other ways, for example by patent in some cases or as a trade secret. See <a href="{{help_url:a-patentability}}">Is my idea patentable?</a></p>

<h2>Common questions</h2>
<ul>
<li><strong>&ldquo;Poor man&rsquo;s copyright&rdquo; (mailing it to yourself).</strong> It does not replace registration.</li>
<li><strong>Fair use.</strong> A limited defense that depends on the facts. It is not a safe harbor for copying &ldquo;a little.&rdquo;</li>
<li><strong>How long does it last?</strong> For most works by an individual, the author&rsquo;s life plus 70 years. Works made for hire and anonymous works follow different rules.</li>
</ul>

<div class="help-callout">
<p>Someone copying your work, or a client asking who owns it? {{consult:Request a free consultation}}.</p>
</div>

<p class="help-source-links">Official sources: <a href="https://www.copyright.gov/registration/" target="_blank" rel="noopener">Copyright Office registration ↗</a> · <a href="https://www.copyright.gov/" target="_blank" rel="noopener">copyright.gov ↗</a></p>
HTMLEOT,
	),
);
