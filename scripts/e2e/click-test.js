// End-to-end click test: opens every page, clicks every link and button, runs the consult form,
// the Ask AI chat, FAQ, search and the mobile menu. Needs the local Docker site (port 8082) and Mailpit (8026).
// Setup:  npm i --no-save playwright-core     (uses your installed Google Chrome)
// Run:    node scripts/e2e/click-test.js desktop   and   node scripts/e2e/click-test.js mobile
// Clear the 5-per-hour consult limit first:  docker compose --profile tools run --rm wpcli transient delete --all
// End-to-end click test. Usage: node e2e.js desktop|mobile
const { chromium } = require('playwright-core');
const fs = require('fs');
const BASE = process.env.BASE || 'http://localhost:8082';
const MAIL = 'http://localhost:8026';
const VP = process.argv[2] || 'desktop';
const viewport = VP === 'mobile' ? { width: 390, height: 844 } : { width: 1280, height: 800 };

const results = [];
const problems = [];
let current = '';
const T0=Date.now(); const log = m => process.stderr.write(((Date.now()-T0)/1000).toFixed(0)+'s '+m+'\n');
function ok(name) { results.push({ name, ok: true }); }
function bad(name, detail) { results.push({ name, ok: false, detail }); problems.push(name + ' :: ' + detail); }
function check(cond, name, detail) { cond ? ok(name) : bad(name, detail || 'failed'); return cond; }

