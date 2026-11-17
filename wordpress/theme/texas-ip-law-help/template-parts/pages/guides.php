<?php
/**
 * Page body: guides
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
  <main class="mock-content-page" id="main">
    <p class="mock-breadcrumb"><a href="<?php echo esc_url( help_url( 'home' ) ); ?>">Home</a> · Guides</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Guides</h1>
    <p style="color:var(--muted);max-width:640px">Each guide is a path: is this the right IP type, what you can do yourself, when to stop and talk to us, then the official government next click.</p>
    <div class="mock-guides__grid" style="margin-top:32px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
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
    <p style="margin-top:28px">Related: <a href="<?php echo esc_url( help_url( 'resources' ) ); ?>">Official resources</a> · <a href="<?php echo esc_url( help_url( 'faq' ) ); ?>">FAQ</a> · <a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a></p>
  </main>
