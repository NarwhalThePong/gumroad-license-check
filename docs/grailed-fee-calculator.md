---
layout: page
title: "Grailed fee calculator (2026): what US sellers keep after commission and processing"
description: "Free Grailed fee calculator for US sellers. See the 6% or 9% seller commission, the 3.49% + $0.49 payment processing fee, what you keep with a Grailed Label or your own label, your profit, monthly and yearly totals, the $120 price line and the exact price to list at to keep a set amount."
---

Grailed charges US sellers two fees on every sale: a **seller commission** of **6% (at least $1.99) when the sale price is under $120**, or **9% at $120 and above**, plus a **payment processing fee** of **3.49% + $0.49** for a US buyer once you're set up with Stripe. A $50 sale with no shipping costs $3.00 in commission and $2.24 in processing, so you keep $44.76. A $150 sale costs $13.50 plus $5.73 and keeps $130.77. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="gr" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="gr-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping cost (USD)<br><input id="gr-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Who pays shipping<br><select id="gr-who" style="width:100%;max-width:200px"><option value="buyer" selected>The buyer</option><option value="seller">Me (free shipping for the buyer)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping label<br><select id="gr-lab" style="width:100%;max-width:200px"><option value="grailed" selected>Grailed Label</option><option value="own">My own label</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment setup and buyer<br><select id="gr-pay" style="width:100%;max-width:260px"><option value="us" selected>Stripe, US buyer (3.49% + $0.49)</option><option value="intl">Stripe, international buyer (4.99% + $0.49)</option><option value="us-no">Not on Stripe, US buyer (3.49% + $0.99)</option><option value="intl-no">Not on Stripe, international buyer (5.49% + $0.99)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="gr-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="gr-cost" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="gr-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right" id="gr-s-price">$0.00</td></tr>
    <tr><td>Shipping the buyer pays</td><td style="text-align:right" id="gr-s-bship">$0.00</td></tr>
    <tr><td>Buyer pays in total, before sales tax</td><td style="text-align:right" id="gr-s-buyer">$0.00</td></tr>
    <tr><td>Sale price used for the commission rate</td><td style="text-align:right" id="gr-s-base">$0.00</td></tr>
    <tr><td>Seller commission (<span id="gr-s-rate">6%</span>)</td><td style="text-align:right" id="gr-s-comm">$0.00</td></tr>
    <tr><td>Payment processing fee</td><td style="text-align:right" id="gr-s-proc">$0.00</td></tr>
    <tr><td>Total Grailed fees</td><td style="text-align:right" id="gr-s-fees">$0.00</td></tr>
    <tr><td>Shipping label you pay</td><td style="text-align:right" id="gr-s-label">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="gr-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right" id="gr-s-eff">n/a</td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right" id="gr-s-cost">$0.00</td></tr>
    <tr><td>Profit</td><td style="text-align:right" id="gr-s-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right" id="gr-m-gross">$0.00</td></tr>
    <tr><td>Seller commissions</td><td style="text-align:right" id="gr-m-comm">$0.00</td></tr>
    <tr><td>Payment processing fees</td><td style="text-align:right" id="gr-m-proc">$0.00</td></tr>
    <tr><td>Shipping labels you pay</td><td style="text-align:right" id="gr-m-labels">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="gr-m-net">$0.00</strong></td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right" id="gr-m-cost">$0.00</td></tr>
    <tr><td>Profit per month</td><td style="text-align:right" id="gr-m-profit">$0.00</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="gr-y-net">$0.00</td></tr>
    <tr><td>Profit per year</td><td style="text-align:right" id="gr-y-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Grailed's fees and shipping (USD)<br><input id="gr-target" type="number" min="0" step="0.01" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="gr-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Grailed US seller fee math (Grailed Help "What are the fees?", article 30282580172045, updated May 13, 2026, and "Does Grailed charge a payment processing fee?", article 30299544492301; checked Oct 29, 2026): seller commission 9% when the sale price is $120 or more, 6% with a $1.99 minimum under $120 (sales on or after May 20, 2026). The sale price is the listing price plus buyer-paid shipping when you don't use a Grailed Label, or the listing price only with a Grailed Label. Payment processing, onboarded with Stripe: 3.49% + $0.49 for US payments, 4.99% + $0.49 for international payments; not onboarded: 3.49% + $0.99 US, 5.49% + $0.99 international. Grailed doesn't say which amount the processing percentage is charged on; here it's charged on what the buyer pays for the item and shipping, before sales tax. Each fee rounds to the nearest cent (half a cent rounds up). */
