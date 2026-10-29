---
layout: page
title: "TCGplayer fee calculator (2026): what US card sellers keep after commission and transaction fees"
description: "Free TCGplayer fee calculator for US sellers. See the 10.75% marketplace commission on the card and shipping (capped at $75 per card), the 2.5% + $0.30 transaction fee on the order total with sales tax, Pro seller fees, what you keep, profit after card cost and postage, monthly and yearly totals and the exact price to keep a set amount."
---

TCGplayer charges a standard US marketplace seller (Level 1 to 4) a **marketplace commission of 10.75%** of the card price and of the shipping the buyer pays, with the commission on each card capped at $75. Each order also pays a **transaction fee of 2.5% of the order total plus $0.30**, and that order total includes the buyer's sales tax. A $20 card with $0.99 shipping and 7% sales tax pays $2.26 in commission and $0.86 in transaction fees, so you keep $17.87. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="tc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Card price (USD)<br><input id="tc-price" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="tc-ship" type="number" min="0" step="0.01" value="0.99" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer's sales tax rate (%)<br><input id="tc-tax" type="number" min="0" step="0.001" value="7" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Orders per month<br><input id="tc-qty" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the card (optional, USD)<br><input id="tc-cost" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What postage costs you (optional, USD)<br><input id="tc-postage" type="number" min="0" step="0.01" value="0.78" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your seller account<br><select id="tc-seller" style="width:100%;max-width:260px"><option value="std" selected>Marketplace seller, Level 1 to 4 (10.75%)</option><option value="pro">Pro seller, not Direct (9.25% + 2.5% Pro fee)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Where the buyer is<br><select id="tc-dest" style="width:100%;max-width:260px"><option value="us" selected>United States (2.5% + $0.30)</option><option value="intl">Outside the US (3.5% + $0.30)</option></select></label></p>
  </div>
  <p id="tc-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per order</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Card price</td><td style="text-align:right"><span id="tc-s-price">$0.00</span></td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right"><span id="tc-s-ship">$0.00</span></td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right"><span id="tc-s-tax">$0.00</span></td></tr>
    <tr><td>Order total</td><td style="text-align:right"><span id="tc-s-total">$0.00</span></td></tr>
    <tr><td>Marketplace commission</td><td style="text-align:right"><span id="tc-s-comm">$0.00</span></td></tr>
    <tr><td>Pro fee</td><td style="text-align:right"><span id="tc-s-pro">$0.00</span></td></tr>
    <tr><td>Transaction fee</td><td style="text-align:right"><span id="tc-s-txn">$0.00</span></td></tr>
    <tr><td>Total TCGplayer fees</td><td style="text-align:right"><span id="tc-s-fees">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="tc-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of card + shipping</td><td style="text-align:right"><span id="tc-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the card</td><td style="text-align:right"><span id="tc-s-cost">$0.00</span></td></tr>
    <tr><td>Postage</td><td style="text-align:right"><span id="tc-s-postage">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="tc-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales (cards + shipping)</td><td style="text-align:right"><span id="tc-m-gross">$0.00</span></td></tr>
    <tr><td>TCGplayer fees</td><td style="text-align:right"><span id="tc-m-fees">$0.00</span></td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="tc-m-net">$0.00</strong></td></tr>
    <tr><td>Cards and postage</td><td style="text-align:right"><span id="tc-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="tc-m-profit">$0.00</span></td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right"><span id="tc-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="tc-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per order after TCGplayer's fees (USD)<br><input id="tc-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="tc-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* TCGplayer US seller fee math (TCGplayer help center "TCGplayer Fees", help.tcgplayer.com/hc/en-us/articles/201357836, and "Fee Calculation Examples", /articles/360047732673; checked Oct 29, 2026). Marketplace Seller (Level 1-4): 10.75% Marketplace Commission Fee on items (capped at $75 per product sold) and on shipping (no cap). Marketplace Pro seller (non-Direct): 9.25% commission plus 2.5% Pro Fee, each on items (capped at $75 per product) and shipping. Transaction Fee per order: 2.5% of the order total (items + shipping + sales tax) + $0.30, or 3.5% + $0.30 on international orders. Fees use bankers rounding to the cent. Direct, Sync and Pro website sales are not modelled. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_TAX = 20, CAP = 7500;
  var SELLERS = { std: { comm: 1075, pro: 0 }, pro: { comm: 925, pro: 250 } };
  var TXN = { us: { bp: 250, fixed: 30 }, intl: { bp: 350, fixed: 30 } };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxRate(v) { return Math.min(Math.round(num(v) * 1000) / 1000, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  /* n / d rounded to an integer, halves to the nearest even integer (bankers rounding); n, d non-negative integers */
  function bank(n, d) { var q = Math.floor(n / d), r = n - q * d; if (2 * r > d || (2 * r === d && q % 2 === 1)) q++; return q; }
  /* n / d rounded to an integer, halves up (used for sales tax) */
  function half(n, d) { var q = Math.floor(n / d), r = n - q * d; return 2 * r >= d ? q + 1 : q; }
  function opts(seller, dest, tax) { return { seller: SELLERS[seller] ? seller : "std", dest: TXN[dest] ? dest : "us", taxm: Math.round(taxRate(tax) * 1000) }; }
  /* c = item price in cents, s = shipping the buyer pays in cents */
  function parts(c, s, o) {
    if (c <= 0) return { commItem: 0, commShip: 0, comm: 0, pro: 0, tax: 0, total: 0, txn: 0, fees: 0, keep: 0 };
    var S = SELLERS[o.seller], T = TXN[o.dest];
    var commItem = Math.min(bank(c * S.comm, 10000), CAP), commShip = bank(s * S.comm, 10000);
    var pro = S.pro ? Math.min(bank(c * S.pro, 10000), CAP) + bank(s * S.pro, 10000) : 0;
    var tax = half((c + s) * o.taxm, 100000), total = c + s + tax, txn = bank(total * T.bp, 10000) + T.fixed;
    var fees = commItem + commShip + pro + txn;
    return { commItem: commItem, commShip: commShip, comm: commItem + commShip, pro: pro, tax: tax, total: total, txn: txn, fees: fees, keep: c + s - fees };
  }
  function calc(x, ship, tax, seller, dest, cost, postage) {
    var price = amt(x), sh = amt(ship), k = amt(cost), pc = amt(postage), o = opts(seller, dest, tax);
    if (price <= 0) return { price: 0, ship: sh, comm: 0, pro: 0, tax: 0, total: 0, txn: 0, fees: 0, net: 0, cost: k, postage: pc, profit: r2(-k - pc), effective: null };
    var c = cents(price), s = cents(sh), p = parts(c, s, o);
    return { price: price, ship: sh, comm: p.comm / 100, pro: p.pro / 100, tax: p.tax / 100, total: p.total / 100, txn: p.txn / 100, fees: p.fees / 100, net: p.keep / 100, cost: k, postage: pc, profit: (p.keep - cents(k) - cents(pc)) / 100, effective: p.fees / (c + s) };
  }
  function perMonth(x, q, ship, tax, seller, dest, cost, postage) {
    var s = calc(x, ship, tax, seller, dest, cost, postage), n = count(q), gross = r2((s.price + s.ship) * n), fees = r2(s.fees * n), net = r2(s.net * n), costs = r2((s.cost + s.postage) * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest item price (to the cent) that keeps at least T after fees, with the shipping charge held fixed. Every order pays at least the $0.30 fixed fee, so keep <= price + shipping - $0.30; rounding can leave keep flat for a cent, so scan up from that bound. */
  function priceFor(T, ship, tax, seller, dest) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), s = cents(amt(ship)), o = opts(seller, dest, tax), hi = MAX_AMT * 100, c = Math.max(1, tc - s + 30);
    for (; c <= hi; c++) if (parts(c, s, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, SELLERS: SELLERS, TXN: TXN, CAP: CAP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, taxRate: taxRate, bank: bank, half: half, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.TcgFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.TcgFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("tc-price").value, sh = $("tc-ship").value, tx = $("tc-tax").value, sl = $("tc-seller").value, d = $("tc-dest").value, q = $("tc-qty").value, k = $("tc-cost").value, pc = $("tc-postage").value, w = [];
    var m = B.perMonth(x, q, sh, tx, sl, d, k, pc), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY || Number(tx) > B.MAX_TAX) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees take the whole sale or more.");
    if (c.price > 0 && c.profit < 0 && c.net > 0) w.push("After the card cost and postage this order loses money.");
    $("tc-warn").textContent = w.join(" ");
    set("tc-s-price", money(c.price)); set("tc-s-ship", money(c.ship)); set("tc-s-tax", money(c.tax)); set("tc-s-total", money(c.total)); set("tc-s-comm", money(c.comm)); set("tc-s-pro", money(c.pro)); set("tc-s-txn", money(c.txn)); set("tc-s-fees", money(c.fees)); set("tc-s-net", money(c.net)); set("tc-s-eff", pctS(c.effective)); set("tc-s-cost", money(c.cost)); set("tc-s-postage", money(c.postage)); set("tc-s-profit", money(c.profit));
    set("tc-m-gross", money(m.gross)); set("tc-m-fees", money(m.fees)); set("tc-m-net", money(m.net)); set("tc-m-cost", money(m.costs)); set("tc-m-profit", money(m.profit)); set("tc-y-net", money(m.year)); set("tc-y-profit", money(m.yearProfit));
    var T = $("tc-target").value, need = B.priceFor(T, sh, tx, sl, d);
    set("tc-need", B.amt(T) <= 0 ? "Enter how much you want to keep per order." : need == null ? "No price works for that amount." : "Price the card at " + money(need) + " (plus " + money(B.amt(sh)) + " shipping) to keep " + money(B.amt(T)) + " per order after TCGplayer's fees.");
  }
  ["tc-price", "tc-ship", "tc-tax", "tc-seller", "tc-dest", "tc-qty", "tc-cost", "tc-postage", "tc-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## TCGplayer seller fees in the US (checked Oct 29, 2026)

| Seller account | Commission on cards | Commission on shipping | Pro fee | Transaction fee per order |
|---|---|---|---|---|
| Marketplace seller (Level 1 to 4) | 10.75%, capped at $75 per card | 10.75%, no cap | none | 2.5% of the order total + $0.30 |
| Pro seller (not Direct) | 9.25%, capped at $75 per card | 9.25%, no cap | 2.5% of cards (capped at $75 per card) and shipping | 2.5% of the order total + $0.30 |

The order total used for the transaction fee is the cards plus shipping plus the buyer's sales tax, so the tax you collect raises the fee even though the tax itself passes through to the state. Orders from buyers outside the US pay a 3.5% + $0.30 transaction fee instead. A transaction is everything one buyer buys from you at checkout with the same shipping method, so the $0.30 is charged once per order, not once per card. The standard commission went from 10.25% to 10.75% and the cap from $50 to $75 per card on February 10, 2026. TCGplayer rounds each fee to the cent using bankers rounding, where an exact half cent goes to the nearest even cent.

These figures come from TCGplayer's own help center: [TCGplayer Fees](https://help.tcgplayer.com/hc/en-us/articles/201357836-TCGplayer-Fees) (last edited September 22, 2026), [Fee Calculation Examples](https://help.tcgplayer.com/hc/en-us/articles/360047732673-Fee-Calculation-Examples) and the [Marketplace Fee Cap Increase FAQ](https://help.tcgplayer.com/hc/en-us/articles/37531606328727-Marketplace-Fee-Cap-Increase-FAQ), with the February 2026 change from TCGplayer's January 8, 2026 [seller blog post](https://seller.tcgplayer.com/blog/important-changes-to-tcgplayer-direct-minimum-pricing-and-marketplace-fees). The calculator reproduces TCGplayer's own worked examples to the cent ($9.20 on a $65.31 card with $0.99 shipping, $36.39 on a $260 card with $8.82 shipping). It treats each order as a single card, assumes sales tax is charged on the card plus shipping at the rate you enter and rounded to the nearest cent, and applies the $75 cap to the commission and the Pro fee separately as the fee table shows. TCGplayer Direct, Sync accounts, Pro website sales and PayPal payouts for sellers outside the US have different fees and are not covered. Your exact fees show on each order in your seller portal, so check them for the final word.

## How the numbers are worked out

```
commission      = 10.75% x card price (max $75 per card) + 10.75% x shipping
transaction fee = 2.5% x (card + shipping + sales tax) + $0.30
                  (3.5% + $0.30 for buyers outside the US)
you keep        = card price + shipping - commission - transaction fee
profit          = you keep - what you paid for the card - postage
```

A Pro seller pays 9.25% instead of 10.75% plus a 2.5% Pro fee on the card and shipping, which works out higher in total.

A $20 card with $0.99 shipping and 7% sales tax has an order total of $22.46. You pay $2.26 in commission and $0.86 in transaction fees and keep $17.87, or $17.67 as a Pro seller. A $5 card with $0.99 shipping keeps $4.88, and a $1 card keeps $1.42, because the $0.30 per order weighs more on cheap cards. A $50 card with $4.99 shipping keeps $47.30, or $46.71 when the buyer is outside the US. A $1,000 card with $10.00 shipping hits the $75 cap and keeps $906.60. At 100 orders a month of $20 cards with $0.99 shipping, you pay $312.00 in fees and keep $1,787.00, or $21,444.00 a year. If each card cost you $8.00 and postage costs $0.78, your profit is $909.00 a month, or $10,908.00 a year. To keep $100 with $0.99 shipping and 7% tax, price the card at $114.87. To keep $20, price it at $22.46.

## FAQ

### How much does TCGplayer take from a sale in 2026?

A standard Level 1 to 4 seller pays a 10.75% commission on the card and shipping plus a transaction fee of 2.5% of the order total including tax plus $0.30. On a $20 card with $0.99 shipping and 7% tax that's $2.26 plus $0.86, so you keep $17.87.

### Does TCGplayer charge fees on shipping and sales tax?

The 10.75% commission applies to the shipping the buyer pays, with no cap. Sales tax is not commissioned, but it is part of the order total that the 2.5% transaction fee is charged on.

### Is there a cap on TCGplayer fees for expensive cards?

Yes. The marketplace commission on each card is capped at $75, which a standard seller reaches at about $698. A $1,000 card pays $75 in commission on the card, plus 10.75% of the shipping and the transaction fee.

### Is a TCGplayer Pro account cheaper?

Not on fees alone. Pro sellers pay 9.25% commission plus a 2.5% Pro fee, 11.75% in total against 10.75% for a standard seller, so a $20 card keeps $17.67 instead of $17.87. Pro accounts are about the extra selling tools, not lower fees.

### What should I price a card at on TCGplayer to keep a set amount?

First work out 1 minus 10.75% minus 2.5% times (1 plus your tax rate), which is 0.86575 at 7% tax. Then add $0.30 to what you want to keep, take away your shipping charge times 0.86575 and divide by 0.86575. For $100 with $0.99 shipping that gives about $114.86, and the calculator above finds the exact cent after rounding, $114.87.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does TCGplayer take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "A standard Level 1 to 4 seller pays a 10.75% commission on the card and shipping plus a transaction fee of 2.5% of the order total including tax plus $0.30. On a $20 card with $0.99 shipping and 7% tax that's $2.26 plus $0.86, so you keep $17.87."}},
{"@type": "Question", "name": "Does TCGplayer charge fees on shipping and sales tax?", "acceptedAnswer": {"@type": "Answer", "text": "The 10.75% commission applies to the shipping the buyer pays, with no cap. Sales tax is not commissioned, but it is part of the order total that the 2.5% transaction fee is charged on."}},
{"@type": "Question", "name": "Is there a cap on TCGplayer fees for expensive cards?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. The marketplace commission on each card is capped at $75, which a standard seller reaches at about $698. A $1,000 card pays $75 in commission on the card, plus 10.75% of the shipping and the transaction fee."}},
{"@type": "Question", "name": "Is a TCGplayer Pro account cheaper?", "acceptedAnswer": {"@type": "Answer", "text": "Not on fees alone. Pro sellers pay 9.25% commission plus a 2.5% Pro fee, 11.75% in total against 10.75% for a standard seller, so a $20 card keeps $17.67 instead of $17.87. Pro accounts are about the extra selling tools, not lower fees."}},
{"@type": "Question", "name": "What should I price a card at on TCGplayer to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "First work out 1 minus 10.75% minus 2.5% times (1 plus your tax rate), which is 0.86575 at 7% tax. Then add $0.30 to what you want to keep, take away your shipping charge times 0.86575 and divide by 0.86575. For $100 with $0.99 shipping that gives about $114.86, and the calculator above finds the exact cent after rounding, $114.87."}}
]}
</script>

## Related tools and guides

- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's final value fee for US sellers, the other big place to sell single cards and graded slabs
- [Whatnot fee calculator (2026)](whatnot-fee-calculator): Whatnot's 8% commission on the item price plus 2.9% + $0.30 processing, for selling cards on live streams
- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with TCGplayer. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
