#!/usr/bin/env python3
"""Pixel-compare the static mock (static/) against the local WordPress theme.

Needs: Google Chrome, Pillow, numpy; the Docker site running on :8082
(./scripts/docker-setup.sh). Serves a copy of the mock on :8767.

  python3 scripts/visual_parity.py            # all pages, desktop + mobile
  python3 scripts/visual_parity.py faq ask    # only some pages

Diff images land in /tmp/help-parity/. Exit code 1 if any page is over the threshold.
"""
from __future__ import annotations

import http.server
import re
import shutil
import socketserver
import subprocess
import sys
import threading
from pathlib import Path

import numpy as np
from PIL import Image

ROOT = Path(__file__).resolve().parents[1]
STATIC = ROOT / "static"
OUT = Path("/tmp/help-parity")
CHROME = "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome"
WP = "http://localhost:8082"
MOCK_PORT = 8767
MOCK = f"http://127.0.0.1:{MOCK_PORT}"

# name -> (mock file, wordpress path)
PAGES = {
    "home": ("index.html", "/"),
    "guides": ("guides.html", "/guides/"),
    "guide-patent": ("guide-patent.html", "/guides/patent/"),
    "guide-trademark": ("guide-trademark.html", "/guides/trademark/"),
    "guide-copyright": ("guide-copyright.html", "/guides/copyright/"),
    "articles": ("articles.html", "/articles/"),
    "article-patent-basics": ("article-patent-basics.html", "/articles/patent-basics/"),
    "article-provisional": ("article-provisional.html", "/articles/provisional-vs-non-provisional/"),
    "article-patentability": ("article-patentability.html", "/articles/is-my-idea-patentable/"),
    "article-licensing": ("article-licensing.html", "/articles/licensing-your-ip/"),
    "resources": ("resources.html", "/resources/"),
    "ask": ("ask.html", "/ask/"),
    "faq": ("faq.html", "/faq/"),
    "about": ("about.html", "/about/"),
    "disclaimer": ("disclaimer.html", "/disclaimer/"),
    "contact": ("contact.html", "/contact/"),
    "search": ("search-results.html?q=provisional%20patent", "/search-results/?q=provisional%20patent"),
}
VIEWPORTS = {"desktop": (1280, 7000), "mobile": (390, 12000)}
THRESHOLD = 0.5  # percent of differing pixels allowed per page


def normalize_intentional_changes(text: str) -> str:
    """Apply the edits we made on purpose in the WordPress theme, so the diff only shows accidents."""
    text = text.replace(
        '          <li><a href="../gold-navy/home.html">Firm website (mock)</a></li>\n', ""
    )
    text = text.replace("texasiplawhelp.com mock</p>", "texasiplawhelp.com</p>")
    text = text.replace(
        "<li>713-518-8837</li>",
        '<li><a href="tel:7135188837" style="color:rgba(255,255,255,0.85)">713-518-8837</a></li>',
    )
    text = text.replace(
        "<li>contact@texasiplawgroup.com</li>",
        '<li><a href="mailto:contact@texasiplawgroup.com" style="color:rgba(255,255,255,0.85)">contact@texasiplawgroup.com</a></li>',
    )
    text = text.replace('value="Jane Inventor"', 'placeholder="Your name"')
    text = text.replace('value="jane@example.com"', 'placeholder="you@example.com"')
    text = text.replace(
        "Name and email let the live site follow up. This mock does not store data on a server.",
        "Name and email are only used to start this demo chat. This demo does not store your data on a server.",
    )
    text = text.replace(
        "Daily token budget on live site; over cap, answers use the knowledge base (guides + USPTO).",
        "Demo chat: a few sample answers, then the knowledge base (guides + USPTO).",
    )
    return text


def prepare_mock() -> Path:
    """Copy the mock, drop the preview-only banner, point images at local assets."""
    tmp = OUT / "mock"
    if tmp.exists():
        shutil.rmtree(tmp)
    tmp.mkdir(parents=True)
    for f in STATIC.glob("*.html"):
        text = f.read_text(encoding="utf-8")
        text = re.sub(r'\s*<p class="mock-label-preview">.*?</p>\n', "\n", text, flags=re.S)
        text = text.replace(
            "../../wp-content/themes/texas-ip-law/assets/images", "assets/images"
        )
        text = normalize_intentional_changes(text)
        (tmp / f.name).write_text(text, encoding="utf-8")
    for name in ("help.css", "help.js"):
        shutil.copy(STATIC / name, tmp / name)
    shutil.copytree(STATIC / "assets", tmp / "assets")
    # the mock markup links ../gold-navy/mock.css only in the AI cost doc; not needed here
    return tmp


