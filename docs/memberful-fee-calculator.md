---
layout: page
title: "Memberful fee calculator (2026): the $49 a month plan, 4.9% fee and Stripe costs, and what you keep"
description: "Free Memberful fee calculator. Enter your membership price, payments per month and share of international members to see Memberful's 4.9% transaction fee, Stripe's card fee, the $49 monthly plan, what you keep each month, the revenue where Memberful beats a 10% platform like Substack, and the price you need to keep a set amount."
---

Memberful runs paid memberships, newsletters, podcasts and downloads on your own site, and charges cards through your own Stripe account. Its Standard plan costs **$49 a month plus a 4.9% transaction fee** on every purchase and renewal, and **Stripe's card processing fee comes on top** (2.9% + 30¢ for US cards on Stripe's standard pricing, plus 1.5% for international cards and 1% when currency conversion is needed). Memberful is free in test mode and starts charging the $49 when you connect Stripe and go live. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="mf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per payment (USD)<br><input id="mf-price" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month (renewals + new sales)<br><input id="mf-qty" type="number" min="0" step="1" value="200" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments on international cards (%)<br><input id="mf-intl" type="number" min="0" max="100" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments needing currency conversion (%)<br><input id="mf-fx" type="number" min="0" max="100" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="mf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Memberful transaction fee (4.9%)</td><td style="text-align:right" id="mf-s-mem">$0.00</td></tr>
    <tr><td>Stripe card fee (2.9% + 30¢, plus add-ons)</td><td style="text-align:right" id="mf-s-stripe">$0.00</td></tr>
    <tr><td>You keep per payment, before the monthly plan</td><td style="text-align:right"><strong id="mf-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of your price</td><td style="text-align:right" id="mf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Revenue</td><td style="text-align:right" id="mf-m-gross">$0.00</td></tr>
    <tr><td>Memberful transaction fees</td><td style="text-align:right" id="mf-m-mem">$0.00</td></tr>
    <tr><td>Stripe card fees</td><td style="text-align:right" id="mf-m-stripe">$0.00</td></tr>
    <tr><td>Memberful Standard plan</td><td style="text-align:right" id="mf-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="mf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="mf-m-eff">n/a</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="mf-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Memberful vs a 10% platform such as Substack</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Substack's costs at the same numbers (10% + Stripe 2.9% + 30¢ + 0.7% Billing)</td><td style="text-align:right" id="mf-c-sub">$0.00</td></tr>
    <tr><td>Memberful saves you per month (negative means it costs more)</td><td style="text-align:right" id="mf-c-save">$0.00</td></tr>
  </table>
  <p id="mf-c-even" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per payment, before the monthly plan (USD)<br><input id="mf-target" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="mf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Memberful fee math. Standard plan $49/month + 4.9% transaction fee (memberful.com/pricing), fee applied on each purchase or renewal with Stripe processing on top (Memberful docs "Memberful payment processing"), $49 charged only once live (docs "Manage your account in test mode"), fee rises to 12.5% if the $49 payment fails and the account lapses (docs "Manage your account in live mode"), transaction fee not refunded on refunds (docs "Refund or suspend an order"). Stripe standard US pricing 2.9% + 30c, +1.5% international cards, +1% currency conversion (stripe.com/pricing). Substack comparison: 10% + 2.9% + 30c + 0.7% Billing (support.substack.com). Checked Oct 28, 2026. Whether the 4.9% is taken on collected sales tax is not stated by Memberful; tax is not modelled. Enterprise pricing, disputes and payout timing are not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLAN = 49, MEM_PCT = 4.9, ST_PCT = 2.9, ST_FIXED = 0.30, INTL = 1.5, FX = 1, SUB_PCT = 10, BILL_PCT = 0.7;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function share(v) { return Math.min(num(v), 100) / 100; }
  function stripePct(o) { o = o || {}; return ST_PCT + INTL * share(o.intl) + FX * share(o.fx); }
  function perSale(v, o) {
    var p = price(v);
    if (p <= 0) return { price: 0, mem: 0, stripe: 0, net: 0, effective: null };
    var mem = r2(p * MEM_PCT / 100), st = r2(p * stripePct(o) / 100 + ST_FIXED);
    return { price: p, mem: mem, stripe: st, net: r2(p - mem - st), effective: (mem + st) / p };
  }
  function substackFee(v, o) { var p = price(v); return p > 0 ? r2(p * (SUB_PCT + BILL_PCT + stripePct(o)) / 100 + ST_FIXED) : 0; }
  function perMonth(v, q, o) {
    var s = perSale(v, o), n = qty(q), gross = r2(s.price * n), mem = r2(s.mem * n), st = r2(s.stripe * n);
    var plan = PLAN, cost = r2(mem + st + plan), sub = r2(substackFee(v, o) * n);
    return { gross: gross, mem: mem, stripe: st, plan: plan, net: r2(gross - cost), year: r2((gross - cost) * 12), effective: gross > 0 ? cost / gross : null, substack: sub, save: r2(sub - cost) };
  }
  /* Monthly revenue above which $49 + 4.9% costs less than 10% + 0.7% Billing (Stripe's fee is the same on both). */
  function breakEven() { return r2(PLAN / ((SUB_PCT + BILL_PCT - MEM_PCT) / 100)); }
  function priceFor(v, o) {
    var k = price(v); if (k <= 0) return null;
    if (perSale(MAX_PRICE, o).net < k) return null;
    var lo = 1, hi = MAX_PRICE * 100;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, o).net >= k) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, PLAN: PLAN, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, share: share, perSale: perSale, substackFee: substackFee, perMonth: perMonth, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.MemberfulFees = api;
})(this);
(function () {
  var F = window.MemberfulFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var p = $("mf-price").value, q = $("mf-qty").value, o = { intl: $("mf-intl").value, fx: $("mf-fx").value };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Payments capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(o.intl) > 100 || Number(o.fx) > 100) w.push("Shares capped at 100%.");
    if (Number(p) < 0 || Number(q) < 0 || Number(o.intl) < 0 || Number(o.fx) < 0) w.push("Negative numbers are treated as 0.");
    set("mf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o);
    set("mf-s-mem", money(s.mem)); set("mf-s-stripe", money(s.stripe)); set("mf-s-net", money(s.net)); set("mf-s-eff", pctS(s.effective));
    set("mf-m-gross", money(m.gross)); set("mf-m-mem", money(m.mem)); set("mf-m-stripe", money(m.stripe)); set("mf-m-plan", money(m.plan)); set("mf-m-net", money(m.net)); set("mf-m-eff", pctS(m.effective)); set("mf-y-net", money(m.year));
    set("mf-c-sub", money(m.substack)); set("mf-c-save", money(m.save));
    set("mf-c-even", "Memberful's $49 plan costs less than Substack's 10% + 0.7% Billing fee once your revenue passes about " + money(F.breakEven()) + " a month.");
    var need = F.priceFor($("mf-target").value, o);
    set("mf-need", need == null ? "Enter how much you want to keep per payment." : "Charge " + money(need) + " to keep at least " + money(F.price($("mf-target").value)) + " per payment before the $49 plan.");
  }
  ["mf-price", "mf-qty", "mf-intl", "mf-fx", "mf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  update();
})();
</script>

