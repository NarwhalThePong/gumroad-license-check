---
layout: page
title: "Facebook Marketplace fee calculator (2026): what US sellers keep after the 10% selling fee"
description: "Free Facebook Marketplace fee calculator for US sellers. See the 10% selling fee ($0.80 minimum per order) on shipped orders, charged on the item, shipping and sales tax, what you keep, profit after item cost and the shipping label, monthly and yearly totals and the exact price to keep a set amount. Local pickup sales are free."
---

Facebook Marketplace charges **no fee on local pickup sales**. When you sell **with shipping** through Marketplace checkout, Meta takes a **selling fee of 10% per order, with a $0.80 minimum**, and the 10% is worked out on the whole transaction: the item price, the shipping the buyer pays and the sales tax. A $50 item with $8.00 shipping and 7% sales tax has an order total of $62.06, so the fee is $6.21 and you keep $51.79 before paying for the label. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="fb" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How the item sells<br><select id="fb-mode" style="width:100%;max-width:260px"><option value="ship" selected>Shipped through checkout (10%, $0.80 minimum)</option><option value="local">Local pickup (no fee)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="fb-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="fb-ship" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer's sales tax rate (%)<br><input id="fb-tax" type="number" min="0" step="0.001" value="7" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Orders per month<br><input id="fb-qty" type="number" min="0" step="1" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="fb-cost" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What the shipping label costs you (optional, USD)<br><input id="fb-label" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="fb-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per order</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right"><span id="fb-s-price">$0.00</span></td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right"><span id="fb-s-ship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="fb-s-tax">$0.00</span></td></tr>
    <tr><td>Order total</td><td style="text-align:right"><span id="fb-s-total">$0.00</span></td></tr>
    <tr><td>Selling fee</td><td style="text-align:right"><span id="fb-s-fee">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="fb-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of item + shipping</td><td style="text-align:right"><span id="fb-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="fb-s-cost">$0.00</span></td></tr>
    <tr><td>Shipping label</td><td style="text-align:right"><span id="fb-s-label">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="fb-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales (items + shipping)</td><td style="text-align:right"><span id="fb-m-gross">$0.00</span></td></tr>
    <tr><td>Selling fees</td><td style="text-align:right"><span id="fb-m-fees">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="fb-m-net">$0.00</strong></td></tr>
    <tr><td>Items and labels</td><td style="text-align:right"><span id="fb-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="fb-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="fb-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="fb-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per order after the selling fee (USD)<br><input id="fb-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="fb-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Facebook Marketplace US seller fee math (Facebook Help Center "When you'll get paid for selling with shipping on Facebook Marketplace", facebook.com/help/620680138523186, and Meta's Commerce Merchant Policies "Selling fees", facebook.com/legal/merchant_policies; checked Oct 29, 2026). Shipped orders through checkout: selling fee of 10% per order, minimum $0.80, on the total transaction value (item sale price + shipping fees + applicable taxes). Local pickup sales: no selling fee. Each fee is rounded to the nearest cent, halves up (Meta does not publish its rounding). Promotional rates are not modelled. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, RATE_BP = 1000, MIN_FEE = 80;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxRate(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  /* n / d rounded to an integer, halves up; n, d non-negative integers */
  function half(n, d) { var q = Math.floor(n / d), r = n - q * d; return 2 * r >= d ? q + 1 : q; }
  function opts(mode, tax) { return { mode: mode === "local" ? "local" : "ship", taxm: Math.round(taxRate(tax) * 1000) }; }
  /* c = item price in cents, s = shipping the buyer pays in cents (ignored for local pickup) */
  function parts(c, s, o) {
    if (c <= 0) return { ship: 0, tax: 0, total: 0, fee: 0, keep: 0 };
    if (o.mode === "local") return { ship: 0, tax: 0, total: c, fee: 0, keep: c };
    var tax = half((c + s) * o.taxm, 100000), total = c + s + tax, fee = Math.max(half(total * RATE_BP, 10000), MIN_FEE);
    return { ship: s, tax: tax, total: total, fee: fee, keep: c + s - fee };
  }
  function calc(x, ship, tax, mode, cost, label) {
    var price = amt(x), o = opts(mode, tax), sh = o.mode === "local" ? 0 : amt(ship), k = amt(cost), lb = o.mode === "local" ? 0 : amt(label);
    if (price <= 0) return { price: 0, ship: sh, tax: 0, total: 0, fee: 0, net: 0, cost: k, label: lb, profit: r2(-k - lb), effective: null };
    var c = cents(price), s = cents(sh), p = parts(c, s, o);
    return { price: price, ship: sh, tax: p.tax / 100, total: p.total / 100, fee: p.fee / 100, net: p.keep / 100, cost: k, label: lb, profit: (p.keep - cents(k) - cents(lb)) / 100, effective: p.fee / (c + s) };
  }
  function perMonth(x, q, ship, tax, mode, cost, label) {
    var s = calc(x, ship, tax, mode, cost, label), n = count(q), gross = r2((s.price + s.ship) * n), fees = r2(s.fee * n), net = r2(s.net * n), costs = r2((s.cost + s.label) * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest item price (to the cent) that keeps at least T after the selling fee, with the shipping charge held fixed. A shipped order pays at least $0.80, so keep <= price + shipping - $0.80; scan up from that bound. */
  function priceFor(T, ship, tax, mode) {
    var target = amt(T); if (target <= 0) return null;
    var o = opts(mode, tax), tc = cents(target), s = o.mode === "local" ? 0 : cents(amt(ship)), hi = MAX_AMT * 100, c = Math.max(1, tc - s + (o.mode === "local" ? 0 : MIN_FEE));
    for (; c <= hi; c++) if (parts(c, s, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, RATE_BP: RATE_BP, MIN_FEE: MIN_FEE, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, taxRate: taxRate, half: half, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.FbmFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.FbmFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("fb-price").value, sh = $("fb-ship").value, tx = $("fb-tax").value, md = $("fb-mode").value, q = $("fb-qty").value, k = $("fb-cost").value, lb = $("fb-label").value, w = [];
    var m = B.perMonth(x, q, sh, tx, md, k, lb), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (md === "local" && (B.amt(sh) > 0 || B.amt(lb) > 0)) w.push("Local pickup has no shipping, so shipping and the label are left out.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fee takes the whole sale or more.");
    if (c.price > 0 && c.profit < 0 && c.net > 0) w.push("After the item cost and the label this order loses money.");
    $("fb-warn").textContent = w.join(" ");
    set("fb-s-price", money(c.price)); set("fb-s-ship", money(c.ship)); set("fb-s-tax", money(c.tax)); set("fb-s-total", money(c.total)); set("fb-s-fee", money(c.fee)); set("fb-s-net", money(c.net)); set("fb-s-eff", pctS(c.effective)); set("fb-s-cost", money(c.cost)); set("fb-s-label", money(c.label)); set("fb-s-profit", money(c.profit));
    set("fb-m-gross", money(m.gross)); set("fb-m-fees", money(m.fees)); set("fb-m-net", money(m.net)); set("fb-m-cost", money(m.costs)); set("fb-m-profit", money(m.profit)); set("fb-y-net", money(m.year)); set("fb-y-profit", money(m.yearProfit));
    var T = $("fb-target").value, need = B.priceFor(T, sh, tx, md);
    set("fb-need", B.amt(T) <= 0 ? "Enter how much you want to keep per order." : need == null ? "No price works for that amount." : md === "local" ? "Price the item at " + money(need) + " to keep " + money(B.amt(T)) + ", since local pickup sales have no fee." : "Price the item at " + money(need) + " (plus " + money(B.amt(sh)) + " shipping) to keep " + money(B.amt(T)) + " per order after the selling fee.");
  }
  ["fb-price", "fb-ship", "fb-tax", "fb-mode", "fb-qty", "fb-cost", "fb-label", "fb-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Facebook Marketplace selling fees in the US (checked Oct 29, 2026)

| How the item sells | Selling fee | What the fee is charged on |
|---|---|---|
| Local pickup, paid in person | none | nothing |
| Shipped through Marketplace checkout | 10% per order, $0.80 minimum | item price + shipping the buyer pays + sales tax |

The 10% is charged on the total transaction value, so the sales tax the buyer pays raises your fee even though the tax itself goes to the state. The $0.80 minimum applies to any order whose total is under $8.00. An order is everything shipped together in one transaction, so the minimum is charged once per order, not once per item. The fee comes out of your payout, which starts 15 days after you mark the item shipped or 5 days after delivery is confirmed. Shipped items use a prepaid label from Meta, and what the label costs you is separate from the selling fee, so the calculator lets you enter it.

These figures come from Facebook's own pages: [When you'll get paid for selling with shipping on Facebook Marketplace](https://www.facebook.com/help/620680138523186) in the Facebook Help Center and the selling fees section of Meta's [Commerce Merchant Policies](https://www.facebook.com/legal/merchant_policies). Meta does not publish how it rounds, so the calculator rounds the fee and the sales tax to the nearest cent, with half a cent going up. It treats each order as a single item and assumes sales tax is charged on the item plus shipping at the rate you enter. Facebook only collects sales tax in states with marketplace facilitator laws, so use 0% if no tax is added at checkout. Promotional rates that Meta sometimes offers, boosted listings and any fee your bank or payment provider charges are not included. Your payout breakdown on each order is the final word.

## How the numbers are worked out

```
order total  = item price + shipping the buyer pays + sales tax
selling fee  = 10% x order total, at least $0.80   (local pickup: $0)
you keep     = item price + shipping - selling fee
profit       = you keep - what you paid for the item - the shipping label
```

A $50 item with $8.00 shipping and 7% sales tax has an order total of $62.06. The selling fee is $6.21 and you keep $51.79. Sold for local pickup instead, you keep the full $50.00. A $20 item with $5.00 shipping pays a $2.68 fee and keeps $22.32. A $3 item with free shipping and no tax pays the $0.80 minimum and keeps $2.20. A $200 item with $15.00 shipping and 8.875% tax pays $23.41 and keeps $191.59. At 40 shipped orders a month of $50 items with $8.00 shipping, you pay $248.40 in fees and keep $2,071.60, or $24,859.20 a year. If each item cost you $20.00 and the label costs $8.00, your profit is $951.60 a month, or $11,419.20 a year. To keep $100 with $8.00 shipping and 7% tax, price the item at $103.98. To keep $100 with free shipping and no tax, price it at $111.11.

## FAQ

### How much does Facebook Marketplace take from a sale in 2026?

Nothing on a local pickup sale. On a shipped order through Marketplace checkout, Meta takes 10% of the order total, with a $0.80 minimum. On a $50 item with $8.00 shipping and 7% tax that's $6.21, so you keep $51.79.

### Does Facebook Marketplace charge its fee on shipping and sales tax?

Yes. The 10% selling fee is charged on the total transaction value, which includes the item price, the shipping the buyer pays and the sales tax. That is why the fee on a $50 item with $8.00 shipping and 7% tax is $6.21 rather than $5.00.

### What is the minimum Facebook Marketplace fee?

The selling fee on a shipped order is at least $0.80. It applies whenever the order total is under $8.00, so a $3 item with free shipping and no tax pays $0.80 and keeps $2.20.

### Is selling on Facebook Marketplace free?

Listing an item is free, and so is selling it for local pickup where the buyer pays you in person. The 10% selling fee only applies when the item is sold with shipping through Marketplace checkout. Boosting a listing is a paid ad and is separate from the selling fee.

### What should I price an item at on Facebook Marketplace to keep a set amount?

For a shipped order, divide what you want to keep by 1 minus 10% times (1 plus your tax rate), which is 0.893 at 7% tax, then take away your shipping charge. For $100 with $8.00 shipping that gives $111.98 minus $8.00, so price the item at $103.98, which is also what the calculator above finds to the exact cent.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Facebook Marketplace take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "Nothing on a local pickup sale. On a shipped order through Marketplace checkout, Meta takes 10% of the order total, with a $0.80 minimum. On a $50 item with $8.00 shipping and 7% tax that's $6.21, so you keep $51.79."}},
{"@type": "Question", "name": "Does Facebook Marketplace charge its fee on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. The 10% selling fee is charged on the total transaction value, which includes the item price, the shipping the buyer pays and the sales tax. That is why the fee on a $50 item with $8.00 shipping and 7% tax is $6.21 rather than $5.00."}},
{"@type": "Question", "name": "What is the minimum Facebook Marketplace fee?", "acceptedAnswer": {"@type": "Answer", "text": "The selling fee on a shipped order is at least $0.80. It applies whenever the order total is under $8.00, so a $3 item with free shipping and no tax pays $0.80 and keeps $2.20."}},
{"@type": "Question", "name": "Is selling on Facebook Marketplace free?", "acceptedAnswer": {"@type": "Answer", "text": "Listing an item is free, and so is selling it for local pickup where the buyer pays you in person. The 10% selling fee only applies when the item is sold with shipping through Marketplace checkout. Boosting a listing is a paid ad and is separate from the selling fee."}},
{"@type": "Question", "name": "What should I price an item at on Facebook Marketplace to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "For a shipped order, divide what you want to keep by 1 minus 10% times (1 plus your tax rate), which is 0.893 at 7% tax, then take away your shipping charge. For $100 with $8.00 shipping that gives $111.98 minus $8.00, so price the item at $103.98, which is also what the calculator above finds to the exact cent."}}
]}
</script>

## Related tools and guides

- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping
- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's final value fee for US sellers, which is also charged on shipping and sales tax
- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 under $15 and 20% at $15 and up
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Facebook or Meta. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
