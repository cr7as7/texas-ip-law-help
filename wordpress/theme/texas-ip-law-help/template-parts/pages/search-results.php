<?php
/**
 * Search results page body.
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

// phpcs:disable WordPress.Security.NonceVerification.Recommended -- public read-only search.
$help_q     = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$help_topic = isset( $_GET['topic'] ) ? sanitize_key( wp_unslash( $_GET['topic'] ) ) : '';
$help_type  = isset( $_GET['type'] ) ? sanitize_key( wp_unslash( $_GET['type'] ) ) : '';
// phpcs:enable

if ( ! in_array( $help_topic, array( 'patents', 'trademarks', 'copyright', 'general' ), true ) ) {
	$help_topic = '';
}
if ( ! in_array( $help_type, array( 'guide', 'article', 'uspto' ), true ) ) {
	$help_type = '';
}

$help_results = help_search( $help_q, $help_topic, $help_type );
$help_action  = help_url( 'search-results' );
?>
  <div class="mock-search-hero">
    <h1>Results for: “<span id="search-results-query"><?php echo esc_html( $help_q ? $help_q : 'all resources' ); ?></span>”</h1>
  </div>
  <section class="mock-resource-search mock-resource-search--compact" aria-label="Search Texas IP Law Help">
    <div class="mock-resource-search__inner">
      <form class="mock-resource-search__form" action="<?php echo esc_url( $help_action ); ?>" method="get" role="search">
        <div><label for="sr-topic">Topic</label><select id="sr-topic" name="topic">
<?php
foreach ( array( '' => 'All', 'patents' => 'Patents', 'trademarks' => 'Trademarks', 'copyright' => 'Copyright', 'general' => 'General' ) as $help_v => $help_l ) {
	printf( '<option value="%s"%s>%s</option>', esc_attr( $help_v ), selected( $help_topic, $help_v, false ), esc_html( $help_l ) ); // phpcs:ignore WordPress.Security.EscapeOutput
}
?>
        </select></div>
        <div><label for="sr-type">Type</label><select id="sr-type" name="type">
<?php
foreach ( array( '' => 'All', 'guide' => 'Guides', 'article' => 'Articles', 'uspto' => 'USPTO' ) as $help_v => $help_l ) {
	printf( '<option value="%s"%s>%s</option>', esc_attr( $help_v ), selected( $help_type, $help_v, false ), esc_html( $help_l ) ); // phpcs:ignore WordPress.Security.EscapeOutput
}
?>
        </select></div>
        <div><label for="sr-q">Keyword</label><input id="sr-q" type="search" name="q" value="<?php echo esc_attr( $help_q ); ?>"></div>
        <button type="submit" class="mock-btn mock-btn--gold">Search</button>
      </form>
    </div>
  </section>
  <main class="mock-search-results" id="main">
    <ul class="mock-search-results__list" id="search-results-list">
<?php if ( $help_results ) : ?>
	<?php foreach ( $help_results as $help_item ) : ?>
		<?php $help_ext = ! empty( $help_item['external'] ); ?>
      <li class="mock-search-results__item">
        <p class="mock-search-results__meta"><?php echo esc_html( $help_item['type'] . ' · ' . $help_item['topic'] ); ?></p>
        <h3><a href="<?php echo esc_url( $help_item['href'] ); ?>"<?php echo $help_ext ? ' target="_blank" rel="noopener"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>><?php echo esc_html( $help_item['title'] . ( $help_ext ? ' ↗' : '' ) ); ?></a></h3>
        <p><?php echo esc_html( $help_item['desc'] ); ?></p>
      </li>
	<?php endforeach; ?>
<?php else : ?>
      <li class="mock-search-results__item">
        <h3>No matches</h3>
        <p>Try a shorter keyword, or browse the <a href="<?php echo esc_url( help_url( 'guides' ) ); ?>">guides</a> and <a href="<?php echo esc_url( help_url( 'articles' ) ); ?>">articles</a>.</p>
      </li>
<?php endif; ?>
    </ul>
  </main>
