#!/usr/bin/env bash
# One-time local setup: start WordPress for texasiplawhelp.com on http://localhost:8082
# and activate the Help theme. Safe to re-run.
set -euo pipefail
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

PORT="${HELP_WP_PORT:-8082}"
URL="http://localhost:${PORT}"
WP=(docker compose --profile tools run --rm -T wpcli wp)

docker compose up -d

echo "Waiting for WordPress files..."
for _ in $(seq 1 60); do
  docker compose exec -T wordpress test -f /var/www/html/wp-includes/version.php 2>/dev/null && break
  sleep 2
done
# The wordpress image copies core on first start; wp-config appears right after.
for _ in $(seq 1 30); do
  docker compose exec -T wordpress test -f /var/www/html/wp-config.php 2>/dev/null && break
  sleep 2
done

if ! "${WP[@]}" core is-installed 2>/dev/null; then
  "${WP[@]}" core install \
    --url="$URL" \
    --title="Texas IP Law Help" \
    --admin_user="helpadmin" \
    --admin_password="help-local-only" \
    --admin_email="admin@example.test" \
    --skip-email
fi

"${WP[@]}" theme activate texas-ip-law-help
# Activation seeds on first switch only. Re-running is safe: it creates missing
# pages/articles and never overwrites ones that already exist.
"${WP[@]}" eval 'help_seed_site();'
"${WP[@]}" rewrite flush --hard >/dev/null 2>&1 || true

echo
echo "Site:  $URL"
echo "Mail:  http://localhost:${HELP_MAIL_UI_PORT:-8026}  (Mailpit catches consultation emails)"
echo "Admin: $URL/wp-admin  (helpadmin / help-local-only — local only)"
