#!/usr/bin/env python3
"""Generate full Texas IP Law Help static pages with shared chrome."""
from pathlib import Path
from _chrome import page

ROOT = Path(__file__).resolve().parent
IMG = "../../wp-content/themes/texas-ip-law/assets/images"


def w(name, html):
    (ROOT / name).write_text(html, encoding="utf-8")
    print("wrote", name)


w(
    "index.html",
    page(
        "Texas IP Law Help | Patent, Trademark &amp; Copyright Guides for Inventors",
        "Start with the right path: patent, trademark, or copyright guides, USPTO links, AI Q&amp;A, and a free consultation with Texas IP Law Group.",
        "index.html",
        f"""  <section class="mock-help-hero">
    <h1>Texas IP Law Help</h1>
    <p>A full inventor site — pick what you need, follow a short path, then use official USPTO or Copyright Office forms. Operated by <strong>Texas IP Law Group</strong>. Educational only; not legal advice.</p>
  </section>

  <section class="help-chooser" aria-labelledby="chooser-heading">
    <h2 id="chooser-heading">What do you need today?</h2>
    <p>One tap. We send you to the right guide, official forms, or an attorney — not a pile of equal widgets.</p>
    <div class="help-chooser__grid">
      <a class="help-chooser__card" href="guide-patent.html">
        <span class="help-chooser__kicker">Patent</span>
        <h3>I invented something</h3>
        <p>Provisional vs. non-provisional, what to document, and the USPTO next click.</p>
      </a>
      <a class="help-chooser__card" href="guide-trademark.html">
        <span class="help-chooser__kicker">Trademark</span>
        <h3>I need to protect a name or logo</h3>
        <p>Clearance, TEAS filing, and when a brand fight needs counsel.</p>
      </a>
      <a class="help-chooser__card" href="guide-copyright.html">
        <span class="help-chooser__kicker">Copyright</span>
        <h3>I created writing, art, or code</h3>
        <p>Copyright Office registration — not USPTO — and what registration adds.</p>
      </a>
      <a class="help-chooser__card" href="ask.html">
        <span class="help-chooser__kicker">Question</span>
        <h3>I have a specific question</h3>
        <p>Search our guides or ask the AI. Answers link to official sources.</p>
      </a>
      <a class="help-chooser__card help-chooser__card--consult" href="contact.html">
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
        <form class="mock-search-split__form mock-resource-search__form" action="search-results.html" method="get">
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
          <p><a href="guides.html">All guides →</a></p>
        </aside>
        <div class="mock-guides__grid">
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">📄</div>
            <h3>Filing a patent</h3>
            <p>Provisional vs. non-provisional and USPTO basics.</p>
            <a href="guide-patent.html">Open patent guide →</a>
          </article>
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">™</div>
            <h3>Filing a trademark</h3>
            <p>TEAS filing and brand clearance overview.</p>
            <a href="guide-trademark.html">Open trademark guide →</a>
          </article>
          <article class="mock-guide-card">
            <div class="mock-guide-card__icon" aria-hidden="true">©</div>
            <h3>Filing a copyright</h3>
            <p>U.S. Copyright Office registration overview.</p>
            <a href="guide-copyright.html">Open copyright guide →</a>
          </article>
        </div>
      </div>
    </div>
  </section>

  <section class="mock-section mock-section--light">
    <div class="mock-section__inner">
      <p class="mock-section__eyebrow" style="color:var(--gold)">Help articles</p>
      <h2 class="mock-section__title" style="color:var(--navy-deep)">Inventor how-tos</h2>
      <div class="mock-blog-grid">
        <a class="mock-blog-card mock-blog-card--link" href="article-patent-basics.html">
          <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-basics.jpg)"></div>
          <div class="mock-blog-card__body">
            <h4>Patent basics for inventors</h4>
            <p style="font-size:13px;color:var(--muted);margin:0">What to document before you file.</p>
          </div>
        </a>
        <a class="mock-blog-card mock-blog-card--link" href="article-provisional.html">
          <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-provisional.jpg)"></div>
          <div class="mock-blog-card__body">
            <h4>Provisional vs. non-provisional</h4>
            <p style="font-size:13px;color:var(--muted);margin:0">Timing before public disclosure.</p>
          </div>
        </a>
        <a class="mock-blog-card mock-blog-card--link" href="article-licensing.html">
          <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-licensing.jpg)"></div>
          <div class="mock-blog-card__body">
            <h4>Licensing your IP</h4>
            <p style="font-size:13px;color:var(--muted);margin:0">Terms every inventor should know.</p>
          </div>
        </a>
      </div>
      <p style="margin-top:20px"><a href="articles.html">View all help articles →</a></p>
    </div>
  </section>

  <section class="mock-cta-band">
    <h2>Need advice for your situation?</h2>
    <p style="color:var(--muted);max-width:520px;margin:0 auto 20px">Guides and AI cannot replace an attorney. Texas IP Law Group offers a free consultation.</p>
    <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Schedule free consultation</button>
  </section>
""",
        extra_head='  <link rel="canonical" href="https://texasiplawhelp.com/">\n',
    ),
)

