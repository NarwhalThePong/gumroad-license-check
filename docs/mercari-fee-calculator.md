---
layout: page
title: "Mercari fee calculator (2026): what US sellers keep after the 10% selling fee"
description: "Free Mercari fee calculator for US sellers. See the 10% selling fee on the item price and buyer-paid shipping, what you keep with buyer-paid or seller-paid shipping, your profit, monthly and yearly totals with Instant Pay, and the exact price to list at to keep a set amount."
---

Mercari charges US sellers a **10% selling fee** on the item price plus any shipping the buyer pays. Since January 6, 2025 there's no separate payment processing fee, and the buyer pays a 3.6% Buyer Protection fee on top, which doesn't come out of your money. That means a $25 sale with free shipping for the buyer leaves you $22.50 before postage, and a $100 sale leaves you $90.00. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="mc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="mc-price" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping label cost (USD)<br><input id="mc-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Who pays shipping<br><select id="mc-who" style="width:100%;max-width:200px"><option value="buyer" selected>The buyer</option><option value="seller">Me (free shipping for the buyer)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="mc-qty" type="number" min="0" step="1" value="40" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="mc-cost" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant Pay cash-outs per month ($3 each)<br><input id="mc-instant" type="number" min="0" max="31" step="1" value="0" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="mc-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right" id="mc-s-price">$0.00</td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right" id="mc-s-bship">$0.00</td></tr>
    <tr><td>Buyer Protection fee the buyer pays (3.6%)</td><td style="text-align:right" id="mc-s-bfee">$0.00</td></tr>
    <tr><td>Buyer pays in total, before sales tax</td><td style="text-align:right" id="mc-s-buyer">$0.00</td></tr>
    <tr><td>Selling fee (10%)</td><td style="text-align:right" id="mc-s-fee">$0.00</td></tr>
    <tr><td>Shipping label you pay</td><td style="text-align:right" id="mc-s-label">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="mc-s-net">$0.00</strong></td></tr>
    <tr><td>Selling fee as a share of the item price</td><td style="text-align:right" id="mc-s-eff">n/a</td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right" id="mc-s-cost">$0.00</td></tr>
    <tr><td>Profit</td><td style="text-align:right" id="mc-s-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right" id="mc-m-gross">$0.00</td></tr>
    <tr><td>Selling fees</td><td style="text-align:right" id="mc-m-fees">$0.00</td></tr>
    <tr><td>Shipping labels you pay</td><td style="text-align:right" id="mc-m-labels">$0.00</td></tr>
    <tr><td>Instant Pay fees</td><td style="text-align:right" id="mc-m-instant">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="mc-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right" id="mc-m-cost">$0.00</td></tr>
    <tr><td>Profit per month</td><td style="text-align:right" id="mc-m-profit">$0.00</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="mc-y-net">$0.00</td></tr>
    <tr><td>Profit per year</td><td style="text-align:right" id="mc-y-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Mercari's fee and shipping (USD)<br><input id="mc-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="mc-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Mercari US seller fee math (Mercari Help "Fees on Mercari", article 169, updated 10/23/2026, and "FAQs about our new fee structure", article 2518; checked Oct 29, 2026): for listings created or updated on or after January 6, 2025, a 10% selling fee on the item price plus buyer-paid shipping, no payment processing fee, and a 3.6% Buyer Protection fee paid by the buyer on the item price plus buyer-paid shipping. Direct deposit cash-outs are free; Instant Pay costs $3 per cash-out. Mercari doesn't publish a rounding rule; each fee rounds to the nearest cent here (half a cent rounds up). */
