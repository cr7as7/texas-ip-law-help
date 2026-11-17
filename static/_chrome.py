"""Shared header/footer strings for the Help site mock. Imported by gen_help_pages.py."""

PREVIEW = (
    '  <p class="mock-label-preview">texasiplawhelp.com — full site mock · '
    'by Texas IP Law Group · <a href="../gold-navy/home.html" style="color:#6b5a1e">Firm preview →</a></p>\n'
)

NAV = [
    ("index.html", "Home"),
    ("guides.html", "Guides"),
    ("articles.html", "Articles"),
    ("resources.html", "Resources"),
    ("ask.html", "Ask AI"),
    ("faq.html", "FAQ"),
    ("about.html", "About"),
]


def header(active):
    links = []
    for href, label in NAV:
        cls = ' class="is-active"' if href == active else ""
        links.append(f'        <a href="{href}"{cls}>{label}</a>')
    nav = "\n".join(links)
    return f"""{PREVIEW}  <header class="mock-site-header">
    <div class="mock-site-header__inner">
      <a class="mock-logo" href="index.html">
        <span class="mock-logo__mark" aria-hidden="true">⌕</span>
        <span class="mock-logo__text">
          <strong class="help-site-name">Texas IP Law Help</strong>
          <span class="help-site-byline">by Texas IP Law Group</span>
        </span>
      </a>
      <nav class="mock-nav" aria-label="Primary">
{nav}
      </nav>
      <button type="button" class="mock-btn mock-btn--gold" data-open-consult>Free consultation</button>
    </div>
  </header>
"""


FOOTER = """  <footer class="mock-footer">
    <div class="mock-footer__inner">
      <div>
        <strong style="color:#fff;font-family:var(--font-display)">Texas IP Law Help</strong>
        <p>Educational inventor resource by Texas IP Law Group. Not a government site. Not legal advice.</p>
      </div>
      <div>
        <h4>This site</h4>
        <ul>
          <li><a href="guides.html">Guides</a></li>
          <li><a href="articles.html">Articles</a></li>
          <li><a href="resources.html">Official resources</a></li>
          <li><a href="ask.html">Ask AI</a></li>
          <li><a href="faq.html">FAQ</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Texas IP Law Group</h4>
        <ul>
          <li><a href="../gold-navy/home.html">Firm website (mock)</a></li>
          <li><a href="https://texasiplawgroup.com/" target="_blank" rel="noopener">texasiplawgroup.com ↗</a></li>
          <li><button type="button" data-open-consult style="background:none;border:none;padding:0;color:rgba(255,255,255,0.85);cursor:pointer;font:inherit">Free consultation</button></li>
          <li>713-518-8837</li>
          <li>contact@texasiplawgroup.com</li>
        </ul>
      </div>
      <div>
        <h4>Legal</h4>
        <ul>
          <li><a href="about.html">About this site</a></li>
          <li><a href="disclaimer.html">Disclaimer</a></li>
          <li><a href="https://www.uspto.gov/" target="_blank" rel="noopener">USPTO.gov ↗</a></li>
          <li><a href="https://www.copyright.gov/" target="_blank" rel="noopener">Copyright.gov ↗</a></li>
        </ul>
      </div>
    </div>
    <p class="mock-footer__bottom">© Texas IP Law Group · Educational only · Not legal advice · texasiplawhelp.com mock</p>
  </footer>
  <a class="mock-quick-answer" href="ask.html">
    <span class="mock-quick-answer__bolt" aria-hidden="true">⚡</span>
    Ask AI
  </a>
  <script src="help.js" defer></script>
"""


def page(title, description, active, body, extra_head=""):
    return f"""<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{title}</title>
  <meta name="description" content="{description}">
  <link rel="stylesheet" href="help.css">
{extra_head}</head>
<body>
{header(active)}{body}
{FOOTER}
</body>
</html>
"""
