---
layout: page
title: "Polar fee calculator (2026): Starter vs Pro, Growth and Scale, and what you keep"
description: "Free Polar.sh fee calculator. Enter your price, monthly sales, tax and plan to see Polar's 5% + 50¢ Starter fee or the lower Pro, Growth and Scale rates, the 1.5% international card fee, Stripe payout fees and what you keep each month, plus the sales level where a paid plan pays off."
---

Polar is a merchant of record, so it collects and remits sales tax and VAT for you and charges one fee per transaction. On the free **Starter** plan that fee is **5% + 50¢**. The paid plans swap part of it for a monthly fee: **Pro** is **$20 a month and 3.8% + 40¢**, **Growth** is **$100 a month and 3.6% + 35¢**, and **Scale** is **$400 a month and 3.4% + 30¢**. Cards issued outside the US add **1.5%**. The fee is worked out on the **total the buyer pays, tax included**. Payouts to your bank go through Stripe, which charges **$2 for each month you get paid out** plus **0.25% + 25¢ per payout**, and up to **1%** if the money is converted to another currency. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="pf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale, before tax (USD)<br><input id="pf-price" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="pf-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Polar plan<br><select id="pf-plan"><option value="starter" selected>Starter (free)</option><option value="pro">Pro ($20/mo)</option><option value="growth">Growth ($100/mo)</option><option value="scale">Scale ($400/mo)</option><option value="early">Early Member (orgs created before May 27, 2026)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax or VAT added at checkout (%)<br><input id="pf-tax" type="number" min="0" max="30" step="0.1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payouts per month<br><input id="pf-payouts" type="number" min="0" step="1" value="1" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Currency conversion on payout (%)<br><input id="pf-fx" type="number" min="0" max="1" step="0.05" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="pf-intl" type="checkbox"> Card issued outside the US (+1.5%)</label> &nbsp; <label><input id="pf-sub" type="checkbox"> Subscription payment (+0.5%, Early Member only)</label></p>
  <p id="pf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays, tax included</td><td style="text-align:right" id="pf-s-total">$0.00</td></tr>
    <tr><td>Tax Polar collects and remits</td><td style="text-align:right" id="pf-s-tax">$0.00</td></tr>
    <tr><td>Polar fee (<span id="pf-rate">5% + $0.50</span> of the total)</td><td style="text-align:right" id="pf-s-fee">$0.00</td></tr>
    <tr><td>You keep per sale, before payouts and the plan cost</td><td style="text-align:right"><strong id="pf-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="pf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue, before tax</td><td style="text-align:right" id="pf-m-gross">$0.00</td></tr>
    <tr><td>Polar fees</td><td style="text-align:right" id="pf-m-fees">$0.00</td></tr>
    <tr><td>Stripe payout fees</td><td style="text-align:right" id="pf-m-payout">$0.00</td></tr>
    <tr><td>Polar plan (<span id="pf-planname">Starter</span>)</td><td style="text-align:right" id="pf-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="pf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="pf-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Which plan is cheapest at these sales?</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Starter: fees + plan</td><td style="text-align:right" id="pf-c-starter">$0.00</td></tr>
    <tr><td>Pro: fees + plan</td><td style="text-align:right" id="pf-c-pro">$0.00</td></tr>
    <tr><td>Growth: fees + plan</td><td style="text-align:right" id="pf-c-growth">$0.00</td></tr>
    <tr><td>Scale: fees + plan</td><td style="text-align:right" id="pf-c-scale">$0.00</td></tr>
  </table>
  <p id="pf-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before payouts and the plan cost (USD)<br><input id="pf-target" type="number" min="0" step="0.01" value="35" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="pf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Polar fee math. Plans (Starter free 5% + 50c, Pro $20/mo 3.8% + 40c, Growth $100/mo 3.6% + 35c, Scale $400/mo 3.4% + 30c), the Early Member rate (4% + 40c, +0.5% on subscription payments), +1.5% for non-US cards, fees charged on the total transaction value including tax, and Stripe payout fees ($2 per month of active payouts, 0.25% + 25c per payout, 0.25% to 1% currency conversion) all from polar.sh/docs/merchant-of-record/fees, checked Oct 28, 2026. USD prices. Refunds, $15 disputes and future Stripe pass-through fees are not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    starter: { name: "Starter", monthly: 0, pct: 5, fixed: 0.50 },
    pro: { name: "Pro", monthly: 20, pct: 3.8, fixed: 0.40 },
    growth: { name: "Growth", monthly: 100, pct: 3.6, fixed: 0.35 },
    scale: { name: "Scale", monthly: 400, pct: 3.4, fixed: 0.30 },
    early: { name: "Early Member", monthly: 0, pct: 4, fixed: 0.40 }
  };
  var PUBLIC = ["starter", "pro", "growth", "scale"];
  var INTL = 1.5, SUB = 0.5, PAYOUT_MONTH = 2, PAYOUT_PCT = 0.25, PAYOUT_FIXED = 0.25, MAX_FX = 1, MAX_TAX = 30;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000, MAX_PAYOUTS = 31;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function payouts(v) { return Math.min(Math.floor(num(v)), MAX_PAYOUTS); }
  function tax(v) { return Math.min(num(v), MAX_TAX); }
  function fx(v) { return Math.min(num(v), MAX_FX); }
  function planKey(o) { return (o && o.plan) in PLANS ? o.plan : "starter"; }
  function rate(o) { o = o || {}; var k = planKey(o), pl = PLANS[k]; return { pct: pl.pct + (o.intl ? INTL : 0) + (o.sub && k === "early" ? SUB : 0), fixed: pl.fixed }; }
  function perSale(v, o) {
    o = o || {}; var p = price(v), rt = rate(o);
    if (p <= 0) return { price: 0, tax: 0, total: 0, fee: 0, net: 0, effective: null, pct: rt.pct, fixed: rt.fixed };
    var tx = r2(p * tax(o.tax) / 100), total = r2(p + tx), fee = r2(total * rt.pct / 100 + rt.fixed);
    return { price: p, tax: tx, total: total, fee: fee, net: r2(p - fee), effective: fee / p, pct: rt.pct, fixed: rt.fixed };
  }
  function planCost(o) { return PLANS[planKey(o)].monthly; }
  function payoutFees(amount, n, fxPct) { var a = num(amount), k = payouts(n); return a > 0 && k > 0 ? r2(PAYOUT_MONTH + a * (PAYOUT_PCT + fx(fxPct)) / 100 + PAYOUT_FIXED * k) : 0; }
  function perMonth(v, q, o) {
    o = o || {}; var s = perSale(v, o), n = qty(q), gross = r2(s.price * n), fees = r2(s.fee * n), pc = planCost(o);
    var po = payoutFees(gross - fees, o.payouts == null ? 1 : o.payouts, o.fx);
    return { gross: gross, fees: fees, payout: po, plan: pc, net: r2(gross - fees - po - pc), effective: gross > 0 ? (fees + po + pc) / gross : null };
  }
  function compare(v, q, o) {
    o = o || {}; var out = {}, best = null;
    PUBLIC.forEach(function (k) { var oo = {}; for (var j in o) oo[j] = o[j]; oo.plan = k; var m = perMonth(v, q, oo); out[k] = r2(m.fees + m.plan); if (best === null || out[k] < out[best]) best = k; });
    out.best = best; return out;
  }
  function breakEven(k, v, o) {
    o = o || {}; var a = {}, b = {}; for (var j in o) { a[j] = o[j]; b[j] = o[j]; } a.plan = "starter"; b.plan = k;
    var save = r2(perSale(v, a).fee - perSale(v, b).fee), p = price(v);
    if (save <= 0 || p <= 0) return null;
    var n = Math.ceil(PLANS[k].monthly / save - 1e-9); return { sales: n, revenue: r2(n * p) };
  }
  function priceFor(v, o) {
    o = o || {}; var k = price(v); if (k <= 0) return null;
    if (perSale(MAX_PRICE, o).net < k) return null;
    var lo = 1, hi = MAX_PRICE * 100;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, o).net >= k) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, PUBLIC: PUBLIC, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, MAX_PAYOUTS: MAX_PAYOUTS, price: price, qty: qty, payouts: payouts, rate: rate, perSale: perSale, planCost: planCost, payoutFees: payoutFees, perMonth: perMonth, compare: compare, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PolarFees = api;
})(this);
(function () {
  var F = window.PolarFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var p = $("pf-price").value, q = $("pf-qty").value;
    var o = { plan: $("pf-plan").value, tax: $("pf-tax").value, payouts: $("pf-payouts").value, fx: $("pf-fx").value, intl: $("pf-intl").checked, sub: $("pf-sub").checked };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(o.payouts) > F.MAX_PAYOUTS) w.push("Payouts capped at " + F.MAX_PAYOUTS + " a month.");
    if (Number(o.tax) > 30) w.push("Tax capped at 30%.");
    if (Number(o.fx) > 1) w.push("Currency conversion capped at 1%, the highest rate Polar lists.");
    if (Number(p) < 0 || Number(q) < 0 || Number(o.payouts) < 0 || Number(o.tax) < 0 || Number(o.fx) < 0) w.push("Negative numbers are treated as 0.");
    if (o.sub && o.plan !== "early") w.push("The 0.5% subscription fee only applies to Early Member organizations, so it is ignored on this plan.");
    set("pf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o), c = F.compare(p, q, o);
    set("pf-rate", (Math.round(s.pct * 100) / 100) + "% + $" + s.fixed.toFixed(2));
    set("pf-s-total", money(s.total)); set("pf-s-tax", money(s.tax)); set("pf-s-fee", money(s.fee)); set("pf-s-net", money(s.net)); set("pf-s-eff", pctS(s.effective));
    set("pf-planname", F.PLANS[o.plan].name + ", " + money(F.planCost(o)) + " a month");
    set("pf-m-gross", money(m.gross)); set("pf-m-fees", money(m.fees)); set("pf-m-payout", money(m.payout)); set("pf-m-plan", money(m.plan)); set("pf-m-net", money(m.net)); set("pf-m-eff", pctS(m.effective));
    F.PUBLIC.forEach(function (k) { set("pf-c-" + k, money(c[k])); });
    var be = ["pro", "growth", "scale"].map(function (k) { var b = F.breakEven(k, p, o); return b ? F.PLANS[k].name + " from " + b.sales.toLocaleString("en-US") + " sales (" + money(b.revenue) + ") a month" : null; }).filter(Boolean);
    set("pf-best", s.price > 0 ? "Cheapest at these sales: " + F.PLANS[c.best].name + " (" + money(c[c.best]) + " a month in fees and plan cost). At this price, each paid plan beats Starter at: " + be.join("; ") + "." : "");
    var need = F.priceFor($("pf-target").value, o);
    set("pf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " before tax to keep at least " + money(F.price($("pf-target").value)) + " per sale, before payouts and the plan cost.");
  }
  ["pf-price", "pf-qty", "pf-target", "pf-payouts", "pf-tax", "pf-fx"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["pf-plan", "pf-intl", "pf-sub"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Polar fees (checked Oct 28, 2026)

| Plan | Monthly fee | Per transaction | Pays off vs Starter at a $40 average order |
|---|---|---|---|
| Starter | Free | 5% + 50¢ | n/a |
| Pro | $20/mo | 3.8% + 40¢ | about $1,379/mo in sales |
| Growth | $100/mo | 3.6% + 35¢ | about $5,634/mo in sales |
| Scale | $400/mo | 3.4% + 30¢ | about $19,048/mo in sales |
| Early Member (orgs created before May 27, 2026) | Free | 4% + 40¢, +0.5% on subscription payments | n/a |

| Other fee | Rate |
|---|---|
| Card issued outside the US | +1.5% |
| Dispute or chargeback | $15 each, win or lose |
| Stripe payout, monthly | $2 for each month with a payout |
| Stripe payout, per payout | 0.25% + 25¢ |
| Currency conversion on payout | 0.25% in the EU, up to 1% elsewhere |

All rates come from Polar's [fees page](https://polar.sh/docs/merchant-of-record/fees), checked Oct 28, 2026. Polar publishes the break-even sales levels in the first table without saying what order size they assume; they match a $40 average order, which is why this calculator starts at $40. At a different price the break-even moves, because the fixed part of the fee matters more on small orders. Upgrading from Early Member to a paid plan retires the Early Member rate for good, and dropping back to Starter lands you on 5% + 50¢. Refunds don't return the original fee. Treat the numbers as estimates and check the fee breakdown in your Polar dashboard.

## How the numbers are worked out

```
total       = price + sales tax or VAT
polar fee   = total x (plan % + 1.5% if the card is non-US) + plan fixed fee
you keep    = price - polar fee            (Polar remits the tax)
payouts     = $2 + (takings this month) x (0.25% + conversion %) + 25¢ x payouts
per month   = you keep x sales - payouts - plan fee
```

Polar's own example is a $30 product sold to a buyer in Sweden with 25% VAT and a non-US card. The buyer pays $37.50, and on Starter the fee is $2.38 plus $0.56 for the international card, $2.94 in total, so you keep $27.06. On Pro it's $2.39, on Growth $2.26 and on Scale $2.14.

## FAQ

### How much does Polar charge per sale?

On the free Starter plan, 5% + 50¢ of the total the buyer pays, tax included, plus 1.5% if the card was issued outside the US. Pro, Growth and Scale lower that to 3.8% + 40¢, 3.6% + 35¢ and 3.4% + 30¢ for $20, $100 and $400 a month.

### Does Polar charge its fee on sales tax and VAT?

Yes. Polar's own example applies the fee to the full $37.50 a Swedish buyer pays for a $30 product with 25% VAT, so tax raises the fee even though the tax itself goes to the government.

### When is Polar Pro worth it?

Pro saves 1.2% plus 10¢ per sale, so it covers its $20 a month once you sell about $1,379 a month at a $40 average order. With cheaper products you get there sooner in sales count but need more sales overall, so try your own price above.

### What does it cost to get paid out from Polar?

Polar adds no payout fee, but Stripe charges $2 for each month you take a payout, plus 0.25% + 25¢ per payout, and 0.25% to 1% if your money is converted to another currency.

### Is Polar cheaper than Lemon Squeezy or Gumroad?

Polar's Starter fee of 5% + 50¢ is the same as Lemon Squeezy's base fee, and both handle sales tax as merchant of record. Gumroad charges 10% + 50¢ on direct sales, plus 2.9% + 30¢ for card processing. Compare them at your own numbers with the [Lemon Squeezy fee calculator](lemon-squeezy-fee-calculator) and the [seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Polar charge per sale?", "acceptedAnswer": {"@type": "Answer", "text": "On the free Starter plan, 5% + 50 cents of the total the buyer pays, tax included, plus 1.5% if the card was issued outside the US. Pro, Growth and Scale lower that to 3.8% + 40 cents, 3.6% + 35 cents and 3.4% + 30 cents for $20, $100 and $400 a month."}},
{"@type": "Question", "name": "Does Polar charge its fee on sales tax and VAT?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. Polar's own example applies the fee to the full $37.50 a Swedish buyer pays for a $30 product with 25% VAT, so tax raises the fee even though the tax itself goes to the government."}},
{"@type": "Question", "name": "When is Polar Pro worth it?", "acceptedAnswer": {"@type": "Answer", "text": "Pro saves 1.2% plus 10 cents per sale, so it covers its $20 a month once you sell about $1,379 a month at a $40 average order."}},
{"@type": "Question", "name": "What does it cost to get paid out from Polar?", "acceptedAnswer": {"@type": "Answer", "text": "Polar adds no payout fee, but Stripe charges $2 for each month you take a payout, plus 0.25% + 25 cents per payout, and 0.25% to 1% if your money is converted to another currency."}},
{"@type": "Question", "name": "Is Polar cheaper than Lemon Squeezy or Gumroad?", "acceptedAnswer": {"@type": "Answer", "text": "Polar's Starter fee of 5% + 50 cents is the same as Lemon Squeezy's base fee, and both handle sales tax as merchant of record. Gumroad charges 10% + 50 cents on direct sales, plus 2.9% + 30 cents for card processing."}}
]}
</script>

## Related tools and guides

- [Gumroad vs Lemon Squeezy vs Polar vs Paddle fees](gumroad-vs-lemon-squeezy-polar-paddle-fees): merchant-of-record fees side by side
- [Paddle fee calculator (2026)](paddle-fee-calculator): Paddle's flat 5% + 50¢ with no monthly plans
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): 5% + 50¢ and its add-ons
- [Gumroad fee calculator (2026)](gumroad-fee-calculator)
- [Whop fee calculator (2026)](whop-fee-calculator): the 2.7% + 30¢ card fee and the 3% app fee
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [Gumroad license key checker](gumroad-license-key-checker)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Polar's 5% + 50¢. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Polar or Stripe. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
