---
layout: page
title: "Substack fee calculator (2026): 10% Substack fee, Stripe processing and Billing fees on monthly and annual plans"
description: "Free Substack fee calculator. Enter your monthly and annual subscription prices and how many paid subscribers you have to see Substack's 10% fee, Stripe's 2.9% + 30¢ card fee, the 0.7% Billing fee, the international card add-on and what you keep per payment, per month and per year."
---

Publishing on Substack is free. Once you turn on paid subscriptions, **Substack keeps 10%** of each subscription payment, and Stripe charges **2.9% + 30¢ per card payment** (US cards) plus a **0.7% Billing fee** on recurring payments. Readers pay the price you set, so all of it comes out of your earnings. Enter your prices and subscriber counts below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="sk" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Monthly price (USD)<br><input id="sk-mprice" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Monthly paid subscribers<br><input id="sk-mqty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Annual price (USD)<br><input id="sk-aprice" type="number" min="0" step="0.01" value="80" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Annual paid subscribers<br><input id="sk-aqty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Card type<br><select id="sk-where"><option value="us" selected>US cards</option><option value="intl">International cards (+1.5%)</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="sk-billing" type="checkbox" checked> Include Stripe's 0.7% Billing fee for recurring payments</label></p>
  <p id="sk-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><th style="text-align:left"></th><th style="text-align:right">Monthly</th><th style="text-align:right">Annual</th></tr>
    <tr><td>Reader pays</td><td style="text-align:right" id="sk-m-price">$0.00</td><td style="text-align:right" id="sk-a-price">$0.00</td></tr>
    <tr><td>Substack fee (10%)</td><td style="text-align:right" id="sk-m-plat">$0.00</td><td style="text-align:right" id="sk-a-plat">$0.00</td></tr>
    <tr><td>Card processing (<span id="sk-procrate">2.9% + $0.30</span>)</td><td style="text-align:right" id="sk-m-proc">$0.00</td><td style="text-align:right" id="sk-a-proc">$0.00</td></tr>
    <tr><td>Stripe Billing (<span id="sk-billrate">0.7%</span>)</td><td style="text-align:right" id="sk-m-bill">$0.00</td><td style="text-align:right" id="sk-a-bill">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right"><strong id="sk-m-fee">$0.00</strong></td><td style="text-align:right"><strong id="sk-a-fee">$0.00</strong></td></tr>
    <tr><td>You keep per payment</td><td style="text-align:right"><strong id="sk-m-net">$0.00</strong></td><td style="text-align:right"><strong id="sk-a-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="sk-m-eff">n/a</td><td style="text-align:right" id="sk-a-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per year, all paid subscribers</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Readers pay in total</td><td style="text-align:right" id="sk-y-gross">$0.00</td></tr>
    <tr><td>Total fees</td><td style="text-align:right" id="sk-y-fee">$0.00</td></tr>
    <tr><td>You keep per year</td><td style="text-align:right"><strong id="sk-y-net">$0.00</strong></td></tr>
    <tr><td>You keep per month (average)</td><td style="text-align:right" id="sk-y-mo">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Monthly price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per monthly payment (USD)<br><input id="sk-target" type="number" min="0" step="0.01" value="5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sk-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Substack fee math. Rates from support.substack.com "How much does Substack cost?" (updated Sep 29, 2026) and "How do I set up a paid publication?", checked Oct 28, 2026. International card add-on is Stripe's standard US pricing. USD only. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLAT_PCT = 10, PROC_PCT = 2.9, PROC_FIXED = 0.30, INTL_PCT = 1.5, BILL_PCT = 0.7, MIN_MONTHLY = 5, MIN_ANNUAL = 30;
  var MAX_PRICE = 1000000, MAX_SUBS = 10000000;
  function r2(n) { return Math.round(n * 100 + 1e-7) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function subs(v) { return Math.floor(clean(v, MAX_SUBS)); }
  function procPct(o) { o = o || {}; return PROC_PCT + (o.where === "intl" ? INTL_PCT : 0); }
  function billPct(o) { o = o || {}; return o.billing === false ? 0 : BILL_PCT; }
  function perPayment(p, o) {
    p = price(p);
    var platFee = p > 0 ? r2(p * PLAT_PCT / 100) : 0;
    var procFee = p > 0 ? r2(p * procPct(o) / 100 + PROC_FIXED) : 0;
    var billFee = p > 0 ? r2(p * billPct(o) / 100) : 0;
    var fee = r2(platFee + procFee + billFee);
    return { price: p, platFee: platFee, procPct: procPct(o), procFee: procFee, billPct: billPct(o), billFee: billFee, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function yearly(mp, mn, ap, an, o) {
    var m = perPayment(mp, o), a = perPayment(ap, o), qm = subs(mn), qa = subs(an);
    var gross = r2(m.price * 12 * qm + a.price * qa), fee = r2(m.fee * 12 * qm + a.fee * qa);
    return { monthlySubs: qm, annualSubs: qa, gross: gross, fee: fee, net: r2(gross - fee), perMonth: r2((gross - fee) / 12) };
  }
  function priceFor(target, o) {
    var k = price(target); if (!(k > 0)) return null;
    var g = 1 - (PLAT_PCT + procPct(o) + billPct(o)) / 100; if (g <= 0) return null;
    var p = Math.max(0.01, Math.ceil(((k + PROC_FIXED) / g) * 100 - 1e-6) / 100);
    while (p > 0.01 && perPayment(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perPayment(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, PLAT_PCT: PLAT_PCT, PROC_PCT: PROC_PCT, PROC_FIXED: PROC_FIXED, INTL_PCT: INTL_PCT, BILL_PCT: BILL_PCT, MIN_MONTHLY: MIN_MONTHLY, MIN_ANNUAL: MIN_ANNUAL,
    MAX_PRICE: MAX_PRICE, MAX_SUBS: MAX_SUBS, price: price, subs: subs, procPct: procPct, billPct: billPct, perPayment: perPayment, yearly: yearly, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.SubstackFees = api;
})(this);
(function () {
  var F = window.SubstackFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var mp = $("sk-mprice").value, mn = $("sk-mqty").value, ap = $("sk-aprice").value, an = $("sk-aqty").value;
    var o = { where: $("sk-where").value, billing: $("sk-billing").checked };
    var w = [];
    if (Number(mp) > F.MAX_PRICE || Number(ap) > F.MAX_PRICE) w.push("Prices capped at " + money(F.MAX_PRICE) + ".");
    if (Number(mn) > F.MAX_SUBS || Number(an) > F.MAX_SUBS) w.push("Subscribers capped at " + F.MAX_SUBS.toLocaleString("en-US") + ".");
    if (Number(mp) < 0 || Number(ap) < 0 || Number(mn) < 0 || Number(an) < 0) w.push("Negative numbers are treated as 0.");
    if (F.price(mp) > 0 && F.price(mp) < F.MIN_MONTHLY) w.push("Substack's minimum monthly price is $5.");
    if (F.price(ap) > 0 && F.price(ap) < F.MIN_ANNUAL) w.push("Substack's minimum annual price is $30.");
    set("sk-warn", w.join(" "));
    var m = F.perPayment(mp, o), a = F.perPayment(ap, o), y = F.yearly(mp, mn, ap, an, o);
    set("sk-procrate", (Math.round(m.procPct * 10) / 10) + "% + " + money(F.PROC_FIXED)); set("sk-billrate", m.billPct + "%");
    [["m", m], ["a", a]].forEach(function (x) { var k = x[0], s = x[1];
      set("sk-" + k + "-price", money(s.price)); set("sk-" + k + "-plat", money(s.platFee)); set("sk-" + k + "-proc", money(s.procFee));
      set("sk-" + k + "-bill", money(s.billFee)); set("sk-" + k + "-fee", money(s.fee)); set("sk-" + k + "-net", money(s.net)); set("sk-" + k + "-eff", pctS(s.effective)); });
    set("sk-y-gross", money(y.gross)); set("sk-y-fee", money(y.fee)); set("sk-y-net", money(y.net)); set("sk-y-mo", money(y.perMonth));
    var need = F.priceFor($("sk-target").value, o);
    set("sk-need", need == null ? "Enter how much you want to keep per monthly payment." : "Charge " + money(need) + " a month to keep at least " + money(F.price($("sk-target").value)) + " per payment" + (need < F.MIN_MONTHLY ? " (Substack's minimum is $5)." : "."));
  }
  ["sk-mprice", "sk-mqty", "sk-aprice", "sk-aqty", "sk-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["sk-where", "sk-billing"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Substack fees (checked Oct 28, 2026)

| Fee | Amount | Applies to |
|---|---|---|
| Substack fee | 10% | Every paid subscription payment (monthly, annual, founding member) |
| Stripe card processing | 2.9% + $0.30 | Every card payment, US cards |
| International cards | +1.5% | Stripe's standard add-on for cards issued outside the US |
| Stripe Billing | 0.7% | Recurring subscription payments |
| Custom domain | $50 once | Optional |
| Publishing | $0 | Free and unpaid newsletters |

Sources: Substack's [How much does Substack cost?](https://support.substack.com/hc/en-us/articles/360037607131-How-much-does-Substack-cost) (updated September 29, 2026) and [How do I set up a paid publication?](https://support.substack.com/hc/en-us/articles/360037459952-How-do-I-set-up-a-paid-publication), checked Oct 28, 2026, plus [Stripe's pricing page](https://stripe.com/pricing) for the international card add-on. Local payment methods such as SEPA Direct Debit, iDEAL and Bancontact have their own Stripe rates, and currency conversion can add 1% to 2%, so treat these numbers as estimates and check your Stripe dashboard. The minimum price is $5 a month or $30 a year for US-dollar Stripe accounts.

## How the numbers are worked out

```
Substack fee     = price x 10%
card processing  = price x (2.9% + 1.5% if international card) + $0.30
Stripe Billing   = price x 0.7%
you keep         = price - Substack fee - card processing - Stripe Billing
```

An $8 monthly subscription paid with a US card costs $0.80 (10%) + $0.53 (2.9% + $0.30) + $0.06 (0.7%) = $1.39, so you keep $6.61, an effective 17.4%. An $80 annual subscription costs $8.00 + $2.62 + $0.56 = $11.18, so you keep $68.82, an effective 14.0%.

**Annual plans save on the fixed 30¢.** Twelve monthly payments pay the 30¢ card fee twelve times, an annual plan pays it once. At $8 a month that's $3.60 a year in fixed fees versus $0.30, which is part of why an annual discount often costs you less than it looks.

## FAQ

### How much does Substack take?

Substack takes 10% of each paid subscription payment and nothing on free newsletters. Stripe then charges 2.9% + $0.30 per US card payment and 0.7% for recurring billing. On an $8 monthly subscription you keep about $6.61.

### Do readers pay Substack's fees?

No. Readers pay the price you set on the web, and Substack and Stripe fees come out of your earnings. Readers may pay more when you add sales tax or VAT, or when they subscribe in the Substack iOS app and you raise in-app prices to cover Apple's fees.

### Is Substack's fee charged on annual and founding member plans?

Yes. The 10% fee and Stripe's fees apply to every subscription payment, whether monthly, annual or founding member. Annual plans pay the fixed 30¢ card fee once a year instead of twelve times.

### What is the minimum price on Substack?

The minimum is $5 a month and $30 a year for US-dollar Stripe accounts. Founding member plans can be any amount above the annual price.

### Is Substack cheaper than Patreon, Ko-fi or Buy Me a Coffee?

Substack's 10% matches Patreon's standard plan for new creators. Buy Me a Coffee takes 5%, and Ko-fi takes 0% on one-off tips and 5% on memberships unless you pay for Ko-fi Gold. Compare your own numbers in the [Patreon fee calculator](patreon-fee-calculator), the [Ko-fi fee calculator](ko-fi-fee-calculator) and the [Buy Me a Coffee fee calculator](buy-me-a-coffee-fee-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Substack take?","acceptedAnswer":{"@type":"Answer","text":"Substack takes 10% of each paid subscription payment and nothing on free newsletters. Stripe then charges 2.9% + $0.30 per US card payment and 0.7% for recurring billing. On an $8 monthly subscription you keep about $6.61."}},
{"@type":"Question","name":"Do readers pay Substack's fees?","acceptedAnswer":{"@type":"Answer","text":"No. Readers pay the price you set on the web, and Substack and Stripe fees come out of your earnings. Readers may pay more when you add sales tax or VAT, or when they subscribe in the Substack iOS app and you raise in-app prices to cover Apple's fees."}},
{"@type":"Question","name":"Is Substack's fee charged on annual and founding member plans?","acceptedAnswer":{"@type":"Answer","text":"Yes. The 10% fee and Stripe's fees apply to every subscription payment, whether monthly, annual or founding member. Annual plans pay the fixed 30 cent card fee once a year instead of twelve times."}},
{"@type":"Question","name":"What is the minimum price on Substack?","acceptedAnswer":{"@type":"Answer","text":"The minimum is $5 a month and $30 a year for US-dollar Stripe accounts. Founding member plans can be any amount above the annual price."}},
{"@type":"Question","name":"Is Substack cheaper than Patreon, Ko-fi or Buy Me a Coffee?","acceptedAnswer":{"@type":"Answer","text":"Substack's 10% matches Patreon's standard plan for new creators. Buy Me a Coffee takes 5%, and Ko-fi takes 0% on one-off tips and 5% on memberships unless you pay for Ko-fi Gold. Compare your own numbers in the Patreon, Ko-fi and Buy Me a Coffee fee calculators."}}
]}
</script>

## Related tools and guides

- [Patreon fee calculator (2026)](patreon-fee-calculator): the 10% standard plan, legacy plans, processing and payout fees
- [Memberful fee calculator (2026)](memberful-fee-calculator): $49 a month + 4.9% instead of 10%, and the revenue where it pays off
- [Buy Me a Coffee fee calculator (2026)](buy-me-a-coffee-fee-calculator): the 5% platform fee, Stripe processing and the payout fee
- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee and whether Ko-fi Gold pays off
- [Kit vs beehiiv vs MailerLite](kit-vs-beehiiv-vs-mailerlite): newsletter platforms compared
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Substack or Stripe. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
