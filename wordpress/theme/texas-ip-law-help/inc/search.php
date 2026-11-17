<?php
/**
 * Search over guides, articles, and official links (server-rendered; replaces the mock's JS index).
 *
 * @package Texas_IP_Law_Help
 */

defined( 'ABSPATH' ) || exit;

/**
 * Curated search index. `url` is a help_url() key or an absolute URL when `external` is true.
 *
 * @return array<int,array<string,mixed>>
 */
function help_search_index() {
	return array(
		array( 'topic' => 'patents', 'type' => 'guide', 'title' => 'How to file a patent — inventor guide', 'url' => 'guides-patent', 'desc' => 'Path: document, search, provisional vs non-provisional, USPTO apply.', 'keywords' => array( 'patent', 'provisional', 'invention', 'uspto', 'file' ) ),
		array( 'topic' => 'trademarks', 'type' => 'guide', 'title' => 'How to file a trademark', 'url' => 'guides-trademark', 'desc' => 'Clearance, TEAS, and when to call counsel.', 'keywords' => array( 'trademark', 'teas', 'brand', 'logo' ) ),
		array( 'topic' => 'copyright', 'type' => 'guide', 'title' => 'How to file a copyright', 'url' => 'guides-copyright', 'desc' => 'Copyright Office registration — not USPTO.', 'keywords' => array( 'copyright', 'registration', 'software' ) ),
		array( 'topic' => 'patents', 'type' => 'article', 'title' => 'Patent basics for inventors', 'url' => 'a-patent-basics', 'desc' => 'What to document before you file.', 'keywords' => array( 'patent', 'basics', 'document' ) ),
		array( 'topic' => 'patents', 'type' => 'article', 'title' => 'Provisional vs. non-provisional', 'url' => 'a-provisional', 'desc' => '12-month clock and public disclosure.', 'keywords' => array( 'provisional', 'non-provisional', 'investors' ) ),
		array( 'topic' => 'patents', 'type' => 'article', 'title' => 'Is my idea patentable?', 'url' => 'a-patentability', 'desc' => 'Novelty and obviousness at a high level.', 'keywords' => array( 'patentable', 'novelty', 'obvious' ) ),
		array( 'topic' => 'general', 'type' => 'article', 'title' => 'Licensing your IP', 'url' => 'a-licensing', 'desc' => 'Exclusive, field of use, royalties.', 'keywords' => array( 'license', 'licensing', 'royalty' ) ),
		array( 'topic' => 'general', 'type' => 'guide', 'title' => 'Inventor FAQ', 'url' => 'faq', 'desc' => 'Patent vs trademark vs copyright, self-file, AI limits.', 'keywords' => array( 'faq', 'help', 'difference' ) ),
		array( 'topic' => 'general', 'type' => 'guide', 'title' => 'Ask Texas IP Law Help AI', 'url' => 'ask', 'desc' => 'General IP questions (educational demo).', 'keywords' => array( 'ai', 'chat', 'ask', 'question' ) ),
		array( 'topic' => 'patents', 'type' => 'uspto', 'title' => 'Patent basics (USPTO)', 'url' => 'https://www.uspto.gov/patents/basics', 'external' => true, 'desc' => 'Official USPTO patent basics.', 'keywords' => array( 'uspto', 'basics' ) ),
		array( 'topic' => 'patents', 'type' => 'uspto', 'title' => 'Provisional application (USPTO)', 'url' => 'https://www.uspto.gov/patents/basics/types-patent-applications/provisional-application', 'external' => true, 'desc' => 'Official USPTO provisional overview.', 'keywords' => array( 'provisional', 'uspto' ) ),
		array( 'topic' => 'trademarks', 'type' => 'uspto', 'title' => 'USPTO trademarks', 'url' => 'https://www.uspto.gov/trademarks', 'external' => true, 'desc' => 'Federal trademark resources.', 'keywords' => array( 'trademark', 'uspto', 'teas' ) ),
		array( 'topic' => 'copyright', 'type' => 'uspto', 'title' => 'U.S. Copyright Office', 'url' => 'https://www.copyright.gov/', 'external' => true, 'desc' => 'Register writings, art, and software.', 'keywords' => array( 'copyright', 'eco' ) ),
	);
}

/**
 * Relevance score for one item and query.
 *
 * @param array<string,mixed> $item  Index item.
 * @param string              $query Search text.
 * @return int
 */
function help_search_score( $item, $query ) {
	if ( '' === $query ) {
		return 1;
	}
	$hay    = strtolower( $item['title'] . ' ' . $item['desc'] . ' ' . implode( ' ', (array) $item['keywords'] ) );
	$needle = strtolower( $query );
	if ( false !== strpos( $hay, $needle ) ) {
		return 10;
	}
	$score = 0;
	foreach ( preg_split( '/\s+/', $needle, -1, PREG_SPLIT_NO_EMPTY ) as $part ) {
		if ( false !== strpos( $hay, $part ) ) {
			++$score;
		}
	}
	return $score;
}

/**
 * Run a search.
 *
 * @param string $query Keyword.
 * @param string $topic patents|trademarks|copyright|general|''.
 * @param string $type  guide|article|uspto|''.
 * @return array<int,array<string,mixed>> Items with resolved `href`.
 */
function help_search( $query, $topic, $type ) {
	$items = array();
	$seen  = array();

	foreach ( help_search_index() as $item ) {
		if ( $topic && $item['topic'] !== $topic ) {
			continue;
		}
		if ( $type && $item['type'] !== $type ) {
			continue;
		}
		if ( help_search_score( $item, $query ) < 1 ) {
			continue;
		}
		$item['href']  = ! empty( $item['external'] ) ? $item['url'] : help_url( $item['url'] );
		$items[]       = $item;
		$seen[ $item['href'] ] = true;
	}

	// Articles added later in WordPress show up too.
	if ( ( ! $type || 'article' === $type ) && ( ! $topic || 'general' === $topic ) ) {
		$args = array(
			'post_type'           => 'post',
			'posts_per_page'      => 20,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		);
		if ( '' !== $query ) {
			$args['s'] = $query;
		}
		$posts = new WP_Query( $args );
		foreach ( $posts->posts as $post ) {
			$href = get_permalink( $post );
			if ( isset( $seen[ $href ] ) ) {
				continue;
			}
			$items[] = array(
				'topic' => 'general',
				'type'  => 'article',
				'title' => get_the_title( $post ),
				'desc'  => wp_strip_all_tags( get_the_excerpt( $post ) ),
				'href'  => $href,
			);
		}
	}

	return $items;
}