(function (root) {
  var CHECKED = "2026-10-29";
  var SELL_PCT = 10, BUYER_PERMILLE = 36, INSTANT_FEE = 300, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(x) { return Math.round(x * 100); }
  /* all amounts in cents; o = { ship: cents, sellerShips: bool (seller pays the shipping label) } */
  function parts(c, o) {
    if (c <= 0) return { base: 0, fee: 0, buyerFee: 0, label: 0, keep: 0 };
    var base = c + (o.sellerShips ? 0 : o.ship);
    var fee = Math.floor((base * SELL_PCT + 50) / 100);
    var buyerFee = Math.floor((base * BUYER_PERMILLE + 500) / 1000);
    var label = o.sellerShips ? o.ship : 0;
    return { base: base, fee: fee, buyerFee: buyerFee, label: label, keep: c - fee - label };
  }
  function opts(ship, sellerShips) { return { ship: cents(amt(ship)), sellerShips: !!sellerShips }; }
  function calc(x, ship, sellerShips, cost) {
    var price = amt(x), k = amt(cost), o = opts(ship, sellerShips);
    if (price <= 0) return { price: 0, ship: o.ship / 100, buyerShip: 0, buyerFee: 0, buyerPays: 0, fee: 0, label: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o), bs = o.sellerShips ? 0 : o.ship;
    return { price: price, ship: o.ship / 100, buyerShip: bs / 100, buyerFee: p.buyerFee / 100, buyerPays: (c + bs + p.buyerFee) / 100, fee: p.fee / 100, label: p.label / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fee / c };
  }
  function perMonth(x, q, ship, sellerShips, cost, cashouts) {
    var s = calc(x, ship, sellerShips, cost), n = count(q), co = Math.min(count(cashouts), 31), gross = r2(s.price * n), fees = r2(s.fee * n), labels = r2(s.label * n), instant = co * INSTANT_FEE / 100;
    var net = r2(s.net * n - instant), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, cashouts: co, gross: gross, fees: fees, labels: labels, instant: instant, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12), effective: gross > 0 ? fees / gross : null };
  }
  /* Smallest item price (to the cent) that keeps at least T per sale. keep(c) >= 0.9c - 0.1*ship - label - 1, and keep(c) <= 0.9c + 1, so start below the answer and step up one cent at a time. */
  function priceFor(T, ship, sellerShips) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, sellerShips), hi = MAX_AMT * 100;
    var extra = o.sellerShips ? o.ship : 0.1 * o.ship;
    var c = Math.max(1, Math.floor((tc + extra - 2) / 0.9) - 1);
    if (parts(hi, o).keep < tc) return null;
    while (c <= hi && parts(c, o).keep < tc) c++;
    return c > hi ? null : c / 100;
  }
  var api = { CHECKED: CHECKED, SELL_PCT: SELL_PCT, BUYER_PERMILLE: BUYER_PERMILLE, INSTANT_FEE: INSTANT_FEE, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, parts: parts, opts: opts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.MercariFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.MercariFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("mc-price").value, sh = $("mc-ship").value, seller = $("mc-who").value === "seller", q = $("mc-qty").value, k = $("mc-cost").value, io = $("mc-instant").value, w = [];
    var m = B.perMonth(x, q, sh, seller, k, io), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (Number(io) > 31) w.push("Instant Pay works once a day, so cash-outs are capped at 31 a month.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fee and shipping take the whole sale or more.");
    $("mc-warn").textContent = w.join(" ");
    set("mc-s-price", money(c.price)); set("mc-s-bship", money(c.buyerShip)); set("mc-s-bfee", money(c.buyerFee)); set("mc-s-buyer", money(c.buyerPays)); set("mc-s-fee", money(c.fee)); set("mc-s-label", money(c.label)); set("mc-s-net", money(c.net)); set("mc-s-eff", pctS(c.effective)); set("mc-s-cost", money(c.cost)); set("mc-s-profit", money(c.profit));
    set("mc-m-gross", money(m.gross)); set("mc-m-fees", money(m.fees)); set("mc-m-labels", money(m.labels)); set("mc-m-instant", money(m.instant)); set("mc-m-net", money(m.net)); set("mc-m-cost", money(m.costs)); set("mc-m-profit", money(m.profit)); set("mc-y-net", money(m.year)); set("mc-y-profit", money(m.yearProfit));
    var T = $("mc-target").value, need = B.priceFor(T, sh, seller);
    set("mc-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Mercari's fee" + (seller && B.amt(sh) > 0 ? " and the shipping label." : "."));
  }
  ["mc-price", "mc-ship", "mc-who", "mc-qty", "mc-cost", "mc-instant", "mc-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Mercari seller fees in the US (checked Oct 29, 2026)

| Fee | Amount | Who pays | Charged on |
|---|---|---|---|
| Listing | free | | |
| Selling fee | 10% | seller | the item price plus buyer-paid shipping |
| Payment processing fee | none (since Jan 6, 2025) | | |
| Buyer Protection fee | 3.6% | buyer | the item price plus buyer-paid shipping |
| Direct deposit cash-out | free | seller | each cash-out ($2 only if a deposit fails) |
| Instant Pay cash-out | $3 | seller | each cash-out, up to $600 a month |

The rates are from Mercari's own help page, [Fees on Mercari](https://www.mercari.com/us/help_center/article/169/) (updated 10/23/2026), which says "Effective January 6, 2025, a 10% selling fee will apply to item price and buyer-paid shipping for new and updated listings" and "No separate payment processing fee will be applied after this date." Mercari's [FAQs about the new fee structure](https://www.mercari.com/us/help_center/article/2518/) sum it up as "Sellers will pay a flat 10% selling fee on the completed item price and buyer-paid shipping" and "Buyers will pay a flat 3.6% Buyer Protection fee". The same fees page says direct deposit no longer has a $2 fee per cash-out and that Instant Pay costs "a $3 flat fee per cash-out". If you offer free shipping, the label cost comes out of your earnings, and because the buyer isn't paying shipping, the 10% is charged on the item price only. Mercari doesn't publish how it rounds a fraction of a cent, so the calculator rounds the fee to the nearest cent and may be a cent off on some prices. This page covers Mercari US only, for listings created or updated since January 6, 2025. Your sale details in the Mercari app show the exact fee, so check them for the final word.

## How the numbers are worked out

```
selling fee   = (item price + shipping the buyer pays) x 10%
you keep      = item price - selling fee                     (buyer pays shipping)
              = item price - selling fee - label cost        (you pay shipping)
buyer pays    = item price + buyer shipping + 3.6% Buyer Protection (+ sales tax)
per month     = you keep x sales - $3 x Instant Pay cash-outs
profit        = you keep - what you paid for the item
```

With no shipping, a $10 sale costs $1.00 and keeps $9.00, a $25 sale costs $2.50 and keeps $22.50, a $50 sale costs $5.00 and keeps $45.00 and a $100 sale costs $10.00 and keeps $90.00. Buyer-paid shipping is charged too: a $25 item with a $7.99 label paid by the buyer costs $3.30 and keeps $21.70. If you pay that $7.99 label yourself, the fee drops to $2.50 but you keep only $14.51. At 40 sales of $25 a month with buyer-paid shipping you pay $100.00 in fees and keep $900.00, or $10,800.00 a year. If each item cost you $8, your profit is $580.00 a month, or $6,960.00 a year. Four Instant Pay cash-outs a month cut that to $888.00 kept, or $10,656.00 a year. To keep $20 per sale, list at $22.22. To keep $50, list at $55.56. To keep $20 after paying a $7.99 label yourself, list at $31.10.

## Free shipping or buyer-paid shipping?

Offering free shipping costs you the whole label, but the 10% fee is then charged on the item price only, so you save 10% of the label in fees. On a $25 item with a $7.99 label, buyer-paid shipping keeps $21.70 and free shipping keeps $14.51. To end up with the same $20 either way, you'd list at $23.11 with buyer-paid shipping or $31.10 with free shipping, so free shipping needs a price about $8 higher.

## FAQ

### How much does Mercari take from a sale in 2026?

Mercari takes a 10% selling fee on the item price plus any shipping the buyer pays. There's no payment processing fee on listings created or updated since January 6, 2025, and the 3.6% Buyer Protection fee is paid by the buyer.

### How much does Mercari take on a $25 sale?

With no shipping, the 10% selling fee is $2.50, so you keep $22.50. If the buyer also paid $7.99 for shipping, the fee is $3.30 and you keep $21.70.

### Does Mercari still charge a payment processing fee?

No, not on listings created or updated since January 6, 2025. Older listings that were never updated kept the old structure, with a 2.9% + $0.50 payment processing fee charged to the buyer, until they were updated.

### Does Mercari charge a fee on shipping?

Yes, when the buyer pays for shipping. The 10% selling fee is charged on the item price plus buyer-paid shipping. If you offer free shipping, the fee is charged on the item price only, but the label cost comes out of your earnings.

### What should I list at on Mercari to keep a set amount?

With buyer-paid or no shipping, divide what you want to keep by 0.9. Keeping $20 means 20 / 0.9, which comes to $22.22. If you pay for shipping, add the label cost first, so keeping $20 after a $7.99 label means 27.99 / 0.9, or $31.10. The calculator above finds the exact cent for any amount.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Mercari take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "Mercari takes a 10% selling fee on the item price plus any shipping the buyer pays. There's no payment processing fee on listings created or updated since January 6, 2025, and the 3.6% Buyer Protection fee is paid by the buyer."}},
{"@type": "Question", "name": "How much does Mercari take on a $25 sale?", "acceptedAnswer": {"@type": "Answer", "text": "With no shipping, the 10% selling fee is $2.50, so you keep $22.50. If the buyer also paid $7.99 for shipping, the fee is $3.30 and you keep $21.70."}},
{"@type": "Question", "name": "Does Mercari still charge a payment processing fee?", "acceptedAnswer": {"@type": "Answer", "text": "No, not on listings created or updated since January 6, 2025. Older listings that were never updated kept the old structure, with a 2.9% + $0.50 payment processing fee charged to the buyer, until they were updated."}},
{"@type": "Question", "name": "Does Mercari charge a fee on shipping?", "acceptedAnswer": {"@type": "Answer", "text": "Yes, when the buyer pays for shipping. The 10% selling fee is charged on the item price plus buyer-paid shipping. If you offer free shipping, the fee is charged on the item price only, but the label cost comes out of your earnings."}},
{"@type": "Question", "name": "What should I list at on Mercari to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "With buyer-paid or no shipping, divide what you want to keep by 0.9. Keeping $20 means 20 / 0.9, which comes to $22.22. If you pay for shipping, add the label cost first, so keeping $20 after a $7.99 label means 27.99 / 0.9, or $31.10. The calculator above finds the exact cent for any amount."}}
]}
</script>

## Related tools and guides

- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 fee under $15 or 20% from $15, and the $15 price cliff
- [Depop fee calculator (2026)](depop-fee-calculator): Depop's 3.3% + $0.45 processing fee with no selling fee for US sellers, plus 12% on boosted sales
- [Grailed fee calculator (2026)](grailed-fee-calculator): Grailed's 6% or 9% seller commission plus 3.49% + $0.49 processing, Grailed Label versus your own label, and the $120 price line
- [Etsy fee calculator (2026)](etsy-fee-calculator): Etsy's listing, transaction and payment processing fees on each sale, your profit and margin
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Mercari. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
