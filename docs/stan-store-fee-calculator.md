---
layout: page
title: "Stan Store fee calculator (2026): Stripe and PayPal fees, Creator vs Creator Pro, and what you keep"
description: "Free Stan Store fee calculator. Enter your price, monthly sales and plan to see Stan's 0% transaction fee, Stripe's 2.9% + 30¢ card fee with the international, currency and recurring add-ons, Afterpay, Klarna and PayPal rates, Stripe payout fees, your Creator or Creator Pro plan cost, and what you keep each month."
---

Stan Store takes **0% of your sales** on both plans. You pay a flat plan, **$29 a month for Creator** or **$99 a month for Creator Pro** (or **$300** and **$948** a year, which works out to $25 and $79 a month), plus the fees of the payment processor that handles the sale. In the US, a Stripe card sale costs **2.9% + 30¢**, plus **1.5%** if the buyer is in another country, **1%** for currency conversion and **0.5%** on recurring payments. On Creator Pro you can also offer **Afterpay (6.0% + 30¢)** and **Klarna (5.99% + 30¢)**. A buyer who pays with **PayPal** costs **3.49% + 49¢**, plus **1.5%** for an international buyer. Stripe also charges **0.25% + 25¢ per payout** to your bank. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="sf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="sf-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="sf-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Stan plan<br><select id="sf-plan"><option value="creator" selected>Creator</option><option value="pro">Creator Pro</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan billing<br><select id="sf-billing"><option value="monthly" selected>Monthly</option><option value="annual">Yearly</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment method<br><select id="sf-method"><option value="card" selected>Stripe: card</option><option value="afterpay">Stripe: Afterpay (Creator Pro)</option><option value="klarna">Stripe: Klarna (Creator Pro)</option><option value="paypal">PayPal</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Stripe payouts per month<br><input id="sf-payouts" type="number" min="0" step="1" value="1" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="sf-intl" type="checkbox"> Buyer in another country (+1.5%)</label> &nbsp; <label><input id="sf-fx" type="checkbox"> Currency conversion (+1%, Stripe card)</label> &nbsp; <label><input id="sf-rec" type="checkbox"> Recurring payment (+0.5%, Stripe card)</label></p>
  <p id="sf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="sf-s-price">$0.00</td></tr>
    <tr><td>Processing (<span id="sf-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="sf-s-proc">$0.00</td></tr>
    <tr><td>Stan transaction fee (0%)</td><td style="text-align:right" id="sf-s-stan">$0.00</td></tr>
    <tr><td>You keep per sale, before payouts and the plan cost</td><td style="text-align:right"><strong id="sf-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="sf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="sf-m-gross">$0.00</td></tr>
    <tr><td>Sale fees</td><td style="text-align:right" id="sf-m-fees">$0.00</td></tr>
    <tr><td>Stripe payout fees (0.25% + $0.25 each)</td><td style="text-align:right" id="sf-m-payout">$0.00</td></tr>
    <tr><td>Stan plan (<span id="sf-planname">Creator, monthly</span>)</td><td style="text-align:right" id="sf-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="sf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="sf-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Creator or Creator Pro?</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Creator: plan + fees</td><td style="text-align:right" id="sf-c-creator">$0.00</td></tr>
    <tr><td>Creator Pro: plan + fees</td><td style="text-align:right" id="sf-c-pro">$0.00</td></tr>
  </table>
  <p id="sf-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Break-even</h3>
  <p id="sf-be" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before payouts and the plan cost (USD)<br><input id="sf-target" type="number" min="0" step="0.01" value="95" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Stan Store fee math. Plan prices ($29/mo or $300/yr Creator, $99/mo or $948/yr Creator Pro) from Stan's "Creator vs. Creator Pro" help article (help.stan.store/article/31) and stan.store/blog/stan-store-pricing; Stan's 0% transaction fee, the US Stripe rates (2.9% + 30c card, 6.0% + 30c Afterpay, 5.99% + 30c Klarna, +1.5% international, +1% currency conversion, +0.5% recurring, 0.25% + 25c per payout) and PayPal's 3.49% from Stan's "Stan, Stripe, and PayPal Transaction Fees" article (help.stan.store/article/83); Stripe card rates also from stripe.com/pricing; PayPal's 49c US fixed fee and 1.5% international fee from paypal.com/us/business/paypal-business-fees. All checked Oct 28, 2026. US sellers, USD only. Afterpay and Klarna are Creator Pro only. Stan Payments, refunds, disputes, taxes, Afterpay/Klarna surcharges and the "(min. $1)" note on payouts are not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    creator: { name: "Creator", monthly: 29, yearly: 300 },
    pro: { name: "Creator Pro", monthly: 99, yearly: 948 }
  };
  var STAN_PCT = 0, CARD = 2.9, AFTERPAY = 6.0, KLARNA = 5.99, STRIPE_FIXED = 0.30, INTL = 1.5, FX = 1, REC = 0.5;
  var PAYPAL = 3.49, PAYPAL_FIXED = 0.49, PAYPAL_INTL = 1.5, PAYOUT_PCT = 0.25, PAYOUT_FIXED = 0.25;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000, MAX_PAYOUTS = 31;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function payouts(v) { return Math.min(Math.floor(num(v)), MAX_PAYOUTS); }
  function planKey(o) { return (o && o.plan) in PLANS ? o.plan : "creator"; }
  function method(o) { var m = o && o.method; return m === "afterpay" || m === "klarna" || m === "paypal" ? m : "card"; }
  function available(o) { var m = method(o); return !((m === "afterpay" || m === "klarna") && planKey(o) !== "pro"); }
  function procPct(o) { var m = method(o); if (m === "afterpay") return AFTERPAY; if (m === "klarna") return KLARNA; if (m === "paypal") return PAYPAL + (o.intl ? PAYPAL_INTL : 0); return CARD + (o.intl ? INTL : 0) + (o.fx ? FX : 0) + (o.rec ? REC : 0); }
  function procFixed(o) { return method(o) === "paypal" ? PAYPAL_FIXED : STRIPE_FIXED; }
  function perSale(v, o) {
    o = o || {}; var p = price(v), m = method(o), pp = procPct(o);
    if (p <= 0) return { price: 0, proc: 0, stan: 0, fee: 0, net: 0, effective: null, method: m, procPct: pp, procFixed: procFixed(o) };
    var proc = r2(p * pp / 100 + procFixed(o)), stan = r2(p * STAN_PCT / 100), fee = r2(proc + stan);
    return { price: p, proc: proc, stan: stan, fee: fee, net: r2(p - fee), effective: fee / p, method: m, procPct: pp, procFixed: procFixed(o) };
  }
  function planCost(o) { var pl = PLANS[planKey(o)]; return o && o.billing === "annual" ? r2(pl.yearly / 12) : pl.monthly; }
  function payoutFees(amount, n) { var a = num(amount), k = payouts(n); return a > 0 && k > 0 ? r2(a * PAYOUT_PCT / 100 + PAYOUT_FIXED * k) : 0; }
  function perMonth(v, q, o) {
    o = o || {}; var s = perSale(v, o), n = qty(q), gross = r2(s.price * n), fees = r2(s.fee * n), pc = planCost(o);
    var po = s.method === "paypal" ? 0 : payoutFees(gross - fees, o.payouts == null ? 1 : o.payouts);
    return { gross: gross, fees: fees, payout: po, plan: pc, net: r2(gross - fees - po - pc), effective: gross > 0 ? (fees + po + pc) / gross : null, available: available(o) };
  }
  function compare(v, q, o) {
    o = o || {}; var out = {}, best = null;
    for (var k in PLANS) { var oo = {}; for (var j in o) oo[j] = o[j]; oo.plan = k; var m = perMonth(v, q, oo); out[k] = m.available ? r2(m.fees + m.payout + m.plan) : null; }
    for (var k2 in PLANS) if (out[k2] != null && (best === null || out[k2] < out[best])) best = k2;
    out.best = best; return out;
  }
  function breakEven(v, o) {
    o = o || {}; var s = perSale(v, o), pc = planCost(o);
    var oc = {}, op = {}; for (var j in o) { oc[j] = o[j]; op[j] = o[j]; } oc.plan = "creator"; op.plan = "pro";
    var diff = r2(planCost(op) - planCost(oc));
    if (s.net <= 0) return { cover: null, proExtra: null, diff: diff };
    return { cover: Math.ceil(pc / s.net - 1e-9), proExtra: Math.ceil(diff / s.net - 1e-9), diff: diff };
  }
  function priceFor(v, o) {
    o = o || {}; var k = price(v); if (k <= 0) return null;
    var lo = 1, hi = MAX_PRICE * 100;
    if (perSale(MAX_PRICE, o).net < k) return null;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, o).net >= k) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, MAX_PAYOUTS: MAX_PAYOUTS, price: price, qty: qty, payouts: payouts, available: available, perSale: perSale, planCost: planCost, payoutFees: payoutFees, perMonth: perMonth, compare: compare, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.StanFees = api;
})(this);
(function () {
  var F = window.StanFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  var boxes = ["sf-intl", "sf-fx", "sf-rec"];
  function update() {
    var p = $("sf-price").value, q = $("sf-qty").value;
    var o = { plan: $("sf-plan").value, billing: $("sf-billing").value, method: $("sf-method").value, payouts: $("sf-payouts").value, intl: $("sf-intl").checked, fx: $("sf-fx").checked, rec: $("sf-rec").checked };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(o.payouts) > F.MAX_PAYOUTS) w.push("Payouts capped at " + F.MAX_PAYOUTS + " a month.");
    if (Number(p) < 0 || Number(q) < 0 || Number(o.payouts) < 0) w.push("Negative numbers are treated as 0.");
    if (!F.available(o)) w.push("Afterpay and Klarna are Creator Pro features, so this method isn't available on Creator.");
    if ((o.method === "afterpay" || o.method === "klarna") && (o.intl || o.fx || o.rec)) w.push("International, currency and recurring add-ons are modelled for Stripe card payments only, so they are ignored for this method.");
    if (o.method === "paypal" && (o.fx || o.rec)) w.push("Currency and recurring add-ons are Stripe card fees, so they are ignored for PayPal. PayPal pays out through PayPal, so no Stripe payout fee is counted.");
    set("sf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o), c = F.compare(p, q, o), b = F.breakEven(p, o), pl = F.PLANS[o.plan];
    set("sf-procrate", (Math.round(s.procPct * 100) / 100) + "% + $" + s.procFixed.toFixed(2) + (s.method === "paypal" ? ", PayPal" : ", Stripe"));
    set("sf-s-price", money(s.price)); set("sf-s-proc", money(s.proc)); set("sf-s-stan", money(s.stan)); set("sf-s-net", money(s.net)); set("sf-s-eff", pctS(s.effective));
    set("sf-planname", pl.name + ", " + (o.billing === "annual" ? "billed yearly" : "monthly"));
    set("sf-m-gross", money(m.gross)); set("sf-m-fees", money(m.fees)); set("sf-m-payout", money(m.payout)); set("sf-m-plan", money(m.plan)); set("sf-m-net", money(m.net)); set("sf-m-eff", pctS(m.effective));
    set("sf-c-creator", c.creator == null ? "not available" : money(c.creator)); set("sf-c-pro", money(c.pro));
    set("sf-best", c.best == null ? "" : "Cheapest at these sales: " + F.PLANS[c.best].name + " (" + money(c[c.best]) + " a month). Stan charges no transaction fee on either plan, so Creator Pro only pays off if its extra features, such as payment plans, discount codes, upsells, Afterpay, Klarna and email marketing, bring in more sales.");
    set("sf-be", b.cover == null ? "Enter a price above the fees to see the break-even." : "At " + money(s.net) + " kept per sale, you need " + b.cover + " sale" + (b.cover === 1 ? "" : "s") + " a month to cover the " + money(F.planCost(o)) + " plan. Creator Pro costs " + money(b.diff) + " a month more than Creator, so it pays off once its features add " + b.proExtra + " extra sale" + (b.proExtra === 1 ? "" : "s") + " a month at this price.");
    var need = F.priceFor($("sf-target").value, o);
    set("sf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("sf-target").value)) + " per sale, before payouts and the plan cost.");
  }
  ["sf-price", "sf-qty", "sf-target", "sf-payouts"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["sf-plan", "sf-billing", "sf-method"].concat(boxes).forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Stan Store fees (checked Oct 28, 2026)

| Plan | Monthly billing | Billed yearly | Stan transaction fee | Stripe card rate (US) | Afterpay and Klarna |
|---|---|---|---|---|---|
| Creator | $29/mo | $300/yr ($25/mo) | 0% | 2.9% + 30¢ | Not included |
| Creator Pro | $99/mo | $948/yr ($79/mo) | 0% | 2.9% + 30¢ | 6.0% + 30¢ and 5.99% + 30¢ |

| Fee (US seller) | Rate |
|---|---|
| Stripe card | 2.9% + 30¢ |
| Buyer in another country (Stripe) | +1.5% |
| Currency conversion (Stripe) | +1% |
| Recurring payments (Stripe) | +0.5% |
| Afterpay (Creator Pro) | 6.0% + 30¢ |
| Klarna (Creator Pro) | 5.99% + 30¢ |
| Stripe payout to your bank | 0.25% + 25¢ per payout |
| PayPal | 3.49% + 49¢ |
| PayPal buyer in another country | +1.5% |

Rates come from Stan's [Creator vs. Creator Pro article](https://help.stan.store/article/31-creator-vs-creator-pro) and [pricing guide](https://stan.store/blog/stan-store-pricing/) (plan prices), Stan's [Stan, Stripe, and PayPal Transaction Fees article](https://help.stan.store/article/83-stan-stripes-transaction-fees) (the 0% Stan fee, every Stripe rate and PayPal's 3.49%), [Stripe's pricing page](https://stripe.com/pricing) (2.9% + 30¢, +1.5% international, +1% conversion) and [PayPal's US merchant fees page](https://www.paypal.com/us/business/paypal-business-fees) (the 49¢ fixed fee and 1.5% international fee), all checked Oct 28, 2026. The calculator covers US sellers charging in USD. Stan lists different Stripe rates for Canada, the UK, Australia and New Zealand, which aren't modelled. Stan Payments, taxes, disputes, any interest Afterpay or Klarna charge your buyer, and the "(min. $1)" note Stan gives next to the payout fee aren't modelled either. Refunds return the full price to the buyer, but Stripe keeps its fee. Treat the numbers as estimates and check the fee breakdown in your Stan Income tab, or in PayPal for PayPal sales.

## How the numbers are worked out

```
processing  = price x (2.9% + 1.5% if abroad + 1% if converted + 0.5% if recurring) + 30¢
              or price x 6.0% + 30¢ for Afterpay, or 5.99% + 30¢ for Klarna (Creator Pro)
              or price x (3.49% + 1.5% if abroad) + 49¢ for PayPal
stan fee    = 0
you keep    = price - processing
payouts     = (Stripe takings this month) x 0.25% + 25¢ x payouts
per month   = you keep x sales - payouts - plan cost
```

A $100 product paid by a US card costs $3.20 (2.9% + 30¢), so you keep $96.80. At 20 sales a month on Creator billed monthly, $2,000 in sales minus $64 in card fees, a $5.09 Stripe payout fee for one payout of $1,936 and the $29 plan leaves $1,901.91. The same buyer paying with PayPal costs $3.98.

## FAQ

### Does Stan Store take a percentage of sales?

No. Stan charges a 0% transaction fee on both plans. You pay the flat plan and the processing fee of Stripe or PayPal, which is 2.9% + 30¢ for a US card through Stripe.

### How much does Stan Store cost?

Creator is $29 a month or $300 a year, and Creator Pro is $99 a month or $948 a year. Billed yearly, that's $25 and $79 a month. There's no free plan, only a 14-day free trial.

### What does PayPal cost on Stan Store?

PayPal's standard fee applies: 3.49% + 49¢ per sale in the US, plus 1.5% if your buyer is in another country. PayPal fees don't show in your Stan Income tab, only in PayPal.

### Is Creator Pro worth it?

Only if you'll use its features. Stan's fees are the same on both plans, so Creator Pro costs $70 a month more ($54 a month billed yearly) for payment plans, discount codes, upsells and order bumps, Afterpay and Klarna, affiliate management and email marketing.

### Is Stan Store cheaper than Kajabi or Podia?

Stan's $29 Creator plan costs less than Kajabi's cheapest plan and has no transaction fee, while Podia's Mover plan adds a 5% fee. Compare with the [Kajabi fee calculator](kajabi-fee-calculator) and the [Podia fee calculator](podia-fee-calculator) at your own numbers.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "Does Stan Store take a percentage of sales?", "acceptedAnswer": {"@type": "Answer", "text": "No. Stan charges a 0% transaction fee on both plans. You pay the flat plan and the processing fee of Stripe or PayPal, which is 2.9% + 30 cents for a US card through Stripe."}},
{"@type": "Question", "name": "How much does Stan Store cost?", "acceptedAnswer": {"@type": "Answer", "text": "Creator is $29 a month or $300 a year, and Creator Pro is $99 a month or $948 a year. Billed yearly, that's $25 and $79 a month. There's no free plan, only a 14-day free trial."}},
{"@type": "Question", "name": "What does PayPal cost on Stan Store?", "acceptedAnswer": {"@type": "Answer", "text": "PayPal's standard fee applies: 3.49% + 49 cents per sale in the US, plus 1.5% if your buyer is in another country. PayPal fees don't show in your Stan Income tab, only in PayPal."}},
{"@type": "Question", "name": "Is Creator Pro worth it?", "acceptedAnswer": {"@type": "Answer", "text": "Only if you'll use its features. Stan's fees are the same on both plans, so Creator Pro costs $70 a month more ($54 a month billed yearly) for payment plans, discount codes, upsells and order bumps, Afterpay and Klarna, affiliate management and email marketing."}},
{"@type": "Question", "name": "Is Stan Store cheaper than Kajabi or Podia?", "acceptedAnswer": {"@type": "Answer", "text": "Stan's $29 Creator plan costs less than Kajabi's cheapest plan and has no transaction fee, while Podia's Mover plan adds a 5% fee."}}
]}
</script>

## Related tools and guides

- [Kajabi fee calculator (2026)](kajabi-fee-calculator): no transaction fee, but $179 to $499 plans and 2.7% to 2.9% + 30¢ card rates
- [Podia fee calculator (2026)](podia-fee-calculator): the 5% Mover fee vs Shaker and Earthquaker
- [Whop fee calculator (2026)](whop-fee-calculator): the 2.7% + 30¢ card fee and the 3% app fee
- [Skool fee calculator (2026)](skool-fee-calculator): Hobby $9 + 10% vs Pro $99 + 2.9% for paid communities
- [Thinkific fee calculator (2026)](thinkific-fee-calculator): no transaction fee with Thinkific Payments, $109 to $499 plans, and a 2% to 0.5% fee for your own Stripe
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Stripe's 2.9% + 30¢ on Stan Store. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Stan, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
