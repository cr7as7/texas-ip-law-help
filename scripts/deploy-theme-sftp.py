#!/usr/bin/env python3
"""Upload the Help theme to GoDaddy Managed WordPress over SFTP.

Uploads only wordpress/theme/texas-ip-law-help/. Pages, posts, and media
stay in the WordPress database and are not touched.

Required env:
  GODADDY_SFTP_HOST
  GODADDY_SFTP_USER
  GODADDY_SFTP_PASSWORD

Optional env:
  GODADDY_SFTP_PORT       default 22
  GODADDY_REMOTE_PATH     default html/wp-content/themes/texas-ip-law-help
"""

from __future__ import annotations

import os
import stat
import sys
import time
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
LOCAL = ROOT / "wordpress" / "theme" / "texas-ip-law-help"
# GoDaddy Managed WordPress: the SFTP home holds html/ (the WordPress root).
REMOTE_DEFAULT = "html/wp-content/themes/texas-ip-law-help"
SKIP_NAMES = {".DS_Store", ".git", "__pycache__"}


def env(name: str, default: str = "") -> str:
    # GitHub passes unset secrets as empty strings, so fall back on blank too.
    return (os.environ.get(name) or default).strip()


def require(name: str) -> str:
    value = env(name)
    if not value:
        sys.exit(
            f"Missing {name}.\n"
            "Add these GitHub Actions secrets (Settings → Secrets and variables → Actions):\n"
            "  GODADDY_SFTP_HOST\n"
            "  GODADDY_SFTP_USER\n"
            "  GODADDY_SFTP_PASSWORD\n"
            "Optional: GODADDY_SFTP_PORT (22), GODADDY_REMOTE_PATH "
            "(html/wp-content/themes/texas-ip-law-help)\n"
            "Copy host, user, and password from GoDaddy Managed WordPress → SFTP."
        )
    return value


def safe_remote(path: str) -> str:
    remote = path.strip().strip("/")
    if (
        not remote
        or ".." in remote.split("/")
        or not remote.endswith("texas-ip-law-help")
        or remote in {"wp-content", "wp-content/themes", "html/wp-content", "html/wp-content/themes"}
    ):
        sys.exit(
            "Refusing deploy. GODADDY_REMOTE_PATH must be the theme folder "
            "and end with texas-ip-law-help."
        )
    return remote


def ensure_dir(sftp, path: str) -> None:
    current = ""
    for part in path.split("/"):
        current = f"{current}/{part}" if current else part
        try:
            sftp.stat(current)
        except FileNotFoundError:
            sftp.mkdir(current)


def local_tree(root: Path) -> dict[str, Path]:
    files: dict[str, Path] = {}
    for path in root.rglob("*"):
        if any(part in SKIP_NAMES for part in path.parts):
            continue
        rel = path.relative_to(root).as_posix()
        files[rel] = path
    return files


def remove_extra(sftp, remote: str, keep: set[str], rel_base: str = "") -> None:
    for entry in sftp.listdir_attr(remote):
        name = entry.filename
        rel = f"{rel_base}/{name}" if rel_base else name
        full = f"{remote}/{name}"
        if stat.S_ISDIR(entry.st_mode):
            remove_extra(sftp, full, keep, rel)
            if rel not in keep:
                try:
                    sftp.rmdir(full)
                    print(f"rmdir {rel}")
                except OSError:
                    pass
        elif rel not in keep:
            sftp.remove(full)
            print(f"rm {rel}")


def open_transport(paramiko, host, port, user, password, attempts=4):
    """Connect, retrying when GoDaddy is slow to answer the login.

    A wrong password is not retried, so a bad secret cannot lock the account.
    """
    for attempt in range(1, attempts + 1):
        transport = paramiko.Transport((host, port))
        try:
            transport.connect(username=user, password=password)
            return transport
        except paramiko.AuthenticationException as exc:
            transport.close()
            if "timeout" not in str(exc).lower():
                sys.exit(f"SFTP login was rejected: {exc}")
            err = exc
        except (paramiko.SSHException, OSError, EOFError) as exc:
            transport.close()
            err = exc
        if attempt < attempts:
            wait = 5 * attempt
            print(f"SFTP connect attempt {attempt}/{attempts} failed ({err}); retrying in {wait}s")
            time.sleep(wait)
    sys.exit(f"SFTP connect failed after {attempts} attempts: {err}")


def main() -> None:
    host = require("GODADDY_SFTP_HOST")
    user = require("GODADDY_SFTP_USER")
    password = require("GODADDY_SFTP_PASSWORD")
    port = int(env("GODADDY_SFTP_PORT", "22") or "22")
    remote = safe_remote(env("GODADDY_REMOTE_PATH", REMOTE_DEFAULT))

    if not LOCAL.is_dir():
        sys.exit(f"Theme folder missing: {LOCAL}")

    try:
        import paramiko
    except ImportError:
        sys.exit("Install deploy deps: pip install -r scripts/requirements-deploy.txt")

    files = local_tree(LOCAL)
    if not files:
        sys.exit(f"Theme folder is empty: {LOCAL}")

    transport = open_transport(paramiko, host, port, user, password)
    try:
        sftp = paramiko.SFTPClient.from_transport(transport)
        # The themes folder must already exist. If it does not, the path is wrong
        # (for example missing the html/ prefix) and we must not invent a new tree.
        themes_dir = remote.rsplit("/", 1)[0]
        try:
            sftp.stat(themes_dir)
        except FileNotFoundError:
            sys.exit(
                f"Remote folder {themes_dir!r} does not exist, so this is not the WordPress "
                "themes folder. Check GODADDY_REMOTE_PATH (GoDaddy uses html/wp-content/themes/...)."
            )
        ensure_dir(sftp, remote)
        for rel, path in sorted(files.items()):
            dest = f"{remote}/{rel}"
            if path.is_dir():
                ensure_dir(sftp, dest)
            elif path.is_file():
                print(f"put {rel}")
                sftp.put(str(path), dest)
        remove_extra(sftp, remote, set(files))
        sftp.stat(f"{remote}/style.css")  # fail loudly if the upload did not land
        sftp.close()
    finally:
        transport.close()

    print(f"Deployed theme to {user}@{host}:{remote}")


if __name__ == "__main__":
    main()
