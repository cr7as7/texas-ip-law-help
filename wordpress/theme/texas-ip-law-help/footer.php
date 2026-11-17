<?php
/**
 * Site footer.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;
?>
  <footer class="mock-footer">
    <div class="mock-footer__inner">
      <div>
        <strong style="color:#fff;font-family:var(--font-display)">Texas IP Law Help</strong>
        <p>Educational inventor resource by Texas IP Law Group. Not a government site. Not legal advice.</p>
      </div>
      <div>
        <h4>This site</h4>
        <ul>
          <li><a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">Guides</a></li>
          <li><a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">Articles</a></li>
          <li><a href="<?php echo esc_url( help_url( 'resources' ) ); ?>">Official resources</a></li>
          <li><a href="<?php echo esc_url( help_url( 'ask' ) ); ?>">Ask AI</a></li>
          <li><a href="<?php echo esc_url( help_url( 'faq' ) ); ?>">FAQ</a></li>
          <li><a href="<?php echo esc_url( help_url( 'contact' ) ); ?>">Contact</a></li>
        </ul>
      </div>
      <div>
        <h4>Texas IP Law Group</h4>
        <ul>
          <li><a href="https://texasiplawgroup.com/" target="_blank" rel="noopener">texasiplawgroup.com ↗</a></li>
          <li><button type="button" data-open-consult style="background:none;border:none;padding:0;color:rgba(255,255,255,0.85);cursor:pointer;font:inherit">Free consultation</button></li>
          <li><a href="tel:7135188837" style="color:rgba(255,255,255,0.85)">713-518-8837</a></li>
          <li><a href="mailto:contact@texasiplawgroup.com" style="color:rgba(255,255,255,0.85)">contact@texasiplawgroup.com</a></li>
        </ul>
      </div>
      <div>
        <h4>Legal</h4>
        <ul>
          <li><a href="<?php echo esc_url( help_url( 'about' ) ); ?>">About this site</a></li>
          <li><a href="<?php echo esc_url( help_url( 'disclaimer' ) ); ?>">Disclaimer</a></li>
          <li><a href="https://www.uspto.gov/" target="_blank" rel="noopener">USPTO.gov ↗</a></li>
          <li><a href="https://www.copyright.gov/" target="_blank" rel="noopener">Copyright.gov ↗</a></li>
        </ul>
      </div>
    </div>
    <p class="mock-footer__bottom">© Texas IP Law Group · Educational only · Not legal advice · texasiplawhelp.com</p>
  </footer>
  <a class="mock-quick-answer" href="<?php echo esc_url( help_url( 'ask' ) ); ?>">
    <span class="mock-quick-answer__bolt" aria-hidden="true">⚡</span>
    Ask AI
  </a>
<?php wp_footer(); ?>
</body>
</html>
