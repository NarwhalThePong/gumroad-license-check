---
layout: page
title: "Skool fee calculator (2026): Hobby $9 vs Pro $99, the 10% or 2.9% + 30¢ fee, and what you keep"
description: "Free Skool fee calculator. Enter your community price, payments per month and how many members came from Skool's Growth Boost to see the Hobby 10% + 30¢ or Pro 2.9% + 30¢ fee, the 30% Growth Boost cut, what you keep each month, the revenue where Pro beats Hobby, and the price you need to keep a set amount."
---

Skool runs paid communities and courses and processes the payments itself, so there is no separate Stripe fee. It has two plans: **Hobby at $9 a month with a 10% + 30¢ fee** on every payment, and **Pro at $99 a month with 2.9% + 30¢** on payments up to $899 (3.9% + 30¢ above $900). If Skool's Growth Boost brings you a paying member, Skool also keeps **30% of that member's payments** for as long as they stay. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="sk" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Plan<br><select id="sk-plan" style="width:100%;max-width:160px"><option value="pro">Pro ($99 a month)</option><option value="hobby">Hobby ($9 a month)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per payment (USD)<br><input id="sk-price" type="number" min="0" step="0.01" value="49" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month (renewals + new members)<br><input id="sk-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments from members Growth Boost brought in (%)<br><input id="sk-boost" type="number" min="0" max="100" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="sk-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Skool transaction fee</td><td style="text-align:right" id="sk-s-fee">$0.00</td></tr>
    <tr><td>You keep from a member you brought</td><td style="text-align:right"><strong id="sk-s-net">$0.00</strong></td></tr>
    <tr><td>You keep from a Growth Boost member (after the 30% cut)</td><td style="text-align:right" id="sk-s-boost">$0.00</td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="sk-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Revenue</td><td style="text-align:right" id="sk-m-gross">$0.00</td></tr>
    <tr><td>Skool transaction fees</td><td style="text-align:right" id="sk-m-fee">$0.00</td></tr>
    <tr><td>Growth Boost cut</td><td style="text-align:right" id="sk-m-boost">$0.00</td></tr>
    <tr><td>Plan</td><td style="text-align:right" id="sk-m-plan">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="sk-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="sk-m-eff">n/a</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="sk-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Hobby vs Pro at these numbers</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>You keep per month on Hobby</td><td style="text-align:right" id="sk-c-hobby">$0.00</td></tr>
    <tr><td>You keep per month on Pro</td><td style="text-align:right" id="sk-c-pro">$0.00</td></tr>
  </table>
  <p id="sk-c-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per payment from a member I brought (USD)<br><input id="sk-target" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sk-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Skool fee math. Hobby $9/month, Pro $99/month (skool.com/pricing). Fees from Skool Help Center "Skool Payments FAQs" (help.skool.com/article/86-subscriptions-faq, last updated Sept 29, 2026): Pro 2.9% + 30c per transaction up to $899, 3.9% + 30c above $900; Hobby 10% + 30c on all transactions; fees non-refundable; Skool is the merchant of record and adds VAT on top of the price; Growth Boost keeps 30% of payments from members Skool brings in, on recurring charges, plus the plan's fees. Prices from $899.01 to $899.99 are not covered by Skool's wording; we use 2.9% below $900 and 3.9% from $900. Checked Oct 28, 2026. Payout currency conversion is not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PLANS = { hobby: { fee: 9, pct: 10, hi: 10 }, pro: { fee: 99, pct: 2.9, hi: 3.9 } };
  var FIXED = 0.30, BIG = 900, BOOST = 30, MAX_PRICE = 100000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function share(v) { return Math.min(num(v), 100) / 100; }
  function plan(k) { return PLANS[k] ? k : "pro"; }
  function perSale(v, k) {
    var p = price(v), P = PLANS[plan(k)];
    if (p <= 0) return { price: 0, fee: 0, net: 0, boostNet: 0, effective: null };
    var fee = r2(p * (p >= BIG ? P.hi : P.pct) / 100 + FIXED), cut = r2(p * BOOST / 100);
    return { price: p, fee: fee, cut: cut, net: r2(p - fee), boostNet: r2(p - fee - cut), effective: fee / p };
  }
  function perMonth(v, q, k, b) {
    var s = perSale(v, k), n = qty(q), nb = Math.round(n * share(b)), gross = r2(s.price * n), fee = r2(s.fee * n), cut = r2((s.cut || 0) * nb);
    var pl = PLANS[plan(k)].fee, cost = r2(fee + cut + pl);
    return { gross: gross, fee: fee, boost: cut, boosted: nb, plan: pl, net: r2(gross - cost), year: r2((gross - cost) * 12), effective: gross > 0 ? cost / gross : null };
  }
  /* Monthly revenue (payments under $900) above which Pro's $99 + 2.9% costs less than Hobby's $9 + 10%. */
  function breakEven() { return r2((PLANS.pro.fee - PLANS.hobby.fee) / ((PLANS.hobby.pct - PLANS.pro.pct) / 100)); }
  function search(lo, hi, k, pl) { if (perSale(hi / 100, pl).net < k) return null; while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, pl).net >= k) hi = mid; else lo = mid + 1; } return lo / 100; }
  /* Net drops at $900 on Pro, so search below $900 first, then from $900 up. */
  function priceFor(v, k) {
    var t = price(v); if (t <= 0) return null;
    var a = search(1, BIG * 100 - 1, t, k); if (a != null) return a;
    return search(BIG * 100, MAX_PRICE * 100, t, k);
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, share: share, perSale: perSale, perMonth: perMonth, breakEven: breakEven, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.SkoolFees = api;
})(this);
(function () {
  var F = window.SkoolFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var k = $("sk-plan").value, p = $("sk-price").value, q = $("sk-qty").value, b = $("sk-boost").value;
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ", Skool's per-charge limit.");
    if (Number(q) > F.MAX_QTY) w.push("Payments capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(b) > 100) w.push("Share capped at 100%.");
    if (Number(p) < 0 || Number(q) < 0 || Number(b) < 0) w.push("Negative numbers are treated as 0.");
    set("sk-warn", w.join(" "));
    var s = F.perSale(p, k), m = F.perMonth(p, q, k, b), h = F.perMonth(p, q, "hobby", b), r = F.perMonth(p, q, "pro", b);
    set("sk-s-fee", money(s.fee)); set("sk-s-net", money(s.net)); set("sk-s-boost", money(s.boostNet)); set("sk-s-eff", pctS(s.effective));
    set("sk-m-gross", money(m.gross)); set("sk-m-fee", money(m.fee)); set("sk-m-boost", money(m.boost)); set("sk-m-plan", money(m.plan)); set("sk-m-net", money(m.net)); set("sk-m-eff", pctS(m.effective)); set("sk-y-net", money(m.year));
    set("sk-c-hobby", money(h.net)); set("sk-c-pro", money(r.net));
    var d = r2c(r.net - h.net);
    set("sk-c-best", (d > 0 ? "Pro leaves you " + money(d) + " more a month than Hobby here." : d < 0 ? "Hobby leaves you " + money(-d) + " more a month than Pro here." : "Both plans leave you the same here.") + " Pro pays off once your revenue passes about " + money(F.breakEven()) + " a month.");
    var need = F.priceFor($("sk-target").value, k);
    set("sk-need", need == null ? "Enter how much you want to keep per payment." : "Charge " + money(need) + " to keep at least " + money(F.price($("sk-target").value)) + " per payment on " + (k === "hobby" ? "Hobby" : "Pro") + ", before the plan fee.");
  }
  function r2c(x) { return Math.round(x * 100) / 100; }
  ["sk-plan", "sk-price", "sk-qty", "sk-boost", "sk-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Skool fees (checked Oct 28, 2026)

| Fee | Hobby | Pro |
|---|---|---|
| Plan | $9 a month | $99 a month |
| Transaction fee, payments up to $899 | 10% + 30¢ | 2.9% + 30¢ |
| Transaction fee, payments above $900 | 10% + 30¢ | 3.9% + 30¢ |
| Separate Stripe or card fee | None, Skool processes payments | None |
| Growth Boost (members Skool brings you) | 30% of their payments, plus the fee above | Same |
| Free trial | 14 days | 14 days |
| Refunds | Transaction fees aren't refunded | Same |
| VAT and sales tax | Skool adds it on top and remits it | Same |

The plan prices are from Skool's [pricing page](https://www.skool.com/pricing) and the fee rules from its help article [Skool Payments FAQs](https://help.skool.com/article/86-subscriptions-faq), both checked Oct 28, 2026. Skool's wording covers payments "up to $899" and "above $900", so this calculator uses 2.9% for prices under $900 and 3.9% from $900. Prices are always in US dollars, and Skool pays out every Wednesday in your local currency, so your bank may see a small conversion difference. Treat the numbers as estimates and check your Skool payouts.

## How the numbers are worked out

```
skool fee      = price x 10% + 30¢          (Hobby)
skool fee      = price x 2.9% + 30¢         (Pro, under $900)
skool fee      = price x 3.9% + 30¢         (Pro, $900 and up)
growth boost   = price x 30%                (only for members Skool brought in)
per month      = (price - fee) x payments - boost cuts - plan
break-even     = ($99 - $9) / (10% - 2.9%) = about $1,267.61 a month
```

These reproduce Skool's own examples: a $9 membership pays out $7.80 on Hobby and $8.44 on Pro (Skool rounds it to $8.4), and a $999 price pays out $959.74 on Pro. At $49 a month with 50 payments, Pro takes $1.72 per payment, so you keep $47.28 per payment, $2,364 before the plan and $2,265 after it. Hobby at the same numbers takes $5.20 per payment and leaves you $2,181 after its $9 plan.

## FAQ

### How much does Skool charge?

Skool has two plans. Hobby costs $9 a month and takes 10% + 30¢ from every payment. Pro costs $99 a month and takes 2.9% + 30¢ from payments up to $899, or 3.9% + 30¢ above $900. There is no separate Stripe fee because Skool processes the payments.

### When is Skool Pro worth it over Hobby?

Pro costs $90 a month more but saves 7.1% of every payment under $900, so it pays off once your community brings in more than about $1,268 a month. Below that, Hobby leaves you more money, though Pro also removes the Skool badge and adds unlimited admins.

### What is the Skool Growth Boost fee?

Growth Boost promotes your community in Skool's search and with ads that Skool pays for. When it brings you a paying member, Skool keeps 30% of that member's payments, on every renewal while they stay, plus the normal transaction fee. Members you bring yourself only pay the normal fee. You can switch it off under Settings, Discovery.

### Does Skool refund its fee when I refund a member?

No. Skool's help center says transaction fees are non-refundable.

### Does Skool charge VAT or sales tax?

Skool is the merchant of record, so it adds VAT or sales tax on top of your price where it applies and remits it itself. The fee in this calculator is worked out on your price before tax.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Skool charge?", "acceptedAnswer": {"@type": "Answer", "text": "Skool has two plans. Hobby costs $9 a month and takes 10% + 30 cents from every payment. Pro costs $99 a month and takes 2.9% + 30 cents from payments up to $899, or 3.9% + 30 cents above $900. There is no separate Stripe fee because Skool processes the payments."}},
{"@type": "Question", "name": "When is Skool Pro worth it over Hobby?", "acceptedAnswer": {"@type": "Answer", "text": "Pro costs $90 a month more but saves 7.1% of every payment under $900, so it pays off once your community brings in more than about $1,268 a month. Below that, Hobby leaves you more money, though Pro also removes the Skool badge and adds unlimited admins."}},
{"@type": "Question", "name": "What is the Skool Growth Boost fee?", "acceptedAnswer": {"@type": "Answer", "text": "Growth Boost promotes your community in Skool's search and with ads that Skool pays for. When it brings you a paying member, Skool keeps 30% of that member's payments, on every renewal while they stay, plus the normal transaction fee. Members you bring yourself only pay the normal fee. You can switch it off under Settings, Discovery."}},
{"@type": "Question", "name": "Does Skool refund its fee when I refund a member?", "acceptedAnswer": {"@type": "Answer", "text": "No. Skool's help center says transaction fees are non-refundable."}},
{"@type": "Question", "name": "Does Skool charge VAT or sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "Skool is the merchant of record, so it adds VAT or sales tax on top of your price where it applies and remits it itself. The fee in this calculator is worked out on your price before tax."}}
]}
</script>

## Related tools and guides

- [Whop fee calculator (2026)](whop-fee-calculator): the 2.7% + 30¢ card fee and the 3% app fee
- [Stan Store fee calculator (2026)](stan-store-fee-calculator): 0% transaction fee, $29 Creator or $99 Creator Pro, plus Stripe or PayPal fees
- [Kajabi fee calculator (2026)](kajabi-fee-calculator): no transaction fee, but $179 to $499 plans
- [Patreon fee calculator (2026)](patreon-fee-calculator) and [Memberful fee calculator (2026)](memberful-fee-calculator) for memberships
- [Podia fee calculator (2026)](podia-fee-calculator) and [Teachable fee calculator (2026)](teachable-fee-calculator) for courses
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Skool's 10% + 30¢ or 2.9% + 30¢. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Skool. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
