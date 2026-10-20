---
layout: page
title: "Gumroad license keys: block refunded and charged-back buyers (Node and Python)"
description: "Gumroad's /v2/licenses/verify returns success even after a refund. The 10-line fix for Node and Python, plus activation-count tips."
---

If you sell software on Gumroad and gate it with license keys, there's a good chance your check looks like this:

```js
const res = await fetch("https://api.gumroad.com/v2/licenses/verify", {
  method: "POST",
  body: new URLSearchParams({ product_id, license_key }),
}).then((r) => r.json());

if (res.success) unlock(); // looks fine...
```

The problem: **`success` only tells you the key exists.** After a buyer is refunded, files a chargeback, or cancels a subscription, `/v2/licenses/verify` still returns `success: true`. The status lives in the `purchase` object, so a check on `success` alone lets refunded buyers keep using your app.

## The fix

Check the purchase flags too:

```js
function evaluate(res) {
  if (!res?.success) return { valid: false, reason: res?.message ?? "invalid license" };
  const p = res.purchase ?? {};
  if (p.refunded) return { valid: false, reason: "purchase refunded" };
  if (p.chargebacked) return { valid: false, reason: "purchase chargebacked" };
  if (p.disputed && !p.dispute_won) return { valid: false, reason: "purchase disputed" };
  if (p.subscription_ended_at) return { valid: false, reason: "subscription ended" };
  if (p.subscription_failed_at) return { valid: false, reason: "subscription payment failed" };
  return { valid: true, reason: "ok" };
}
```

Python:

```python
def evaluate(res):
    if not res or not res.get("success"):
        return {"valid": False, "reason": (res or {}).get("message", "invalid license")}
    p = res.get("purchase") or {}
    for flag in ("refunded", "chargebacked"):
        if p.get(flag):
            return {"valid": False, "reason": f"purchase {flag}"}
    if p.get("disputed") and not p.get("dispute_won"):
        return {"valid": False, "reason": "purchase disputed"}
    if p.get("subscription_ended_at") or p.get("subscription_failed_at"):
        return {"valid": False, "reason": "subscription inactive"}
    return {"valid": True, "reason": "ok"}
```

## Two more tips

1. **Send `increment_uses_count=false` on re-checks.** By default every verify call bumps the key's `uses` count, so if you count activations, routine re-checks will burn through them. Only increment on the first activation.
2. **Re-check now and then, not just once.** Refunds happen after activation. A re-check every few days catches them. If you do this, cache the last good result so your app doesn't break offline.

## Free code

Both versions (zero dependencies, with tests) are in this MIT repo: **https://github.com/NarwhalThePong/gumroad-license-check**

If you want the production version, with a signed offline cache and grace period, activation limits, and a small proxy server so your product ID and logic stay off the client, I sell it as the **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)**.


---
[All guides](./)