w(
    "guides.html",
    page(
        "IP guides for inventors — Texas IP Law Help",
        "Step-by-step patent, trademark, and copyright guides with official USPTO and Copyright Office links.",
        "guides.html",
        """  <main class="mock-content-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · Guides</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Guides</h1>
    <p style="color:var(--muted);max-width:640px">Each guide is a path: is this the right IP type, what you can do yourself, when to stop and talk to us, then the official government next click.</p>
    <div class="mock-guides__grid" style="margin-top:32px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:20px">
      <article class="mock-guide-card">
        <h3>Filing a patent</h3>
        <p>Protect a new machine, process, composition, or useful improvement.</p>
        <a href="guide-patent.html">Open patent guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Filing a trademark</h3>
        <p>Protect a name, logo, or slogan you use to sell goods or services.</p>
        <a href="guide-trademark.html">Open trademark guide →</a>
      </article>
      <article class="mock-guide-card">
        <h3>Filing a copyright</h3>
        <p>Protect original writing, art, music, software, or other works of authorship.</p>
        <a href="guide-copyright.html">Open copyright guide →</a>
      </article>
    </div>
    <p style="margin-top:28px">Related: <a href="resources.html">Official resources</a> · <a href="faq.html">FAQ</a> · <a href="ask.html">Ask AI</a></p>
  </main>
""",
    ),
)

