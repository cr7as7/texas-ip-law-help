/**
 * texasiplawhelp.com static mock only — not the WordPress theme.
 */
(function () {
  'use strict';

  var CONSULT_EMAIL = 'contact@texasiplawgroup.com';
  var AI_TURN_BUDGET = 4;
  var FIRM_HOME = '../gold-navy/home.html';

  var MODAL_HTML =
    '<div class="mock-modal" id="consult-modal" hidden aria-hidden="true">' +
    '<div class="mock-modal__backdrop" data-close-modal tabindex="-1"></div>' +
    '<div class="mock-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="consult-title">' +
    '<button type="button" class="mock-modal__close" data-close-modal aria-label="Close">&times;</button>' +
    '<h2 id="consult-title">Free consultation — Texas IP Law Group</h2>' +
    '<p class="mock-modal__note">Preview: opens an email draft to <strong>' +
    CONSULT_EMAIL +
    '</strong>. Live site uses a secure form handler.</p>' +
    '<form id="consult-form" class="mock-form-consult">' +
    '<div class="mock-field"><label for="consult-name">Name *</label><input id="consult-name" name="name" type="text" required autocomplete="name"></div>' +
    '<div class="mock-field"><label for="consult-email">Email *</label><input id="consult-email" name="email" type="email" required autocomplete="email"></div>' +
    '<div class="mock-field"><label for="consult-phone">Phone</label><input id="consult-phone" name="phone" type="tel" autocomplete="tel"></div>' +
    '<div class="mock-field"><label for="consult-invention">Describe your invention or IP question *</label><textarea id="consult-invention" name="invention" required rows="4"></textarea></div>' +
    '<div class="mock-field"><span style="font-size:12px;font-weight:600;color:var(--muted)">Interested in *</span>' +
    '<div class="mock-field-checkboxes" style="margin-top:8px">' +
    '<label><input type="checkbox" name="interest" value="patent"> Patent</label>' +
    '<label><input type="checkbox" name="interest" value="trademark"> Trademark</label>' +
    '<label><input type="checkbox" name="interest" value="copyright"> Copyright</label>' +
    '<label><input type="checkbox" name="interest" value="licensing"> Licensing / strategy</label>' +
    '</div></div>' +
    '<button type="submit" class="mock-btn mock-btn--gold" style="width:100%">Send to Texas IP Law Group</button>' +
    '</form>' +
    '<div id="consult-success" class="mock-consult-success" hidden>' +
    '<strong>Thank you</strong><p style="color:var(--muted);margin:0">Email draft opened (or copy from your mail app).</p>' +
    '<button type="button" class="mock-btn mock-btn--gold" style="margin-top:16px" data-close-modal>Close</button></div></div></div>';

  if (!document.getElementById('consult-modal')) {
    document.body.insertAdjacentHTML('beforeend', MODAL_HTML);
  }

  var SEARCH_ITEMS = [
    { topic: 'patents', type: 'guide', title: 'How to file a patent — inventor guide', url: 'guide-patent.html', desc: 'Path: document, search, provisional vs non-provisional, USPTO apply.', keywords: ['patent', 'provisional', 'invention', 'uspto', 'file'] },
    { topic: 'trademarks', type: 'guide', title: 'How to file a trademark', url: 'guide-trademark.html', desc: 'Clearance, TEAS, and when to call counsel.', keywords: ['trademark', 'teas', 'brand', 'logo'] },
    { topic: 'copyright', type: 'guide', title: 'How to file a copyright', url: 'guide-copyright.html', desc: 'Copyright Office registration — not USPTO.', keywords: ['copyright', 'registration', 'software'] },
    { topic: 'patents', type: 'article', title: 'Patent basics for inventors', url: 'article-patent-basics.html', desc: 'What to document before you file.', keywords: ['patent', 'basics', 'document'] },
    { topic: 'patents', type: 'article', title: 'Provisional vs. non-provisional', url: 'article-provisional.html', desc: '12-month clock and public disclosure.', keywords: ['provisional', 'non-provisional', 'investors'] },
    { topic: 'patents', type: 'article', title: 'Is my idea patentable?', url: 'article-patentability.html', desc: 'Novelty and obviousness at a high level.', keywords: ['patentable', 'novelty', 'obvious'] },
    { topic: 'general', type: 'article', title: 'Licensing your IP', url: 'article-licensing.html', desc: 'Exclusive, field of use, royalties.', keywords: ['license', 'licensing', 'royalty'] },
    { topic: 'general', type: 'guide', title: 'Inventor FAQ', url: 'faq.html', desc: 'Patent vs trademark vs copyright, self-file, AI limits.', keywords: ['faq', 'help', 'difference'] },
    { topic: 'general', type: 'guide', title: 'Ask Texas IP Law Help AI', url: 'ask.html', desc: 'General IP questions (educational demo).', keywords: ['ai', 'chat', 'ask', 'question'] },
    { topic: 'patents', type: 'uspto', title: 'Patent basics (USPTO)', url: 'https://www.uspto.gov/patents/basics', external: true, desc: 'Official USPTO patent basics.', keywords: ['uspto', 'basics'] },
    { topic: 'patents', type: 'uspto', title: 'Provisional application (USPTO)', url: 'https://www.uspto.gov/patents/basics/apply/provisional-application', external: true, desc: 'Official USPTO provisional overview.', keywords: ['provisional', 'uspto'] },
    { topic: 'trademarks', type: 'uspto', title: 'USPTO trademarks', url: 'https://www.uspto.gov/trademarks', external: true, desc: 'Federal trademark resources.', keywords: ['trademark', 'uspto', 'teas'] },
    { topic: 'copyright', type: 'uspto', title: 'U.S. Copyright Office', url: 'https://www.copyright.gov/', external: true, desc: 'Register writings, art, and software.', keywords: ['copyright', 'eco'] },
  ];

  function initMobileNav() {
    document.querySelectorAll('.mock-site-header__inner').forEach(function (inner) {
      if (inner.querySelector('.mock-nav-toggle')) return;
      var nav = inner.querySelector('.mock-nav');
      if (!nav) return;
      nav.id = nav.id || 'help-primary-nav';
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'mock-nav-toggle';
      btn.setAttribute('aria-expanded', 'false');
      btn.setAttribute('aria-controls', nav.id);
      btn.innerHTML = '<span class="sr-only">Menu</span>';
      var consultBtn = inner.querySelector('[data-open-consult]');
      if (consultBtn) {
        var wrap = document.createElement('div');
        wrap.className = 'mock-site-header__consult';
        consultBtn.parentNode.insertBefore(wrap, consultBtn);
        wrap.appendChild(consultBtn);
      }
      inner.insertBefore(btn, nav);
      btn.addEventListener('click', function () {
        var open = nav.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
      nav.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
          nav.classList.remove('is-open');
          btn.setAttribute('aria-expanded', 'false');
        });
      });
    });
  }
  initMobileNav();

  var modal = document.getElementById('consult-modal');
  var form = document.getElementById('consult-form');
  var success = document.getElementById('consult-success');
  var lastFocus = null;

  function openConsult() {
    if (!modal) return;
    lastFocus = document.activeElement;
    if (form) { form.hidden = false; form.reset(); }
    if (success) success.hidden = true;
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('mock-modal-open');
    var first = modal.querySelector('input, textarea, button');
    if (first) first.focus();
  }

  function closeConsult() {
    if (!modal) return;
    modal.hidden = true;
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('mock-modal-open');
    if (lastFocus && lastFocus.focus) lastFocus.focus();
  }

  function bindConsultIn(root) {
    (root || document).querySelectorAll('[data-open-consult]').forEach(function (el) {
      if (el.getAttribute('data-consult-bound') === '1') return;
      el.setAttribute('data-consult-bound', '1');
      el.addEventListener('click', function (e) { e.preventDefault(); openConsult(); });
    });
  }
  bindConsultIn(document);
  if (modal) {
    modal.querySelectorAll('[data-close-modal]').forEach(function (el) { el.addEventListener('click', closeConsult); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && !modal.hidden) closeConsult(); });
  }

  if (form && success) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (!form.querySelectorAll('input[name="interest"]:checked').length) {
        window.alert('Select at least one interest.');
        return;
      }
      if (!form.reportValidity()) return;
      var name = form.querySelector('#consult-name').value.trim();
      var subj = encodeURIComponent('Texas IP Law Help — consultation — ' + name);
      var body = encodeURIComponent('Consultation request from Texas IP Law Help preview.\n\nName: ' + name);
      try { window.location.href = 'mailto:' + CONSULT_EMAIL + '?subject=' + subj + '&body=' + body; } catch (err) {}
      form.hidden = true;
      success.hidden = false;
    });
  }

  document.querySelectorAll('.mock-resource-search__form').forEach(function (searchForm) {
    searchForm.addEventListener('submit', function (e) {
      e.preventDefault();
      var params = new URLSearchParams();
      var q = searchForm.querySelector('[name="q"]');
      var topic = searchForm.querySelector('[name="topic"]');
      var type = searchForm.querySelector('[name="type"]');
      if (q && q.value.trim()) params.set('q', q.value.trim());
      if (topic && topic.value) params.set('topic', topic.value);
      if (type && type.value) params.set('type', type.value);
      window.location.href = (searchForm.getAttribute('action') || 'search-results.html') + (params.toString() ? '?' + params.toString() : '');
    });
  });

  function scoreItem(item, q) {
    if (!q) return 1;
    var hay = (item.title + ' ' + item.desc + ' ' + (item.keywords || []).join(' ')).toLowerCase();
    var needle = q.toLowerCase();
    if (hay.indexOf(needle) !== -1) return 10;
    return needle.split(/\s+/).filter(Boolean).filter(function (p) { return hay.indexOf(p) !== -1; }).length;
  }

  function renderSearchResults() {
    var list = document.getElementById('search-results-list');
    if (!list) return;
    var params = new URLSearchParams(window.location.search);
    var q = params.get('q') || '';
    var topic = params.get('topic') || '';
    var type = params.get('type') || '';
    var queryEl = document.getElementById('search-results-query');
    if (queryEl) queryEl.textContent = q || 'all resources';
    var items = SEARCH_ITEMS.filter(function (item) {
      if (topic && item.topic !== topic) return false;
      if (type && item.type !== type) return false;
      return scoreItem(item, q) > 0;
    });
    if (!q && !topic && !type) items = SEARCH_ITEMS.slice();
    list.innerHTML = '';
    items.forEach(function (item) {
      var li = document.createElement('li');
      li.className = 'mock-search-results__item';
      var rel = item.external ? ' target="_blank" rel="noopener"' : '';
      li.innerHTML = '<p class="mock-search-results__meta">' + item.type + ' · ' + item.topic + '</p><h3><a href="' + item.url + '"' + rel + '>' + item.title + (item.external ? ' ↗' : '') + '</a></h3><p>' + item.desc + '</p>';
      list.appendChild(li);
    });
  }
  renderSearchResults();

  function appendBubble(container, who, text, isAi) {
    var div = document.createElement('div');
    div.className = 'mock-bubble ' + (isAi ? 'mock-bubble--ai' : 'mock-bubble--user');
    div.innerHTML = '<div class="who">' + who + '</div>' + text;
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
  }

  var AI_REPLIES = [
    'Many inventors file a <strong>provisional</strong> first for an early date — general info only. Path: <a href="guide-patent.html">patent guide</a> · official <a href="https://www.uspto.gov/patents/basics/apply/provisional-application" target="_blank" rel="noopener">USPTO provisional ↗</a>. If investors or a public demo are involved, that is a <button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;text-decoration:underline">consultation</button>, not an AI answer.',
    'Public disclosure can affect patent rights. This chat cannot judge your facts. Read <a href="article-provisional.html">provisional vs. non-provisional</a> or talk to <a href="' + FIRM_HOME + '">Texas IP Law Group</a>.',
    'Names and logos are usually trademarks, not patents. Start with <a href="guide-trademark.html">the trademark guide</a>, then <a href="https://www.uspto.gov/trademarks" target="_blank" rel="noopener">USPTO TEAS ↗</a>.',
    'Copyright is the Copyright Office, not USPTO. <a href="guide-copyright.html">Copyright guide</a> · <a href="https://www.copyright.gov/" target="_blank" rel="noopener">copyright.gov ↗</a>.',
  ];
  var KB_REPLY = '(Knowledge base) Daily AI demo limit — curated answer with USPTO + guides. <button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;text-decoration:underline">Schedule consultation</button>.';
  var replyIdx = 0;
  var aiTurns = 0;
  var kbMode = false;

  var startBtn = document.getElementById('mock-start-ai');
  var chatMsgs = document.getElementById('mock-chat-msgs');
  var chatInput = document.getElementById('mock-chat-input');
  var chatSend = document.getElementById('mock-chat-send');
  var chatStatus = document.getElementById('mock-chat-status');
  var chatBudget = document.getElementById('mock-chat-budget');
  var questionEl = document.getElementById('q');
  var nameEl = document.getElementById('name');
  var emailEl = document.getElementById('email');
  var step1 = document.getElementById('mock-step-1');
  var step2 = document.getElementById('mock-step-2');
  var intake = document.getElementById('mock-intake');

  function updateBudgetUi() {
    if (!chatBudget) return;
    var left = Math.max(0, AI_TURN_BUDGET - aiTurns);
    chatBudget.textContent = kbMode ? 'Knowledge base mode (demo)' : 'AI demo · ' + left + ' turn' + (left === 1 ? '' : 's') + ' left';
    chatBudget.classList.toggle('is-kb', kbMode);
  }

  function startAiChat() {
    if (!startBtn || !chatMsgs) return;
    if (!nameEl.value.trim() || !emailEl.value.trim() || emailEl.value.indexOf('@') === -1) {
      window.alert('Enter your name and a valid email to start (mock intake).');
      return;
    }
    var q = questionEl && questionEl.value.trim();
    if (!q) { window.alert('Enter your first question.'); return; }
    chatMsgs.innerHTML = '';
    appendBubble(chatMsgs, 'You', escapeHtml(q).replace(/\n/g, '<br>'), false);
    aiTurns = 1;
    kbMode = false;
    updateBudgetUi();
    setTimeout(function () {
      appendBubble(chatMsgs, 'Texas IP Law Help AI', AI_REPLIES[0], true);
      bindConsultIn(chatMsgs);
      if (chatStatus) chatStatus.textContent = '● Demo AI — educational only';
      chatInput.disabled = false;
      chatSend.disabled = false;
      if (step1) step1.classList.add('is-done');
      if (step2) step2.classList.add('is-done');
      if (intake) intake.classList.add('is-started');
      replyIdx = 1;
    }, 450);
  }

  if (startBtn) startBtn.addEventListener('click', startAiChat);

  function escapeHtml(s) {
    return s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
  }

  function sendFollowUp() {
    if (!chatInput || chatInput.disabled) return;
    var text = chatInput.value.trim();
    if (!text) return;
    appendBubble(chatMsgs, 'You', escapeHtml(text), false);
    chatInput.value = '';
    aiTurns += 1;
    if (aiTurns > AI_TURN_BUDGET) kbMode = true;
    updateBudgetUi();
    setTimeout(function () {
      if (kbMode) {
        appendBubble(chatMsgs, 'Texas IP Law Help (KB)', KB_REPLY, true);
      } else {
        appendBubble(chatMsgs, 'Texas IP Law Help AI', AI_REPLIES[replyIdx % AI_REPLIES.length], true);
        replyIdx += 1;
      }
      bindConsultIn(chatMsgs);
    }, 500);
  }
  if (chatSend) chatSend.addEventListener('click', sendFollowUp);
  if (chatInput) {
    chatInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { e.preventDefault(); sendFollowUp(); }
    });
  }

  if (chatBudget) updateBudgetUi();
  if (window.location.hash === '#chat') {
    if (!document.getElementById('chat')) {
      window.location.replace('ask.html');
    } else {
      setTimeout(function () {
        var el = document.getElementById('chat');
        if (el) el.scrollIntoView({ behavior: 'smooth' });
      }, 200);
    }
  }

  if (document.getElementById('chat')) {
    var fab = document.querySelector('.mock-quick-answer');
    if (fab) fab.hidden = true;
  }
})();
