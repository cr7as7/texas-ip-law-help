<?php
/**
 * Page body: home
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
  <main id="main">
  <section class="mock-help-hero">
    <h1>Texas IP Law Help</h1>
    <p>A full inventor site — pick what you need, follow a short path, then use official USPTO or Copyright Office forms. Operated by <strong>Texas IP Law Group</strong>. Educational only; not legal advice.</p>
  </section>

  <section class="help-chooser" aria-labelledby="chooser-heading">
    <h2 id="chooser-heading">What do you need today?</h2>
    <p>One tap. We send you to the right guide, official forms, or an attorney — not a pile of equal widgets.</p>
    <div class="help-chooser__grid">
      <a class="help-chooser__card" href="<?php echo esc_url( help_url( 'guides-patent' ) ); ?>">
        <span class="help-chooser__kicker">Patent</span>
        <h3>I invented something</h3>
        <p>Provisional vs. non-provisional, what to document, and the USPTO next click.</p>
      </a>
      <a class="help-chooser__card" href="<?php echo esc_url( help_url( 'guides-trademark' ) ); ?>">
        <span class="help-chooser__kicker">Trademark</span>
        <h3>I need to protect a name or logo</h3>
        <p>Clearance, TEAS filing, and when a brand fight needs counsel.</p>
      </a>
      <a class="help-chooser__card" href="<?php echo esc_url( help_url( 'guides-copyright' ) ); ?>">
        <span class="help-chooser__kicker">Copyright</span>
        <h3>I created writing, art, or code</h3>
        <p>Copyright Office registration — not USPTO — and what registration adds.</p>
      </a>
      <a class="help-chooser__card" href="<?php echo esc_url( help_url( 'ask' ) ); ?>">
        <span class="help-chooser__kicker">Question</span>
        <h3>I have a specific question</h3>
        <p>Search our guides or ask the AI. Answers link to official sources.</p>
      </a>
      <a class="help-chooser__card help-chooser__card--consult" href="<?php echo esc_url( help_url( 'contact' ) ); ?>">
        <span class="help-chooser__kicker">Attorney</span>
        <h3>I want to talk to a lawyer</h3>
        <p>Skip the encyclopedia. Free consultation with Texas IP Law Group.</p>
      </a>
    </div>
  </section>

  <section class="mock-search-split mock-search-split--priority" aria-label="Search Texas IP Law Help">
    <div class="mock-search-split__inner">
      <div class="mock-search-split__intro">
        <h2>Already know the keyword?</h2>
        <p>Search guides, articles, and official USPTO links. If you are not sure which IP type you have, use the cards above instead.</p>
      </div>
      <div class="mock-search-split__panel">
        <div class="mock-search-split__bar"><span aria-hidden="true">⌕</span> Search Texas IP Law Help</div>
        <form class="mock-search-split__form mock-resource-search__form" action="<?php echo esc_url( help_url( 'search-results' ) ); ?>" method="get">
          <div>
            <label for="search-topic">Topic</label>
            <select id="search-topic" name="topic">
              <option value="">All topics</option>
              <option value="patents">Patents</option>
              <option value="trademarks">Trademarks</option>
              <option value="copyright">Copyright</option>
              <option value="general">General IP</option>
            </select>
          </div>
          <div>
            <label for="search-type">Type</label>
            <select id="search-type" name="type">
              <option value="">All types</option>
              <option value="guide">Guides</option>
              <option value="article">Articles</option>
              <option value="uspto">USPTO links</option>
            </select>
          </div>
          <div>
            <label for="search-q">Keyword</label>
            <input id="search-q" type="search" name="q" placeholder="e.g. provisional patent, TEAS trademark…" autocomplete="off">
          </div>
          <button type="submit" class="mock-btn mock-btn--gold">Search</button>
        </form>
        <p class="mock-search-split__note">Educational only — not legal advice.</p>
      </div>
    </div>
  </section>

  <section class="mock-section" id="guides">
    <div class="mock-section__inner">
      <div class="mock-guides">
        <aside class="mock-guides__aside">
          <h2>Common guides</h2>
          <p>Three starting paths. Each one ends at an official government form, plus a clear line for when to call an attorney.</p>
          <p><a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">All guides →</a></p>
        </aside>
        <div class="mock-guides__grid">
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">📄</div>
            <h3>Filing a patent</h3>
            <p>Provisional vs. non-provisional and USPTO basics.</p>
            <a href="<?php echo esc_url( help_url( 'guides-patent' ) ); ?>">Open patent guide →</a>
          </article>
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">™</div>
            <h3>Filing a trademark</h3>
            <p>TEAS filing and brand clearance overview.</p>
            <a href="<?php echo esc_url( help_url( 'guides-trademark' ) ); ?>">Open trademark guide →</a>
          </article>
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">©</div>
            <h3>Filing a copyright</h3>
            <p>U.S. Copyright Office registration overview.</p>
            <a href="<?php echo esc_url( help_url( 'guides-copyright' ) ); ?>">Open copyright guide →</a>
          </article>
        </div>
      </div>
    </div>
  </section>

  <section class="mock-section mock-section--light">
    <div class="mock-section__inner">
      <p class="mock-section__eyebrow" style="color:var(--gold)">Help articles</p>
      <h2 class="mock-section__title" style="color:var(--navy-deep)">Inventor how-tos</h2>
      <?php help_render_post_cards( help_featured_posts(), 'home' ); ?>
      <p style="margin-top:20px"><a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">View all help articles →</a></p>
    </div>
  </section>

  <section class="mock-cta-band">
    <h2>Need advice for your situation?</h2>
    <p style="color:var(--muted);max-width:520px;margin:0 auto 20px">Guides and AI cannot replace an attorney. Texas IP Law Group offers a free consultation.</p>
    <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Schedule free consultation</button>
  </section>
  </main>
