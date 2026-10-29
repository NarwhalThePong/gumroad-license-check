---
layout: page
title: "Whatnot fee calculator (2026): what US sellers keep after commission and processing"
description: "Free Whatnot fee calculator for US sellers. See the commission for your category and sales tier (8% to start, 4% for coins), the 2.9% + $0.30 payment processing fee on item, shipping and tax, what you keep, your profit, monthly and yearly totals and the exact price to keep a set amount."
---

Whatnot charges US sellers two fees on each order. The **commission** is a percentage of the **item price only**, not the shipping or tax the buyer pays. It starts at **8%** for most categories and **4%** for coins, and it drops as your sales grow: your total sales in one four-week period set your tier for the next one. **Payment processing** is **2.9% of the total order value** the buyer pays (item, shipping and tax) **plus $0.30** per order. A $50 sale with no shipping or tax costs $4.00 in commission and $1.75 in processing, so you keep $44.25. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="wn" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="wn-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="wn-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping you cover (USD)<br><input id="wn-seller" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales tax rate (%)<br><input id="wn-tax" type="number" min="0" step="0.001" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="wn-qty" type="number" min="0" step="1" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="wn-cost" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Category<br><select id="wn-cat" style="width:100%;max-width:260px"><option value="sports" selected>Sports</option><option value="tcg">Trading card games</option><option value="fashion">Fashion</option><option value="collectibles">Other collectibles</option><option value="coins">Coins</option><option value="other">Other</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your tier (sales last four weeks)<br><select id="wn-tier" style="width:100%;max-width:260px"><option value="0" selected>Standard ($0 to $14,999)</option><option value="1">Tier 1 ($15,000 to $34,999)</option><option value="2">Tier 2 ($35,000 to $49,999)</option><option value="3">Tier 3 ($50,000 to $99,999)</option><option value="4">Tier 4 ($100,000 to $249,999)</option><option value="5">Tier 5 ($250,000 to $499,999)</option><option value="6">Tier 6 ($500,000 and up)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>0% commission above $1,500<br><select id="wn-hv" style="width:100%;max-width:260px"><option value="no" selected>No</option><option value="yes">Yes, the item is in a qualifying category</option></select></label></p>
  </div>
  <p id="wn-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right"><span id="wn-s-price">$0.00</span></td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right"><span id="wn-s-ship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="wn-s-tax">$0.00</span></td></tr>
    <tr><td>Total order value</td><td style="text-align:right"><span id="wn-s-total">$0.00</span></td></tr>
    <tr><td>Commission rate</td><td style="text-align:right"><span id="wn-s-rate">$0.00</span></td></tr>
    <tr><td>Commission</td><td style="text-align:right"><span id="wn-s-comm">$0.00</span></td></tr>
    <tr><td>Payment processing</td><td style="text-align:right"><span id="wn-s-proc">$0.00</span></td></tr>
    <tr><td>Total Whatnot fees</td><td style="text-align:right"><span id="wn-s-fees">$0.00</span></td></tr>
    <tr><td>Shipping you cover</td><td style="text-align:right"><span id="wn-s-seller">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="wn-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right"><span id="wn-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="wn-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="wn-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right"><span id="wn-m-gross">$0.00</span></td></tr>
    <tr><td>Whatnot fees</td><td style="text-align:right"><span id="wn-m-fees">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="wn-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="wn-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="wn-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="wn-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="wn-y-profit">$0.00</span></td></tr>
  </table>
  <p id="wn-next" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Whatnot's fees (USD)<br><input id="wn-target" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="wn-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Whatnot US seller fee math (Whatnot Help Center "Whatnot seller fees", help.whatnot.com/hc/en-us/articles/4847069165965, updated Oct 1, 2026; whatnot.com/seller/fees; "Reduced Commission on High-Value Orders", help.whatnot.com/hc/en-us/articles/27912945518733; checked Oct 29, 2026). Commission is a percentage of the item's sale price only (shipping and taxes the buyer pays are not included). The rate depends on the category and on the tier your total sales over the previous four-week period unlocked (US: Standard $0-$14,999, Tier 1 $15,000-$34,999, Tier 2 $35,000-$49,999, Tier 3 $50,000-$99,999, Tier 4 $100,000-$249,999, Tier 5 $250,000-$499,999, Tier 6 $500,000+). Payment processing is 2.9% of the total order value the buyer pays (item price, buyer-paid shipping and taxes) plus $0.30 per order. In select categories, commission is 0% on the part of a single order above $1,500. Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, PROC_BP = 290, PROC_FIXED = 30, HV_CAP = 150000;
  var TIERS = ["Standard ($0 to $14,999)", "Tier 1 ($15,000 to $34,999)", "Tier 2 ($35,000 to $49,999)", "Tier 3 ($50,000 to $99,999)", "Tier 4 ($100,000 to $249,999)", "Tier 5 ($250,000 to $499,999)", "Tier 6 ($500,000 and up)"];
  var TIER_MIN = [0, 15000, 35000, 50000, 100000, 250000, 500000];
  /* rates in hundredths of a percent, Standard..Tier 6 */
  var CATS = {
    sports: { name: "Sports", bp: [800, 775, 750, 725, 700, 675, 650] },
    tcg: { name: "Trading card games", bp: [800, 775, 750, 725, 700, 675, 650] },
    fashion: { name: "Fashion", bp: [800, 700, 650, 550, 500, 450, 450] },
    collectibles: { name: "Other collectibles", bp: [800, 725, 650, 600, 500, 500, 500] },
    coins: { name: "Coins", bp: [400, 390, 380, 370, 360, 355, 350] },
    other: { name: "Other", bp: [800, 700, 650, 550, 400, 400, 400] }
  };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxPct(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  function tierFor(sales) { var s = num(sales), t = 0; for (var i = 0; i < TIER_MIN.length; i++) if (s >= TIER_MIN[i]) t = i; return t; }
  function rateBp(cat, tier) { var C = CATS[cat] || CATS.sports, t = Math.max(0, Math.min(6, Math.floor(num(tier)))); return C.bp[t]; }
  /* o = { ship: cents the buyer pays for shipping, seller: cents of shipping you cover, tax: % on item + shipping, cat, tier, hv: 0% above $1,500 applies } */
  function opts(ship, seller, tax, cat, tier, hv) { return { ship: cents(amt(ship)), seller: cents(amt(seller)), tax: taxPct(tax), cat: CATS[cat] ? cat : "sports", tier: Math.max(0, Math.min(6, Math.floor(num(tier)))), hv: !!hv }; }
  function parts(c, o) {
    if (c <= 0) return { tax: 0, total: 0, comm: 0, proc: 0, fees: 0, keep: 0 };
    var bp = rateBp(o.cat, o.tier), base = o.hv ? Math.min(c, HV_CAP) : c, comm = rnd(base * bp / 10000), tax = rnd((c + o.ship) * o.tax / 100), total = c + o.ship + tax, proc = rnd(total * PROC_BP / 10000) + PROC_FIXED, fees = comm + proc;
    return { tax: tax, total: total, comm: comm, proc: proc, fees: fees, keep: c - fees - o.seller };
  }
  function calc(x, ship, seller, tax, cat, tier, hv, cost) {
    var price = amt(x), k = amt(cost), o = opts(ship, seller, tax, cat, tier, hv), bp = rateBp(o.cat, o.tier);
    if (price <= 0) return { price: 0, ship: o.ship / 100, tax: 0, total: 0, rate: bp / 100, comm: 0, proc: 0, fees: 0, seller: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o);
    return { price: price, ship: o.ship / 100, tax: p.tax / 100, total: p.total / 100, rate: bp / 100, comm: p.comm / 100, proc: p.proc / 100, fees: p.fees / 100, seller: o.seller / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fees / c };
  }
  function perMonth(x, q, ship, seller, tax, cat, tier, hv, cost) {
    var s = calc(x, ship, seller, tax, cat, tier, hv, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fees * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs), four = r2(s.price * n * 28 / 30.4375);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12), fourWeek: four, nextTier: tierFor(four) };
  }
  /* Smallest item price (to the cent) that keeps at least T. Rounding of two fees can make keep dip by a cent, so scan up from a safe lower bound (keep <= price - seller shipping). */
  function priceFor(T, ship, seller, tax, cat, tier, hv) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, seller, tax, cat, tier, hv), hi = MAX_AMT * 100, c = Math.max(1, tc + o.seller);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, CATS: CATS, TIERS: TIERS, TIER_MIN: TIER_MIN, PROC_BP: PROC_BP, PROC_FIXED: PROC_FIXED, HV_CAP: HV_CAP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, tierFor: tierFor, rateBp: rateBp, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.WhatnotFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.WhatnotFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("wn-price").value, sh = $("wn-ship").value, sl = $("wn-seller").value, tx = $("wn-tax").value, cat = $("wn-cat").value, tier = $("wn-tier").value, hv = $("wn-hv").value === "yes", q = $("wn-qty").value, k = $("wn-cost").value, w = [];
    var m = B.perMonth(x, q, sh, sl, tx, cat, tier, hv, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees take the whole sale or more.");
    if (hv && c.price > 1500 && cat === "fashion") w.push("In Fashion, only bags and accessories qualify for 0% above $1,500.");
    $("wn-warn").textContent = w.join(" ");
    set("wn-s-price", money(c.price)); set("wn-s-ship", money(c.ship)); set("wn-s-tax", money(c.tax)); set("wn-s-total", money(c.total)); set("wn-s-rate", c.rate.toFixed(2) + "%"); set("wn-s-comm", money(c.comm)); set("wn-s-proc", money(c.proc)); set("wn-s-fees", money(c.fees)); set("wn-s-seller", money(c.seller)); set("wn-s-net", money(c.net)); set("wn-s-eff", pctS(c.effective)); set("wn-s-cost", money(c.cost)); set("wn-s-profit", money(c.profit));
    set("wn-m-gross", money(m.gross)); set("wn-m-fees", money(m.fees)); set("wn-m-net", money(m.net)); set("wn-m-cost", money(m.costs)); set("wn-m-profit", money(m.profit)); set("wn-y-net", money(m.year)); set("wn-y-profit", money(m.yearProfit));
    set("wn-next", m.gross > 0 ? "At this pace you'd sell about " + money(m.fourWeek) + " in four weeks, which unlocks " + B.TIERS[m.nextTier] + " for the next period." : "");
    var T = $("wn-target").value, need = B.priceFor(T, sh, sl, tx, cat, tier, hv);
    set("wn-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "Sell at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Whatnot's fees" + (B.amt(sl) > 0 ? " and the shipping you cover." : "."));
  }
  ["wn-price", "wn-ship", "wn-seller", "wn-tax", "wn-qty", "wn-cost", "wn-cat", "wn-tier", "wn-hv", "wn-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Whatnot commission rates in the US (checked Oct 29, 2026)

Whatnot moved to tiered commission on September 21, 2026. Your total sales across all categories in a four-week period set your tier for the next four weeks, and each sale is then charged the rate for its category at that tier. For live sales the category is the show's category; for marketplace sales it's the product's.

| Category | Standard $0 to $14,999 | Tier 1 $15,000+ | Tier 2 $35,000+ | Tier 3 $50,000+ | Tier 4 $100,000+ | Tier 5 $250,000+ | Tier 6 $500,000+ |
|---|---|---|---|---|---|---|---|
| Sports | 8.00% | 7.75% | 7.50% | 7.25% | 7.00% | 6.75% | 6.50% |
| Trading card games | 8.00% | 7.75% | 7.50% | 7.25% | 7.00% | 6.75% | 6.50% |
| Fashion | 8.00% | 7.00% | 6.50% | 5.50% | 5.00% | 4.50% | 4.50% |
| Other collectibles | 8.00% | 7.25% | 6.50% | 6.00% | 5.00% | 5.00% | 5.00% |
| Coins | 4.00% | 3.90% | 3.80% | 3.70% | 3.60% | 3.55% | 3.50% |
| Other | 8.00% | 7.00% | 6.50% | 5.50% | 4.00% | 4.00% | 4.00% |

Payment processing is the same for everyone in the US: 2.9% of the total order value plus $0.30 per order. Whatnot also charges 0% commission on the part of a single order above $1,500 in Comics & Anime, Toys & Hobbies, Coins & Money, Trading Card Games, Entertainment Cards, Sports singles, Bags & Accessories and Jewelry & Watches. Sports breaks and surprise products don't qualify, and processing still applies to the whole order.

These figures come from Whatnot's own pages: [Whatnot seller fees](https://help.whatnot.com/hc/en-us/articles/4847069165965-Whatnot-seller-fees) (updated Oct 1, 2026), [How fees work](https://www.whatnot.com/seller/fees) and [Reduced Commission on High-Value Orders](https://help.whatnot.com/hc/en-us/articles/27912945518733-Reduced-Commission-on-High-Value-Orders). Whatnot says processing fees "are calculated on the total order value paid by the buyer, including the item price, buyer-paid shipping, and taxes, plus a fixed transaction fee." The calculator assumes sales tax is charged on the item and shipping, that the shipping the buyer pays goes to the label rather than to you, and that each fee rounds to the nearest cent. Promotional rates (such as 0% for new sellers) and custom rates below the public table aren't included. Through October 31, 2026, Premier Shop sellers also get 10% off their commission rate; from November 1 that discount ends. Your order receipt in Seller Hub shows the exact fees, so check it for the final word.

## How the numbers are worked out

```
commission  = rate for your category and tier x item price   (shipping and tax not included)
processing  = 2.9% x (item price + shipping the buyer pays + sales tax) + $0.30
you keep    = item price - commission - processing - any shipping you cover
per month   = you keep x sales
profit      = you keep - what you paid for the item
```

At the 8% standard rate with no shipping or tax, a $20 sale costs $1.60 plus $0.88 and keeps $17.52, and a $100 sale costs $8.00 plus $3.20 and keeps $88.80. Whatnot's own example of a $10 item with $4.99 shipping costs $0.80 in commission and $0.73 in processing, so you keep $8.47. Add $6 shipping and 7% sales tax to a $50 sale and processing rises to $2.04, so you keep $43.96. A $50 coin at 4% keeps $46.25, and a $50 Fashion sale at Tier 3 (5.50%) keeps $45.50. A $2,000 trading card pays 8% only on the first $1,500, so commission is $120.00 instead of $160.00 and you keep $1,821.70. At 40 sales of $50 a month you pay $230.00 in fees and keep $1,770.00, or $21,240.00 a year. If each item cost you $20, your profit is $970.00 a month, or $11,640.00 a year. To keep $40 per sale at 8% with no shipping or tax, sell at $45.23. To keep $100, sell at $112.56.

## FAQ

### How much does Whatnot take from a sale in 2026?

At the standard rate, 8% commission on the item price plus 2.9% of the order total and $0.30 for processing. On a $50 sale with no shipping or tax that's $4.00 plus $1.75, so you keep $44.25.

### Does Whatnot charge fees on shipping and sales tax?

Not commission. Whatnot charges commission on the item price only. The 2.9% processing fee is charged on the whole order the buyer pays, including shipping and tax.

### How do I get a lower Whatnot commission rate?

Sell more in a four-week period. In the US, $15,000 in total sales unlocks Tier 1 for the next four weeks, and the rates keep dropping up to Tier 6 at $500,000. Rates as low as 3% are custom deals for the largest sellers.

### What is Whatnot's fee on coins?

Coins start at 4% commission and drop to 3.5% at the top tier, plus the same 2.9% + $0.30 processing fee. A $50 coin sale with no shipping or tax keeps $46.25.

### What should I sell at on Whatnot to keep a set amount?

At 8% with no shipping or tax, add $0.30 to what you want to keep and divide by 0.891. For $40 that gives $45.23. The calculator above finds the exact cent for any category, tier, shipping and sales tax.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Whatnot take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "At the standard rate, 8% commission on the item price plus 2.9% of the order total and $0.30 for processing. On a $50 sale with no shipping or tax that's $4.00 plus $1.75, so you keep $44.25."}},
{"@type": "Question", "name": "Does Whatnot charge fees on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "Not commission. Whatnot charges commission on the item price only. The 2.9% processing fee is charged on the whole order the buyer pays, including shipping and tax."}},
{"@type": "Question", "name": "How do I get a lower Whatnot commission rate?", "acceptedAnswer": {"@type": "Answer", "text": "Sell more in a four-week period. In the US, $15,000 in total sales unlocks Tier 1 for the next four weeks, and the rates keep dropping up to Tier 6 at $500,000. Rates as low as 3% are custom deals for the largest sellers."}},
{"@type": "Question", "name": "What is Whatnot's fee on coins?", "acceptedAnswer": {"@type": "Answer", "text": "Coins start at 4% commission and drop to 3.5% at the top tier, plus the same 2.9% + $0.30 processing fee. A $50 coin sale with no shipping or tax keeps $46.25."}},
{"@type": "Question", "name": "What should I sell at on Whatnot to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "At 8% with no shipping or tax, add $0.30 to what you want to keep and divide by 0.891. For $40 that gives $45.23. The calculator above finds the exact cent for any category, tier, shipping and sales tax."}}
]}
</script>

## Related tools and guides

- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 13.6% final value fee for most categories plus $0.30 or $0.40 per order, charged on shipping and sales tax too
- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping
- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 fee under $15 or 20% from $15, and the $15 price cliff
- [Grailed fee calculator (2026)](grailed-fee-calculator): Grailed's 6% or 9% seller commission plus 3.49% + $0.49 processing, and the $120 price line
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Whatnot. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
