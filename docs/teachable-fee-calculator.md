---
layout: page
title: "Teachable fee calculator (2026): the 7.5% Starter fee, card and PayPal processing, plan cost and what you keep"
description: "Free Teachable fee calculator. Enter your course price and monthly sales to see Teachable's 7.5% Starter transaction fee, Teachable Payments processing for US and international cards and PayPal, your plan cost, what you keep per sale and per month, and the sales level where Builder beats Starter."
---

Teachable charges a monthly plan fee, and on the **Starter plan it also keeps a 7.5% transaction fee** on each sale. Builder and Growth have **0% transaction fees** when you use Teachable Payments. Every sale also pays processing: **2.9% + 30¢ for US cards**, 3.9% + 30¢ for international cards, 3.49% + 49¢ for US PayPal and 4.99% + 49¢ for international PayPal. Enter your price and sales below to see each fee, the plan cost spread over your sales, and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="tc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="tc-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="tc-qty" type="number" min="0" step="1" value="10" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan<br><select id="tc-plan"><option value="starter" selected>Starter (7.5% fee)</option><option value="builder">Builder (0% fee)</option><option value="growth">Growth (0% fee)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan billing<br><select id="tc-billing"><option value="yearly" selected>Yearly</option><option value="monthly">Monthly</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer pays with<br><select id="tc-method"><option value="us_card" selected>US card (2.9% + 30¢)</option><option value="intl_card">International card (3.9% + 30¢)</option><option value="us_paypal">US PayPal (3.49% + 49¢)</option><option value="intl_paypal">International PayPal (4.99% + 49¢)</option></select></label></p>
  </div>
  <p id="tc-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="tc-s-price">$0.00</td></tr>
    <tr><td>Teachable transaction fee (<span id="tc-txrate">7.5%</span>)</td><td style="text-align:right" id="tc-s-tx">$0.00</td></tr>
    <tr><td>Processing (<span id="tc-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="tc-s-proc">$0.00</td></tr>
    <tr><td>You keep per sale, before the plan fee</td><td style="text-align:right"><strong id="tc-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="tc-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="tc-m-gross">$0.00</td></tr>
    <tr><td>Transaction and processing fees</td><td style="text-align:right" id="tc-m-fees">$0.00</td></tr>
    <tr><td>Plan cost (<span id="tc-planname">Starter, yearly</span>)</td><td style="text-align:right" id="tc-m-plan">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="tc-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="tc-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">All three plans at these sales</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><th style="text-align:left">Plan</th><th style="text-align:right">Plan cost</th><th style="text-align:right">All fees</th><th style="text-align:right">You keep</th></tr>
    <tr><td>Starter</td><td style="text-align:right" id="tc-c-starter-plan"></td><td style="text-align:right" id="tc-c-starter-fee"></td><td style="text-align:right" id="tc-c-starter-net"></td></tr>
    <tr><td>Builder</td><td style="text-align:right" id="tc-c-builder-plan"></td><td style="text-align:right" id="tc-c-builder-fee"></td><td style="text-align:right" id="tc-c-builder-net"></td></tr>
    <tr><td>Growth</td><td style="text-align:right" id="tc-c-growth-plan"></td><td style="text-align:right" id="tc-c-growth-fee"></td><td style="text-align:right" id="tc-c-growth-net"></td></tr>
  </table>
  <p id="tc-be" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before the plan fee (USD)<br><input id="tc-target" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="tc-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Teachable fee math. Rates from teachable.com/pricing (plans, transaction fees and "Additional plan information" processing fees), checked Oct 28, 2026. USD only; optional BackOffice fee, taxes and chargebacks not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = { starter: { name: "Starter", tx: 7.5, monthly: 39, yearly: 29 }, builder: { name: "Builder", tx: 0, monthly: 89, yearly: 69 }, growth: { name: "Growth", tx: 0, monthly: 189, yearly: 139 } };
  var METHODS = { us_card: { pct: 2.9, fixed: 0.30 }, intl_card: { pct: 3.9, fixed: 0.30 }, us_paypal: { pct: 3.49, fixed: 0.49 }, intl_paypal: { pct: 4.99, fixed: 0.49 } };
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(n) { return Math.round(n * 100 + 1e-7) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function qty(v) { return Math.floor(clean(v, MAX_QTY)); }
  function plan(k) { return PLANS[k] || PLANS.starter; }
  function method(k) { return METHODS[k] || METHODS.us_card; }
  function planCost(k, billing) { var p = plan(k); return billing === "monthly" ? p.monthly : p.yearly; }
  function perSale(p, o) {
    o = o || {}; p = price(p); var pl = plan(o.plan), m = method(o.method);
    var tx = p > 0 ? r2(p * pl.tx / 100) : 0, proc = p > 0 ? r2(p * m.pct / 100 + m.fixed) : 0, fee = r2(tx + proc);
    return { price: p, txPct: pl.tx, tx: tx, procPct: m.pct, procFixed: m.fixed, proc: proc, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function perMonth(p, q, o) {
    o = o || {}; var s = perSale(p, o), n = qty(q), cost = planCost(o.plan, o.billing);
    var gross = r2(s.price * n), fees = r2(s.fee * n), net = r2(gross - fees - cost);
    return { sales: n, gross: gross, fees: fees, plan: cost, net: net, effective: gross > 0 ? (fees + cost) / gross : null };
  }
  function breakEven(billing) { return r2((planCost("builder", billing) - planCost("starter", billing)) / (PLANS.starter.tx / 100)); }
  function priceFor(target, o) {
    var k = price(target); if (!(k > 0)) return null; o = o || {}; var pl = plan(o.plan), m = method(o.method);
    var g = 1 - (pl.tx + m.pct) / 100; if (g <= 0) return null;
    var p = Math.max(0.01, Math.ceil(((k + m.fixed) / g) * 100 - 1e-6) / 100);
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, METHODS: METHODS, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, planCost: planCost, perSale: perSale, perMonth: perMonth, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.TeachableFees = api;
})(this);
(function () {
  var F = window.TeachableFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var p = $("tc-price").value, q = $("tc-qty").value, o = { plan: $("tc-plan").value, billing: $("tc-billing").value, method: $("tc-method").value };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(p) < 0 || Number(q) < 0) w.push("Negative numbers are treated as 0.");
    set("tc-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o);
    set("tc-txrate", s.txPct + "%"); set("tc-procrate", s.procPct + "% + " + money(s.procFixed));
    set("tc-s-price", money(s.price)); set("tc-s-tx", money(s.tx)); set("tc-s-proc", money(s.proc)); set("tc-s-net", money(s.net)); set("tc-s-eff", pctS(s.effective));
    set("tc-planname", F.PLANS[o.plan].name + ", " + o.billing);
    set("tc-m-gross", money(m.gross)); set("tc-m-fees", money(m.fees)); set("tc-m-plan", money(m.plan)); set("tc-m-net", money(m.net)); set("tc-m-eff", pctS(m.effective));
    ["starter", "builder", "growth"].forEach(function (k) { var c = F.perMonth(p, q, { plan: k, billing: o.billing, method: o.method });
      set("tc-c-" + k + "-plan", money(c.plan)); set("tc-c-" + k + "-fee", money(c.fees)); set("tc-c-" + k + "-net", money(c.net)); });
    set("tc-be", "On " + o.billing + " billing, Builder costs less than Starter once you sell more than " + money(F.breakEven(o.billing)) + " a month (the extra plan cost divided by Starter's 7.5% fee).");
    var need = F.priceFor($("tc-target").value, o);
    set("tc-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("tc-target").value)) + " per sale on " + F.PLANS[o.plan].name + ".");
  }
  ["tc-price", "tc-qty", "tc-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["tc-plan", "tc-billing", "tc-method"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Teachable fees (checked Oct 28, 2026)

| Plan | Monthly billing | Yearly billing (per month) | Transaction fee | Products |
|---|---|---|---|---|
| Starter | $39 | $29 | 7.5% | 5 |
| Builder | $89 | $69 | 0% with Teachable Payments | 10 |
| Growth | $189 | $139 | 0% with Teachable Payments | 50 |

| Processing fee | Rate |
|---|---|
| US credit and debit cards | 2.9% + 30¢ |
| International credit and debit cards | 3.9% + 30¢ |
| US PayPal | 3.49% + 49¢ |
| International PayPal | 4.99% + 49¢ |
| Chargeback | $15 |
| BackOffice (optional) | 2% to 2.8% |

Source: [Teachable's pricing page](https://www.teachable.com/pricing), including its "Additional plan information" section, checked Oct 28, 2026. Limited-time offers are left out. Teachable Payments pays out daily. The optional BackOffice service, chargebacks, sales tax and VAT are not included in the calculator, so treat the numbers as estimates and check your Teachable dashboard.

## How the numbers are worked out

```
transaction fee = price x 7.5% on Starter, 0% on Builder and Growth
processing      = price x rate + fixed fee (30¢ cards, 49¢ PayPal)
you keep        = price - transaction fee - processing
per month       = you keep x sales - plan cost
```

A $100 course sold on Starter to a US card buyer pays $7.50 (7.5%) + $3.20 (2.9% + 30¢) = $10.70 in fees, so you keep $89.30 before the plan fee. On Builder you keep $96.80. At 10 sales a month on yearly billing, Starter leaves you $864.00 after its $29 plan cost and Builder leaves you $899.00 after $69.

**When Builder pays off.** Builder costs $40 a month more than Starter on yearly billing ($50 on monthly), and it saves 7.5% of every sale. So Builder comes out ahead once you sell more than about $533 a month on yearly billing, or about $667 a month on monthly billing.

## FAQ

### How much does Teachable take per sale?

On the Starter plan Teachable keeps 7.5% of each sale. On Builder and Growth there is no Teachable transaction fee when you use Teachable Payments. Processing is charged on every plan: 2.9% + 30¢ for US cards, 3.9% + 30¢ for international cards, 3.49% + 49¢ for US PayPal and 4.99% + 49¢ for international PayPal.

### Is Teachable Starter or Builder cheaper?

Starter is cheaper while your sales are small. Builder costs $40 a month more on yearly billing and removes the 7.5% fee, so it becomes cheaper once you sell more than about $533 a month (about $667 a month on monthly billing).

### Do buyers pay Teachable's fees?

No. Buyers pay the price you set, plus any sales tax or VAT. The transaction fee and processing fee come out of your earnings.

### How much does a $100 course on Teachable earn me?

With a US card buyer, you keep $89.30 per sale on Starter and $96.80 per sale on Builder or Growth, before the monthly plan cost.

### Is Teachable cheaper than Podia, Payhip or Gumroad?

It depends on how much you sell. At low sales, a free plan with a percentage fee usually costs less. At higher sales, flat plans with no transaction fee such as Teachable Builder come out ahead. See [Teachable vs Podia vs Payhip vs Gumroad](teachable-vs-podia-vs-payhip-vs-gumroad-courses) for worked examples, and the [Payhip fee calculator](payhip-fee-calculator) and [Gumroad fee calculator](gumroad-fee-calculator) to run your own numbers.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Teachable take per sale?","acceptedAnswer":{"@type":"Answer","text":"On the Starter plan Teachable keeps 7.5% of each sale. On Builder and Growth there is no Teachable transaction fee when you use Teachable Payments. Processing is charged on every plan: 2.9% + 30 cents for US cards, 3.9% + 30 cents for international cards, 3.49% + 49 cents for US PayPal and 4.99% + 49 cents for international PayPal."}},
{"@type":"Question","name":"Is Teachable Starter or Builder cheaper?","acceptedAnswer":{"@type":"Answer","text":"Starter is cheaper while your sales are small. Builder costs $40 a month more on yearly billing and removes the 7.5% fee, so it becomes cheaper once you sell more than about $533 a month (about $667 a month on monthly billing)."}},
{"@type":"Question","name":"Do buyers pay Teachable's fees?","acceptedAnswer":{"@type":"Answer","text":"No. Buyers pay the price you set, plus any sales tax or VAT. The transaction fee and processing fee come out of your earnings."}},
{"@type":"Question","name":"How much does a $100 course on Teachable earn me?","acceptedAnswer":{"@type":"Answer","text":"With a US card buyer, you keep $89.30 per sale on Starter and $96.80 per sale on Builder or Growth, before the monthly plan cost."}},
{"@type":"Question","name":"Is Teachable cheaper than Podia, Payhip or Gumroad?","acceptedAnswer":{"@type":"Answer","text":"It depends on how much you sell. At low sales, a free plan with a percentage fee usually costs less. At higher sales, flat plans with no transaction fee such as Teachable Builder come out ahead."}}
]}
</script>

## Related tools and guides

- [Teachable vs Podia vs Payhip vs Gumroad: where to sell an online course](teachable-vs-podia-vs-payhip-vs-gumroad-courses): plan prices and the real monthly cost at $500 and $3,000 in sales
- [Podia fee calculator (2026)](podia-fee-calculator): the 5% Mover fee vs Shaker and Earthquaker
- [Payhip fee calculator (2026)](payhip-fee-calculator): Payhip's 5%, 2% or 0% fee on Free, Plus and Pro
- [Gumroad fee calculator](gumroad-fee-calculator): fee, payout and effective rate for direct and Discover sales
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Teachable Starter's 7.5%. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Teachable, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
