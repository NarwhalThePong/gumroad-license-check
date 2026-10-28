---
layout: page
title: "Sellfy fee calculator (2026): 0% transaction fee, plan cost, sales caps and Stripe or PayPal fees"
description: "Free Sellfy fee calculator. Enter your price and monthly sales to see which Sellfy plan your yearly sales need (Starter, Business or Premium), the plan cost per sale, the Stripe or PayPal processing fee, the 2% overage fee above a plan's cap, what you keep per month, and the price you need to keep a set amount."
---

Sellfy takes **0% per sale**. Instead you pay a flat plan price, and each plan has a **yearly sales cap**: Starter **$29/month** ($22/month billed yearly) up to $10k a year, Business **$79/month** ($59 yearly) up to $50k, Premium **$159/month** ($119 yearly) up to $200k. Payments go straight into your own **Stripe or PayPal** account, so their processing fee (about **2.9% + 30¢**) comes off every sale. If you go over your plan's cap and don't upgrade, Sellfy says it may charge a **2% overage fee** on the sales above the cap. Enter your numbers below to see the real cost. Everything runs in your browser and nothing is sent anywhere.

<div id="sy" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="sy-price" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="sy-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan<br><select id="sy-plan"><option value="auto" selected>Cheapest plan that fits my sales</option><option value="starter">Starter (up to $10k/yr)</option><option value="business">Business (up to $50k/yr)</option><option value="premium">Premium (up to $200k/yr)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Billing<br><select id="sy-bill"><option value="monthly" selected>Monthly</option><option value="yearly">Yearly (save 25%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processor<br><select id="sy-proc"><option value="stripe" selected>Stripe card (2.9% + $0.30)</option><option value="paypal">PayPal Checkout (3.49% + $0.49)</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="sy-intl" type="checkbox"> Buyer outside the US (PayPal adds +1.5%)</label></p>
  <p id="sy-warn" style="margin:0 0 8px;color:#a00"></p>
  <p id="sy-planline" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Price the buyer pays</td><td style="text-align:right" id="sy-o-price">$0.00</td></tr>
    <tr><td>Sellfy transaction fee</td><td style="text-align:right" id="sy-o-sellfy">$0.00</td></tr>
    <tr><td>Payment processor fee (<span id="sy-o-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="sy-o-proc">$0.00</td></tr>
    <tr><td>Plan cost spread over your sales</td><td style="text-align:right" id="sy-o-plan">$0.00</td></tr>
    <tr><td>Total cost per sale</td><td style="text-align:right"><strong id="sy-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per sale</td><td style="text-align:right"><strong id="sy-o-net">$0.00</strong></td></tr>
    <tr><td>Cost as a share of your price</td><td style="text-align:right" id="sy-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales</td><td style="text-align:right" id="sy-m-gross">$0.00</td></tr>
    <tr><td>Sellfy plan</td><td style="text-align:right" id="sy-m-plan">$0.00</td></tr>
    <tr><td>Payment processor fees</td><td style="text-align:right" id="sy-m-proc">$0.00</td></tr>
    <tr><td>Overage fee (2% above the plan cap, averaged per month)</td><td style="text-align:right" id="sy-m-over">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="sy-m-net">$0.00</strong></td></tr>
    <tr><td>All costs as a share of sales</td><td style="text-align:right" id="sy-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount per sale</h3>
  <p style="margin:0 0 8px"><label>I want to keep (USD)<br><input id="sy-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sy-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Sellfy fee math. Plan prices, caps and the 2% overage fee from sellfy.com/pricing (pricing.md last updated 2026-08-05) and docs.sellfy.com "How much does Sellfy cost?" (updated Oct 19, 2026), checked Oct 28, 2026. Processing rates are typical US Stripe card / PayPal Checkout rates. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = {
    "starter":  { name: "Starter",  monthly: 29,  yearly: 22,  cap: 10000 },
    "business": { name: "Business", monthly: 79,  yearly: 59,  cap: 50000 },
    "premium":  { name: "Premium",  monthly: 159, yearly: 119, cap: 200000 }
  };
  var ORDER = ["starter", "business", "premium"];
  var OVERAGE_PCT = 2;
  var PROCESSORS = {
    "stripe": { name: "Stripe card", pct: 2.9, fixed: 0.30, intlPct: 0 },
    "paypal": { name: "PayPal Checkout", pct: 3.49, fixed: 0.49, intlPct: 1.5 }
  };
  var MAX_PRICE = 1000000, MAX_SALES = 1000000;
  function r2(n) { return Math.round(n * 100) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function billing(o) { o = o || {}; return o.billing === "yearly" ? "yearly" : "monthly"; }
  function proc(o) { o = o || {}; return PROCESSORS[o.processor] ? o.processor : "stripe"; }
  function procPct(o) { var pr = PROCESSORS[proc(o)]; return pr.pct + ((o && o.intl) ? pr.intlPct : 0); }
  function procFixed(o) { return PROCESSORS[proc(o)].fixed; }
  // Cheapest plan whose yearly cap covers the yearly sales; Premium if above every cap (Sellfy asks >$200k sellers to contact them).
  function planFor(annual) { for (var i = 0; i < ORDER.length; i++) if (annual <= PLANS[ORDER[i]].cap) return ORDER[i]; return "premium"; }
  function plan(o, annual) { o = o || {}; return PLANS[o.plan] ? o.plan : planFor(annual || 0); }
  function planMonthly(key, o) { return PLANS[key][billing(o)]; }
  function perSaleProc(p, o) { p = price(p); return p > 0 ? r2(p * procPct(o) / 100 + procFixed(o)) : 0; }
  function monthly(p, n, o) {
    o = o || {}; p = price(p); var q = sales(n);
    var gross = r2(p * q), annual = gross * 12;
    var key = plan(o, annual), pl = PLANS[key];
    var planCost = planMonthly(key, o);
    var procFees = r2(perSaleProc(p, o) * q);
    var overAnnual = Math.max(0, annual - pl.cap);
    var overage = r2(overAnnual * OVERAGE_PCT / 100 / 12);
    var costs = r2(planCost + procFees + overage);
    return { price: p, sales: q, gross: gross, annual: r2(annual), plan: key, planName: pl.name, cap: pl.cap, overCap: overAnnual > 0,
      aboveAll: annual > PLANS.premium.cap, planCost: planCost, procFees: procFees, overage: overage, costs: costs,
      net: r2(gross - costs), effective: gross > 0 ? costs / gross : null };
  }
  function perSale(p, n, o) {
    var m = monthly(p, n, o), proc1 = perSaleProc(p, o);
    var share = m.sales > 0 ? r2((m.planCost + m.overage) / m.sales) : 0;
    var fee = m.price > 0 ? r2(proc1 + share) : 0;
    return { price: m.price, sellfyFee: 0, procFee: proc1, planShare: share, fee: fee, net: r2(m.price - fee), effective: m.price > 0 ? fee / m.price : null, plan: m.plan };
  }
  // Lowest price (to the cent) that keeps at least `target` per sale after processing and the plan cost spread over n sales (plan held fixed at the given options).
  function priceFor(target, n, o) {
    o = o || {}; var k = price(target), q = sales(n); if (!(k > 0)) return null;
    var key = PLANS[o.plan] ? o.plan : null;
    var f = procPct(o) / 100; if (f >= 1) return null;
    function netAt(p) {
      var pk = key || planFor(p * q * 12), pl = PLANS[pk];
      var share = q > 0 ? (planMonthly(pk, o) + Math.max(0, p * q * 12 - pl.cap) * OVERAGE_PCT / 100 / 12) / q : 0;
      return r2(p - perSaleProc(p, o) - r2(share));
    }
    var p = Math.ceil(((k + procFixed(o)) / (1 - f)) * 100 - 1e-6) / 100, guard = 0;
    while (netAt(p) < k && guard++ < 2000000) p = r2(p + 0.01 + Math.max(0, (k - netAt(p)) * 0.5));
    while (p > 0.01 && netAt(r2(p - 0.01)) >= k) p = r2(p - 0.01);
    return netAt(p) >= k ? p : null;
  }
  // Sellfy plan cost as an equivalent per-sale fee rate at a given monthly sales total (for comparing with % platforms).
  function equivalentPct(monthlySales, key, o) { var s = clean(monthlySales, MAX_PRICE * MAX_SALES); return s > 0 ? planMonthly(key, o) / s * 100 : null; }
  var api = { CHECKED: CHECKED, PLANS: PLANS, ORDER: ORDER, OVERAGE_PCT: OVERAGE_PCT, PROCESSORS: PROCESSORS, MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES,
    price: price, sales: sales, billing: billing, proc: proc, procPct: procPct, procFixed: procFixed, planFor: planFor, plan: plan, planMonthly: planMonthly,
    perSaleProc: perSaleProc, monthly: monthly, perSale: perSale, priceFor: priceFor, equivalentPct: equivalentPct };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.SellfyFees = api;
})(this);
(function () {
  var F = window.SellfyFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function procLabel(o) { var pr = F.PROCESSORS[F.proc(o)], pct = F.procPct(o); return (Math.round(pct * 100) / 100) + "% + " + money(pr.fixed); }
  function update() {
    var rawP = $("sy-price").value, rawN = $("sy-qty").value;
    var o = { plan: $("sy-plan").value, billing: $("sy-bill").value, processor: $("sy-proc").value, intl: $("sy-intl").checked };
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Sales capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawP) < 0 || Number(rawN) < 0) w.push("Negative numbers are treated as 0.");
    if (F.proc(o) === "stripe" && o.intl) w.push("The international surcharge shown applies to PayPal; Stripe's cross-border fees vary by card.");
    var m = F.monthly(rawP, rawN, o), s = F.perSale(rawP, rawN, o);
    if (m.aboveAll) w.push("Over $200k a year: Sellfy asks high-volume sellers to contact them for a custom offer, so the 2% overage shown is only a placeholder.");
    else if (m.overCap) w.push("Your yearly sales (" + money(m.annual) + ") are above the " + m.planName + " cap of " + money(m.cap) + ". Sellfy expects you to upgrade; if you don't, it may charge 2% on the sales above the cap.");
    set("sy-warn", w.join(" "));
    set("sy-planline", "Plan: " + m.planName + " at " + money(m.planCost) + "/month (" + F.billing(o) + " billing), yearly sales " + money(m.annual) + " of a " + money(m.cap) + " cap.");
    set("sy-o-price", money(s.price)); set("sy-o-sellfy", money(0));
    set("sy-o-procrate", procLabel(o)); set("sy-o-proc", money(s.procFee));
    set("sy-o-plan", m.sales > 0 ? money(s.planShare) : "n/a");
    set("sy-o-fee", money(s.fee)); set("sy-o-net", money(s.net)); set("sy-o-eff", pctS(s.effective));
    set("sy-m-gross", money(m.gross)); set("sy-m-plan", money(m.planCost)); set("sy-m-proc", money(m.procFees));
    set("sy-m-over", money(m.overage)); set("sy-m-net", money(m.net)); set("sy-m-eff", pctS(m.effective));
    var need = F.priceFor($("sy-target").value, rawN, o);
    set("sy-need", need == null ? "Enter how much you want to keep per sale and your sales per month." : "Charge " + money(need) + " to keep at least " + money(F.price($("sy-target").value)) + " per sale at " + F.sales(rawN).toLocaleString("en-US") + " sales a month, after processing and the Sellfy plan cost.");
  }
  ["sy-price", "sy-qty", "sy-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["sy-plan", "sy-bill", "sy-proc", "sy-intl"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Sellfy plans and fees (checked Oct 28, 2026)

| Plan | Monthly billing | Yearly billing (per month) | Yearly sales cap | Sellfy transaction fee |
|---|---|---|---|---|
| Starter | $29 | $22 ($264/year) | $10,000 | 0% |
| Business | $79 | $59 ($708/year) | $50,000 | 0% |
| Premium | $159 | $119 ($1,428/year) | $200,000 | 0% |

Every plan has a 14-day free trial (checkout is switched off during the trial, so you can't sell until you upgrade) and a 30-day money-back guarantee. Above $200,000 a year Sellfy asks you to contact them. If you pass your plan's cap and don't upgrade, Sellfy says it "may start to charge a 2% overage fee" on the sales above the limit.

On top of the plan, your **payment processor** takes its normal cut, because Sellfy pays you instantly into your own Stripe or PayPal account and never holds a balance:

| Processor | Typical US fee |
|---|---|
| Stripe (card, Apple Pay, Google Pay) | 2.9% + $0.30 |
| PayPal Checkout | 3.49% + $0.49 (US), +1.5% for international buyers |

Sellfy's own help page quotes PayPal at "2.9% + $0.30 in the US" and "3.4% + $0.30 on average worldwide"; PayPal's current US price list for PayPal Checkout is 3.49% + $0.49, which is what this calculator uses. Your account may have a different rate, so pick the one that matches it.

Sources: [Sellfy pricing](https://sellfy.com/pricing/) and [How much does Sellfy cost?](https://docs.sellfy.com/article/211-how-much-does-sellfy-cost) (updated Oct 19, 2026), [How to receive payments from customers](https://docs.sellfy.com/article/42-what-are-the-payment-options-available), all checked Oct 28, 2026. Rates change, so check the pricing pages before you rely on a number.

## How the numbers are worked out

```
yearly sales        = price x sales per month x 12
plan                = cheapest plan whose cap covers your yearly sales (or the one you pick)
processing fee      = price x processor rate + fixed    (e.g. 2.9% + $0.30)
overage fee         = 2% x (yearly sales - plan cap) / 12, only if you're over the cap
you keep per month  = sales - plan price - processing fees - overage fee
plan cost per sale  = (plan price + overage fee) / sales per month
```

At $20 x 50 sales a month ($1,000/month, $12,000/year) you are over Starter's $10k cap, so the cheapest plan that fits is **Business at $79/month**. Stripe takes $0.88 a sale ($44 a month), so you keep $1,000 - $79 - $44 = **$877**, a 12.3% total cost. Billed yearly, Business is $59/month and you keep $897 (10.3%). Staying on Starter would cost $29 plus a 2% overage on the $2,000 above the cap (about $3.33/month), keeping about $923.67, but Sellfy expects you to upgrade.

**When is Sellfy cheaper than a % fee platform?** Starter at $29/month equals a 5% per-sale fee at $580 of monthly sales ($440 on yearly billing). Below that, a free plan that takes 5% (Payhip Free, Ko-fi shop) keeps more; above it, Sellfy's flat price wins until you hit the cap. Because the caps are yearly, a launch month or a bundle sale can push you into the next plan.

## FAQ

### Does Sellfy take a cut of each sale?

No. Sellfy charges 0% transaction fees on every plan. You pay a flat monthly or yearly plan price, and Stripe or PayPal take their normal processing fee (about 2.9% + 30¢) from each sale.

### What happens if I go over Sellfy's yearly sales limit?

Sellfy notifies you and expects you to move to the next plan. If you don't upgrade, it says it may charge a 2% overage fee on the revenue above your plan's limit. Starter covers up to $10,000 a year, Business $50,000 and Premium $200,000.

### Is there a free Sellfy plan?

No. There's a 14-day free trial, but checkout is turned off until you upgrade, so you can't make sales on the trial. The cheapest plan is Starter at $29/month, or $22/month billed yearly.

### Is Sellfy cheaper than Gumroad or Payhip?

It depends on your volume. Gumroad takes 10% + 50¢ per direct sale plus processing, and Payhip's free plan takes 5% plus processing, with no monthly fee. Sellfy's Starter price matches a 5% fee at about $580 a month in sales ($440 on yearly billing), so Sellfy wins above that until you reach the next cap. Compare your own numbers in the [Seller fee comparison calculator](seller-fee-comparison-calculator).

### Does Sellfy collect sales tax or VAT for me?

No. Sellfy isn't a merchant of record. It has VAT and tax settings so you can add tax at checkout, but you're responsible for collecting and filing it. Gumroad, Lemon Squeezy, Paddle and Polar collect and pay it for you.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"Does Sellfy take a cut of each sale?","acceptedAnswer":{"@type":"Answer","text":"No. Sellfy charges 0% transaction fees on every plan. You pay a flat monthly or yearly plan price, and Stripe or PayPal take their normal processing fee (about 2.9% + 30 cents) from each sale."}},
{"@type":"Question","name":"What happens if I go over Sellfy's yearly sales limit?","acceptedAnswer":{"@type":"Answer","text":"Sellfy notifies you and expects you to move to the next plan. If you don't upgrade, it says it may charge a 2% overage fee on the revenue above your plan's limit. Starter covers up to $10,000 a year, Business $50,000 and Premium $200,000."}},
{"@type":"Question","name":"Is there a free Sellfy plan?","acceptedAnswer":{"@type":"Answer","text":"No. There's a 14-day free trial, but checkout is turned off until you upgrade, so you can't make sales on the trial. The cheapest plan is Starter at $29/month, or $22/month billed yearly."}},
{"@type":"Question","name":"Is Sellfy cheaper than Gumroad or Payhip?","acceptedAnswer":{"@type":"Answer","text":"It depends on your volume. Gumroad takes 10% + 50 cents per direct sale plus processing, and Payhip's free plan takes 5% plus processing, with no monthly fee. Sellfy's Starter price matches a 5% fee at about $580 a month in sales ($440 on yearly billing), so Sellfy wins above that until you reach the next cap."}},
{"@type":"Question","name":"Does Sellfy collect sales tax or VAT for me?","acceptedAnswer":{"@type":"Answer","text":"No. Sellfy isn't a merchant of record. It has VAT and tax settings so you can add tax at checkout, but you're responsible for collecting and filing it. Gumroad, Lemon Squeezy, Paddle and Polar collect and pay it for you."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [Gumroad alternatives: Payhip vs Sellfy vs SendOwl (2026)](gumroad-alternatives-payhip-sellfy-sendowl)
- [Payhip fee calculator (2026)](payhip-fee-calculator) and [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): the processing fee that comes off every Sellfy sale
- [When do you get paid? Payout timing on Gumroad, Payhip, Etsy, Lemon Squeezy and Sellfy](when-do-you-get-paid-gumroad-payhip-etsy-lemon-squeezy-sellfy)
- [Who collects sales tax and VAT on digital products?](who-collects-sales-tax-vat-gumroad-lemon-squeezy-payhip-sellfy-etsy)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Sellfy, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
