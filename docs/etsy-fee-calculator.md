---
layout: page
title: "Etsy fee calculator: fees, profit, margin and the price you need (US, 2026)"
description: "Free Etsy fee and profit calculator for US sellers. Enter your price, shipping, cost of goods and label cost to see the listing fee, 6.5% transaction fee, 3% + $0.25 payment processing and Offsite Ads fees, your payout, profit, margin and the price you need for a target margin."
---

See what an Etsy sale actually pays you. Enter the item price, what you charge for shipping, what the item costs you to make and what the shipping label costs, and the calculator adds up every Etsy fee on the order: the **$0.20 listing fee** per item sold, the **6.5% transaction fee** on the item price, shipping and gift wrap, **payment processing of 3% + $0.25** (US shops), and the **Offsite Ads fee** (15%, or 12%, capped at $100) if the order came from an Etsy ad on another site. Then it shows your payout, profit and margin, and solves for the price you need to hit a target margin or profit. All rates can be edited. Everything runs in your browser and nothing is sent anywhere.

<div id="efc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:720px">
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Item price, per item ($)<br><input id="efc-price" type="number" min="0" step="0.01" value="28" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Quantity in the order<br><input id="efc-qty" type="number" min="1" step="1" value="1" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping you charge the buyer ($)<br><input id="efc-ship" type="number" min="0" step="0.01" value="6.50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Gift wrap charged ($, optional)<br><input id="efc-wrap" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cost of goods, per item ($)<br><input id="efc-cogs" type="number" min="0" step="0.01" value="9.40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping label cost ($)<br><input id="efc-label" type="number" min="0" step="0.01" value="5.10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Offsite Ads<br><select id="efc-ads" style="width:100%;max-width:220px"><option value="none" selected>Not an Offsite Ads order</option><option value="std">Offsite Ads order, 15%</option><option value="low">Offsite Ads order, 12%</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buyer's sales tax rate (%, optional)<br><input id="efc-tax" type="number" min="0" max="20" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><small>Use the item price after any sale or coupon discount. Etsy collects and pays US sales tax for you, so it isn't your income, but the payment processing fee is charged on it. Leave the tax rate at 0 if you don't know it.</small></p>
  <details style="margin:0 0 12px">
    <summary>Fee rates (US shop, October 2026; edit for other countries or rate changes)</summary>
    <div style="display:flex;flex-wrap:wrap;gap:4px 24px;margin-top:8px">
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Listing fee per item sold ($)<br><input id="efc-r-list" type="number" min="0" step="0.01" value="0.20" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Transaction fee (%)<br><input id="efc-r-tf" type="number" min="0" step="0.1" value="6.5" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processing (%)<br><input id="efc-r-pf" type="number" min="0" step="0.1" value="3" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processing fixed fee ($)<br><input id="efc-r-pfx" type="number" min="0" step="0.01" value="0.25" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Offsite Ads, standard rate (%)<br><input id="efc-r-ads1" type="number" min="0" step="0.1" value="15" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Offsite Ads, reduced rate (%)<br><input id="efc-r-ads2" type="number" min="0" step="0.1" value="12" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Offsite Ads cap per order ($)<br><input id="efc-r-cap" type="number" min="0" step="1" value="100" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="efc-r-taxproc" type="checkbox" checked> Processing fee is charged on sales tax too</label></p>
    </div>
  </details>
  <table style="width:100%">
    <tbody>
      <tr><td>Buyer pays you (items + shipping + gift wrap)</td><td style="text-align:right" id="efc-o-rev"></td></tr>
      <tr><td>Sales tax collected (passed to the state)</td><td style="text-align:right" id="efc-o-tax"></td></tr>
      <tr><td>Listing fee</td><td style="text-align:right" id="efc-o-list"></td></tr>
      <tr><td>Transaction fee</td><td style="text-align:right" id="efc-o-tf"></td></tr>
      <tr><td>Payment processing fee</td><td style="text-align:right" id="efc-o-pf"></td></tr>
      <tr><td>Offsite Ads fee</td><td style="text-align:right" id="efc-o-ads"></td></tr>
      <tr><td><strong>Total Etsy fees</strong></td><td style="text-align:right"><strong id="efc-o-fees"></strong></td></tr>
      <tr><td>Fees as a share of what the buyer pays</td><td style="text-align:right" id="efc-o-feepct"></td></tr>
      <tr><td><strong>Net payout from Etsy</strong></td><td style="text-align:right"><strong id="efc-o-payout"></strong></td></tr>
      <tr><td>Cost of goods</td><td style="text-align:right" id="efc-o-cogs"></td></tr>
      <tr><td>Shipping label</td><td style="text-align:right" id="efc-o-label"></td></tr>
      <tr><td><strong>Profit</strong></td><td style="text-align:right"><strong id="efc-o-profit"></strong></td></tr>
      <tr><td>Profit margin</td><td style="text-align:right" id="efc-o-margin"></td></tr>
      <tr><td>Profit per item</td><td style="text-align:right" id="efc-o-each"></td></tr>
    </tbody>
  </table>
  <p id="efc-o-note" style="font-weight:bold"></p>
  <hr>
  <p><strong>Price needed</strong> (same shipping, costs and Offsite Ads setting as above)</p>
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Target profit margin (%)<br><input id="efc-tm" type="number" min="0" max="99" step="1" value="35" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Target profit per order ($)<br><input id="efc-tp" type="number" min="0" step="0.01" value="10" style="width:100%;max-width:160px"></label></p>
  </div>
  <table style="width:100%">
    <tbody>
      <tr><td>Price per item for the target margin</td><td style="text-align:right"><strong id="efc-s-margin"></strong></td></tr>
      <tr><td>Price per item for the target profit</td><td style="text-align:right"><strong id="efc-s-profit"></strong></td></tr>
      <tr><td>Break-even price per item</td><td style="text-align:right" id="efc-s-even"></td></tr>
    </tbody>
  </table>
  <p id="efc-s-note"><small></small></p>
