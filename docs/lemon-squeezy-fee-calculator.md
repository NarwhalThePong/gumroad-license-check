---
layout: page
title: "Lemon Squeezy fee calculator (2026): 5% + 50¢ plus international, PayPal and subscription fees"
description: "Free Lemon Squeezy fee calculator. Enter your price, buyer location, payment method and VAT or sales tax to see the 5% + 50¢ platform fee with the +1.5% international, +1.5% PayPal and +0.5% subscription surcharges, what you keep per sale and per month, payout fees, and the price you need to keep a set amount."
---

Lemon Squeezy charges **5% + 50¢ per sale**, with no monthly fee. Some sales cost more: **+1.5% if the buyer is outside the US, +1.5% if they pay with PayPal, and +0.5% on subscription payments**. The fee is taken from the whole order total, including any VAT or sales tax Lemon Squeezy collects, so tax makes the fee a little bigger even though the tax itself isn't yours. Enter your numbers below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

<div id="lsf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale before tax (USD)<br><input id="lsf-price" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="lsf-qty" type="number" min="0" step="1" value="50" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>VAT or sales tax on the order (%)<br><input id="lsf-tax" type="number" min="0" max="50" step="0.1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How you get paid<br><select id="lsf-payout"><option value="us-bank">Bank account in the US (free)</option><option value="intl-bank">Bank account outside the US (1% per payout)</option><option value="paypal-us">PayPal, US account ($0.50 per payout)</option><option value="paypal-intl">PayPal, non-US account (3%, max $30 per payout)</option></select></label></p>
  </div>
  <p style="margin:0 0 4px"><label><input id="lsf-intl" type="checkbox"> Buyer outside the US (+1.5%)</label></p>
  <p style="margin:0 0 4px"><label><input id="lsf-paypal" type="checkbox"> Buyer pays with PayPal (+1.5%)</label></p>
  <p style="margin:0 0 8px"><label><input id="lsf-sub" type="checkbox"> Subscription payment (+0.5%)</label></p>
  <p id="lsf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Price</td><td style="text-align:right" id="lsf-o-price">$0.00</td></tr>
    <tr><td>Tax collected (passed on, not yours)</td><td style="text-align:right" id="lsf-o-tax">$0.00</td></tr>
    <tr><td>Order total the buyer pays</td><td style="text-align:right" id="lsf-o-total">$0.00</td></tr>
    <tr><td>Lemon Squeezy fee (<span id="lsf-o-rate">5%</span> of the total + $0.50)</td><td style="text-align:right"><strong id="lsf-o-fee">$0.00</strong></td></tr>
    <tr><td>You keep per sale</td><td style="text-align:right"><strong id="lsf-o-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of your price</td><td style="text-align:right" id="lsf-o-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales before tax</td><td style="text-align:right" id="lsf-m-gross">$0.00</td></tr>
    <tr><td>Lemon Squeezy fees</td><td style="text-align:right" id="lsf-m-fee">$0.00</td></tr>
    <tr><td>Payout fees (2 payouts a month)</td><td style="text-align:right" id="lsf-m-payout">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="lsf-m-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount per sale</h3>
  <p style="margin:0 0 8px"><label>I want to keep (USD, before payout fees)<br><input id="lsf-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="lsf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Lemon Squeezy fee math. Rates from lemonsqueezy.com/pricing and docs.lemonsqueezy.com/help/getting-started/fees, checked Oct 28, 2026. */
