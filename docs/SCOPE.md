# Texas IP Law Help — separate site mock (`texasiplawhelp.com`)

**Status:** **v1 static mock** in `mockups/texasiplawhelp/` (2026-11-11) — home, guides, articles, about, disclaimer, search + `help.js` AI/search. Build: `scripts/build-texasiplawhelp-dist.sh` → `dist/`.  
**Client:** Susan Dellamea / Texas IP Law Group  
**Sister site:** [texasiplawgroup.com](https://texasiplawgroup.com/) (firm — separate mock: `mockups/gold-navy/home.html`)

---

## 1. Product definition

| | **texasiplawgroup.com** | **texasiplawhelp.com** |
|--|-------------------------|-------------------------|
| **Audience** | Clients hiring counsel; credibility | Inventors self-serving first; education |
| **Primary job** | Trust, services, consultation | Answer IP questions, search, USPTO paths, AI demo |
| **Homepage hero** | Susan / firm value proposition | Search + “get help now” (not firm hero) |
| **Success metric** | Consultation requests | Usage + **referrals to firm** (traction for main site) |
| **Tone** | Attorney firm | Educational portal **by** Texas IP Law Group |

Susan owns **both** domains; Help is **not** a duplicate firm site — it is a **destination product** that complements and feeds the firm.

**Client brief** (`mockups/some_info.txt`): inventor resource; general IP Q&A; USPTO forms/links; blog/articles; AI; branding **Texas IP Law Group** (never Lone Star).

**Positioning vs. state resource:** Improve on **[texasiplaw.org](https://texasiplaw.org/)**-style USPTO/inventor help — clearer paths, search, guides, AI, and firm blog/expertise — so inventors choose TIPG when they need counsel.

---

## 2. Reference stack (design + IA)

Use these **in order** when mocking — do not blend firm homepage into Help home.

| Priority | Reference | What to borrow |
|----------|-----------|----------------|
| A | **Susan approved v3 Help page** — `mockups/gold-navy/texas-ip-law-help.html` | Flow steps, split search, common guides, intake + chat, USPTO grid, blog strip, consult CTA, quick-answer chip |
| B | **[TexasLawHelp.org](https://www.texaslawhelp.org/)** | Search-first mental model, “Common guides” grid, topic/type discovery, disclaimer culture (IP content is ours) |
| C | **State / USPTO help** — texasiplaw.org (when reachable) + USPTO.gov | Official link targets, self-filing honesty, no competing “legal advice” |
| D | **In-repo UX spec** — `docs/design-preview/texas-ip-law-help-user-flow.html` | Journey: Discover → intake → AI → follow-up → consultation |
| E | **Live WP target** — `wp-content/themes/texas-ip-law/page-ip-law-help.php` + `template-parts/ip-law-help-*` | What eventually ships on WordPress (may lag mock) |
| F | **Firm site** — texasiplawgroup.com | Footer “powered by / by Texas IP Law Group”, link to About, Fees, Free consultation |

**Out of scope for Help mock primary nav:** About Susan hero, practice-area sales cards, Fees & Services detail (footer links only).

---

## 3. Information architecture (Help-only)

### Primary nav (proposed)
`Home` · `Guides` (hub or anchor) · `Articles` · `Ask AI` · `About this site` · CTA: **Free consultation** (modal or link to group site)

### Page list — static mock v1

| Page | File (planned) | H1 focus |
|------|----------------|----------|
| Home | `index.html` | Texas IP Law Help — search + guides entry |
| Search results | `search-results.html` | Filtered inventor resources (mock index) |
| Guide: Patent | `guide-patent.html` | Filing a patent (overview + USPTO) |
| Guide: Trademark | `guide-trademark.html` | Filing a trademark |
| Guide: Copyright | `guide-copyright.html` | Filing a copyright |
| Articles | `articles.html` | Help-focused blog grid (inventor how-tos) |
| Ask AI | `ask.html` or `index.html#chat` | Single-page chat hub (same as current Help layout) |
| About Help | `about.html` | What this site is + link to Texas IP Law Group |
| Legal | `disclaimer.html` (stub) | Not legal advice; educational |

**Optional v1.1:** Video strip (from WP sample), events strip (no TexasLawHelp events clone).

### Home section order (proposed — differs from firm `home.html`)
1. Compact branded header (logo = **Texas IP Law Help**, subline “by Texas IP Law Group”)
2. **Search band** (dominant — Susan feedback)
3. **Common guides** (patent / trademark / copyright)
4. **Ask AI** (intake + chat) — interactive mock
5. **USPTO & official forms**
6. **Articles** (help-focused, drives SEO + firm authority)
7. **Consultation CTA** → firm
8. Footer: firm link, phone, email, disclaimer

---

## 4. Content strategy

- **Guides:** Step-by-step stubs + outbound USPTO / Copyright Office links (reuse copy from `mockups/gold-navy/guide-*.html`).
- **Articles:** **Help-focused** (inventor how-tos), not a full mirror of firm blog — each card can say “Texas IP Law Group” as publisher; URLs can later point to group blog or Help-only posts.
- **AI:** Scripted demo in mock; Susan appendix `ai-cost-appendix.html` stays **internal**, not public Help nav.
- **Consult:** Mock modal; live = email `contact@texasiplawgroup.com` or `free-consultation` on group site.
- **SEO (future live):** See **§12 SEO** — indexable guides/articles are primary; AI supports users and internal links.

---

## 4b. AI on Texas IP Law Help (product behavior)

**Purpose:** On **texasiplawhelp.com**, AI helps inventors get **plain-language, educational answers** to IP questions — patents, trademarks, copyright, timing, USPTO basics — then points them to **official sources**, **our guides/articles**, and **Texas IP Law Group** when facts need an attorney.

This is **not** a replacement for Susan. It is the “interactive layer” on top of search + guides.

### What the AI does (live site target)

| Capability | Behavior |
|------------|----------|
| **Answer questions** | User asks in natural language; AI explains concepts (provisional vs non-provisional, trademark clearance, etc.) in **general** terms. |
| **Grounding** | Prefer answers that cite **USPTO / Copyright Office links**, **Help guides**, and **curated firm Q&A** — not hallucinated procedure. |
| **Follow-ups** | Same chat thread; user can ask “what about investors?” / “TEAS?” without restarting. |
| **Budget** | Daily token cap (Susan’s cost appendix); over cap → **knowledge-base answers** (static snippets + links). |
| **Escalation** | Clear path: “This isn’t legal advice for your situation” → **free consultation** (group site or form). |
| **Lead capture (optional)** | Light intake (name, email, topic) before or with first question — for follow-up email on live site. |

### What the AI must not do

- Give **specific legal advice** (“you should file Tuesday”, “your invention is patentable”).
- Pose as Susan or a licensed attorney in the chat persona.
- Invent USPTO forms, fees, or deadlines without linking to official pages.

### User journey (maps to mock)

1. Land from search/social/Google → **search** or **Ask AI**  
2. Ask question → AI reply + links to guide/USPTO  
3. Read **article/guide** (SEO landing pages)  
4. Need personal help → **consultation** → **texasiplawgroup.com**

### Mock vs production

| | Mock (`help.js`) | Production (Help domain) |
|--|------------------|---------------------------|
| LLM | Scripted replies | API (OpenAI/Gemini/etc.) + system prompt |
| Grounding | Hard-coded links in replies | RAG: guides + USPTO index + blog |
| SEO | N/A for chat bubbles | **Separate indexable pages** (§12) |

---

## 5. Brand & UI rules

- **Palette:** Same **gold/navy** tokens as `mockups/gold-navy/mock.css` (reuse or shared `help.css` import).
- **Name in header:** “Texas IP Law Help” primary; “Texas IP Law Group” in footer/byline — per `some_info.txt`.
- **No** Lone Star / unrelated reference branding.
- **Disclaimer:** Visible on search + AI (“educational only — not legal advice”).
- **Mock label:** Yellow preview banner (like gold-navy mocks).

---

## 6. Technical / repo plan

```
mockups/texasiplawhelp/          # NEW tree (separate from gold-navy firm mock)
  SCOPE.md                       # this file
  index.html                     # Help home
  ...
  help.css                       # extends or copies gold/navy tokens
  help.js                        # consult modal, search, AI (fork from mock.js)
  dist/                          # Cloudflare bundle (separate script)
```

- **Do not** replace `mockups/gold-navy/` — firm mock stays Susan’s “main website” preview.
- New script: `scripts/build-texasiplawhelp-dist.sh` (mirror cloudflare dist pattern).
- **Production later:** Second GoDaddy Managed WP **or** static Pages on Cloudflare — decision deferred; mock is static first.

---

## 7. Cross-linking contract (both sites)

| From Help | To firm |
|-----------|---------|
| Footer | texasiplawgroup.com — About, Fees, Contact, Free consultation |
| AI / CTA | “Schedule with an attorney” |
| About Help | “Operated by Texas IP Law Group” |

| From firm (gold-navy `home.html`) | To Help |
|-----------------------------------|---------|
| Nav + hero CTA | texasiplawhelp.com (or mock path) — “Open Texas IP Law Help” |
| Mini AI | Deep link to Help `#chat` |

---

## 8. Mock build phases (after scope sign-off)

1. **IA wireframe** — single PDF or HTML sitemap (`sitemap.html`) for Susan.
2. **v1 static** — Home + Help chat page + 3 guides + search results + articles grid + about/disclaimer stubs.
3. **Interactivity** — search filters, AI chat, consult modal (parity with v3 `mock.js`).
4. **Susan package** — PNG slices + optional PDF (update `generate-susan-mockup-pdf.py` for **two-site** deck).
5. **Separate Cloudflare preview** — `*.trycloudflare.com` or `texasiplawhelp.pages.dev`.

---

## 9. Open items to confirm with Susan (before pixel work)

- [ ] Exact live URL spelling confirmed: **texasiplawhelp.com**
- [ ] Is **texasiplaw.org** the main competitive reference she named? Any other inventor sites?
- [ ] Free consultation: stay on **group.com** only, or form on Help too?
- [ ] Articles: all new Help titles vs. syndicate existing group blog posts?
- [ ] Trademark line: “Texas IP Law Help” vs. “Texas IP Law Help™” in footer

---

## 12. SEO strategy (`texasiplawhelp.com`)

**Principle:** Google indexes **HTML pages with stable text**, not private chat threads. AI drives engagement and firm leads; **SEO is won on guides, articles, and FAQ-style pages** that the AI also recommends.

### Domain & keyword split

| Domain | Owns (examples) | Avoid cannibalizing |
|--------|-----------------|---------------------|
| **texasiplawhelp.com** | Texas inventor patent help, provisional patent guide, trademark TEAS help, copyright registration inventor, “how do I file a patent in Texas” (informational) | “patent attorney Houston”, “hire patent lawyer” (firm site) |
| **texasiplawgroup.com** | Patent attorney, IP counsel Texas, fees, consultation, Susan/firm trust | Long-tail how-to guides (canonical on Help) |

Cross-link: every Help guide footer → “Need an attorney? Texas IP Law Group”; firm nav → Help for inventors.

### On-page SEO (every Help mock page → live template)

- **One H1** per page with primary keyword (e.g. guide H1: “How to file a patent — overview for Texas inventors”).
- **H2/H3** hierarchy for steps, FAQs, “Official resources”.
- **Meta title & description** unique per URL (mock: `<title>` + future `inc/seo.php` on Help WP).
- **Canonical** always `https://texasiplawhelp.com/...` (not group.com duplicate).
- **Descriptive alt text** on article/guide images.
- **Internal links:** guides ↔ articles ↔ USPTO section ↔ Ask AI anchor; use real anchor text (“provisional patent application”, not “click here”).

### Content types that rank (v1 mock + live)

1. **Common guides** (3 pillars) — long-form, steps, outbound USPTO.  
2. **Help articles** — inventor how-tos (provisional timing, patentability basics, licensing 101).  
3. **FAQ blocks** on guide pages — optional `FAQPage` JSON-LD when Q&A is visible in HTML.  
4. **Search results page** — indexable only if URLs are real content pages; prefer `/guides/patent/` over infinite query strings for SEO.

### Schema (live Help site)

- **WebSite** + **`SearchAction`** if site search is real.  
- **Organization** / **`publisher`** → Texas IP Law Group (same entity, Help as property).  
- **Article** on blog posts.  
- **FAQPage** on static FAQ sections (not on dynamic chat).  
- **BreadcrumbList** on guides and articles.

### AI + SEO together (how they reinforce)

- AI answers should **link to canonical guide URLs** on the same domain (mock demos this).  
- Curate **top 20 inventor questions** as static FAQ or short articles → rank + train KB.  
- Chat intro copy on page (visible without JS) summarizes what AI does — keywords in **static** paragraph under H1.  
- **Noindex** thin/search-only URLs if needed; **index** guides and articles.

### Performance (Core Web Vitals = SEO)

- Help site: system fonts on live WP; minimal JS; chat loads after main content (firm skill rules when ported).

---

## 10. Explicit non-goals (mock v1)

- WordPress theme second install
- Real AI API, real search index, server email
- Replacing or merging firm homepage mock
- v4 “mega search” layout that was rolled back on firm mock (unless Susan re-approves on Help-only)
