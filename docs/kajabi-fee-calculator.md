---
layout: page
title: "Kajabi fee calculator (2026): Kajabi Payments card rates by plan, the third-party processor fee, and what you keep"
description: "Free Kajabi fee calculator. Enter your price, monthly sales and plan to see Kajabi Payments' 2.9%, 2.8% or 2.7% + 30¢ card fee or 0.8% ACH fee, the international, currency, subscription and invoicing add-ons, the 2%, 1% or 0.5% fee for using your own Stripe account, your Basic, Growth or Pro plan cost, and what you keep each month."
---

Kajabi takes **no revenue share**, but you pay a monthly plan and a fee on every sale. With **Kajabi Payments**, a US card sale costs **2.9% + 30¢ on Basic, 2.8% + 30¢ on Growth and 2.7% + 30¢ on Pro**, plus **1.5% for international cards** and **1% for currency conversion**. ACH bank payments cost **0.8%, capped at $5**. Subscriptions and payment plans add **0.7%** to every payment, Kajabi Invoicing adds **0.4%**, and Kajabi Sales Tax costs **15¢** a transaction. If you connect your own Stripe account instead, Kajabi adds **2%, 1% or 0.5%** by plan on top of Stripe's own fee. Plans cost **$179, $249 or $499 a month**, or **$143, $199 or $399 a month** billed yearly. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="kf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="kf-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="kf-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Kajabi plan<br><select id="kf-plan"><option value="basic" selected>Basic</option><option value="growth">Growth</option><option value="pro">Pro</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan billing<br><select id="kf-billing"><option value="monthly" selected>Monthly</option><option value="annual">Yearly (save 20%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment method<br><select id="kf-method"><option value="card" selected>Kajabi Payments: card or wallet</option><option value="ach">Kajabi Payments: ACH bank debit</option><option value="third">Your own Stripe account</option></select></label></p>
  </div>
  <p style="margin:0 0 4px"><label><input id="kf-intl" type="checkbox"> International card (+1.5%)</label> &nbsp; <label><input id="kf-fx" type="checkbox"> Currency conversion (+1%)</label></p>
  <p style="margin:0 0 8px"><label><input id="kf-sub" type="checkbox"> Subscription or payment plan (+0.7%)</label> &nbsp; <label><input id="kf-inv" type="checkbox"> Kajabi Invoicing (+0.4%)</label> &nbsp; <label><input id="kf-tax" type="checkbox"> Kajabi Sales Tax (15¢)</label></p>
  <p id="kf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="kf-s-price">$0.00</td></tr>
    <tr><td>Processing (<span id="kf-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="kf-s-proc">$0.00</td></tr>
    <tr><td>Kajabi add-ons (<span id="kf-addrate">none</span>)</td><td style="text-align:right" id="kf-s-add">$0.00</td></tr>
    <tr><td>Kajabi third-party processor fee</td><td style="text-align:right" id="kf-s-third">$0.00</td></tr>
    <tr><td>You keep per sale, before the plan cost</td><td style="text-align:right"><strong id="kf-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="kf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="kf-m-gross">$0.00</td></tr>
    <tr><td>Sale fees</td><td style="text-align:right" id="kf-m-fees">$0.00</td></tr>
    <tr><td>Kajabi plan (<span id="kf-planname">Basic, monthly</span>)</td><td style="text-align:right" id="kf-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="kf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="kf-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Which plan costs least at these sales?</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Basic: plan + sale fees</td><td style="text-align:right" id="kf-c-basic">$0.00</td></tr>
    <tr><td>Growth: plan + sale fees</td><td style="text-align:right" id="kf-c-growth">$0.00</td></tr>
    <tr><td>Pro: plan + sale fees</td><td style="text-align:right" id="kf-c-pro">$0.00</td></tr>
  </table>
  <p id="kf-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before the plan cost (USD)<br><input id="kf-target" type="number" min="0" step="0.01" value="95" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="kf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Kajabi fee math. Plan prices, Kajabi Payments card rates by plan and the third-party processor fee from kajabi.com/pricing; ACH, international, currency, subscription, invoicing and sales tax fees from Kajabi's US Kajabi Payments fee article (help.kajabi.com/en/articles/17174624); Stripe's 2.9% + 30c, +1.5% international and +1% conversion from stripe.com/pricing. All checked Oct 28, 2026. US businesses, USD only; disputes, refunds, Buy Now Pay Later, manual card entry and instant payouts not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    basic: { name: "Basic", monthly: 179, annual: 143, card: 2.9, third: 2 },
    growth: { name: "Growth", monthly: 249, annual: 199, card: 2.8, third: 1 },
    pro: { name: "Pro", monthly: 499, annual: 399, card: 2.7, third: 0.5 }
  };
  var CARD_FIXED = 0.30, INTL = 1.5, FX = 1, ACH_PCT = 0.8, ACH_CAP = 5, SUB = 0.7, INV = 0.4, TAX_FIXED = 0.15;
  var STRIPE_PCT = 2.9, STRIPE_FIXED = 0.30;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function plan(o) { return PLANS[(o && o.plan) in PLANS ? o.plan : "basic"]; }
  function method(o) { return o && (o.method === "ach" || o.method === "third") ? o.method : "card"; }
  function procPct(o) { var m = method(o); if (m === "ach") return ACH_PCT; var b = m === "third" ? STRIPE_PCT : plan(o).card; return b + (o.intl ? INTL : 0) + (o.fx ? FX : 0); }
  function addPct(o) { return method(o) === "third" ? 0 : (o.sub ? SUB : 0) + (o.inv ? INV : 0); }
  function addFixed(o) { return method(o) !== "third" && o.tax ? TAX_FIXED : 0; }
  function perSale(v, o) {
    o = o || {}; var p = price(v), m = method(o), pl = plan(o);
    if (p <= 0) return { price: 0, proc: 0, add: 0, third: 0, fee: 0, net: 0, effective: null, method: m, procPct: procPct(o), addPct: addPct(o) };
    var proc = m === "ach" ? Math.min(r2(p * ACH_PCT / 100), ACH_CAP) : r2(p * procPct(o) / 100 + (m === "third" ? STRIPE_FIXED : CARD_FIXED));
    var add = r2(p * addPct(o) / 100 + addFixed(o));
    var third = m === "third" ? r2(p * pl.third / 100) : 0;
    var fee = r2(proc + add + third);
    return { price: p, proc: proc, add: add, third: third, fee: fee, net: r2(p - fee), effective: fee / p, method: m, procPct: procPct(o), addPct: addPct(o) };
  }
  function planCost(o) { var pl = plan(o); return o && o.billing === "annual" ? pl.annual : pl.monthly; }
  function perMonth(v, q, o) {
    o = o || {}; var s = perSale(v, o), n = qty(q), gross = r2(s.price * n), fees = r2(s.fee * n), pc = planCost(o);
    return { gross: gross, fees: fees, plan: pc, net: r2(gross - fees - pc), effective: gross > 0 ? (fees + pc) / gross : null };
  }
  function compare(v, q, o) {
    var out = {}; for (var k in PLANS) { var oo = {}; for (var j in o) oo[j] = o[j]; oo.plan = k; var m = perMonth(v, q, oo); out[k] = r2(m.fees + m.plan); }
    var best = null; for (var k2 in out) if (best === null || out[k2] < out[best]) best = k2;
    out.best = best; return out;
  }
  function priceFor(v, o) {
    o = o || {}; var k = price(v); if (k <= 0) return null;
    var pct = procPct(o) + addPct(o) + (method(o) === "third" ? plan(o).third : 0), fixed = addFixed(o) + (method(o) === "ach" ? 0 : CARD_FIXED);
    var g = 1 - pct / 100; if (g <= 0) return null;
    var p = (k + fixed) / g;
    if (method(o) === "ach" && p * ACH_PCT / 100 > ACH_CAP) p = (k + ACH_CAP + fixed) / (1 - addPct(o) / 100);
    p = Math.max(0.01, Math.ceil(p * 100 - 1e-6) / 100);
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, ACH_CAP: ACH_CAP, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, perSale: perSale, planCost: planCost, perMonth: perMonth, compare: compare, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.KajabiFees = api;
})(this);
(function () {
  var F = window.KajabiFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  var boxes = ["kf-intl", "kf-fx", "kf-sub", "kf-inv", "kf-tax"];
  function update() {
    var p = $("kf-price").value, q = $("kf-qty").value;
    var o = { plan: $("kf-plan").value, billing: $("kf-billing").value, method: $("kf-method").value, intl: $("kf-intl").checked, fx: $("kf-fx").checked, sub: $("kf-sub").checked, inv: $("kf-inv").checked, tax: $("kf-tax").checked };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(p) < 0 || Number(q) < 0) w.push("Negative numbers are treated as 0.");
    if (o.method === "ach" && (o.intl || o.fx)) w.push("International and currency fees apply to card sales only, so they are ignored for ACH.");
    if (o.method === "third" && (o.sub || o.inv || o.tax)) w.push("Subscription, invoicing and sales tax fees are Kajabi Payments fees, so they are ignored for your own Stripe account.");
    set("kf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o), c = F.compare(p, q, o), pl = F.PLANS[o.plan];
    set("kf-procrate", s.method === "ach" ? "0.8%, max $5" : (Math.round(s.procPct * 10) / 10) + "% + $0.30" + (s.method === "third" ? ", Stripe" : ""));
    set("kf-addrate", s.addPct || (o.tax && s.method !== "third") ? (Math.round(s.addPct * 10) / 10) + "%" + (o.tax && s.method !== "third" ? " + $0.15" : "") : "none");
    set("kf-s-price", money(s.price)); set("kf-s-proc", money(s.proc)); set("kf-s-add", money(s.add)); set("kf-s-third", money(s.third)); set("kf-s-net", money(s.net)); set("kf-s-eff", pctS(s.effective));
    set("kf-planname", pl.name + ", " + (o.billing === "annual" ? "billed yearly" : "monthly"));
    set("kf-m-gross", money(m.gross)); set("kf-m-fees", money(m.fees)); set("kf-m-plan", money(m.plan)); set("kf-m-net", money(m.net)); set("kf-m-eff", pctS(m.effective));
    set("kf-c-basic", money(c.basic)); set("kf-c-growth", money(c.growth)); set("kf-c-pro", money(c.pro));
    set("kf-best", "Cheapest at these sales: " + F.PLANS[c.best].name + " (" + money(c[c.best]) + " a month). Plans also differ in products, contacts and websites, so check the limits too.");
    var need = F.priceFor($("kf-target").value, o);
    set("kf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("kf-target").value)) + " per sale, before the plan cost.");
  }
  ["kf-price", "kf-qty", "kf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["kf-plan", "kf-billing", "kf-method"].concat(boxes).forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Kajabi fees (checked Oct 28, 2026)

| Plan | Monthly billing | Billed yearly | Kajabi Payments card rate (US) | Fee for your own Stripe account |
|---|---|---|---|---|
| Basic | $179/mo | $143/mo | 2.9% + 30¢ | 2% |
| Growth | $249/mo | $199/mo | 2.8% + 30¢ | 1% |
| Pro | $499/mo | $399/mo | 2.7% + 30¢ | 0.5% |

| Kajabi Payments fee (US) | Rate | When it applies |
|---|---|---|
| International card | +1.5% | Card issued outside your country |
| Currency conversion | +1% | Offer priced in a currency other than your bank's |
| ACH Direct Debit | 0.8%, max $5 | Payments from a US bank account |
| ACH bank verification / failed ACH | $1.50 / $4.00 | Per attempt / per failed payment |
| Subscriptions and payment plans | +0.7% | Every payment in the series, including the first |
| Kajabi Invoicing | +0.4% | Payments made through Kajabi Invoicing |
| Kajabi Sales Tax | 15¢ | Per transaction on offers with it turned on |
| Manually entered card | +0.5% | First use of a manually entered card |
| Afterpay / Klarna | 6% + 30¢ / 5.99% + 30¢ | Buy Now, Pay Later sales |
| Dispute | $15 | Per chargeback, not refunded if you win |
| Instant Payout | 1.5%, min 50¢ | Optional, each time you request one |

Sources: [Kajabi's pricing page](https://kajabi.com/pricing) (plan prices, card rates by plan and the third-party processor fee), [Kajabi's US Kajabi Payments fee article](https://help.kajabi.com/en/articles/17174624) (all other Kajabi Payments fees) and [Stripe's pricing page](https://stripe.com/pricing) (2.9% + 30¢, +1.5% international, +1% conversion), all checked Oct 28, 2026. Kajabi says rates on its pricing page are for US businesses; other countries have their own schedules. The third-party fee doesn't apply to PayPal, and it isn't charged in countries where Kajabi Payments isn't offered. Refunds cost nothing extra, but the original fees aren't returned. Disputes, Buy Now Pay Later, manual card entry and instant payouts are not in the calculator, so treat the numbers as estimates and check your Kajabi Payouts page.

## How the numbers are worked out

```
processing  = price x (plan card rate + 1.5% if international + 1% if converted) + 30¢
              or, for ACH, price x 0.8%, capped at $5
              or, with your own Stripe, price x (2.9% + surcharges) + 30¢
add-ons     = price x (0.7% subscription + 0.4% invoicing) + 15¢ sales tax, only those on
              (Kajabi Payments only)
third-party = price x 2% Basic, 1% Growth or 0.5% Pro, only with your own Stripe
you keep    = price - processing - add-ons - third-party fee
per month   = you keep x sales - plan cost
```

A $100 course paid by a US card on Basic costs $3.20 (2.9% + 30¢), so you keep $96.80. On Pro the same sale costs $3.00. At 20 sales a month on Basic billed monthly, $2,000 in sales minus $64 in fees and the $179 plan leaves $1,757. Run the same sales through your own Stripe account on Basic and each sale also pays Kajabi's 2%, so the fee is $5.20.

## FAQ

### Does Kajabi take a percentage of sales?

Kajabi doesn't take a revenue share. You pay a card processing fee on each Kajabi Payments sale (2.9%, 2.8% or 2.7% + 30¢ in the US, depending on plan), plus 2%, 1% or 0.5% extra if you use your own Stripe account instead of Kajabi Payments.

### How much are Kajabi's plans?

Basic is $179 a month, Growth $249 and Pro $499. Billed yearly they work out to $143, $199 and $399 a month.

### What does Kajabi charge for subscriptions and payment plans?

With Kajabi Payments, recurring payments add 0.7% on top of the normal card or ACH rate, on every payment in the series including the first one.

### Is it cheaper to use Stripe or Kajabi Payments on Kajabi?

Usually Kajabi Payments. Stripe's own rate is 2.9% + 30¢, the same as Kajabi Payments on Basic, but Kajabi adds 2%, 1% or 0.5% by plan when you connect your own Stripe account. Kajabi Payments also gets the lower 2.8% and 2.7% card rates on Growth and Pro.

### Is Kajabi cheaper than Teachable or Podia?

Kajabi's plans cost more, but it charges no transaction fee. At low sales a cheaper plan with a transaction fee usually wins, and at high sales a flat plan does. Compare with the [Teachable fee calculator](teachable-fee-calculator) and the [Podia fee calculator](podia-fee-calculator) at your own numbers.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"Does Kajabi take a percentage of sales?","acceptedAnswer":{"@type":"Answer","text":"Kajabi doesn't take a revenue share. You pay a card processing fee on each Kajabi Payments sale (2.9%, 2.8% or 2.7% + 30 cents in the US, depending on plan), plus 2%, 1% or 0.5% extra if you use your own Stripe account instead of Kajabi Payments."}},
{"@type":"Question","name":"How much are Kajabi's plans?","acceptedAnswer":{"@type":"Answer","text":"Basic is $179 a month, Growth $249 and Pro $499. Billed yearly they work out to $143, $199 and $399 a month."}},
{"@type":"Question","name":"What does Kajabi charge for subscriptions and payment plans?","acceptedAnswer":{"@type":"Answer","text":"With Kajabi Payments, recurring payments add 0.7% on top of the normal card or ACH rate, on every payment in the series including the first one."}},
{"@type":"Question","name":"Is it cheaper to use Stripe or Kajabi Payments on Kajabi?","acceptedAnswer":{"@type":"Answer","text":"Usually Kajabi Payments. Stripe's own rate is 2.9% + 30 cents, the same as Kajabi Payments on Basic, but Kajabi adds 2%, 1% or 0.5% by plan when you connect your own Stripe account. Kajabi Payments also gets the lower 2.8% and 2.7% card rates on Growth and Pro."}},
{"@type":"Question","name":"Is Kajabi cheaper than Teachable or Podia?","acceptedAnswer":{"@type":"Answer","text":"Kajabi's plans cost more, but it charges no transaction fee. At low sales a cheaper plan with a transaction fee usually wins, and at high sales a flat plan does."}}
]}
</script>

## Related tools and guides

- [Teachable fee calculator (2026)](teachable-fee-calculator): the 7.5% Starter fee vs Builder and Growth
- [Podia fee calculator (2026)](podia-fee-calculator): the 5% Mover fee vs Shaker and Earthquaker
- [Thinkific fee calculator (2026)](thinkific-fee-calculator): no transaction fee with Thinkific Payments, $109 to $499 plans, and a 2% to 0.5% fee for your own Stripe
- [Stan Store fee calculator (2026)](stan-store-fee-calculator): 0% transaction fee, $29 Creator or $99 Creator Pro, plus Stripe or PayPal fees
- [Teachable vs Podia vs Payhip vs Gumroad: where to sell an online course](teachable-vs-podia-vs-payhip-vs-gumroad-courses): plan prices and the real monthly cost at $500 and $3,000 in sales
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Kajabi's 2.9% + 30¢ on Basic. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Kajabi, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
