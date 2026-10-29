---
layout: page
title: "Shopify fee calculator (2026): Shopify Payments card rates on Basic, Grow and Advanced"
description: "Free Shopify fee calculator. See the Shopify Payments fee on each order for online standard and premium cards, in-person and keyed-in cards, international cards and third-party payment providers on Basic, Grow or Advanced, add the monthly plan cost, compare plans and get the price to charge to keep a set amount."
---

Shopify takes a card processing fee from every order paid through **Shopify Payments**, and how much depends on your plan. On **Basic** ($39 a month, or $29 a month billed yearly) an online order paid with a standard card costs **2.9% + 30¢**, a premium card such as American Express or a business card costs **3.5% + 30¢**, and a card tapped, dipped or swiped in person costs **2.6% + 10¢**. **Grow** ($105 a month, or $79 billed yearly) lowers those to 2.7% + 30¢, 3.3% + 30¢ and 2.5% + 10¢, and **Advanced** ($399 a month, or $299 billed yearly) to 2.5% + 30¢, 3.1% + 30¢ and 2.4% + 10¢. Online cards issued outside the US cost an extra **1%**, and if you use a payment provider other than Shopify Payments, Shopify adds a **2%, 1% or 0.6%** transaction fee on top of that provider's own fee. Enter your numbers below to see what you keep on each plan. Everything runs in your browser and nothing is sent anywhere.

<div id="sh" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 220px;margin:0 0 8px"><label>Shopify plan<br><select id="sh-plan" style="width:100%;max-width:320px"><option value="basic">Basic</option><option value="grow">Grow</option><option value="advanced">Advanced</option></select></label></p>
    <p style="flex:1 1 220px;margin:0 0 8px"><label>Plan billing<br><select id="sh-bill" style="width:100%;max-width:320px"><option value="yearly">Billed yearly ($29 / $79 / $299 a month)</option><option value="monthly">Billed monthly ($39 / $105 / $399 a month)</option></select></label></p>
    <p style="flex:1 1 280px;margin:0 0 8px"><label>How the customer pays<br><select id="sh-type" style="width:100%;max-width:340px"><option value="online">Online, standard card</option><option value="premium">Online, premium card (American Express or business card)</option><option value="inperson">In person, card tapped, dipped or swiped</option><option value="manual">In person, card number typed in</option><option value="thirdparty">Third-party payment provider (not Shopify Payments)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Order total (USD)<br><input id="sh-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Orders per month<br><input id="sh-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="sh-intl" type="checkbox"> Online card issued outside the US (+1%)</label></p>
  </div>
  <div id="sh-gw" style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your provider's own fee (%)<br><input id="sh-gwp" type="number" min="0" step="0.01" value="2.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plus a fixed fee per order (USD)<br><input id="sh-gwf" type="number" min="0" step="0.01" value="0.30" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="sh-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per order</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customer pays</td><td style="text-align:right" id="sh-s-price">$0.00</td></tr>
    <tr><td>Shopify rate for this order</td><td style="text-align:right" id="sh-s-rate"></td></tr>
    <tr><td>Shopify fee</td><td style="text-align:right" id="sh-s-shop">$0.00</td></tr>
    <tr><td>Third-party provider's fee</td><td style="text-align:right" id="sh-s-prov">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="sh-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the order</td><td style="text-align:right" id="sh-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customers pay</td><td style="text-align:right" id="sh-m-gross">$0.00</td></tr>
    <tr><td>Payment fees</td><td style="text-align:right" id="sh-m-fees">$0.00</td></tr>
    <tr><td>Shopify plan</td><td style="text-align:right" id="sh-m-plan">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="sh-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what customers paid</td><td style="text-align:right" id="sh-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="sh-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Same month on each plan</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Basic: you keep</td><td style="text-align:right" id="sh-c-basic">$0.00</td></tr>
    <tr><td>Grow: you keep</td><td style="text-align:right" id="sh-c-grow">$0.00</td></tr>
    <tr><td>Advanced: you keep</td><td style="text-align:right" id="sh-c-advanced">$0.00</td></tr>
  </table>
  <p id="sh-c-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per order after fees (USD)<br><input id="sh-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sh-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Shopify Payments US fee math (shopify.com/pricing, help.shopify.com/en/manual/payments/shopify-payments/transactions/credit-card-rates, shopify.com/blog/credit-card-processing-fees, checked Oct 29, 2026). Plans: Basic $39/mo monthly or $29/mo billed yearly, Grow $105 or $79, Advanced $399 or $299. Online standard cards 2.9%/2.7%/2.5% + 30c; online premium cards (domestic business/corporate cards and all domestic American Express) 3.5%/3.3%/3.1% + 30c; extra 1% on online cards issued outside the US; in-person cards 2.6%/2.5%/2.4% + 10c; in-person manual entry 3.5% + 10c; third-party payment provider transaction fee 2%/1%/0.6% on top of that provider's own fee. Shopify doesn't publish a rounding rule, so each fee rounds to the nearest cent here. */
