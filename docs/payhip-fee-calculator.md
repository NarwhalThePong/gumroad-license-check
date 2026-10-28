---
layout: page
title: "Payhip fee calculator (2026): Free vs Plus vs Pro, what you keep per sale"
description: "Free Payhip fee calculator. Enter your price and monthly sales to see Payhip's 5%, 2% or 0% transaction fee plus Stripe or PayPal fees, what you keep per sale and per month, and the sales level where Payhip Plus ($29/month) and Pro ($99/month) start to pay off."
---

Payhip charges a transaction fee that depends on your plan: **5% on Free, 2% on Plus ($29 a month) and 0% on Pro ($99 a month)**. Stripe or PayPal then take their own processing fee on every sale, on every plan. Enter your price and how many sales you make a month to see each fee, what you keep, and which plan costs you the least. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

<div id="phf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="phf-price" type="number" min="0" step="0.01" value="19" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="phf-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processor<br><select id="phf-proc"><option value="stripe">Stripe card (2.9% + $0.30)</option><option value="paypal">PayPal Checkout (3.49% + $0.49)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your Payhip plan<br><select id="phf-plan"><option value="free">Free Forever ($0/month, 5%)</option><option value="plus">Plus ($29/month, 2%)</option><option value="pro">Pro ($99/month, 0%)</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="phf-intl" type="checkbox"> Buyer outside the US (adds PayPal's 1.5% international fee)</label></p>
  <p id="phf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Price</td><td style="text-align:right" id="phf-o-price">$0.00</td></tr>
    <tr><td>Payhip transaction fee (<span id="phf-o-pct">5%</span>)</td><td style="text-align:right" id="phf-o-pfee">$0.00</td></tr>
    <tr><td><span id="phf-o-procname">Stripe</span> processing fee</td><td style="text-align:right" id="phf-o-xfee">$0.00</td></tr>
    <tr><td>Total fees per sale</td><td style="text-align:right"><strong id="phf-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per sale</td><td style="text-align:right"><strong id="phf-o-net">$0.00</strong></td></tr>
    <tr><td>Effective fee per sale</td><td style="text-align:right" id="phf-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month on your plan</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Gross sales</td><td style="text-align:right" id="phf-m-gross">$0.00</td></tr>
    <tr><td>Payhip transaction fees</td><td style="text-align:right" id="phf-m-pfee">$0.00</td></tr>
    <tr><td>Processing fees</td><td style="text-align:right" id="phf-m-xfee">$0.00</td></tr>
    <tr><td>Plan fee</td><td style="text-align:right" id="phf-m-plan">$0.00</td></tr>
    <tr><td>Total cost</td><td style="text-align:right"><strong id="phf-m-cost">$0.00</strong></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="phf-m-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">All three plans at this price and volume</h3>
  <div style="overflow-x:auto">
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <thead><tr><th style="text-align:left">Plan</th><th style="text-align:right">Plan fee</th><th style="text-align:right">Payhip fees</th><th style="text-align:right">Processing</th><th style="text-align:right">Total cost</th><th style="text-align:right">You keep</th><th style="text-align:right">Effective fee</th></tr></thead>
    <tbody id="phf-cmp"></tbody>
  </table>
  </div>
  <p id="phf-best" style="margin:0 0 8px;font-weight:bold"></p>
  <p id="phf-be" style="margin:0"></p>
</div>

<script>
/* Payhip fee math. Payhip plans checked Oct 28, 2026; Stripe and PayPal US standard rates as on the PayPal & Stripe fee calculator. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    free: { id: "free", name: "Free Forever", monthly: 0, pct: 5 },
    plus: { id: "plus", name: "Plus", monthly: 29, pct: 2 },
    pro: { id: "pro", name: "Pro", monthly: 99, pct: 0 }
  };
  var ORDER = ["free", "plus", "pro"];
  var PROC = {
    stripe: { name: "Stripe", pct: 2.9, fixed: 0.30, intlPct: 0 },
    paypal: { name: "PayPal", pct: 3.49, fixed: 0.49, intlPct: 1.5 }
  };
  var MAX_PRICE = 1000000, MAX_SALES = 1000000;
  function r2(n) { return Math.round(n * 100) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function plan(id) { return PLANS[id] || PLANS.free; }
  function proc(id) { return PROC[id] || PROC.stripe; }
  function perSale(p, planId, procId, intl) {
    p = price(p); var pl = plan(planId), pr = proc(procId);
    var payhipFee = p > 0 ? r2(p * pl.pct / 100) : 0;
    var procFee = p > 0 ? r2(p * (pr.pct + (intl ? pr.intlPct : 0)) / 100 + pr.fixed) : 0;
    var total = r2(payhipFee + procFee);
    return { price: p, payhipFee: payhipFee, procFee: procFee, totalFee: total, net: r2(p - total), effective: p > 0 ? total / p : null };
  }
  function monthly(p, n, planId, procId, intl) {
    var s = perSale(p, planId, procId, intl), q = sales(n), pl = plan(planId);
    var gross = r2(s.price * q), pf = r2(s.payhipFee * q), xf = r2(s.procFee * q), cost = r2(pf + xf + pl.monthly);
    return { plan: pl.id, name: pl.name, sales: q, gross: gross, payhipFees: pf, procFees: xf, planFee: pl.monthly, totalCost: cost, net: r2(gross - cost), effective: gross > 0 ? cost / gross : null };
  }
  function compare(p, n, procId, intl) {
    var rows = ORDER.map(function (id) { return monthly(p, n, id, procId, intl); }), best = rows[0];
    rows.forEach(function (r) { if (r.totalCost < best.totalCost - 1e-9) best = r; });
    return { rows: rows, best: best.plan };
  }
  // Monthly sales (in dollars) above which plan b costs less than plan a. Processing fees are the same on every plan, so they cancel out.
  function breakEvenRevenue(aId, bId) {
    var a = plan(aId), b = plan(bId), d = (a.pct - b.pct) / 100;
    return d > 0 ? (b.monthly - a.monthly) / d : null;
  }
  // Smallest number of sales a month at this price where plan b costs strictly less than plan a.
  function breakEvenSales(p, aId, bId) {
    p = price(p); var a = plan(aId), b = plan(bId);
    var diffC = Math.round((r2(p * a.pct / 100) - r2(p * b.pct / 100)) * 100), mC = Math.round((b.monthly - a.monthly) * 100);
    if (!(diffC > 0)) return null;
    return Math.floor(mC / diffC) + 1;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, PROC: PROC, MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES, price: price, sales: sales,
    perSale: perSale, monthly: monthly, compare: compare, breakEvenRevenue: breakEvenRevenue, breakEvenSales: breakEvenSales };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PayhipFees = api;
})(this);
(function () {
  var F = window.PayhipFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var rawP = $("phf-price").value, rawN = $("phf-qty").value;
    var p = F.price(rawP), n = F.sales(rawN), pid = $("phf-plan").value, xid = $("phf-proc").value, intl = $("phf-intl").checked;
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Sales capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawP) < 0 || Number(rawN) < 0) w.push("Negative numbers are treated as 0.");
    set("phf-warn", w.join(" "));
    var s = F.perSale(p, pid, xid, intl), m = F.monthly(p, n, pid, xid, intl), pl = F.PLANS[pid], pr = F.PROC[xid];
    set("phf-o-price", money(s.price)); set("phf-o-pct", pl.pct + "%"); set("phf-o-pfee", money(s.payhipFee));
    set("phf-o-procname", pr.name + (intl && pr.intlPct ? " (international)" : "")); set("phf-o-xfee", money(s.procFee));
    set("phf-o-fee", money(s.totalFee)); set("phf-o-net", money(s.net)); set("phf-o-eff", pctS(s.effective));
    set("phf-m-gross", money(m.gross)); set("phf-m-pfee", money(m.payhipFees)); set("phf-m-xfee", money(m.procFees));
    set("phf-m-plan", money(m.planFee)); set("phf-m-cost", money(m.totalCost)); set("phf-m-net", money(m.net));
    var c = F.compare(p, n, xid, intl), tb = $("phf-cmp");
    while (tb.firstChild) tb.removeChild(tb.firstChild);
    c.rows.forEach(function (r) {
      var tr = document.createElement("tr");
      [r.name + (r.plan === c.best ? " (cheapest)" : ""), money(r.planFee), money(r.payhipFees), money(r.procFees), money(r.totalCost), money(r.net), pctS(r.effective)].forEach(function (t, i) {
        var td = document.createElement("td"); td.textContent = t; if (i) td.style.textAlign = "right";
        if (r.plan === c.best) td.style.fontWeight = "bold";
        tr.appendChild(td);
      });
      tb.appendChild(tr);
    });
    var best = F.PLANS[c.best], cur = c.rows.filter(function (r) { return r.plan === pid; })[0], br = c.rows.filter(function (r) { return r.plan === c.best; })[0];
    set("phf-best", n > 0 && p > 0 ? (c.best === pid ? "Your plan, " + best.name + ", is the cheapest at " + n.toLocaleString("en-US") + " sales a month." :
      best.name + " is cheapest at " + n.toLocaleString("en-US") + " sales a month: you'd keep " + money(br.net - cur.net) + " more a month than on " + pl.name + ".") : "Enter a price and monthly sales to compare plans.");
    function at(a, b) { var k = F.breakEvenSales(p, a, b); return k == null ? "" : " (at " + money(p) + ", from " + k.toLocaleString("en-US") + " sales a month)"; }
    set("phf-be", "Plus beats Free above " + money(F.breakEvenRevenue("free", "plus")) + " a month in sales" + at("free", "plus") +
      ". Pro beats Plus above " + money(F.breakEvenRevenue("plus", "pro")) + at("plus", "pro") +
      ". Pro beats Free above " + money(F.breakEvenRevenue("free", "pro")) + at("free", "pro") + ".");
  }
  ["phf-price", "phf-qty"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["phf-proc", "phf-plan", "phf-intl"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Payhip plans and fees (checked Oct 28, 2026)

| Plan | Monthly price | Payhip transaction fee | Processing fee (charged by Stripe or PayPal) |
|---|---|---|---|
| Free Forever | $0 | 5% | yes |
| Plus | $29 | 2% | yes |
| Pro | $99 | 0% | yes |

Every plan has the same features, unlimited products and unlimited revenue; only the monthly price and the transaction fee change. Payhip shows monthly prices only, with no annual plan, so a year costs $0, $348 or $1,188.

Processing fees used (US standard rates, the same as our [PayPal & Stripe fee calculator](paypal-stripe-fee-calculator)):

| Processor | Fee per sale |
|---|---|
| Stripe, domestic card | 2.9% + $0.30 |
| PayPal Checkout | 3.49% + $0.49 |
| PayPal, international buyer | add 1.5% |

Sources: [Payhip pricing](https://payhip.com/pricing) ("PayPal and Stripe will still charge at their standard rates ... This applies for all plans"), [Payhip Help Center: Billing and Upgrading](https://help.payhip.com/article/102-billing-and-upgrading), [Payhip Help Center: Connect Your Stripe Account](https://help.payhip.com/article/65-connecting-your-stripe-account) (standard Stripe fee 2.9% + $0.30), [Payhip Help Center: Connect Your PayPal Account](https://help.payhip.com/article/64-connecting-your-paypal-account), [Stripe pricing](https://stripe.com/pricing) and [PayPal merchant fees (US)](https://www.paypal.com/us/business/paypal-business-fees), all checked Oct 28, 2026. Rates change and your Stripe or PayPal account may have a different rate, so check your own account before you rely on a number.

## When does Payhip Plus or Pro pay off?

Stripe and PayPal charge the same on every plan, so only the Payhip fee and the monthly price decide which plan is cheapest:

- **Plus beats Free above $966.67 a month in sales.** Plus saves 3% of sales (5% down to 2%), and 3% covers the $29 at $29 / 0.03 = $966.67.
- **Pro beats Plus above $3,500 a month.** Pro saves another 2%, and 2% covers the extra $70 ($99 - $29) at $70 / 0.02 = $3,500.
- **Pro beats Free above $1,980 a month** ($99 / 0.05), but between $966.67 and $3,500 Plus is cheaper than both.

The calculator also shows the number of sales at your price where each switch pays off. This calculator rounds each fee to the cent on every sale, so the sales count can differ by one from simply dividing the dollar break-even by your price.

## How the numbers are worked out

```
Payhip fee per sale      = price x plan rate (5%, 2% or 0%), rounded to the cent
processing fee per sale  = price x processor % (+ 1.5% for PayPal international) + fixed fee, rounded to the cent
you keep per sale        = price - Payhip fee - processing fee
total cost per month     = (Payhip fee + processing fee) x sales + plan fee
you keep per month       = price x sales - total cost per month
```

Example: a $19 sale on the Free plan with Stripe costs $0.95 (5%) + $0.85 (2.9% + $0.30) = $1.80, so you keep $17.20. On Plus the Payhip fee is $0.38 and you keep $17.77 per sale, but you also pay $29 a month. At 50 sales a month Free costs $90.00 and Plus costs $90.50; from 51 sales Plus is cheaper.

Not included: sales tax and VAT (Payhip says it collects and remits digital EU/UK VAT and US/Canadian sales tax for you, so it isn't part of your price), Stripe's extra fees for international cards and currency conversion, refunds, chargebacks and payout fees.

## FAQ

### How much does Payhip take per sale?

On the Free Forever plan Payhip takes 5% of each sale, on Plus ($29 a month) 2%, and on Pro ($99 a month) nothing. Stripe or PayPal also charge their processing fee on top, on every plan, for example 2.9% + $0.30 for a US Stripe card payment.

### Does Payhip charge Stripe or PayPal fees on top?

Yes. Payhip doesn't process payments itself. Your connected Stripe or PayPal account charges its standard fee on each sale, and that money goes to Stripe or PayPal, not to Payhip. This applies on all three plans, including Pro.

### When should I upgrade from Payhip Free to Plus?

Once you sell more than about $967 a month. Below that, 5% of your sales is less than Plus's $29 plus 2%. Pro only becomes the cheapest plan above $3,500 a month in sales.

### Does Payhip have annual plans?

Payhip's pricing page lists monthly prices only ($0, $29 and $99), with no annual discount, so a year of Plus costs $348 and a year of Pro costs $1,188.

### Is Payhip cheaper than Gumroad?

On a direct sale, usually yes. Gumroad charges 10% + $0.50 plus card processing, while Payhip Free charges 5% plus processing. Compare both, and other platforms, at your own price in the [Seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Payhip take per sale?","acceptedAnswer":{"@type":"Answer","text":"On the Free Forever plan Payhip takes 5% of each sale, on Plus ($29 a month) 2%, and on Pro ($99 a month) nothing. Stripe or PayPal also charge their processing fee on top, on every plan, for example 2.9% + $0.30 for a US Stripe card payment."}},
{"@type":"Question","name":"Does Payhip charge Stripe or PayPal fees on top?","acceptedAnswer":{"@type":"Answer","text":"Yes. Payhip doesn't process payments itself. Your connected Stripe or PayPal account charges its standard fee on each sale, and that money goes to Stripe or PayPal, not to Payhip. This applies on all three plans, including Pro."}},
{"@type":"Question","name":"When should I upgrade from Payhip Free to Plus?","acceptedAnswer":{"@type":"Answer","text":"Once you sell more than about $967 a month. Below that, 5% of your sales is less than Plus's $29 plus 2%. Pro only becomes the cheapest plan above $3,500 a month in sales."}},
{"@type":"Question","name":"Does Payhip have annual plans?","acceptedAnswer":{"@type":"Answer","text":"Payhip's pricing page lists monthly prices only ($0, $29 and $99), with no annual discount, so a year of Plus costs $348 and a year of Pro costs $1,188."}},
{"@type":"Question","name":"Is Payhip cheaper than Gumroad?","acceptedAnswer":{"@type":"Answer","text":"On a direct sale, usually yes. Gumroad charges 10% + $0.50 plus card processing, while Payhip Free charges 5% plus processing. Compare both, and other platforms, at your own price in the Seller fee comparison calculator."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Payhip next to Gumroad, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [Gumroad alternatives: Payhip vs Sellfy vs SendOwl (2026)](gumroad-alternatives-payhip-sellfy-sendowl): fees, plan limits and the real monthly cost at $500 and $3,000 a month
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator) and [Gumroad fee calculator](gumroad-fee-calculator)
- [When do you get paid? Payout timing on Gumroad, Payhip, Etsy, Lemon Squeezy and Sellfy](when-do-you-get-paid-gumroad-payhip-etsy-lemon-squeezy-sellfy)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Payhip, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
