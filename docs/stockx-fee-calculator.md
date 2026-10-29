---
layout: page
title: "StockX fee calculator (2026): what US sneaker sellers keep after fees and shipping"
description: "Free StockX fee calculator for US sellers. See the transaction fee for your Seller Level (9% down to 7%, $5 minimum), the 3% payment processing fee, the $5 seller shipping on standard sales, Flex sales, your payout, profit, monthly and yearly totals and the exact price to keep a set amount."
---

StockX charges US sellers on its Verified Marketplace a **transaction fee set by your Seller Level**, from **9% at Level 1** down to **7% at Level 5**, with a **$5 minimum**, plus a **3% payment processing fee**, both on the final sale price. On a standard sale StockX also takes **$5 for shipping** out of your payout; on a **Flex** sale, where your pairs already sit in StockX's warehouse, there's no per-sale shipping or fulfillment fee. A $100 pair at Level 1 costs $9.00 plus $3.00 plus $5.00 shipping, so you're paid $83.00, or $88.00 through Flex. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="sx" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sale price (USD)<br><input id="sx-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Seller shipping on a standard sale (USD)<br><input id="sx-ship" type="number" min="0" step="0.01" value="5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="sx-qty" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="sx-cost" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your Seller Level<br><select id="sx-level" style="width:100%;max-width:260px"><option value="1" selected>Level 1 (9%)</option><option value="2">Level 2 (8.5%)</option><option value="3">Level 3 (8%)</option><option value="4">Level 4 (7.5%)</option><option value="5">Level 5 (7%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How it sells<br><select id="sx-method" style="width:100%;max-width:260px"><option value="std" selected>Standard (you ship it to StockX)</option><option value="flex">Flex (already in StockX's warehouse)</option></select></label></p>
  </div>
  <p id="sx-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sale price</td><td style="text-align:right"><span id="sx-s-price">$0.00</span></td></tr>
    <tr><td>Transaction fee</td><td style="text-align:right"><span id="sx-s-txn">$0.00</span></td></tr>
    <tr><td>Payment processing (3%)</td><td style="text-align:right"><span id="sx-s-proc">$0.00</span></td></tr>
    <tr><td>Total StockX fees</td><td style="text-align:right"><span id="sx-s-fees">$0.00</span></td></tr>
    <tr><td>Seller shipping</td><td style="text-align:right"><span id="sx-s-ship">$0.00</span></td></tr>
    <tr><td>You're paid</td><td style="text-align:right"><strong id="sx-s-net">$0.00</strong></td></tr>
    <tr><td>Fees and shipping as a share of the price</td><td style="text-align:right"><span id="sx-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="sx-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="sx-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales</td><td style="text-align:right"><span id="sx-m-gross">$0.00</span></td></tr>
    <tr><td>StockX fees and shipping</td><td style="text-align:right"><span id="sx-m-fees">$0.00</span></td></tr>
    <tr><td>You're paid per month</td><td style="text-align:right"><strong id="sx-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="sx-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="sx-m-profit">$0.00</span></td></tr>
    <tr><td>You're paid per year (12 months like this)</td><td style="text-align:right"><span id="sx-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="sx-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to be paid per sale after StockX fees and shipping (USD)<br><input id="sx-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sx-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* StockX US seller fee math, Verified Marketplace (StockX Help "What are StockX's fees for sellers?", stockx.com/help/articles/what-are-stockxs-fees-for-sellers; "What is the StockX Seller Program? What are Seller Levels?", stockx.com/help/articles/what-is-the-stockx-seller-program-what-are-seller-levels; "How much does shipping cost for sellers?", stockx.com/help/articles/how-much-does-shipping-cost-for-sellers; "What is Flex?", stockx.com/help/articles/what-is-flex; "Updates to the StockX Seller Program", stockx.com/news/en-us/updates-to-the-stockx-seller-program, effective Mar 1, 2026; checked Oct 29, 2026). Transaction fee by Seller Level on the final sale price: Level 1 9%, Level 2 8.5%, Level 3 8%, Level 4 7.5%, Level 5 7%, with a $5.00 US minimum seller fee (applied here to the transaction fee). Payment processing: 3% of the sale price. Standard (non-Flex) sales: US seller shipping $5.00 deducted from the payout. Flex sales: same Level rate, no per-sale shipping or fulfillment fee (storage fees not modelled). Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MIN_FEE = 500, PROC_BP = 300, SHIP_US = 500;
  var LEVELS = { 1: 900, 2: 850, 3: 800, 4: 750, 5: 700 };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  /* o = { level: 1-5, flex: Flex sale, ship: cents of seller shipping on a standard sale } */
  function opts(level, method, ship) { var l = LEVELS[level] ? Number(level) : 1, flex = method === "flex"; return { level: l, flex: flex, ship: flex ? 0 : cents(amt(ship)) }; }
  function parts(c, o) {
    if (c <= 0) return { txn: 0, proc: 0, ship: 0, fees: 0, keep: 0 };
    var txn = Math.max(MIN_FEE, rnd(c * LEVELS[o.level] / 10000)), proc = rnd(c * PROC_BP / 10000), fees = txn + proc;
    return { txn: txn, proc: proc, ship: o.ship, fees: fees, keep: c - fees - o.ship };
  }
  function calc(x, level, method, ship, cost) {
    var price = amt(x), k = amt(cost), o = opts(level, method, ship);
    if (price <= 0) return { price: 0, txn: 0, proc: 0, ship: 0, fees: 0, net: 0, cost: k, profit: r2(-k), effective: null, rate: LEVELS[o.level] / 100 };
    var c = cents(price), p = parts(c, o);
    return { price: price, txn: p.txn / 100, proc: p.proc / 100, ship: p.ship / 100, fees: p.fees / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: (p.fees + p.ship) / c, rate: LEVELS[o.level] / 100 };
  }
  function perMonth(x, q, level, method, ship, cost) {
    var s = calc(x, level, method, ship, cost), n = count(q), gross = r2(s.price * n), fees = r2((s.fees + s.ship) * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest sale price (to the cent) that keeps at least T. Rounding and the $5 minimum can leave keep flat for a cent, so scan up from a safe lower bound (processing is at least 3% of the price minus half a cent, so keep <= 0.97 x price + $0.005 - shipping). */
  function priceFor(T, level, method, ship) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(level, method, ship), hi = MAX_AMT * 100, c = Math.max(1, Math.floor((tc + o.ship - 0.5) / 0.97) - 1);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, LEVELS: LEVELS, MIN_FEE: MIN_FEE, PROC_BP: PROC_BP, SHIP_US: SHIP_US, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.StockXFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.StockXFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("sx-price").value, sh = $("sx-ship").value, lv = $("sx-level").value, md = $("sx-method").value, q = $("sx-qty").value, k = $("sx-cost").value, w = [];
    var m = B.perMonth(x, q, lv, md, sh, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees and shipping take the whole sale or more.");
    if (md === "flex" && B.amt(sh) > 0) w.push("Flex sales have no per-sale shipping fee, so the shipping box is ignored.");
    $("sx-warn").textContent = w.join(" ");
    set("sx-s-price", money(c.price)); set("sx-s-txn", money(c.txn)); set("sx-s-proc", money(c.proc)); set("sx-s-fees", money(c.fees)); set("sx-s-ship", money(c.ship)); set("sx-s-net", money(c.net)); set("sx-s-eff", pctS(c.effective)); set("sx-s-cost", money(c.cost)); set("sx-s-profit", money(c.profit));
    set("sx-m-gross", money(m.gross)); set("sx-m-fees", money(m.fees)); set("sx-m-net", money(m.net)); set("sx-m-cost", money(m.costs)); set("sx-m-profit", money(m.profit)); set("sx-y-net", money(m.year)); set("sx-y-profit", money(m.yearProfit));
    var T = $("sx-target").value, need = B.priceFor(T, lv, md, sh);
    set("sx-need", B.amt(T) <= 0 ? "Enter how much you want to be paid per sale." : need == null ? "No price works for that amount." : "Sell at " + money(need) + " to be paid " + money(B.amt(T)) + " per sale after StockX fees" + (md === "flex" ? "." : " and shipping."));
  }
  ["sx-price", "sx-ship", "sx-level", "sx-method", "sx-qty", "sx-cost", "sx-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## StockX seller fees in the US (checked Oct 29, 2026)

| Seller Level | Sales needed in a calendar quarter | Transaction fee | Payment processing |
|---|---|---|---|
| Level 1 | None | 9% | 3% |
| Level 2 | 12 sales or $1,500 | 8.5% | 3% |
| Level 3 | 40 sales or $5,000 | 8% | 3% |
| Level 4 | 200 sales or $25,000 | 7.5% | 3% |
| Level 5 | 800 sales or $100,000 | 7% | 3% |

Both fees are charged on the final sale price, and the US minimum seller fee is $5.00, which at Level 1 covers every sale under $55.56. Standard sales also take $5.00 from your payout for the shipping label StockX gives you (more for heavy items or multi-item packs, and free shipping may be available at some StockX drop-off locations). Since March 1, 2026, Flex sales pay the same rate as your Seller Level with no $5 fulfillment fee and no per-sale shipping, though Flex storage costs $1 to $3 a month per item after 30 days. Once you reach a level you keep it for the rest of that quarter and the next one. StockX's newer Listings Marketplace and StockX Live currently charge sellers no selling or processing fees, but they're open only to select sellers, so this calculator covers the Verified Marketplace.

These figures come from StockX's own pages: [What are StockX's fees for sellers?](https://stockx.com/help/articles/what-are-stockxs-fees-for-sellers), [StockX Seller Levels](https://stockx.com/help/articles/what-is-the-stockx-seller-program-what-are-seller-levels), [How much does shipping cost for sellers?](https://stockx.com/help/articles/how-much-does-shipping-cost-for-sellers), [What is Flex?](https://stockx.com/help/articles/what-is-flex) and [Updates to the StockX Seller Program](https://stockx.com/news/en-us/updates-to-the-stockx-seller-program/). StockX says it "calculates the transaction fee on the final sale price." The calculator assumes the $5 minimum applies to the transaction fee, that each fee rounds to the nearest cent and that the buyer's own fees and sales tax don't come out of your payout. Your Seller Level and exact fees show in your StockX profile and on each sale, so check them for the final word.

## How the numbers are worked out

```
transaction fee = level rate (9%, 8.5%, 8%, 7.5% or 7%) x sale price, at least $5
processing fee  = 3% x sale price
shipping        = $5 on a standard sale, $0 on a Flex sale
you're paid     = sale price - transaction fee - processing fee - shipping
profit          = you're paid - what you paid for the item
```

At Level 1, a $100 pair is paid out at $83.00 on a standard sale and $88.00 through Flex. A $40 pair hits the $5 minimum, pays $1.20 in processing and $5.00 shipping, so you're paid $28.80. A $200 pair pays $18.00 plus $6.00 plus shipping and you're paid $171.00, or $175.00 at Level 5, and a $1,000 pair is paid out at $875.00. A $250 pair at Level 3 is paid $217.50, and a $150 Flex sale at Level 2 is paid $132.75. At 10 sales of $200 pairs a month at Level 1, you pay $290.00 in fees and shipping and are paid $1,710.00, or $20,520.00 a year. If each pair cost you $120, your profit is $510.00 a month, or $6,120.00 a year. To be paid $100 on a standard Level 1 sale, sell at $119.32, or $113.64 through Flex. To be paid $20, sell at $30.93.

## FAQ

### How much does StockX take from a sale in 2026?

At Level 1, a 9% transaction fee and a 3% processing fee, with a $5 minimum transaction fee, plus $5 shipping on a standard sale. On a $100 sale that's $9.00 plus $3.00 plus $5.00, so you're paid $83.00.

### What are the StockX Seller Levels?

Five levels based on your sales in a calendar quarter: Level 1 pays 9%, Level 2 (12 sales or $1,500) 8.5%, Level 3 (40 sales or $5,000) 8%, Level 4 (200 sales or $25,000) 7.5% and Level 5 (800 sales or $100,000) 7%. The 3% processing fee is the same at every level.

### Is StockX Flex cheaper than a standard sale?

Since March 1, 2026, Flex pays the same rate as your Seller Level with no $5 fulfillment fee and no per-sale shipping, so on a $100 pair at Level 1 you're paid $88.00 instead of $83.00. Flex storage is free for 30 days and then costs $1 to $3 a month per item.

### What is the StockX minimum seller fee?

$5.00 for US sellers. At Level 1's 9% that covers any sale under $55.56, so a $40 pair still pays $5.00 instead of $3.60.

### What should I sell at on StockX to keep a set amount?

On a standard Level 1 sale over $55.56, add $5 shipping to what you want to be paid and divide by 0.88. For $100 that gives $119.32. The calculator above finds the exact cent for any Seller Level, Flex or standard sale.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does StockX take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "At Level 1, a 9% transaction fee and a 3% processing fee, with a $5 minimum transaction fee, plus $5 shipping on a standard sale. On a $100 sale that's $9.00 plus $3.00 plus $5.00, so you're paid $83.00."}},
{"@type": "Question", "name": "What are the StockX Seller Levels?", "acceptedAnswer": {"@type": "Answer", "text": "Five levels based on your sales in a calendar quarter: Level 1 pays 9%, Level 2 (12 sales or $1,500) 8.5%, Level 3 (40 sales or $5,000) 8%, Level 4 (200 sales or $25,000) 7.5% and Level 5 (800 sales or $100,000) 7%. The 3% processing fee is the same at every level."}},
{"@type": "Question", "name": "Is StockX Flex cheaper than a standard sale?", "acceptedAnswer": {"@type": "Answer", "text": "Since March 1, 2026, Flex pays the same rate as your Seller Level with no $5 fulfillment fee and no per-sale shipping, so on a $100 pair at Level 1 you're paid $88.00 instead of $83.00. Flex storage is free for 30 days and then costs $1 to $3 a month per item."}},
{"@type": "Question", "name": "What is the StockX minimum seller fee?", "acceptedAnswer": {"@type": "Answer", "text": "$5.00 for US sellers. At Level 1's 9% that covers any sale under $55.56, so a $40 pair still pays $5.00 instead of $3.60."}},
{"@type": "Question", "name": "What should I sell at on StockX to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "On a standard Level 1 sale over $55.56, add $5 shipping to what you want to be paid and divide by 0.88. For $100 that gives $119.32. The calculator above finds the exact cent for any Seller Level, Flex or standard sale."}}
]}
</script>

## Related tools and guides

- [Grailed fee calculator (2026)](grailed-fee-calculator): Grailed's 6% or 9% commission plus 3.49% + $0.49 processing, for selling streetwear and sneakers on Grailed instead
- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 8% final value fee on athletic shoes at $150 and up with no per-order fee
- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's 10% selling fee with no processing fee
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with StockX. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
