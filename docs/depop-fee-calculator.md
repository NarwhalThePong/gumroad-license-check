---
layout: page
title: "Depop fee calculator (2026): what US sellers keep after the 3.3% + $0.45 fee and boosting"
description: "Free Depop fee calculator for US sellers. See Depop's payment processing fee and the 12% boosting fee on each sale, what you keep, your profit after what you paid for the item, monthly and yearly totals, and the exact price to list at to keep a set amount."
---

Depop doesn't charge US sellers a selling fee. What you do pay on each sale is a **payment processing fee of 3.3% + $0.45**, worked out on everything the buyer pays: the item price, the shipping and any sales tax. If the sale came from a **boosted listing**, Depop also takes a **12% boosting fee** on the item price. That means a $25 sale with no shipping or tax leaves you $23.72, or $20.72 if it was boosted, and a $100 sale leaves you $96.25, or $84.25 boosted. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="dp" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price (USD)<br><input id="dp-price" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping the buyer pays (USD)<br><input id="dp-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How you ship<br><select id="dp-method" style="width:100%;max-width:200px"><option value="depop" selected>Depop Shipping label</option><option value="own">My own shipping</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer's sales tax rate (%, optional)<br><input id="dp-tax" type="number" min="0" max="20" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="dp-boost" type="checkbox"> Sold through a boosted listing</label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="dp-qty" type="number" min="0" step="1" value="40" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you paid for the item (optional, USD)<br><input id="dp-cost" type="number" min="0" step="0.01" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="dp-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item price</td><td style="text-align:right" id="dp-s-price">$0.00</td></tr>
    <tr><td>Sales tax the buyer pays</td><td style="text-align:right" id="dp-s-tax">$0.00</td></tr>
    <tr><td>Buyer pays in total</td><td style="text-align:right" id="dp-s-buyer">$0.00</td></tr>
    <tr><td>Payment processing fee (3.3% + $0.45)</td><td style="text-align:right" id="dp-s-proc">$0.00</td></tr>
    <tr><td>Boosting fee (12%)</td><td style="text-align:right" id="dp-s-boost">$0.00</td></tr>
    <tr><td>Depop fees in total</td><td style="text-align:right" id="dp-s-fee">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="dp-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the item price</td><td style="text-align:right" id="dp-s-eff">n/a</td></tr>
    <tr><td>What you paid for the item</td><td style="text-align:right" id="dp-s-cost">$0.00</td></tr>
    <tr><td>Profit</td><td style="text-align:right" id="dp-s-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Item prices</td><td style="text-align:right" id="dp-m-gross">$0.00</td></tr>
    <tr><td>Depop fees</td><td style="text-align:right" id="dp-m-fees">$0.00</td></tr>
    <tr><td>You keep per month</td><td style="text-align:right"><strong id="dp-m-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of item prices</td><td style="text-align:right" id="dp-m-eff">n/a</td></tr>
    <tr><td>What you paid for the items</td><td style="text-align:right" id="dp-m-cost">$0.00</td></tr>
    <tr><td>Profit per month</td><td style="text-align:right" id="dp-m-profit">$0.00</td></tr>
    <tr><td>You keep per year (12 months like this)</td><td style="text-align:right" id="dp-y-net">$0.00</td></tr>
    <tr><td>Profit per year</td><td style="text-align:right" id="dp-y-profit">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Depop's fees (USD)<br><input id="dp-target" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="dp-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Depop US seller fee math (Depop Help Centre "Seller fees and charges" and "Boosted Listings Policy" (effective 23 March 2026), depop.com/sell, checked Oct 29, 2026): no Depop selling fee for US sellers; US payment processing fee (Depop Payments) 3.3% + $0.45, charged on the item sale price plus shipping costs and any applicable taxes; boosting fee 12% for US sellers (new listings from 23 March 2026), charged on the item sale price (excluding taxes) plus shipping only if you arrange your own shipping, and only when the sale counts as a boosted sale. Depop doesn't publish a rounding rule; each fee and the sales tax round to the nearest cent here (half a cent rounds up). */