## Memberful fees (checked Oct 28, 2026)

| Fee | Rate |
|---|---|
| Standard plan | $49 a month, charged once you go live (test mode is free) |
| Memberful transaction fee | 4.9% of each purchase and renewal |
| Stripe card processing (US standard pricing) | 2.9% + 30¢ per payment, paid to Stripe |
| International card | +1.5% (Stripe) |
| Currency conversion | +1% (Stripe) |
| If your $49 payment fails and the account lapses | Transaction fee rises to 12.5% until you reactivate |
| Refunds | Memberful keeps its transaction fee; Stripe keeps its processing fee |
| Enterprise | Custom pricing |
| Fee on collected sales tax | Not stated by Memberful, so not included here |

The plan price and 4.9% fee come from Memberful's [pricing page](https://memberful.com/pricing/), and the fee rules from its help docs on [payment processing](https://memberful.com/docs/overview/getting-started/payment-processing), [going live](https://memberful.com/docs/account-management/modes/manage-your-account-in-test-mode), [failed plan payments](https://memberful.com/docs/account-management/modes/manage-your-account-in-live-mode) and [refunds](https://memberful.com/docs/member-management/payments-and-access/refund-or-suspend-an-order). Stripe rates are from [Stripe's pricing page](https://stripe.com/pricing). All checked Oct 28, 2026. Stripe's rates vary by country, so sellers outside the US should use their local Stripe rate. Memberful can calculate and [collect sales tax](https://memberful.com/docs/configuration/taxes/collect-taxes) at checkout, but it doesn't file or pay that tax for you, and it doesn't say whether its 4.9% applies to the tax portion, so the calculator works on your price before tax. Treat the numbers as estimates and check your Stripe dashboard.

## How the numbers are worked out

```
memberful fee  = price x 4.9%
stripe fee     = price x (2.9% + 1.5% x intl share + 1% x conversion share) + 30¢
you keep       = price - memberful fee - stripe fee
per month      = you keep x payments - $49
break-even     = $49 / (10% + 0.7% - 4.9%) = about $844.83 a month vs Substack
```

At $10 a month with 200 US members, Memberful takes $0.49 and Stripe $0.59 per payment, so you keep $8.92 per payment, $1,784 before the plan and $1,735 after it. Substack at the same numbers would cost $1.66 per payment.

## FAQ

### How much does Memberful charge?

The Standard plan is $49 a month plus a 4.9% transaction fee on every purchase and renewal. Stripe's card fee comes on top, which is 2.9% + 30¢ for US cards on Stripe's standard pricing. Using Memberful in test mode is free, and the $49 starts when you go live.

### Does Memberful have a free plan?

Not for live payments. You can set everything up in test mode for free, but once you connect Stripe and go live you pay $49 a month plus 4.9% per transaction.

### Is Memberful cheaper than Substack or Patreon?

It depends on your revenue. Substack keeps 10% plus Stripe's fees and a 0.7% Billing fee, and Patreon's standard plan keeps 10% plus processing. Memberful's $49 + 4.9% works out cheaper than Substack's 10% + 0.7% once you make more than about $845 a month, and more expensive below that. Compare them with the [Substack fee calculator](substack-fee-calculator) and the [Patreon fee calculator](patreon-fee-calculator).

### Does Memberful refund its fee when I refund a member?

No. Memberful's help docs say it doesn't refund its transaction fee when you process a refund, and Stripe doesn't return its processing fee on card refunds either.

### What happens if my Memberful payment fails?

Memberful retries the $49 charge during a short grace period. If it still can't charge you, your transaction fee rises from 4.9% to 12.5% and you can't email posts until you update your card and reactivate the account.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Memberful charge?", "acceptedAnswer": {"@type": "Answer", "text": "The Standard plan is $49 a month plus a 4.9% transaction fee on every purchase and renewal. Stripe's card fee comes on top, which is 2.9% + 30 cents for US cards on Stripe's standard pricing. Using Memberful in test mode is free, and the $49 starts when you go live."}},
{"@type": "Question", "name": "Does Memberful have a free plan?", "acceptedAnswer": {"@type": "Answer", "text": "Not for live payments. You can set everything up in test mode for free, but once you connect Stripe and go live you pay $49 a month plus 4.9% per transaction."}},
{"@type": "Question", "name": "Is Memberful cheaper than Substack or Patreon?", "acceptedAnswer": {"@type": "Answer", "text": "It depends on your revenue. Substack keeps 10% plus Stripe's fees and a 0.7% Billing fee, and Patreon's standard plan keeps 10% plus processing. Memberful's $49 + 4.9% works out cheaper than Substack's 10% + 0.7% once you make more than about $845 a month, and more expensive below that."}},
{"@type": "Question", "name": "Does Memberful refund its fee when I refund a member?", "acceptedAnswer": {"@type": "Answer", "text": "No. Memberful's help docs say it doesn't refund its transaction fee when you process a refund, and Stripe doesn't return its processing fee on card refunds either."}},
{"@type": "Question", "name": "What happens if my Memberful payment fails?", "acceptedAnswer": {"@type": "Answer", "text": "Memberful retries the $49 charge during a short grace period. If it still can't charge you, your transaction fee rises from 4.9% to 12.5% and you can't email posts until you update your card and reactivate the account."}}
]}
</script>

## Related tools and guides

- [Substack fee calculator (2026)](substack-fee-calculator): Substack's 10% fee, Stripe card and 0.7% Billing fees on monthly and annual plans
- [Patreon fee calculator (2026)](patreon-fee-calculator): the 10% standard plan, legacy plans, processing and payout fees
- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee and whether Ko-fi Gold pays off
- [Gumroad fee calculator (2026)](gumroad-fee-calculator) and [Payhip fee calculator (2026)](payhip-fee-calculator)
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): 5% + 50¢ and its add-ons
- [PayPal and Stripe fee calculator](paypal-stripe-fee-calculator)
- [Kit vs beehiiv vs MailerLite](kit-vs-beehiiv-vs-mailerlite): newsletter platforms compared

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Memberful's 4.9% stacked on Stripe's 2.9% + 30¢. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Memberful, Stripe, Substack or Patreon. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
