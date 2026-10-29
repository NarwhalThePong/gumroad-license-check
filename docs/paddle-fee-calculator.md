---
layout: page
title: "Paddle fee calculator (2026): what Paddle's 5% + 50¢ costs and what you keep"
description: "Free Paddle fee calculator. Enter your price, monthly sales and sales tax or VAT to see Paddle's 5% + 50¢ merchant-of-record fee on the tax-inclusive total, payout costs, what you keep each month, how it compares with plain Stripe, and the price you need to keep a set amount."
---

Paddle is a merchant of record: it sells your product to the buyer, collects and remits sales tax and VAT, handles chargebacks and buyer support, and pays you what is left. Its standard price is one fee, **5% + 50¢ per checkout transaction**, with **no monthly fee**. The fee is worked out on the **total the buyer pays, tax included**. Payouts by local bank transfer (ACH in the US, SEPA in the Eurozone, and local transfers in the UK, Canada and Australia) carry **no Paddle fee**, but a payout sent by international SWIFT wire because the currency doesn't match your bank's country costs **$15**. Enter your numbers below to see the fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="pd" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale, before tax (USD)<br><input id="pd-price" type="number" min="0" step="0.01" value="29" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="pd-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax or VAT added at checkout (%)<br><input id="pd-tax" type="number" min="0" max="30" step="0.1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>SWIFT wire payouts per month ($15 each)<br><input id="pd-swift" type="number" min="0" step="1" value="0" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="pd-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays, tax included</td><td style="text-align:right" id="pd-s-total">$0.00</td></tr>
    <tr><td>Tax Paddle collects and remits</td><td style="text-align:right" id="pd-s-tax">$0.00</td></tr>
    <tr><td>Paddle fee (5% + $0.50 of the total)</td><td style="text-align:right" id="pd-s-fee">$0.00</td></tr>
    <tr><td>You keep per sale</td><td style="text-align:right"><strong id="pd-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="pd-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue, before tax</td><td style="text-align:right" id="pd-m-gross">$0.00</td></tr>
    <tr><td>Paddle fees</td><td style="text-align:right" id="pd-m-fees">$0.00</td></tr>
    <tr><td>SWIFT payout fees</td><td style="text-align:right" id="pd-m-payout">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="pd-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="pd-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Paddle vs plain Stripe card processing</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Stripe standard US card fees (2.9% + 30¢), before you handle tax yourself</td><td style="text-align:right" id="pd-c-stripe">$0.00</td></tr>
    <tr><td>Extra Paddle costs a month for being merchant of record</td><td style="text-align:right" id="pd-c-extra">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale (USD)<br><input id="pd-target" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="pd-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Paddle fee math. Standard pay-as-you-go rate 5% + 50c per checkout transaction, no monthly fee (paddle.com/pricing), fee taken from the total order amount including tax (Paddle help center "How are my earnings calculated?": $120 order with $20 VAT, $6.50 fee, $93.50 earnings), no Paddle payout fee except $15 for SWIFT wires when the payout currency doesn't match the bank's country (Paddle help center "Is there a fee taken for payouts?"). Stripe comparison uses Stripe's standard US card rate 2.9% + 30c. Checked Oct 28, 2026. USD prices. Custom pricing, Payoneer fees, refunds and disputes are not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var PCT = 5, FIXED = 0.50, SWIFT = 15, STRIPE_PCT = 2.9, STRIPE_FIXED = 0.30, SMALL = 10, MAX_TAX = 30;
  var MAX_PRICE = 1000000, MAX_QTY = 1000000, MAX_SWIFT = 31;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function price(v) { return Math.min(r2(num(v)), MAX_PRICE); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function swift(v) { return Math.min(Math.floor(num(v)), MAX_SWIFT); }
  function tax(v) { return Math.min(num(v), MAX_TAX); }
  function perSale(v, o) {
    o = o || {}; var p = price(v);
    if (p <= 0) return { price: 0, tax: 0, total: 0, fee: 0, net: 0, effective: null };
    var tx = r2(p * tax(o.tax) / 100), total = r2(p + tx), fee = r2(total * PCT / 100 + FIXED);
    return { price: p, tax: tx, total: total, fee: fee, net: r2(p - fee), effective: fee / p };
  }
  function stripeFee(v) { var p = price(v); return p > 0 ? r2(p * STRIPE_PCT / 100 + STRIPE_FIXED) : 0; }
  function perMonth(v, q, o) {
    o = o || {}; var s = perSale(v, o), n = qty(q), gross = r2(s.price * n), fees = r2(s.fee * n);
    var po = gross > 0 ? r2(SWIFT * swift(o.swift)) : 0, st = r2(stripeFee(v) * n);
    return { gross: gross, fees: fees, payout: po, net: r2(gross - fees - po), effective: gross > 0 ? (fees + po) / gross : null, stripe: st, extra: r2(fees + po - st) };
  }
  function priceFor(v, o) {
    o = o || {}; var k = price(v); if (k <= 0) return null;
    if (perSale(MAX_PRICE, o).net < k) return null;
    var lo = 1, hi = MAX_PRICE * 100;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (perSale(mid / 100, o).net >= k) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, SMALL: SMALL, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, MAX_SWIFT: MAX_SWIFT, price: price, qty: qty, swift: swift, perSale: perSale, stripeFee: stripeFee, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PaddleFees = api;
})(this);
(function () {
  var F = window.PaddleFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var p = $("pd-price").value, q = $("pd-qty").value, o = { tax: $("pd-tax").value, swift: $("pd-swift").value };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(o.swift) > F.MAX_SWIFT) w.push("Payouts capped at " + F.MAX_SWIFT + " a month.");
    if (Number(o.tax) > 30) w.push("Tax capped at 30%.");
    if (Number(p) < 0 || Number(q) < 0 || Number(o.tax) < 0 || Number(o.swift) < 0) w.push("Negative numbers are treated as 0.");
    if (Number(p) > 0 && Number(p) < F.SMALL) w.push("Paddle asks sellers with products under $10 to contact it for custom pricing, so your real rate may differ.");
    set("pd-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o);
    set("pd-s-total", money(s.total)); set("pd-s-tax", money(s.tax)); set("pd-s-fee", money(s.fee)); set("pd-s-net", money(s.net)); set("pd-s-eff", pctS(s.effective));
    set("pd-m-gross", money(m.gross)); set("pd-m-fees", money(m.fees)); set("pd-m-payout", money(m.payout)); set("pd-m-net", money(m.net)); set("pd-m-eff", pctS(m.effective));
    set("pd-c-stripe", money(m.stripe)); set("pd-c-extra", money(m.extra));
    var need = F.priceFor($("pd-target").value, o);
    set("pd-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " before tax to keep at least " + money(F.price($("pd-target").value)) + " per sale.");
  }
  ["pd-price", "pd-qty", "pd-target", "pd-tax", "pd-swift"].forEach(function (id) { $(id).addEventListener("input", update); });
  update();
})();
</script>

