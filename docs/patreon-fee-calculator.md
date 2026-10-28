---
layout: page
title: "Patreon fee calculator (2026): 10% platform fee, legacy 5%/8%/11% plans, processing, currency and payout fees"
description: "Free Patreon fee calculator. Enter your tier price, number of paid members, plan, payment method and payout method to see the Patreon platform fee, payment processing fee, currency conversion fee and payout fee, what you keep per payment and per month, and the price you need to keep a set amount."
---

Patreon takes a **10% platform fee** from creators who published their page after August 4, 2025. Creators who published on or before that date and kept their page published stay on their **legacy plan**: Founders 5%, Pro 8% or Pro + Merch 11%. On top of the platform fee Patreon charges a **payment processing fee** (2.9% + 30¢ for cards in USD on the standard plan), a **2.5% currency conversion fee** when a member pays in a different currency than your payout currency, and a small **payout fee** when you withdraw. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="pt" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per payment (USD)<br><input id="pt-price" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Paid members (payments) per month<br><input id="pt-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Patreon plan<br><select id="pt-plan"><option value="standard" selected>Standard (10%, pages published after Aug 4, 2025)</option><option value="pro">Pro, legacy (8%)</option><option value="promerch">Pro + Merch, legacy (11%)</option><option value="founders">Founders, legacy (5%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Member's payment method<br><select id="pt-method"><option value="card" selected>Credit card / Apple Pay</option><option value="paypal_us">PayPal / Venmo (US member)</option><option value="paypal_intl">PayPal / Venmo (non-US member)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payout method (once a month)<br><select id="pt-payout"><option value="stripe" selected>US bank transfer via Stripe ($0.25)</option><option value="paypal">PayPal (1%, min $0.25, max $20)</option><option value="none">Leave out payout fee</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="pt-fx" type="checkbox"> Member pays in a different currency than my payout currency (+2.5%)</label></p>
  <p id="pt-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Price the member pays</td><td style="text-align:right" id="pt-o-price">$0.00</td></tr>
    <tr><td>Patreon platform fee (<span id="pt-o-platrate">10%</span>)</td><td style="text-align:right" id="pt-o-plat">$0.00</td></tr>
    <tr><td>Payment processing fee (<span id="pt-o-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="pt-o-proc">$0.00</td></tr>
    <tr><td>Currency conversion fee (<span id="pt-o-fxrate">0%</span>)</td><td style="text-align:right" id="pt-o-fx">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right"><strong id="pt-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per payment</td><td style="text-align:right"><strong id="pt-o-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="pt-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Member payments</td><td style="text-align:right" id="pt-m-gross">$0.00</td></tr>
    <tr><td>Platform fees</td><td style="text-align:right" id="pt-m-plat">$0.00</td></tr>
    <tr><td>Payment processing fees</td><td style="text-align:right" id="pt-m-proc">$0.00</td></tr>
    <tr><td>Currency conversion fees</td><td style="text-align:right" id="pt-m-fx">$0.00</td></tr>
    <tr><td>Payout fee (one payout)</td><td style="text-align:right" id="pt-m-payout">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="pt-m-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount per payment</h3>
  <p style="margin:0 0 8px"><label>I want to keep (USD)<br><input id="pt-target" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="pt-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Patreon fee math. Rates from support.patreon.com "Creator fees overview" (updated Sep 11, 2026) and "A standard platform fee for new creators" (updated Oct 8, 2026), plus patreon.com/pricing, checked Oct 28, 2026. USD payout currency only. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    "standard": { name: "Standard", pct: 10, legacy: false },
    "pro": { name: "Pro (legacy)", pct: 8, legacy: true },
    "promerch": { name: "Pro + Merch (legacy)", pct: 11, legacy: true },
    "founders": { name: "Founders (legacy)", pct: 5, legacy: true }
  };
  var METHODS = { "card": "Credit card / Apple Pay", "paypal_us": "PayPal / Venmo (US)", "paypal_intl": "PayPal / Venmo (non-US)" };
  // USD processing rates. Standard 10% plan: same rate at every amount. Pro / Pro + Merch: micropayment rate at $3 or less.
  var STD = { "card": { pct: 2.9, fixed: 0.30 }, "paypal_us": { pct: 2.9, fixed: 0.30 }, "paypal_intl": { pct: 3.9, fixed: 0.30 } };
  var MICRO = { "card": { pct: 5, fixed: 0.10 }, "paypal_us": { pct: 5, fixed: 0.10 }, "paypal_intl": { pct: 6, fixed: 0.10 } };
  var FOUNDERS = { "card": { pct: 1.6, fixed: 0.30 }, "paypal_us": { pct: 2.65, fixed: 0.28 }, "paypal_intl": { pct: 2.65, fixed: 0.28 } };
  var MICRO_MAX = 3, FX_PCT = 2.5;
  var PAYOUTS = { "stripe": "US bank transfer (Stripe)", "paypal": "PayPal", "none": "None" };
  var MAX_PRICE = 1000000, MAX_SALES = 1000000;
  function r2(n) { return Math.round(n * 100) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function plan(o) { o = o || {}; return PLANS[o.plan] ? o.plan : "standard"; }
  function method(o) { o = o || {}; return METHODS[o.method] ? o.method : "card"; }
  function payout(o) { o = o || {}; return PAYOUTS[o.payout] ? o.payout : "stripe"; }
  function platPct(o) { return PLANS[plan(o)].pct; }
  function isMicro(p, o) { var pl = plan(o); return (pl === "pro" || pl === "promerch") && p > 0 && p <= MICRO_MAX; }
  // Processing rate for a price, plan and payment method.
  function procRate(p, o) {
    var pl = plan(o), m = method(o);
    if (pl === "founders") return FOUNDERS[m];
    return isMicro(p, o) ? MICRO[m] : STD[m];
  }
  function fxPct(o) { return (o && o.fx) ? FX_PCT : 0; }
  function perSale(p, o) {
    o = o || {}; p = price(p);
    var pl = platPct(o), rate = procRate(p, o), fx = fxPct(o);
    var platFee = p > 0 ? r2(p * pl / 100) : 0;
    var procFee = p > 0 ? r2(p * rate.pct / 100 + rate.fixed) : 0;
    var fxFee = p > 0 ? r2(p * fx / 100) : 0;
    var fee = r2(platFee + procFee + fxFee);
    return { price: p, platPct: pl, procPct: rate.pct, procFixed: rate.fixed, micro: isMicro(p, o), fxPct: fx, platFee: platFee, procFee: procFee, fxFee: fxFee, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  // Payout fee on one withdrawal of `amount` (US creator, USD).
  function payoutFee(amount, o) {
    var a = Math.max(0, Number(amount) || 0), po = payout(o);
    if (a <= 0 || po === "none") return 0;
    if (po === "stripe") return 0.25;
    return r2(Math.min(20, Math.max(0.25, a * 0.01)));
  }
  function monthly(p, n, o) {
    o = o || {}; var s = perSale(p, o), q = sales(n);
    var gross = r2(s.price * q), platFees = r2(s.platFee * q), procFees = r2(s.procFee * q), fxFees = r2(s.fxFee * q);
    var balance = r2(gross - platFees - procFees - fxFees);
    var pay = payoutFee(balance, o);
    var net = r2(balance - pay);
    return { sales: q, gross: gross, platFees: platFees, procFees: procFees, fxFees: fxFees, balance: balance, payout: pay, net: net, effective: gross > 0 ? (gross - net) / gross : null };
  }
  // Lowest price (to the cent) that keeps at least `target` per payment (payout fee left out, it is per withdrawal).
  // Checks the micropayment band (<= $3) and the standard band separately, because the fee jumps at $3.
  function priceFor(target, o) {
    o = o || {}; var k = price(target); if (!(k > 0)) return null;
    var bands = [{ lo: 0.01, hi: MICRO_MAX }, { lo: 3.01, hi: MAX_PRICE }], best = null;
    for (var i = 0; i < bands.length; i++) {
      var b = bands[i], rate = procRate(b.lo, o);
      var f = (platPct(o) + rate.pct + fxPct(o)) / 100; if (f >= 1) continue;
      var p = Math.max(b.lo, Math.ceil(((k + rate.fixed) / (1 - f)) * 100 - 1e-6) / 100);
      while (p > b.lo && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
      var guard = 0;
      while (p <= b.hi && perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
      if (p <= b.hi && perSale(p, o).net >= k && (best === null || p < best)) best = p;
    }
    return best;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, METHODS: METHODS, STD: STD, MICRO: MICRO, FOUNDERS: FOUNDERS, MICRO_MAX: MICRO_MAX, FX_PCT: FX_PCT, PAYOUTS: PAYOUTS,
    MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES, price: price, sales: sales, plan: plan, method: method, payout: payout,
    platPct: platPct, isMicro: isMicro, procRate: procRate, fxPct: fxPct, perSale: perSale, payoutFee: payoutFee, monthly: monthly, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PatreonFees = api;
})(this);
(function () {
  var F = window.PatreonFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var rawP = $("pt-price").value, rawN = $("pt-qty").value;
    var o = { plan: $("pt-plan").value, method: $("pt-method").value, payout: $("pt-payout").value, fx: $("pt-fx").checked };
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Payments capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawP) < 0 || Number(rawN) < 0) w.push("Negative numbers are treated as 0.");
    var s = F.perSale(rawP, o), m = F.monthly(rawP, rawN, o);
    if (s.micro) w.push("Prices of $3 or less use Patreon's micropayment rate on the Pro and Pro + Merch plans.");
    if (F.plan(o) === "founders" && s.price > 0 && s.price <= F.MICRO_MAX) w.push("Patreon does not list a separate small-payment rate for Founders, so the Founders rate is shown.");
    if (F.payout(o) === "paypal" && m.balance > 0 && m.balance < 10) w.push("PayPal payouts need a $10 minimum balance.");
    set("pt-warn", w.join(" "));
    set("pt-o-price", money(s.price));
    set("pt-o-platrate", s.platPct + "%"); set("pt-o-plat", money(s.platFee));
    set("pt-o-procrate", s.procPct + "% + " + money(s.procFixed)); set("pt-o-proc", money(s.procFee));
    set("pt-o-fxrate", s.fxPct + "%"); set("pt-o-fx", money(s.fxFee));
    set("pt-o-fee", money(s.fee)); set("pt-o-net", money(s.net)); set("pt-o-eff", pctS(s.effective));
    set("pt-m-gross", money(m.gross)); set("pt-m-plat", money(m.platFees)); set("pt-m-proc", money(m.procFees)); set("pt-m-fx", money(m.fxFees)); set("pt-m-payout", money(m.payout)); set("pt-m-net", money(m.net));
    var need = F.priceFor($("pt-target").value, o);
    set("pt-need", need == null ? "Enter how much you want to keep per payment." : "Charge " + money(need) + " to keep at least " + money(F.price($("pt-target").value)) + " per payment with these options (before the payout fee).");
  }
  ["pt-price", "pt-qty", "pt-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["pt-plan", "pt-method", "pt-payout", "pt-fx"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Patreon fees (checked Oct 28, 2026)

**Platform fee**, a share of each successful payment (not counting sales tax):

| Plan | Platform fee | Who is on it |
|---|---|---|
| Standard | 10% | Anyone who publishes a creator page after August 4, 2025, and legacy creators who unpublish and republish |
| Pro (legacy) | 8% | Pages published on or before August 4, 2025 and kept published |
| Pro + Merch (legacy) | 11% | Same as Pro, with merch fulfillment |
| Founders (legacy) | 5% | Joined before May 7, 2019 and never changed plan |

**Payment processing fee** per payment, when your payout currency is US dollars:

| Member's payment method | Standard 10% plan (any amount) | Pro and Pro + Merch, $3 or less | Pro and Pro + Merch, over $3 | Founders |
|---|---|---|---|---|
| Credit card / Apple Pay | 2.9% + $0.30 | 5% + $0.10 | 2.9% + $0.30 | 1.6% + $0.30 |
| PayPal / Venmo, US member | 2.9% + $0.30 | 5% + $0.10 | 2.9% + $0.30 | 2.65% + $0.28 |
| PayPal / Venmo, non-US member | 3.9% + $0.30 | 6% + $0.10 | 3.9% + $0.30 | 2.65% + $0.28 |

**Other fees:**

| Fee | Amount |
|---|---|
| Currency conversion | 2.5% of the full payment (including tax) when the member pays in a different currency than your payout currency |
| Payout, US bank transfer (Stripe) | $0.25 per payout |
| Payout, PayPal | 1% of the amount, minimum $0.25, capped at $20 ($10 minimum payout) |
| Purchases in the iOS app | Apple's 30% App Store fee instead of Patreon's processing fee; the platform fee still applies. US members can pay on the mobile web instead |

Sources: [Creator fees overview](https://support.patreon.com/hc/en-us/articles/11111747095181-Creator-fees-overview) (updated September 11, 2026), [A standard platform fee for new creators](https://support.patreon.com/hc/en-us/articles/36426991446797-A-standard-platform-fee-for-new-creators-effective-after-August-4-2025) (updated October 8, 2026) and [Patreon pricing](https://www.patreon.com/pricing), all checked Oct 28, 2026. Patreon also lists processing and payout fees for 13 other payout currencies (EUR, GBP, CAD, AUD and more) on the Creator fees overview; this calculator covers US dollar payouts only. Where the law requires it, Patreon also adds VAT, GST or sales tax on its fees, which depends on where your business is and is not included here. Rates change, so check Patreon's pages before you rely on a number.

## How the numbers are worked out

```
platform fee        = price x plan rate                (10%, 8%, 11% or 5%)
processing fee      = price x processing rate + fixed  (e.g. 2.9% + $0.30)
currency conversion = price x 2.5%                     (only if the member pays in another currency)
you keep per payment = price - platform fee - processing fee - currency conversion
payout fee          = once per withdrawal, taken off the monthly total
```

A $10 tier on the standard 10% plan paid by card costs $1.00 (10% platform fee) + $0.59 (2.9% + $0.30) = $1.59, so you keep $8.41, an effective 15.9%. With 100 members that is $841.00 a month before the payout fee, or $840.75 after a $0.25 bank payout. The same $10 on the legacy Pro plan costs $0.80 + $0.59 = $1.39, so you keep $8.61.

**Cheap tiers lose the most.** On the standard plan a $3 tier pays $0.30 + $0.39 = $0.69 in fees (23%), because the fixed 30¢ is a big share of a small price. Legacy Pro and Pro + Merch creators get the lower micropayment rate (5% + 10¢) on payments of $3 or less, so the same $3 tier costs $0.24 + $0.25 = $0.49 on Pro. That also means a $3.01 tier on Pro keeps less than a $3.00 tier, since the fee jumps once the price passes $3.

## FAQ

### How much does Patreon take from creators in 2026?

New creators (pages published after August 4, 2025) pay a 10% platform fee plus payment processing, which is 2.9% + $0.30 for card payments in US dollars. So a $10 payment costs about $1.59 in fees and you keep about $8.41. Currency conversion (2.5%) and a small payout fee can apply on top.

### Is Patreon's fee still 5%, 8% or 12%?

Not for new creators. Since August 4, 2025, new pages are on the standard 10% plan. Creators who published on or before that date and kept their page published keep their legacy plan: Founders 5%, Pro 8% or Pro + Merch 11%. Unpublishing your page moves you to the 10% plan when you republish.

### What are Patreon's payment processing fees?

On the standard 10% plan with US dollar payouts: 2.9% + $0.30 for credit cards, Apple Pay and US PayPal or Venmo, and 3.9% + $0.30 for PayPal or Venmo from outside the US, at any payment amount. Legacy Pro and Pro + Merch plans pay 5% + $0.10 (6% + $0.10 for non-US PayPal) on payments of $3 or less.

### Does Patreon charge a fee to withdraw money?

Yes, a payout fee comes off each withdrawal. For US creators paid in dollars it is $0.25 per bank transfer through Stripe, or 1% of the amount by PayPal (at least $0.25, at most $20, with a $10 minimum payout).

### Is Patreon cheaper than Ko-fi or Gumroad?

For memberships, Ko-fi's free plan takes 5% plus Stripe or PayPal fees, and Ko-fi Gold ($12/month) takes 0%, so Ko-fi usually costs less than Patreon's standard 10%. Gumroad charges 10% + $0.50 plus card processing per sale. Patreon handles checkout, failed-payment retries and most sales tax for you. Compare what you keep in the [Ko-fi fee calculator](ko-fi-fee-calculator) and the [Seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Patreon take from creators in 2026?","acceptedAnswer":{"@type":"Answer","text":"New creators (pages published after August 4, 2025) pay a 10% platform fee plus payment processing, which is 2.9% + $0.30 for card payments in US dollars. So a $10 payment costs about $1.59 in fees and you keep about $8.41. Currency conversion (2.5%) and a small payout fee can apply on top."}},
{"@type":"Question","name":"Is Patreon's fee still 5%, 8% or 12%?","acceptedAnswer":{"@type":"Answer","text":"Not for new creators. Since August 4, 2025, new pages are on the standard 10% plan. Creators who published on or before that date and kept their page published keep their legacy plan: Founders 5%, Pro 8% or Pro + Merch 11%. Unpublishing your page moves you to the 10% plan when you republish."}},
{"@type":"Question","name":"What are Patreon's payment processing fees?","acceptedAnswer":{"@type":"Answer","text":"On the standard 10% plan with US dollar payouts: 2.9% + $0.30 for credit cards, Apple Pay and US PayPal or Venmo, and 3.9% + $0.30 for PayPal or Venmo from outside the US, at any payment amount. Legacy Pro and Pro + Merch plans pay 5% + $0.10 (6% + $0.10 for non-US PayPal) on payments of $3 or less."}},
{"@type":"Question","name":"Does Patreon charge a fee to withdraw money?","acceptedAnswer":{"@type":"Answer","text":"Yes, a payout fee comes off each withdrawal. For US creators paid in dollars it is $0.25 per bank transfer through Stripe, or 1% of the amount by PayPal (at least $0.25, at most $20, with a $10 minimum payout)."}},
{"@type":"Question","name":"Is Patreon cheaper than Ko-fi or Gumroad?","acceptedAnswer":{"@type":"Answer","text":"For memberships, Ko-fi's free plan takes 5% plus Stripe or PayPal fees, and Ko-fi Gold ($12/month) takes 0%, so Ko-fi usually costs less than Patreon's standard 10%. Gumroad charges 10% + $0.50 plus card processing per sale. Patreon handles checkout, failed-payment retries and most sales tax for you. Compare what you keep in the Ko-fi fee calculator and the Seller fee comparison calculator."}}
]}
</script>

## Related tools and guides

- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee and whether Ko-fi Gold pays off
- [Buy Me a Coffee fee calculator (2026)](buy-me-a-coffee-fee-calculator): the flat 5% platform fee plus Stripe processing and payout fees
- [Substack fee calculator (2026)](substack-fee-calculator): Substack's 10% fee, Stripe card and 0.7% Billing fees on monthly and annual plans
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [Payhip fee calculator (2026)](payhip-fee-calculator) and [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)
- [Who collects sales tax and VAT on digital products?](who-collects-sales-tax-vat-gumroad-lemon-squeezy-payhip-sellfy-etsy)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Patreon, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