w(
    "guide-patent.html",
    page(
        "How to file a patent — inventor guide | Texas IP Law Help",
        "Overview of U.S. patent filing for inventors: document, search, provisional vs non-provisional, USPTO apply links, and when to hire counsel.",
        "guides.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · <a href="guides.html">Guides</a> · Patent</p>
    <h1>How to file a patent — overview for inventors</h1>
    <p>Use this path if you made a new and useful invention (machine, process, composition, or improvement). Names and logos are usually <a href="guide-trademark.html">trademarks</a>. Books, art, and code are usually <a href="guide-copyright.html">copyright</a>.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">The path</h2>
    <ol class="mock-guide-steps">
      <li><strong>Document</strong> the invention: drawings, how it works, dates of conception, and anyone you already told.</li>
      <li><strong>Look around</strong> — a prior-art search (USPTO Patent Public Search and published papers) so you know what is already out there.</li>
      <li><strong>Choose a first filing.</strong> A <a href="article-provisional.html">provisional</a> can lock an early date at lower cost; a non-provisional is examined and can become an issued patent.</li>
      <li><strong>File with the USPTO</strong> — often with a registered patent attorney or agent. Self-filers still use official forms.</li>
      <li><strong>Keep deadlines.</strong> A provisional gives you up to 12 months to file a matching non-provisional. Office actions have their own clocks.</li>
    </ol>
    <div class="help-stop">
      <h2>Stop and talk to an attorney if…</h2>
      <ul>
        <li>You already showed the invention at a trade show, on a website, or to investors.</li>
        <li>Someone wants you to assign or license rights, or you have a co-inventor dispute.</li>
        <li>You received a USPTO office action or a deadline inside six months.</li>
        <li>The invention is a medical device, software with a business method, or anything you are unsure is even patent-eligible.</li>
      </ul>
      <p style="margin:12px 0 0"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button></p>
    </div>
    <div class="mock-guide-official">
      <h2 style="margin:0 0 12px;font-size:18px;color:var(--navy-deep)">Official next clicks (USPTO)</h2>
      <p style="margin:0 0 12px;font-size:14px;color:var(--muted)">We do not replace the government site. These are the pages to use for self-service filing and learning.</p>
      <p style="margin:0"><a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">Patent basics ↗</a> · <a href="https://www.uspto.gov/patents/apply" target="_blank" rel="noopener">How to apply ↗</a> · <a href="https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application" target="_blank" rel="noopener">Provisional applications ↗</a></p>
    </div>
    <div class="help-next">
      <a href="article-patent-basics.html"><strong>Read:</strong> Patent basics for inventors</a>
      <a href="ask.html"><strong>Ask:</strong> Texas IP Law Help AI</a>
    </div>
    <p>Related: <a href="guide-trademark.html">Trademark guide</a> · <a href="guide-copyright.html">Copyright guide</a> · <a href="resources.html">All official resources</a></p>
  </main>
""",
    ),
)

w(
    "guide-trademark.html",
    page(
        "How to file a trademark — inventor guide | Texas IP Law Help",
        "Federal trademark overview: clearance, TEAS filing, specimens, and when brand conflicts need an attorney.",
        "guides.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · <a href="guides.html">Guides</a> · Trademark</p>
    <h1>How to file a trademark — overview</h1>
    <p>Use this path to protect a <strong>brand</strong> — name, logo, or slogan you use in commerce. A trademark is not a patent. If you invented a product, start with the <a href="guide-patent.html">patent guide</a> as well.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">The path</h2>
    <ol class="mock-guide-steps">
      <li><strong>Pick a strong mark</strong> (distinctive, not a generic product name).</li>
      <li><strong>Clearance search</strong> — USPTO Trademark Search plus common-law uses (web, state filings). Filing without a search is how conflicts start.</li>
      <li><strong>Identify goods and services</strong> and how the mark is already used, or will be used, in commerce.</li>
      <li><strong>File on USPTO TEAS</strong> with the right specimens and fees.</li>
      <li><strong>Watch the application</strong> — office actions, publication, then maintenance after registration.</li>
    </ol>
    <div class="help-stop">
      <h2>Stop and talk to an attorney if…</h2>
      <ul>
        <li>Search shows a similar mark in your class, or you received a cease-and-desist.</li>
        <li>You are expanding nationwide or licensing the brand.</li>
        <li>The USPTO issued an office action you do not understand.</li>
      </ul>
      <p style="margin:12px 0 0"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button></p>
    </div>
    <div class="mock-guide-official">
      <h2 style="margin:0 0 12px;font-size:18px;color:var(--navy-deep)">Official next clicks (USPTO)</h2>
      <p style="margin:0"><a href="https://www.uspto.gov/trademarks" target="_blank" rel="noopener">Trademarks ↗</a> · <a href="https://www.uspto.gov/trademarks/search" target="_blank" rel="noopener">Trademark search ↗</a> · <a href="https://www.uspto.gov/trademarks/apply" target="_blank" rel="noopener">Apply (TEAS) ↗</a></p>
    </div>
    <div class="help-next">
      <a href="resources.html"><strong>More:</strong> Official resource list</a>
      <a href="ask.html"><strong>Ask:</strong> AI about brands</a>
    </div>
    <p>Related: <a href="guide-patent.html">Patent guide</a> · <a href="guide-copyright.html">Copyright guide</a></p>
  </main>
""",
    ),
)