</div>

<script>
(function () {
  /*calc-start*/
  function nz(v) { return isFinite(v) && v > 0 ? v : 0; }
  function adsRate(ads, r) { return ads === "std" ? nz(r.ads1) / 100 : ads === "low" ? nz(r.ads2) / 100 : 0; }
  function fees(o, r) {
    var q = Math.floor(nz(o.qty)), rev = nz(o.price) * q + nz(o.ship) + nz(o.wrap);
    var tax = rev * nz(o.tax) / 100;
    var list = q * nz(r.list), tf = nz(r.tf) / 100 * rev;
    var pf = rev > 0 ? nz(r.pf) / 100 * (rev + (r.taxproc ? tax : 0)) + nz(r.pfx) : 0;
    var ads = Math.min(nz(r.cap), adsRate(o.ads, r) * rev);
    var total = list + tf + pf + ads, payout = rev - total;
    var cogs = q * nz(o.cogs), label = nz(o.label), profit = payout - cogs - label;
    return { q: q, rev: rev, tax: tax, list: list, tf: tf, pf: pf, ads: ads, fees: total, feePct: rev > 0 ? total / rev * 100 : null,
      payout: payout, cogs: cogs, label: label, profit: profit, margin: rev > 0 ? profit / rev * 100 : null, each: q > 0 ? profit / q : null };
  }
  // Price per item so that profit = m * (what the buyer pays) + t. Returns null if no price works.
  function solve(o, r, m, t) {
    var q = Math.floor(nz(o.qty)); if (q < 1) return null;
    var k = 1 - nz(r.tf) / 100 - nz(r.pf) / 100 * (1 + (r.taxproc ? nz(o.tax) / 100 : 0));
    var fixed = nz(r.pfx) + q * nz(r.list) + q * nz(o.cogs) + nz(o.label) + t;
    var a = adsRate(o.ads, r), cap = nz(r.cap), rev = null;
    if (k - a - m > 0) { var r1 = fixed / (k - a - m); if (a === 0 || a * r1 <= cap) rev = r1; }
    if (rev === null && a > 0 && k - m > 0) { var r2 = (fixed + cap) / (k - m); if (a * r2 >= cap) rev = r2; }
    if (rev === null) return null;
    return Math.max(0, (rev - nz(o.ship) - nz(o.wrap)) / q);
  }
  /*calc-end*/
  function $(id) { return document.getElementById(id); }
  function num(id) { var v = parseFloat($(id).value); return isFinite(v) && v >= 0 ? v : 0; }
  function money(n) { n = Math.round(n * 100) / 100; return (n < 0 ? "-$" : "$") + Math.abs(n).toFixed(2); }
  function pct(n) { return n === null ? "n/a" : n.toFixed(1) + "%"; }
  function set(id, t) { $(id).textContent = t; }
  function update() {
    var o = { price: num("efc-price"), qty: num("efc-qty"), ship: num("efc-ship"), wrap: num("efc-wrap"), cogs: num("efc-cogs"),
      label: num("efc-label"), ads: $("efc-ads").value, tax: num("efc-tax") };
    var r = { list: num("efc-r-list"), tf: num("efc-r-tf"), pf: num("efc-r-pf"), pfx: num("efc-r-pfx"), ads1: num("efc-r-ads1"),
      ads2: num("efc-r-ads2"), cap: num("efc-r-cap"), taxproc: !!$("efc-r-taxproc").checked };
    var f = fees(o, r);
    set("efc-o-rev", money(f.rev)); set("efc-o-tax", money(f.tax)); set("efc-o-list", money(f.list)); set("efc-o-tf", money(f.tf));
    set("efc-o-pf", money(f.pf)); set("efc-o-ads", money(f.ads)); set("efc-o-fees", money(f.fees)); set("efc-o-feepct", pct(f.feePct));
    set("efc-o-payout", money(f.payout)); set("efc-o-cogs", money(f.cogs)); set("efc-o-label", money(f.label));
    set("efc-o-profit", money(f.profit)); set("efc-o-margin", pct(f.margin)); set("efc-o-each", f.each === null ? "n/a" : money(f.each));
    if (f.q < 1) set("efc-o-note", "Enter a quantity of at least 1.");
    else if (f.rev <= 0) set("efc-o-note", "Enter a price to see the fees.");
    else set("efc-o-note", (f.profit >= 0 ? "You keep " + money(f.profit) + " profit on this order" : "You lose " + money(-f.profit) + " on this order")
      + ": Etsy takes " + money(f.fees) + " (" + pct(f.feePct) + ") and your goods and label cost " + money(f.cogs + f.label) + ".");
    var tm = Math.min(num("efc-tm"), 99) / 100, tp = num("efc-tp");
    var sm = solve(o, r, tm, 0), sp = solve(o, r, 0, tp), se = solve(o, r, 0, 0);
    set("efc-s-margin", sm === null ? "not reachable" : money(Math.ceil(sm * 100 - 1e-7) / 100));
    set("efc-s-profit", sp === null ? "not reachable" : money(Math.ceil(sp * 100 - 1e-7) / 100));
    set("efc-s-even", se === null ? "not reachable" : money(Math.ceil(se * 100 - 1e-7) / 100));
    set("efc-s-note", sm === null ? "A " + Math.round(tm * 100) + "% margin isn't reachable with these fee rates: percentage fees alone take more than that of every dollar."
      : "Prices are rounded up to the cent. Margin means profit divided by what the buyer pays you (items + shipping + gift wrap, before sales tax).");
  }
  ["efc-price", "efc-qty", "efc-ship", "efc-wrap", "efc-cogs", "efc-label", "efc-tax", "efc-tm", "efc-tp", "efc-r-list", "efc-r-tf",
   "efc-r-pf", "efc-r-pfx", "efc-r-ads1", "efc-r-ads2", "efc-r-cap"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["efc-ads", "efc-r-taxproc"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

<!-- TODO: link the paid Etsy Seller Profit Tracker here (Gumroad URL) once it is published. Do not link it before then. -->

New to Etsy fees? Read **[Etsy fees explained (2026)](etsy-fees-explained)** for what each fee is, what it's charged on, and worked examples.

## How the numbers are worked out

```
buyer pays        = item price * quantity + shipping charged + gift wrap
sales tax         = buyer pays * tax rate          (collected and paid by Etsy, not your income)
listing fee       = $0.20 * quantity               (each item sold renews the listing)
transaction fee   = 6.5% * buyer pays
processing fee    = 3% * (buyer pays + sales tax) + $0.25
offsite ads fee   = 15% or 12% * buyer pays, at most $100 per order (Offsite Ads orders only)
net payout        = buyer pays - all Etsy fees
profit            = net payout - cost of goods * quantity - shipping label
margin            = profit / buyer pays
price needed      = solves profit = target margin * buyer pays (or = target profit)
                    for the item price, using the same costs and fees
```

The calculator works with exact amounts; Etsy rounds each fee to the cent, so your statement can differ by a cent or two. Rates are the ones for a US shop with a US bank account as of October 2026. Sellers in other countries pay a different payment processing rate, and some pay a regulatory operating fee or a currency conversion fee; open "Fee rates" to change them. *Check Etsy's Fees & Payments Policy before relying on these numbers, since fees change.*

## FAQ

### How much does Etsy take from a sale?

For a typical US order Etsy takes the $0.20 listing fee, 6.5% of the item price plus shipping, and 3% + $0.25 for payment processing, so roughly 9.5% plus $0.45 for a one-item order. On a $28 item with $6.50 shipping that's about $3.73 in fees. If the sale came from an Offsite Ad, add 15% (or 12%) of the order, up to $100.

### Does Etsy charge fees on shipping?

Yes. The 6.5% transaction fee and the payment processing fee are both charged on what the buyer pays for shipping, not just on the item price. Offering "free shipping" and raising the item price by the same amount costs you the same in fees.

### Does Etsy charge fees on sales tax?

The transaction fee is not charged on sales tax, but the payment processing fee is charged on the full amount the buyer pays, including tax. Etsy collects and sends US sales tax to the states for you, so the tax itself never counts as your income.

### What is the Offsite Ads fee?

When a buyer clicks an Etsy ad on another site (such as Google or social media) and buys from your shop within 30 days, Etsy charges an Offsite Ads fee on that order: 15% for shops that made under $10,000 on Etsy in the last 12 months, and 12% for shops above that, where the ads are required. The fee is capped at $100 per order. Pick the rate in the Offsite Ads box to see how one of these orders changes your profit.

### How do I price my Etsy item for a target margin?

Enter your cost of goods, label cost and shipping, then set a target margin under "Price needed". The calculator solves for the item price where profit divided by what the buyer pays equals your target, including every percentage and fixed fee. If you want a fixed dollar profit per order instead, use the target profit box. The break-even price is the lowest price at which you don't lose money.

### Should I count Offsite Ads orders when I set prices?

If many of your orders come from Offsite Ads, price for the worst case: switch the Offsite Ads box to 15% or 12% and check that the margin still works. On a single cheap item the fee can take most of the profit.

More tools and guides: [all guides and free tools](./). Not affiliated with Etsy. Not tax advice.