(function (root) {
  var CHECKED = "2026-10-28";
  var BASE_PCT = 5, FIXED = 0.50, INTL_PCT = 1.5, PAYPAL_PCT = 1.5, SUB_PCT = 0.5;
  var PAYOUTS = {
    "us-bank": { name: "US bank", pct: 0, flat: 0, cap: null },
    "intl-bank": { name: "Non-US bank", pct: 1, flat: 0, cap: null },
    "paypal-us": { name: "PayPal (US)", pct: 0, flat: 0.50, cap: null },
    "paypal-intl": { name: "PayPal (non-US)", pct: 3, flat: 0, cap: 30 }
  };
  var PAYOUTS_PER_MONTH = 2, MAX_PRICE = 1000000, MAX_SALES = 1000000, MAX_TAX = 50;
  function r2(n) { return Math.round(n * 100) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function sales(v) { return Math.floor(clean(v, MAX_SALES)); }
  function tax(v) { return clean(v, MAX_TAX); }
  function rate(o) { o = o || {}; return BASE_PCT + (o.intl ? INTL_PCT : 0) + (o.paypal ? PAYPAL_PCT : 0) + (o.sub ? SUB_PCT : 0); }
  function perSale(p, o) {
    o = o || {}; p = price(p); var t = tax(o.taxPct), pct = rate(o);
    var taxAmt = r2(p * t / 100), total = r2(p + taxAmt);
    var fee = p > 0 ? r2(total * pct / 100 + FIXED) : 0;
    return { price: p, taxPct: t, tax: taxAmt, total: total, ratePct: pct, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function payoutFee(amount, method) {
    var m = PAYOUTS[method] || PAYOUTS["us-bank"]; if (!(amount > 0)) return 0;
    var f = amount * m.pct / 100 + m.flat; if (m.cap != null) f = Math.min(f, m.cap); return r2(Math.min(f, amount));
  }
  function monthly(p, n, o) {
    o = o || {}; var s = perSale(p, o), q = sales(n);
    var gross = r2(s.price * q), fees = r2(s.fee * q), beforePayout = r2(gross - fees);
    var each = beforePayout / PAYOUTS_PER_MONTH, pay = beforePayout > 0 ? r2(payoutFee(each, o.payout) * PAYOUTS_PER_MONTH) : 0;
    return { sales: q, gross: gross, fees: fees, payoutFees: pay, net: r2(beforePayout - pay), effective: gross > 0 ? (fees + pay) / gross : null };
  }
  // Lowest price (to the cent) that keeps at least `target` per sale after the Lemon Squeezy fee.
  function priceFor(target, o) {
    o = o || {}; var k = price(target); if (!(k > 0)) return null;
    var f = (1 + tax(o.taxPct) / 100) * rate(o) / 100; if (f >= 1) return null;
    var p = Math.ceil(((k + FIXED) / (1 - f)) * 100 - 1e-6) / 100;
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    while (perSale(p, o).net < k) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, BASE_PCT: BASE_PCT, FIXED: FIXED, INTL_PCT: INTL_PCT, PAYPAL_PCT: PAYPAL_PCT, SUB_PCT: SUB_PCT, PAYOUTS: PAYOUTS,
    MAX_PRICE: MAX_PRICE, MAX_SALES: MAX_SALES, MAX_TAX: MAX_TAX, price: price, sales: sales, tax: tax, rate: rate,
    perSale: perSale, payoutFee: payoutFee, monthly: monthly, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.LemonSqueezyFees = api;
})(this);
(function () {
  var F = window.LemonSqueezyFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  function update() {
    var rawP = $("lsf-price").value, rawN = $("lsf-qty").value, rawT = $("lsf-tax").value;
    var o = { taxPct: rawT, intl: $("lsf-intl").checked, paypal: $("lsf-paypal").checked, sub: $("lsf-sub").checked, payout: $("lsf-payout").value };
    var w = [];
    if (Number(rawP) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(rawN) > F.MAX_SALES) w.push("Sales capped at " + F.MAX_SALES.toLocaleString("en-US") + " a month.");
    if (Number(rawT) > F.MAX_TAX) w.push("Tax capped at " + F.MAX_TAX + "%.");
    if (Number(rawP) < 0 || Number(rawN) < 0 || Number(rawT) < 0) w.push("Negative numbers are treated as 0.");
    set("lsf-warn", w.join(" "));
    var s = F.perSale(rawP, o), m = F.monthly(rawP, rawN, o);
    set("lsf-o-price", money(s.price)); set("lsf-o-tax", money(s.tax)); set("lsf-o-total", money(s.total));
    set("lsf-o-rate", (Math.round(s.ratePct * 10) / 10) + "%"); set("lsf-o-fee", money(s.fee)); set("lsf-o-net", money(s.net)); set("lsf-o-eff", pctS(s.effective));
    set("lsf-m-gross", money(m.gross)); set("lsf-m-fee", money(m.fees)); set("lsf-m-payout", money(m.payoutFees)); set("lsf-m-net", money(m.net));
    var need = F.priceFor($("lsf-target").value, o);
    set("lsf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " (before tax) to keep at least " + money(F.price($("lsf-target").value)) + " per sale with these options.");
  }
  ["lsf-price", "lsf-qty", "lsf-tax", "lsf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["lsf-intl", "lsf-paypal", "lsf-sub", "lsf-payout"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Lemon Squeezy fees (checked Oct 28, 2026)

| Fee | Rate | When it applies |
|---|---|---|
| Platform fee | 5% + $0.50 | Every sale, taken from the order total including tax |
| International | +1.5% | Buyer outside the US |
| PayPal | +1.5% | Buyer pays with PayPal |
| Subscription | +0.5% | Each subscription payment |
| Abandoned cart recovery | +5% | Payments recovered by abandoned cart emails |
| Affiliate referral | +3% | Sales made through an affiliate (paid by you, the seller) |
| Monthly fee | $0 | Selling is free to start; email marketing is free up to 500 subscribers |

Payout fees, taken when your balance is paid out (Lemon Squeezy pays out twice a month):

| Payout method | Fee |
|---|---|
| Bank account in the US | Free |
| Bank account outside the US | 1% per payout |
| PayPal, US account | $0.50 per payout |
| PayPal, account outside the US | 3% per payout, capped at $30 |

Sources: [Lemon Squeezy pricing](https://www.lemonsqueezy.com/pricing) and [Lemon Squeezy docs: Fees](https://docs.lemonsqueezy.com/help/getting-started/fees), both checked Oct 28, 2026. Lemon Squeezy also says it offers custom pricing for high-volume sellers and for products under $10. Rates change, so check your store's plan page before you rely on a number.

## How the numbers are worked out

```
order total        = price + tax
fee rate           = 5% (+1.5% international, +1.5% PayPal, +0.5% subscription)
Lemon Squeezy fee  = order total x fee rate + $0.50, rounded to the cent
you keep per sale  = price - Lemon Squeezy fee   (the tax goes to the tax office)
payout fee         = per payout, on the balance paid out (2 payouts a month assumed)
```

Example from Lemon Squeezy's own docs: a buyer in France pays $20 plus 20% VAT, so $24.00 in total. The fee is 5% + 1.5% international = 6.5% of $24.00 ($1.56) plus $0.50, so $2.06, and you keep $17.94.

A $20 sale to a US buyer with no sales tax costs $1.50 (5% of $20 + $0.50), so you keep $18.50, an effective 7.5%. The 50¢ part weighs more on cheap products: on a $5 sale the fee is $0.75, which is 15% of the price.

Not included: abandoned cart and affiliate fees (they only apply to those particular sales), currency conversion on your own bank's side, refunds and chargebacks.

## FAQ

### How much does Lemon Squeezy take per sale?

5% of the order total plus $0.50. Buyers outside the US add 1.5%, PayPal payments add 1.5%, and subscription payments add 0.5%, so a PayPal subscription payment from a buyer outside the US costs 8.5% + $0.50.

### Does Lemon Squeezy charge Stripe or PayPal fees on top?

No. Lemon Squeezy is the merchant of record and its platform fee covers card processing, currency conversion and tax handling. The only extras are the surcharges above and the payout fee, if your payout method has one.

### Is the Lemon Squeezy fee charged on tax?

Yes. Lemon Squeezy calculates the fee on the total order value, which includes the VAT or sales tax it collects. The tax itself is paid to the tax office, so you keep the price minus the fee.

### Does Lemon Squeezy have a monthly fee?

No. Selling is free with no monthly charge; you only pay per sale. Its email marketing is free up to 500 subscribers and is billed separately above that.

### Is Lemon Squeezy cheaper than Gumroad?

On a direct sale, usually yes. Gumroad charges 10% + $0.50 plus card processing on direct sales, while Lemon Squeezy charges 5% + $0.50 with processing included. Compare both, and other platforms, at your own price in the [Seller fee comparison calculator](seller-fee-comparison-calculator).

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Lemon Squeezy take per sale?","acceptedAnswer":{"@type":"Answer","text":"5% of the order total plus $0.50. Buyers outside the US add 1.5%, PayPal payments add 1.5%, and subscription payments add 0.5%, so a PayPal subscription payment from a buyer outside the US costs 8.5% + $0.50."}},
{"@type":"Question","name":"Does Lemon Squeezy charge Stripe or PayPal fees on top?","acceptedAnswer":{"@type":"Answer","text":"No. Lemon Squeezy is the merchant of record and its platform fee covers card processing, currency conversion and tax handling. The only extras are the surcharges above and the payout fee, if your payout method has one."}},
{"@type":"Question","name":"Is the Lemon Squeezy fee charged on tax?","acceptedAnswer":{"@type":"Answer","text":"Yes. Lemon Squeezy calculates the fee on the total order value, which includes the VAT or sales tax it collects. The tax itself is paid to the tax office, so you keep the price minus the fee."}},
{"@type":"Question","name":"Does Lemon Squeezy have a monthly fee?","acceptedAnswer":{"@type":"Answer","text":"No. Selling is free with no monthly charge; you only pay per sale. Its email marketing is free up to 500 subscribers and is billed separately above that."}},
{"@type":"Question","name":"Is Lemon Squeezy cheaper than Gumroad?","acceptedAnswer":{"@type":"Answer","text":"On a direct sale, usually yes. Gumroad charges 10% + $0.50 plus card processing on direct sales, while Lemon Squeezy charges 5% + $0.50 with processing included. Compare both, and other platforms, at your own price in the Seller fee comparison calculator."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Lemon Squeezy next to Gumroad, Payhip, Ko-fi, Paddle, Polar, Etsy, Stripe and PayPal at your price and volume
- [Gumroad vs Lemon Squeezy vs Polar vs Paddle](gumroad-vs-lemon-squeezy-polar-paddle-fees): fees in 2026 and what you keep
- [Payhip fee calculator (2026)](payhip-fee-calculator) and [Gumroad fee calculator](gumroad-fee-calculator)
- [When do you get paid? Payout timing on Gumroad, Payhip, Etsy, Lemon Squeezy and Sellfy](when-do-you-get-paid-gumroad-payhip-etsy-lemon-squeezy-sellfy)
- [Who collects sales tax and VAT on digital products? Gumroad, Lemon Squeezy, Payhip, Sellfy and Etsy](who-collects-sales-tax-vat-gumroad-lemon-squeezy-payhip-sellfy-etsy)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Lemon Squeezy. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