w(
    "guide-copyright.html",
    page(
        "How to file a copyright — inventor guide | Texas IP Law Help",
        "Copyright Office registration overview for writings, art, music, and software. Not the USPTO.",
        "guides.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · <a href="guides.html">Guides</a> · Copyright</p>
    <h1>How to file a copyright — overview</h1>
    <p>Copyright protects original works of authorship fixed in a tangible medium — software, writings, art, music, videos. Registration is with the <strong>U.S. Copyright Office</strong>, not the USPTO.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">The path</h2>
    <ol class="mock-guide-steps">
      <li>Confirm the work is original and already written down, recorded, or saved (not just an idea in your head).</li>
      <li>Understand what registration adds: public record, and important timing if you later need to sue.</li>
      <li>Prepare the application and deposit copies per Copyright Office rules for your type of work.</li>
      <li>File online through copyright.gov (eCO) and track the claim.</li>
    </ol>
    <div class="help-stop">
      <h2>Stop and talk to an attorney if…</h2>
      <ul>
        <li>Someone copied your work, or a platform took it down.</li>
        <li>You need work-for-hire, assignment, or a software license drafted.</li>
        <li>The work is mixed with a patentable invention or a brand you also want to register.</li>
      </ul>
      <p style="margin:12px 0 0"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button></p>
    </div>
    <div class="mock-guide-official">
      <h2 style="margin:0 0 12px;font-size:18px;color:var(--navy-deep)">Official next clicks (Copyright Office)</h2>
      <p style="margin:0"><a href="https://www.copyright.gov/" target="_blank" rel="noopener">Copyright.gov ↗</a> · <a href="https://www.copyright.gov/registration/" target="_blank" rel="noopener">Registration overview ↗</a></p>
    </div>
    <div class="help-next">
      <a href="guide-patent.html"><strong>Also inventing?</strong> Patent guide</a>
      <a href="ask.html"><strong>Ask:</strong> AI about copyright</a>
    </div>
  </main>
""",
    ),
)

ARTICLES = [
    (
        "article-patent-basics.html",
        "Patent basics for inventors | Texas IP Law Help",
        "What Texas inventors should document and understand before filing a U.S. patent application.",
        "Patent basics for inventors",
        f"{IMG}/blog/blog-post-basics.jpg",
        """
    <p>A patent is a time-limited right to exclude others from making, using, selling, or importing what the claims cover. It is not a permission slip to commercialize, and it is not the same as a trademark or copyright.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">Before you file</h2>
    <ul>
      <li>Write a dated description and sketches of how the invention works — not just that it exists.</li>
      <li>List everyone who contributed to the inventive idea (inventorship is a legal question).</li>
      <li>Note every public disclosure: pitches, demos, papers, Kickstarter, GitHub.</li>
      <li>Read the USPTO <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">patent basics</a> so the forms make sense.</li>
    </ul>
    <p>Then follow the <a href="guide-patent.html">patent guide</a>. If the facts are messy (investors, a looming show, a co-founder), <button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;font:inherit;text-decoration:underline">talk to Texas IP Law Group</button>.</p>
""",
    ),
    (
        "article-provisional.html",
        "Provisional vs. non-provisional patents | Texas IP Law Help",
        "How provisional applications relate to a later non-provisional filing, the 12-month clock, and public disclosure.",
        "Provisional vs. non-provisional",
        f"{IMG}/blog/blog-post-provisional.jpg",
        """
    <p>A <strong>provisional</strong> application can establish an early U.S. filing date. It is not examined, does not become a patent by itself, and expires at 12 months unless you file a matching non-provisional that claims its benefit.</p>
    <p>A <strong>non-provisional</strong> (utility) application is examined. Claims get written, the examiner searches, and you may receive office actions.</p>
    <p>Inventors often ask about provisionals before an investor meeting. Timing around <strong>public disclosure</strong> is fact-specific — this article cannot tell you whether your demo last month still leaves a path. Use the <a href="guide-patent.html">patent guide</a> and official <a href="https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application" target="_blank" rel="noopener">USPTO provisional page ↗</a>, then consult if the date is close.</p>
""",
    ),
    (
        "article-patentability.html",
        "Is my idea patentable? | Texas IP Law Help",
        "High-level look at novelty, obviousness, and subject matter — educational only, not an opinion on your invention.",
        "Is my idea patentable?",
        f"{IMG}/blog/blog-post-patentability.jpg",
        """
    <p>U.S. utility patents generally require patent-eligible subject matter, novelty, and non-obviousness, plus an enabling description. Whether <em>your</em> idea qualifies is a legal and technical judgment — the AI and this article will not declare it patentable.</p>
    <p>At a high level: if the public already has the same invention, or if it would have been obvious to a skilled person in view of what already exists, a patent is unlikely. Abstract ideas, laws of nature, and natural phenomena have extra eligibility issues.</p>
    <p>A prior-art search is a start; an attorney opinion is different. See the <a href="guide-patent.html">patent guide</a> or <a href="ask.html">ask a general question</a>.</p>
""",
    ),
    (
        "article-licensing.html",
        "Licensing your IP | Texas IP Law Help",
        "Key licensing terms inventors should recognize before signing — field, territory, exclusive, royalties.",
        "Licensing your IP",
        f"{IMG}/blog/blog-post-licensing.jpg",
        """
    <p>A license lets someone else use your IP on terms you set. Assignment transfers ownership. Mixing those up in an email to a manufacturer is a common way inventors lose control.</p>
    <p>Terms to recognize: exclusive vs. non-exclusive, field of use, territory, royalties vs. lump sum, improvements, and who enforces against copycats. This is not a contract template.</p>
    <p>If someone sent you a term sheet, that is a <a href="contact.html">consultation</a> moment — not an AI moment.</p>
""",
    ),
]

for fname, title, desc, h1, img, body in ARTICLES:
    w(
        fname,
        page(
            title,
            desc,
            "articles.html",
            f"""  <header class="help-article-hero">
    <div class="help-article-hero__inner">
      <p class="mock-breadcrumb"><a href="index.html">Home</a> · <a href="articles.html">Articles</a></p>
      <h1>{h1}</h1>
      <p>Educational explainer by Texas IP Law Group. Not legal advice for your facts.</p>
    </div>
  </header>
  <main class="mock-guide-page">
    {body}
    <p style="margin-top:28px"><a href="articles.html">All articles</a> · <a href="guides.html">Guides</a> · <a href="ask.html">Ask AI</a></p>
  </main>
""",
        ),
    )

w(
    "articles.html",
    page(
        "IP articles for inventors — Texas IP Law Help",
        "Educational articles on patents, trademarks, copyright, and licensing for Texas inventors.",
        "articles.html",
        f"""  <main class="mock-content-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · Articles</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Articles for inventors</h1>
    <p style="color:var(--muted);max-width:640px">Help-focused explainers — not legal advice. When you need counsel for your invention, Texas IP Law Group offers a free consultation.</p>
    <div class="mock-blog-grid" style="margin-top:32px">
      <a class="mock-blog-card mock-blog-card--link" href="article-patent-basics.html">
        <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-basics.jpg)"></div>
        <div class="mock-blog-card__body"><h4>Patent basics for inventors</h4><p style="font-size:13px;color:var(--muted)">What to document before filing with the USPTO.</p></div>
      </a>
      <a class="mock-blog-card mock-blog-card--link" href="article-provisional.html">
        <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-provisional.jpg)"></div>
        <div class="mock-blog-card__body"><h4>Provisional vs. non-provisional</h4><p style="font-size:13px;color:var(--muted)">Investor meetings and public disclosure timing.</p></div>
      </a>
      <a class="mock-blog-card mock-blog-card--link" href="article-patentability.html">
        <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-patentability.jpg)"></div>
        <div class="mock-blog-card__body"><h4>Is my idea patentable?</h4><p style="font-size:13px;color:var(--muted)">Novelty and obviousness at a high level.</p></div>
      </a>
      <a class="mock-blog-card mock-blog-card--link" href="article-licensing.html">
        <div class="mock-blog-card__img" style="background-image:url({IMG}/blog/blog-post-licensing.jpg)"></div>
        <div class="mock-blog-card__body"><h4>Licensing your IP</h4><p style="font-size:13px;color:var(--muted)">Key deal terms for inventors.</p></div>
      </a>
    </div>
  </main>
