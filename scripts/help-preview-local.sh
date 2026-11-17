#!/usr/bin/env bash
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
DIST="$ROOT/static/dist"
PORT="${HELP_PREVIEW_PORT:-8766}"

"$ROOT/scripts/build-texasiplawhelp-dist.sh"
/usr/sbin/lsof -ti:"$PORT" 2>/dev/null | /usr/bin/xargs kill -9 2>/dev/null || true
echo "Texas IP Law Help → http://127.0.0.1:$PORT/index.html"
exec /usr/bin/python3 -m http.server "$PORT" --directory "$DIST"