(function (root) {
  var CHECKED = "2026-10-29";
  var PROC_PERMILLE = 33, PROC_FIXED = 45, BOOST_PCT = 12, MAX_AMT = 1000000, MAX_QTY = 1000000, MAX_TAX = 20;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function taxRate(v) { return Math.min(Math.round(num(v) * 100) / 100, MAX_TAX); }
  function cents(x) { return Math.round(x * 100); }
  /* all amounts in cents; o = { ship: cents, bp: tax basis points, boosted: bool, own: bool (own shipping) } */
  function parts(c, o) {
    if (c <= 0) return { tax: 0, proc: 0, boost: 0, fees: 0, keep: 0 };
    var s = o.ship, tax = Math.floor(((c + s) * o.bp + 5000) / 10000);
    var proc = Math.floor(((c + s + tax) * PROC_PERMILLE + 500) / 1000) + PROC_FIXED;
    var boost = o.boosted ? Math.floor(((c + (o.own ? s : 0)) * BOOST_PCT + 50) / 100) : 0;
    var fees = proc + boost;
    return { tax: tax, proc: proc, boost: boost, fees: fees, keep: c + (o.own ? s : 0) - fees };
  }
  function opts(ship, tax, boosted, own) { return { ship: cents(amt(ship)), bp: Math.round(taxRate(tax) * 100), boosted: !!boosted, own: !!own }; }
  function calc(x, ship, tax, boosted, own, cost) {
    var price = amt(x), k = amt(cost), o = opts(ship, tax, boosted, own);
    if (price <= 0) return { price: 0, ship: o.ship / 100, tax: 0, buyerPays: 0, proc: 0, boost: 0, fee: 0, net: 0, cost: k, profit: r2(-k), effective: null };
    var c = cents(price), p = parts(c, o);
    return { price: price, ship: o.ship / 100, tax: p.tax / 100, buyerPays: (c + o.ship + p.tax) / 100, proc: p.proc / 100, boost: p.boost / 100, fee: p.fees / 100, net: p.keep / 100, cost: k, profit: (p.keep - cents(k)) / 100, effective: p.fees / c };
  }
  function perMonth(x, q, ship, tax, boosted, own, cost) {
    var s = calc(x, ship, tax, boosted, own, cost), n = count(q), gross = r2(s.price * n), fees = r2(s.fee * n), net = r2(s.net * n), costs = r2(s.cost * n), profit = r2(net - costs);
    return { sale: s, count: n, gross: gross, fees: fees, net: net, costs: costs, profit: profit, year: r2(net * 12), yearProfit: r2(profit * 12), effective: gross > 0 ? fees / gross : null };
  }
  /* Smallest item price (to the cent) that keeps at least T per sale. Rounding can make what you keep dip by a cent as the price rises, so start from a price that provably keeps too little and step up one cent at a time. */
  function priceFor(T, ship, tax, boosted, own) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), o = opts(ship, tax, boosted, own), s = o.ship, r = o.bp / 10000;
    var k = 1 - 0.033 * (1 + r) - (o.boosted ? 0.12 : 0);
    var base = (o.own ? s : 0) - 0.033 * s * (1 + r) - PROC_FIXED - (o.boosted && o.own ? 0.12 * s : 0);
    /* keep(c) <= k*c + base + 2 for every c, so any c below this start keeps less than the target */
    var c = Math.max(1, Math.floor((tc - base - 2) / k) - 1), hi = MAX_AMT * 100;
    if (parts(hi, o).keep < tc) return null;
    while (c <= hi && parts(c, o).keep < tc) c++;
    return c > hi ? null : c / 100;
  }
  var api = { CHECKED: CHECKED, PROC_PERMILLE: PROC_PERMILLE, PROC_FIXED: PROC_FIXED, BOOST_PCT: BOOST_PCT, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, MAX_TAX: MAX_TAX, amt: amt, count: count, taxRate: taxRate, parts: parts, opts: opts, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.DepopFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.DepopFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var x = $("dp-price").value, sh = $("dp-ship").value, own = $("dp-method").value === "own", tx = $("dp-tax").value, bo = !!$("dp-boost").checked, q = $("dp-qty").value, k = $("dp-cost").value, w = [];
    var m = B.perMonth(x, q, sh, tx, bo, own, k), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.amt(sh) >= B.MAX_AMT || B.count(q) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (Number(tx) > B.MAX_TAX) w.push("Sales tax is capped at 20%.");
    if (c.price > 0 && c.net <= 0) w.push("At this price the fees take the whole sale or more.");
    if (own && c.ship > 0) w.push("With your own shipping, what you keep includes the buyer's shipping money, and you pay the postage out of it.");
    $("dp-warn").textContent = w.join(" ");
    set("dp-s-price", money(c.price)); set("dp-s-tax", money(c.tax)); set("dp-s-buyer", money(c.buyerPays)); set("dp-s-proc", money(c.proc)); set("dp-s-boost", money(c.boost)); set("dp-s-fee", money(c.fee)); set("dp-s-net", money(c.net)); set("dp-s-eff", pctS(c.effective)); set("dp-s-cost", money(c.cost)); set("dp-s-profit", money(c.profit));
    set("dp-m-gross", money(m.gross)); set("dp-m-fees", money(m.fees)); set("dp-m-net", money(m.net)); set("dp-m-eff", pctS(m.effective)); set("dp-m-cost", money(m.costs)); set("dp-m-profit", money(m.profit)); set("dp-y-net", money(m.year)); set("dp-y-profit", money(m.yearProfit));
    var T = $("dp-target").value, need = B.priceFor(T, sh, tx, bo, own);
    set("dp-need", B.amt(T) <= 0 ? "Enter how much you want to keep per sale." : need == null ? "No price works for that amount." : "List at " + money(need) + " to keep " + money(B.amt(T)) + " per sale after Depop's fees" + (bo ? " on a boosted sale." : "."));
  }
  ["dp-price", "dp-ship", "dp-method", "dp-tax", "dp-boost", "dp-qty", "dp-cost", "dp-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Depop seller fees in the US (checked Oct 29, 2026)

| Fee | Amount | Charged on |
|---|---|---|
| Selling fee | none for US sellers | |
| Payment processing fee (Depop Payments) | 3.3% + $0.45 | the item price plus shipping and any sales tax |
| Boosting fee, only on a boosted sale | 12% | the item price, plus the shipping if you arrange your own shipping |

The rates are from Depop's own help page on [seller fees and charges](https://depophelp.zendesk.com/hc/en-gb/articles/360001791127-Seller-fees-and-charges), which says "No Depop Selling fees will be charged to sellers based in the UK, US, or AUS" and lists the "US payment processing fee (Depop Payments)" as "3.3% + $0.45", charged "on the item sale price plus shipping costs and any applicable taxes". The same table gives the 12% boosting fee for US sellers and notes it applies to new listings from 23 March 2026. Depop's [Boosted Listings Policy](https://depophelp.zendesk.com/hc/en-gb/articles/9253129255569-Boosted-Listings-Policy) (effective 23 March 2026) explains that the boosting fee is only due when a buyer saw the boosted version of your listing and bought the item within 28 days, that it isn't charged on Depop Shipping labels, and that it comes on top of the payment processing fee. Depop's [selling page](https://www.depop.com/sell/) repeats that there are no selling fees and that payment processing and boosting fees still apply. All fees come out before your money is paid to your bank account, and they're reversed if the sale is refunded. Depop doesn't publish how it rounds a fraction of a cent, so the calculator rounds each fee (and the sales tax) to the nearest cent and may be a cent off on some prices. States differ on whether shipping is taxed, so the calculator applies the tax rate to the item price plus shipping, which you can set to 0. This page covers US sellers paid through Depop Payments only, not sellers in other countries or PayPal payouts. Your sale receipt in Depop shows the exact fees, so check it for the final word.

## How the numbers are worked out

```
buyer pays      = item price + shipping + sales tax
processing fee  = buyer pays x 3.3% + $0.45
boosting fee    = item price x 12%                    (only on a boosted sale)
                  (+ shipping x 12% if you ship it yourself)
you keep        = item price - fees                   (Depop Shipping label)
                = item price + shipping - fees        (your own shipping, before you pay postage)
profit          = you keep - what you paid for the item
```

With no shipping or tax, a $10 sale costs $0.78 and keeps $9.22, a $25 sale costs $1.28 and keeps $23.72, a $50 sale costs $2.10 and keeps $47.90 and a $100 sale costs $3.75 and keeps $96.25. If the $25 sale was boosted, the 12% adds $3.00, so the fees are $4.28 and you keep $20.72. A boosted $100 sale costs $15.75 and keeps $84.25. Shipping paid by the buyer still adds to the processing fee: a $25 item with $5 shipping on a Depop Shipping label costs $1.44 and keeps $23.56. At 40 sales of $25 a month you pay $51.20 in fees and keep $948.80, or $11,385.60 a year. If each item cost you $8, your profit is $628.80 a month, or $7,545.60 a year. To keep $20 per sale, list at $21.15, or $24.15 if the sale will be boosted. To keep $50, list at $52.17.

## The $0.45 per sale and the boost

Because $0.45 is charged on every sale, it weighs most on cheap items: the fees are 7.8% of a $10 sale but only 3.8% of a $100 sale, and at $0.47 or less there's nothing left. Boosting is the bigger cost when it applies. A boosted $25 sale pays 17.1% in fees instead of 5.1%, so it's worth boosting only if it gets you sales you wouldn't have made anyway.

## FAQ

### How much does Depop take from a sale in 2026?

For US sellers there's no selling fee. Depop charges a payment processing fee of 3.3% + $0.45 on the total the buyer pays, including shipping and tax, plus a 12% boosting fee on the item price if the sale came from a boosted listing.

### How much does Depop take on a $25 sale?

With no shipping or tax, the processing fee is $1.28, so you keep $23.72. If the sale was boosted, the 12% boosting fee adds $3.00, so the fees are $4.28 and you keep $20.72.

### Does Depop still charge a 10% selling fee?

Not for US sellers. Depop's fee table says no selling fees are charged to sellers based in the UK, US or Australia. The 10% selling fee still applies to sellers outside those countries.

### Does Depop charge fees on shipping?

The payment processing fee is charged on the item price plus shipping and any sales tax. The boosting fee isn't charged on Depop Shipping labels, but it is charged on the shipping if you arrange your own.

### What should I list at on Depop to keep a set amount?

Without boosting, shipping or tax, add $0.45 to what you want to keep and divide by 0.967. Keeping $20 means 20.45 / 0.967, which comes to $21.15. The calculator above finds the exact cent for any amount, with boosting, shipping and tax.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Depop take from a sale in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "For US sellers there's no selling fee. Depop charges a payment processing fee of 3.3% + $0.45 on the total the buyer pays, including shipping and tax, plus a 12% boosting fee on the item price if the sale came from a boosted listing."}},
{"@type": "Question", "name": "How much does Depop take on a $25 sale?", "acceptedAnswer": {"@type": "Answer", "text": "With no shipping or tax, the processing fee is $1.28, so you keep $23.72. If the sale was boosted, the 12% boosting fee adds $3.00, so the fees are $4.28 and you keep $20.72."}},
{"@type": "Question", "name": "Does Depop still charge a 10% selling fee?", "acceptedAnswer": {"@type": "Answer", "text": "Not for US sellers. Depop's fee table says no selling fees are charged to sellers based in the UK, US or Australia. The 10% selling fee still applies to sellers outside those countries."}},
{"@type": "Question", "name": "Does Depop charge fees on shipping?", "acceptedAnswer": {"@type": "Answer", "text": "The payment processing fee is charged on the item price plus shipping and any sales tax. The boosting fee isn't charged on Depop Shipping labels, but it is charged on the shipping if you arrange your own."}},
{"@type": "Question", "name": "What should I list at on Depop to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Without boosting, shipping or tax, add $0.45 to what you want to keep and divide by 0.967. Keeping $20 means 20.45 / 0.967, which comes to $21.15. The calculator above finds the exact cent for any amount, with boosting, shipping and tax."}}
]}
</script>

## Related tools and guides

- [Poshmark fee calculator (2026)](poshmark-fee-calculator): Poshmark's flat $2.95 fee under $15 or 20% from $15, and the $15 price cliff
- [Etsy fee calculator (2026)](etsy-fee-calculator): Etsy's listing, transaction and payment processing fees on each sale, your profit and margin
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's goods-and-services and checkout fees next to Stripe's card fees, for selling outside a marketplace
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Depop. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
