---
layout: page
title: "eBay fee calculator (2026): what US sellers keep after final value fees"
description: "Free eBay fee calculator for US sellers without an eBay Store. See the final value fee for your category (13.6% for most), the $0.30 or $0.40 per order fee, sales tax and shipping in the fee, the 1.65% international fee, what you keep, your profit, monthly and yearly totals and the exact price to list at to keep a set amount."
---

eBay charges US sellers one **final value fee** when an item sells: a percentage of the **total amount of the sale**, which includes the item price, the shipping you charge and the sales tax, plus a **per order fee** of **$0.30** for orders of $10.00 or less and **$0.40** above that. For most categories the percentage is **13.6%** up to $7,500 and 2.35% on the part above. There's no separate payment processing fee. A $50 sale with no shipping or tax costs $6.80 plus $0.40, so you keep $42.80. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="eb" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="eb-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping you charge the buyer (USD)<br><input id="eb-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping label you pay (USD)<br><input id="eb-label" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax rate (%)<br><input id="eb-tax" type="number" min="0" step="0.001" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="eb-qty" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="eb-cost" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Category<br><select id="eb-cat" style="width:100%;max-width:260px"><option value="most" selected>Most categories (13.6%)</option><option value="media">Books, movies and music (15.3%)</option><option value="coins">Coins, trading cards and comics (13.25%)</option><option value="guitars">Guitars and basses (6.7%)</option><option value="watches">Watches (15%, 6.5%, 3%)</option><option value="bags">Women's bags and handbags (15% or 9%)</option><option value="jewelry">Jewelry, not watches (15% or 9%)</option><option value="bullion">Bullion (13.6% or 7%)</option><option value="sneakers">Athletic shoes (13.6%, or 8% from $150)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer<br><select id="eb-intl" style="width:100%;max-width:260px"><option value="us" selected>In the US</option><option value="intl">Outside the US, not using eBay International Shipping (+1.65%)</option></select></label></p>
  </div>
  <p id="eb-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right"><span id="eb-s-price">$0.00</span></td></tr>
    <tr><td>Shipping charged to the buyer</td><td style="text-align:right"><span id="eb-s-bship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="eb-s-tax">$0.00</span></td></tr>
    <tr><td>Total amount of the sale</td><td style="text-align:right"><span id="eb-s-total">$0.00</span></td></tr>
    <tr><td>Final value fee, percentage part</td><td style="text-align:right"><span id="eb-s-pct">$0.00</span></td></tr>
    <tr><td>Per order fee</td><td style="text-align:right"><span id="eb-s-order">$0.00</span></td></tr>
    <tr><td>International fee</td><td style="text-align:right"><span id="eb-s-intl">$0.00</span></td></tr>
    <tr><td>Total eBay fees</td><td style="text-align:right"><span id="eb-s-fees">$0.00</span></td></tr>
    <tr><td>Shipping label you pay</td><td style="text-align:right"><span id="eb-s-label">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="eb-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right"><span id="eb-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="eb-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="eb-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right"><span id="eb-m-gross">$0.00</span></td></tr>
    <tr><td>eBay fees</td><td style="text-align:right"><span id="eb-m-fees">$0.00</span></td></tr>
    <tr><td>Shipping labels you pay</td><td style="text-align:right"><span id="eb-m-labels">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="eb-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="eb-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="eb-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="eb-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="eb-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after eBay's fees and the shipping label (USD)<br><input id="eb-target" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="eb-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* eBay US final value fee math for sellers without an eBay Store (eBay Help "Selling fees", ebay.com/help/selling/fees-credits-invoices/selling-fees?id=4822; checked Oct 29, 2026). The final value fee is a percentage of the total amount of the sale (item price, shipping charged to the buyer, handling and sales tax) plus a per order fee of $0.30 for orders of $10.00 or less and $0.40 above $10.00. Rates by category: most categories 13.6% up to $7,500 and 2.35% on the part above; Books & Magazines, Movies & TV, Music 15.3% then 2.35%; Coins & Paper Money (not bullion) and select collectibles (comic books, non-sport and sports trading cards, collectible card games) 13.25% then 2.35%; Guitars & Basses 6.7% then 2.35%; Women's Bags & Handbags 15% of the whole sale up to $2,000, 9% above; Jewelry (not watches) 15% up to $5,000, 9% above; Watches 15% up to $1,000, 6.5% from $1,000 to $7,500, 3% above; Bullion 13.6% up to $7,500, 7% above; men's and women's athletic shoes 8% with no per order fee at $150 and above, 13.6% under $150. International fee 1.65% of the total amount of the sale when the buyer is outside the US and you don't use eBay International Shipping. Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, INTL_BP = 165;
  /* bp = hundredths of a percent. "split": rate per slice of the total. "whole": one rate on the whole total, picked by size. */
  var CATS = {
    most: { name: "Most categories", split: [[750000, 1360], [Infinity, 235]] },
    media: { name: "Books, movies, music", split: [[750000, 1530], [Infinity, 235]] },
    coins: { name: "Coins, trading cards, comics", split: [[750000, 1325], [Infinity, 235]] },
    guitars: { name: "Guitars & basses", split: [[750000, 670], [Infinity, 235]] },
    watches: { name: "Watches", split: [[100000, 1500], [750000, 650], [Infinity, 300]] },
    bags: { name: "Women's bags & handbags", whole: [[200000, 1500], [Infinity, 900]] },
    jewelry: { name: "Jewelry (not watches)", whole: [[500000, 1500], [Infinity, 900]] },
    bullion: { name: "Bullion", whole: [[750000, 1360], [Infinity, 700]] },
    sneakers: { name: "Athletic shoes", sneakers: true }
  };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxPct(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  /* t = total amount of the sale in cents; returns [percentage fee in cents, per order fee in cents] */
  function fvf(t, cat) {
    var C = CATS[cat] || CATS.most, f = 0, prev = 0, i;
    if (t <= 0) return [0, 0];
    if (C.sneakers) return t >= 15000 ? [rnd(t * 800 / 10000), 0] : [rnd(t * 1360 / 10000), t <= 1000 ? 30 : 40];
    if (C.whole) { for (i = 0; i < C.whole.length; i++) if (t <= C.whole[i][0]) { f = t * C.whole[i][1]; break; } }
    else for (i = 0; i < C.split.length && t > prev; i++) { f += (Math.min(t, C.split[i][0]) - prev) * C.split[i][1]; prev = C.split[i][0]; }
    return [rnd(f / 10000), t <= 1000 ? 30 : 40];
  }
  /* o = { bship: cents charged to buyer, label: cents you pay for the label, tax: % sales tax on item + shipping, intl: bool, cat } */
  function opts(bship, label, tax, intl, cat) { return { bship: cents(amt(bship)), label: cents(amt(label)), tax: taxPct(tax), intl: !!intl, cat: CATS[cat] ? cat : "most" }; }
  function parts(c, o) {
    if (c <= 0) return { tax: 0, total: 0, pct: 0, order: 0, intl: 0, fees: 0, keep: 0 };
    var tax = rnd((c + o.bship) * o.tax / 100), total = c + o.bship + tax, f = fvf(total, o.cat), intl = o.intl ? rnd(total * INTL_BP / 10000) : 0, fees = f[0] + f[1] + intl;
    return { tax: tax, total: total, pct: f[0], order: f[1], intl: intl, fees: fees, keep: c + o.bship - fees - o.label };
  }
  function calc(x, bship, label, tax, intl, cat, cost) {
    var price = amt(x), k = amt(cost), o = opts(bship, label, tax, intl, cat);
    if (price <= 0) return { price: 0, bship: o.bship / 100, tax: 0, total: 0, pct: 0, order: 0, intl: 0, fees: 0, label: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o);
    return { price: price, bship: o.bship / 100, tax: p.tax / 100, total: p.total / 100, pct: p.pct / 100, order: p.order / 100, intl: p.intl / 100, fees: p.fees / 100, label: o.label / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fees / c };
  }
  function perMonth(x, q, bship, label, tax, intl, cat, cost) {
    var s = calc(x, bship, label, tax, intl, cat, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fees * n), labels = r2(s.label * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, labels: labels, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest item price (to the cent) that keeps at least T. Keep can drop (the $10 per order step) or jump (whole-sale rate cuts), so scan up from a safe lower bound: keep <= price + buyer shipping - label. */
  function priceFor(T, bship, label, tax, intl, cat) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(bship, label, tax, intl, cat), hi = MAX_AMT * 100, c = Math.max(1, tc - o.bship + o.label);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, CATS: CATS, INTL_BP: INTL_BP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, fvf: fvf, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.EbayFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.EbayFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("eb-price").value, sh = $("eb-ship").value, lab = $("eb-label").value, tx = $("eb-tax").value, intl = $("eb-intl").value === "intl", cat = $("eb-cat").value, q = $("eb-qty").value, k = $("eb-cost").value, w = [];
    var m = B.perMonth(x, q, sh, lab, tx, intl, cat, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees and shipping label take the whole sale or more.");
    if (cat === "sneakers" && c.total > 0 && c.total < 150) w.push("Athletic shoes pay 8% with no per order fee once the total sale reaches $150, so a price at $150 can keep more than one just under it.");
    if ((cat === "bags" && c.total > 1700 && c.total <= 2000) || (cat === "jewelry" && c.total > 4250 && c.total <= 5000)) w.push("Just above the price line the rate drops to 9% on the whole sale, so a slightly higher price can keep much more.");
    $("eb-warn").textContent = w.join(" ");
    set("eb-s-price", money(c.price)); set("eb-s-bship", money(c.bship)); set("eb-s-tax", money(c.tax)); set("eb-s-total", money(c.total)); set("eb-s-pct", money(c.pct)); set("eb-s-order", money(c.order)); set("eb-s-intl", money(c.intl)); set("eb-s-fees", money(c.fees)); set("eb-s-label", money(c.label)); set("eb-s-net", money(c.net)); set("eb-s-eff", pctS(c.effective)); set("eb-s-cost", money(c.cost)); set("eb-s-profit", money(c.profit));
    set("eb-m-gross", money(m.gross)); set("eb-m-fees", money(m.fees)); set("eb-m-labels", money(m.labels)); set("eb-m-net", money(m.net)); set("eb-m-cost", money(m.costs)); set("eb-m-profit", money(m.profit)); set("eb-y-net", money(m.year)); set("eb-y-profit", money(m.yearProfit));
    var T = $("eb-target").value, need = B.priceFor(T, sh, lab, tx, intl, cat);
    set("eb-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after eBay's fees" + (B.amt(lab) > 0 ? " and the shipping label." : "."));
  }
  ["eb-price", "eb-ship", "eb-label", "eb-tax", "eb-qty", "eb-cost", "eb-cat", "eb-intl", "eb-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## eBay final value fees in the US (checked Oct 29, 2026)

These are the rates for sellers without an eBay Store. Store subscribers, vehicles and eBay Live sales have their own fee pages.

| Category | Final value fee | Per order fee |
|---|---|---|
| Most categories | 13.6% up to $7,500, 2.35% on the part above | $0.30 up to $10, $0.40 above |
| Books & Magazines, Movies & TV, Music | 15.3% up to $7,500, 2.35% above | same |
| Coins & Paper Money (not bullion), comic books, non-sport and sports trading cards, collectible card games | 13.25% up to $7,500, 2.35% above | same |
| Guitars & Basses | 6.7% up to $7,500, 2.35% above | same |
| Watches, Parts & Accessories | 15% up to $1,000, 6.5% from $1,000 to $7,500, 3% above | same |
| Women's Bags & Handbags | 15% of the whole sale up to $2,000, 9% if over $2,000 | same |
| Jewelry (not watches) | 15% of the whole sale up to $5,000, 9% if over $5,000 | same |
| Bullion | 13.6% up to $7,500, 7% of the whole sale if over $7,500 | same |
| Men's and women's athletic shoes | 13.6% under $150, 8% at $150 and above | none at $150 and above |
| International fee, buyer outside the US and you don't use eBay International Shipping | 1.65% of the total amount of the sale | |
| Insertion fee | first 250 listings a month free, then $0.35 each in most categories | |

All of this comes from eBay's own help page, [Selling fees](https://www.ebay.com/help/selling/fees-credits-invoices/selling-fees?id=4822). It says the final value fee "is calculated as a percentage of the total amount of the sale, plus a per order fee", that "For orders $10.00 or less the per order fee is $0.30, for orders over $10.00 the per order fee is $0.40", and that "The total amount of the sale includes the item price, any handling charges, any shipping costs collected from the buyer (some exceptions apply), sales tax, and any other applicable fees." So you pay the fee on sales tax you never keep. If you offer free domestic shipping, there's no fee on shipping. The calculator assumes sales tax is charged on the item and shipping and rounds each fee to the nearest cent. eBay can also add to the final value fee if your account is rated Below Standard or has a very high rate of "item not as described" returns, and it doesn't include promoted listing ad fees. Your order details in Seller Hub show the exact fees, so check them for the final word.

## How the numbers are worked out

```
total sale    = item price + shipping charged to the buyer + sales tax
fee           = 13.6% x total sale (up to $7,500) + 2.35% x the part above   (most categories)
per order     = $0.30 if the total sale is $10.00 or less, otherwise $0.40
international = 1.65% x total sale                          (only if it applies)
you keep      = item price + shipping charged - fees - your shipping label
per month     = you keep x sales
profit        = you keep - what you paid for the item
```

With no shipping or tax, a $20 sale costs $2.72 plus $0.40 and keeps $16.88. A $100 sale costs $13.60 plus $0.40 and keeps $86.00, and a $300 sale costs $40.80 plus $0.40 and keeps $258.80. Charge the buyer $10 for shipping on a $50 item and pay $8 for the label, and the fee is $8.16 plus $0.40, so you keep $43.44. Add 7% sales tax and the total sale is $64.20, the fee rises to $8.73 and you keep $42.87. An international buyer adds $0.83 to a $50 sale, and a $50 book costs $7.65 plus $0.40 instead of $6.80. At 20 sales of $50 a month you pay $144.00 in fees and keep $856.00, or $10,272.00 a year. If each item cost you $20, your profit is $456.00 a month, or $5,472.00 a year. To keep $40 per sale, list at $46.76. To keep $100, list at $116.20. To keep $40 after paying an $8 label yourself, list at $56.02.

## Price lines where a higher price keeps less, or more

The per order fee goes from $0.30 to $0.40 above $10.00, so a $10.00 sale keeps $8.34, but $10.01 to $10.10 keep less, and $10.13 is the first price that keeps more. Some categories go the other way. Athletic shoes pay 8% with no per order fee once the total sale reaches $150, so a $149.99 pair keeps $129.19 and a $150.00 pair keeps $138.00. Women's bags at $2,000.00 keep $1,699.60, but at $2,000.01 the whole sale drops to 9% and keeps $1,819.61. Shipping and sales tax count toward these lines.

## FAQ

### How much does eBay take from a sale in 2026?

For most categories, 13.6% of the total amount of the sale up to $7,500, plus a $0.40 per order fee ($0.30 on orders of $10 or less). On a $50 sale with no shipping or tax that's $7.20, so you keep $42.80.

### How much does eBay take on a $100 sale?

In most categories, with no shipping or tax, the final value fee is $13.60 plus the $0.40 per order fee, so eBay takes $14.00 and you keep $86.00.

### Does eBay charge fees on shipping and sales tax?

Yes. The final value fee is charged on the total amount of the sale, which includes shipping the buyer pays and sales tax. If you offer free domestic shipping, there's no fee on shipping.

### Does eBay still charge a payment processing fee?

No. eBay says you "don't have to worry about third-party payment processing fees". The final value fee and the per order fee cover it.

### What should I list at on eBay to keep a set amount?

In most categories with no shipping or tax, add $0.40 to what you want to keep and divide by 0.864. For $40 that gives $46.76. The calculator above finds the exact cent for any category, shipping, sales tax and buyer.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does eBay take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "For most categories, 13.6% of the total amount of the sale up to $7,500, plus a $0.40 per order fee ($0.30 on orders of $10 or less). On a $50 sale with no shipping or tax that's $7.20, so you keep $42.80."}},
{"@type": "Question", "name": "How much does eBay take on a $100 sale?", "acceptedAnswer": {"@type": "Answer", "text": "In most categories, with no shipping or tax, the final value fee is $13.60 plus the $0.40 per order fee, so eBay takes $14.00 and you keep $86.00."}},
{"@type": "Question", "name": "Does eBay charge fees on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. The final value fee is charged on the total amount of the sale, which includes shipping the buyer pays and sales tax. If you offer free domestic shipping, there's no fee on shipping."}},
{"@type": "Question", "name": "Does eBay still charge a payment processing fee?", "acceptedAnswer": {"@type": "Answer", "text": "No. eBay says you \"don't have to worry about third-party payment processing fees\". The final value fee and the per order fee cover it."}},
{"@type": "Question", "name": "What should I list at on eBay to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "In most categories with no shipping or tax, add $0.40 to what you want to keep and divide by 0.864. For $40 that gives $46.76. The calculator above finds the exact cent for any category, shipping, sales tax and buyer."}}
]}
</script>

