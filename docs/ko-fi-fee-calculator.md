---
layout: page
title: "Ko-fi fee calculator (2026): 0% on tips, 5% service fee, Ko-fi Gold and Stripe or PayPal processing"
description: "Free Ko-fi fee calculator. Enter your price, payment type, plan and payment processor to see the 0% or 5% Ko-fi service fee, the Stripe or PayPal processing fee on top, what you keep per sale and per month, whether Ko-fi Gold pays off, and the price you need to keep a set amount."
---

Ko-fi charges **0% on one-time tips and 5% on everything else** (shop sales, commissions, memberships, monthly tips) on the free plan. Turn on Standard mode and the 5% service fee applies to tips too. Ko-fi never holds your money: payments go straight into your own **Stripe or PayPal** account, so their usual processing fee (about **2.9% + 30¢** on Stripe, **3.49% + 49¢** on PayPal) comes off on top. **Ko-fi Gold** removes the service fee for a flat **$12/month**. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="kf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="kf-price" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="kf-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment type<br><select id="kf-type"><option value="tip">One-time tip</option><option value="goal">Crowdfunding (Goal)</option><option value="monthlytip">Monthly tip</option><option value="membership">Membership tier</option><option value="commission">Commission</option><option value="shop" selected>Shop sale</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan<br><select id="kf-plan"><option value="free" selected>Ko-fi Free (0% tips, 5% rest)</option><option value="standard">Standard (5% on all)</option><option value="gold">Ko-fi Gold ($12/mo, 0%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processor<br><select id="kf-proc"><option value="stripe" selected>Stripe card (2.9% + $0.30)</option><option value="paypal">PayPal Checkout (3.49% + $0.49)</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="kf-intl" type="checkbox"> Buyer outside the US (PayPal adds +1.5%)</label></p>
  <p id="kf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Price the supporter pays</td><td style="text-align:right" id="kf-o-price">$0.00</td></tr>
    <tr><td>Ko-fi service fee (<span id="kf-o-svcrate">5%</span>)</td><td style="text-align:right" id="kf-o-svc">$0.00</td></tr>
    <tr><td>Payment processor fee (<span id="kf-o-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="kf-o-proc">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right"><strong id="kf-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per sale</td><td style="text-align:right"><strong id="kf-o-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="kf-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales</td><td style="text-align:right" id="kf-m-gross">$0.00</td></tr>
    <tr><td>Ko-fi service fees</td><td style="text-align:right" id="kf-m-svc">$0.00</td></tr>
    <tr><td>Payment processor fees</td><td style="text-align:right" id="kf-m-proc">$0.00</td></tr>
    <tr><td>Ko-fi Gold subscription</td><td style="text-align:right" id="kf-m-gold">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="kf-m-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount per sale</h3>
  <p style="margin:0 0 8px"><label>I want to keep (USD)<br><input id="kf-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="kf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Ko-fi fee math. Rates from help.ko-fi.com ("Does Ko-fi take a fee?", "What is Ko-fi Gold?") and ko-fi.com/gold, checked Oct 28, 2026. Processing rates are typical Stripe/PayPal US card rates (Ko-fi says "around 3% + $0.30"). */
(function (root) {
  var CHECKED = "2026-10-28";
  var SVC_PCT = 5, GOLD_MONTHLY = 12;
  var PROCESSORS = {
    "stripe": { name: "Stripe card", pct: 2.9, fixed: 0.30, intlPct: 0 },
    "paypal": { name: "PayPal Checkout", pct: 3.49, fixed: 0.49, intlPct: 1.5 }
  };
  // On Ko-fi Free these payment types have no service fee; everything else is 5%. Standard charges 5% on all; Gold charges 0% on all.
  var FEE_FREE_ON_FREE = { "tip": true, "goal": true };
  var TYPES = { "tip": "One-time tip", "goal": "Crowdfunding (Goal)", "monthlytip": "Monthly tip", "membership": "Membership tier", "commission": "Commission", "shop": "Shop sale" };
  var MAX_PRICE = 1000000, MAX_SALES = 1000000;
  function r2(n) { return Math.round(n * 100) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function plan(o) { o = o || {}; return o.plan === "standard" || o.plan === "gold" ? o.plan : "free"; }
  function type(o) { o = o || {}; return TYPES[o.type] ? o.type : "shop"; }
  function proc(o) { o = o || {}; return PROCESSORS[o.processor] ? o.processor : "stripe"; }
  // Ko-fi service fee percent for a plan + payment type.
  function svcPct(o) {
    var pl = plan(o); if (pl === "gold") return 0; if (pl === "standard") return SVC_PCT;
    return FEE_FREE_ON_FREE[type(o)] ? 0 : SVC_PCT;
  }
  // Processor percent (with the PayPal international surcharge when the buyer is outside the US).
  function procPct(o) { var pr = PROCESSORS[proc(o)]; return pr.pct + ((o && o.intl) ? pr.intlPct : 0); }
  function procFixed(o) { return PROCESSORS[proc(o)].fixed; }
  function perSale(p, o) {
    o = o || {}; p = price(p);
    var svc = svcPct(o), pp = procPct(o), fx = procFixed(o);
    var svcFee = p > 0 ? r2(p * svc / 100) : 0;
    var procFee = p > 0 ? r2(p * pp / 100 + fx) : 0;
    var fee = r2(svcFee + procFee);
    return { price: p, svcPct: svc, procPct: pp, procFixed: fx, svcFee: svcFee, procFee: procFee, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function monthly(p, n, o) {
    o = o || {}; var s = perSale(p, o), q = sales(n);
    var gross = r2(s.price * q), svcFees = r2(s.svcFee * q), procFees = r2(s.procFee * q);
    var gold = plan(o) === "gold" ? GOLD_MONTHLY : 0;
    var net = r2(gross - svcFees - procFees - gold);
    return { sales: q, gross: gross, svcFees: svcFees, procFees: procFees, gold: gold, fees: r2(svcFees + procFees), net: net, effective: gross > 0 ? (svcFees + procFees + gold) / gross : null };
  }
  // Lowest price (to the cent) that keeps at least `target` per sale after Ko-fi and processing fees (ignores the Gold monthly fee, which is not per sale).
  function priceFor(target, o) {
    o = o || {}; var k = price(target); if (!(k > 0)) return null;
    var f = (svcPct(o) + procPct(o)) / 100; if (f >= 1) return null;
    var p = Math.ceil(((k + procFixed(o)) / (1 - f)) * 100 - 1e-6) / 100;
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    while (perSale(p, o).net < k) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, SVC_PCT: SVC_PCT, GOLD_MONTHLY: GOLD_MONTHLY, PROCESSORS: PROCESSORS, FEE_FREE_ON_FREE: FEE_FREE_ON_FREE, TYPES: TYPES,
    MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES, price: price, sales: sales, plan: plan, type: type, proc: proc,
    svcPct: svcPct, procPct: procPct, procFixed: procFixed, perSale: perSale, monthly: monthly, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.KofiFees = api;
})(this);
(function () {
  var F = window.KofiFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function procLabel(o) { var pr = F.PROCESSORS[F.proc(o)], pct = F.procPct(o); return (Math.round(pct * 100) / 100) + "% + " + money(pr.fixed); }
  function update() {
    var rawP = $("kf-price").value, rawN = $("kf-qty").value;
    var o = { type: $("kf-type").value, plan: $("kf-plan").value, processor: $("kf-proc").value, intl: $("kf-intl").checked };
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Sales capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawP) < 0 || Number(rawN) < 0) w.push("Negative numbers are treated as 0.");
    if (F.proc(o) === "stripe" && o.intl) w.push("The international surcharge shown applies to PayPal; Stripe's cross-border fees vary by card.");
    set("kf-warn", w.join(" "));
    var s = F.perSale(rawP, o), m = F.monthly(rawP, rawN, o);
    set("kf-o-price", money(s.price));
    set("kf-o-svcrate", (Math.round(s.svcPct * 10) / 10) + "%"); set("kf-o-svc", money(s.svcFee));
    set("kf-o-procrate", procLabel(o)); set("kf-o-proc", money(s.procFee));
    set("kf-o-fee", money(s.fee)); set("kf-o-net", money(s.net)); set("kf-o-eff", pctS(s.effective));
    set("kf-m-gross", money(m.gross)); set("kf-m-svc", money(m.svcFees)); set("kf-m-proc", money(m.procFees)); set("kf-m-gold", money(m.gold)); set("kf-m-net", money(m.net));
    var need = F.priceFor($("kf-target").value, o);
    set("kf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("kf-target").value)) + " per sale with these options" + (F.plan(o) === "gold" ? " (before the $12/mo Ko-fi Gold fee)." : "."));
  }
  ["kf-price", "kf-qty", "kf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["kf-type", "kf-plan", "kf-proc", "kf-intl"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Ko-fi fees (checked Oct 28, 2026)

| Payment type | Ko-fi Free | Standard | Ko-fi Gold |
|---|---|---|---|
| One-time tip | 0% | 5% | 0% |
| Crowdfunding (Goal) | 0% | 5% | 0% |
| Monthly tip | 5% | 5% | 0% |
| Membership tier | 5% | 5% | 0% |
| Commission | 5% | 5% | 0% |
| Shop sale | 5% | 5% | 0% |
| Monthly cost | $0 | $0 | $12/month |

On top of the Ko-fi service fee, your **payment processor** takes its normal cut, because Ko-fi pays you directly into your own Stripe or PayPal account and never holds a balance:

| Processor | Typical US fee |
|---|---|
| Stripe (card) | 2.9% + $0.30 |
| PayPal Checkout | 3.49% + $0.49 (US), +1.5% for international cards |

Sources: [Does Ko-fi take a fee?](https://help.ko-fi.com/hc/en-us/articles/360002506494-Does-Ko-fi-take-a-fee), [What is Ko-fi Gold?](https://help.ko-fi.com/hc/en-us/articles/360005506873-What-is-Ko-fi-Gold) and [Ko-fi Gold](https://ko-fi.com/gold), all checked Oct 28, 2026. Ko-fi labels its 5% service fee the "Application Fee" on Stripe and the "Partner Fee" on PayPal. Stripe and PayPal fees vary by account, country and currency; Ko-fi gives "around 3% + $0.30" as a rule of thumb. Rates change, so check the pricing pages before you rely on a number.

## How the numbers are worked out

```
Ko-fi service fee   = price x service rate        (0% or 5%, see the table)
processing fee      = price x processor rate + fixed   (e.g. 2.9% + $0.30)
you keep per sale   = price - Ko-fi service fee - processing fee
Ko-fi Gold          = flat $12/month, taken off your monthly total, not per sale
```

A $20 shop sale on Ko-fi Free paid by Stripe card costs $1.00 (5% service fee) + $0.88 (2.9% + $0.30) = $1.88, so you keep $18.12, an effective 9.4%. The same $20 as a one-time tip on the free plan has no service fee, so you only lose the $0.88 processing and keep $19.12. Because Ko-fi's 5% has no fixed part, the fee is a steady share of the price; the processor's fixed 30¢ or 49¢ is what weighs most on cheap items.

**Does Ko-fi Gold pay off?** Gold costs $12/month and removes the 5% service fee. It pays for itself once your fee-paying sales (shop, commissions, memberships, monthly tips) pass about **$240 a month** ($12 ÷ 5%). Below that, the free plan keeps more; above it, Gold does. One-time tips are already fee-free, so they don't count toward the break-even.

## FAQ

### How much does Ko-fi take per sale?

Nothing on one-time tips on the free plan. For shop sales, commissions, memberships and monthly tips, Ko-fi takes a 5% service fee. On top of that your payment processor (Stripe or PayPal) takes its normal fee, around 2.9%–3.5% plus a fixed 30¢–49¢, because you're paid directly into your own account.

### Does Ko-fi charge Stripe and PayPal fees on top of the 5%?

Yes. Ko-fi never holds your money; supporters pay straight into your connected Stripe or PayPal account, so those processors take their usual transaction fee in addition to Ko-fi's 0% or 5% service fee.

### Is Ko-fi really free?

The free plan has no monthly cost and takes 0% on one-time tips, so you can run a tip page paying only the payment processor's fee. Shop sales, commissions, memberships and monthly tips carry the 5% service fee unless you subscribe to Ko-fi Gold.

### What does Ko-fi Gold cost and what does it remove?

Ko-fi Gold is $12/month (monthly only for new creators) and removes the 5% service fee on all payment types. It's worth it once your fee-paying sales pass about $240 a month. Memberships started before you switched to Gold keep the 5% fee.

### Is Ko-fi cheaper than Gumroad or Lemon Squeezy?

Often, for tips and low-fee shop sales, because Ko-fi's service fee is 0–5% with no fixed part. But Ko-fi isn't a merchant of record, so you handle your own sales tax and VAT, while Gumroad, Lemon Squeezy, Paddle and Polar collect it for you. Compare what you keep at your own price in the [Seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Ko-fi take per sale?","acceptedAnswer":{"@type":"Answer","text":"Nothing on one-time tips on the free plan. For shop sales, commissions, memberships and monthly tips, Ko-fi takes a 5% service fee. On top of that your payment processor (Stripe or PayPal) takes its normal fee, around 2.9%-3.5% plus a fixed 30c-49c, because you're paid directly into your own account."}},
{"@type":"Question","name":"Does Ko-fi charge Stripe and PayPal fees on top of the 5%?","acceptedAnswer":{"@type":"Answer","text":"Yes. Ko-fi never holds your money; supporters pay straight into your connected Stripe or PayPal account, so those processors take their usual transaction fee in addition to Ko-fi's 0% or 5% service fee."}},
{"@type":"Question","name":"Is Ko-fi really free?","acceptedAnswer":{"@type":"Answer","text":"The free plan has no monthly cost and takes 0% on one-time tips, so you can run a tip page paying only the payment processor's fee. Shop sales, commissions, memberships and monthly tips carry the 5% service fee unless you subscribe to Ko-fi Gold."}},
{"@type":"Question","name":"What does Ko-fi Gold cost and what does it remove?","acceptedAnswer":{"@type":"Answer","text":"Ko-fi Gold is $12/month (monthly only for new creators) and removes the 5% service fee on all payment types. It's worth it once your fee-paying sales pass about $240 a month. Memberships started before you switched to Gold keep the 5% fee."}},
{"@type":"Question","name":"Is Ko-fi cheaper than Gumroad or Lemon Squeezy?","acceptedAnswer":{"@type":"Answer","text":"Often, for tips and low-fee shop sales, because Ko-fi's service fee is 0-5% with no fixed part. But Ko-fi isn't a merchant of record, so you handle your own sales tax and VAT, while Gumroad, Lemon Squeezy, Paddle and Polar collect it for you. Compare what you keep at your own price in the Seller fee comparison calculator."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Ko-fi next to Gumroad, Payhip, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [Buy Me a Coffee fee calculator (2026)](buy-me-a-coffee-fee-calculator): Buy Me a Coffee's flat 5% plus Stripe fees, to compare with Ko-fi
- [Payhip fee calculator (2026)](payhip-fee-calculator) and [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): the processing fee that comes off every Ko-fi sale
- [When do you get paid? Payout timing on Gumroad, Payhip, Etsy, Lemon Squeezy and Sellfy](when-do-you-get-paid-gumroad-payhip-etsy-lemon-squeezy-sellfy)
- [Who collects sales tax and VAT on digital products?](who-collects-sales-tax-vat-gumroad-lemon-squeezy-payhip-sellfy-etsy)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Ko-fi, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
