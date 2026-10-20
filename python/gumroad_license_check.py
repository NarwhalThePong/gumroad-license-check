"""gumroad-license-check (Python 3.8+, standard library only). MIT License."""
import json
import urllib.error
import urllib.parse
import urllib.request

API_URL = "https://api.gumroad.com/v2/licenses/verify"


def evaluate(resp):
    """Gumroad returns success: true even for refunded purchases, so check the flags too."""
    if not resp or not resp.get("success"):
        return {"valid": False, "reason": (resp or {}).get("message", "invalid license")}
    p = resp.get("purchase") or {}
    if p.get("refunded"):
        return {"valid": False, "reason": "purchase refunded"}
    if p.get("chargebacked"):
        return {"valid": False, "reason": "purchase chargebacked"}
    if p.get("disputed") and not p.get("dispute_won"):
        return {"valid": False, "reason": "purchase disputed"}
    if p.get("subscription_ended_at"):
        return {"valid": False, "reason": "subscription ended"}
    if p.get("subscription_failed_at"):
        return {"valid": False, "reason": "subscription payment failed"}
    return {"valid": True, "reason": "ok", "purchase": p}


def _post(data, timeout):
    req = urllib.request.Request(API_URL, data=urllib.parse.urlencode(data).encode(), method="POST")
    try:
        with urllib.request.urlopen(req, timeout=timeout) as r:
            return json.load(r)
    except urllib.error.HTTPError as e:  # Gumroad sends JSON with 404 for unknown keys
        return json.load(e)


def verify_license(product_id, license_key, timeout=10, post=_post):
    return evaluate(post({"product_id": product_id, "license_key": str(license_key).strip(),
                          "increment_uses_count": "false"}, timeout))
