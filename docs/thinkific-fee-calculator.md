---
layout: page
title: "Thinkific fee calculator (2026): Thinkific Payments card fees, the third-party gateway fee by plan, and what you keep"
description: "Free Thinkific fee calculator. Enter your price, monthly sales and plan to see Thinkific Payments' 2.9% + 30¢ card fee, the international, currency, subscription, sales tax and invoicing add-ons, the 3.9% wallet and 6.5% Buy Now Pay Later rates, the 2%, 1% or 0.5% fee for using your own Stripe account, your Start, Grow or Expand plan cost, and what you keep each month."
---

Thinkific takes **no revenue share** when you use **Thinkific Payments**, but you pay a monthly plan and a processing fee on every sale. A US card sale costs **2.9% + 30¢** on every plan (Apple Pay and Google Pay too), plus **1.5% for international cards** and **1% for currency conversion**. Subscriptions and payment plans add **0.7%**, the Sales Tax & VAT solution adds **0.5%** on taxed sales, and invoices add **0.4%, capped at $5**. Link, Cash App and Amazon Pay cost **3.9% + 30¢**, and Buy Now Pay Later costs **6.5% + 30¢**. If you connect your own Stripe account instead, Thinkific adds a **third-party gateway fee of 2% on Start, 1% on Grow or 0.5% on Expand**, on top of Stripe's own fee. Plans cost **$109, $219 or $499 a month**, or **$82, $164 or $374 a month** billed yearly. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="tf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="tf-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="tf-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Thinkific plan<br><select id="tf-plan"><option value="start" selected>Start</option><option value="grow">Grow</option><option value="expand">Expand</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan billing<br><select id="tf-billing"><option value="monthly" selected>Monthly</option><option value="annual">Yearly (save 25%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment method<br><select id="tf-method"><option value="card" selected>Thinkific Payments: card, Apple Pay or Google Pay</option><option value="wallet">Thinkific Payments: Link, Cash App or Amazon Pay</option><option value="bnpl">Thinkific Payments: Buy Now Pay Later</option><option value="third">Your own Stripe account</option></select></label></p>
  </div>
  <p style="margin:0 0 4px"><label><input id="tf-intl" type="checkbox"> International card (+1.5%)</label> &nbsp; <label><input id="tf-fx" type="checkbox"> Currency conversion (+1%)</label></p>
  <p style="margin:0 0 8px"><label><input id="tf-sub" type="checkbox"> Subscription or payment plan (+0.7%)</label> &nbsp; <label><input id="tf-tax" type="checkbox"> Sales Tax &amp; VAT solution (+0.5%)</label> &nbsp; <label><input id="tf-inv" type="checkbox"> Paid by invoice (+0.4%, max $5)</label></p>
  <p id="tf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="tf-s-price">$0.00</td></tr>
    <tr><td>Processing (<span id="tf-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="tf-s-proc">$0.00</td></tr>
    <tr><td>Thinkific add-ons (<span id="tf-addrate">none</span>)</td><td style="text-align:right" id="tf-s-add">$0.00</td></tr>
    <tr><td>Thinkific third-party gateway fee</td><td style="text-align:right" id="tf-s-third">$0.00</td></tr>
    <tr><td>You keep per sale, before the plan cost</td><td style="text-align:right"><strong id="tf-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="tf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="tf-m-gross">$0.00</td></tr>
    <tr><td>Sale fees</td><td style="text-align:right" id="tf-m-fees">$0.00</td></tr>
    <tr><td>Thinkific plan (<span id="tf-planname">Start, monthly</span>)</td><td style="text-align:right" id="tf-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="tf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="tf-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Which plan costs least at these sales?</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Start: plan + sale fees</td><td style="text-align:right" id="tf-c-start">$0.00</td></tr>
    <tr><td>Grow: plan + sale fees</td><td style="text-align:right" id="tf-c-grow">$0.00</td></tr>
    <tr><td>Expand: plan + sale fees</td><td style="text-align:right" id="tf-c-expand">$0.00</td></tr>
  </table>
  <p id="tf-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before the plan cost (USD)<br><input id="tf-target" type="number" min="0" step="0.01" value="95" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="tf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Thinkific fee math. Plan prices from thinkific.com/pricing; Thinkific Payments US card, international, currency, subscription, wallet, BNPL, sales tax and invoicing fees from Thinkific's "Thinkific Payments Supported Countries and Transaction Fees" article (support.thinkific.com/hc/en-us/articles/1500012376321); third-party gateway fee by plan from Thinkific's "Third-Party Payment Gateway Fee FAQ" (support.thinkific.com/hc/en-us/articles/22383950439575); Stripe's 2.9% + 30c, +1.5% international and +1% conversion from stripe.com/pricing. All checked Oct 28, 2026. US businesses, USD only; the sales tax fee is applied to the price (Thinkific charges it on price plus tax); disputes, refunds, instant payouts and the $1M yearly waiver of the gateway fee not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    start: { name: "Start", monthly: 109, annual: 82, third: 2 },
    grow: { name: "Grow", monthly: 219, annual: 164, third: 1 },
    expand: { name: "Expand", monthly: 499, annual: 374, third: 0.5 }
  };
  var FIXED = 0.30, CARD = 2.9, WALLET = 3.9, BNPL = 6.5, INTL = 1.5, FX = 1, SUB = 0.7, TAX = 0.5, INV = 0.4, INV_CAP = 5;
  var STRIPE_PCT = 2.9, STRIPE_FIXED = 0.30;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function plan(o) { return PLANS[(o && o.plan) in PLANS ? o.plan : "start"]; }
  function method(o) { var m = o && o.method; return m === "wallet" || m === "bnpl" || m === "third" ? m : "card"; }
  function procPct(o) { var m = method(o); if (m === "wallet") return WALLET; if (m === "bnpl") return BNPL; return (m === "third" ? STRIPE_PCT : CARD) + (o.intl ? INTL : 0) + (o.fx ? FX : 0); }
  function addPct(o) { var m = method(o); if (m === "third") return 0; return (m === "card" && o.sub ? SUB : 0) + (o.tax ? TAX : 0); }
  function invOn(o) { return method(o) === "card" && !!o.inv; }
  function perSale(v, o) {
    o = o || {}; var p = price(v), m = method(o), pl = plan(o);
    if (p <= 0) return { price: 0, proc: 0, add: 0, third: 0, fee: 0, net: 0, effective: null, method: m, procPct: procPct(o), addPct: addPct(o) };
    var proc = r2(p * procPct(o) / 100 + (m === "third" ? STRIPE_FIXED : FIXED));
    var add = r2(p * addPct(o) / 100 + (invOn(o) ? Math.min(p * INV / 100, INV_CAP) : 0));
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
    o = o || {}; var out = {}; for (var k in PLANS) { var oo = {}; for (var j in o) oo[j] = o[j]; oo.plan = k; var m = perMonth(v, q, oo); out[k] = r2(m.fees + m.plan); }
    var best = null; for (var k2 in out) if (best === null || out[k2] < out[best]) best = k2;
    out.best = best; return out;
  }
  function priceFor(v, o) {
    o = o || {}; var k = price(v); if (k <= 0) return null;
    var lo = 1, hi = MAX_PRICE * 100;
    if (perSale(MAX_PRICE, o).net < k) return null;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, o).net >= k) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, INV_CAP: INV_CAP, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, perSale: perSale, planCost: planCost, perMonth: perMonth, compare: compare, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.ThinkificFees = api;
})(this);
(function () {
  var F = window.ThinkificFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  var boxes = ["tf-intl", "tf-fx", "tf-sub", "tf-tax", "tf-inv"];
  function update() {
    var p = $("tf-price").value, q = $("tf-qty").value;
    var o = { plan: $("tf-plan").value, billing: $("tf-billing").value, method: $("tf-method").value, intl: $("tf-intl").checked, fx: $("tf-fx").checked, sub: $("tf-sub").checked, tax: $("tf-tax").checked, inv: $("tf-inv").checked };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(p) < 0 || Number(q) < 0) w.push("Negative numbers are treated as 0.");
    if ((o.method === "wallet" || o.method === "bnpl") && (o.intl || o.fx || o.sub || o.inv)) w.push("International, currency, subscription and invoice fees are modelled for card payments only, so they are ignored for this method.");
    if (o.method === "third" && (o.sub || o.tax || o.inv)) w.push("Subscription, sales tax and invoice fees are Thinkific Payments fees, so they are ignored for your own Stripe account.");
    set("tf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o), c = F.compare(p, q, o), pl = F.PLANS[o.plan];
    set("tf-procrate", (Math.round(s.procPct * 10) / 10) + "% + $0.30" + (s.method === "third" ? ", Stripe" : ""));
    var inv = o.inv && s.method === "card";
    set("tf-addrate", s.addPct || inv ? [s.addPct ? (Math.round(s.addPct * 10) / 10) + "%" : "", inv ? "invoice 0.4%, max $5" : ""].filter(Boolean).join(" + ") : "none");
    set("tf-s-price", money(s.price)); set("tf-s-proc", money(s.proc)); set("tf-s-add", money(s.add)); set("tf-s-third", money(s.third)); set("tf-s-net", money(s.net)); set("tf-s-eff", pctS(s.effective));
    set("tf-planname", pl.name + ", " + (o.billing === "annual" ? "billed yearly" : "monthly"));
    set("tf-m-gross", money(m.gross)); set("tf-m-fees", money(m.fees)); set("tf-m-plan", money(m.plan)); set("tf-m-net", money(m.net)); set("tf-m-eff", pctS(m.effective));
    set("tf-c-start", money(c.start)); set("tf-c-grow", money(c.grow)); set("tf-c-expand", money(c.expand));
    set("tf-best", "Cheapest at these sales: " + F.PLANS[c.best].name + " (" + money(c[c.best]) + " a month). Plans also differ in branding, communities, admins and video bandwidth, so check the limits too.");
    var need = F.priceFor($("tf-target").value, o);
    set("tf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("tf-target").value)) + " per sale, before the plan cost.");
  }
  ["tf-price", "tf-qty", "tf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["tf-plan", "tf-billing", "tf-method"].concat(boxes).forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Thinkific fees (checked Oct 28, 2026)

| Plan | Monthly billing | Billed yearly | Thinkific Payments card rate (US) | Fee for your own Stripe account |
|---|---|---|---|---|
| Start | $109/mo | $82/mo | 2.9% + 30¢ | 2% |
| Grow | $219/mo | $164/mo | 2.9% + 30¢ | 1% |
| Expand | $499/mo | $374/mo | 2.9% + 30¢ | 0.5% |

| Thinkific Payments fee (US) | Rate | When it applies |
|---|---|---|
| Card, Apple Pay, Google Pay | 2.9% + 30¢ | Every successful payment |
| International card | +1.5% | Card issued outside the US |
| Currency conversion | +1% | Payment needs a currency conversion |
| Subscriptions and payment plans | +0.7% | Recurring and installment payments |
| Link, Cash App, Amazon Pay | 3.9% + 30¢ | Domestic payments with these wallets |
| Buy Now, Pay Later | 6.5% + 30¢ | Afterpay and similar, plus 1.5% cross-border on Afterpay |
| Sales Tax & VAT solution | +0.5% | Every taxed sale, on price plus tax, even at a 0% rate |
| Invoicing | +0.4%, max $5 | Invoices paid through Thinkific, plus the payment method's fee |
| Instant Payout | 1.5% | Optional, each time you request one |

Sources: [Thinkific's pricing page](https://www.thinkific.com/pricing/) (plan prices), [Thinkific's Payments fees article](https://support.thinkific.com/hc/en-us/articles/1500012376321-Thinkific-Payments-Supported-Countries-and-Transaction-Fees) (all Thinkific Payments fees), [Thinkific's third-party gateway fee FAQ](https://support.thinkific.com/hc/en-us/articles/22383950439575-Third-Party-Payment-Gateway-Fee-FAQ) (the 2%, 1% and 0.5% fee) and [Stripe's pricing page](https://stripe.com/pricing) (2.9% + 30¢, +1.5% international, +1% conversion), all checked Oct 28, 2026. The gateway fee applies in the US, Canada, the UK and the EU, and only on your first $1M in sales each calendar year. Refunds cost nothing extra, but the original fees aren't returned. Disputes, instant payouts and the $1M waiver are not in the calculator, and the sales tax fee is worked out on the price only, so treat the numbers as estimates and check your Thinkific Orders report.

## How the numbers are worked out

```
processing  = price x (2.9% + 1.5% if international + 1% if converted) + 30¢
              or price x 3.9% + 30¢ for Link, Cash App or Amazon Pay
              or price x 6.5% + 30¢ for Buy Now Pay Later
              or, with your own Stripe, price x (2.9% + surcharges) + 30¢
add-ons     = price x (0.7% subscription + 0.5% sales tax) + invoice 0.4% (max $5),
              only those on (Thinkific Payments only)
gateway fee = price x 2% Start, 1% Grow or 0.5% Expand, only with your own Stripe
you keep    = price - processing - add-ons - gateway fee
per month   = you keep x sales - plan cost
```

A $100 course paid by a US card on any plan costs $3.20 (2.9% + 30¢), so you keep $96.80. At 20 sales a month on Start billed monthly, $2,000 in sales minus $64 in fees and the $109 plan leaves $1,827. Run the same sale through your own Stripe account on Start and it also pays Thinkific's 2%, so the fee is $5.20.

## FAQ

### Does Thinkific take a percentage of sales?

Not with Thinkific Payments. You pay the card processing fee (2.9% + 30¢ in the US) and your plan. If you connect your own Stripe account instead, Thinkific adds a third-party gateway fee of 2% on Start, 1% on Grow or 0.5% on Expand.

### How much are Thinkific's plans?

Start is $109 a month, Grow $219 and Expand $499. Billed yearly they work out to $82, $164 and $374 a month. There's no free plan, only a 30-day free trial.

### What does Thinkific charge for subscriptions and payment plans?

With Thinkific Payments, recurring and installment payments add 0.7% on top of the normal card rate.

### Is it cheaper to use Stripe or Thinkific Payments on Thinkific?

Usually Thinkific Payments. Stripe's own rate is 2.9% + 30¢, the same as Thinkific Payments, but Thinkific adds 2%, 1% or 0.5% by plan when you use your own Stripe account, on your first $1M in sales each year.

### Is Thinkific cheaper than Teachable or Kajabi?

Thinkific's Start plan costs less than Kajabi's Basic plan and charges no transaction fee with Thinkific Payments, while Teachable's cheapest plan adds a 7.5% fee. Compare with the [Teachable fee calculator](teachable-fee-calculator) and the [Kajabi fee calculator](kajabi-fee-calculator) at your own numbers.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "Does Thinkific take a percentage of sales?", "acceptedAnswer": {"@type": "Answer", "text": "Not with Thinkific Payments. You pay the card processing fee (2.9% + 30 cents in the US) and your plan. If you connect your own Stripe account instead, Thinkific adds a third-party gateway fee of 2% on Start, 1% on Grow or 0.5% on Expand."}},
{"@type": "Question", "name": "How much are Thinkific's plans?", "acceptedAnswer": {"@type": "Answer", "text": "Start is $109 a month, Grow $219 and Expand $499. Billed yearly they work out to $82, $164 and $374 a month. There's no free plan, only a 30-day free trial."}},
{"@type": "Question", "name": "What does Thinkific charge for subscriptions and payment plans?", "acceptedAnswer": {"@type": "Answer", "text": "With Thinkific Payments, recurring and installment payments add 0.7% on top of the normal card rate."}},
{"@type": "Question", "name": "Is it cheaper to use Stripe or Thinkific Payments on Thinkific?", "acceptedAnswer": {"@type": "Answer", "text": "Usually Thinkific Payments. Stripe's own rate is 2.9% + 30 cents, the same as Thinkific Payments, but Thinkific adds 2%, 1% or 0.5% by plan when you use your own Stripe account, on your first $1M in sales each year."}},
{"@type": "Question", "name": "Is Thinkific cheaper than Teachable or Kajabi?", "acceptedAnswer": {"@type": "Answer", "text": "Thinkific's Start plan costs less than Kajabi's Basic plan and charges no transaction fee with Thinkific Payments, while Teachable's cheapest plan adds a 7.5% fee."}}
]}
</script>

## Related tools and guides

- [Kajabi fee calculator (2026)](kajabi-fee-calculator): no transaction fee, but $179 to $499 plans and 2.7% to 2.9% + 30¢ card rates
- [Teachable fee calculator (2026)](teachable-fee-calculator): the 7.5% Starter fee vs Builder and Growth
- [Podia fee calculator (2026)](podia-fee-calculator): the 5% Mover fee vs Shaker and Earthquaker
- [Teachable vs Podia vs Payhip vs Gumroad: where to sell an online course](teachable-vs-podia-vs-payhip-vs-gumroad-courses): plan prices and the real monthly cost at $500 and $3,000 in sales
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Thinkific's 2.9% + 30¢. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Thinkific, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
