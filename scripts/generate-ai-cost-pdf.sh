#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
SRC="$ROOT/static/AI-COST-BASIS-Susan.html"
OUT="$ROOT/exports/Texas-IP-Law-Help-AI-Cost-Basis.pdf"
CHROME="/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"

"$ROOT/scripts/build-texasiplawhelp-dist.sh"
SRC="$ROOT/static/dist/AI-COST-BASIS-Susan.html"
[[ -f "$SRC" ]] || SRC="$ROOT/static/AI-COST-BASIS-Susan.html"
mkdir -p "$ROOT/exports"

[[ -x "$CHROME" ]] || { echo "Install Chrome or open $SRC → Print to PDF"; exit 1; }
FILE_URL="$(python3 -c "import pathlib; print(pathlib.Path('$SRC').resolve().as_uri())")"
"$CHROME" --headless=new --disable-gpu --no-pdf-header-footer \
  --print-to-pdf="$OUT" "$FILE_URL" 2>/dev/null
echo "PDF: $OUT"