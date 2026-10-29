---
layout: page
title: "Givebutter fee calculator (2026): what your nonprofit keeps with tips on or off"
description: "Free Givebutter fee calculator for US nonprofits. With donor tips on there is no platform fee and Givebutter covers processing; with tips off it charges a 3% platform fee plus 2.9% + $0.30 per card donation (1.9% + $0.30 by ACH). See the fees, what you keep and how many donations you need."
---

Givebutter is free to use when you leave **donor tips on**: you pay no platform fee, donors are asked to cover the processing fee, and Givebutter says it covers any processing fee a donor doesn't, so you receive the full donation. If you **turn tips off**, Givebutter charges a **3% platform fee** plus processing of **2.9% + $0.30 per card donation** or **1.9% + $0.30 per ACH (bank) donation**, and you choose whether donors cover those fees. With tips off and no donor covering fees, 100 card donations of $50 raise $5,000, the fees come to $325.00 and you keep $4,675.00, or 93.5%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="gb" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Donor tips<br><select id="gb-mode"><option value="notips" selected>Off (3% platform fee + processing)</option><option value="tips">On (no platform fee, Givebutter covers processing)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How donors pay<br><select id="gb-method"><option value="card" selected>Card (2.9% + $0.30)</option><option value="ach">ACH bank transfer (1.9% + $0.30)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Number of donations<br><input id="gb-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Typical donation (USD)<br><input id="gb-pa" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Share of donors who cover the fees (%)<br><input id="gb-cover" type="number" min="0" max="100" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="gb-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Your campaign</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Donations</td><td style="text-align:right"><span id="gb-count">0</span></td></tr>
    <tr><td>Donors covering the fees</td><td style="text-align:right"><span id="gb-covered">0</span></td></tr>
    <tr><td>Total raised</td><td style="text-align:right"><span id="gb-raised">$0.00</span></td></tr>
    <tr><td>Platform fee per donation</td><td style="text-align:right"><span id="gb-plat">$0.00</span></td></tr>
    <tr><td>Processing fee per donation</td><td style="text-align:right"><span id="gb-proc">$0.00</span></td></tr>
    <tr><td>Fees you absorb in total</td><td style="text-align:right"><span id="gb-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of the total</td><td style="text-align:right"><span id="gb-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="gb-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Donations needed to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep after Givebutter's fees (USD)<br><input id="gb-target" type="number" min="0" step="0.01" value="10000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="gb-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Givebutter fee math for US nonprofits (checked 2026-10-29 from givebutter.com/pricing). All math in integer cents; Givebutter does not publish its rounding, so each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, PLATFORM = 300, FIX = 30, PROC = { card: 290, ach: 190 };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function pct(v) { return Math.min(num(v), 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  function platform(c, tips) { return tips || c <= 0 ? 0 : half(c * PLATFORM); }
  function processing(c, tips, method) { return tips || c <= 0 ? 0 : half(c * (PROC[method] || PROC.card)) + FIX; }
  function fee(c, tips, method) { return platform(c, tips) + processing(c, tips, method); }
  function covered(n, coverPct) { return Math.min(n, Math.floor(n * coverPct / 100 + 0.5)); }
  function partsC(n, A, tips, method, coverPct) {
    var absorbed = n - covered(n, coverPct), raised = n * A, fees = absorbed * fee(A, tips, method);
    return { raised: raised, absorbed: absorbed, fees: fees, net: raised - fees };
  }
  function calc(n, pa, mode, method, cover) {
    var N = count(n), A = cents(amt(pa)), tips = mode !== "notips", p = partsC(N, A, tips, method, pct(cover)), d = function (x) { return x / 100; };
    return { donations: N, coveredCount: N - p.absorbed, raised: d(p.raised), fees: d(p.fees), net: d(p.net), effective: p.raised > 0 ? p.fees / p.raised : null, perPlatform: d(platform(A, tips)), perProcessing: d(processing(A, tips, method)), perFee: d(fee(A, tips, method)) };
  }
  /* fewest donations of size pa so that the amount kept >= target */
  function donationsFor(target, pa, mode, method, cover) {
    var T = cents(big(target)), A = cents(amt(pa)), tips = mode !== "notips", c = pct(cover);
    if (T <= 0 || A <= 0 || A - fee(A, tips, method) <= 0) return null;
    var ok = function (n) { return partsC(n, A, tips, method, c).net >= T; };
    if (!ok(MAX_QTY)) return null;
    var lo = 0, hi = MAX_QTY;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (ok(m)) hi = m; else lo = m + 1; }
    var p = partsC(lo, A, tips, method, c);
    return { donations: lo, raised: p.raised / 100, net: p.net / 100 };
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, PLATFORM: PLATFORM, FIX: FIX, PROC: PROC, num: num, amt: amt, count: count, pct: pct, fee: fee, platform: platform, processing: processing, covered: covered, partsC: partsC, calc: calc, donationsFor: donationsFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.GbFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.GbFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var m = $("gb-mode").value, me = $("gb-method").value, n = $("gb-n").value, pa = $("gb-pa").value, cv = $("gb-cover").value, w = [];
    var r = B.calc(n, pa, m, me, cv);
    if (B.amt(pa) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (Number(cv) > 100) w.push("The share of donors covering fees is capped at 100%.");
    $("gb-warn").textContent = w.join(" ");
    set("gb-count", r.donations.toLocaleString("en-US")); set("gb-covered", r.coveredCount.toLocaleString("en-US")); set("gb-raised", money(r.raised)); set("gb-plat", money(r.perPlatform)); set("gb-proc", money(r.perProcessing)); set("gb-fees", money(r.fees)); set("gb-eff", pctS(r.effective)); set("gb-net", money(r.net));
    var T = $("gb-target").value, need = B.donationsFor(T, pa, m, me, cv);
    set("gb-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(pa) <= 0 ? "Enter a typical donation amount." : need == null ? "No number of donations reaches that amount." : "You need " + need.donations.toLocaleString("en-US") + " donations of " + money(B.amt(pa)) + ", raising " + money(need.raised) + " and keeping " + money(need.net) + " after fees.");
  }
  ["gb-mode", "gb-method", "gb-n", "gb-pa", "gb-cover", "gb-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Givebutter fees in the US (checked Oct 29, 2026)

| Fee | Tips on | Tips off |
|---|---|---|
| Platform fee | $0.00 | 3% of each donation |
| Card processing | covered by the donor or by Givebutter | 2.9% + $0.30 per donation |
| ACH (bank) processing | covered by the donor or by Givebutter | 1.9% + $0.30 per donation |
| Payouts | free | free |
| Monthly cost | $0 (Givebutter Plus is optional, from $29 a month) | $0 (Givebutter Plus is optional, from $29 a month) |

With tips off you can require donors to cover the fees, make covering them optional, or absorb them yourself. When a donor covers them, you receive the full donation; when you absorb them, they come out of the donation. The $0.30 is charged on every donation, so small donations lose a bigger share: a $10 card donation with tips off pays $0.89, which is 8.9% of it.

These figures come from Givebutter's own [pricing page](https://givebutter.com/pricing). Givebutter does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It treats every donation as the same size and leaves out refunds, disputes, other payment methods and the optional Givebutter Plus subscription. Your Givebutter dashboard is the final word.

## How the numbers are worked out

```
tips on:   you keep = total raised
tips off:  fee per donation = 3% platform + 2.9% + $0.30 card   (ACH: 1.9% + $0.30)
           you keep = total raised - fee x donations where you absorb the fees
```

With tips off, a $50 card donation pays a $1.50 platform fee and $1.75 processing, so 100 of them raise $5,000.00, the fees come to $325.00 and you keep $4,675.00. Paid by ACH, the same donations pay $275.00 and you keep $4,725.00. If 60 of the 100 donors cover the fees, you absorb them on only 40 donations and keep $4,870.00. With tips on you keep the full $5,000.00. A single $25 card donation pays $1.78 and leaves $23.22, and a $100 card donation pays $6.20 and leaves $93.80. Raise $50,000 from 500 card donations of $100 with tips off and you keep $46,900.00.

## FAQ

### How much does Givebutter take from donations?

Nothing if you keep donor tips on: there is no platform fee, and Givebutter says it covers any processing fee a donor doesn't. With tips off it takes a 3% platform fee plus 2.9% + $0.30 per card donation, which is $3.25 on a $50 donation, unless the donor chooses to cover the fees.

### Is Givebutter really free?

Yes, when donor tips are on. Givebutter makes its money from optional tips donors add at checkout, so your nonprofit pays no platform fee and no processing fee. Givebutter Plus, a paid add-on from $29 a month, is optional.

### What happens if I turn off tips on Givebutter?

A flat 3% platform fee applies to every donation, plus processing of 2.9% + $0.30 for cards or 1.9% + $0.30 for ACH. You can require donors to cover those fees, make it optional, or absorb them yourself.

### What percentage of donations do I keep on Givebutter with tips off?

If you absorb the fees on card donations, you keep 92.9% of a $25 donation, 93.5% of a $50 donation and 93.8% of a $100 donation. Every donor who covers the fees brings that donation back to 100%.

### How many donations do I need to keep a set amount on Givebutter?

Divide the amount you want to keep by what each donation leaves after fees, which is $46.75 for a $50 card donation with tips off, then round up. The calculator above finds the exact number: to keep $10,000 with $50 card donations and tips off, you need 214 donations, raising $10,700.00 and keeping $10,004.50.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Givebutter take from donations?", "acceptedAnswer": {"@type": "Answer", "text": "Nothing if you keep donor tips on: there is no platform fee, and Givebutter says it covers any processing fee a donor doesn't. With tips off it takes a 3% platform fee plus 2.9% + $0.30 per card donation, which is $3.25 on a $50 donation, unless the donor chooses to cover the fees."}},
{"@type": "Question", "name": "Is Givebutter really free?", "acceptedAnswer": {"@type": "Answer", "text": "Yes, when donor tips are on. Givebutter makes its money from optional tips donors add at checkout, so your nonprofit pays no platform fee and no processing fee. Givebutter Plus, a paid add-on from $29 a month, is optional."}},
{"@type": "Question", "name": "What happens if I turn off tips on Givebutter?", "acceptedAnswer": {"@type": "Answer", "text": "A flat 3% platform fee applies to every donation, plus processing of 2.9% + $0.30 for cards or 1.9% + $0.30 for ACH. You can require donors to cover those fees, make it optional, or absorb them yourself."}},
{"@type": "Question", "name": "What percentage of donations do I keep on Givebutter with tips off?", "acceptedAnswer": {"@type": "Answer", "text": "If you absorb the fees on card donations, you keep 92.9% of a $25 donation, 93.5% of a $50 donation and 93.8% of a $100 donation. Every donor who covers the fees brings that donation back to 100%."}},
{"@type": "Question", "name": "How many donations do I need to keep a set amount on Givebutter?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want to keep by what each donation leaves after fees, which is $46.75 for a $50 card donation with tips off, then round up. The calculator above finds the exact number: to keep $10,000 with $50 card donations and tips off, you need 214 donations, raising $10,700.00 and keeping $10,004.50."}}
]}
</script>

## Related tools and guides

- [GoFundMe fee calculator (2026)](gofundme-fee-calculator): no platform fee, just 2.9% + $0.30 per donation (2.2% + $0.30 for certified charities)
- [Indiegogo fee calculator (2026)](indiegogo-fee-calculator): Indiegogo's 5% platform fee plus 3% + $0.20 per payment, with no fees if the goal isn't reached
- [Kickstarter fee calculator (2026)](kickstarter-fee-calculator): Kickstarter's 5% fee plus 3% + $0.30 per pledge, charged only if the project is funded
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): what card payments cost on PayPal and Stripe

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Givebutter. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