class _Quiet(http.server.SimpleHTTPRequestHandler):
    def log_message(self, *args):
        pass


def serve(directory: Path):
    socketserver.TCPServer.allow_reuse_address = True
    httpd = socketserver.TCPServer(
        ("127.0.0.1", MOCK_PORT),
        lambda *a, **k: _Quiet(*a, directory=str(directory), **k),
    )
    threading.Thread(target=httpd.serve_forever, daemon=True).start()
    return httpd


def shot(url: str, dest: Path, width: int, height: int) -> None:
    subprocess.run(
        [
            CHROME, "--headless=new", "--disable-gpu", "--hide-scrollbars",
            "--force-device-scale-factor=1", f"--window-size={width},{height}",
            "--virtual-time-budget=6000", f"--screenshot={dest}", url,
        ],
        check=True, stdout=subprocess.DEVNULL, stderr=subprocess.DEVNULL, timeout=90,
    )


def trim(img: Image.Image) -> Image.Image:
    """Drop the empty white area under the footer."""
    # A row counts as page content when most of it is not white. (The fixed "Ask AI"
    # button is small, so it does not count.)
    arr = np.asarray(img.convert("RGB"))
    filled = (arr < 250).any(axis=2).mean(axis=1) > 0.5
    rows = np.where(filled)[0]
    return img.crop((0, 0, img.width, int(rows[-1]) + 1)) if len(rows) else img


def compare(a: Image.Image, b: Image.Image):
    h = min(a.height, b.height)
    x = np.asarray(a.convert("RGB").crop((0, 0, a.width, h)), dtype=np.int16)
    y = np.asarray(b.convert("RGB").crop((0, 0, b.width, h)), dtype=np.int16)
    bad = np.abs(x - y).sum(axis=2) > 48
    pct = 100.0 * bad.sum() / bad.size
    rows = np.where(bad.any(axis=1))[0]
    first = int(rows[0]) if len(rows) else -1
    diff = np.asarray(a.convert("RGB").crop((0, 0, a.width, h))).copy()
    diff[bad] = (255, 0, 0)
    return pct, first, Image.fromarray(diff)


def main() -> int:
    wanted = set(sys.argv[1:])
    OUT.mkdir(parents=True, exist_ok=True)
    mock_dir = prepare_mock()
    httpd = serve(mock_dir)
    failed = 0
    print(f"{'page':24} {'view':8} {'mock h':>7} {'wp h':>7} {'diff %':>7}  first diff y")
    try:
        for name, (mock_file, wp_path) in PAGES.items():
            if wanted and name not in wanted:
                continue
            for view, (w, h) in VIEWPORTS.items():
                m_png, w_png = OUT / f"{name}-{view}-mock.png", OUT / f"{name}-{view}-wp.png"
                # Headless Chrome occasionally screenshots before web fonts finish loading,
                # so give a differing page one more try before calling it a failure.
                for _attempt in range(2):
                    shot(f"{MOCK}/{mock_file}", m_png, w, h)
                    shot(f"{WP}{wp_path}", w_png, w, h)
                    a, b = trim(Image.open(m_png)), trim(Image.open(w_png))
                    pct, first, diff = compare(a, b)
                    if pct == 0:
                        break
                diff.save(OUT / f"{name}-{view}-diff.png")
                flag = "" if (pct <= THRESHOLD and a.height == b.height) else "  <-- CHECK"
                if flag:
                    failed += 1
                print(f"{name:24} {view:8} {a.height:7} {b.height:7} {pct:7.2f}  {first}{flag}")
    finally:
        httpd.shutdown()
    print(f"\n{failed} page/viewport pair(s) need a look. Images: {OUT}")
    return 1 if failed else 0


if __name__ == "__main__":
    sys.exit(main())
