#!/usr/bin/env python3
"""Generate HTML rows for texasiplawhelp.com AI cost appendix (§4 session + §5 monthly)."""
from __future__ import annotations

# --- Edit assumptions here ---
WEBSITE_VISITS = [800, 1200, 1500, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000]
ASK_AI_PCT = [0.08, 0.10, 0.12, 0.13, 0.15, 0.17, 0.18, 0.20, 0.20, 0.22, 0.22, 0.25]
# Avg user questions per Ask AI visit (ramp 3.0 → 4.0 over year)
AVG_USER_QUESTIONS = [round(3.0 + (4.0 - 3.0) * i / 11, 1) for i in range(12)]
CHAT_MESSAGES_PER_VISIT = 6
KB_SHARE = 0.55
API_SHARE = 0.45
TOKENS_IN_PER_API = 3000
TOKENS_OUT_PER_API = 600
COST_MINI_PER_API = 0.0008
CAPS = [15, 15, 15, 25, 25, 25, 35, 35, 35, 50, 50, 50]

SESSION_TYPES = [
    ("Light", 2),
    ("Typical", 3.5),
    ("Heavy", 6),
]


def fmt_k(n: int) -> str:
    if n >= 1_000_000:
        return f"{n / 1_000_000:.2f}M"
    if n >= 1000:
        return f"{n / 1000:.1f}k"
    return str(n)


def session_row(label: str, user_q: float) -> str:
    bot = user_q
    live = int(round(bot * API_SHARE))
    tin = live * TOKENS_IN_PER_API
    tout = live * TOKENS_OUT_PER_API
    tot = tin + tout
    cost = live * COST_MINI_PER_API
    return (
        f"<tr><td><strong>{label}</strong></td>"
        f'<td class="num">{user_q}</td>'
        f'<td class="num">{bot:.0f}</td>'
        f'<td class="num">{live}</td>'
        f'<td class="num">{fmt_k(tin)}</td>'
        f'<td class="num">{fmt_k(tout)}</td>'
        f'<td class="num">{fmt_k(tot)}</td>'
        f'<td class="num">${cost:.4f}</td></tr>'
    )


def month_row(i: int) -> dict:
    visits = WEBSITE_VISITS[i]
    pct = ASK_AI_PCT[i]
    avg_q = AVG_USER_QUESTIONS[i]
    cap = CAPS[i]
    ask = int(round(visits * pct))
    guides = visits - ask
    user_q_total = int(round(ask * avg_q))
    msgs = ask * CHAT_MESSAGES_PER_VISIT
    kb = int(round(msgs * KB_SHARE))
    live = int(round(msgs * API_SHARE))
    tin = live * TOKENS_IN_PER_API
    tout = live * TOKENS_OUT_PER_API
    ttot = tin + tout
    bill = round(live * COST_MINI_PER_API, 2)
    return {
        "month": i + 1,
        "visits": visits,
        "pct": pct,
        "ask": ask,
        "guides": guides,
        "avg_q": avg_q,
        "user_q": user_q_total,
        "msgs": msgs,
        "kb": kb,
        "live": live,
        "tin": tin,
        "tout": tout,
        "ttot": ttot,
        "bill": bill,
        "cap": cap,
    }


def month_html(r: dict) -> str:
    pct_s = f"{int(r['pct'] * 100) if r['pct'] * 100 == int(r['pct'] * 100) else r['pct'] * 100:g}%"
    return (
        f"<tr><td><strong>Month {r['month']}</strong></td>"
        f'<td class="num"><strong>{r["visits"]:,}</strong></td>'
        f'<td class="num">{pct_s}</td>'
        f'<td class="num"><strong>{r["ask"]:,}</strong></td>'
        f'<td class="num">{r["guides"]:,}</td>'
        f'<td class="num">{r["avg_q"]}</td>'
        f'<td class="num">{r["user_q"]:,}</td>'
        f'<td class="num">{r["msgs"]:,}</td>'
        f'<td class="num">{r["kb"]:,}</td>'
        f'<td class="num">{r["live"]:,}</td>'
        f'<td class="num">{fmt_k(r["tin"])}</td>'
        f'<td class="num">{fmt_k(r["tout"])}</td>'
        f'<td class="num">{fmt_k(r["ttot"])}</td>'
        f'<td class="num"><strong>${r["bill"]:.2f}</strong></td>'
        f'<td class="num"><strong>${r["cap"]}</strong></td></tr>'
    )


