# WordPress (GoDaddy production)

1. **GoDaddy:** second **Managed WordPress** site for `texasiplawhelp.com`.
2. **Theme:** evolve `theme/texas-ip-law-help/` into a full theme (or child theme) from `static/` mock.
3. **Deploy:** merge to `main` runs `.github/workflows/deploy.yml` and SFTP-uploads this theme. Secrets: `GODADDY_SFTP_HOST`, `GODADDY_SFTP_USER`, `GODADDY_SFTP_PASSWORD`.

Templates here are copied from the firm theme’s Help page (`page-ip-law-help.php`, `ip-law-help-*` parts) as a starting point.
