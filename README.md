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

## Local preview

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