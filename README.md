# gumroad-license-check
A tiny, dependency-free Gumroad license key check for **Node** and **Python** that **rejects refunded, charged-back and disputed purchases and ended subscriptions**.

## The gotcha
Most Gumroad integrations do this:
```js
const res = await (await fetch("https://api.gumroad.com/v2/licenses/verify", {...})).json();
if (res.success) unlockApp(); // ❌ refunded buyers pass too
```
`/v2/licenses/verify` still returns `success: true` after a buyer gets a refund or files a chargeback. The key still exists; the status is only in the `purchase` object (`refunded`, `chargebacked`, `disputed`, `subscription_ended_at`, `subscription_failed_at`). Check `success` alone and refunded buyers keep using your software.

## Node (18+)
```js
import { verifyLicense } from "./node/index.mjs";
const { valid, reason } = await verifyLicense("YOUR_PRODUCT_ID", userKey);
if (!valid) console.log("License rejected:", reason); // e.g. "purchase refunded"
```

## Python (3.8+)
```python
from gumroad_license_check import verify_license
res = verify_license("YOUR_PRODUCT_ID", user_key)
if not res["valid"]:
    print("License rejected:", res["reason"])
```
`product_id` is shown on your product's edit page, in the license key section. The check sends `increment_uses_count=false`, so routine re-checks don't use up activations.

Tests: `npm test`, which runs the Node tests and Python's unittest.

## Guides
- [Block refunded and charged-back buyers in your license check](docs/refunded-gumroad-license-keys.md)
- [Sell access to a private GitHub repo on Gumroad](docs/sell-private-github-repo-on-gumroad.md)
- [Gumroad sale alerts in Discord, Slack or Telegram](docs/gumroad-sale-alerts-discord-slack-telegram.md)
- [Sell a paid Discord on Gumroad and revoke roles on refund](docs/gumroad-discord-roles-refunds.md)
- [Awesome Gumroad](https://github.com/NarwhalThePong/awesome-gumroad): curated open-source tools for building on Gumroad
- [Gumroad Ping (webhook) reference: fields, events, retries and verification](https://narwhalthepong.github.io/gumroad-license-check/gumroad-ping-webhook)
- [Sync Gumroad sales to Google Sheets automatically (no Zapier)](https://narwhalthepong.github.io/gumroad-license-check/sync-gumroad-sales-to-google-sheets)
- [Gumroad fees in 2026, explained](https://narwhalthepong.github.io/gumroad-license-check/gumroad-fees-explained)
- [Gumroad 1099-K and taxes: reconcile gross sales with what you earned](https://narwhalthepong.github.io/gumroad-license-check/gumroad-1099-k-taxes)
- [Gumroad vs Lemon Squeezy vs Polar vs Paddle: fees in 2026](https://narwhalthepong.github.io/gumroad-license-check/gumroad-vs-lemon-squeezy-polar-paddle-fees)

All guides, rendered: [Gumroad developer guides](https://narwhalthepong.github.io/gumroad-license-check/)

## Free browser tools
These run in your browser; nothing is uploaded.
- [Gumroad license key checker](https://narwhalthepong.github.io/gumroad-license-check/gumroad-license-key-checker): see if a key is valid, refunded, charged back or disputed, without using up an activation.
- [Gumroad fee calculator](https://narwhalthepong.github.io/gumroad-license-check/gumroad-fee-calculator): your payout on direct and Discover sales, and the price you need for a target payout.
- [Gumroad sales CSV analyzer](https://narwhalthepong.github.io/gumroad-license-check/gumroad-sales-csv-analyzer): gross, refunds, fees and net by product, month, referrer and country from your sales export.
- [Gumroad bundle and discount calculator](https://narwhalthepong.github.io/gumroad-license-check/gumroad-bundle-discount-calculator): bundle pricing, offer codes, buyer savings and fees.
- [PayPal and Stripe fee calculator](https://narwhalthepong.github.io/gumroad-license-check/paypal-stripe-fee-calculator) and [Etsy fee calculator](https://narwhalthepong.github.io/gumroad-license-check/etsy-fee-calculator), if you sell on more than one platform.

## Need more?
This repo is intentionally small. The **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)** adds:
- a signed offline cache with a grace period, so your app works without internet
- activation counting and limits, so one key can't run on unlimited machines
- a small proxy server, so your product ID and logic stay off the client
- ready-to-use Node and Python modules, with tests

Other kits for Gumroad sellers:
- [GitHub Access Kit](https://paudrudis.gumroad.com/l/znsmji): sell access to a private repo. Buyers are invited automatically and removed on refund.
- [Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm): turn your Gumroad sales into reports.
- [Discord Access Kit](https://paudrudis.gumroad.com/l/gskxf): give Discord roles from license keys and remove them on refund.
- [Ping Relay](https://paudrudis.gumroad.com/l/tdohx): verified sale alerts to Discord, Slack and Telegram.
- [All kits bundle](https://paudrudis.gumroad.com/l/vtmohb)

## License
MIT © Pau Drudis. Not affiliated with Gumroad.