def footer_html(rows: list[dict]) -> str:
    s = {
        "visits": sum(r["visits"] for r in rows),
        "ask": sum(r["ask"] for r in rows),
        "guides": sum(r["guides"] for r in rows),
        "user_q": sum(r["user_q"] for r in rows),
        "msgs": sum(r["msgs"] for r in rows),
        "kb": sum(r["kb"] for r in rows),
        "live": sum(r["live"] for r in rows),
        "tin": sum(r["tin"] for r in rows),
        "tout": sum(r["tout"] for r in rows),
        "ttot": sum(r["ttot"] for r in rows),
        "bill": sum(r["bill"] for r in rows),
        "caps": sum(r["cap"] for r in rows),
    }
    return (
        '<tr><td><strong>Year 1</strong></td>'
        f'<td class="num"><strong>{s["visits"]:,}</strong></td>'
        '<td class="num">—</td>'
        f'<td class="num"><strong>{s["ask"]:,}</strong></td>'
        f'<td class="num">{s["guides"]:,}</td>'
        '<td class="num">3.0→4.0 avg</td>'
        f'<td class="num"><strong>{s["user_q"]:,}</strong></td>'
        f'<td class="num">{s["msgs"]:,}</td>'
        f'<td class="num">{s["kb"]:,}</td>'
        f'<td class="num">{s["live"]:,}</td>'
        f'<td class="num">{fmt_k(s["tin"])}</td>'
        f'<td class="num">{fmt_k(s["tout"])}</td>'
        f'<td class="num">{fmt_k(s["ttot"])}</td>'
        f'<td class="num"><strong>${s["bill"]:.2f}</strong></td>'
        f'<td class="num">${s["caps"]}*</td></tr>'
    )


def patch_html(root: str) -> None:
    from pathlib import Path

    path = Path(root) / "static/AI-COST-BASIS-Susan.html"
    text = path.read_text(encoding="utf-8")
    start = text.find('<tbody id="monthly-forecast-body">')
    end = text.find("</tbody>", start) + len("</tbody>")
    foot_start = text.find('<tfoot id="monthly-forecast-foot">')
    foot_end = text.find("</tfoot>", foot_start) + len("</tfoot>")
    rows = [month_row(i) for i in range(12)]
    body = '<tbody id="monthly-forecast-body">\n' + "\n".join(month_html(r) for r in rows) + "\n    </tbody>"
    foot = '<tfoot id="monthly-forecast-foot">\n      ' + footer_html(rows) + "\n    </tfoot>"
    path.write_text(text[:start] + body + text[end:foot_start] + foot + text[foot_end:], encoding="utf-8")
    print(f"Patched {path}", file=__import__("sys").stderr)


def main() -> None:
    import argparse
    import os

    ap = argparse.ArgumentParser()
    ap.add_argument("--write", action="store_true", help="Patch mockups/gold-navy/ai-cost-appendix.html tbody/tfoot")
    args = ap.parse_args()
    if args.write:
        root = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
        patch_html(root)
        return

    rows = [month_row(i) for i in range(12)]
    print("<!-- SESSION_TABLE_BODY -->")
    for label, q in SESSION_TYPES:
        print(session_row(label, q))
    print("<!-- MONTHLY_TABLE_BODY -->")
    for r in rows:
        print(month_html(r))
    print("<!-- MONTHLY_TABLE_FOOT -->")
    print(footer_html(rows))
    # Example for Susan copy
    m6 = rows[5]
    print(
        f"\n# Month 6 example: {m6['ask']} Ask AI visits × {m6['avg_q']} questions "
        f"= {m6['user_q']:,} user questions → {fmt_k(m6['tin'])} input tokens → ${m6['bill']:.2f} API",
        file=__import__("sys").stderr,
    )


if __name__ == "__main__":
    main()