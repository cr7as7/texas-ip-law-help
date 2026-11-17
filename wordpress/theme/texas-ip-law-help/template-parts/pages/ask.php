<?php
/**
 * Page body: ask
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
  <main id="main">
  <section class="mock-help-hero">
    <h1>Ask Texas IP Law Help AI</h1>
    <p>General questions only. Replies point to our <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>" style="color:#d4af37">guides</a> and official USPTO pages. For advice about your invention, use a free consultation.</p>
  </section>
  <div class="mock-help-layout" id="chat">
    <div class="mock-intake" id="mock-intake">
      <span class="mock-step-label" id="mock-step-1">Step 1</span>
      <h2 style="margin:0 0 8px;font-family:var(--font-display);color:var(--navy-deep)">Your question</h2>
      <?php if ( help_ai_is_live() ) : ?>
      <p style="font-size:14px;color:var(--muted);margin:0 0 16px">Your name and email stay in your browser. Your question is sent to our AI provider (xAI) to write an answer, and we do not save it. Please do not include confidential details about your invention. <a href="<?php echo esc_url( help_url( 'privacy' ) ); ?>">Privacy notice</a>.</p>
      <?php else : ?>
      <p style="font-size:14px;color:var(--muted);margin:0 0 16px">Name and email are only used to start this demo chat. This demo does not store your data on a server.</p>
      <?php endif; ?>
      <div class="mock-field">
        <label for="name">Name *</label>
        <input id="name" type="text" placeholder="Your name" autocomplete="name">
      </div>
      <div class="mock-field">
        <label for="email">Email *</label>
        <input id="email" type="email" placeholder="you@example.com" autocomplete="email">
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
          <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images' ) ); ?>/susan-avatar-cartoon.png" alt="">
          <div>
            <strong>Texas IP Law Help AI</strong>
            <small id="mock-chat-status">Click Start AI help</small>
            <span class="mock-ai-budget" id="mock-chat-budget"><?php echo help_ai_is_live() ? 'AI · 4 turns left' : 'AI demo · 4 turns left'; ?></span>
          </div>
        </div>
        <div class="mock-chat__msgs" id="mock-chat-msgs">
          <p class="mock-chat__empty">Your conversation appears here after Step 1.</p>
        </div>
        <div class="mock-chat__compose">
          <input type="text" id="mock-chat-input" placeholder="Ask a follow-up question…" disabled>
          <button type="button" class="mock-btn mock-btn--gold" id="mock-chat-send" disabled>Send</button>
        </div>
        <p style="margin:0;padding:10px 14px 14px;font-size:11px;color:var(--muted);background:#fff"><?php echo help_ai_is_live() ? 'AI answers are general information and can be wrong. Not legal advice. After a few questions, or on busy days, you get curated guide and USPTO answers instead.' : 'Demo chat: a few sample answers, then the knowledge base (guides + USPTO).'; ?></p>
      </div>
    </div>
  </div>
  <p style="text-align:center;padding:0 24px 40px;color:var(--muted)">Prefer to read first? <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">Open the guides</a> · <a href="<?php echo esc_url( help_url( 'faq' ) ); ?>">FAQ</a></p>
  </main>
