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

## Need more?
This repo is intentionally small. The **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)** adds:
- a signed offline cache with a grace period, so your app works without internet
- activation counting and limits, so one key can't run on unlimited machines
- a small proxy server, so your product ID and logic stay off the client
- ready-to-use Node and Python modules, with tests

Other kits for Gumroad sellers:
- [GitHub Access Kit](https://paudrudis.gumroad.com/l/znsmji): sell access to a private repo. Buyers are invited automatically and removed on refund.
- [Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm): turn your Gumroad sales into reports.
- [All kits bundle](https://paudrudis.gumroad.com/l/vtmohb)

## License
MIT © Pau Drudis. Not affiliated with Gumroad.