""",
    ),
)

w(
    "resources.html",
    page(
        "USPTO &amp; official inventor resources — Texas IP Law Help",
        "Official USPTO, Copyright Office, Inventors Assistance Center, and Texas pro bono links for self-service filing.",
        "resources.html",
        """  <main class="mock-content-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · Resources</p>
    <h1 class="mock-section__title" style="color:var(--navy-deep)">Official resources</h1>
    <p style="color:var(--muted);max-width:680px">Texas IP Law Help points you at primary government sources. We are not the USPTO. If you cannot pay a lawyer, we also list honest Texas options — we do not run those programs.</p>
    <div class="help-resource-grid">
      <article class="help-resource-card">
        <h3>Patent basics</h3>
        <p>What patents protect and how the U.S. process works.</p>
        <a href="https://www.uspto.gov/patents/basics" target="_blank" rel="noopener">uspto.gov/patents/basics ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Apply for a patent</h3>
        <p>Official filing path, fees, and forms.</p>
        <a href="https://www.uspto.gov/patents/apply" target="_blank" rel="noopener">uspto.gov/patents/apply ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Provisional applications</h3>
        <p>Lower-cost first filing to secure an early date.</p>
        <a href="https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application" target="_blank" rel="noopener">USPTO provisional overview ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Trademarks (TEAS)</h3>
        <p>Federal trademark search, filing, and maintenance.</p>
        <a href="https://www.uspto.gov/trademarks" target="_blank" rel="noopener">uspto.gov/trademarks ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Inventors Assistance Center</h3>
        <p>USPTO staff answer general filing questions. Not a substitute for your own attorney.</p>
        <a href="https://www.uspto.gov/learning-and-resources/support-centers/inventors-assistance-center-iac" target="_blank" rel="noopener">IAC ↗</a>
        <p style="margin-top:8px;font-size:13px">800-786-9199</p>
      </article>
      <article class="help-resource-card">
        <h3>U.S. Copyright Office</h3>
        <p>Register writings, art, music, and software.</p>
        <a href="https://www.copyright.gov/" target="_blank" rel="noopener">copyright.gov ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Need free patent help in Texas?</h3>
        <p>Income-qualified inventors may apply to TALA’s USPTO Patent Pro Bono program. Waitlists are common. This is not Texas IP Law Group.</p>
        <a href="https://talarts.org/inventors" target="_blank" rel="noopener">talarts.org/inventors ↗</a>
      </article>
      <article class="help-resource-card">
        <h3>Our guides</h3>
        <p>Plain-language paths that end at these official pages.</p>
        <a href="guides.html">Open guides →</a>
      </article>
    </div>
  </main>
