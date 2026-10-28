---
layout: page
title: "Gumroad bundle & discount calculator: bundle pricing, offer codes and fees"
description: "Free Gumroad bundle pricing and discount code calculator. Add your product prices, set a bundle price or discount, and see buyer savings, Gumroad fees, your payout and how many bundle sales replace separate sales."
---

Plan a Gumroad bundle or a discount code before you publish it. Add the prices of the products in the bundle, set a bundle price or a discount, and see what the buyer saves, what Gumroad takes and what you keep compared with selling each product on its own. Direct sales cost **10% + $0.50 plus 2.9% + $0.30 card processing** per sale, which Gumroad charges on top; Gumroad Discover sales cost **30%**, with processing included. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

<div id="gbd" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:680px">
  <p style="margin-bottom:4px"><strong>Product prices (USD)</strong></p>
  <div id="gbd-rows"></div>
  <p><button type="button" id="gbd-add">+ Add product</button></p>
  <p><label><input type="radio" name="gbd-mode" id="gbd-mode-price" value="price" checked> Bundle price (USD)</label>
     <input id="gbd-bprice" type="number" min="0" step="0.01" value="45" style="width:120px"><br>
     <label><input type="radio" name="gbd-mode" id="gbd-mode-pct" value="pct"> Discount off the total (%)</label>
     <input id="gbd-bpct" type="number" min="0" max="100" step="1" value="30" style="width:120px"></p>
  <p><label>Offer code on top (% off, optional)<br><input id="gbd-code" type="number" min="0" max="100" step="1" value="0" style="width:120px"></label></p>
  <p><label>Share of sales from Discover (%)<br><input id="gbd-disc" type="number" min="0" max="100" step="1" value="0" style="width:120px"></label></p>
  <table style="width:100%">
    <tr><th></th><th style="text-align:right">Bundle (one sale)</th><th style="text-align:right">Bought separately</th></tr>
    <tr><td>Buyer pays</td><td style="text-align:right" id="gbd-bpay"></td><td style="text-align:right" id="gbd-spay"></td></tr>
    <tr><td>Fees (Gumroad + card processing)</td><td style="text-align:right" id="gbd-bfee"></td><td style="text-align:right" id="gbd-sfee"></td></tr>
    <tr><td>You keep</td><td style="text-align:right" id="gbd-bnet"></td><td style="text-align:right" id="gbd-snet"></td></tr>
    <tr><td>Effective fee</td><td style="text-align:right" id="gbd-bpct2"></td><td style="text-align:right" id="gbd-spct"></td></tr>
  </table>
  <p id="gbd-save" style="font-weight:bold"></p>
  <p id="gbd-feenote"></p>
  <hr>
  <p><label>Separate product sales to replace<br><input id="gbd-x" type="number" min="0" step="1" value="10" style="width:120px"></label></p>
  <p id="gbd-break"></p>
</div>

