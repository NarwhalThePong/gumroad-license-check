---
layout: page
title: "Gumroad Ping (webhook) reference: fields, events, retries and verification"
description: "Everything Gumroad's Ping webhook sends, how to get refund, dispute and cancellation events with resource subscriptions, how retries and duplicates work, and how to verify unsigned pings."
---

Gumroad calls its webhook **Ping**. It's simple to turn on, but a few details aren't obvious until something breaks: the Settings URL only receives sales, nothing is signed, and the same ping can show up twice. This page collects those details in one place, checked against [Gumroad's Ping docs](https://gumroad.com/ping), the [API docs](https://gumroad.com/api) and the open-source [antiwork/gumroad](https://github.com/antiwork/gumroad) code.

If all you want is a message in Discord, Slack or Telegram for each sale, see [Gumroad sale alerts in Discord, Slack or Telegram](gumroad-sale-alerts-discord-slack-telegram) instead.

## Two ways to receive pings

| | Settings → Advanced → **Ping endpoint** | API **resource subscriptions** |
|---|---|---|
| Events | `sale` only | `sale`, `refund`, `dispute`, `dispute_won`, `cancellation`, `subscription_updated`, `subscription_ended`, `subscription_restarted` |
| Set up | Paste a URL in the dashboard | `PUT /v2/resource_subscriptions` with an access token |
| Limit | One URL per account | Several URLs allowed, one call per event |

The Settings endpoint only ever gets `sale`. Gumroad's own test suite checks for this ("never sends notification_endpoint anything but 'sale'"). If your license server or membership logic needs to know about refunds, chargebacks or cancellations, you have to use resource subscriptions. The Settings URL alone won't tell you.

### The Settings endpoint

1. In Gumroad, open **Settings → Advanced**.
2. Under **Ping**, put your URL in **Ping endpoint**, for example `https://example.com/gumroad?secret=LONG_RANDOM_STRING`.
3. Click **Send test ping to URL**. Gumroad posts your most recent sale with `test` set to `true` and shows the HTTP status your endpoint returned. If you have no sales yet, it asks you to make a test purchase first.

Use HTTPS. Gumroad's docs recommend it, and your secret is in the URL.

### Resource subscriptions (refunds, disputes, cancellations)

You need an access token with the `view_sales` scope. To get one, create an application under **Settings → Advanced → Applications** and click **Generate access token**. Then subscribe once per event:

```bash
for ev in sale refund dispute dispute_won cancellation subscription_ended; do
  curl https://api.gumroad.com/v2/resource_subscriptions \
    -d "access_token=$GUMROAD_ACCESS_TOKEN" \
    -d "resource_name=$ev" \
    --data-urlencode "post_url=https://example.com/gumroad?secret=$PING_SECRET" \
    -X PUT
done
```

Note the `PUT`, not `POST`. A successful call returns:

```json
{ "success": true, "resource_subscription": { "id": "G_-mnBf9b1j9A7a4ub4nFQ==", "resource_name": "sale", "post_url": "https://example.com/gumroad?secret=..." } }
```

- **List:** `GET /v2/resource_subscriptions?resource_name=refund` (the `resource_name` parameter is required).
- **Delete:** `DELETE /v2/resource_subscriptions/:id`. It only works with a token from the same application that created the subscription.
- The `post_url` has to resolve to a public address, so `localhost` and private IPs are rejected. For local testing, use a tunnel.
- Delivery depends on that application still having a live token with `view_sales` (or `account`) scope. If you revoke the token, the pings stop.
- If you subscribe `sale` here **and** fill in the Settings endpoint, each sale is posted to both URLs.

## What a ping looks like

Each ping is an HTTP `POST` with an `application/x-www-form-urlencoded` body. (The one exception: `zapier.com` URLs get JSON.) Gumroad doesn't read your response body. Any 2xx counts as delivered.

Every value arrives as a string, so booleans come through as `"true"` / `"false"`. Nested values are sent with brackets, for example `url_params[campaignid]=c123`, `variants[Size]=Large`, `custom_fields[Company]=Acme` and `card[visual]=...`.

### Sale, refund and dispute pings

These are the fields on the [Ping page](https://gumroad.com/ping), plus a few that the current open-source payload code also sends. Many fields only appear when they apply.

| Field | Meaning |
|---|---|
| `resource_name` | `sale`, `refund`, `dispute` or `dispute_won` |
| `sale_id` | The sale's ID. Use it with `GET /v2/sales/:id`. A refund carries the same `sale_id` as the original sale. |
| `sale_timestamp` | When the sale happened |
| `order_number` | Numeric version of `sale_id` |
| `seller_id`, `product_id`, `product_name` | Who sold what |
| `product_permalink`, `short_product_id` | Product URL and short permalink. An older `permalink` field is deprecated; use these instead. |
| `email`, `full_name`, `purchaser_id` | Buyer email, name if given, Gumroad account ID if the buyer has one |
| `price` | Price paid, in cents |
| `gumroad_fee` | Gumroad's fee, in cents |
| `quantity` | Quantity bought |
| `variants` | Chosen options, for example `variants[Tier]=Pro` |
| `offer_code` | Discount code used, if any |
| `license_key` | Present if license keys are enabled for the product |
| `url_params` | Query parameters from the product URL the buyer used, for example `?campaignid=c123` |
| `custom_fields` | Checkout custom fields. Each field is also sent as its own top-level key. |
| `subscription_id`, `recurrence`, `is_recurring_charge` | Membership details, for memberships only |
| `is_preorder_authorization` | Pre-orders |
| `refunded` | `true` if the sale has been refunded |
| `disputed`, `dispute_won` | Chargeback state, from the current open-source code |
| `discover_fee_charged` | `true` if the Discover fee applied |
| `affiliate`, `affiliate_credit_amount_cents` | Affiliate email and payout |
| `is_gift_receiver_purchase`, `gifter_email`, `gift_price` | Gift purchases |
| `ip_country`, `referrer`, `can_contact`, `card` | Buyer country, where they came from, marketing consent, card type |
| `shipping_information`, `shipping_rate` | Physical products |
| `test` | `true` when you bought your own product, and on the dashboard's test ping |
| `retry_count` | Only present on a retried delivery: `1`, `2` or `3` |

The `url_params` field is a free tracking tool. Link to `https://you.gumroad.com/l/abc?source=newsletter` and every sale from that link carries `url_params[source]=newsletter`.

### Membership pings (`cancellation`, `subscription_*`)

These are about a subscription, not a single charge, so **they have no `sale_id`**. They send `subscription_id`, `product_id`, `product_name`, `user_id`, `user_email`, `purchase_ids` (every charge on the subscription), `created_at`, `charge_occurrence_count`, `recurrence`, `free_trial_ends_at`, `custom_fields`, `license_key` and `resource_name`, plus:

- **`cancellation`:** `cancelled`, `cancelled_at`, and one of `cancelled_by_buyer`, `cancelled_by_seller`, `cancelled_by_admin` or `cancelled_due_to_payment_failures`. This is sent when cancellation is requested. Access normally runs until the end of the paid period.
- **`subscription_ended`:** `ended_at` and `ended_reason` (`cancelled`, `failed_payment` or `fixed_subscription_period_ended`). This is sent when the subscription has actually ended, so it's usually the right moment to remove access.
- **`subscription_updated`:** `type` (`upgrade` or `downgrade`), `effective_as_of`, `old_plan` and `new_plan`. This applies to tiered memberships only.
- **`subscription_restarted`:** `restarted_at`.

To check one of these, read it back with `GET /v2/subscribers/:id`, using `subscription_id`.

## Retries, duplicates and ordering

From Gumroad's Ping page and the delivery worker in the open-source repo:

- **You have 5 seconds.** Return a 2xx right away and do the slow work (API calls, emails, database writes) afterwards.
- **Delivery is at least once.** The same ping can arrive twice. Deduplicate on `resource_name` + `sale_id` (or `subscription_id`), not on `sale_id` alone, because a refund reuses the sale's ID.
- **Order isn't guaranteed.** A refund ping can arrive before the sale ping it refers to. Re-reading the sale (below) gives you its current state, so order stops mattering.
- **Retries are limited.** Only responses `499`, `500`, `502`, `503` and `504` are retried. Any other error, like a `403` from a firewall, drops the ping. The docs list retries after 1, 3 and 10 minutes and 1 hour. The current worker code schedules at most 3 retries (`retry_count` 1 to 3) and also retries timeouts and connection errors. Either way, a server that's down for an hour can miss pings for good.
- **Redirects:** the worker follows up to 3 redirects and re-sends the same POST body. To be safe, register the final URL.

Because retries run out, treat pings as a fast path and reconcile now and then. A nightly `GET /v2/sales?after=YYYY-MM-DD` catches anything you missed. The [Google Sheets sync guide](sync-gumroad-sales-to-google-sheets) shows one way to do it.

## Pings are not signed: how to verify them

There's no signature header and no shared secret. Anyone who learns your URL can POST a fake `sale_id=...&price=0&email=me@example.com`. Two habits fix that:

1. **Put a long random secret in the URL** (`?secret=...`) and reject requests without it. This blocks drive-by junk. The open-source delivery code also sends HTTP basic auth if the URL contains `user:pass@`, but a query secret works with both the Settings page and the API.
2. **Never act on the ping body.** Take `sale_id` and fetch the sale with `GET https://api.gumroad.com/v2/sales/:id` and your own token. If Gumroad says the sale doesn't exist, ignore the ping. If it does, use the API's `refunded`, `partially_refunded`, `chargedback`, `disputed` and `dispute_won` flags, not the ping's.

The same rule applies to license keys. A key in a ping proves nothing until you check it. [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check) is a free, zero-dependency check that also rejects refunded and charged-back keys.

## Receiver example: Node (18+, no dependencies)

This checks the secret in constant time, acknowledges immediately, ignores duplicates, and re-reads the sale (or subscriber) from the API before deciding to grant or revoke access.

```js
const http = require('http');
const crypto = require('crypto');

const API = process.env.GUMROAD_API_BASE || 'https://api.gumroad.com';
const SECRET = Buffer.from(process.env.PING_SECRET || '');
const seen = new Set(); // use a database table in production

function secretOk(given) {
  const b = Buffer.from(given || '');
  return SECRET.length > 0 && b.length === SECRET.length && crypto.timingSafeEqual(b, SECRET);
}

async function handle(ping) {
  const event = ping.get('resource_name') || 'sale';
  const id = ping.get('sale_id') || ping.get('subscription_id');
  if (!id || seen.has(`${event}:${id}`)) return;          // duplicate or junk
  seen.add(`${event}:${id}`);

  // Never trust the ping body: read the record back from the API.
  const path = ping.get('sale_id') ? `sales/${encodeURIComponent(id)}` : `subscribers/${encodeURIComponent(id)}`;
  const r = await fetch(`${API}/v2/${path}`, {
    headers: { Authorization: `Bearer ${process.env.GUMROAD_ACCESS_TOKEN}` },
  });
  const data = await r.json();
  if (!data.success) { seen.delete(`${event}:${id}`); return console.warn('not found, ignoring', event, id); }

  if (data.sale) {
    const s = data.sale;
    const bad = s.refunded || s.partially_refunded || s.chargedback || (s.disputed && !s.dispute_won);
    console.log(event, s.id, s.product_name, s.price, bad ? 'REVOKE' : 'GRANT');
  } else {
    console.log(event, data.subscriber.id, data.subscriber.status);
  }
}

http.createServer((req, res) => {
  const url = new URL(req.url, 'http://localhost');
  if (req.method !== 'POST' || !secretOk(url.searchParams.get('secret'))) {
    res.statusCode = 404; return res.end();
  }
  let body = '';
  req.on('data', (c) => { body += c; if (body.length > 1e5) req.destroy(); });
  req.on('end', () => {
    res.end('ok');                                       // acknowledge within 5 seconds
    handle(new URLSearchParams(body)).catch((e) => console.error(e));
  });
}).listen(process.env.PORT || 8788);
```

Run it with `PING_SECRET=... GUMROAD_ACCESS_TOKEN=... node receiver.js`, then point Gumroad at `https://your-host/?secret=...`.

## Receiver example: Python (3.9+, standard library only)

```python
import hmac, json, os, threading, urllib.error, urllib.parse, urllib.request
from http.server import BaseHTTPRequestHandler, ThreadingHTTPServer

API = os.environ.get("GUMROAD_API_BASE", "https://api.gumroad.com")
SECRET = os.environ.get("PING_SECRET", "")
seen, lock = set(), threading.Lock()  # use a database table in production

def handle(ping):
    event = ping.get("resource_name", "sale")
    rid = ping.get("sale_id") or ping.get("subscription_id")
    with lock:
        if not rid or (event, rid) in seen:
            return  # duplicate or junk
        seen.add((event, rid))
    # Never trust the ping body: read the record back from the API.
    kind = "sales" if ping.get("sale_id") else "subscribers"
    req = urllib.request.Request(
        f"{API}/v2/{kind}/{urllib.parse.quote(rid, safe='')}",
        headers={"Authorization": "Bearer " + os.environ["GUMROAD_ACCESS_TOKEN"]})
    try:
        data = json.load(urllib.request.urlopen(req, timeout=10))
    except urllib.error.HTTPError as e:
        data = json.load(e)
    if not data.get("success"):
        with lock:
            seen.discard((event, rid))
        return print("not found, ignoring", event, rid)
    if "sale" in data:
        s = data["sale"]
        bad = s.get("refunded") or s.get("partially_refunded") or s.get("chargedback") \
            or (s.get("disputed") and not s.get("dispute_won"))
        print(event, s["id"], s["product_name"], s["price"], "REVOKE" if bad else "GRANT", flush=True)
    else:
        print(event, data["subscriber"]["id"], data["subscriber"]["status"], flush=True)

class Ping(BaseHTTPRequestHandler):
    def do_POST(self):
        qs = urllib.parse.parse_qs(urllib.parse.urlsplit(self.path).query)
        if not SECRET or not hmac.compare_digest(qs.get("secret", [""])[0], SECRET):
            self.send_response(404); self.end_headers(); return
        body = self.rfile.read(min(int(self.headers.get("Content-Length", 0)), 100_000))
        self.send_response(200); self.end_headers(); self.wfile.write(b"ok")  # ack fast
        ping = dict(urllib.parse.parse_qsl(body.decode()))
        threading.Thread(target=handle, args=(ping,), daemon=True).start()

ThreadingHTTPServer(("", int(os.environ.get("PORT", 8789))), Ping).serve_forever()
```

Both examples were tested against local mock pings and a mocked Sales API. Here's what each case did:

- A valid sale was granted after one API lookup.
- The same ping sent again was ignored.
- A refund ping was revoked based on the API's `refunded` flag.
- A forged `sale_id` returned "not found" and was ignored.
- Requests with a wrong or missing secret got a `404`.
- A `cancellation` ping was looked up through `/v2/subscribers/:id`.

`GUMROAD_API_BASE` is only there so you can point the receiver at a mock. Leave it unset in production. Replace the in-memory `seen` set with a database table (a unique key on event + ID) so that restarts don't forget what you've already handled.

## Common problems

- **The test ping works but real refunds never arrive:** the Settings endpoint is sale-only. Add a `refund` resource subscription.
- **Nothing arrives at all:** check the HTTP status the test button reports. Cloudflare or bot protection often answers `403`, and a `403` is never retried.
- **Duplicate emails or license grants:** add dedupe on event + ID.
- **Pasting a Discord or Slack webhook URL does nothing:** those services expect JSON. You need a small relay. See the [sale alerts guide](gumroad-sale-alerts-discord-slack-telegram).

## Skip the plumbing

*Disclosure: the paid kits below are our own products, and we earn the sale price if you buy one.*

- **[Gumroad Ping Relay](https://paudrudis.gumroad.com/l/tdohx)** ($9+): a ready-made receiver that verifies every ping against the Sales API, dedupes, and posts sales, refunds and disputes to Discord, Slack and Telegram, with a CSV ledger.
- **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)** ($19+): license checks with an offline cache, activation limits and a proxy server, so refunds turn keys off.
- **[n8n Workflows for Gumroad Sellers](https://payhip.com/b/st5cr)** ($19, on Payhip): four importable n8n workflows that verify each ping against the Sales API before acting: sale alerts with a Google Sheets log, refund and chargeback access revokes, a weekly digest and a monthly CSV export.
- **[gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check)** (free, MIT): the refund-aware license check on its own.

## Related guides

- [Block refunded and charged-back buyers in your Gumroad license check](refunded-gumroad-license-keys)
- [Sell access to a private GitHub repo on Gumroad](sell-private-github-repo-on-gumroad)
- [Sell a paid Discord on Gumroad and revoke roles on refund](gumroad-discord-roles-refunds)

Not affiliated with Gumroad.
