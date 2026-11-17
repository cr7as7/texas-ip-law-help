# texas-ip-law-help

**Texas IP Law Help** — [texasiplawhelp.com](https://texasiplawhelp.com) inventor hub (separate from [Texas IP Law Group](https://texasiplawgroup.com/) firm site).

| Folder | Purpose |
|--------|---------|
| `static/` | Static mock / staging HTML (`help.css`, `help.js`, guides, AI cost doc) |
| `static/dist/` | Built bundle (generated — do not edit) |
| `scripts/` | Build, local preview, AI forecast + PDF |
| `docs/` | `SCOPE.md`, `PREVIEW.md` |
| `exports/` | Client PDFs |
| `wordpress/theme/texas-ip-law-help/` | WP templates → **GoDaddy Managed WordPress** (production path) |

## WordPress theme (production)

`wordpress/theme/texas-ip-law-help/` is a hand-built theme (no page builder, no CDNs, fonts self-hosted) that matches the static mock pixel for pixel.

- Page layouts live in `template-parts/pages/<uri-with-dashes>.php`; `page.php` picks the file from the page URI. Editing a page's copy means editing that file (it deploys with the theme).
- The four articles are normal WordPress posts, created on first activation, editable in wp-admin. Permalinks are `/articles/%postname%/`.
- SEO (titles, descriptions, canonical, Open Graph, JSON-LD, noindex on search and 404) is in `inc/seo.php` and `inc/seo-data.php`. Do not add an SEO plugin.
- The consultation form posts to `admin-ajax.php` (`help_consult`) and emails `contact@texasiplawgroup.com` (override with the `HELP_CONSULT_EMAIL` constant in wp-config.php). It has a honeypot, validation, and a per-IP rate limit.
- The "Ask AI" chat is a canned demo, not a live AI. Replace the chat logic in `assets/js/help.js` when a real backend exists.

**First time on a new WordPress site:** after the deploy uploads the theme, go to Appearance → Themes and activate **Texas IP Law Help**. Activation creates the 13 pages and 4 articles, and sets the front page and permalinks.

## Local WordPress (Docker, separate from the firm site)

```bash
./scripts/docker-setup.sh
# Site  → http://localhost:8082            (HELP_WP_PORT to change)
# Admin → http://localhost:8082/wp-admin   helpadmin / help-local-only (local only)
# Mail  → http://localhost:8026            (Mailpit: consultation emails land here)
```

This stack has its own project name, ports, and volumes, so it runs next to the firm site's Docker. The theme folder is bind-mounted: edit a file, refresh the browser. `docker compose down -v` wipes the database.

## Visual parity check

Compares the WordPress site with the static mock at desktop (1280) and phone (390) widths:

```bash
pip install pillow numpy
python3 scripts/visual_parity.py   # needs Google Chrome and the local Docker site running
```

Passing means every page differs from the mock by less than 0.5% of pixels (currently 0.00%).

## Local static preview

```bash
chmod +x scripts/*.sh
./scripts/help-preview-local.sh
# → http://127.0.0.1:8766/index.html
```

## Build only

```bash
./scripts/build-texasiplawhelp-dist.sh
```

## AI cost PDF (Susan)

```bash
./scripts/generate-ai-cost-pdf.sh
```

## Git / deploy

- **Production:** WordPress on **GoDaddy Managed WordPress** at **texasiplawhelp.com**
- **Pull request:** `.github/workflows/ci.yml` lints theme PHP and builds the static preview. It does not touch GoDaddy.
- **Merge to `main`:** `.github/workflows/deploy.yml` uploads **only** `wordpress/theme/texas-ip-law-help/` over SFTP. Pages, posts, menus, and media stay in WordPress.
- **Manual deploy:** Actions → Deploy theme → Run workflow.
- **`main` is protected:** no direct pushes. Make a branch, open a PR, wait for the `check` job to pass, then merge. Settings → Branches to change this.
- **Local deploy:** `set -a; source .env; set +a; python3 scripts/deploy-theme-sftp.py` (needs `pip install -r scripts/requirements-deploy.txt`).

GoDaddy credentials are GitHub Actions secrets (repo → Settings → Secrets and variables → Actions), never committed:

| Secret | Example |
|--------|---------|
| `GODADDY_SFTP_HOST` | host from Managed WordPress → SFTP |
| `GODADDY_SFTP_USER` | SFTP username |
| `GODADDY_SFTP_PASSWORD` | SFTP password |
| `GODADDY_SFTP_PORT` | `22` (optional) |
| `GODADDY_REMOTE_PATH` | `wp-content/themes/texas-ip-law-help` (optional; must end with `texas-ip-law-help`) |

Copy host, username, and password from the GoDaddy Managed WordPress SFTP panel. The first deploy stays red until those three secrets exist.

## Sister repo

Firm theme + Docker dev lives in **`texas_ip_law`** (texasiplawgroup.com). This repo is **Help-only**.