<script>
(function () {
  /*calc-start*/
  function round2(n) { return Math.round(n * 100) / 100; }
  function directFee(p) { return p > 0 ? round2(round2(p * 0.10 + 0.50) + round2(p * 0.029 + 0.30)) : 0; }
  function discoverFee(p) { return p > 0 ? round2(p * 0.30) : 0; }
  function blendFee(p, s) { return (1 - s) * directFee(p) + s * discoverFee(p); }
  function calc(prices, mode, bprice, bpct, code, disc, x) {
    prices = prices.filter(function (p) { return isFinite(p) && p > 0; });
    var total = prices.reduce(function (a, b) { return a + b; }, 0);
    var list = mode === "pct" ? total * (1 - Math.min(bpct, 100) / 100) : bprice;
    var paid = round2(list * (1 - Math.min(code, 100) / 100));
    var s = Math.min(disc, 100) / 100;
    var bfee = blendFee(paid, s), bnet = paid - bfee;
    var sfee = prices.reduce(function (a, p) { return a + blendFee(p, s); }, 0), snet = total - sfee;
    var avgNet = prices.length ? snet / prices.length : 0;
    var need = bnet > 0 ? Math.ceil(x * avgNet / bnet - 1e-9) : null;
    return { n: prices.length, total: total, paid: paid, save: total - paid, savePct: total > 0 ? (total - paid) / total * 100 : 0,
      bfee: bfee, bnet: bnet, bpct: paid > 0 ? bfee / paid * 100 : null, sfee: sfee, snet: snet, spct: total > 0 ? sfee / total * 100 : null,
      fixedSaved: (1 - s) * 0.80 * Math.max(prices.length - 1, 0), avgNet: avgNet, need: need, ratio: avgNet > 0 ? bnet / avgNet : null };
  }
  /*calc-end*/
  function money(n) { n = round2(n); return (n < 0 ? "-$" : "$") + Math.abs(n).toFixed(2); }
  function $(id) { return document.getElementById(id); }
  function num(id, d) { var v = parseFloat($(id).value); return isFinite(v) && v >= 0 ? v : d; }
  function set(id, t) { $(id).textContent = t; }
  var rows = $("gbd-rows");
  function addRow(v) {
    var d = document.createElement("div"); d.style.margin = "4px 0";
    var i = document.createElement("input"); i.type = "number"; i.min = "0"; i.step = "0.01"; i.value = v; i.className = "gbd-p"; i.style.width = "120px";
    var b = document.createElement("button"); b.type = "button"; b.textContent = "Remove"; b.style.marginLeft = "8px";
    b.addEventListener("click", function () { rows.removeChild(d); update(); });
    i.addEventListener("input", update); d.appendChild(i); d.appendChild(b); rows.appendChild(d);
  }
  function update() {
    var ps = Array.prototype.map.call(rows.querySelectorAll(".gbd-p"), function (i) { return parseFloat(i.value); });
    var r = calc(ps, $("gbd-mode-pct").checked ? "pct" : "price", num("gbd-bprice", 0), num("gbd-bpct", 0), num("gbd-code", 0), num("gbd-disc", 0), Math.floor(num("gbd-x", 0)));
    set("gbd-bpay", money(r.paid)); set("gbd-spay", money(r.total));
    set("gbd-bfee", money(r.bfee)); set("gbd-sfee", money(r.sfee));
    set("gbd-bnet", money(r.bnet)); set("gbd-snet", money(r.snet));
    set("gbd-bpct2", r.bpct === null ? "n/a" : r.bpct.toFixed(1) + "%"); set("gbd-spct", r.spct === null ? "n/a" : r.spct.toFixed(1) + "%");
    if (!r.n) { set("gbd-save", "Add at least one product price."); set("gbd-feenote", ""); set("gbd-break", ""); return; }
    set("gbd-save", r.save >= 0 ? "Buyer saves " + money(r.save) + " (" + r.savePct.toFixed(1) + "%) versus buying all " + r.n + " products separately."
      : "The bundle costs " + money(-r.save) + " more than buying the products separately. Lower the bundle price.");
    set("gbd-feenote", "On direct sales a bundle pays one $0.50 Gumroad fee and one $0.30 card fee instead of " + r.n + " of each, saving about " + money(r.fixedSaved) + " per buyer at your Discover share. You keep " + money(r.bnet) + " from the bundle versus " + money(r.snet) + " if the same buyer bought everything separately.");
    var x = Math.floor(num("gbd-x", 0));
    set("gbd-break", r.need === null ? "The bundle earns nothing at this price."
      : r.need + " bundle sales earn at least as much as " + x + " separate product sales (about " + money(r.avgNet) + " kept on each). One bundle sale is worth " + r.ratio.toFixed(2) + " separate sales.");
  }
  [19, 29, 15].forEach(addRow);
  $("gbd-add").addEventListener("click", function () { addRow(""); });
  ["gbd-bprice", "gbd-bpct", "gbd-code", "gbd-disc", "gbd-x"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["gbd-mode-price", "gbd-mode-pct"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## How the numbers are worked out

```
total            = sum of the product prices
bundle price     = your bundle price, or total * (1 - discount %)
buyer pays       = bundle price * (1 - offer code %)
direct fee       = (buyer pays * 10% + $0.50)
                   + card processing (buyer pays * 2.9% + $0.30)   (per sale)
discover fee     = buyer pays * 30%   (processing included, per sale)
fee              = blend of the two by your Discover share
bought separately: each product is its own sale and pays its own fee,
                   including its own $0.50 and $0.30 on direct sales
bundle sales to replace X separate sales
                 = X * (average kept per separate sale) / (kept per bundle sale), rounded up
```

Card payments are assumed; PayPal payments carry PayPal's own fees instead of the 2.9% + $0.30. Fees are rounded to the cent per sale. Gumroad is the merchant of record and handles sales tax and VAT, which aren't part of these fees. *Check [Gumroad's pricing page](https://gumroad.com/pricing) and [Gumroad's fees help page](https://gumroad.com/help/article/66-gumroads-fees) before relying on these numbers, since fees change.* For a single price, use the [Gumroad fee calculator](gumroad-fee-calculator).

## FAQ

### How should I price a Gumroad bundle?

Most bundles sit at 20-40% below the total of the products inside. The calculator shows what the buyer saves and what you keep, so you can find a discount that looks generous without cutting too deep. Because a bundle is one sale, it pays one $0.50 Gumroad fee and one $0.30 card fee instead of one of each per product, so part of the discount is paid for by fees you no longer pay.

### Does a Gumroad discount code stack with a bundle price?

An offer code takes its percentage off whatever the buyer is paying for that product, so a code applied to a bundle comes off the bundle price. Enter the code's percentage in "Offer code on top" to see the final price, fee and payout. Gumroad's fee is charged on what the buyer actually pays, after the discount.

### Is the Gumroad fee charged on the price before or after the discount?

After. The 10% (or 30% on Discover) is a share of the amount the buyer pays, and the $0.50 is added once per sale. Card processing on direct sales (2.9% + $0.30) is also worked out on what the buyer pays. A discount lowers the percentage parts but not the $0.50 or the $0.30.

### How many bundle sales make up for lost separate sales?

Enter how many single-product sales you're worried about losing. The calculator divides what those sales would have paid you by what one bundle sale pays and rounds up. If one bundle sale is worth 2.5 separate sales, a buyer who would only have bought one product is a clear win, and a buyer who would have bought everything costs you the discount.

### Do Discover sales change the math?

Yes. Discover charges 30% with no fixed fee, so bundling saves less on fees for those sales. Set your Discover share to blend both rates. Links you share yourself are direct sales.

## Track bundles and discounts after launch

- **[Gumroad Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm)** turns your sales data into revenue, refund and per-product reports, so you can see whether the bundle is pulling its weight.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)** imports your sales CSV, applies the fees to every row, and builds a P&L with a tax set-aside sheet.

What does a discount code actually cost you, and how do codes work on other platforms? See [Discount codes and sales](discount-codes-and-sales-gumroad-lemon-squeezy-payhip-sellfy-etsy).
More tools and guides: [Gumroad fee calculator](gumroad-fee-calculator), [Gumroad fees in 2026, explained](gumroad-fees-explained), [all Gumroad developer guides](./). Not affiliated with Gumroad.
