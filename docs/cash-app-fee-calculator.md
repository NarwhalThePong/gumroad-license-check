---
layout: page
title: "Cash App for Business fee calculator (2026): payment fees, Tap to Pay and Instant transfer"
description: "Free Cash App for Business fee calculator. See the 2.6% + $0.15 fee on each customer payment (3% with Tap to Pay), add an Instant transfer fee, and get your monthly and yearly take-home plus the price to charge to keep a set amount."
---

A Cash App Business account is free to open, but Cash App **deducts a fee from every payment you receive** on it. A payment from a customer's Cash App account costs **2.6% + $0.15**, and a payment you take in person with **Tap to Pay** costs **3%**. Moving your balance to your bank is free with a standard transfer, while an **Instant transfer** to your debit card costs **0.5% to 2.5%** (minimum $0.25 to $1, maximum $75), with the exact fee shown in the app before you confirm. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="ca" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 260px;margin:0 0 8px"><label>How you get paid<br><select id="ca-mode" style="width:100%;max-width:320px"><option value="cash">Customer pays from Cash App (2.6% + $0.15)</option><option value="tap">Tap to Pay, in person (3%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment amount (USD)<br><input id="ca-price" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month<br><input id="ca-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="ca-instant" type="checkbox"> Use Instant transfers</label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant transfers per month<br><input id="ca-inst" type="number" min="0" step="1" value="1" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant fee rate (%, 0.5 to 2.5)<br><input id="ca-rate" type="number" min="0.5" max="2.5" step="0.05" value="2.5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant fee minimum (USD, 0.25 to 1)<br><input id="ca-min" type="number" min="0.25" max="1" step="0.01" value="1" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="ca-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customer pays</td><td style="text-align:right" id="ca-s-price">$0.00</td></tr>
    <tr><td>Cash App processing fee</td><td style="text-align:right" id="ca-s-fee">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="ca-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of the payment</td><td style="text-align:right" id="ca-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customers pay</td><td style="text-align:right" id="ca-m-gross">$0.00</td></tr>
    <tr><td>Cash App processing fees</td><td style="text-align:right" id="ca-m-fees">$0.00</td></tr>
    <tr><td>Instant transfer fees</td><td style="text-align:right" id="ca-m-inst">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="ca-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what customers paid</td><td style="text-align:right" id="ca-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="ca-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per payment after Cash App's fee (USD)<br><input id="ca-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="ca-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Cash App Business fee math (cash.app/help/us/en-US/6521-cash-app-business-fees and 3073-withdrawal-transfer-speed-options, checked Oct 28, 2026): 2.6% + $0.15 per payment received from a customer's Cash App account; 3% per Tap to Pay payment; percentage fees rounded to the cent with banker's rounding (Cash App Business Terms, sec. 6); standard transfer free; Instant transfer 0.5%-2.5% (minimum $0.25-$1, maximum $75), exact fee shown in the app. */
