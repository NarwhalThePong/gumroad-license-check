---
layout: page
title: "itch.io fee calculator (2026): open revenue share, PayPal and Stripe fees and what you keep"
description: "Free itch.io fee calculator for game developers and creators. Enter your price, sales per month and your open revenue share (0% to 100%, default 10%) to see itch.io's cut, the $0.30 + 2.9% PayPal or Stripe processing fee, your monthly and yearly take-home, and the price to charge to keep a set amount."
---

itch.io uses **open revenue sharing**: you choose what share of each sale goes to itch.io, anywhere from 0% to 100%, and the default is **10%**. On top of that, the payment processor (PayPal or Stripe) takes a fee on every transaction, generally **$0.30 + 2.9%** of the price. That processing fee applies whether you are paid directly or through itch.io's payout system. Enter your numbers below to see what you actually keep. Everything runs in your browser and nothing is sent anywhere.

<div id="it" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price the buyer pays, including any extra in pay-what-you-want (USD)<br><input id="it-price" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your open revenue share to itch.io (%)<br><input id="it-share" type="number" min="0" max="100" step="1" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="it-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payout transfer fees per month, if any (USD)<br><input id="it-payout" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="it-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="it-s-price">$0.00</td></tr>
    <tr><td>itch.io revenue share</td><td style="text-align:right" id="it-s-share">$0.00</td></tr>
    <tr><td>PayPal or Stripe fee ($0.30 + 2.9%)</td><td style="text-align:right" id="it-s-proc">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="it-s-net">$0.00</strong></td></tr>
    <tr><td>Total fees as a share of the price</td><td style="text-align:right" id="it-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyers pay</td><td style="text-align:right" id="it-m-gross">$0.00</td></tr>
    <tr><td>itch.io revenue share</td><td style="text-align:right" id="it-m-share">$0.00</td></tr>
    <tr><td>Processing fees</td><td style="text-align:right" id="it-m-proc">$0.00</td></tr>
    <tr><td>Payout transfer fees</td><td style="text-align:right" id="it-m-payout">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="it-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what buyers paid</td><td style="text-align:right" id="it-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="it-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after the revenue share and processing (USD)<br><input id="it-target" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="it-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* itch.io fee math. Open revenue share: seller picks 0% to 100%, default 10%, taken from the price; then the payment processor fee, generally $0.30 + 2.9% of the total price for PayPal and Stripe, applies per transaction in both payout modes (itch.io Creator docs "Accepting Payments and Getting Paid", itch.io/docs/creators/payments; open revenue sharing announcement itch.io/updates/open-revenue-sharing). Payouts mode: one-time $3.00 tax identity fee and payout transfer fees passed on (same doc). Checked Oct 28, 2026. */
