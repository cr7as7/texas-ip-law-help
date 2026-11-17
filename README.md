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

## Git / deploy (target)

- **Production:** WordPress on **GoDaddy** (second Managed WP site) on **texasiplawhelp.com**
- **Workflow:** GitHub PR → merge `main` → CI deploys theme to GoDaddy (to be wired in `.github/workflows/`)

## Sister repo

Firm theme + Docker dev lives in **`texas_ip_law`** (texasiplawgroup.com). This repo is **Help-only**.