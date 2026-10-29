---
layout: page
title: "Reverb fee calculator (2026): what US sellers keep after selling and processing fees"
description: "Free Reverb fee calculator for US sellers. See the 5% selling fee on item and shipping ($0.50 minimum, $500 maximum), the 3.19% + $0.49 Reverb Payments processing fee on item, shipping and tax (2.99% for Preferred Sellers), the 1% cross-border fee, what you keep, your profit, monthly and yearly totals and the exact price to keep a set amount."
---

Reverb charges US sellers two fees on each order. The **selling fee** is **5% of the total sale amount, including shipping** but not sales tax, with a **$0.50 minimum** and a **$500 maximum**. The **payment processing fee** for Reverb Payments is **3.19% of the full order amount, including shipping and sales tax, plus $0.49** per order (**2.99% + $0.49** for Preferred Sellers). Listing is free. A $100 sale with no shipping or tax costs $5.00 in selling fees and $3.68 in processing, so you keep $91.32. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="rv" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="rv-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="rv-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your shipping label cost (USD)<br><input id="rv-label" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax rate (%)<br><input id="rv-tax" type="number" min="0" step="0.001" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="rv-qty" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="rv-cost" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Seller status<br><select id="rv-plan" style="width:100%;max-width:260px"><option value="standard" selected>Standard (3.19% + $0.49)</option><option value="preferred">Preferred Seller (2.99% + $0.49)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer in another country<br><select id="rv-xb" style="width:100%;max-width:260px"><option value="no" selected>No</option><option value="yes">Yes, add the 1% cross-border fee</option></select></label></p>
  </div>
  <p id="rv-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right"><span id="rv-s-price">$0.00</span></td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right"><span id="rv-s-ship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="rv-s-tax">$0.00</span></td></tr>
    <tr><td>Total order value</td><td style="text-align:right"><span id="rv-s-total">$0.00</span></td></tr>
    <tr><td>Selling fee (5%)</td><td style="text-align:right"><span id="rv-s-sell">$0.00</span></td></tr>
    <tr><td>Payment processing</td><td style="text-align:right"><span id="rv-s-proc">$0.00</span></td></tr>
    <tr><td>Cross-border fee</td><td style="text-align:right"><span id="rv-s-xb">$0.00</span></td></tr>
    <tr><td>Total Reverb fees</td><td style="text-align:right"><span id="rv-s-fees">$0.00</span></td></tr>
    <tr><td>Your shipping label</td><td style="text-align:right"><span id="rv-s-label">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="rv-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right"><span id="rv-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="rv-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="rv-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right"><span id="rv-m-gross">$0.00</span></td></tr>
    <tr><td>Reverb fees</td><td style="text-align:right"><span id="rv-m-fees">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="rv-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="rv-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="rv-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="rv-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="rv-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Reverb's fees (USD)<br><input id="rv-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="rv-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Reverb US seller fee math (Reverb Help Center "What fees will I pay for selling on Reverb?", help.reverb.com/hc/en-us/articles/40917652290843; "What is a payment processing fee?", help.reverb.com/hc/en-us/articles/41988540155931; Reverb's Billing Policy, reverb.com/legal/reverbs-billing-policy; checked Oct 29, 2026). Selling fee: 5% of the total sale amount including shipping (not sales tax), minimum $0.50, maximum $500 (reached at a $10,000 sale). Reverb Payments processing: 3.19% of the full order amount including shipping and sales tax, plus $0.49 per transaction (Preferred Sellers 2.99% + $0.49). Cross-border: an extra 1% of the transaction total when buyer and seller are in different countries. Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, SELL_BP = 500, SELL_MIN = 50, SELL_MAX = 50000, PROC_FIXED = 49, XB_BP = 100;
  var PLANS = { standard: { name: "Standard seller", bp: 319 }, preferred: { name: "Preferred Seller", bp: 299 } };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxPct(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  /* o = { ship: cents the buyer pays for shipping, label: cents you pay for the label, tax: % on item + shipping, plan, xb: cross-border } */
  function opts(ship, label, tax, plan, xb) { return { ship: cents(amt(ship)), label: cents(amt(label)), tax: taxPct(tax), plan: PLANS[plan] ? plan : "standard", xb: !!xb }; }
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
  /* Smallest item price (to the cent) that keeps at least T. Fee rounding and the $0.50 minimum can make keep flat or dip by a cent, so scan up from a safe lower bound (processing alone is at least 2.99% of item + shipping plus $0.49, so keep <= 0.9701 x (item + shipping) - $0.49 - label). */
  function priceFor(T, ship, label, tax, plan, xb) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, label, tax, plan, xb), hi = MAX_AMT * 100, c = Math.max(1, Math.floor((tc + o.label + PROC_FIXED) / 0.9701) - o.ship - 1);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, SELL_BP: SELL_BP, SELL_MIN: SELL_MIN, SELL_MAX: SELL_MAX, PROC_FIXED: PROC_FIXED, XB_BP: XB_BP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.ReverbFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.ReverbFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("rv-price").value, sh = $("rv-ship").value, lb = $("rv-label").value, tx = $("rv-tax").value, plan = $("rv-plan").value, xb = $("rv-xb").value === "yes", q = $("rv-qty").value, k = $("rv-cost").value, w = [];
    var m = B.perMonth(x, q, sh, lb, tx, plan, xb, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees and shipping take the whole sale or more.");
    $("rv-warn").textContent = w.join(" ");
    set("rv-s-price", money(c.price)); set("rv-s-ship", money(c.ship)); set("rv-s-tax", money(c.tax)); set("rv-s-total", money(c.total)); set("rv-s-sell", money(c.sell)); set("rv-s-proc", money(c.proc)); set("rv-s-xb", money(c.xb)); set("rv-s-fees", money(c.fees)); set("rv-s-label", money(c.label)); set("rv-s-net", money(c.net)); set("rv-s-eff", pctS(c.effective)); set("rv-s-cost", money(c.cost)); set("rv-s-profit", money(c.profit));
    set("rv-m-gross", money(m.gross)); set("rv-m-fees", money(m.fees)); set("rv-m-net", money(m.net)); set("rv-m-cost", money(m.costs)); set("rv-m-profit", money(m.profit)); set("rv-y-net", money(m.year)); set("rv-y-profit", money(m.yearProfit));
    var T = $("rv-target").value, need = B.priceFor(T, sh, lb, tx, plan, xb);
    set("rv-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "Sell at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Reverb's fees" + (B.amt(lb) > 0 ? " and your shipping label." : "."));
  }
  ["rv-price", "rv-ship", "rv-label", "rv-tax", "rv-qty", "rv-cost", "rv-plan", "rv-xb", "rv-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Reverb seller fees in the US (checked Oct 29, 2026)

| Fee | Rate | Charged on |
|---|---|---|
| Selling fee | 5%, $0.50 minimum, $500 maximum | Item price plus shipping, not sales tax |
| Payment processing (Reverb Payments) | 3.19% + $0.49 per order | Item price, shipping and sales tax |
| Payment processing (Preferred Seller) | 2.99% + $0.49 per order | Item price, shipping and sales tax |
| Cross-border fee | 1% | The order total, when buyer and seller are in different countries |
| Listing an item | Free | No listing, renewal or monthly fees |

The $500 cap on the selling fee is reached at a $10,000 sale, so anything above that still pays $500. Both fees come out of your payout. Bumps (paid promotion), Reverb shipping labels, Reverb Safe Shipping (1.5% to 3% of the item's value) and the 2.5% currency conversion fee for listing in another currency are optional extras and aren't in the calculator. If you take PayPal instead of Reverb Payments, PayPal charges its own processing fee in place of Reverb's.

These figures come from Reverb's own pages: [What fees will I pay for selling on Reverb?](https://help.reverb.com/hc/en-us/articles/40917652290843-What-fees-will-I-pay-for-selling-on-Reverb), [What is a payment processing fee?](https://help.reverb.com/hc/en-us/articles/41988540155931-What-is-a-payment-processing-fee) and [Reverb's Billing Policy](https://reverb.com/legal/reverbs-billing-policy). Reverb says the selling fee "is assessed off of the total sale amount (including shipping)" and that the processing fee "is calculated from the order's total sale price, including shipping fees and any applicable taxes." The calculator assumes sales tax is charged on the item and shipping, that the shipping the buyer pays comes to you and the label cost goes out, and that each fee rounds to the nearest cent. Your Earnings page on Reverb shows the exact fees withheld from each payout, so check it for the final word.

## How the numbers are worked out

```
selling fee  = 5% x (item price + shipping the buyer pays), at least $0.50, at most $500
processing   = 3.19% x (item price + shipping + sales tax) + $0.49   (2.99% for Preferred Sellers)
cross-border = 1% x (item price + shipping + sales tax), only for buyers in another country
you keep     = item price + shipping the buyer pays - fees - your shipping label
profit       = you keep - what you paid for the item
```

With no shipping or tax, a $100 sale keeps $91.32, a $650 guitar costs $32.50 plus $21.23 and keeps $596.27, and a $1,000 sale costs $50.00 plus $32.39 and keeps $917.61, about 91.8% of the price. A $5 item hits the $0.50 minimum and keeps $3.85. A $12,000 sale pays the $500 maximum plus $383.29 in processing and keeps $11,116.71. Sell a $500 amp with $25 shipping charged and a $20 label and you keep $461.51; add 8% sales tax and processing rises to $18.58, so you keep $460.17. A Preferred Seller keeps $459.56 on a $500 sale instead of $458.56, and a buyer in another country costs an extra $5.00, so you keep $453.56. At 20 sales of $100 a month you pay $173.60 in fees and keep $1,826.40, or $21,916.80 a year. If each item cost you $40, your profit is $1,026.40 a month, or $12,316.80 a year. To keep $100 per sale with no shipping or tax, sell at $109.45. To keep $500, sell at $545.14.

## FAQ

### How much does Reverb take from a sale in 2026?

A 5% selling fee plus 3.19% + $0.49 for payment processing. On a $100 sale with no shipping or tax that's $5.00 plus $3.68, so you keep $91.32.

### Does Reverb charge fees on shipping and sales tax?

The 5% selling fee is charged on the item price plus shipping, but not on sales tax. The processing fee is charged on the whole order, including shipping and sales tax.

### What is the maximum Reverb selling fee?

$500 in the US, which is 5% of a $10,000 sale. Sales above $10,000 still pay $500, though processing keeps growing with the price. The minimum selling fee is $0.50.

### How do I get lower Reverb fees?

Preferred Sellers pay 2.99% + $0.49 for processing instead of 3.19% + $0.49. The 5% selling fee is the same for everyone, and listing is always free.

### What should I sell at on Reverb to keep a set amount?

With no shipping or tax, add $0.49 to what you want to keep and divide by 0.9181. For $100 that gives $109.45. The calculator above finds the exact cent for any shipping, label cost, sales tax and seller status.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Reverb take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "A 5% selling fee plus 3.19% + $0.49 for payment processing. On a $100 sale with no shipping or tax that's $5.00 plus $3.68, so you keep $91.32."}},
{"@type": "Question", "name": "Does Reverb charge fees on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "The 5% selling fee is charged on the item price plus shipping, but not on sales tax. The processing fee is charged on the whole order, including shipping and sales tax."}},
{"@type": "Question", "name": "What is the maximum Reverb selling fee?", "acceptedAnswer": {"@type": "Answer", "text": "$500 in the US, which is 5% of a $10,000 sale. Sales above $10,000 still pay $500, though processing keeps growing with the price. The minimum selling fee is $0.50."}},
{"@type": "Question", "name": "How do I get lower Reverb fees?", "acceptedAnswer": {"@type": "Answer", "text": "Preferred Sellers pay 2.99% + $0.49 for processing instead of 3.19% + $0.49. The 5% selling fee is the same for everyone, and listing is always free."}},
{"@type": "Question", "name": "What should I sell at on Reverb to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "With no shipping or tax, add $0.49 to what you want to keep and divide by 0.9181. For $100 that gives $109.45. The calculator above finds the exact cent for any shipping, label cost, sales tax and seller status."}}
]}
</script>

## Related tools and guides

- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 13.6% final value fee for most categories plus $0.30 or $0.40 per order, charged on shipping and sales tax too
- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping
- [Whatnot fee calculator (2026)](whatnot-fee-calculator): Whatnot's 8% commission on the item price only plus 2.9% + $0.30 processing, with lower rates as your sales grow
- [Discogs fee calculator (2026)](discogs-fee-calculator): Discogs' 9% selling fee on item and shipping ($0.10 minimum, $150 maximum per item) plus PayPal's 3.49% + $0.49 on the whole payment, for record sellers
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Reverb. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