""",
    ),
)

w(
    "ask.html",
    page(
        "Ask AI — Texas IP Law Help",
        "Ask general patent, trademark, and copyright questions. Educational AI demo by Texas IP Law Group — not legal advice.",
        "ask.html",
        """  <section class="mock-help-hero">
    <h1>Ask Texas IP Law Help AI</h1>
    <p>General questions only. Replies point to our <a href="guides.html" style="color:#d4af37">guides</a> and official USPTO pages. For advice about your invention, use a free consultation.</p>
  </section>
  <div class="mock-help-layout" id="chat">
    <div class="mock-intake" id="mock-intake">
      <span class="mock-step-label" id="mock-step-1">Step 1</span>
      <h2 style="margin:0 0 8px;font-family:var(--font-display);color:var(--navy-deep)">Your question</h2>
      <p style="font-size:14px;color:var(--muted);margin:0 0 16px">Name and email let the live site follow up. This mock does not store data on a server.</p>
      <div class="mock-field">
        <label for="name">Name *</label>
        <input id="name" type="text" value="Jane Inventor" autocomplete="name">
      </div>
      <div class="mock-field">
        <label for="email">Email *</label>
        <input id="email" type="email" value="jane@example.com" autocomplete="email">
      </div>
      <div class="mock-field">
        <label for="topic">Topic</label>
        <select id="topic">
          <option>Patents &amp; inventions</option>
          <option>Trademarks</option>
          <option>Copyright</option>
          <option>General IP</option>
        </select>
      </div>
      <div class="mock-field">
        <label for="interest">What are you interested in?</label>
        <select id="interest">
          <option>Filing a patent</option>
          <option>Filing a trademark</option>
          <option>Filing a copyright</option>
          <option>Licensing / strategy</option>
        </select>
      </div>
      <div class="mock-field">
        <label for="q">Your first question</label>
        <textarea id="q">Should I file a provisional patent before talking to investors about my medical device?</textarea>
      </div>
      <button type="button" class="mock-btn mock-btn--gold" style="width:100%" id="mock-start-ai">Start AI help</button>
    </div>
    <div>
      <span class="mock-step-label" id="mock-step-2">Step 2</span>
      <div class="mock-chat mock-chat--demo" id="mock-chat">
        <div class="mock-chat__head">
          <img src="../../wp-content/themes/texas-ip-law/assets/images/susan-avatar-cartoon.png" alt="">
          <div>
            <strong>Texas IP Law Help AI</strong>
            <small id="mock-chat-status">Click Start AI help</small>
            <span class="mock-ai-budget" id="mock-chat-budget">AI demo · 4 turns left</span>
          </div>
        </div>
        <div class="mock-chat__msgs" id="mock-chat-msgs">
          <p class="mock-chat__empty">Your conversation appears here after Step 1.</p>
        </div>
        <div class="mock-chat__compose">
          <input type="text" id="mock-chat-input" placeholder="Ask a follow-up question…" disabled>
          <button type="button" class="mock-btn mock-btn--gold" id="mock-chat-send" disabled>Send</button>
        </div>
        <p style="margin:0;padding:10px 14px 14px;font-size:11px;color:var(--muted);background:#fff">Daily token budget on live site; over cap, answers use the knowledge base (guides + USPTO).</p>
      </div>
    </div>
  </div>
  <p style="text-align:center;padding:0 24px 40px;color:var(--muted)">Prefer to read first? <a href="guides.html">Open the guides</a> · <a href="faq.html">FAQ</a></p>
