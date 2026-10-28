---
layout: page
title: "Buy Me a Coffee fee calculator (2026): 5% platform fee, Stripe processing, international, membership and payout fees"
description: "Free Buy Me a Coffee fee calculator. Enter your support or membership price, number of payments, where supporters are and who covers the card fee to see the 5% platform fee, Stripe processing, the international and subscription add-ons, the payout fee and what you keep per payment and per month."
---

Buy Me a Coffee has **no monthly fee** and takes a **5% platform fee** on each payment, so you keep 95% before card processing. Payments go through Stripe at **2.9% + 30¢**, plus **1% for supporters outside the US** and **0.5% for membership (subscription) payments**, and Stripe takes **0.5% when your money is paid out**. You can let supporters cover the card fee instead. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="bm" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per payment (USD)<br><input id="bm-price" type="number" min="0" step="0.01" value="5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month<br><input id="bm-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment type<br><select id="bm-type"><option value="onetime" selected>One-time support, shop or commission</option><option value="membership">Monthly or yearly membership (+0.5%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Where the supporter is<br><select id="bm-where"><option value="us" selected>United States</option><option value="intl">Outside the US (+1%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Who pays the card fee<br><select id="bm-cover"><option value="creator" selected>I cover it (default)</option><option value="supporter">Supporter pays it on top</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="bm-payout" type="checkbox" checked> Include the 0.5% payout fee</label></p>
  <p id="bm-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Supporter pays</td><td style="text-align:right" id="bm-o-paid">$0.00</td></tr>
    <tr><td>Buy Me a Coffee platform fee (5%)</td><td style="text-align:right" id="bm-o-plat">$0.00</td></tr>
    <tr><td>Card processing (<span id="bm-o-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="bm-o-proc">$0.00</td></tr>
    <tr><td>Payout fee (<span id="bm-o-payrate">0.5%</span>)</td><td style="text-align:right" id="bm-o-pay">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right"><strong id="bm-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per payment</td><td style="text-align:right"><strong id="bm-o-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of your price</td><td style="text-align:right" id="bm-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Supporters pay in total</td><td style="text-align:right" id="bm-m-gross">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right" id="bm-m-fee">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="bm-m-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount per payment</h3>
  <p style="margin:0 0 8px"><label>I want to keep (USD)<br><input id="bm-target" type="number" min="0" step="0.01" value="5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="bm-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Buy Me a Coffee fee math. Rates from help.buymeacoffee.com "How to calculate charges on your payment?" (Mar 18, 2026), "How to eliminate the credit card fee from your earnings?" (Jul 27, 2026), buymeacoffee.com/faq and Terms of Use (updated 10/12/2026), checked Oct 28, 2026. USD only. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLAT_PCT = 5, PROC_PCT = 2.9, PROC_FIXED = 0.30, INTL_PCT = 1, SUB_PCT = 0.5, PAYOUT_PCT = 0.5;
  var MAX_PRICE = 1000000, MAX_SALES = 1000000;
  function r2(n) { return Math.round(n * 100 + 1e-7) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function procPct(o) { o = o || {}; return PROC_PCT + (o.where === "intl" ? INTL_PCT : 0) + (o.type === "membership" ? SUB_PCT : 0); }
  function payoutPct(o) { o = o || {}; return o.payout === false ? 0 : PAYOUT_PCT; }
  function perSale(p, o) {
    o = o || {}; p = price(p);
    var pp = procPct(o), procFee = p > 0 ? r2(p * pp / 100 + PROC_FIXED) : 0;
    var supporter = o.cover === "supporter";
    var paid = supporter ? r2(p + procFee) : p;
    var platFee = p > 0 ? r2(p * PLAT_PCT / 100) : 0;
    var creatorProc = supporter ? 0 : procFee;
    var beforePayout = r2(p - platFee - creatorProc);
    var payFee = p > 0 ? r2(Math.max(0, beforePayout) * payoutPct(o) / 100) : 0;
    var fee = r2(platFee + creatorProc + payFee);
    return { price: p, paid: paid, procPct: pp, procFee: procFee, supporterPaysProc: supporter, platFee: platFee, payPct: payoutPct(o), payFee: payFee, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function monthly(p, n, o) {
    var s = perSale(p, o), q = sales(n);
    return { sales: q, gross: r2(s.paid * q), fee: r2(s.fee * q), net: r2(s.net * q) };
  }
  function priceFor(target, o) {
    o = o || {}; var k = price(target); if (!(k > 0)) return null;
    var f = (PLAT_PCT + (o.cover === "supporter" ? 0 : procPct(o))) / 100, fixed = o.cover === "supporter" ? 0 : PROC_FIXED;
    var g = (1 - f) * (1 - payoutPct(o) / 100); if (g <= 0) return null;
    var p = Math.max(0.01, Math.ceil(((k / g) + fixed) * 100 - 1e-6) / 100);
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, PLAT_PCT: PLAT_PCT, PROC_PCT: PROC_PCT, PROC_FIXED: PROC_FIXED, INTL_PCT: INTL_PCT, SUB_PCT: SUB_PCT, PAYOUT_PCT: PAYOUT_PCT,
    MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES, price: price, sales: sales, procPct: procPct, payoutPct: payoutPct, perSale: perSale, monthly: monthly, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.BmcFees = api;
})(this);
(function () {
  var F = window.BmcFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var rawP = $("bm-price").value, rawN = $("bm-qty").value;
    var o = { type: $("bm-type").value, where: $("bm-where").value, cover: $("bm-cover").value, payout: $("bm-payout").checked };
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Payments capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawP) < 0 || Number(rawN) < 0) w.push("Negative numbers are treated as 0.");
    var s = F.perSale(rawP, o), m = F.monthly(rawP, rawN, o);
    if (s.supporterPaysProc && s.price > 0) w.push("The supporter pays " + money(s.procFee) + " extra for the card fee, so it does not come out of your earnings.");
    set("bm-warn", w.join(" "));
    set("bm-o-paid", money(s.paid)); set("bm-o-plat", money(s.platFee));
    set("bm-o-procrate", (Math.round(s.procPct * 10) / 10) + "% + " + money(F.PROC_FIXED) + (s.supporterPaysProc ? ", paid by supporter" : ""));
    set("bm-o-proc", money(s.supporterPaysProc ? 0 : s.procFee));
    set("bm-o-payrate", s.payPct + "%"); set("bm-o-pay", money(s.payFee));
    set("bm-o-fee", money(s.fee)); set("bm-o-net", money(s.net)); set("bm-o-eff", pctS(s.effective));
    set("bm-m-gross", money(m.gross)); set("bm-m-fee", money(m.fee)); set("bm-m-net", money(m.net));
    var need = F.priceFor($("bm-target").value, o);
    set("bm-need", need == null ? "Enter how much you want to keep per payment." : "Charge " + money(need) + " to keep at least " + money(F.price($("bm-target").value)) + " per payment with these options.");
  }
  ["bm-price", "bm-qty", "bm-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["bm-type", "bm-where", "bm-cover", "bm-payout"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Buy Me a Coffee fees (checked Oct 28, 2026)

| Fee | Amount | Applies to |
|---|---|---|
| Platform fee | 5% | Every payment (one-time support, memberships, shop items, commissions) |
| Card processing (Stripe) | 2.9% + $0.30 | Every payment; you cover it by default, or supporters can pay it on top |
| International add-on | +1% | Supporters outside the US |
| Subscription add-on | +0.5% | Membership (recurring) payments |
| Payout processing | 0.5% | Money paid out to your Stripe account |
| Monthly fee | $0 | No paid plans |

Sources: [How to calculate charges on your payment?](https://help.buymeacoffee.com/en/articles/8105744-how-to-calculate-charges-on-your-payment) (March 18, 2026), [How to eliminate the credit card fee from your earnings?](https://help.buymeacoffee.com/en/articles/8105320-how-to-eliminate-the-credit-card-fee-from-your-earnings) (July 27, 2026), the [Buy Me a Coffee FAQ](https://buymeacoffee.com/faq) and [Terms of Use](https://buymeacoffee.com/terms) (updated October 12, 2026), all checked Oct 28, 2026. The terms say processing fees can vary by location, currency and payment method, and that payout minimums and currency conversion charges may apply, so treat these numbers as estimates and check your dashboard. Payouts start once your balance reaches $10 and go to Stripe every Wednesday.

## How the numbers are worked out

```
platform fee     = price x 5%
card processing  = price x (2.9% + 1% if outside the US + 0.5% if membership) + $0.30
payout fee       = (price - platform fee - card processing) x 0.5%
you keep         = price - platform fee - card processing - payout fee
```

A $5 one-time support from a US supporter costs $0.25 (5%) + $0.45 (2.9% + $0.30) = $0.70, and the 0.5% payout fee takes another $0.02, so you keep $4.28, an effective 14.4%. If the supporter covers the card fee they pay $5.45 and you keep $4.73. A $5 membership from a supporter outside the US costs $0.25 + $0.52 (4.4% + $0.30) + $0.02, so you keep $4.21.

**Small amounts lose the most.** The fixed 30¢ is 10% of a $3 coffee, so turning on "supporter covers the card fee" or nudging people toward larger amounts matters most at low prices.

## FAQ

### How much does Buy Me a Coffee take?

Buy Me a Coffee takes a 5% platform fee and has no monthly fee. Stripe card processing of 2.9% + $0.30 comes on top, plus 1% for supporters outside the US, 0.5% for membership payments and 0.5% on payouts. On a $5 US support you keep about $4.28.

### Can supporters pay the Buy Me a Coffee card fee?

Yes. In Settings you can turn off "Cover credit card fee" so supporters pay the processing fee on top. Buy Me a Coffee's own example charges a supporter $26.03 for a $25 contribution. The 5% platform fee still comes out of your earnings.

### Does Buy Me a Coffee charge more for memberships?

Membership payments carry an extra 0.5% processing fee on top of 2.9% + $0.30, so a recurring $5 membership costs about 2 cents more than a one-time $5 support.

### When does Buy Me a Coffee pay out?

Once your balance reaches $10 and your account is approved, payouts go to your Stripe account every Wednesday, and Stripe then sends them to your bank, usually in 2 to 7 business days. Stripe's payout processing takes about 0.5%.

### Is Buy Me a Coffee cheaper than Ko-fi or Patreon?

Ko-fi takes 0% on one-off tips on its free plan and 5% on memberships and shop sales unless you pay $12 a month for Ko-fi Gold. Patreon takes 10% for new creators. Buy Me a Coffee's flat 5% sits in between. Compare your own numbers in the [Ko-fi fee calculator](ko-fi-fee-calculator) and the [Patreon fee calculator](patreon-fee-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Buy Me a Coffee take?","acceptedAnswer":{"@type":"Answer","text":"Buy Me a Coffee takes a 5% platform fee and has no monthly fee. Stripe card processing of 2.9% + $0.30 comes on top, plus 1% for supporters outside the US, 0.5% for membership payments and 0.5% on payouts. On a $5 US support you keep about $4.28."}},
{"@type":"Question","name":"Can supporters pay the Buy Me a Coffee card fee?","acceptedAnswer":{"@type":"Answer","text":"Yes. In Settings you can turn off Cover credit card fee so supporters pay the processing fee on top. Buy Me a Coffee's own example charges a supporter $26.03 for a $25 contribution. The 5% platform fee still comes out of your earnings."}},
{"@type":"Question","name":"Does Buy Me a Coffee charge more for memberships?","acceptedAnswer":{"@type":"Answer","text":"Membership payments carry an extra 0.5% processing fee on top of 2.9% + $0.30, so a recurring $5 membership costs about 2 cents more than a one-time $5 support."}},
{"@type":"Question","name":"When does Buy Me a Coffee pay out?","acceptedAnswer":{"@type":"Answer","text":"Once your balance reaches $10 and your account is approved, payouts go to your Stripe account every Wednesday, and Stripe then sends them to your bank, usually in 2 to 7 business days. Stripe's payout processing takes about 0.5%."}},
{"@type":"Question","name":"Is Buy Me a Coffee cheaper than Ko-fi or Patreon?","acceptedAnswer":{"@type":"Answer","text":"Ko-fi takes 0% on one-off tips on its free plan and 5% on memberships and shop sales unless you pay $12 a month for Ko-fi Gold. Patreon takes 10% for new creators. Buy Me a Coffee's flat 5% sits in between. Compare your own numbers in the Ko-fi fee calculator and the Patreon fee calculator."}}
]}
</script>

## Related tools and guides

- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee and whether Ko-fi Gold pays off
- [Patreon fee calculator (2026)](patreon-fee-calculator): the 10% standard plan, legacy plans, processing and payout fees
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Buy Me a Coffee or Stripe. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