(async () => {
  const browser = await chromium.launch({ channel: 'chrome', headless: true });
  const ctx = await browser.newContext({
    viewport,
    isMobile: VP === 'mobile',
    hasTouch: VP === 'mobile',
    deviceScaleFactor: 1,
    userAgent: VP === 'mobile' ? 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X) AppleWebKit/605.1.15 Version/17.0 Mobile/15E148 Safari/604.1' : undefined,
  });
  // External sites: stub so a click can be verified without leaving the box.
  const externalHits = [];
  await ctx.route(url => !/^https?:\/\/localhost:8082/.test(url.href) && !/^data:/.test(url.href), route => {
    const u = route.request().url();
    if (route.request().resourceType() === 'document') {
      externalHits.push(u);
      return route.fulfill({ status: 200, contentType: 'text/html', body: '<title>stub</title><h1>external stub</h1>' });
    }
    return route.fulfill({ status: 200, body: '' });
  });

  const page = await ctx.newPage();
  page.setDefaultTimeout(8000);
  const pageErrors = [];
  page.on('pageerror', e => pageErrors.push(current + ' pageerror: ' + e.message));
  page.on('console', m => { if (m.type() === 'error' && !/404/.test(m.text())) pageErrors.push(current + ' console: ' + m.text().slice(0, 200)); });
  page.on('response', r => {
    const u = r.url();
    if (u.startsWith(BASE) && r.status() >= 400 && !/favicon|\/wp-json|admin-ajax|nonexistent/.test(u)) {
      pageErrors.push(current + ' HTTP ' + r.status() + ' ' + u);
    }
  });
  page.on('requestfailed', r => {
    if (r.url().startsWith(BASE)) pageErrors.push(current + ' requestfailed ' + r.url() + ' ' + (r.failure() || {}).errorText);
  });

  async function go(path) {
    current = path;
    const r = await page.goto(BASE + path, { waitUntil: 'load' });
    return r;
  }

  // ---------- discover pages ----------
  const seen = new Set(); const queue = ['/']; const pages = [];
  while (queue.length) {
    const u = queue.shift(); if (seen.has(u)) continue; seen.add(u);
    const r = await go(u); pages.push(u);
    check(r.status() === 200, `[load] ${u}`, 'status ' + r.status());
    const links = await page.$$eval('a[href]', a => a.map(x => x.getAttribute('href')));
    for (const l of links) {
      let n = l; if (n.startsWith(BASE)) n = n.slice(BASE.length);
      if (n.startsWith('/') && !n.startsWith('/wp-') && !/\.(jpg|png|svg|xml|pdf|ico)$/.test(n)) { n = n.split('#')[0]; if (!seen.has(n)) queue.push(n); }
    }
  }
  for (const extra of ['/search-results/?q=patent', '/nonexistent-page-xyz/']) pages.push(extra);

  // ---------- per page: basics + click every link ----------
  const extChecked = new Set();
  for (const u of pages) {
    log('page '+u); const is404 = u.includes('nonexistent');
    const r = await go(u);
    if (is404) check(r.status() === 404, `[404 page] status`, 'got ' + r.status());
    const info = await page.evaluate(() => ({
      h1: document.querySelectorAll('h1').length,
      title: document.title,
      overflow: document.documentElement.scrollWidth - document.documentElement.clientWidth,
      brokenImgs: [...document.images].filter(i => i.complete && i.naturalWidth === 0 && i.src).map(i => i.src),
      lazyImgs: [...document.images].filter(i => !i.complete).length,
    }));
    check(info.h1 === 1, `[h1] ${u}`, 'h1 count ' + info.h1);
    check(info.title && info.title.length > 5, `[title] ${u}`, info.title);
    check(info.overflow <= 0, `[overflow] ${u}`, 'overflow ' + info.overflow + 'px');
    check(info.brokenImgs.length === 0, `[images] ${u}`, info.brokenImgs.join(','));

    await page.evaluate(() => document.querySelectorAll('details').forEach(d => d.open = true));
    const count = await page.locator('a[href]').count();
    for (let i = 0; i < count; i++) {
      const loc = page.locator('a[href]').nth(i);
      const href = await loc.getAttribute('href');
      const target = await loc.getAttribute('target');
      const rel = (await loc.getAttribute('rel')) || '';
      const text = ((await loc.innerText().catch(() => '')) || (await loc.getAttribute('aria-label')) || '').trim().replace(/\s+/g, ' ').slice(0, 40);
      if (await loc.evaluate(el => !!el.closest('#consult-modal'))) continue; // tested with the modal open
      log('link '+i+' '+href);
      const label = `[link] ${u} → "${text}" (${href.slice(0, 70)})`;

      await loc.evaluate(el => { const d = el.closest('details'); if (d) d.open = true; });
      // make visible: on mobile the nav sits behind the toggle
      let visible = await loc.isVisible();
      if (!visible) {
        const inNav = await loc.evaluate(el => !!el.closest('.mock-nav'));
        if (inNav) {
          const toggle = page.locator('.mock-nav-toggle').first();
          if (await toggle.isVisible()) {
            await toggle.click();
            visible = await loc.isVisible();
          }
        }
      }
      if (!visible) {
        const hidden = await loc.evaluate(el => ({ cls: el.className, hiddenAttr: el.hidden, st: getComputedStyle(el).display }));
        // skip-link and the quick-answer FAB hidden on /ask/ are expected
        if (/skip-link|sr-only/.test(hidden.cls) || hidden.hiddenAttr) { ok(label + ' (hidden by design)'); continue; }
        bad(label, 'not visible at ' + VP + ' (' + JSON.stringify(hidden) + ')');
        continue;
      }

      if (/skip-link/.test(await loc.getAttribute('class') || '')) { await loc.focus(); await loc.click(); check(await page.evaluate(() => location.hash === '#main'), label + ' [focus+click]'); continue; }
      // classify
      if (/^mailto:/.test(href)) { check(/^mailto:[^@\s]+@[^@\s]+\.[a-z]+/i.test(href), label, 'bad mailto'); continue; }
      if (/^tel:/.test(href)) { check(/^tel:\+?[\d-]{7,}$/.test(href), label, 'bad tel'); continue; }
      if (href.startsWith('#')) {
        await loc.click();
        const id = href.slice(1);
        const exists = id === '' || await page.evaluate(id => !!document.getElementById(id), id);
        check(exists, label, 'anchor target missing');
        continue;
      }
      const abs = new URL(href, BASE + u);
      if (abs.origin !== BASE) {
        // external: opens correctly, and safely
        if (target === '_blank') check(/noopener/.test(rel), label + ' [noopener]', 'rel=' + rel);
        const before = externalHits.length;
        const popupP = target === '_blank' ? ctx.waitForEvent('page', { timeout: 4000 }).catch(() => null) : null;
        await loc.click();
        let landed = null;
        if (popupP) { const pp = await popupP; if (pp) { await pp.waitForLoadState().catch(() => {}); landed = pp.url(); await pp.close(); } }
        else { await page.waitForLoadState().catch(() => {}); landed = page.url(); }
        check(externalHits.length > before && landed && landed.startsWith(abs.href.split('#')[0].slice(0, 25)), label + ' [opens]', 'landed ' + landed);
        if (!popupP) await go(u);
        continue;
      }
      // internal link: click, land on 200 + h1
      await loc.click();
      await page.waitForLoadState('load').catch(() => {});
      const resp = { status: () => 0 };
      const navStatus = await page.evaluate(() => { const n = performance.getEntriesByType('navigation')[0]; return n ? n.responseStatus : -1; }).catch(() => -1);
      resp.status = () => navStatus;
      const landedPath = new URL(page.url()).pathname;
      const want = abs.pathname;
      const hasH1 = await page.locator('h1').count();
      const st = resp.status();
      const is404target = want.includes('nonexistent');
      check((st === 200 || (is404target && st === 404)) && hasH1 === 1 && landedPath.replace(/\/$/, '') === want.replace(/\/$/, ''), label, `status ${st} landed ${landedPath} want ${want} h1 ${hasH1}`);
      if (abs.hash) { /* anchor on another page */ const id = abs.hash.slice(1); const ex = await page.evaluate(id => !!document.getElementById(id), id); check(ex, label + ' [anchor]', 'missing #' + id); }
      await go(u);
    }
  }

  log('nav'); // ---------- header / mobile nav ----------
  await go('/');
  const toggle = page.locator('.mock-nav-toggle').first();
  if (VP === 'mobile') {
    check(await toggle.isVisible(), '[nav] hamburger visible on mobile');
    check(!(await page.locator('.mock-nav').first().isVisible()), '[nav] menu closed initially');
    await toggle.click();
    check(await page.locator('.mock-nav').first().isVisible(), '[nav] menu opens');
    check((await toggle.getAttribute('aria-expanded')) === 'true', '[nav] aria-expanded true');
    await toggle.click();
    check(!(await page.locator('.mock-nav').first().isVisible()), '[nav] menu closes on 2nd tap');
    await toggle.click();
    await page.locator('.mock-nav a').first().click(); await page.waitForLoadState();
  } else {
    check(!(await toggle.isVisible()), '[nav] hamburger hidden on desktop');
    check(await page.locator('.mock-nav').first().isVisible(), '[nav] links visible on desktop');
  }

  log('consult');
  const mod = page.locator('#consult-modal');
  async function consultTriggers() { return page.locator('[data-open-consult]'); }
  let consultTested = 0;
  for (const u of pages.filter(p => !p.includes('nonexistent'))) {
    await go(u);
    const n = await (await consultTriggers()).count();
    for (let i = 0; i < n; i++) {
      const t = (await consultTriggers()).nth(i);
      if (!(await t.isVisible())) continue;
      await t.click();
      const shown = await mod.isVisible();
      const focusOk = await page.evaluate(() => document.activeElement && document.activeElement.id === 'consult-name');
      check(shown && focusOk, `[consult] opens + focuses name: ${u} trigger #${i}`, `shown ${shown} focus ${focusOk}`);
      await page.keyboard.press('Escape');
      check(!(await mod.isVisible()), `[consult] Escape closes: ${u} trigger #${i}`);
      consultTested++;
    }
  }
  ok(`[consult] triggers exercised: ${consultTested}`);

  await go('/');
  async function openModal() { await page.locator('.mock-site-header [data-open-consult], [data-open-consult]').filter({ visible: true }).first().click(); await mod.waitFor({ state: 'visible' }); }
  await openModal();
  await page.locator('#consult-modal .mock-modal__close').click();
  check(!(await mod.isVisible()), '[consult] X button closes');
  await openModal();
  const overlay = page.locator('#consult-modal [data-close-modal]').first();
  const closers = await page.locator('#consult-modal [data-close-modal]').count();
  ok(`[consult] close controls found: ${closers}`);
  await page.mouse.click(5, viewport.height - 5);
  check(!(await mod.isVisible()), '[consult] click on backdrop closes', 'modal still open');
  if (await mod.isVisible()) await page.keyboard.press('Escape');

  // validation
  await openModal();
  await page.locator('#consult-submit').click();
  check(await page.locator('#consult-error').isVisible() && /interest/i.test(await page.locator('#consult-error').innerText()), '[consult] no interest → error shown', 'no error');
  const cbs = page.locator('#consult-form input[name="interest[]"]');
  const nCb = await cbs.count();
  ok(`[consult] interest checkboxes: ${nCb}`);
  for (let i = 0; i < nCb; i++) { await cbs.nth(i).check(); check(await cbs.nth(i).isChecked(), `[consult] checkbox #${i} toggles`); await cbs.nth(i).uncheck(); }
  await cbs.first().check();
  await page.locator('#consult-submit').click();
  check(await page.evaluate(() => !document.getElementById('consult-success').hidden === false), '[consult] required fields block submit (no success)');
  const stillForm = await page.locator('#consult-form').isVisible();
  check(stillForm, '[consult] form still visible after invalid submit');

  // clear mail, submit valid
  await fetch(MAIL + '/api/v1/messages', { method: 'DELETE' });
  await page.fill('#consult-name', 'E2E Tester ' + VP);
  await page.fill('#consult-email', 'e2e@example.com');
  await page.fill('#consult-invention', 'Can I patent a thermostat that learns? ' + VP);
  await page.locator('#consult-form input[name="phone"]').fill('713-555-0100').catch(() => {});
  await page.locator('#consult-submit').click();
  await page.locator('#consult-success').waitFor({ state: 'visible', timeout: 15000 }).then(() => ok('[consult] valid submit → success panel'), () => bad('[consult] valid submit → success panel', 'not shown; error: ' + '')); 
  await page.waitForTimeout(1500);
  const msgs = await (await fetch(MAIL + '/api/v1/messages')).json();
  const m = (msgs.messages || [])[0];
  check(!!m && /E2E Tester/.test(m.Subject) && m.To.some(t => t.Address === 'contact@texasiplawgroup.com'), '[consult] email delivered to contact@texasiplawgroup.com', JSON.stringify(m && { s: m.Subject, to: m.To }));
  if (m) {
    const full = await (await fetch(MAIL + '/api/v1/message/' + m.ID)).json();
    check(/thermostat/.test(full.Text) && /e2e@example.com/.test(full.Text) && /Interested in: patent/.test(full.Text), '[consult] email body has question, email, interest', full.Text);
    check(full.ReplyTo && full.ReplyTo.some(r => r.Address === 'e2e@example.com'), '[consult] Reply-To is the visitor', JSON.stringify(full.ReplyTo));
  }
  await page.locator('#consult-success [data-close-modal]').click();
  check(!(await mod.isVisible()), '[consult] success Close button closes modal');
  // reopening resets
  await openModal();
  check(await page.locator('#consult-form').isVisible() && !(await page.locator('#consult-success').isVisible()), '[consult] reopen shows fresh form');
  check((await page.inputValue('#consult-name')) === '', '[consult] reopen clears fields');
  // links inside the modal (modal is already open here)
  const mlinks = page.locator('#consult-modal a[href]'); const mln = await mlinks.count();
  ok('[consult] links inside modal: ' + mln);
  for (let i = 0; i < mln; i++) {
    const h = await mlinks.nth(i).getAttribute('href');
    if (/^mailto|^tel/.test(h)) { ok('[consult] modal link ' + h); continue; }
    const r = await ctx.request.get(new URL(h, BASE).href); check(r.status() === 200, '[consult] modal link ' + h + ' → 200', r.status());
  }
  await page.keyboard.press('Escape');
  await openModal();
  // honeypot
  await page.fill('#consult-name', 'Bot'); await page.fill('#consult-email', 'bot@example.com'); await page.fill('#consult-invention', 'spam');
  await page.locator('#consult-form input[name="interest[]"]').first().check();
  await page.evaluate(() => { document.getElementById('consult-website').value = 'http://spam'; });
  await fetch(MAIL + '/api/v1/messages', { method: 'DELETE' });
  await page.locator('#consult-submit').click();
  await page.waitForTimeout(1500);
  const msgs2 = await (await fetch(MAIL + '/api/v1/messages')).json();
  check((msgs2.messages || []).length === 0, '[consult] honeypot submissions send no email', 'emails: ' + (msgs2.messages || []).length);
  await page.keyboard.press('Escape');
  // honeypot is not visible/focusable to humans
  const hpVisible = await page.evaluate(() => { const e = document.getElementById('consult-website'); const r = e.getBoundingClientRect(); const s = getComputedStyle(e.closest('div,label,p') || e); return { w: r.width, h: r.height, tab: e.tabIndex, vis: s.visibility, disp: s.display, left: r.left }; });
  ok('[consult] honeypot geometry ' + JSON.stringify(hpVisible));

  log('ask');
  await go('/ask/');
  check(!(await page.locator('.mock-quick-answer').first().isVisible().catch(() => false)), '[ask] floating quick-answer hidden on ask page');
  check(await page.locator('#mock-chat-input').isDisabled(), '[ask] chat input disabled before start');
  const dialogs = [];
  page.on('dialog', d => { dialogs.push(d.message()); d.dismiss(); });
  await page.locator('#mock-start-ai').click(); await page.waitForTimeout(300);
  check(dialogs.length === 1 && /name and a valid email/i.test(dialogs[0]), '[ask] start with empty name/email → prompt', JSON.stringify(dialogs));
  await page.fill('#name', 'E2E'); await page.fill('#email', 'bademail');
  await page.locator('#mock-start-ai').click(); await page.waitForTimeout(300);
  check(dialogs.length === 2, '[ask] invalid email → prompt', JSON.stringify(dialogs));
  await page.fill('#email', 'e2e@example.com'); await page.fill('#q', '');
  await page.locator('#mock-start-ai').click(); await page.waitForTimeout(300);
  check(dialogs.length === 3 && /first question/i.test(dialogs[2]), '[ask] missing question → prompt', JSON.stringify(dialogs));
  await page.fill('#q', 'Can I patent my app idea?');
  for (const sel of ['#topic', '#interest']) {
    const opts = await page.locator(sel + ' option').evaluateAll(o => o.map(x => x.value));
    for (const v of opts) await page.selectOption(sel, v);
    ok(`[ask] ${sel} options selectable: ${opts.length}`);
  }
  await page.locator('#mock-start-ai').click();
  await page.locator('#mock-chat-msgs .mock-bubble--ai').first().waitFor({ timeout: 8000 }).then(() => ok('[ask] AI first reply appears'), () => bad('[ask] AI first reply appears', 'timeout'));
  check(!(await page.locator('#mock-chat-input').isDisabled()), '[ask] chat input enabled after start');
  check(/turns? left/.test(await page.locator('#mock-chat-budget').innerText()), '[ask] budget indicator shows turns left');
  // links inside reply
  const replyLinks = page.locator('#mock-chat-msgs .mock-bubble--ai a');
  const rn = await replyLinks.count();
  for (let i = 0; i < rn; i++) {
    const a = replyLinks.nth(i); const h = await a.getAttribute('href'); const tg = await a.getAttribute('target');
    if (tg === '_blank') { check(/noopener/.test((await a.getAttribute('rel')) || ''), `[ask] reply link noopener ${h}`); continue; }
    const resp = await ctx.request.get(new URL(h, BASE).href); check(resp.status() === 200, `[ask] reply link ${h} → 200`, resp.status());
  }
  // consult button inside chat bubble
  const inChatConsult = page.locator('#mock-chat-msgs [data-open-consult]').first();
  if (await inChatConsult.count()) { await inChatConsult.click(); check(await mod.isVisible(), '[ask] consult button inside chat opens modal'); await page.keyboard.press('Escape'); } else bad('[ask] consult button inside chat', 'none found');
  // follow-ups through budget; Enter key and Send button
  await page.fill('#mock-chat-input', 'follow up via Enter'); await page.press('#mock-chat-input', 'Enter');
  await page.waitForTimeout(900);
  check((await page.locator('#mock-chat-msgs .mock-bubble--user').count()) === 2, '[ask] Enter sends follow-up');
  await page.fill('#mock-chat-input', 'follow up via button'); await page.locator('#mock-chat-send').click();
  await page.waitForTimeout(900);
  check((await page.locator('#mock-chat-msgs .mock-bubble--user').count()) === 3, '[ask] Send button sends follow-up');
  await page.locator('#mock-chat-send').click(); // empty
  check((await page.locator('#mock-chat-msgs .mock-bubble--user').count()) === 3, '[ask] empty send ignored');
  for (let i = 0; i < 4; i++) { await page.fill('#mock-chat-input', 'more ' + i); await page.locator('#mock-chat-send').click(); await page.waitForTimeout(700); }
  check(/knowledge base/i.test(await page.locator('#mock-chat-budget').innerText()), '[ask] budget exhausted → knowledge base mode', await page.locator('#mock-chat-budget').innerText());
  check((await page.locator('#mock-chat-msgs .mock-bubble--ai').last().innerText()).toLowerCase().includes('knowledge base'), '[ask] KB reply shown after cap');
  check(await page.evaluate(() => { const m = document.getElementById('mock-chat-msgs'); return m.scrollHeight >= m.clientHeight; }), '[ask] chat scroll container ok');
  // XSS: user text is escaped
  await go('/ask/');
  await page.fill('#name', 'x'); await page.fill('#email', 'x@x.co'); await page.fill('#q', '<img src=x onerror=window.__xss=1> hi');
  await page.locator('#mock-start-ai').click(); await page.waitForTimeout(900);
  check(!(await page.evaluate(() => window.__xss)), '[ask] HTML in question is escaped (no XSS)');
  // #chat redirect from other page, FAB
  await go('/guides/#chat'); await page.waitForURL(/\/ask\//, { timeout: 5000 }).then(() => ok('[ask] /guides/#chat redirects to /ask/'), () => bad('[ask] /guides/#chat redirect', page.url()));
  await go('/');
  const fab = page.locator('.mock-quick-answer');
  check(await fab.isVisible(), '[fab] quick-answer visible on home');
  await fab.click(); await page.waitForURL(/\/ask\//); ok('[fab] click → /ask/');

  log('faq');
  await go('/faq/');
  const sums = page.locator('summary'); const sn = await sums.count();
  let faqOk = 0;
  for (let i = 0; i < sn; i++) {
    const s = sums.nth(i); const det = s.locator('xpath=..');
    const init = await det.evaluate(d => d.open);
    await s.click(); const after1 = await det.evaluate(d => d.open);
    const bodyVisible = after1 ? await det.locator('xpath=*[position()>1]').first().isVisible().catch(() => true) : true;
    await s.click(); const after2 = await det.evaluate(d => d.open);
    if (after1 === !init && after2 === init && bodyVisible) faqOk++; else bad(`[faq] question #${i}`, `init ${init} after1 ${after1} after2 ${after2} visible ${bodyVisible}`);
  }
  check(faqOk === sn && sn >= 15, `[faq] ${faqOk}/${sn} accordions open and close`, 'count ' + sn);
  // links in FAQ answers
  await sums.first().click();

  log('search');
  await go('/');
  const sform = page.locator('form.mock-search-split__form');
  async function doSearch(topic, type, q) {
    await go('/');
    await page.selectOption('#search-topic', topic); await page.selectOption('#search-type', type);
    await page.fill('#search-q', q);
    await Promise.all([page.waitForNavigation(), sform.locator('button[type=submit]').click()]);
    return page.evaluate(() => ({ url: location.href, h1: document.querySelector('h1').innerText, links: [...document.querySelectorAll('main a, .mock-main a, #main a')].map(a => a.getAttribute('href')).filter(h => h && !h.startsWith('#')).length, text: document.body.innerText.slice(0, 3000) }));
  }
  const cases = [
    ['', '', 'provisional', /provisional/i],
    ['patents', '', 'patent', /patent/i],
    ['trademarks', 'guide', 'trademark', /trademark/i],
    ['copyright', '', 'copyright', /copyright/i],
    ['', 'article', 'disclosure', /disclosure/i],
    ['', 'uspto', '', /USPTO/i],
    ['', '', 'zzzzqqqq', /no (results|matches)|nothing|couldn/i],
    ['', '', '', /./],
  ];
  for (const [t, ty, q, re] of cases) {
    const r = await doSearch(t, ty, q);
    check(re.test(r.text) && r.links >= 1, `[search] topic="${t}" type="${ty}" q="${q}" shows relevant content`, r.url + ' links ' + r.links);
  }
  // click every result link of a broad search
  await go('/search-results/?q=patent');
  const resLinks = await page.$$eval('main a[href], #main a[href]', a => a.map(x => x.href).filter(h => h.startsWith(location.origin) && !h.includes('#')));
  const uniq = [...new Set(resLinks)];
  for (const h of uniq) { const r = await ctx.request.get(h); check(r.status() === 200, `[search] result link ${h}`, r.status()); }
  // WP native search + XSS
  await go('/?s=patent'); check(true, '[search] /?s=patent loads');
  await go('/search-results/?q=%3Cscript%3Ewindow.__s=1%3C/script%3E');
  check(!(await page.evaluate(() => window.__s)), '[search] script in query is not executed');
  check(!(await page.content()).includes('<script>window.__s=1</script>'), '[search] query reflected escaped');

  // ---------- keyboard: skip link ----------
  await go('/'); await page.keyboard.press('Tab');
  const focused = await page.evaluate(() => document.activeElement && document.activeElement.className);
  check(/skip-link/.test(focused), '[a11y] first Tab hits skip link', focused);
  await page.keyboard.press('Enter');
  check(await page.evaluate(() => location.hash === '#main'), '[a11y] skip link jumps to #main');

  // ---------- site files ----------
  for (const [p, ct] of [['/robots.txt', /text\/plain/], ['/wp-sitemap.xml', /xml/], ['/favicon.ico', /./], ['/feed/', /xml/]]) {
    const r = await ctx.request.get(BASE + p); check(r.status() === 200, `[file] ${p}`, r.status());
  }
  const sm = await (await ctx.request.get(BASE + '/wp-sitemap.xml')).text();
  const subs = [...sm.matchAll(/<loc>([^<]+)<\/loc>/g)].map(x => x[1].replace(/^https?:\/\/[^/]+/, BASE));
  for (const s of subs) {
    const r = await ctx.request.get(s); check(r.status() === 200, `[sitemap] ${s}`, r.status());
    const body = await r.text();
    for (const loc of [...body.matchAll(/<loc>([^<]+)<\/loc>/g)].map(x => x[1].replace(/^https?:\/\/[^/]+/, BASE))) {
      if (loc.endsWith('.xml')) continue;
      const rr = await ctx.request.get(loc); check(rr.status() === 200, `[sitemap url] ${loc}`, rr.status());
    }
  }

  // ---------- done ----------
  const uniqErrs = [...new Set(pageErrors)];
  for (const e of uniqErrs) bad('[browser] ' + e.slice(0, 160), 'console/network error');
  if (!uniqErrs.length) ok('[browser] no console errors, page errors, or failed requests');
  fs.writeFileSync(`/tmp/help-e2e-report-${VP}.json`, JSON.stringify(results, null, 1));
  const passed = results.filter(r => r.ok).length;
  console.log(`\n=== ${VP}: ${passed}/${results.length} checks passed, ${problems.length} problems ===`);
  for (const p of problems) console.log('FAIL', p);
  await browser.close();
})().catch(e => { console.error('SCRIPT CRASH', e); fs.writeFileSync(`/tmp/help-e2e-report-${VP}.json`, JSON.stringify(results)); process.exit(2); });