(function (root) {
  var CHECKED = "2026-10-28";
  var DEFAULT_SHARE = 10, PROC_PCT = 0.029, PROC_FIXED = 0.30, TAX_ID_FEE = 3, MIN_PAYOUT = 5;
  var MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function sharePct(v) { if (v === "" || v === null || v === undefined) return DEFAULT_SHARE; var n = Number(v); if (!isFinite(n)) return DEFAULT_SHARE; return Math.min(Math.max(n, 0), 100); }
  function procFee(p) { return p > 0 ? r2(p * PROC_PCT + PROC_FIXED) : 0; }
  function calc(p, s) {
    var price = amt(p); if (price <= 0) return { price: 0, share: 0, proc: 0, net: 0, effective: null };
    var share = r2(price * sharePct(s) / 100), proc = procFee(price), net = r2(price - share - proc);
    return { price: price, share: share, proc: proc, net: net, effective: (share + proc) / price };
  }
  function perMonth(p, s, q, payoutFee) {
    var c = calc(p, s), n = count(q), gross = r2(c.price * n), share = r2(c.share * n), proc = r2(c.proc * n), pf = amt(payoutFee);
    var net = r2(gross - share - proc - pf);
    return { sale: c, count: n, gross: gross, share: share, proc: proc, payout: pf, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  /* Smallest price (to the cent) that keeps at least T per sale; null when the share plus 2.9% leaves nothing.
     Rounding moves net by at most a cent, so every price whose unrounded net is below T - $0.01 fails; scan up from there. */
  function priceFor(T, s) {
    var target = amt(T), k = 1 - sharePct(s) / 100 - PROC_PCT; if (target <= 0 || k <= 1e-9) return null;
    var c = Math.max(1, Math.floor((target - 0.01 + PROC_FIXED) / k * 100));
    for (var i = 0; i < 200000 && c <= MAX_AMT * 100; i++, c++) if (calc(c / 100, s).net + 1e-9 >= target) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, DEFAULT_SHARE: DEFAULT_SHARE, PROC_PCT: PROC_PCT, PROC_FIXED: PROC_FIXED, TAX_ID_FEE: TAX_ID_FEE, MIN_PAYOUT: MIN_PAYOUT, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, sharePct: sharePct, procFee: procFee, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.ItchFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.ItchFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var p = $("it-price").value, s = $("it-share").value, m = B.perMonth(p, s, $("it-qty").value, $("it-payout").value), c = m.sale, w = [];
    var raw = Number(s);
    if (s !== "" && (!isFinite(raw) || raw < 0 || raw > 100)) w.push("The revenue share can only be set from 0% to 100%, so it was clamped.");
    if (c.price > 0 && c.price < 2) w.push("itch.io suggests charging at least $2, because the $0.30 fixed fee is a large part of small payments.");
    if (c.net < 0) w.push("At this price and share the fees are more than the sale.");
    if (B.amt(p) >= B.MAX_AMT || B.count($("it-qty").value) >= B.MAX_QTY) w.push("Large numbers are capped.");
    $("it-warn").textContent = w.join(" ");
    set("it-s-price", money(c.price)); set("it-s-share", money(c.share)); set("it-s-proc", money(c.proc)); set("it-s-net", money(c.net)); set("it-s-eff", pctS(c.effective));
    set("it-m-gross", money(m.gross)); set("it-m-share", money(m.share)); set("it-m-proc", money(m.proc)); set("it-m-payout", money(m.payout));
    set("it-m-net", money(m.net)); set("it-m-eff", pctS(m.effective)); set("it-y-net", money(m.year));
    var need = B.priceFor($("it-target").value, s);
    set("it-need", B.amt($("it-target").value) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works: at this revenue share the fees take the whole sale." : "Charge " + money(need) + " to keep " + money(B.amt($("it-target").value)) + " per sale after a " + B.sharePct(s) + "% revenue share and the $0.30 + 2.9% processing fee.");
  }
  ["it-price", "it-share", "it-qty", "it-payout", "it-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## itch.io fees for creators (checked Oct 28, 2026)

| Fee | What it is |
|---|---|
| Open revenue share | You choose 0% to 100% of each sale for itch.io in your seller settings. The default is 10%. It is taken from the price the buyer pays. |
| Payment processing | PayPal and Stripe each charge a per-transaction fee, generally $0.30 + 2.9% of the total price. It applies in both payout modes. |
| Currency conversion | Depending on your PayPal account, there may be extra currency conversion fees. The itch.io payout system pays in USD only. |
| Payout transfer fees (itch.io payouts only) | When itch.io sends your payout by PayPal or Payoneer, the transfer fee is passed on to you. itch.io recommends requesting a payout about once a month. Minimum payout is $5. |
| Tax identity check (itch.io payouts only) | A one-time flat $3.00 fee for verifying the tax information you give in the tax interview. |
| Unclaimed earnings | Money left on your itch.io balance for over a year may be charged a maintenance fee. |
| Chargebacks | In payouts mode itch.io is liable, but chargeback fees may be passed on if your account has a high dispute rate. |

The open revenue share and processing fees are from itch.io's [Accepting Payments and Getting Paid](https://itch.io/docs/creators/payments) guide for creators, which also covers payout modes, payout fees and the $3 tax identity fee. The 10% default is from itch.io's [Introducing open revenue sharing](https://itch.io/updates/open-revenue-sharing) post, and the [Creator FAQ](https://itch.io/docs/creators/faq) confirms that itch.io is free to use. Processing fees can vary slightly by buyer and country, so check your payout summary for the exact amounts.

## How the numbers are worked out

```
revenue share  = price x your share (0% to 100%, default 10%)
processing     = price x 2.9% + $0.30
you keep       = price - revenue share - processing
per month      = you keep x sales - payout transfer fees
```

This is itch.io's own worked example: a $10 sale at the default 10% keeps $8.41, with $1.00 to itch.io and $0.59 for processing. At 100 sales a month that is $841, or $10,092 a year. Set the share to 0% and the same sale keeps $9.41. A $2 game at 10% keeps $1.44, and a $1 game keeps only $0.57, because the $0.30 fixed fee is so large on small prices. To keep $10 a sale at 10%, charge $11.82.

## FAQ

### How much does itch.io take from sales in 2026?

You choose. itch.io's open revenue share lets you set anywhere from 0% to 100% of each sale for itch.io, and the default is 10%. PayPal or Stripe also takes a processing fee, generally $0.30 + 2.9%, so a $10 sale at the default keeps $8.41.

### Can I set the itch.io revenue share to 0%?

Yes. The slider in your seller settings goes from 0% to 100%. At 0% you still pay the payment processor's fee, so a $10 sale keeps $9.41.

### Does itch.io charge fees on payouts?

If you use the "collected by itch.io, paid later" payout system, the PayPal or Payoneer transfer fee is passed on to you, plus a one-time $3.00 tax identity verification fee. Paid directly to your own PayPal or Stripe account, the money arrives per sale and only the processor's fees apply.

### What is the minimum price I should charge on itch.io?

itch.io recommends at least $2. The $0.30 fixed processing fee is 30% of a $1 payment and 15% of a $2 payment, so very low prices lose a large share to fees.

### What price should I charge on itch.io to keep a set amount?

Use the calculator's price-to-keep box. As a rule of thumb, add $0.30 to your target and divide by 1 minus your share minus 2.9%. At the default 10%, that is (target + $0.30) / 0.871, so keeping $10 means charging about $11.83 (the calculator's exact answer is $11.82, because fees round to the cent).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does itch.io take from sales in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "You choose. itch.io's open revenue share lets you set anywhere from 0% to 100% of each sale for itch.io, and the default is 10%. PayPal or Stripe also takes a processing fee, generally $0.30 + 2.9%, so a $10 sale at the default keeps $8.41."}},
{"@type": "Question", "name": "Can I set the itch.io revenue share to 0%?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. The slider in your seller settings goes from 0% to 100%. At 0% you still pay the payment processor's fee, so a $10 sale keeps $9.41."}},
{"@type": "Question", "name": "Does itch.io charge fees on payouts?", "acceptedAnswer": {"@type": "Answer", "text": "If you use the \"collected by itch.io, paid later\" payout system, the PayPal or Payoneer transfer fee is passed on to you, plus a one-time $3.00 tax identity verification fee. Paid directly to your own PayPal or Stripe account, the money arrives per sale and only the processor's fees apply."}},
{"@type": "Question", "name": "What is the minimum price I should charge on itch.io?", "acceptedAnswer": {"@type": "Answer", "text": "itch.io recommends at least $2. The $0.30 fixed processing fee is 30% of a $1 payment and 15% of a $2 payment, so very low prices lose a large share to fees."}},
{"@type": "Question", "name": "What price should I charge on itch.io to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Use the calculator's price-to-keep box. As a rule of thumb, add $0.30 to your target and divide by 1 minus your share minus 2.9%. At the default 10%, that is (target + $0.30) / 0.871, so keeping $10 means charging about $11.83 (the calculator's exact answer is $11.82, because fees round to the cent)."}}
]}
</script>

## Related tools and guides

- [Bandcamp fee calculator (2026)](bandcamp-fee-calculator): Bandcamp's 15% or 10% revenue share, for soundtracks and music sold next to an itch.io page
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): the card and PayPal fees behind every itch.io sale
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Gumroad fee calculator](gumroad-fee-calculator): Gumroad's 10% + 50¢ fee, for creators selling games and assets in both places
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from game sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with itch.io. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
