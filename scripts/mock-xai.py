#!/usr/bin/env python3
"""Tiny fake xAI chat-completions server for testing the Grok integration offline.

  python3 scripts/mock-xai.py            # listens on :8099
  HELP_XAI_API_KEY=test-key HELP_XAI_ENDPOINT=http://host.docker.internal:8099/v1/chat/completions \
    docker compose up -d wordpress

Behavior: replies with a short answer that echoes the last user message, includes one
good link and one bad link (the theme must strip the bad one), and reports token usage.
Send "FAIL" in a message to get an HTTP 500. Send "HTML" to get markup in the reply.
"""

import json
import sys
from http.server import BaseHTTPRequestHandler, HTTPServer

PORT = int(sys.argv[1]) if len(sys.argv) > 1 else 8099
TOKENS_PER_CALL = 1000
calls = []


class Handler(BaseHTTPRequestHandler):
    def log_message(self, *args):
        pass

    def _send(self, code, payload):
        body = json.dumps(payload).encode()
        self.send_response(code)
        self.send_header("Content-Type", "application/json")
        self.send_header("Content-Length", str(len(body)))
        self.end_headers()
        self.wfile.write(body)

    def do_GET(self):
        self._send(200, {"calls": len(calls), "last": calls[-1] if calls else None})

    def do_POST(self):
        length = int(self.headers.get("Content-Length", "0"))
        data = json.loads(self.rfile.read(length) or b"{}")
        calls.append(
            {
                "auth": self.headers.get("Authorization", ""),
                "model": data.get("model"),
                "max_tokens": data.get("max_tokens"),
                "roles": [m["role"] for m in data.get("messages", [])],
                "system_has_rules": "Never give legal advice" in data["messages"][0]["content"]
                or "general education only" in data["messages"][0]["content"].lower(),
            }
        )
        last = data["messages"][-1]["content"]
        if "FAIL" in last:
            self._send(500, {"error": "boom"})
            return
        text = (
            "A provisional application can secure an early filing date. "
            "See https://www.uspto.gov/patents/basics/apply/provisional-application "
            "and https://evil.example.com/steal for more.\n\n"
            "[Patent guide](http://localhost:8082/guides/patent/) is a good start. "
            "For your facts, talk to an attorney."
        )
        if "HTML" in last:
            text += " <script>alert(1)</script><b>bold</b>"
        self._send(
            200,
            {
                "choices": [{"message": {"role": "assistant", "content": text}}],
                "usage": {"total_tokens": TOKENS_PER_CALL},
            },
        )


if __name__ == "__main__":
    print(f"mock xAI on :{PORT}")
    HTTPServer(("0.0.0.0", PORT), Handler).serve_forever()
