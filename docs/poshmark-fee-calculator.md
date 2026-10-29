---
layout: page
title: "Poshmark fee calculator (2026): what you keep after the $2.95 or 20% seller fee"
description: "Free Poshmark fee calculator. See Poshmark's seller fee and what you keep on each sale, your profit after what you paid for the item, monthly and yearly totals, the $15 price cliff, and the exact price to list at to keep a set amount."
---

Poshmark charges US sellers one fee when an item sells, and it comes out of the final order price. For a sale **under $15**, the fee is a flat **$2.95**. For a sale of **$15 or more**, the fee is **20%**, so you keep 80%. Listing is free, and there is no monthly fee or separate payment processing fee. That means a $10 sale leaves you $7.05, a $25 sale leaves you $20.00 and a $100 sale leaves you $80.00. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="pm" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sale price (USD)<br><input id="pm-price" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="pm-qty" type="number" min="0" step="1" value="40" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="pm-cost" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="pm-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sale price</td><td style="text-align:right" id="pm-s-price">$0.00</td></tr>
    <tr><td>Poshmark fee rule for this price</td><td style="text-align:right" id="pm-s-rate"></td></tr>
    <tr><td>Poshmark fee</td><td style="text-align:right" id="pm-s-fee">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="pm-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of the sale</td><td style="text-align:right" id="pm-s-eff">n/a</td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right" id="pm-s-cost">$0.00</td></tr>
    <tr><td>Profit</td><td style="text-align:right" id="pm-s-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyers pay (item prices)</td><td style="text-align:right" id="pm-m-gross">$0.00</td></tr>
    <tr><td>Poshmark fees</td><td style="text-align:right" id="pm-m-fees">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="pm-m-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of sales</td><td style="text-align:right" id="pm-m-eff">n/a</td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right" id="pm-m-cost">$0.00</td></tr>
    <tr><td>Profit per month</td><td style="text-align:right" id="pm-m-profit">$0.00</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="pm-y-net">$0.00</td></tr>
    <tr><td>Profit per year</td><td style="text-align:right" id="pm-y-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Poshmark's fee (USD)<br><input id="pm-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="pm-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Poshmark US seller fee math (poshmark.com/fee_policy, Fee Policy Version 1.7, effective Nov 25, 2024, checked Oct 29, 2026): "For sales under $15, the fee is a flat rate of $2.95. For sales $15 and above, the fee is 20% and you keep 80%." The fee comes off the final order price. Listing is free. Poshmark doesn't publish a rounding rule; 20% of a whole-cent price never lands on half a cent, so each fee rounds to the nearest cent here. */
