---
layout: page
title: "Venmo fee calculator (2026): goods and services, business profile and Instant Transfer fees"
description: "Free Venmo fee calculator for sellers. Compare the 2.99% goods-and-services fee on a personal profile with the business profile's 1.9% + $0.10 (2.29% + $0.09 for Tap to Pay), add Instant Transfer's 1.75% fee, and see your monthly and yearly take-home and the price to charge to keep a set amount."
---

Venmo is free for personal payments between friends, but **getting paid for goods or services is not**. A payment the sender marks as goods and services on a personal profile costs the seller **2.99%**. A **business profile** pays **1.9% + $0.10** per payment, or **2.29% + $0.09** for payments taken with Tap to Pay. Moving the money to your bank is free with a standard transfer, while **Instant Transfer** costs **1.75%** (minimum $0.25, maximum $25). Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="vm" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 260px;margin:0 0 8px"><label>How you get paid<br><select id="vm-mode" style="width:100%;max-width:320px"><option value="gs">Personal profile, goods and services (2.99%)</option><option value="biz">Business profile (1.9% + $0.10)</option><option value="tap">Business profile, Tap to Pay (2.29% + $0.09)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment amount (USD)<br><input id="vm-price" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month<br><input id="vm-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant Transfers per month (0 = standard, free)<br><input id="vm-inst" type="number" min="0" step="1" value="0" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="vm-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="vm-s-price">$0.00</td></tr>
    <tr><td>Venmo seller fee</td><td style="text-align:right" id="vm-s-fee">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="vm-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of the payment</td><td style="text-align:right" id="vm-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyers pay</td><td style="text-align:right" id="vm-m-gross">$0.00</td></tr>
    <tr><td>Venmo seller fees</td><td style="text-align:right" id="vm-m-fees">$0.00</td></tr>
    <tr><td>Instant Transfer fees</td><td style="text-align:right" id="vm-m-inst">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="vm-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what buyers paid</td><td style="text-align:right" id="vm-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="vm-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per payment after Venmo's fee (USD)<br><input id="vm-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="vm-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Venmo seller fee math (venmo.com/resources/our-fees "Fees with your Venmo Account", checked Oct 28, 2026): personal-profile payments marked as goods and services 2.99%; business profile 1.9% + $0.10; business profile via Tap to Pay 2.29% + $0.09; charity profile 1.9% + $0.10; Instant Transfer 1.75% (min $0.25, max $25), standard transfer $0. */
