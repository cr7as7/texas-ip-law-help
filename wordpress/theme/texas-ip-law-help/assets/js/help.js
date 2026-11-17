/**
 * Texas IP Law Help — mobile menu, consultation modal, and the educational AI demo chat.
 * Site URLs come from window.helpSite (see functions.php).
 */
(function () {
  'use strict';

  var CFG = window.helpSite || {};
  var URLS = CFG.urls || {};
  var CONSULT_EMAIL = CFG.consultEmail || 'contact@texasiplawgroup.com';
  var FIRM_HOME = CFG.firmUrl || 'https://texasiplawgroup.com/';
  var AI_TURN_BUDGET = 4;

  function esc(s) {
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  var MODAL_HTML =
    '<div class="mock-modal" id="consult-modal" hidden aria-hidden="true">' +
    '<div class="mock-modal__backdrop" data-close-modal tabindex="-1"></div>' +
    '<div class="mock-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="consult-title">' +
    '<button type="button" class="mock-modal__close" data-close-modal aria-label="Close">&times;</button>' +
    '<h2 id="consult-title">Free consultation — Texas IP Law Group</h2>' +
    '<p class="mock-modal__note">Your request goes to <strong>' + esc(CONSULT_EMAIL) + '</strong>. ' +
    'Please do not include confidential details yet.</p>' +
    '<form id="consult-form" class="mock-form-consult" novalidate>' +
    '<div class="mock-field help-hp" aria-hidden="true"><label for="consult-website">Website</label><input id="consult-website" name="website" type="text" tabindex="-1" autocomplete="off"></div>' +
    '<div class="mock-field"><label for="consult-name">Name *</label><input id="consult-name" name="name" type="text" required autocomplete="name" maxlength="120"></div>' +
    '<div class="mock-field"><label for="consult-email">Email *</label><input id="consult-email" name="email" type="email" required autocomplete="email"></div>' +
    '<div class="mock-field"><label for="consult-phone">Phone</label><input id="consult-phone" name="phone" type="tel" autocomplete="tel"></div>' +
    '<div class="mock-field"><label for="consult-invention">Describe your invention or IP question *</label><textarea id="consult-invention" name="invention" required rows="4" maxlength="5000"></textarea></div>' +
    '<div class="mock-field"><span style="font-size:12px;font-weight:600;color:var(--muted)">Interested in *</span>' +
    '<div class="mock-field-checkboxes" style="margin-top:8px">' +
    '<label><input type="checkbox" name="interest[]" value="patent"> Patent</label>' +
    '<label><input type="checkbox" name="interest[]" value="trademark"> Trademark</label>' +
    '<label><input type="checkbox" name="interest[]" value="copyright"> Copyright</label>' +
    '<label><input type="checkbox" name="interest[]" value="licensing"> Licensing / strategy</label>' +
    '</div></div>' +
    '<p class="mock-consult-error" id="consult-error" role="alert" hidden></p>' +
    '<button type="submit" class="mock-btn mock-btn--gold" style="width:100%" id="consult-submit">Send to Texas IP Law Group</button>' +
    '</form>' +
    '<div id="consult-success" class="mock-consult-success" hidden>' +
    '<strong>Thank you</strong><p style="color:var(--muted);margin:0">We received your request and will reply by email.</p>' +
    '<button type="button" class="mock-btn mock-btn--gold" style="margin-top:16px" data-close-modal>Close</button></div></div></div>';

  if (!document.getElementById('consult-modal')) {
    document.body.insertAdjacentHTML('beforeend', MODAL_HTML);
  }

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
  var errorEl = document.getElementById('consult-error');
  var submitBtn = document.getElementById('consult-submit');
  var lastFocus = null;

  function openConsult() {
    if (!modal) return;
    lastFocus = document.activeElement;
    if (form) { form.hidden = false; form.reset(); }
    if (errorEl) errorEl.hidden = true;
    if (success) success.hidden = true;
    modal.hidden = false;
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('mock-modal-open');
    var first = modal.querySelector('#consult-name');
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

  function showError(msg) {
    if (!errorEl) { window.alert(msg); return; }
    errorEl.textContent = msg;
    errorEl.hidden = false;
  }

  function mailtoFallback(name, invention) {
    var subj = encodeURIComponent('Texas IP Law Help — consultation — ' + name);
    var body = encodeURIComponent('Name: ' + name + '\n\n' + invention);
    window.location.href = 'mailto:' + CONSULT_EMAIL + '?subject=' + subj + '&body=' + body;
  }

  if (form && success) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      if (errorEl) errorEl.hidden = true;
      if (!form.querySelectorAll('input[name="interest[]"]:checked').length) {
        showError('Select at least one interest.');
        return;
      }
      if (!form.reportValidity()) return;

      var data = new FormData(form);
      data.append('action', 'help_consult');
      var name = form.querySelector('#consult-name').value.trim();
      var invention = form.querySelector('#consult-invention').value.trim();

      if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Sending…'; }

      fetch(CFG.ajaxUrl, { method: 'POST', body: data, credentials: 'same-origin' })
        .then(function (res) { return res.json().catch(function () { return { success: false }; }); })
        .then(function (json) {
          if (json && json.success) {
            form.hidden = true;
            success.hidden = false;
            return;
          }
          var msg = json && json.data && json.data.message ? json.data.message : 'We could not send your request.';
          showError(msg + ' You can also email ' + CONSULT_EMAIL + '.');
        })
        .catch(function () {
          showError('Network problem. Opening your email app instead.');
          mailtoFallback(name, invention);
        })
        .then(function () {
          if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = 'Send to Texas IP Law Group'; }
        });
    });
  }

  function appendBubble(container, who, text, isAi) {
    var div = document.createElement('div');
    div.className = 'mock-bubble ' + (isAi ? 'mock-bubble--ai' : 'mock-bubble--user');
    div.innerHTML = '<div class="who">' + who + '</div>' + text;
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
  }

  var CONSULT_BTN = '<button type="button" data-open-consult style="background:none;border:none;padding:0;color:var(--gold);cursor:pointer;text-decoration:underline">';

  // Educational demo: canned answers, not a live AI model.
  var AI_REPLIES = [
    'Many inventors file a <strong>provisional</strong> first for an early date — general info only. Path: <a href="' + esc(URLS.guidePatent) + '">patent guide</a> · official <a href="https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application" target="_blank" rel="noopener">USPTO provisional ↗</a>. If investors or a public demo are involved, that is a ' + CONSULT_BTN + 'consultation</button>, not an AI answer.',
    'Public disclosure can affect patent rights. This chat cannot judge your facts. Read <a href="' + esc(URLS.provisional) + '">provisional vs. non-provisional</a> or talk to <a href="' + esc(FIRM_HOME) + '">Texas IP Law Group</a>.',
    'Names and logos are usually trademarks, not patents. Start with <a href="' + esc(URLS.guideMark) + '">the trademark guide</a>, then <a href="https://www.uspto.gov/trademarks" target="_blank" rel="noopener">USPTO TEAS ↗</a>.',
    'Copyright is the Copyright Office, not USPTO. <a href="' + esc(URLS.guideCopy) + '">Copyright guide</a> · <a href="https://www.copyright.gov/" target="_blank" rel="noopener">copyright.gov ↗</a>.'
  ];
  var KB_REPLY = '(Knowledge base) Demo limit reached — curated answer with USPTO + guides. ' + CONSULT_BTN + 'Schedule consultation</button>.';
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
      window.alert('Enter your name and a valid email to start.');
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
      window.location.replace(URLS.ask || '/ask/');
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