## Related tools and guides

- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping
- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 fee under $15 or 20% from $15, and the $15 price cliff
- [Grailed fee calculator (2026)](grailed-fee-calculator): Grailed's 6% or 9% seller commission plus 3.49% + $0.49 processing, and the $120 price line
- [Whatnot fee calculator (2026)](whatnot-fee-calculator): Whatnot's 8% commission on the item price only plus 2.9% + $0.30 processing, with lower rates as your sales grow
- [Reverb fee calculator (2026)](reverb-fee-calculator): Reverb's 5% selling fee on item and shipping ($0.50 minimum, $500 maximum) plus 3.19% + $0.49 processing for music gear sellers
- [Discogs fee calculator (2026)](discogs-fee-calculator): Discogs' 9% selling fee on item and shipping ($0.10 minimum, $150 maximum per item) plus PayPal's 3.49% + $0.49 on the whole payment, for record sellers
- [StockX fee calculator (2026)](stockx-fee-calculator): StockX's 9% to 7% transaction fee by Seller Level ($5 minimum) plus 3% processing and $5 seller shipping, for sneaker and streetwear sellers
- [TCGplayer fee calculator (2026)](tcgplayer-fee-calculator): TCGplayer's 10.75% commission on the card and shipping (capped at $75 per card) plus the 2.5% + $0.30 transaction fee on the order total with tax, for trading card sellers
- [Depop fee calculator (2026)](depop-fee-calculator): Depop's 3.3% + $0.45 processing fee with no selling fee for US sellers
- [Etsy fee calculator (2026)](etsy-fee-calculator): Etsy's listing, transaction and payment processing fees on each sale
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with eBay. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
