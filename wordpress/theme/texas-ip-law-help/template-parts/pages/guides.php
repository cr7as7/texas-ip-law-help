<?php
/**
 * Page body: guides
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
  <main class="mock-content-page help-longform" id="main">
    <p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · Guides</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Guides</h1>
    <p style="color:var(--muted);max-width:640px">Each guide is a path: is this the right IP type, what you can do yourself, when to stop and talk to us, then the official government next click.</p>

    <h2>Start with the type of protection</h2>
    <div class="mock-guides__grid" style="margin-top:20px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
      <article class="mock-guide-card">
        <h3>Filing a patent</h3>
        <p>Protect a new machine, process, composition, or useful improvement.</p>
        <a href="<?php echo esc_url( help_url( 'guides-patent' ) ); ?>">Open patent guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Filing a trademark</h3>
        <p>Protect a name, logo, or slogan you use to sell goods or services.</p>
        <a href="<?php echo esc_url( help_url( 'guides-trademark' ) ); ?>">Open trademark guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Filing a copyright</h3>
        <p>Protect original writing, art, music, software, or other works of authorship.</p>
        <a href="<?php echo esc_url( help_url( 'guides-copyright' ) ); ?>">Open copyright guide →</a>
      </article>
    </div>

    <h2>Then the next step</h2>
    <div class="mock-guides__grid" style="margin-top:20px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
      <article class="mock-guide-card">
        <h3>Provisional patent application</h3>
        <p>An early filing date with a 12-month clock. What it does, what it needs, and its limits.</p>
        <a href="<?php echo esc_url( help_url( 'guides-provisional' ) ); ?>">Open provisional guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Search for existing patents</h3>
        <p>Use free tools to look for prior art before you spend money on a filing.</p>
        <a href="<?php echo esc_url( help_url( 'guides-patent-search' ) ); ?>">Open patent search guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Search for a trademark</h3>
        <p>Check a name or logo for conflicts before you print, launch, or file.</p>
        <a href="<?php echo esc_url( help_url( 'guides-trademark-search' ) ); ?>">Open trademark search guide →</a>
      </article>
    </div>

    <h2>Patent, trademark, or copyright?</h2>
    <p>People often mix these up. They protect different things, and many businesses use more than one. This is a general comparison, not advice about your facts.</p>
    <div class="help-compare-wrap"><table class="help-compare">
      <thead><tr><th scope="col"></th><th scope="col">Patent</th><th scope="col">Trademark</th><th scope="col">Copyright</th></tr></thead>
      <tbody>
        <tr><th scope="row">Protects</th><td>How an invention works or is made</td><td>A name, logo, or slogan that identifies who sells something</td><td>Original creative expression (writing, art, music, code)</td></tr>
        <tr><th scope="row">Does <em>not</em> protect</th><td>Mere ideas, laws of nature, abstract ideas</td><td>The product itself, or a generic word for it</td><td>Ideas, facts, methods, or names</td></tr>
        <tr><th scope="row">How you get it</th><td>Apply to the USPTO and pass examination</td><td>Rights start with use; you can also register with the USPTO</td><td>Automatic when the work is created; registration is optional but valuable</td></tr>
        <tr><th scope="row">Where to file</th><td>USPTO</td><td>USPTO (and optionally the state)</td><td>U.S. Copyright Office</td></tr>
        <tr><th scope="row">How long</th><td>Generally 20 years from filing for a utility patent</td><td>Can last as long as you keep using it and keep filing renewals</td><td>Usually the author&rsquo;s life plus 70 years (other rules for work made for hire)</td></tr>
      </tbody>
    </table></div>

    <h2>A sensible order of operations</h2>
    <ol class="mock-guide-steps">
      <li><strong>Decide what you are protecting.</strong> An invention, a brand, a creative work, or a mix of these.</li>
      <li><strong>Stop public sharing</strong> until you know your plan. Demos, posts, and pitches can start deadlines. See <a href="<?php echo esc_url( help_url( 'a-disclosure' ) ); ?>">public disclosure before you file</a>.</li>
      <li><strong>Search first.</strong> Look for existing patents or conflicting names before you spend money.</li>
      <li><strong>Pick the filing.</strong> For patents that may be a provisional or a non-provisional. For brands, a federal trademark application.</li>
      <li><strong>Calendar every deadline</strong> and plan who will watch it.</li>
    </ol>

    <h2>Mistakes inventors make</h2>
    <ul>
      <li>Talking about the invention publicly or selling it before filing.</li>
      <li>Treating a provisional application as if it were a patent.</li>
      <li>Choosing a business name before checking whether it is already used.</li>
      <li>Assuming that registering a company name or domain also protects the brand.</li>
      <li>Hiring a freelancer or developer without a written agreement about who owns the work.</li>
    </ul>

    <div class="help-cta-band">
      <h2>Want a person to look at your facts?</h2>
      <p>The guides explain the general path. Texas IP Law Group can tell you what applies to your invention or brand.</p>
      <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button>
    </div>

    <p style="margin-top:28px">Related: <a href="<?php echo esc_url( help_url( 'resources' ) ); ?>">Official resources</a> · <a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">Articles</a> · <a href="<?php echo esc_url( help_url( 'faq' ) ); ?>">FAQ</a> · <a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a></p>
  </main>