(function (root) {
  var CHECKED = "2026-10-29";
  /* bp = percentage in hundredths of a percent, fixed in cents, so the math stays in whole cents. */
  var PLANS = {
    basic: { label: "Basic", monthly: 39, yearly: 29, online: 290, premium: 350, inperson: 260, manual: 350, thirdparty: 200 },
    grow: { label: "Grow", monthly: 105, yearly: 79, online: 270, premium: 330, inperson: 250, manual: 350, thirdparty: 100 },
    advanced: { label: "Advanced", monthly: 399, yearly: 299, online: 250, premium: 310, inperson: 240, manual: 350, thirdparty: 60 }
  };
  var TYPES = {
    online: { label: "Online, standard card", fixed: 30, intl: true },
    premium: { label: "Online, premium card (American Express or business card)", fixed: 30, intl: true },
    inperson: { label: "In person, card tapped, dipped or swiped", fixed: 10, intl: false },
    manual: { label: "In person, card number typed in", fixed: 10, intl: false },
    thirdparty: { label: "Third-party payment provider (not Shopify Payments)", fixed: 0, intl: false }
  };
  var INTL_BP = 100, GW_BP = 290, GW_FIXED = 30, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function plan(p) { return PLANS[p] ? p : "basic"; }
  function type(t) { return TYPES[t] ? t : "online"; }
  function billing(b) { return b === "monthly" ? "monthly" : "yearly"; }
  function cents(x) { return Math.round(x * 100); }
  /* round c*bp/10000 to the nearest cent (half a cent rounds up) */
  function pctCents(c, bp) { return Math.floor((c * bp + 5000) / 10000); }
  /* third-party provider's own fee: percent (e.g. 2.9) and fixed in dollars (e.g. 0.30); blank means 2.9% + 30c */
  function gateway(g) {
    g = g || {}; var p = g.pct === undefined || g.pct === "" ? GW_BP / 100 : Number(g.pct), f = g.fixed === undefined || g.fixed === "" ? GW_FIXED / 100 : Number(g.fixed);
    if (!isFinite(p) || p < 0) p = 0; if (!isFinite(f) || f < 0) f = 0;
    return { bp: Math.round(Math.min(p, 20) * 100), fixed: Math.round(Math.min(f, 10) * 100) };
  }
  function rate(p, t, intl) { t = type(t); return PLANS[plan(p)][t] + (intl && TYPES[t].intl ? INTL_BP : 0); }
  /* returns { shopify, provider } in cents */
  function feeParts(c, p, t, intl, g) {
    if (c <= 0) return { shopify: 0, provider: 0 };
    t = type(t);
    if (t === "thirdparty") { var G = gateway(g); return { shopify: pctCents(c, PLANS[plan(p)].thirdparty), provider: pctCents(c, G.bp) + G.fixed }; }
    return { shopify: pctCents(c, rate(p, t, intl)) + TYPES[t].fixed, provider: 0 };
  }
  function calc(x, p, t, intl, g) {
    var price = amt(x); if (price <= 0) return { price: 0, shopify: 0, provider: 0, fee: 0, net: 0, effective: null };
    var c = cents(price), f = feeParts(c, p, t, intl, g), tot = f.shopify + f.provider;
    return { price: price, shopify: f.shopify / 100, provider: f.provider / 100, fee: tot / 100, net: (c - tot) / 100, effective: tot / c };
  }
  function planFee(p, b) { return PLANS[plan(p)][billing(b)]; }
  /* Monthly: orders x fee, then the plan's monthly cost (monthly billing or the yearly plan's per-month price). */
  function perMonth(x, p, t, q, b, intl, g) {
    var s = calc(x, p, t, intl, g), n = count(q), gross = r2(s.price * n), fees = r2(s.fee * n), sub = planFee(p, b);
    var net = r2(gross - fees - sub);
    return { sale: s, count: n, gross: gross, fees: fees, shopifyFees: r2(s.shopify * n), providerFees: r2(s.provider * n), plan: sub, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  function compare(x, t, q, b, intl, g) { var o = {}; for (var p in PLANS) o[p] = perMonth(x, p, t, q, b, intl, g); return o; }
  /* Smallest price (to the cent) that keeps at least T per order. What you keep never drops as the price rises (with a third-party provider, two separately rounded fees can dip it by a cent), so a binary search finds it. */
  function priceFor(T, p, t, intl, g) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), lo = 1, hi = MAX_AMT * 100;
    function keep(c) { var f = feeParts(c, p, t, intl, g); return c - f.shopify - f.provider; }
    if (keep(hi) < tc) return null;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (keep(mid) >= tc) hi = mid; else lo = mid + 1; }
    for (var c2 = lo - 1, best = lo; c2 > 0 && c2 >= lo - 200; c2--) if (keep(c2) >= tc) best = c2;
    return best / 100;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, TYPES: TYPES, INTL_BP: INTL_BP, GW_BP: GW_BP, GW_FIXED: GW_FIXED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, plan: plan, type: type, billing: billing, gateway: gateway, rate: rate, calc: calc, planFee: planFee, perMonth: perMonth, compare: compare, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.ShopifyFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.ShopifyFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function rateText(p, t, intl) {
    var ty = B.type(t);
    if (ty === "thirdparty") return (B.PLANS[B.plan(p)].thirdparty / 100) + "% + your provider's fee";
    return (B.rate(p, ty, intl) / 100) + "% + " + B.TYPES[ty].fixed + "\u00a2";
  }
  function update() {
    var pl = $("sh-plan").value, bl = $("sh-bill").value, ty = $("sh-type").value, x = $("sh-price").value, q = $("sh-qty").value, intl = $("sh-intl").checked, w = [];
    var g = { pct: $("sh-gwp").value, fixed: $("sh-gwf").value }, tp = B.type(ty) === "thirdparty";
    $("sh-gw").style.display = tp ? "flex" : "none";
    var m = B.perMonth(x, pl, ty, q, bl, intl, g), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (intl && !B.TYPES[B.type(ty)].intl) w.push("The extra 1% for international cards applies to online card orders through Shopify Payments.");
    $("sh-warn").textContent = w.join(" ");
    set("sh-s-price", money(c.price)); set("sh-s-rate", rateText(pl, ty, intl)); set("sh-s-shop", money(c.shopify)); set("sh-s-prov", money(c.provider)); set("sh-s-net", money(c.net)); set("sh-s-eff", pctS(c.effective));
    set("sh-m-gross", money(m.gross)); set("sh-m-fees", money(m.fees)); set("sh-m-plan", money(m.plan)); set("sh-m-net", money(m.net)); set("sh-m-eff", pctS(m.effective)); set("sh-y-net", money(m.year));
    var cmp = B.compare(x, ty, q, bl, intl, g), best = "basic";
    ["basic", "grow", "advanced"].forEach(function (p) { set("sh-c-" + p, money(cmp[p].net) + " (after " + money(cmp[p].plan) + " plan)"); if (cmp[p].net > cmp[best].net + 1e-9) best = p; });
    set("sh-c-best", m.gross > 0 ? "At these numbers, " + B.PLANS[best].label + " leaves you the most each month." : "");
    var T = $("sh-target").value, need = B.priceFor(T, pl, ty, intl, g);
    set("sh-need", B.amt(T) <= 0 ? "Enter how much you want to keep per order." : need == null ? "No price works for that amount." : "Charge " + money(need) + " to keep " + money(B.amt(T)) + " per order after fees (" + B.PLANS[B.plan(pl)].label + ", " + B.TYPES[B.type(ty)].label.toLowerCase() + ").");
  }
  ["sh-plan", "sh-bill", "sh-type", "sh-price", "sh-qty", "sh-intl", "sh-gwp", "sh-gwf", "sh-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Shopify Payments fees in the US (checked Oct 29, 2026)

| | Basic | Grow | Advanced |
|---|---|---|---|
| Plan, billed monthly | $39/mo | $105/mo | $399/mo |
| Plan, billed yearly | $29/mo | $79/mo | $299/mo |
| Online, standard card | 2.9% + 30¢ | 2.7% + 30¢ | 2.5% + 30¢ |
| Online, premium card (American Express, business and corporate cards) | 3.5% + 30¢ | 3.3% + 30¢ | 3.1% + 30¢ |
| Online card issued outside the US | extra 1% | extra 1% | extra 1% |
| In person, card tapped, dipped or swiped | 2.6% + 10¢ | 2.5% + 10¢ | 2.4% + 10¢ |
| In person, card number typed in | 3.5% + 10¢ | 3.5% + 10¢ | 3.5% + 10¢ |
| Third-party payment provider (Shopify's fee, on top of the provider's) | 2% | 1% | 0.6% |

Rates are from Shopify's own pages: [Shopify pricing](https://www.shopify.com/pricing), [Shopify Payments rates in the United States by card type](https://help.shopify.com/en/manual/payments/shopify-payments/transactions/credit-card-rates) and [Credit card processing fees](https://www.shopify.com/blog/credit-card-processing-fees). Shopify counts domestic consumer Visa, Mastercard, Discover and Diners Club cards as standard, and domestic business, corporate and commercial cards plus every domestic American Express card as premium. Shopify Plus starts at $2,300 a month with its own rates (2.25% + 30¢ for standard online cards) and isn't modeled here, and neither are POS Pro ($89 a month per location), PayPal wallet payments, local payment methods, currency conversion or the $1-a-month introductory offer. Shopify doesn't publish how it rounds a fraction of a cent, so the calculator rounds each fee to the nearest cent and may be a cent off on some amounts. Fees can change, so check Settings > Payments in your Shopify admin for your exact rates.

## How the numbers are worked out

```
Shopify Payments fee = order x rate + fixed fee
third-party provider = order x Shopify transaction fee (2%, 1% or 0.6%)
                       + order x provider's rate + provider's fixed fee
you keep             = order - fees
per month            = you keep x orders - plan price
```

A $100 online order paid with a standard card costs $3.20 on Basic, so you keep $96.80. The same order costs $3.00 on Grow and $2.80 on Advanced. A premium card costs $3.80 on Basic, and the same card tapped in person costs $2.70, so you keep $97.30. Shopify's own worked example shows the same $3.20, $3.80 and $2.70 on a $100 Basic payment. A card issued outside the US adds $1.00 on a $100 online order. On Basic with a third-party provider charging 2.9% + 30¢, a $100 order costs $5.20: $2.00 to Shopify and $3.20 to the provider. At 100 online orders of $50 a month with yearly billing, Basic keeps $4,796.00, or $57,552.00 a year. Grow keeps $4,756.00 and Advanced keeps $4,546.00. With monthly billing, Basic keeps $4,786.00, Grow $4,730.00 and Advanced $4,446.00. To keep $100 per online standard-card order, charge $103.30 on Basic or $103.08 on Grow. In person on Basic, charge $102.77.

## When does Grow or Advanced pay off?

Grow takes 0.2 percentage points less than Basic on standard online cards and costs $66 more a month on monthly billing, so it pays for itself at about $33,000 a month of online card sales. On yearly billing the gap is $50, so the break-even drops to about $25,000 a month. Advanced saves another 0.2 points over Grow, which takes about $147,000 a month (monthly billing) or about $110,000 a month (yearly billing) to cover its higher price. Against Basic, Advanced saves 0.4 points and breaks even at about $90,000 a month on monthly billing or about $67,500 a month on yearly billing. If you use a third-party payment provider, Grow cuts Shopify's transaction fee from 2% to 1%, which pays off at about $6,600 a month of sales on monthly billing or $5,000 on yearly billing. The bigger plans also add staff accounts and reporting, which may matter more to you than the fee math.

## FAQ

### How much does Shopify charge per transaction in 2026?

With Shopify Payments on the Basic plan, 2.9% + 30¢ for an online order paid with a standard card, 3.5% + 30¢ for a premium card such as American Express, and 2.6% + 10¢ for a card tapped, dipped or swiped in person. Grow charges 2.7% + 30¢ online and Advanced 2.5% + 30¢. Online cards issued outside the US cost an extra 1%.

### How much is the Shopify fee on a $100 order?

On Basic, $3.20 for an online standard-card order (you keep $96.80), $3.80 for a premium card and $2.70 for an in-person card. On Grow the online standard-card fee is $3.00, and on Advanced it's $2.80.

### Does Shopify charge a fee if I don't use Shopify Payments?

Yes. If you take payments through a third-party provider, Shopify adds a transaction fee of 2% on Basic, 1% on Grow or 0.6% on Advanced, and your provider still charges its own fee. On Basic with a provider charging 2.9% + 30¢, a $100 order costs $5.20 in total.

### What is a premium card on Shopify?

Shopify bills domestic business, corporate and commercial cards, such as Visa Business, and every domestic American Express card at its premium rate: 3.5% + 30¢ on Basic, 3.3% + 30¢ on Grow and 3.1% + 30¢ on Advanced for online orders.

### What should I charge on Shopify to keep a set amount?

Add the fixed fee to what you want to keep and divide by one minus the rate. Keeping $100 from an online standard-card order on Basic means (100 + 0.30) / 0.971, which gives $103.30. The calculator above finds the exact cent for any plan and payment type.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Shopify charge per transaction in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "With Shopify Payments on the Basic plan, 2.9% + 30¢ for an online order paid with a standard card, 3.5% + 30¢ for a premium card such as American Express, and 2.6% + 10¢ for a card tapped, dipped or swiped in person. Grow charges 2.7% + 30¢ online and Advanced 2.5% + 30¢. Online cards issued outside the US cost an extra 1%."}},
{"@type": "Question", "name": "How much is the Shopify fee on a $100 order?", "acceptedAnswer": {"@type": "Answer", "text": "On Basic, $3.20 for an online standard-card order (you keep $96.80), $3.80 for a premium card and $2.70 for an in-person card. On Grow the online standard-card fee is $3.00, and on Advanced it's $2.80."}},
{"@type": "Question", "name": "Does Shopify charge a fee if I don't use Shopify Payments?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. If you take payments through a third-party provider, Shopify adds a transaction fee of 2% on Basic, 1% on Grow or 0.6% on Advanced, and your provider still charges its own fee. On Basic with a provider charging 2.9% + 30¢, a $100 order costs $5.20 in total."}},
{"@type": "Question", "name": "What is a premium card on Shopify?", "acceptedAnswer": {"@type": "Answer", "text": "Shopify bills domestic business, corporate and commercial cards, such as Visa Business, and every domestic American Express card at its premium rate: 3.5% + 30¢ on Basic, 3.3% + 30¢ on Grow and 3.1% + 30¢ on Advanced for online orders."}},
{"@type": "Question", "name": "What should I charge on Shopify to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Add the fixed fee to what you want to keep and divide by one minus the rate. Keeping $100 from an online standard-card order on Basic means (100 + 0.30) / 0.971, which gives $103.30. The calculator above finds the exact cent for any plan and payment type."}}
]}
</script>

## Related tools and guides

- [Square fee calculator (2026)](square-fee-calculator): Square Free, Plus and Premium card fees in person and online, plus Instant transfer costs
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's own goods-and-services and checkout fees, next to Stripe's card fees
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Etsy fee calculator (2026)](etsy-fee-calculator): Etsy's listing, transaction and payment processing fees on each sale
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales
- [Invoice late fee calculator](invoice-late-fee-calculator): work out a late fee on an unpaid invoice

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Shopify Inc. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
