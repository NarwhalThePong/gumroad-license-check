---
layout: page
title: "Discogs fee calculator (2026): what US record sellers keep after the selling fee and PayPal"
description: "Free Discogs fee calculator for US sellers. See the 9% selling fee on item and shipping ($0.10 minimum, $150 maximum per item), the PayPal processing fee on the whole payment including sales tax (3.49% + $0.49, or 2.99% + $0.49 for cards), the 1.50% international fee, what you keep, your profit, monthly and yearly totals and the exact price to keep a set amount."
---

Discogs charges US sellers a **selling fee of 9% on each item's price plus its shipping**, with a **$0.10 minimum** and a **$150 maximum** per item. It isn't charged on sales tax, and listing is free. Payments go through PayPal, which takes its own **processing fee from the whole payment, including sales tax**: **3.49% + $0.49** when the buyer pays with PayPal and **2.99% + $0.49** for a card payment, plus **1.50%** when the buyer is in another country. A $100 record with no shipping or tax costs $9.00 in selling fees and $3.98 in PayPal fees, so you keep $87.02. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="dg" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="dg-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="dg-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your postage cost (USD)<br><input id="dg-label" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax rate (%)<br><input id="dg-tax" type="number" min="0" step="0.001" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="dg-qty" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="dg-cost" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How the buyer pays<br><select id="dg-plan" style="width:100%;max-width:260px"><option value="paypal" selected>PayPal Checkout (3.49% + $0.49)</option><option value="card">Card payment (2.99% + $0.49)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer in another country<br><select id="dg-xb" style="width:100%;max-width:260px"><option value="no" selected>No</option><option value="yes">Yes, add PayPal's 1.50% international fee</option></select></label></p>
  </div>
  <p id="dg-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right"><span id="dg-s-price">$0.00</span></td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right"><span id="dg-s-ship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="dg-s-tax">$0.00</span></td></tr>
    <tr><td>Total order value</td><td style="text-align:right"><span id="dg-s-total">$0.00</span></td></tr>
    <tr><td>Discogs selling fee (9%)</td><td style="text-align:right"><span id="dg-s-sell">$0.00</span></td></tr>
    <tr><td>PayPal processing</td><td style="text-align:right"><span id="dg-s-proc">$0.00</span></td></tr>
    <tr><td>PayPal international fee</td><td style="text-align:right"><span id="dg-s-xb">$0.00</span></td></tr>
    <tr><td>Total fees</td><td style="text-align:right"><span id="dg-s-fees">$0.00</span></td></tr>
    <tr><td>Your postage</td><td style="text-align:right"><span id="dg-s-label">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="dg-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right"><span id="dg-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="dg-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="dg-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right"><span id="dg-m-gross">$0.00</span></td></tr>
    <tr><td>Discogs and PayPal fees</td><td style="text-align:right"><span id="dg-m-fees">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="dg-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="dg-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="dg-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="dg-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="dg-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Discogs and PayPal fees (USD)<br><input id="dg-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="dg-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Discogs US seller fee math (Discogs Support "What Are The Fees For Selling On Discogs?", support.discogs.com/hc/en-us/articles/360007521674; "U.S. Sales Tax In The Discogs Marketplace", support.discogs.com/hc/en-us/articles/360024123194; Discogs selling fee FAQ, discogs.com/selling/updates/selling-fee-faq-2023; PayPal US merchant fees, paypal.com/us/business/paypal-business-fees; checked Oct 29, 2026). Selling fee: 9% of each item's price plus its shipping, not sales tax, minimum $0.10, maximum $150 per item (reached at $1,666.67). PayPal processing is charged on the entire payment including sales tax: 3.49% + $0.49 for PayPal Checkout, 2.99% + $0.49 for card payments, plus 1.50% for a buyer in another country. Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, SELL_BP = 900, SELL_MIN = 10, SELL_MAX = 15000, PROC_FIXED = 49, XB_BP = 150;
  var PLANS = { paypal: { name: "PayPal Checkout", bp: 349 }, card: { name: "Card payment", bp: 299 } };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxPct(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  /* o = { ship: cents the buyer pays for shipping, label: cents you pay to ship, tax: % on item + shipping, plan: how the buyer pays, xb: buyer in another country } */
  function opts(ship, label, tax, plan, xb) { return { ship: cents(amt(ship)), label: cents(amt(label)), tax: taxPct(tax), plan: PLANS[plan] ? plan : "paypal", xb: !!xb }; }
  function parts(c, o) {
    if (c <= 0) return { sub: 0, tax: 0, total: 0, sell: 0, proc: 0, xb: 0, fees: 0, keep: 0 };
    var sub = c + o.ship, sell = Math.min(SELL_MAX, Math.max(SELL_MIN, rnd(sub * SELL_BP / 10000))), tax = rnd(sub * o.tax / 100), total = sub + tax, proc = rnd(total * PLANS[o.plan].bp / 10000) + PROC_FIXED, xb = o.xb ? rnd(total * XB_BP / 10000) : 0, fees = sell + proc + xb;
    return { sub: sub, tax: tax, total: total, sell: sell, proc: proc, xb: xb, fees: fees, keep: sub - fees - o.label };
  }
  function calc(x, ship, label, tax, plan, xb, cost) {
    var price = amt(x), k = amt(cost), o = opts(ship, label, tax, plan, xb);
    if (price <= 0) return { price: 0, ship: o.ship / 100, tax: 0, total: 0, sell: 0, proc: 0, xb: 0, fees: 0, label: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o);
    return { price: price, ship: o.ship / 100, tax: p.tax / 100, total: p.total / 100, sell: p.sell / 100, proc: p.proc / 100, xb: p.xb / 100, fees: p.fees / 100, label: o.label / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fees / c };
  }
  function perMonth(x, q, ship, label, tax, plan, xb, cost) {
    var s = calc(x, ship, label, tax, plan, xb, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fees * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest item price (to the cent) that keeps at least T. Fee rounding and the $0.10 minimum can make keep flat or dip by a cent, so scan up from a safe lower bound (processing alone is at least 2.99% of item + shipping plus $0.49, so keep <= 0.9701 x (item + shipping) - $0.49 - label). */
  function priceFor(T, ship, label, tax, plan, xb) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, label, tax, plan, xb), hi = MAX_AMT * 100, c = Math.max(1, Math.floor((tc + o.label + PROC_FIXED) / 0.9701) - o.ship - 1);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, SELL_BP: SELL_BP, SELL_MIN: SELL_MIN, SELL_MAX: SELL_MAX, PROC_FIXED: PROC_FIXED, XB_BP: XB_BP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.DiscogsFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.DiscogsFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("dg-price").value, sh = $("dg-ship").value, lb = $("dg-label").value, tx = $("dg-tax").value, plan = $("dg-plan").value, xb = $("dg-xb").value === "yes", q = $("dg-qty").value, k = $("dg-cost").value, w = [];
    var m = B.perMonth(x, q, sh, lb, tx, plan, xb, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees and shipping take the whole sale or more.");
    $("dg-warn").textContent = w.join(" ");
    set("dg-s-price", money(c.price)); set("dg-s-ship", money(c.ship)); set("dg-s-tax", money(c.tax)); set("dg-s-total", money(c.total)); set("dg-s-sell", money(c.sell)); set("dg-s-proc", money(c.proc)); set("dg-s-xb", money(c.xb)); set("dg-s-fees", money(c.fees)); set("dg-s-label", money(c.label)); set("dg-s-net", money(c.net)); set("dg-s-eff", pctS(c.effective)); set("dg-s-cost", money(c.cost)); set("dg-s-profit", money(c.profit));
    set("dg-m-gross", money(m.gross)); set("dg-m-fees", money(m.fees)); set("dg-m-net", money(m.net)); set("dg-m-cost", money(m.costs)); set("dg-m-profit", money(m.profit)); set("dg-y-net", money(m.year)); set("dg-y-profit", money(m.yearProfit));
    var T = $("dg-target").value, need = B.priceFor(T, sh, lb, tx, plan, xb);
    set("dg-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "Sell at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Discogs and PayPal fees" + (B.amt(lb) > 0 ? " and your postage." : "."));
  }
  ["dg-price", "dg-ship", "dg-label", "dg-tax", "dg-qty", "dg-cost", "dg-plan", "dg-xb", "dg-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Discogs seller fees in the US (checked Oct 29, 2026)

| Fee | Rate | Charged on |
|---|---|---|
| Discogs selling fee | 9%, $0.10 minimum, $150 maximum per item | Each item's price plus its shipping, not sales tax |
| PayPal processing (PayPal Checkout) | 3.49% + $0.49 per payment | The whole payment, including shipping and sales tax |
| PayPal processing (card payment) | 2.99% + $0.49 per payment | The whole payment, including shipping and sales tax |
| PayPal international fee | 1.50% | The whole payment, when the buyer is in another country |
| Listing an item | Free | No listing or monthly fees |

The $150 cap on the selling fee is reached at about $1,667 of item and shipping, so a rarer pressing above that still pays $150. Both fees come out of the buyer's payment before it reaches you: PayPal shows Discogs' share as a "Partner Fee" (or "Partner Commission"), which also holds any sales tax Discogs collects for the state, and PayPal's own cut as "Fee". The calculator works out one item per order. On a multi-item order the selling fee and its minimum and maximum still apply to each item, but PayPal's $0.49 is charged once per payment.

These figures come from Discogs' and PayPal's own pages: [What Are The Fees For Selling On Discogs?](https://support.discogs.com/hc/en-us/articles/360007521674-What-Are-The-Fees-For-Selling-On-Discogs), [U.S. Sales Tax In The Discogs Marketplace](https://support.discogs.com/hc/en-us/articles/360024123194-U-S-Sales-Tax-In-The-Discogs-Marketplace), [Discogs' selling fee FAQ](https://www.discogs.com/selling/updates/selling-fee-faq-2023/) and [PayPal's US merchant fees](https://www.paypal.com/us/business/paypal-business-fees). Discogs says its fee is "calculated on an individual item's price and its shipping cost" and that "PayPal processing fees are assessed on the entire transaction amount, which includes sales tax." The calculator assumes sales tax is charged on the item and shipping, that the shipping the buyer pays comes to you and your postage goes out, and that each fee rounds to the nearest cent. Your PayPal activity and Discogs' Monthly Platform Fee Statement show the exact fees on each order, so check them for the final word.

## How the numbers are worked out

```
selling fee  = 9% x (item price + shipping the buyer pays), at least $0.10, at most $150
PayPal fee   = 3.49% x (item price + shipping + sales tax) + $0.49   (2.99% for card payments)
intl fee     = 1.50% x (item price + shipping + sales tax), only for buyers in another country
you keep     = item price + shipping the buyer pays - fees - your postage
profit       = you keep - what you paid for the item
```

With no shipping or tax, a $100 record keeps $87.02, a $25 LP costs $2.25 plus $1.36 and keeps $21.39, and a $1,000 sale costs $90.00 plus $35.39 and keeps $874.61, about 87.5% of the price. A $1 single hits the $0.10 minimum and keeps $0.38. A $2,000 sale pays the $150 maximum plus $70.29 to PayPal and keeps $1,779.71. Sell a $25 LP with $5 shipping charged and $4.50 postage and you keep $21.26; add 8% sales tax and the PayPal fee rises to $1.62, so you keep $21.18. Paid by card, a $100 sale keeps $87.52 instead of $87.02, and a buyer in another country costs an extra $1.50, so you keep $85.52. At 40 sales of that $25 LP a month you pay $169.60 in fees and keep $850.40, or $10,204.80 a year. If each record cost you $8, your profit is $530.40 a month, or $6,364.80 a year. To keep $100 per sale with no shipping or tax, sell at $114.83. To keep $20 on an LP with $5 shipping and $4.50 postage, sell at $23.56.

## FAQ

### How much does Discogs take from a sale in 2026?

A 9% selling fee on the item and its shipping, plus PayPal's 3.49% + $0.49 processing fee. On a $100 sale with no shipping or tax that's $9.00 plus $3.98, so you keep $87.02.

### Does Discogs charge fees on shipping and sales tax?

The 9% selling fee is charged on the item price plus shipping, but not on sales tax. PayPal's processing fee is charged on the whole payment, including shipping and sales tax.

### What is the maximum Discogs selling fee?

$150 per item in US dollars, which is 9% of about $1,667. The minimum is $0.10 per item. Both limits apply to each item, not to the order total.

### Why is the Partner Fee in PayPal bigger than 9%?

PayPal's "Partner Fee" line bundles Discogs' 9% selling fee with any sales tax or VAT that Discogs collects and pays to the government for the order. The sales tax was never yours to keep, so the fee itself is still 9% of item plus shipping.

### What should I sell at on Discogs to keep a set amount?

With no shipping or tax and a PayPal payment, add $0.49 to what you want to keep and divide by 0.8751. For $100 that gives $114.83. The calculator above finds the exact cent for any shipping, postage, sales tax and payment type.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Discogs take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "A 9% selling fee on the item and its shipping, plus PayPal's 3.49% + $0.49 processing fee. On a $100 sale with no shipping or tax that's $9.00 plus $3.98, so you keep $87.02."}},
{"@type": "Question", "name": "Does Discogs charge fees on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "The 9% selling fee is charged on the item price plus shipping, but not on sales tax. PayPal's processing fee is charged on the whole payment, including shipping and sales tax."}},
{"@type": "Question", "name": "What is the maximum Discogs selling fee?", "acceptedAnswer": {"@type": "Answer", "text": "$150 per item in US dollars, which is 9% of about $1,667. The minimum is $0.10 per item. Both limits apply to each item, not to the order total."}},
{"@type": "Question", "name": "Why is the Partner Fee in PayPal bigger than 9%?", "acceptedAnswer": {"@type": "Answer", "text": "PayPal's \"Partner Fee\" line bundles Discogs' 9% selling fee with any sales tax or VAT that Discogs collects and pays to the government for the order. The sales tax was never yours to keep, so the fee itself is still 9% of item plus shipping."}},
{"@type": "Question", "name": "What should I sell at on Discogs to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "With no shipping or tax and a PayPal payment, add $0.49 to what you want to keep and divide by 0.8751. For $100 that gives $114.83. The calculator above finds the exact cent for any shipping, postage, sales tax and payment type."}}
]}
</script>

## Related tools and guides

- [Reverb fee calculator (2026)](reverb-fee-calculator): Reverb's 5% selling fee on item and shipping plus 3.19% + $0.49 processing, for selling records and gear on Reverb instead
- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 15.3% final value fee for books, movies and music plus $0.30 or $0.40 per order, charged on shipping and sales tax too
- [Bandcamp fee calculator (2026)](bandcamp-fee-calculator): Bandcamp's 15% or 10% revenue share on digital and physical music sales
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): the PayPal fees behind every Discogs payment
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Discogs or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
