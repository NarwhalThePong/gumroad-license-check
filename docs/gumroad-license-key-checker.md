---
layout: page
title: "Gumroad license key checker: verify a key and see refunds, chargebacks and uses"
description: "Free Gumroad license key checker. Paste a product ID and license key to see if the key is valid, refunded, charged back, disputed or tied to an ended subscription, and how many times it has been used. Runs in your browser and does not increase the uses count."
---

Check a Gumroad license key without writing any code. Paste the product ID and the key, and this page asks Gumroad's public `/v2/licenses/verify` endpoint directly from your browser. It shows whether the key exists, whether the purchase was refunded, charged back or disputed, whether a subscription has ended, and how many times the key has been verified. It always sends `increment_uses_count=false`, so checking a key here does not use up an activation. The key goes only to Gumroad; this page has no server and stores nothing.

<div id="glk" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:680px">
  <p><label>Product ID<br><input id="glk-pid" type="text" autocomplete="off" spellcheck="false" placeholder="e.g. 32-nPAicqbLj8B_WswVlMw==" style="width:100%"></label><br>
  <small>Find it on your product's edit page under Content, in the license key section. Products created before January 9, 2023 can use the product permalink instead.</small></p>
  <p><label><input type="checkbox" id="glk-useperm"> Use the product permalink instead (older products)</label></p>
  <p><label>License key<br><input id="glk-key" type="text" autocomplete="off" spellcheck="false" placeholder="XXXXXXXX-XXXXXXXX-XXXXXXXX-XXXXXXXX" style="width:100%"></label></p>
  <p><button type="button" id="glk-go">Check key</button></p>
  <p id="glk-verdict" style="font-weight:bold"></p>
  <table id="glk-table" style="width:100%;display:none"><tbody id="glk-rows"></tbody></table>
  <p id="glk-note"></p>
</div>

<script>
(function () {
  /*check-start*/
  function maskEmail(e) {
    if (!e || e.indexOf("@") < 1) return e || "";
    var p = e.split("@"); return p[0].charAt(0) + "***@" + p[1];
  }
  function judge(data) {
    if (!data || data.success !== true || !data.purchase) {
      return { ok: false, verdict: "Not valid: " + ((data && data.message) || "Gumroad did not recognise this key for that product."), rows: [] };
    }
    var p = data.purchase, problems = [];
    if (p.refunded) problems.push("refunded");
    if (p.chargebacked) problems.push("charged back");
    if (p.disputed && !p.dispute_won) problems.push("disputed");
    if (p.subscription_ended_at) problems.push("subscription ended");
    if (p.subscription_cancelled_at) problems.push("subscription cancelled");
    if (p.subscription_failed_at) problems.push("subscription payment failed");
    var rows = [
      ["Product", p.product_name || ""],
      ["Bought", p.sale_timestamp || p.created_at || ""],
      ["Buyer", maskEmail(p.email)],
      ["Times verified (uses)", String(data.uses)],
      ["Quantity", p.quantity != null ? String(p.quantity) : ""],
      ["Variant", p.variants || ""],
      ["Refunded", p.refunded ? "yes" : "no"],
      ["Charged back", p.chargebacked ? "yes" : "no"],
      ["Disputed", p.disputed ? (p.dispute_won ? "yes (dispute won)" : "yes") : "no"],
      ["Subscription ended", p.subscription_ended_at || "no"],
      ["Subscription cancelled", p.subscription_cancelled_at || "no"],
      ["Subscription payment failed", p.subscription_failed_at || "no"],
      ["Test purchase", p.test ? "yes" : "no"]
    ];
    var verdict = problems.length
      ? "Key exists, but should be rejected: " + problems.join(", ") + "."
      : "Valid key in good standing" + (p.test ? " (test purchase)." : ".");
    return { ok: problems.length === 0, verdict: verdict, rows: rows };
  }
  function body(id, usePerm, key) {
    var f = new URLSearchParams();
    f.set(usePerm ? "product_permalink" : "product_id", id.trim());
    f.set("license_key", key.trim());
    f.set("increment_uses_count", "false");
    return f.toString();
  }
  /*check-end*/
  function $(i) { return document.getElementById(i); }
  function show(r) {
    $("glk-verdict").textContent = r.verdict;
    $("glk-verdict").style.color = r.ok ? "#1a7f37" : "#b42318";
    var tb = $("glk-rows"); tb.innerHTML = "";
    r.rows.forEach(function (x) {
      var tr = document.createElement("tr"), a = document.createElement("td"), b = document.createElement("td");
      a.textContent = x[0]; b.textContent = x[1]; b.style.textAlign = "right"; tr.appendChild(a); tr.appendChild(b); tb.appendChild(tr);
    });
    $("glk-table").style.display = r.rows.length ? "" : "none";
  }
  $("glk-go").addEventListener("click", function () {
    var id = $("glk-pid").value, key = $("glk-key").value;
    $("glk-note").textContent = "";
    if (!id.trim() || !key.trim()) { show({ ok: false, verdict: "Enter both the product ID and the license key.", rows: [] }); return; }
    $("glk-verdict").style.color = ""; $("glk-verdict").textContent = "Checking with Gumroad...";
    fetch("https://api.gumroad.com/v2/licenses/verify", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: body(id, $("glk-useperm").checked, key)
    }).then(function (res) { return res.json().catch(function () { return { success: false, message: "Gumroad returned HTTP " + res.status + "." }; }); })
      .then(function (d) { show(judge(d)); })
      .catch(function () { show({ ok: false, verdict: "Could not reach Gumroad. Check your connection and try again.", rows: [] }); });
  });
})();
</script>

## What the result means

- **Not valid** means Gumroad has no such key for that product. The most common cause is using the product permalink for a product created after January 9, 2023; those need the product ID.
- **Key exists, but should be rejected** means the key is real but the purchase was refunded, charged back, disputed, or belongs to a subscription that ended, was cancelled or failed to renew. Gumroad's verify call still returns `success: true` for these, which is why so many license checks let refunded buyers keep using the software. Your own check has to look at these fields; the [refunded license keys guide](refunded-gumroad-license-keys) shows how in Node and Python.
- **Times verified (uses)** is how many times the key has been verified with `increment_uses_count` left on. If you limit activations, compare this with your limit. This page never increases it.

## Checking keys in your own app

This tool is for spot checks and support tickets. In a shipped app, do the same check in code, cache the result so the app still works offline, and keep the product ID and rules on a small server rather than in the client. The [Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs/LAUNCH30) does all of that, with a signed offline cache, a grace period and activation limits. If you'd rather start from free code, see the open source [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check).

Related: [Gumroad fee calculator](gumroad-fee-calculator) and [bundle & discount calculator](gumroad-bundle-discount-calculator).