(function (root) {
  var CHECKED = "2026-10-28";
  var MODES = { gs: { pct: 0.0299, fixed: 0, label: "Personal profile, goods and services (2.99%)" }, biz: { pct: 0.019, fixed: 0.10, label: "Business profile (1.9% + $0.10)" }, tap: { pct: 0.0229, fixed: 0.09, label: "Business profile, Tap to Pay (2.29% + $0.09)" } };
  var IT_PCT = 0.0175, IT_MIN = 0.25, IT_MAX = 25, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function mode(m) { return MODES[m] ? m : "gs"; }
  function fee(p, m) { var M = MODES[mode(m)]; return p > 0 ? r2(p * M.pct + M.fixed) : 0; }
  function instantFee(x) { var a = amt(x); return a > 0 ? Math.min(Math.max(r2(a * IT_PCT), IT_MIN), IT_MAX) : 0; }
  function calc(p, m) {
    var price = amt(p); if (price <= 0) return { price: 0, fee: 0, net: 0, effective: null };
    var f = fee(price, m), net = r2(price - f);
    return { price: price, fee: f, net: net, effective: f / price };
  }
  /* Monthly: sales x fee, then optional Instant Transfers (the month's balance split evenly over n transfers). */
  function perMonth(p, m, q, instantCount) {
    var c = calc(p, m), n = count(q), gross = r2(c.price * n), fees = r2(c.fee * n), bal = r2(gross - fees), k = count(instantCount), inst = 0;
    if (k > 0 && bal > 0) { var each = r2(bal / k); inst = r2(instantFee(each) * k); }
    var net = r2(bal - inst);
    return { sale: c, count: n, gross: gross, fees: fees, instant: inst, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  /* Smallest price (to the cent) that keeps at least T per payment; rounding moves net by at most a cent, so scan up from just below. */
  function priceFor(T, m) {
    var target = amt(T), M = MODES[mode(m)], k = 1 - M.pct; if (target <= 0) return null;
    var c = Math.max(1, Math.floor((target - 0.01 + M.fixed) / k * 100));
    for (var i = 0; i < 200000 && c <= MAX_AMT * 100; i++, c++) if (calc(c / 100, m).net + 1e-9 >= target) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, MODES: MODES, IT_PCT: IT_PCT, IT_MIN: IT_MIN, IT_MAX: IT_MAX, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, mode: mode, fee: fee, instantFee: instantFee, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.VenmoFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.VenmoFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var md = $("vm-mode").value, p = $("vm-price").value, m = B.perMonth(p, md, $("vm-qty").value, $("vm-inst").value), c = m.sale, w = [];
    if (B.amt(p) >= B.MAX_AMT || B.count($("vm-qty").value) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (md === "gs" && c.price > 0) w.push("Personal profiles are meant for personal use; if you sell regularly, Venmo expects you to use a business profile.");
    $("vm-warn").textContent = w.join(" ");
    set("vm-s-price", money(c.price)); set("vm-s-fee", money(c.fee)); set("vm-s-net", money(c.net)); set("vm-s-eff", pctS(c.effective));
    set("vm-m-gross", money(m.gross)); set("vm-m-fees", money(m.fees)); set("vm-m-inst", money(m.instant));
    set("vm-m-net", money(m.net)); set("vm-m-eff", pctS(m.effective)); set("vm-y-net", money(m.year));
    var need = B.priceFor($("vm-target").value, md);
    set("vm-need", B.amt($("vm-target").value) <= 0 ? "Enter how much you want to keep per payment." : need == null ? "No price works for that amount." : "Charge " + money(need) + " to keep " + money(B.amt($("vm-target").value)) + " per payment after Venmo's fee for " + B.MODES[B.mode(md)].label + ".");
  }
  ["vm-mode", "vm-price", "vm-qty", "vm-inst", "vm-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Venmo fees for sellers (checked Oct 28, 2026)

| Fee | What it costs |
|---|---|
| Personal payment from a friend | Free. No fee when Venmo users send you personal payments. |
| Personal profile, payment marked as goods and services | 2.99% seller transaction fee, charged to you when the sender marks the payment as goods and services. |
| Business profile payment | 1.9% + $0.10 per payment. |
| Business profile payment through Tap to Pay | 2.29% + $0.09 per payment. |
| Charity profile payment | 1.9% + $0.10 per payment. |
| Standard transfer to your bank | Free, typically 1 to 3 business days to a linked bank account. |
| Instant Transfer to your bank or debit card | 1.75%, with a $0.25 minimum and a $25 maximum per transfer. Typically arrives in minutes. |
| Buyer paying with a credit card | The buyer, not the seller, pays 3% when sending money from a credit card to a personal account. |

All rates are from Venmo's own [fees page](https://venmo.com/resources/our-fees/), part of the Venmo User Agreement. Fees can change, so check that page and your transaction history for the exact amounts.

## How the numbers are worked out

```
seller fee     = payment x 2.99%           (personal, goods and services)
               = payment x 1.9% + $0.10    (business profile)
               = payment x 2.29% + $0.09   (business profile, Tap to Pay)
you keep       = payment - seller fee
instant fee    = transfer x 1.75%, at least $0.25 and at most $25
per month      = you keep x payments - Instant Transfer fees
```

A $100 payment keeps $97.01 on a personal profile marked as goods and services, $98.00 on a business profile, and $97.62 through Tap to Pay. A $20 business payment keeps $19.52. At 100 goods-and-services payments of $25 a month you keep $2,425.00, and moving that with one Instant Transfer costs the $25 maximum, leaving $2,400.00, or $28,800.00 a year. An Instant Transfer of $500 costs $8.75, and one of $10 costs the $0.25 minimum. To keep $100 per payment, charge $103.08 on a personal goods-and-services payment, $102.04 on a business profile, or $102.44 with Tap to Pay.

## FAQ

### How much does Venmo charge sellers in 2026?

On a personal profile, a payment marked as goods and services costs the seller 2.99%. On a business profile, each payment costs 1.9% + $0.10, or 2.29% + $0.09 through Tap to Pay. Personal payments between friends are free.

### Is a Venmo business profile cheaper than goods and services?

For most amounts, yes. On a $100 payment the business profile fee is $2.00 against $2.99 for goods and services on a personal profile. Because of the $0.10 fixed part, the business profile only costs more on payments under about $9.17.

### How much is Venmo Instant Transfer?

1.75% of the amount you move, with a $0.25 minimum and a $25 maximum per transfer. A standard transfer to your linked bank is free and usually takes 1 to 3 business days.

### Who pays the Venmo goods and services fee?

The seller, the person receiving the payment. The sender pays nothing extra unless they pay with a credit card, which adds a 3% fee for the sender.

### What should I charge on Venmo to keep a set amount?

Divide what you want to keep by 1 minus the percentage, after adding any fixed fee. For goods and services that is target / 0.9701, so keeping $100 means charging $103.08. On a business profile it is (target + $0.10) / 0.981, which gives $102.04.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Venmo charge sellers in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "On a personal profile, a payment marked as goods and services costs the seller 2.99%. On a business profile, each payment costs 1.9% + $0.10, or 2.29% + $0.09 through Tap to Pay. Personal payments between friends are free."}},
{"@type": "Question", "name": "Is a Venmo business profile cheaper than goods and services?", "acceptedAnswer": {"@type": "Answer", "text": "For most amounts, yes. On a $100 payment the business profile fee is $2.00 against $2.99 for goods and services on a personal profile. Because of the $0.10 fixed part, the business profile only costs more on payments under about $9.17."}},
{"@type": "Question", "name": "How much is Venmo Instant Transfer?", "acceptedAnswer": {"@type": "Answer", "text": "1.75% of the amount you move, with a $0.25 minimum and a $25 maximum per transfer. A standard transfer to your linked bank is free and usually takes 1 to 3 business days."}},
{"@type": "Question", "name": "Who pays the Venmo goods and services fee?", "acceptedAnswer": {"@type": "Answer", "text": "The seller, the person receiving the payment. The sender pays nothing extra unless they pay with a credit card, which adds a 3% fee for the sender."}},
{"@type": "Question", "name": "What should I charge on Venmo to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide what you want to keep by 1 minus the percentage, after adding any fixed fee. For goods and services that is target / 0.9701, so keeping $100 means charging $103.08. On a business profile it is (target + $0.10) / 0.981, which gives $102.04."}}
]}
</script>

## Related tools and guides

- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's own goods-and-services and checkout fees, next to Stripe's card fees
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Cash App for Business fee calculator (2026)](cash-app-fee-calculator): Cash App's 2.6% + $0.15 business payment fee and 3% Tap to Pay fee, side by side with Instant transfer costs
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator): set a rate that covers fees, taxes and time off
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from Venmo sales
- [Gumroad 1099-K taxes](gumroad-1099-k-taxes): how payment platforms report your sales to the IRS

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Venmo or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
