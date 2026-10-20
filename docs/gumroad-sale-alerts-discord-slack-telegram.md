---
layout: page
title: "Gumroad sale alerts in Discord, Slack or Telegram (and why pasting the webhook URL fails)"
description: "Gumroad pings are form-encoded and unsigned, so Discord and Slack webhooks reject them. A small relay that verifies each sale with the Sales API."
---

You'd think getting a Discord message for every Gumroad sale would mean pasting a Discord webhook URL into Gumroad's Ping setting. Try it and nothing shows up.

## Why it fails
1. **Format.** Gumroad sends `application/x-www-form-urlencoded`. Discord expects JSON `{"content": "..."}`, Slack expects `{"text": "..."}`, and Telegram expects `{"chat_id", "text"}` sent to a bot endpoint.
2. **Trust.** The ping isn't signed. Once your relay URL leaks, anyone can post fake "sales" to it.
3. **Repeats.** Gumroad can send the same ping more than once.

## A 40-line relay

```js
const http = require('http');
http.createServer((req, res) => {
  let body = ''; req.on('data', c => body += c);
  req.on('end', async () => {
    const u = new URL(req.url, 'http://x');
    if (u.searchParams.get('secret') !== process.env.PING_SECRET) { res.statusCode = 403; return res.end(); }
    const saleId = new URLSearchParams(body).get('sale_id');
    // Don't trust the ping body: fetch the real sale
    const r = await fetch(`https://api.gumroad.com/v2/sales/${encodeURIComponent(saleId)}`,
      { headers: { Authorization: `Bearer ${process.env.GUMROAD_ACCESS_TOKEN}` } });
    const { sale } = await r.json();
    const kind = sale.refunded ? 'REFUND' : 'SALE';
    await fetch(process.env.DISCORD_WEBHOOK_URL, {
      method: 'POST', headers: { 'content-type': 'application/json' },
      body: JSON.stringify({ content: `${kind}: ${sale.product_name} $${(sale.price / 100).toFixed(2)}` })
    });
    res.end('ok');
  });
}).listen(8788);
```

Deploy it anywhere that runs Node, then set Gumroad's Ping URL to `https://your-host/?secret=...`.

## Making it production-grade
- **Dedupe** on `sale_id + event`, so resent pings don't alert twice.
- **Separate events:** refunds, chargebacks, disputes, cancellations.
- **Net after fees:** Gumroad keeps 10% + $0.50 plus card processing (2.9% + $0.30) on direct sales, and 30% on Discover sales. Seeing the net number changes how you price.
- **Referrer:** `sale.referrer` tells you which post or site sold the product. That's the cheapest marketing analytics you'll get.
- **Mask emails** before posting them into a shared channel.
- **Ledger:** append every event to a CSV, and guard cells that start with `=`, `+`, `-` or `@` so a malicious product name can't run a formula in Excel.

## Want the finished version?
[Gumroad Ping Relay](https://paudrudis.gumroad.com/l/tdohx/LAUNCH30) does all of the above for Discord, Slack and Telegram at once, plus the CSV ledger. It has 13 tests and zero dependencies. To turn that ledger into a monthly P&L, see the [Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq/LAUNCH30).

For license keys that ignore refunds, there's a free fix: [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check).

---
[All guides](./)