""",
    ),
)

w(
    "faq.html",
    page(
        "Inventor FAQ — Texas IP Law Help",
        "Common questions about patents, trademarks, copyright, USPTO filing, and when to hire Texas IP Law Group.",
        "faq.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · FAQ</p>
    <h1>Frequently asked questions</h1>
    <p>Short answers. Guides and official sites have the steps. None of this is legal advice for your facts.</p>
    <div class="help-faq">
      <details open>
        <summary>Is this the USPTO?</summary>
        <p>No. Texas IP Law Help is an educational site by Texas IP Law Group. Filing happens on <a href="https://www.uspto.gov/" target="_blank" rel="noopener">uspto.gov</a> or <a href="https://www.copyright.gov/" target="_blank" rel="noopener">copyright.gov</a>.</p>
      </details>
      <details>
        <summary>Patent, trademark, or copyright — which one?</summary>
        <p>Invention / how it works → <a href="guide-patent.html">patent</a>. Name or logo you sell under → <a href="guide-trademark.html">trademark</a>. Writing, art, music, code as expression → <a href="guide-copyright.html">copyright</a>. Many businesses need more than one.</p>
      </details>
      <details>
        <summary>Can I file myself?</summary>
        <p>The USPTO allows it. Forms, fees, and claims are easy to get wrong. Use our guides to reach the official pages; use a consultation if the invention, a deadline, or investors are in the mix.</p>
      </details>
      <details>
        <summary>Does the AI give legal advice?</summary>
        <p>No. It explains general concepts and links to guides and USPTO pages. See the <a href="disclaimer.html">disclaimer</a>.</p>
      </details>
      <details>
        <summary>I cannot afford a lawyer. What then?</summary>
        <p>See <a href="resources.html">official resources</a> for the Inventors Assistance Center and TALA Patent Pro Bono (income limits, waitlist). We do not operate those programs.</p>
      </details>
      <details>
        <summary>How do I hire Texas IP Law Group?</summary>
        <p><a href="contact.html">Contact</a> or use Free consultation. The firm site is <a href="https://texasiplawgroup.com/" target="_blank" rel="noopener">texasiplawgroup.com</a>.</p>
      </details>
    </div>
  </main>
""",
    ),
)

