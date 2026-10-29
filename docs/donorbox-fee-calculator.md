---
layout: page
title: "Donorbox fee calculator (2026): what your nonprofit keeps on Standard or Pro"
description: "Free Donorbox fee calculator for US nonprofits. The free Standard plan charges a 2.95% platform fee, Pro charges 1.75% for $150 a month, plus Stripe (2.2% + $0.30 nonprofit card rate, 0.8% ACH capped at $5) or PayPal (1.99% + $0.49). See the fees, what you keep and when Pro pays off."
---

Donorbox's free **Standard plan** charges a **2.95% platform fee** on each donation made through donation forms, donation pages and crowdfunding pages. The **Pro plan** costs **$150 a month** and lowers that fee to **1.75%**, and the Premium plan (price on request) lowers it to **1.6%**. On top of the platform fee you pay **one payment processing fee** to Stripe or PayPal: Donorbox lists the US nonprofit rates as **2.2% + $0.30 per card donation** with Stripe, **0.8% capped at $5** for ACH bank transfers, and **1.99% + $0.49** with PayPal. On Standard with Stripe card donations and no donor covering fees, 100 donations of $50 raise $5,000, the fees come to $288.00 and you keep $4,712.00, or 94.2%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="db" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Donorbox plan<br><select id="db-plan"><option value="standard" selected>Standard (free, 2.95%)</option><option value="pro">Pro ($150 a month, 1.75%)</option><option value="premium">Premium (1.6%, price on request, not included)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How donors pay<br><select id="db-method"><option value="card" selected>Card, Stripe nonprofit rate (2.2% + $0.30)</option><option value="cardstd">Card, Stripe standard rate (2.9% + $0.30)</option><option value="ach">ACH bank transfer (0.8%, max $5)</option><option value="paypal">PayPal nonprofit rate (1.99% + $0.49)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Donations this month<br><input id="db-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Typical donation (USD)<br><input id="db-pa" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Share of donors who cover the fees (%)<br><input id="db-cover" type="number" min="0" max="100" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="db-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Your month of donations</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Donations</td><td style="text-align:right"><span id="db-count">0</span></td></tr>
    <tr><td>Donors covering the fees</td><td style="text-align:right"><span id="db-covered">0</span></td></tr>
    <tr><td>Total raised</td><td style="text-align:right"><span id="db-raised">$0.00</span></td></tr>
    <tr><td>Platform fee per donation</td><td style="text-align:right"><span id="db-plat">$0.00</span></td></tr>
    <tr><td>Processing fee per donation</td><td style="text-align:right"><span id="db-proc">$0.00</span></td></tr>
    <tr><td>Fees you absorb in total</td><td style="text-align:right"><span id="db-fees">$0.00</span></td></tr>
    <tr><td>Plan subscription</td><td style="text-align:right"><span id="db-sub">$0.00</span></td></tr>
    <tr><td>Fees as a share of the total</td><td style="text-align:right"><span id="db-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="db-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Donations needed to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep this month after Donorbox's fees (USD)<br><input id="db-target" type="number" min="0" step="0.01" value="10000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="db-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Donorbox fee math for US nonprofits (checked 2026-10-29 from donorbox.org/pricing; Stripe standard card rate from stripe.com/pricing). All math in integer cents; Donorbox does not publish its rounding, so each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000;
  var PLANS = { standard: { rate: 295, monthly: 0 }, pro: { rate: 175, monthly: 15000 }, premium: { rate: 160, monthly: 0 } };
  var METHODS = { card: { rate: 220, fix: 30, cap: 0 }, cardstd: { rate: 290, fix: 30, cap: 0 }, ach: { rate: 80, fix: 0, cap: 500 }, paypal: { rate: 199, fix: 49, cap: 0 } };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function pct(v) { return Math.min(num(v), 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  function plan(p) { return PLANS[p] || PLANS.standard; }
  function method(m) { return METHODS[m] || METHODS.card; }
  function platform(c, p) { return c <= 0 ? 0 : half(c * plan(p).rate); }
  function processing(c, m) { if (c <= 0) return 0; var M = method(m), f = half(c * M.rate) + M.fix; return M.cap ? Math.min(f, M.cap) : f; }
  function fee(c, p, m) { return platform(c, p) + processing(c, m); }
  function covered(n, coverPct) { return Math.min(n, Math.floor(n * coverPct / 100 + 0.5)); }
  function partsC(n, A, p, m, coverPct) {
    var absorbed = n - covered(n, coverPct), raised = n * A, fees = absorbed * fee(A, p, m), sub = plan(p).monthly;
    return { raised: raised, absorbed: absorbed, fees: fees, sub: sub, net: raised - fees - sub };
  }
  function calc(n, pa, p, m, cover) {
    var N = count(n), A = cents(amt(pa)), P = partsC(N, A, p, m, pct(cover)), d = function (x) { return x / 100; };
    return { donations: N, coveredCount: N - P.absorbed, raised: d(P.raised), fees: d(P.fees), sub: d(P.sub), net: d(P.net), effective: P.raised > 0 ? (P.fees + P.sub) / P.raised : null, perPlatform: d(platform(A, p)), perProcessing: d(processing(A, m)), perFee: d(fee(A, p, m)) };
  }
  /* fewest donations in a month of size pa so that the amount kept >= target */
  function donationsFor(target, pa, p, m, cover) {
    var T = cents(big(target)), A = cents(amt(pa)), c = pct(cover);
    if (T <= 0 || A <= 0 || A - fee(A, p, m) <= 0) return null;
    var ok = function (n) { return partsC(n, A, p, m, c).net >= T; };
    if (!ok(MAX_QTY)) return null;
    var lo = 0, hi = MAX_QTY;
    while (lo < hi) { var k = Math.floor((lo + hi) / 2); if (ok(k)) hi = k; else lo = k + 1; }
    var P = partsC(lo, A, p, m, c);
    return { donations: lo, raised: P.raised / 100, net: P.net / 100 };
  }
  /* monthly card-donation volume above which Pro ($150/month, 1.75%) costs less than Standard (2.95%) */
  function proBreakEven() { return PLANS.pro.monthly / ((PLANS.standard.rate - PLANS.pro.rate) / 10000) / 100; }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, PLANS: PLANS, METHODS: METHODS, num: num, amt: amt, count: count, pct: pct, fee: fee, platform: platform, processing: processing, covered: covered, partsC: partsC, calc: calc, donationsFor: donationsFor, proBreakEven: proBreakEven };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.DbxFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.DbxFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var p = $("db-plan").value, me = $("db-method").value, n = $("db-n").value, pa = $("db-pa").value, cv = $("db-cover").value, w = [];
    var r = B.calc(n, pa, p, me, cv);
    if (B.amt(pa) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (Number(cv) > 100) w.push("The share of donors covering fees is capped at 100%.");
    $("db-warn").textContent = w.join(" ");
    set("db-count", r.donations.toLocaleString("en-US")); set("db-covered", r.coveredCount.toLocaleString("en-US")); set("db-raised", money(r.raised)); set("db-plat", money(r.perPlatform)); set("db-proc", money(r.perProcessing)); set("db-fees", money(r.fees)); set("db-sub", money(r.sub)); set("db-eff", pctS(r.effective)); set("db-net", money(r.net));
    var T = $("db-target").value, need = B.donationsFor(T, pa, p, me, cv);
    set("db-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(pa) <= 0 ? "Enter a typical donation amount." : need == null ? "No number of donations reaches that amount." : "You need " + need.donations.toLocaleString("en-US") + " donations of " + money(B.amt(pa)) + ", raising " + money(need.raised) + " and keeping " + money(need.net) + " after fees.");
  }
  ["db-plan", "db-method", "db-n", "db-pa", "db-cover", "db-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Donorbox fees in the US (checked Oct 29, 2026)

| Fee | Standard | Pro | Premium |
|---|---|---|---|
| Monthly cost | $0 | $150 (less with yearly billing) | price on request |
| Platform fee, donation forms, pages and crowdfunding | 2.95% | 1.75% | 1.6% |
| Platform fee, event ticketing and memberships | within Donorbox's listed 2.95% to 3.95% range | 2% | 2% |
| Stripe card (US nonprofit rate) | 2.2% + $0.30 | 2.2% + $0.30 | 2.2% + $0.30 |
| Stripe ACH bank transfer | 0.8%, capped at $5 | 0.8%, capped at $5 | 0.8%, capped at $5 |
| PayPal (US nonprofit rate) | 1.99% + $0.49 | 1.99% + $0.49 | 1.99% + $0.49 |

The processing rates are Stripe's and PayPal's discounted rates for registered US nonprofits, which you apply for with those processors. Without the discount, Stripe's standard card rate is 2.9% + $0.30, and the calculator offers it as an option. American Express cards cost more. Donors can choose to cover the fees at checkout, and then you receive the full donation. The $0.30 is charged on every card donation, so small donations lose a bigger share: a $10 card donation on Standard pays $0.82, which is 8.2% of it.

These figures come from Donorbox's own [pricing page](https://donorbox.org/pricing), and the standard card rate from [Stripe's pricing page](https://stripe.com/pricing). Donorbox does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It treats every donation as the same size, counts the Pro subscription as one month's cost against one month of donations, and leaves out refunds, disputes, crypto and stock gifts (3.95% in total), add-ons and kiosk fees. Your Donorbox and Stripe or PayPal dashboards are the final word.

## How the numbers are worked out

```
fee per donation = platform fee (2.95% Standard, 1.75% Pro, 1.6% Premium)
                 + processing (Stripe card 2.2% + $0.30, ACH 0.8% max $5, PayPal 1.99% + $0.49)
you keep         = total raised - fee x donations where you absorb the fees - Pro's $150 a month
```

On Standard, a $50 Stripe card donation pays a $1.48 platform fee and $1.40 processing, so 100 of them raise $5,000.00, the fees come to $288.00 and you keep $4,712.00. Paid by ACH, the same donations cost $188.00 and you keep $4,812.00, and through PayPal they cost $297.00 and you keep $4,703.00. Without Stripe's nonprofit discount the card fees are $323.00 and you keep $4,677.00. If 60 of the 100 donors cover the fees, you keep $4,884.80. On Pro, the same 100 card donations pay $228.00 in fees plus the $150 subscription, so you keep $4,622.00. A single $25 card donation on Standard pays $1.59 and leaves $23.41, a $100 donation pays $5.45 and leaves $94.55, and a $1,000 ACH donation pays $34.50 and leaves $965.50.

## FAQ

### How much does Donorbox take from donations?

On the free Standard plan Donorbox takes a 2.95% platform fee, and Stripe or PayPal take a processing fee on top. With Stripe's US nonprofit card rate of 2.2% + $0.30, a $50 donation pays $2.88 in total and you keep $47.12, unless the donor chooses to cover the fees.

### Is Donorbox free for nonprofits?

The Standard plan has no monthly fee, setup fee or cancellation fee. You pay only when a donation comes in: the 2.95% platform fee plus the payment processor's fee. Donors can cover those fees at checkout, in which case you receive the full donation.

### When is Donorbox Pro worth $150 a month?

Pro lowers the platform fee from 2.95% to 1.75%, which saves 1.2% of what you raise. That covers the $150 subscription once you raise $12,500 a month through donation forms and pages. At $12,500 from 250 donations of $50, both plans leave you $11,780.00. Below that Standard costs less, and above it Pro does.

### What percentage of donations do I keep on Donorbox?

On Standard with Stripe card donations and no donor covering fees, you keep 93.6% of a $25 donation, 94.2% of a $50 donation and 94.6% of a $100 donation. ACH gifts keep more because the bank fee is 0.8% and never more than $5.

### How many donations do I need to keep a set amount on Donorbox?

Divide the amount you want to keep by what each donation leaves after fees, which is $47.12 for a $50 card donation on Standard, then round up. The calculator above finds the exact number: to keep $10,000 with $50 card donations on Standard, you need 213 donations, raising $10,650.00 and keeping $10,036.56.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Donorbox take from donations?", "acceptedAnswer": {"@type": "Answer", "text": "On the free Standard plan Donorbox takes a 2.95% platform fee, and Stripe or PayPal take a processing fee on top. With Stripe's US nonprofit card rate of 2.2% + $0.30, a $50 donation pays $2.88 in total and you keep $47.12, unless the donor chooses to cover the fees."}},
{"@type": "Question", "name": "Is Donorbox free for nonprofits?", "acceptedAnswer": {"@type": "Answer", "text": "The Standard plan has no monthly fee, setup fee or cancellation fee. You pay only when a donation comes in: the 2.95% platform fee plus the payment processor's fee. Donors can cover those fees at checkout, in which case you receive the full donation."}},
{"@type": "Question", "name": "When is Donorbox Pro worth $150 a month?", "acceptedAnswer": {"@type": "Answer", "text": "Pro lowers the platform fee from 2.95% to 1.75%, which saves 1.2% of what you raise. That covers the $150 subscription once you raise $12,500 a month through donation forms and pages. At $12,500 from 250 donations of $50, both plans leave you $11,780.00. Below that Standard costs less, and above it Pro does."}},
{"@type": "Question", "name": "What percentage of donations do I keep on Donorbox?", "acceptedAnswer": {"@type": "Answer", "text": "On Standard with Stripe card donations and no donor covering fees, you keep 93.6% of a $25 donation, 94.2% of a $50 donation and 94.6% of a $100 donation. ACH gifts keep more because the bank fee is 0.8% and never more than $5."}},
{"@type": "Question", "name": "How many donations do I need to keep a set amount on Donorbox?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want to keep by what each donation leaves after fees, which is $47.12 for a $50 card donation on Standard, then round up. The calculator above finds the exact number: to keep $10,000 with $50 card donations on Standard, you need 213 donations, raising $10,650.00 and keeping $10,036.56."}}
]}
</script>

## Related tools and guides

- [Givebutter fee calculator (2026)](givebutter-fee-calculator): free with donor tips on, or a 3% platform fee plus 2.9% + $0.30 per card donation with tips off
- [GoFundMe fee calculator (2026)](gofundme-fee-calculator): no platform fee, just 2.9% + $0.30 per donation (2.2% + $0.30 for certified charities)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): what card payments cost on PayPal and Stripe

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Donorbox. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
