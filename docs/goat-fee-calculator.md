---
layout: page
title: "GOAT fee calculator (2026): what US sneaker sellers keep after commission, seller fee and cash out"
description: "Free GOAT fee calculator for US sellers. See the commission for your seller rating (9.5% at 90 or above, up to 25%), the $5 seller fee for prepaid shipping or $0 for drop-off, the 2.9% cash out fee, your payout, profit, monthly and yearly totals and the exact price to keep a set amount."
---

GOAT charges US sellers a **commission of 9.5%** of the listing price when your seller rating is 90 or above, plus a **seller fee of $5** if you ship with GOAT's prepaid label or **$0** if you use drop-off. When you move your earnings to your bank by ACH direct deposit or to PayPal, GOAT also takes a **2.9% cash out fee**. A $100 pair costs $9.50 plus $5.00, so $85.50 lands in your GOAT balance and you're paid $83.02 after cashing out, or $87.88 with drop-off. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="gt" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Listing price (USD)<br><input id="gt-price" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="gt-qty" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="gt-cost" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your seller rating<br><select id="gt-rating" style="width:100%;max-width:260px"><option value="a" selected>90 or above (9.5%)</option><option value="b">70 to 89 (15%)</option><option value="c">50 to 69 (20%)</option><option value="d">Below 50 (25%)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How you send it to GOAT<br><select id="gt-ship" style="width:100%;max-width:260px"><option value="prepaid" selected>Prepaid shipping label ($5 seller fee)</option><option value="dropoff">Drop-off ($0 seller fee)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How you take the money out<br><select id="gt-cash" style="width:100%;max-width:260px"><option value="ach" selected>Cash out by ACH or PayPal (2.9%)</option><option value="credit">Leave it on GOAT (no cash out fee)</option></select></label></p>
  </div>
  <p id="gt-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Listing price</td><td style="text-align:right"><span id="gt-s-price">$0.00</span></td></tr>
    <tr><td>Commission</td><td style="text-align:right"><span id="gt-s-comm">$0.00</span></td></tr>
    <tr><td>Seller fee</td><td style="text-align:right"><span id="gt-s-sfee">$0.00</span></td></tr>
    <tr><td>Earnings on GOAT</td><td style="text-align:right"><span id="gt-s-earn">$0.00</span></td></tr>
    <tr><td>Cash out fee (2.9%)</td><td style="text-align:right"><span id="gt-s-cash">$0.00</span></td></tr>
    <tr><td>Total GOAT fees</td><td style="text-align:right"><span id="gt-s-fees">$0.00</span></td></tr>
    <tr><td>You're paid</td><td style="text-align:right"><strong id="gt-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right"><span id="gt-s-eff">$0.00</span></td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right"><span id="gt-s-cost">$0.00</span></td></tr>
    <tr><td>Profit</td><td style="text-align:right"><span id="gt-s-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales</td><td style="text-align:right"><span id="gt-m-gross">$0.00</span></td></tr>
    <tr><td>GOAT fees</td><td style="text-align:right"><span id="gt-m-fees">$0.00</span></td></tr>
    <tr><td>You're paid per month</td><td style="text-align:right"><strong id="gt-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right"><span id="gt-m-cost">$0.00</span></td></tr>
    <tr><td>Profit per month</td><td style="text-align:right"><span id="gt-m-profit">$0.00</span></td></tr>
    <tr><td>You're paid per year (12 months like this)</td><td style="text-align:right"><span id="gt-y-net">$0.00</span></td></tr>
    <tr><td>Profit per year</td><td style="text-align:right"><span id="gt-y-profit">$0.00</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to be paid per sale after GOAT's fees (USD)<br><input id="gt-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="gt-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* GOAT US seller fee math (GOAT "Fee Policy", goat.com/fees, last updated Aug 1, 2026; checked Oct 29, 2026). Commission on the listing price by seller rating: 90 or above 9.5%, 70-89 15%, 50-69 20%, below 50 25%, plus the seller fee for your location: United States drop-off $0, United States prepaid shipping $5. Cash out fee: 2.9% when earnings are deposited by ACH direct deposit or PayPal (not modelled as charged when earnings stay on GOAT). Each fee rounds to the nearest cent. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, CASHOUT_BP = 290;
  var RATINGS = { a: 950, b: 1500, c: 2000, d: 2500 }, SELLER_FEE = { prepaid: 500, dropoff: 0 };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(x) { return Math.round(x * 100); }
  function rnd(x) { return Math.floor(x + 0.5 + 1e-9); }
  /* o = { rating: a-d, ship: prepaid|dropoff, cashout: true when paid out by ACH or PayPal } */
  function opts(rating, ship, cashout) { return { rating: RATINGS[rating] ? rating : "a", ship: SELLER_FEE.hasOwnProperty(ship) ? ship : "prepaid", cashout: !(cashout === false || cashout === "credit" || cashout === "0") }; }
  function parts(c, o) {
    if (c <= 0) return { comm: 0, sfee: 0, earn: 0, cash: 0, fees: 0, keep: 0 };
    var comm = rnd(c * RATINGS[o.rating] / 10000), sfee = SELLER_FEE[o.ship], earn = c - comm - sfee, cash = o.cashout && earn > 0 ? rnd(earn * CASHOUT_BP / 10000) : 0, fees = comm + sfee + cash;
    return { comm: comm, sfee: sfee, earn: earn, cash: cash, fees: fees, keep: c - fees };
  }
  function calc(x, rating, ship, cashout, cost) {
    var price = amt(x), k = amt(cost), o = opts(rating, ship, cashout);
    if (price <= 0) return { price: 0, comm: 0, sfee: 0, earn: 0, cash: 0, fees: 0, net: 0, cost: k, profit: r2(-k), effective: null, rate: RATINGS[o.rating] / 100 };
    var c = cents(price), p = parts(c, o);
    return { price: price, comm: p.comm / 100, sfee: p.sfee / 100, earn: p.earn / 100, cash: p.cash / 100, fees: p.fees / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fees / c, rate: RATINGS[o.rating] / 100 };
  }
  function perMonth(x, q, rating, ship, cashout, cost) {
    var s = calc(x, rating, ship, cashout, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fees * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12) };
  }
  /* Smallest listing price (to the cent) that keeps at least T. keep never exceeds the price minus the seller fee, and rounding can leave keep flat for a cent, so scan up from a safe lower bound. */
  function priceFor(T, rating, ship, cashout) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(rating, ship, cashout), hi = MAX_AMT * 100, c = Math.max(1, tc + SELLER_FEE[o.ship]);
    for (; c <= hi; c++) if (parts(c, o).keep >= tc) return c / 100;
    return null;
  }
  var api = { CHECKED: CHECKED, RATINGS: RATINGS, SELLER_FEE: SELLER_FEE, CASHOUT_BP: CASHOUT_BP, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, opts: opts, parts: parts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.GoatFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.GoatFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("gt-price").value, rt = $("gt-rating").value, sp = $("gt-ship").value, ch = $("gt-cash").value === "ach", q = $("gt-qty").value, k = $("gt-cost").value, w = [];
    var m = B.perMonth(x, q, rt, sp, ch, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees take the whole sale or more.");
    if (ch && c.earn > 0 && c.earn < 25) w.push("GOAT only lets you cash out once your earnings are over $25.");
    $("gt-warn").textContent = w.join(" ");
    set("gt-s-price", money(c.price)); set("gt-s-comm", money(c.comm)); set("gt-s-sfee", money(c.sfee)); set("gt-s-earn", money(c.earn)); set("gt-s-cash", money(c.cash)); set("gt-s-fees", money(c.fees)); set("gt-s-net", money(c.net)); set("gt-s-eff", pctS(c.effective)); set("gt-s-cost", money(c.cost)); set("gt-s-profit", money(c.profit));
    set("gt-m-gross", money(m.gross)); set("gt-m-fees", money(m.fees)); set("gt-m-net", money(m.net)); set("gt-m-cost", money(m.costs)); set("gt-m-profit", money(m.profit)); set("gt-y-net", money(m.year)); set("gt-y-profit", money(m.yearProfit));
    var T = $("gt-target").value, need = B.priceFor(T, rt, sp, ch);
    set("gt-need", B.amt(T) <= 0 ? "Enter how much you want to be paid per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to be paid " + money(B.amt(T)) + " per sale after GOAT's fees" + (ch ? " and cashing out." : "."));
  }
  ["gt-price", "gt-rating", "gt-ship", "gt-cash", "gt-qty", "gt-cost", "gt-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## GOAT seller fees in the US (checked Oct 29, 2026)

| Seller rating | Commission on the listing price | Seller fee, prepaid shipping | Seller fee, drop-off |
|---|---|---|---|
| 90 or above | 9.5% | $5 | $0 |
| 70 to 89 | 15% | $5 | $0 |
| 50 to 69 | 20% | $5 | $0 |
| Below 50 | 25% | $5 | $0 |

Every seller starts at a rating of 90. Each seller cancellation takes 10 points off and each successful sale adds 2, so a single cancellation drops you to the 15% band until you make five more sales. Both the commission and the seller fee come out of the listing price, and the commission is charged only when an item sells. Cashing out to your bank by ACH direct deposit or to PayPal costs 2.9% of the amount, which GOAT sometimes reduces or waives during promotions, and you can only cash out once your earnings are over $25. Accounts with no activity for two years may also be charged a $1 monthly maintenance fee in some states. Canadian sellers pay 12.4% at the top rating band, and sellers in other places pay a different seller fee, so this calculator covers US sellers.

These figures come from GOAT's own [Fee Policy](https://www.goat.com/fees), last updated August 1, 2026. The calculator assumes the cash out fee is 2.9% of the whole amount you cash out after commission and the seller fee, and that each fee rounds to the nearest cent. Your exact fees show in the GOAT app on each sale, so check them for the final word.

## How the numbers are worked out

```
commission  = rating rate (9.5%, 15%, 20% or 25%) x listing price
seller fee  = $5 with a prepaid shipping label, $0 with drop-off
earnings    = listing price - commission - seller fee
cash out    = 2.9% x earnings (ACH or PayPal), $0 if left on GOAT
you're paid = earnings - cash out
profit      = you're paid - what you paid for the item
```

At a rating of 90 or above, a $100 pair is paid out at $83.02 with a prepaid label and $87.88 with drop-off, or $85.50 if you leave the money on GOAT. A $50 pair pays $4.75 in commission and $5.00 in seller fees, leaving $40.25, and you're paid $39.08 after cashing out. A $200 pair pays $19.00 plus $5.00, leaving $176.00, and you're paid $170.90, but at a rating between 70 and 89 the commission jumps to $30.00 and you're paid $160.21. A $150 pair at a rating between 50 and 69 is paid $111.66, and a $1,000 pair at the top rating is paid $873.90. At 10 sales of $200 pairs a month, you pay $291.00 in fees and are paid $1,709.00, or $20,508.00 a year. If each pair cost you $120, your profit is $509.00 a month, or $6,108.00 a year. To be paid $100 after cashing out, list at $119.33, or $113.80 with drop-off. To be paid $20, list at $28.29.

## FAQ

### How much does GOAT take from a sale in 2026?

With a seller rating of 90 or above, a 9.5% commission plus a $5 seller fee if you use GOAT's prepaid shipping label, then 2.9% when you cash out by ACH or PayPal. On a $100 sale that's $9.50 plus $5.00 plus $2.48, so you're paid $83.02.

### What is the GOAT seller rating and how does it change my fees?

Everyone starts at 90. A cancellation takes off 10 points and a successful sale adds 2. At 90 or above the commission is 9.5%, from 70 to 89 it's 15%, from 50 to 69 it's 20% and below 50 it's 25%, and a rating under 50 can also lead to an account review.

### Is GOAT drop-off cheaper than shipping?

Yes. US drop-off has a $0 seller fee instead of $5 for a prepaid label, so on a $100 pair you're paid $87.88 instead of $83.02 after cashing out.

### Can I avoid the GOAT cash out fee?

The 2.9% fee applies when you move earnings to your bank by ACH direct deposit or to PayPal. If you leave the money on GOAT and spend it there, no cash out fee is charged, and GOAT sometimes waives or lowers the fee during promotions.

### What should I list at on GOAT to keep a set amount?

With a prepaid label and a cash out, divide what you want by 0.971, add $5 and divide by 0.905. For $100 that gives about $119.32, and the calculator above finds the exact cent after rounding, $119.33.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does GOAT take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "With a seller rating of 90 or above, a 9.5% commission plus a $5 seller fee if you use GOAT's prepaid shipping label, then 2.9% when you cash out by ACH or PayPal. On a $100 sale that's $9.50 plus $5.00 plus $2.48, so you're paid $83.02."}},
{"@type": "Question", "name": "What is the GOAT seller rating and how does it change my fees?", "acceptedAnswer": {"@type": "Answer", "text": "Everyone starts at 90. A cancellation takes off 10 points and a successful sale adds 2. At 90 or above the commission is 9.5%, from 70 to 89 it's 15%, from 50 to 69 it's 20% and below 50 it's 25%, and a rating under 50 can also lead to an account review."}},
{"@type": "Question", "name": "Is GOAT drop-off cheaper than shipping?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. US drop-off has a $0 seller fee instead of $5 for a prepaid label, so on a $100 pair you're paid $87.88 instead of $83.02 after cashing out."}},
{"@type": "Question", "name": "Can I avoid the GOAT cash out fee?", "acceptedAnswer": {"@type": "Answer", "text": "The 2.9% fee applies when you move earnings to your bank by ACH direct deposit or to PayPal. If you leave the money on GOAT and spend it there, no cash out fee is charged, and GOAT sometimes waives or lowers the fee during promotions."}},
{"@type": "Question", "name": "What should I list at on GOAT to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "With a prepaid label and a cash out, divide what you want by 0.971, add $5 and divide by 0.905. For $100 that gives about $119.32, and the calculator above finds the exact cent after rounding, $119.33."}}
]}
</script>

## Related tools and guides

- [StockX fee calculator (2026)](stockx-fee-calculator): StockX's 9% to 7% transaction fee by Seller Level plus 3% processing and $5 seller shipping, for comparing the other big sneaker marketplace
- [Grailed fee calculator (2026)](grailed-fee-calculator): Grailed's 6% or 9% commission plus 3.49% + $0.49 processing, for selling streetwear and sneakers on Grailed instead
- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 8% final value fee on athletic shoes at $150 and up with no per-order fee
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with GOAT. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