(function (root) {
  var CHECKED = "2026-10-28";
  /* bp = percentage in hundredths of a percent, fixed in cents, so the math stays in whole cents. */
  var MODES = { cash: { bp: 260, fixed: 15, label: "Cash App payment (2.6% + $0.15)" }, tap: { bp: 300, fixed: 0, label: "Tap to Pay (3%)" } };
  var IT_PCT_LO = 0.5, IT_PCT_HI = 2.5, IT_MIN_LO = 0.25, IT_MIN_HI = 1, IT_MAX = 75, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function mode(m) { return MODES[m] ? m : "cash"; }
  function cents(x) { return Math.round(x * 100); }
  /* round n/d (n, d positive integers) to the nearest integer, ties to even */
  function bankers(n, d) { var q = Math.floor(n / d), r = n - q * d; if (2 * r > d) return q + 1; if (2 * r < d) return q; return q % 2 === 0 ? q : q + 1; }
  function feeCents(c, m) { var M = MODES[mode(m)]; return c > 0 ? bankers(c * M.bp, 10000) + M.fixed : 0; }
  function fee(p, m) { return feeCents(cents(amt(p)), m) / 100; }
  function clamp(x, lo, hi) { return Math.min(Math.max(x, lo), hi); }
  function instantRate(v) { var n = Number(v); return isFinite(n) && n > 0 ? clamp(n, IT_PCT_LO, IT_PCT_HI) : IT_PCT_HI; }
  function instantMin(v) { var n = Number(v); return isFinite(n) && n > 0 ? clamp(r2(n), IT_MIN_LO, IT_MIN_HI) : IT_MIN_HI; }
  function instantFee(x, rate, min) { var a = amt(x); return a > 0 ? Math.min(Math.max(r2(a * instantRate(rate) / 100), instantMin(min)), IT_MAX) : 0; }
  function calc(p, m) {
    var price = amt(p); if (price <= 0) return { price: 0, fee: 0, net: 0, effective: null };
    var c = cents(price), f = feeCents(c, m);
    return { price: price, fee: f / 100, net: (c - f) / 100, effective: f / c };
  }
  /* Monthly: payments x fee, then optional Instant transfers (the month's balance split evenly over k transfers). */
  function perMonth(p, m, q, k, rate, min) {
    var s = calc(p, m), n = count(q), gross = r2(s.price * n), fees = r2(s.fee * n), bal = r2(gross - fees), t = count(k), inst = 0;
    if (t > 0 && bal > 0) { var each = r2(bal / t); inst = r2(instantFee(each, rate, min) * t); }
    var net = r2(bal - inst);
    return { sale: s, count: n, gross: gross, fees: fees, instant: inst, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  /* Smallest price (to the cent) that keeps at least T per payment; net never drops as the price rises, so scan up from just below the estimate. */
  function priceFor(T, m) {
    var target = amt(T), M = MODES[mode(m)]; if (target <= 0) return null;
    var tc = cents(target), c = Math.max(1, Math.floor((tc + M.fixed) / (1 - M.bp / 10000)) - 2);
    for (var i = 0; i < 200000 && c <= MAX_AMT * 100; i++, c++) if (c - feeCents(c, m) >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, MODES: MODES, IT_PCT_LO: IT_PCT_LO, IT_PCT_HI: IT_PCT_HI, IT_MIN_LO: IT_MIN_LO, IT_MIN_HI: IT_MIN_HI, IT_MAX: IT_MAX, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, mode: mode, bankers: bankers, fee: fee, instantRate: instantRate, instantMin: instantMin, instantFee: instantFee, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.CashAppFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.CashAppFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var md = $("ca-mode").value, p = $("ca-price").value, on = $("ca-instant").checked, w = [];
    var m = B.perMonth(p, md, $("ca-qty").value, on ? $("ca-inst").value : 0, $("ca-rate").value, $("ca-min").value), c = m.sale;
    if (B.amt(p) >= B.MAX_AMT || B.count($("ca-qty").value) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (on && (Number($("ca-rate").value) !== B.instantRate($("ca-rate").value) || Number($("ca-min").value) !== B.instantMin($("ca-min").value))) w.push("Instant fee rate is kept between 0.5% and 2.5% and the minimum between $0.25 and $1, the range Cash App lists.");
    $("ca-warn").textContent = w.join(" ");
    set("ca-s-price", money(c.price)); set("ca-s-fee", money(c.fee)); set("ca-s-net", money(c.net)); set("ca-s-eff", pctS(c.effective));
    set("ca-m-gross", money(m.gross)); set("ca-m-fees", money(m.fees)); set("ca-m-inst", money(m.instant));
    set("ca-m-net", money(m.net)); set("ca-m-eff", pctS(m.effective)); set("ca-y-net", money(m.year));
    var need = B.priceFor($("ca-target").value, md);
    set("ca-need", B.amt($("ca-target").value) <= 0 ? "Enter how much you want to keep per payment." : need == null ? "No price works for that amount." : "Charge " + money(need) + " to keep " + money(B.amt($("ca-target").value)) + " per payment after Cash App's fee for a " + B.MODES[B.mode(md)].label + ".");
  }
  ["ca-mode", "ca-price", "ca-qty", "ca-instant", "ca-inst", "ca-rate", "ca-min", "ca-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Cash App for Business fees (checked Oct 28, 2026)

| Fee | What it costs |
|---|---|
| Opening a Cash App Business account | Free. No extra hardware needed. |
| Payment from a customer's Cash App account | 2.6% + $0.15 per payment, deducted before the money reaches your balance. |
| Payment accepted with Tap to Pay | 3% per payment. |
| Standard transfer to your bank | Free, usually arrives in 1 to 3 business days. |
| Instant transfer to your linked debit card | 0.5% to 2.5% of the amount, with a minimum of $0.25 to $1 and a maximum of $75. Cash App shows the exact fee before you confirm. |

Rates are from Cash App's own help pages: [Cash App Business Fees](https://cash.app/help/us/en-US/6521-cash-app-business-fees) and [Withdrawal Transfer Speed Options](https://cash.app/help/us/en-US/3073-withdrawal-transfer-speed-options). The [Cash App Business Terms](https://cash.app/us/en/legal/cash-payment-terms) say percentage fees are rounded to the cent with banker's rounding (an exact half cent goes to the nearest even cent), which this calculator copies. Cash App doesn't publish a single Instant transfer rate, so the calculator starts at the top of its range (2.5%, $1 minimum); change it to the rate your app shows. Fees can change, so check your Activity tab for the exact amounts.

## How the numbers are worked out

```
processing fee = payment x 2.6% + $0.15    (customer pays from Cash App)
               = payment x 3%              (Tap to Pay)
you keep       = payment - processing fee
instant fee    = transfer x rate (0.5% to 2.5%), at least the minimum ($0.25 to $1), at most $75
per month      = you keep x payments - Instant transfer fees
```

A $100 payment from a customer's Cash App account costs $2.75, so you keep $97.25. The same $100 through Tap to Pay keeps $97.00. A $20 payment keeps $19.33, and a $25 payment keeps $24.20. At 100 payments of $25 a month you keep $2,420.00, or $29,040.00 a year with free standard transfers. Moving that $2,420.00 with one Instant transfer at 2.5% costs $60.50, leaving $2,359.50; at 0.5% it costs $12.10. To keep $100 per payment, charge $102.82 for a Cash App payment or $103.09 with Tap to Pay.

## FAQ

### How much does Cash App charge businesses in 2026?

A Cash App Business account pays 2.6% + $0.15 on each payment received from a customer's Cash App account, and 3% on each payment accepted with Tap to Pay. The account itself is free to open.

### How much is the Cash App fee on $100?

For a payment from a customer's Cash App account, $2.75 (2.6% of $100 is $2.60, plus $0.15), so you receive $97.25. Through Tap to Pay the fee is $3.00 and you keep $97.00.

### How much does a Cash App Instant transfer cost?

Cash App lists 0.5% to 2.5% of the amount, with a minimum of $0.25 to $1 and a maximum of $75, and shows the exact fee before you confirm. A standard transfer to your bank is free and usually takes 1 to 3 business days.

### Do I pay fees on a personal Cash App account?

Cash App's processing fee applies to payments received on a Cash App Business account. Cash App asks you to use the business account for business payments, the sale of goods or services, and to keep personal payments on your personal account so you aren't charged fees on them.

### What should I charge on Cash App to keep a set amount?

Add the $0.15 to what you want to keep and divide by 0.974, then round up to the cent. Keeping $100 means charging $102.82. With Tap to Pay, divide by 0.97, which gives $103.09.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Cash App charge businesses in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "A Cash App Business account pays 2.6% + $0.15 on each payment received from a customer's Cash App account, and 3% on each payment accepted with Tap to Pay. The account itself is free to open."}},
{"@type": "Question", "name": "How much is the Cash App fee on $100?", "acceptedAnswer": {"@type": "Answer", "text": "For a payment from a customer's Cash App account, $2.75 (2.6% of $100 is $2.60, plus $0.15), so you receive $97.25. Through Tap to Pay the fee is $3.00 and you keep $97.00."}},
{"@type": "Question", "name": "How much does a Cash App Instant transfer cost?", "acceptedAnswer": {"@type": "Answer", "text": "Cash App lists 0.5% to 2.5% of the amount, with a minimum of $0.25 to $1 and a maximum of $75, and shows the exact fee before you confirm. A standard transfer to your bank is free and usually takes 1 to 3 business days."}},
{"@type": "Question", "name": "Do I pay fees on a personal Cash App account?", "acceptedAnswer": {"@type": "Answer", "text": "Cash App's processing fee applies to payments received on a Cash App Business account. Cash App asks you to use the business account for business payments, the sale of goods or services, and to keep personal payments on your personal account so you aren't charged fees on them."}},
{"@type": "Question", "name": "What should I charge on Cash App to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Add the $0.15 to what you want to keep and divide by 0.974, then round up to the cent. Keeping $100 means charging $102.82. With Tap to Pay, divide by 0.97, which gives $103.09."}}
]}
</script>

## Related tools and guides

- [Venmo fee calculator (2026)](venmo-fee-calculator): Venmo's 2.99% goods-and-services fee against its business profile's 1.9% + $0.10
- [Square fee calculator (2026)](square-fee-calculator): Square's card fees on Square Free, Plus and Premium, from 2.6% + 15¢ in person to 3.5% + 15¢ keyed in, plus Instant transfer costs
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's own goods-and-services and checkout fees, next to Stripe's card fees
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator): set a rate that covers fees, taxes and time off
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales
- [Gumroad 1099-K taxes](gumroad-1099-k-taxes): how payment platforms report your sales to the IRS

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Cash App or Block, Inc. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