(function (root) {
  var CHECKED = "2026-10-29";
  var LOW_PCT = 6, HIGH_PCT = 9, MIN_FEE = 199, TIER = 12000, MAX_AMT = 1000000, MAX_QTY = 1000000;
  var PAY = { us: [349, 49], intl: [499, 49], "us-no": [349, 99], "intl-no": [549, 99] };
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(x) { return Math.round(x * 100); }
  function commission(base) { return base < TIER ? Math.max(Math.floor((base * LOW_PCT + 50) / 100), MIN_FEE) : Math.floor((base * HIGH_PCT + 50) / 100); }
  /* all amounts in cents; o = { ship: cents, sellerShips: bool, own: bool (own label instead of a Grailed Label), pay: key of PAY } */
  function parts(c, o) {
    if (c <= 0) return { saleBase: 0, comm: 0, procBase: 0, proc: 0, label: 0, keep: 0 };
    var bs = o.sellerShips ? 0 : o.ship, saleBase = c + (o.own ? bs : 0), procBase = c + bs, r = PAY[o.pay] || PAY.us;
    var comm = commission(saleBase), proc = Math.floor((procBase * r[0] + 5000) / 10000) + r[1], label = o.sellerShips ? o.ship : 0;
    return { saleBase: saleBase, comm: comm, procBase: procBase, proc: proc, label: label, keep: c - comm - proc - label };
  }
  function opts(ship, sellerShips, own, pay) { return { ship: cents(amt(ship)), sellerShips: !!sellerShips, own: !!own, pay: PAY[pay] ? pay : "us" }; }
  function calc(x, ship, sellerShips, own, pay, cost) {
    var price = amt(x), k = amt(cost), o = opts(ship, sellerShips, own, pay), bs = o.sellerShips ? 0 : o.ship;
    if (price <= 0) return { price: 0, buyerShip: bs / 100, buyerPays: 0, saleBase: 0, rate: null, comm: 0, proc: 0, fees: 0, label: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o);
    return { price: price, buyerShip: bs / 100, buyerPays: (c + bs) / 100, saleBase: p.saleBase / 100, rate: p.saleBase < TIER ? LOW_PCT : HIGH_PCT, comm: p.comm / 100, proc: p.proc / 100, fees: (p.comm + p.proc) / 100, label: p.label / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: (p.comm + p.proc) / c };
  }
  function perMonth(x, q, ship, sellerShips, own, pay, cost) {
    var s = calc(x, ship, sellerShips, own, pay, cost), n = count(q), gross = r2(s.price * n), comms = r2(s.comm * n), procs = r2(s.proc * n), labels = r2(s.label * n);
    var net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, comms: comms, procs: procs, fees: r2(comms + procs), labels: labels, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12), effective: gross > 0 ? r2(comms + procs) / gross : null };
  }
  /* Smallest item price (to the cent) that keeps at least T per sale. keep isn't monotonic (it drops at the $120 line and can dip a cent from rounding), so: commission >= 6% - 0.5c and 9% - 0.5c above the line give lower bounds; scan up from them in each tier and take the smaller hit. */
  function priceFor(T, ship, sellerShips, own, pay) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, sellerShips, own, pay), r = PAY[o.pay], pp = r[0] / 10000, hi = MAX_AMT * 100;
    var label = o.sellerShips ? o.ship : 0, extra = o.own && !o.sellerShips ? o.ship : 0, keep = function (c) { return parts(c, o).keep; };
    var best = null, c = Math.max(1, Math.floor((tc - 1 + r[1] + label) / (1 - LOW_PCT / 100 - pp)) - 1), tierStart = Math.max(1, TIER - extra);
    for (; c < tierStart && c <= hi; c++) if (keep(c) >= tc) { best = c; break; }
    if (best == null) {
      c = Math.max(tierStart, Math.floor((tc - 1 + r[1] + label) / (1 - HIGH_PCT / 100 - pp)) - 1);
      if (keep(hi) < tc && c >= hi) return null;
      for (; c <= hi; c++) if (keep(c) >= tc) { best = c; break; }
    }
    return best == null ? null : best / 100;
  }
  var api = { CHECKED: CHECKED, LOW_PCT: LOW_PCT, HIGH_PCT: HIGH_PCT, MIN_FEE: MIN_FEE, TIER: TIER, PAY: PAY, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, commission: commission, parts: parts, opts: opts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.GrailedFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.GrailedFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("gr-price").value, sh = $("gr-ship").value, seller = $("gr-who").value === "seller", own = $("gr-lab").value === "own", pay = $("gr-pay").value, q = $("gr-qty").value, k = $("gr-cost").value, w = [];
    var m = B.perMonth(x, q, sh, seller, own, pay, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees and shipping take the whole sale or more.");
    if (c.rate === 9 && c.saleBase < 125) w.push("Just over the $120 line the commission jumps from 6% to 9%, so a price a little under $120 can keep more.");
    $("gr-warn").textContent = w.join(" ");
    set("gr-s-price", money(c.price)); set("gr-s-bship", money(c.buyerShip)); set("gr-s-buyer", money(c.buyerPays)); set("gr-s-base", money(c.saleBase)); set("gr-s-rate", c.rate == null ? "n/a" : c.rate + "%"); set("gr-s-comm", money(c.comm)); set("gr-s-proc", money(c.proc)); set("gr-s-fees", money(c.fees)); set("gr-s-label", money(c.label)); set("gr-s-net", money(c.net)); set("gr-s-eff", pctS(c.effective)); set("gr-s-cost", money(c.cost)); set("gr-s-profit", money(c.profit));
    set("gr-m-gross", money(m.gross)); set("gr-m-comm", money(m.comms)); set("gr-m-proc", money(m.procs)); set("gr-m-labels", money(m.labels)); set("gr-m-net", money(m.net)); set("gr-m-cost", money(m.costs)); set("gr-m-profit", money(m.profit)); set("gr-y-net", money(m.year)); set("gr-y-profit", money(m.yearProfit));
    var T = $("gr-target").value, need = B.priceFor(T, sh, seller, own, pay);
    set("gr-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Grailed's fees" + (seller && B.amt(sh) > 0 ? " and the shipping label." : "."));
  }
  ["gr-price", "gr-ship", "gr-who", "gr-lab", "gr-pay", "gr-qty", "gr-cost", "gr-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Grailed seller fees in the US (checked Oct 29, 2026)

| Fee | Amount | Who pays | Charged on |
|---|---|---|---|
| Listing | free | | |
| Seller commission, sale price under $120 | 6%, at least $1.99 | seller | the sale price (sales on or after May 20, 2026) |
| Seller commission, sale price $120 and above | 9% | seller | the sale price |
| Payment processing, on Stripe, US buyer | 3.49% + $0.49 | seller | each sale |
| Payment processing, on Stripe, international buyer | 4.99% + $0.49 | seller | each sale |
| Payment processing, not on Stripe | 3.49% + $0.99 (US buyer) or 5.49% + $0.99 (international) | seller | each sale |
| Grailed Label shipping | the label cost | buyer, or you if you offer free shipping | each sale |

The commission comes from Grailed's own help page, [What are the fees?](https://support.grailed.com/hc/en-us/articles/30282580172045-What-are-the-fees) (updated May 13, 2026), which lists a 9% "Standard" fee for a sale price of "$120 and above" and a "Reduced" fee of "6% (minimum $1.99)" under $120, "Applicable to sales on/after 5/20/26". The same page says the sale price is "The listing price your item sells for, plus Any shipping costs charged to the buyer, if you are not using a Grailed Label", and "If you use a Grailed Label, the sale price is based on the listing price only." The processing rates are from [Does Grailed charge a payment processing fee?](https://support.grailed.com/hc/en-us/articles/30299544492301-Does-Grailed-charge-a-payment-processing-fee), which lists "US domestic payments 3.49% + .49 USD" and "International payments 4.99% + .49 USD" once you're onboarded with Stripe, and 3.49% + $0.99 and 5.49% + $0.99 if you aren't. [What are Grailed Labels?](https://support.grailed.com/hc/en-us/articles/32229125355661-What-are-Grailed-Labels) explains that US buyers pay for the label, and if you offer free shipping the label cost "will be deducted from your payment". Grailed doesn't say which amount the processing percentage is charged on, so the calculator charges it on everything the buyer pays for the item and shipping, before sales tax, and rounds each fee to the nearest cent. Grailed also says promotional commission rates may apply to some sales. Your sale details on Grailed show the exact fees, so check them for the final word.

## How the numbers are worked out

```
sale price    = item price                                   (Grailed Label)
              = item price + shipping the buyer pays         (your own label)
commission    = 6% of the sale price, at least $1.99         (sale price under $120)
              = 9% of the sale price                         (sale price $120 and above)
processing    = 3.49% x (item price + buyer shipping) + $0.49   (Stripe, US buyer)
you keep      = item price - commission - processing
                - label cost                                 (only if you offer free shipping)
per month     = you keep x sales
profit        = you keep - what you paid for the item
```

With no shipping and a US buyer, a $20 sale costs $1.99 in commission (the minimum) and $1.19 in processing and keeps $16.82. A $50 sale costs $3.00 and $2.24 and keeps $44.76, a $100 sale costs $6.00 and $3.98 and keeps $90.02, and a $300 sale costs $27.00 and $10.96 and keeps $262.04. If a buyer pays $10 for a Grailed Label on a $50 item, the commission stays $3.00, processing is $2.58 and you keep $44.42. With your own label and the same $10 charged to the buyer, the commission is charged on $60 and you keep $43.82. Offer free shipping with a $10 label and you keep $34.76. An international buyer costs you $2.99 in processing on a $50 sale instead of $2.24. At 20 sales of $50 a month you pay $104.80 in fees and keep $895.20, or $10,742.40 a year. If each item cost you $20, your profit is $495.20 a month, or $5,942.40 a year. To keep $40 per sale, list at $44.73. To keep $100, list at $111.02. To keep $40 after paying a $10 label yourself, list at $55.79.

## The $120 price line

Because the commission jumps from 6% to 9% at a $120 sale price, a higher price can leave you with less. A $119.99 sale keeps $108.11, but a $120.00 sale keeps only $104.52. You need to list at $124.10 just to keep the same $108.11, and $124.11 is the first price that keeps more. If an item would sell for somewhere between $120 and $124.10, pricing it at $119.99 keeps more. With your own label, buyer-paid shipping counts toward the $120 too.

## FAQ

### How much does Grailed take from a sale in 2026?

A seller commission of 6% (at least $1.99) when the sale price is under $120, or 9% from $120, plus a payment processing fee of 3.49% + $0.49 for a US buyer once you're set up with Stripe. On a $50 sale that's $5.24 in total, so you keep $44.76.

### How much does Grailed take on a $100 sale?

With no shipping and a US buyer, the commission is $6.00 and processing is $3.98, so Grailed's fees are $9.98 and you keep $90.02.

### Does Grailed charge commission on shipping?

Only if you use your own label. With a Grailed Label the commission is charged on the listing price only. With your own label, shipping charged to the buyer is added to the sale price for the commission.

### What is the minimum Grailed fee?

For sales under $120 on or after May 20, 2026, the 6% commission has a $1.99 minimum, so it applies to items under about $33. The payment processing fee is charged on top.

### What should I list at on Grailed to keep a set amount?

Under the $120 line, divide what you want to keep plus $0.49 by about 0.9051. For $40 that gives $44.74, and because each fee is rounded to the cent, $44.73 is already enough. Above the line, divide by about 0.8751 instead. The calculator above finds the exact cent for any amount, shipping choice and buyer.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Grailed take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "A seller commission of 6% (at least $1.99) when the sale price is under $120, or 9% from $120, plus a payment processing fee of 3.49% + $0.49 for a US buyer once you're set up with Stripe. On a $50 sale that's $5.24 in total, so you keep $44.76."}},
{"@type": "Question", "name": "How much does Grailed take on a $100 sale?", "acceptedAnswer": {"@type": "Answer", "text": "With no shipping and a US buyer, the commission is $6.00 and processing is $3.98, so Grailed's fees are $9.98 and you keep $90.02."}},
{"@type": "Question", "name": "Does Grailed charge commission on shipping?", "acceptedAnswer": {"@type": "Answer", "text": "Only if you use your own label. With a Grailed Label the commission is charged on the listing price only. With your own label, shipping charged to the buyer is added to the sale price for the commission."}},
{"@type": "Question", "name": "What is the minimum Grailed fee?", "acceptedAnswer": {"@type": "Answer", "text": "For sales under $120 on or after May 20, 2026, the 6% commission has a $1.99 minimum, so it applies to items under about $33. The payment processing fee is charged on top."}},
{"@type": "Question", "name": "What should I list at on Grailed to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Under the $120 line, divide what you want to keep plus $0.49 by about 0.9051. For $40 that gives $44.74, and because each fee is rounded to the cent, $44.73 is already enough. Above the line, divide by about 0.8751 instead. The calculator above finds the exact cent for any amount, shipping choice and buyer."}}
]}
</script>

## Related tools and guides

- [Mercari fee calculator (2026)](mercari-fee-calculator): Mercari's flat 10% selling fee on the item price and buyer-paid shipping, and free versus buyer-paid shipping
- [eBay fee calculator (2026)](ebay-fee-calculator): eBay's 13.6% final value fee for most categories plus $0.30 or $0.40 per order, charged on shipping and sales tax too
- [StockX fee calculator (2026)](stockx-fee-calculator): StockX's 9% to 7% transaction fee by Seller Level ($5 minimum) plus 3% processing and $5 seller shipping, for sneaker and streetwear sellers
- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 fee under $15 or 20% from $15, and the $15 price cliff
- [Depop fee calculator (2026)](depop-fee-calculator): Depop's 3.3% + $0.45 processing fee with no selling fee for US sellers, plus 12% on boosted sales
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Grailed. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