(function (root) {
  var CHECKED = "2026-10-29";
  var FLAT = 295, CUTOFF = 1500, PCT = 20, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(x) { return Math.round(x * 100); }
  /* fee in cents on an order price in cents */
  function feeCents(c) { if (c <= 0) return 0; return c < CUTOFF ? FLAT : Math.floor((c * PCT + 50) / 100); }
  function keepCents(c) { return c - feeCents(c); }
  function flat(x) { return cents(amt(x)) < CUTOFF; }
  function calc(x, cost) {
    var price = amt(x), k = amt(cost);
    if (price <= 0) return { price: 0, fee: 0, net: 0, cost: k, profit: r2(-k), effective: null, flat: false };
    var c = cents(price), f = feeCents(c);
    return { price: price, fee: f / 100, net: (c - f) / 100, cost: k, profit: (c - f - cents(k)) / 100, effective: f / c, flat: c < CUTOFF };
  }
  function perMonth(x, q, cost) {
    var s = calc(x, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fee * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12), effective: gross > 0 ? fees / gross : null };
  }
  /* A $15.00 to $15.04 sale keeps less than a $14.99 sale ($15.05 ties it), because the fee jumps from $2.95 to 20%. */
  function cliff(x) { var c = cents(amt(x)); return c >= CUTOFF && keepCents(c) < keepCents(CUTOFF - 1); }
  /* Smallest price (to the cent) that keeps at least T per sale. What you keep is not monotonic across the $15 line, so check the flat-fee band directly and binary search the 20% band, where it never drops. */
  function priceFor(T) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), best = null;
    if (tc + FLAT < CUTOFF) best = tc + FLAT;
    var lo = CUTOFF, hi = MAX_AMT * 100;
    if (keepCents(hi) >= tc) {
      while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (keepCents(mid) >= tc) hi = mid; else lo = mid + 1; }
      if (best === null || lo < best) best = lo;
    }
    return best === null ? null : best / 100;
  }
  var api = { CHECKED: CHECKED, FLAT: FLAT, CUTOFF: CUTOFF, PCT: PCT, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, feeCents: feeCents, flat: flat, calc: calc, perMonth: perMonth, cliff: cliff, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.PoshmarkFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.PoshmarkFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("pm-price").value, q = $("pm-qty").value, k = $("pm-cost").value, w = [];
    var m = B.perMonth(x, q, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the $2.95 fee takes the whole sale or more.");
    if (B.cliff(x)) w.push("A $14.99 sale keeps $12.04, more than this price does, because the fee jumps from $2.95 to 20% at $15. List at $15.06 or more to beat $14.99.");
    $("pm-warn").textContent = w.join(" ");
    set("pm-s-price", money(c.price)); set("pm-s-rate", c.price <= 0 ? "" : c.flat ? "Under $15: flat $2.95" : "$15 and above: 20%"); set("pm-s-fee", money(c.fee)); set("pm-s-net", money(c.net)); set("pm-s-eff", pctS(c.effective)); set("pm-s-cost", money(c.cost)); set("pm-s-profit", money(c.profit));
    set("pm-m-gross", money(m.gross)); set("pm-m-fees", money(m.fees)); set("pm-m-net", money(m.net)); set("pm-m-eff", pctS(m.effective)); set("pm-m-cost", money(m.costs)); set("pm-m-profit", money(m.profit)); set("pm-y-net", money(m.year)); set("pm-y-profit", money(m.yearProfit));
    var T = $("pm-target").value, need = B.priceFor(T);
    set("pm-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Poshmark's fee.");
  }
  ["pm-price", "pm-qty", "pm-cost", "pm-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Poshmark seller fees in the US (checked Oct 29, 2026)

| Sale price | Poshmark fee | You keep |
|---|---|---|
| Under $15 | flat $2.95 | the price minus $2.95 |
| $15 and above | 20% | 80% |
| Listing an item | free | |

The rates are from Poshmark's own [Fee Policy](https://poshmark.com/fee_policy) (Version 1.7, effective November 25, 2024), which says: "For sales under $15, the fee is a flat rate of $2.95. For sales $15 and above, the fee is 20% and you keep 80%." Poshmark's [guide to selling](https://poshmark.com/posh_guide/get_started_on_poshmark) adds that the fee covers the payment processing, a prepaid shipping label and support for the sale, and that you can withdraw your earnings to your bank account for free. The [Poshmark blog](https://blog.poshmark.com/) confirms there are no separate listing fees or monthly costs. A $15.00 sale is in the 20% band. The fee comes off the final order price, so an accepted offer or a price drop changes it. The buyer pays the shipping, and this calculator doesn't model shipping discounts you choose to cover, Posh Credit, Poshmark Canada or wholesale. Poshmark doesn't publish how it rounds a fraction of a cent, so the calculator rounds each fee to the nearest cent and may be a cent off on some prices. Poshmark shows your estimated earnings when you create a listing, and your actual earnings follow the final order price, so check that figure for the final word.

## How the numbers are worked out

```
Poshmark fee = $2.95            if the sale is under $15
             = sale x 20%       if the sale is $15 or more
you keep     = sale - fee
profit       = you keep - what you paid for the item
per month    = you keep x sales per month
```

A $10 sale costs $2.95, so you keep $7.05. A $14.99 sale keeps $12.04, but a $15.00 sale costs $3.00 and keeps only $12.00. A $15.99 sale costs $3.20 and keeps $12.79, a $25 sale keeps $20.00, a $50 sale keeps $40.00 and a $100 sale costs $20.00 and keeps $80.00. At 40 sales of $25 a month you pay $200.00 in fees and keep $800.00, or $9,600.00 a year. If each item cost you $8, your profit is $480.00 a month, or $5,760.00 a year. To keep $20 per sale, list at $25.00. To keep $10, list at $12.95. To keep $50, list at $62.50.

## The $15 price cliff

Because the fee jumps from a flat $2.95 to 20% at $15, prices just above $15 leave you less than $14.99 does. A $14.99 sale keeps $12.04. Every price from $15.00 to $15.04 keeps less than that, $15.05 ties it, and $15.06 is the first price that keeps more ($12.05). Under $15 the flat fee is a large share of a cheap sale: 29.5% of a $10 sale and almost all of a $3 sale. From $15 up it is always 20%, so bundling cheap items into one sale of $15 or more can cut the fee share.

## FAQ

### How much does Poshmark take from a sale in 2026?

In the US, Poshmark takes a flat $2.95 on a sale under $15 and 20% on a sale of $15 or more, so you keep 80%. Listing is free, and there's no monthly fee or separate payment processing fee.

### How much does Poshmark take on a $20 sale?

20%, which is $4.00, so you keep $16.00. On a $10 sale the fee is the flat $2.95, so you keep $7.05.

### Is a $15 sale on Poshmark charged $2.95 or 20%?

20%. Poshmark's fee policy puts sales of $15 and above in the 20% band, so a $15.00 sale costs $3.00 and keeps $12.00, while a $14.99 sale keeps $12.04. You need to list at $15.06 or more to keep more than a $14.99 sale.

### Does the buyer or the seller pay Poshmark's fee?

The seller. Poshmark deducts the fee from the final order price after the item sells, and the buyer pays the shipping on top of the item price.

### What should I list at on Poshmark to keep a set amount?

For $12.04 or less, add $2.95 to what you want to keep. For more, divide what you want to keep by 0.8. Keeping $20 means 20 / 0.8, which gives $25.00. The calculator above finds the exact cent for any amount.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Poshmark take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "In the US, Poshmark takes a flat $2.95 on a sale under $15 and 20% on a sale of $15 or more, so you keep 80%. Listing is free, and there's no monthly fee or separate payment processing fee."}},
{"@type": "Question", "name": "How much does Poshmark take on a $20 sale?", "acceptedAnswer": {"@type": "Answer", "text": "20%, which is $4.00, so you keep $16.00. On a $10 sale the fee is the flat $2.95, so you keep $7.05."}},
{"@type": "Question", "name": "Is a $15 sale on Poshmark charged $2.95 or 20%?", "acceptedAnswer": {"@type": "Answer", "text": "20%. Poshmark's fee policy puts sales of $15 and above in the 20% band, so a $15.00 sale costs $3.00 and keeps $12.00, while a $14.99 sale keeps $12.04. You need to list at $15.06 or more to keep more than a $14.99 sale."}},
{"@type": "Question", "name": "Does the buyer or the seller pay Poshmark's fee?", "acceptedAnswer": {"@type": "Answer", "text": "The seller. Poshmark deducts the fee from the final order price after the item sells, and the buyer pays the shipping on top of the item price."}},
{"@type": "Question", "name": "What should I list at on Poshmark to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "For $12.04 or less, add $2.95 to what you want to keep. For more, divide what you want to keep by 0.8. Keeping $20 means 20 / 0.8, which gives $25.00. The calculator above finds the exact cent for any amount."}}
]}
</script>

## Related tools and guides

- [Etsy fee calculator (2026)](etsy-fee-calculator): Etsy's listing, transaction and payment processing fees on each sale, your profit and margin
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's goods-and-services and checkout fees next to Stripe's card fees, for selling outside a marketplace
- [Shopify fee calculator (2026)](shopify-fee-calculator): Shopify Payments card fees on Basic, Grow and Advanced for your own store
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Poshmark, Inc. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