## Paddle fees (checked Oct 28, 2026)

| Fee | Rate |
|---|---|
| Checkout transaction | 5% + 50¢ of the total the buyer pays, tax included |
| Monthly fee | None |
| Products under $10 | Paddle asks you to contact it for custom pricing |
| High volume | Custom pricing on request |
| Payout by local bank transfer (ACH, SEPA, UK, Canada, Australia) in your bank's currency | No Paddle fee |
| Payout by SWIFT wire, when the payout currency differs from your bank's country | $15 (or €15 or £15) per payout |
| Payout to Payoneer | Payoneer's own fees |

The transaction fee comes from Paddle's [pricing page](https://www.paddle.com/pricing), and the fee-on-tax rule and payout costs from Paddle's help center articles on [how earnings are calculated](https://www.paddle.com/help/manage/reporting/how-are-my-earnings-calculated) and [payout fees](https://www.paddle.com/help/manage/get-paid/is-there-a-fee-taken-for-payouts), all checked Oct 28, 2026. The fee covers payment processing, extra payment methods, sales tax and VAT filing, fraud screening, chargeback handling and buyer support. Your own bank, or an intermediary bank on a wire, can still charge you on top. Treat the numbers as estimates and check the transaction report in your Paddle dashboard.

## How the numbers are worked out

```
total        = price + sales tax or VAT
paddle fee   = total x 5% + 50¢
you keep     = price - paddle fee          (Paddle remits the tax)
per month    = you keep x sales - $15 x SWIFT payouts
vs stripe    = (paddle fees + payout fees) - (2.9% x price + 30¢) x sales
```

Paddle's own example is a UK buyer paying a $120 order that includes $20 of VAT. Paddle takes 5% + 50¢ of the full $120, which is $6.50, and the seller keeps $93.50. Set the price to $100 and tax to 20% above and you get the same result.

## FAQ

### How much does Paddle charge per sale?

5% + 50¢ of the total the buyer pays, tax included, with no monthly fee. On a $29 sale with no tax that's $1.95, so you keep $27.05.

### Does Paddle charge its fee on sales tax and VAT?

Yes. Paddle's help center example takes the fee from a $120 order that includes $20 of VAT, so the fee is $6.50 rather than the $5.50 it would be on the $100 product price alone.

### Does Paddle charge for payouts?

Paddle adds no payout fee for local bank transfers in your bank's own currency, such as USD by ACH to a US bank. If the payout currency doesn't match your bank's country, the money goes by SWIFT wire and Paddle deducts $15 per payout. Payoneer payouts carry Payoneer's fees.

### Is Paddle more expensive than Stripe?

On fees alone, yes: Stripe's standard US card rate is 2.9% + 30¢, so Paddle costs about 2.1% + 20¢ more per sale before tax. That gap pays for Paddle being merchant of record, so you don't register for, collect or file sales tax and VAT yourself, and it handles chargebacks and buyer support. The calculator shows the monthly gap at your numbers.

### Is Paddle cheaper than Lemon Squeezy, Polar or Gumroad?

Paddle, Lemon Squeezy and Polar's free Starter plan all charge 5% + 50¢. Lemon Squeezy adds 1.5% for non-US buyers and for PayPal, and Polar adds 1.5% for non-US cards, while Paddle's price page lists no such surcharges. Gumroad charges 10% + 50¢ on direct sales plus card processing. Compare them with the [Polar fee calculator](polar-fee-calculator), the [Lemon Squeezy fee calculator](lemon-squeezy-fee-calculator) and the [seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Paddle charge per sale?", "acceptedAnswer": {"@type": "Answer", "text": "5% + 50 cents of the total the buyer pays, tax included, with no monthly fee. On a $29 sale with no tax that's $1.95, so you keep $27.05."}},
{"@type": "Question", "name": "Does Paddle charge its fee on sales tax and VAT?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. Paddle's help center example takes the fee from a $120 order that includes $20 of VAT, so the fee is $6.50 rather than the $5.50 it would be on the $100 product price alone."}},
{"@type": "Question", "name": "Does Paddle charge for payouts?", "acceptedAnswer": {"@type": "Answer", "text": "Paddle adds no payout fee for local bank transfers in your bank's own currency, such as USD by ACH to a US bank. If the payout currency doesn't match your bank's country, the money goes by SWIFT wire and Paddle deducts $15 per payout. Payoneer payouts carry Payoneer's fees."}},
{"@type": "Question", "name": "Is Paddle more expensive than Stripe?", "acceptedAnswer": {"@type": "Answer", "text": "On fees alone, yes: Stripe's standard US card rate is 2.9% + 30 cents, so Paddle costs about 2.1% + 20 cents more per sale before tax. That gap pays for Paddle being merchant of record, so you don't register for, collect or file sales tax and VAT yourself, and it handles chargebacks and buyer support."}},
{"@type": "Question", "name": "Is Paddle cheaper than Lemon Squeezy, Polar or Gumroad?", "acceptedAnswer": {"@type": "Answer", "text": "Paddle, Lemon Squeezy and Polar's free Starter plan all charge 5% + 50 cents. Lemon Squeezy adds 1.5% for non-US buyers and for PayPal, and Polar adds 1.5% for non-US cards, while Paddle's price page lists no such surcharges. Gumroad charges 10% + 50 cents on direct sales plus card processing."}}
]}
</script>

## Related tools and guides

- [Gumroad vs Lemon Squeezy vs Polar vs Paddle fees](gumroad-vs-lemon-squeezy-polar-paddle-fees): merchant-of-record fees side by side
- [Polar fee calculator (2026)](polar-fee-calculator): Polar's Starter, Pro, Growth and Scale rates
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): 5% + 50¢ and its add-ons
- [PayPal and Stripe fee calculator](paypal-stripe-fee-calculator)
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [Gumroad fee calculator (2026)](gumroad-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Paddle's 5% + 50¢. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Paddle or Stripe. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