w(
    "about.html",
    page(
        "About Texas IP Law Help",
        "Texas IP Law Help is an inventor education website with guides, USPTO links, and AI Q&amp;A — operated by Texas IP Law Group.",
        "about.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · About</p>
    <h1>About Texas IP Law Help</h1>
    <p><strong>Texas IP Law Help</strong> (texasiplawhelp.com) is a full inventor website: start-here paths, step-by-step guides, articles, official USPTO and Copyright Office links, FAQ, search, and an educational AI demo.</p>
    <p>It is operated by <strong>Texas IP Law Group</strong>, a patent and IP law firm. This site is separate from the <a href="../gold-navy/home.html">firm website</a> so you can learn and reach government forms without wading through attorney sales pages first.</p>
    <h2 style="font-family:var(--font-display);color:var(--navy-deep);font-size:20px">What we are not</h2>
    <p>We are not a government agency, not TexasLawHelp, and not legal aid. AI and guides are not legal advice and do not create an attorney-client relationship. See the <a href="disclaimer.html">disclaimer</a>.</p>
    <p style="margin-top:24px"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Talk to an attorney</button></p>
  </main>
""",
    ),
)

w(
    "disclaimer.html",
    page(
        "Disclaimer — Texas IP Law Help",
        "Texas IP Law Help is general educational information only, not legal advice.",
        "about.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · Disclaimer</p>
    <h1>Disclaimer</h1>
    <p>Texas IP Law Help provides <strong>general educational information</strong> about intellectual property. It is not legal advice and does not create an attorney-client relationship.</p>
    <p>AI responses, guides, articles, and search results may be incomplete or outdated. Official filing rules live on USPTO.gov and Copyright.gov — confirm there before you file.</p>
    <p>For advice about your specific invention or brand, contact Texas IP Law Group.</p>
    <p style="margin-top:24px"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button></p>
  </main>
""",
    ),
)

w(
    "contact.html",
    page(
        "Contact &amp; free consultation — Texas IP Law Help",
        "Reach Texas IP Law Group from Texas IP Law Help: phone, email, or request a free consultation.",
        "about.html",
        """  <main class="mock-guide-page">
    <p class="mock-breadcrumb"><a href="index.html">Home</a> · Contact</p>
    <h1>Contact Texas IP Law Group</h1>
    <p>This Help site educates. The firm gives legal advice. Use consultation when your facts matter — deadlines, investors, office actions, someone copying you.</p>
    <ul>
      <li>Phone: <a href="tel:7135188837">713-518-8837</a></li>
      <li>Email: <a href="mailto:contact@texasiplawgroup.com">contact@texasiplawgroup.com</a></li>
      <li>Firm site: <a href="https://texasiplawgroup.com/" target="_blank" rel="noopener">texasiplawgroup.com ↗</a></li>
    </ul>
    <p style="margin-top:24px"><button type="button" class="mock-btn mock-btn--gold" data-open-consult>Request a free consultation</button></p>
    <p style="margin-top:16px;color:var(--muted)">Still figuring out patent vs trademark? Start at <a href="index.html">What do you need today?</a></p>
  </main>
""",
    ),
)

w(
    "search-results.html",
    page(
        "Search results — Texas IP Law Help",
        "Search Texas IP Law Help for patent, trademark, and copyright guides, articles, and USPTO resources.",
        "index.html",
        """  <div class="mock-search-hero">
    <h1>Results for: “<span id="search-results-query">provisional patent</span>”</h1>
  </div>
  <section class="mock-resource-search mock-resource-search--compact">
    <div class="mock-resource-search__inner">
      <form class="mock-resource-search__form" action="search-results.html" method="get">
        <div><label for="sr-topic">Topic</label><select id="sr-topic" name="topic"><option value="">All</option><option value="patents">Patents</option><option value="trademarks">Trademarks</option><option value="copyright">Copyright</option><option value="general">General</option></select></div>
        <div><label for="sr-type">Type</label><select id="sr-type" name="type"><option value="">All</option><option value="guide">Guides</option><option value="article">Articles</option><option value="uspto">USPTO</option></select></div>
        <div><label for="sr-q">Keyword</label><input id="sr-q" type="search" name="q" value="provisional patent"></div>
        <button type="submit" class="mock-btn mock-btn--gold">Search</button>
      </form>
    </div>
  </section>
  <div class="mock-search-results">
    <ul class="mock-search-results__list" id="search-results-list"></ul>
  </div>
""",
    ),
)

print("done")
