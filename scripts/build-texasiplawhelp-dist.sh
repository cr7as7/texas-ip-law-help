#!/usr/bin/env bash
# Self-contained bundle for texasiplawhelp.com (static preview / staging).
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SRC="$ROOT/static"
DIST="$SRC/dist"
ASSETS="$SRC/assets/images"

rm -rf "$DIST"
mkdir -p "$DIST/assets/images/blog"

for f in index.html about.html articles.html disclaimer.html search-results.html \
  guide-patent.html guide-trademark.html guide-copyright.html \
  guides.html ask.html resources.html faq.html contact.html \
  article-patent-basics.html article-provisional.html article-patentability.html article-licensing.html \
  AI-COST-BASIS-Susan.html; do
  [[ -f "$SRC/$f" ]] && cp "$SRC/$f" "$DIST/"
done
cp "$SRC/help.css" "$SRC/help.js" "$DIST/"

cp -R "$ASSETS/." "$DIST/assets/images/" 2>/dev/null || true

if [[ "$(uname)" == Darwin ]]; then
  for html in "$DIST"/*.html; do
    sed -i '' 's|../../wp-content/themes/texas-ip-law/assets/images|assets/images|g' "$html"
    sed -i '' 's|../gold-navy/mock.css|help.css|g' "$html"
  done
else
  for html in "$DIST"/*.html; do
    sed -i 's|../../wp-content/themes/texas-ip-law/assets/images|assets/images|g' "$html"
    sed -i 's|../gold-navy/mock.css|help.css|g' "$html"
  done
fi

echo "Built: $DIST ($(find "$DIST" -type f | wc -l | tr -d ' ') files)"