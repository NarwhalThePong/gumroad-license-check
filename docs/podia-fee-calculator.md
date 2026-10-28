---
layout: page
title: "Podia fee calculator (2026): the 5% Mover fee, Stripe and PayPal processing, plan cost and what you keep"
description: "Free Podia fee calculator. Enter your price and monthly sales to see Podia's 5% Mover transaction fee, Stripe or PayPal processing, your Mover, Shaker or Earthquaker plan cost, what you keep per sale and per month, and the sales level where Shaker beats Mover."
---

Podia charges a monthly plan fee, and on the **Mover plan it also keeps a 5% transaction fee** on each sale. Shaker and Earthquaker have **no Podia transaction fee**. Every sale also pays your own payment processor: Stripe or PayPal charge a **standard 2.9% + 30¢**, which can vary by country. PayPal is only available on Shaker and Earthquaker. Enter your price and sales below to see each fee, the plan cost and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="pc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="pc-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="pc-qty" type="number" min="0" step="1" value="10" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan<br><select id="pc-plan"><option value="mover" selected>Mover (5% fee)</option><option value="shaker">Shaker (no fee)</option><option value="earthquaker">Earthquaker (no fee)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan billing<br><select id="pc-billing"><option value="yearly" selected>Yearly</option><option value="monthly">Monthly</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Processing rate (%)<br><input id="pc-pct" type="number" min="0" step="0.01" value="2.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Fixed fee per sale (USD)<br><input id="pc-fixed" type="number" min="0" step="0.01" value="0.30" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px;font-size:90%">The default 2.9% + 30¢ is the standard rate Podia quotes for Stripe and PayPal. Change it if your Stripe or PayPal account shows a different rate, for example for international cards.</p>
  <p id="pc-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="pc-s-price">$0.00</td></tr>
    <tr><td>Podia transaction fee (<span id="pc-txrate">5%</span>)</td><td style="text-align:right" id="pc-s-tx">$0.00</td></tr>
    <tr><td>Processing (<span id="pc-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="pc-s-proc">$0.00</td></tr>
    <tr><td>You keep per sale, before the plan fee</td><td style="text-align:right"><strong id="pc-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="pc-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="pc-m-gross">$0.00</td></tr>
    <tr><td>Transaction and processing fees</td><td style="text-align:right" id="pc-m-fees">$0.00</td></tr>
    <tr><td>Plan cost (<span id="pc-planname">Mover, yearly</span>)</td><td style="text-align:right" id="pc-m-plan">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="pc-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="pc-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">All three plans at these sales</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><th style="text-align:left">Plan</th><th style="text-align:right">Plan cost</th><th style="text-align:right">All fees</th><th style="text-align:right">You keep</th></tr>
    <tr><td>Mover</td><td style="text-align:right" id="pc-c-mover-plan"></td><td style="text-align:right" id="pc-c-mover-fee"></td><td style="text-align:right" id="pc-c-mover-net"></td></tr>
    <tr><td>Shaker</td><td style="text-align:right" id="pc-c-shaker-plan"></td><td style="text-align:right" id="pc-c-shaker-fee"></td><td style="text-align:right" id="pc-c-shaker-net"></td></tr>
    <tr><td>Earthquaker</td><td style="text-align:right" id="pc-c-earthquaker-plan"></td><td style="text-align:right" id="pc-c-earthquaker-fee"></td><td style="text-align:right" id="pc-c-earthquaker-net"></td></tr>
  </table>
  <p id="pc-be" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before the plan fee (USD)<br><input id="pc-target" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="pc-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Podia fee math. Rates from podia.com/pricing (plans, FAQ on transaction and processing fees) and help.podia.com "Understanding Podia transaction fees" and "Accepting payments in Podia", checked Oct 28, 2026. USD only; extra email subscribers, taxes, refunds and chargebacks not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = { mover: { name: "Mover", tx: 5, monthly: 49, yearly: 42 }, shaker: { name: "Shaker", tx: 0, monthly: 99, yearly: 84 }, earthquaker: { name: "Earthquaker", tx: 0, monthly: 179, yearly: 150 } };
  var DEFAULT_PCT = 2.9, DEFAULT_FIXED = 0.30, MAX_PCT = 20, MAX_FIXED = 10;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(n) { return Math.round(n * 100 + 1e-7) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function qty(v) { return Math.floor(clean(v, MAX_QTY)); }
  function plan(k) { return PLANS[k] || PLANS.mover; }
  function rate(o) {
    var pct = o.pct === undefined || o.pct === "" || o.pct === null || !isFinite(Number(o.pct)) ? DEFAULT_PCT : Math.min(Math.max(Number(o.pct), 0), MAX_PCT);
    var fixed = o.fixed === undefined || o.fixed === "" || o.fixed === null || !isFinite(Number(o.fixed)) ? DEFAULT_FIXED : Math.min(Math.max(Number(o.fixed), 0), MAX_FIXED);
    return { pct: pct, fixed: fixed };
  }
  function planCost(k, billing) { var p = plan(k); return billing === "monthly" ? p.monthly : p.yearly; }
  function perSale(p, o) {
    o = o || {}; p = price(p); var pl = plan(o.plan), m = rate(o);
    var tx = p > 0 ? r2(p * pl.tx / 100) : 0, proc = p > 0 ? r2(p * m.pct / 100 + m.fixed) : 0, fee = r2(tx + proc);
    return { price: p, txPct: pl.tx, tx: tx, procPct: m.pct, procFixed: m.fixed, proc: proc, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function perMonth(p, q, o) {
    o = o || {}; var s = perSale(p, o), n = qty(q), cost = planCost(o.plan, o.billing);
    var gross = r2(s.price * n), fees = r2(s.fee * n), net = r2(gross - fees - cost);
    return { sales: n, gross: gross, fees: fees, plan: cost, net: net, effective: gross > 0 ? (fees + cost) / gross : null };
  }
  function breakEven(billing) { return r2((planCost("shaker", billing) - planCost("mover", billing)) / (PLANS.mover.tx / 100)); }
  function priceFor(target, o) {
    var k = price(target); if (!(k > 0)) return null; o = o || {}; var pl = plan(o.plan), m = rate(o);
    var g = 1 - (pl.tx + m.pct) / 100; if (g <= 0) return null;
    var p = Math.max(0.01, Math.ceil(((k + m.fixed) / g) * 100 - 1e-6) / 100);
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, DEFAULT_PCT: DEFAULT_PCT, DEFAULT_FIXED: DEFAULT_FIXED, MAX_PCT: MAX_PCT, MAX_FIXED: MAX_FIXED, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, rate: rate, planCost: planCost, perSale: perSale, perMonth: perMonth, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PodiaFees = api;
})(this);
(function () {
  var F = window.PodiaFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var p = $("pc-price").value, q = $("pc-qty").value, o = { plan: $("pc-plan").value, billing: $("pc-billing").value, pct: $("pc-pct").value, fixed: $("pc-fixed").value };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(o.pct) > F.MAX_PCT) w.push("Processing rate capped at " + F.MAX_PCT + "%.");
    if (Number(o.fixed) > F.MAX_FIXED) w.push("Fixed fee capped at " + money(F.MAX_FIXED) + ".");
    if (Number(p) < 0 || Number(q) < 0 || Number(o.pct) < 0 || Number(o.fixed) < 0) w.push("Negative numbers are treated as 0.");
    set("pc-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o);
    set("pc-txrate", s.txPct + "%"); set("pc-procrate", s.procPct + "% + " + money(s.procFixed));
    set("pc-s-price", money(s.price)); set("pc-s-tx", money(s.tx)); set("pc-s-proc", money(s.proc)); set("pc-s-net", money(s.net)); set("pc-s-eff", pctS(s.effective));
    set("pc-planname", F.PLANS[o.plan].name + ", " + o.billing);
    set("pc-m-gross", money(m.gross)); set("pc-m-fees", money(m.fees)); set("pc-m-plan", money(m.plan)); set("pc-m-net", money(m.net)); set("pc-m-eff", pctS(m.effective));
    ["mover", "shaker", "earthquaker"].forEach(function (k) { var c = F.perMonth(p, q, { plan: k, billing: o.billing, pct: o.pct, fixed: o.fixed });
      set("pc-c-" + k + "-plan", money(c.plan)); set("pc-c-" + k + "-fee", money(c.fees)); set("pc-c-" + k + "-net", money(c.net)); });
    set("pc-be", "On " + o.billing + " billing, Shaker costs less than Mover once you sell more than " + money(F.breakEven(o.billing)) + " a month (the extra plan cost divided by Mover's 5% fee). Earthquaker has the same 0% fee as Shaker, so it only pays off for its higher limits.");
    var need = F.priceFor($("pc-target").value, o);
    set("pc-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("pc-target").value)) + " per sale on " + F.PLANS[o.plan].name + ".");
  }
  ["pc-price", "pc-qty", "pc-target", "pc-pct", "pc-fixed"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["pc-plan", "pc-billing"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Podia fees (checked Oct 28, 2026)

| Plan | Monthly billing | Yearly billing (per month) | Podia transaction fee | Products | Email subscribers included |
|---|---|---|---|---|---|
| Mover | $49 | $42 ($504 a year) | 5% | 50 | 100 |
| Shaker | $99 | $84 ($1,008 a year) | None | 150 | 500 |
| Earthquaker | $179 | $150 ($1,800 a year) | None | Unlimited | 1,000 |

Processing is charged by your own Stripe or PayPal account, not by Podia. Podia quotes the standard rate as 2.9% + 30¢, which can vary by country. PayPal is only supported on Shaker and Earthquaker, so Mover sellers take payments through Stripe (cards, Apple Pay, Google Pay, Link and other methods Stripe supports).

Sources: [Podia's pricing page](https://www.podia.com/pricing) and its FAQ, plus the Podia Help Center articles [Understanding Podia transaction fees](https://help.podia.com/en/articles/11371138-understanding-podia-transaction-fees) and [Accepting payments in Podia](https://help.podia.com/en/articles/11370248-accepting-payments-in-podia), checked Oct 28, 2026. Extra email subscribers, sales tax, refunds and chargebacks are not included, so treat the numbers as estimates and check your Stripe or PayPal dashboard.

## How the numbers are worked out

```
transaction fee = price x 5% on Mover, 0% on Shaker and Earthquaker
processing      = price x 2.9% + 30¢ (or the rate you enter)
you keep        = price - transaction fee - processing
per month       = you keep x sales - plan cost
```

A $100 course sold on Mover pays $5.00 (5%) + $3.20 (2.9% + 30¢) = $8.20 in fees, so you keep $91.80 before the plan fee. On Shaker you keep $96.80. At 10 sales a month on yearly billing, Mover leaves you $876.00 after its $42 plan cost and Shaker leaves you $884.00 after $84.

**When Shaker pays off.** Shaker costs $42 a month more than Mover on yearly billing ($50 on monthly), and it removes the 5% fee. So Shaker comes out ahead once you sell more than $840 a month on yearly billing, or $1,000 a month on monthly billing.

## FAQ

### How much does Podia take per sale?

On the Mover plan Podia keeps 5% of each sale. On Shaker and Earthquaker Podia takes no transaction fee. Your Stripe or PayPal account also charges processing on every plan, usually 2.9% + 30¢.

### Is Podia Mover or Shaker cheaper?

Mover is cheaper while your sales are small. Shaker costs $42 a month more on yearly billing and removes the 5% fee, so it becomes cheaper once you sell more than $840 a month ($1,000 a month on monthly billing).

### Can I use PayPal on Podia Mover?

No. PayPal is only supported on Shaker and Earthquaker. On Mover you accept payments through Stripe.

### How much does a $100 course on Podia earn me?

With the standard 2.9% + 30¢ processing rate, you keep $91.80 per sale on Mover and $96.80 per sale on Shaker or Earthquaker, before the monthly plan cost.

### Is Podia cheaper than Teachable, Payhip or Gumroad?

It depends on how much you sell. Podia Mover's 5% fee is lower than Teachable Starter's 7.5%, but its plan costs more. Flat plans with no transaction fee come out ahead at higher sales. See [Teachable vs Podia vs Payhip vs Gumroad](teachable-vs-podia-vs-payhip-vs-gumroad-courses) for worked examples, and the [Teachable fee calculator](teachable-fee-calculator) and [Payhip fee calculator](payhip-fee-calculator) to run your own numbers.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Podia take per sale?","acceptedAnswer":{"@type":"Answer","text":"On the Mover plan Podia keeps 5% of each sale. On Shaker and Earthquaker Podia takes no transaction fee. Your Stripe or PayPal account also charges processing on every plan, usually 2.9% + 30 cents."}},
{"@type":"Question","name":"Is Podia Mover or Shaker cheaper?","acceptedAnswer":{"@type":"Answer","text":"Mover is cheaper while your sales are small. Shaker costs $42 a month more on yearly billing and removes the 5% fee, so it becomes cheaper once you sell more than $840 a month ($1,000 a month on monthly billing)."}},
{"@type":"Question","name":"Can I use PayPal on Podia Mover?","acceptedAnswer":{"@type":"Answer","text":"No. PayPal is only supported on Shaker and Earthquaker. On Mover you accept payments through Stripe."}},
{"@type":"Question","name":"How much does a $100 course on Podia earn me?","acceptedAnswer":{"@type":"Answer","text":"With the standard 2.9% + 30 cents processing rate, you keep $91.80 per sale on Mover and $96.80 per sale on Shaker or Earthquaker, before the monthly plan cost."}},
{"@type":"Question","name":"Is Podia cheaper than Teachable, Payhip or Gumroad?","acceptedAnswer":{"@type":"Answer","text":"It depends on how much you sell. Podia Mover's 5% fee is lower than Teachable Starter's 7.5%, but its plan costs more. Flat plans with no transaction fee come out ahead at higher sales."}}
]}
</script>

## Related tools and guides

- [Teachable vs Podia vs Payhip vs Gumroad: where to sell an online course](teachable-vs-podia-vs-payhip-vs-gumroad-courses): plan prices and the real monthly cost at $500 and $3,000 in sales
- [Teachable fee calculator (2026)](teachable-fee-calculator): the 7.5% Starter fee vs Builder and Growth
- [Kajabi fee calculator (2026)](kajabi-fee-calculator): no transaction fee, but $179 to $499 plans and 2.7% to 2.9% + 30¢ card rates
- [Payhip fee calculator (2026)](payhip-fee-calculator): Payhip's 5%, 2% or 0% fee on Free, Plus and Pro
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Podia Mover's 5% plus processing. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Podia, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
