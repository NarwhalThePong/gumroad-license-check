---
layout: page
title: "Gumroad fee calculator: what you keep after the 10% + $0.50, card processing and Discover fees"
description: "Free Gumroad fee calculator. Enter a price to see your payout on direct and Discover sales, your effective fee, monthly take-home, and the price you need to hit a target payout."
---

Type a price to see what you keep on a Gumroad sale. Direct sales (your own links) cost **10% + $0.50 plus 2.9% + $0.30 card processing**, which Gumroad charges on top. Sales that come through Gumroad Discover cost **30%**, with processing included. Everything runs in your browser and nothing is sent anywhere.

<div id="gfc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:640px">
  <p><label>Price per sale (USD)<br><input id="gfc-price" type="number" min="0" step="0.01" value="19" style="width:140px;font-size:1.1em"></label></p>
  <p><label>Sales per month<br><input id="gfc-qty" type="number" min="0" step="1" value="10" style="width:140px"></label></p>
  <p><label>Share of sales from Discover (%)<br><input id="gfc-disc" type="number" min="0" max="100" step="1" value="0" style="width:140px"></label></p>
  <p><label><input id="gfc-hv" type="checkbox"> Paid sales this month already past $20,000 (Gumroad fee drops to 5% + $0.50)</label></p>
  <table style="width:100%">
    <tr><th></th><th style="text-align:right">Direct sale</th><th style="text-align:right">Discover sale</th></tr>
    <tr><td>Fees (Gumroad + card processing)</td><td style="text-align:right" id="gfc-dfee"></td><td style="text-align:right" id="gfc-xfee"></td></tr>
    <tr><td>You keep</td><td style="text-align:right" id="gfc-dnet"></td><td style="text-align:right" id="gfc-xnet"></td></tr>
    <tr><td>Effective fee</td><td style="text-align:right" id="gfc-dpct"></td><td style="text-align:right" id="gfc-xpct"></td></tr>
  </table>
  <p id="gfc-month" style="font-weight:bold"></p>
  <hr>
  <p><label>I want to keep this much per sale (USD)<br><input id="gfc-target" type="number" min="0" step="0.01" value="20" style="width:140px"></label></p>
  <p id="gfc-solve"></p>
</div>

<script>
(function () {
  function money(n) { return (n < 0 ? "-$" : "$") + Math.abs(n).toFixed(2); }
  function round2(n) { return Math.round(n * 100) / 100; }
  var HV = false;
  function directFee(p) { return p > 0 ? round2(round2(p * (HV ? 5 : 10) / 100 + 0.50) + round2(p * 2.9 / 100 + 0.30)) : 0; }
  function directPrice(t) { var r = HV ? 0.921 : 0.871, pr = Math.max(0, Math.floor((t + 0.80) / r * 100) / 100 - 0.02); while (round2(pr - directFee(pr)) < t - 1e-9) pr = round2(pr + 0.01); return pr; }
  function discoverFee(p) { return p > 0 ? round2(p * 0.30) : 0; }
  function num(id, dflt) { var v = parseFloat(document.getElementById(id).value); return isFinite(v) && v >= 0 ? v : dflt; }
  function set(id, t) { document.getElementById(id).textContent = t; }
  function update() {
    HV = document.getElementById("gfc-hv").checked;
    var p = num("gfc-price", 0), q = Math.floor(num("gfc-qty", 0)), d = Math.min(num("gfc-disc", 0), 100) / 100;
    var df = directFee(p), xf = discoverFee(p);
    set("gfc-dfee", money(df)); set("gfc-xfee", money(xf));
    set("gfc-dnet", money(p - df)); set("gfc-xnet", money(p - xf));
    set("gfc-dpct", p > 0 ? (df / p * 100).toFixed(1) + "%" : "n/a");
    set("gfc-xpct", p > 0 ? "30.0%" : "n/a");
    var gross = p * q, net = q * ((1 - d) * (p - df) + d * (p - xf));
    set("gfc-month", "At " + q + " sales a month: " + money(gross) + " gross, about " + money(net) + " take-home before payout fees.");
    var t = num("gfc-target", 0);
    var pd = directPrice(t), px = Math.ceil(t / 0.70 * 100 - 1e-9) / 100;
    set("gfc-solve", "To keep " + money(t) + " per sale, charge at least " + money(pd) + " for direct sales, or " + money(px) + " if the sale comes through Discover.");
  }
  ["gfc-price", "gfc-qty", "gfc-disc", "gfc-target", "gfc-hv"].forEach(function (id) { var el = document.getElementById(id); el.addEventListener("input", update); el.addEventListener("change", update); });
  update();
})();
</script>

## How the numbers are worked out

```
direct fee     = (price * 10% + $0.50) + card processing (price * 2.9% + $0.30)
                 (5% + $0.50 instead of 10% + $0.50 once paid sales pass $20,000 that month)
discover fee   = price * 30%   (processing included)
you keep       = price - fee
price to keep a target (direct)   = (target + 0.80) / 0.871
price to keep a target (Discover) = target / 0.70
```

Card payments are assumed; PayPal payments carry PayPal's own fees instead of the 2.9% + $0.30. Fees are rounded to the cent, and the target prices are rounded up so you never land a cent short. Gumroad is the merchant of record and handles sales tax and VAT, which aren't part of these fees. Payout methods can have their own small fees, so check one real payout to confirm your true net. *Rates from [Gumroad's fees help page](https://gumroad.com/help/article/66-gumroads-fees), checked October 20, 2026. Fees change, so confirm there before relying on these numbers.*

## Quick takeaways

- **Under about $5, the flat $0.50 eats a big share.** With card processing, a $3 product loses about 40% on a direct sale; a $19 product loses about 17.1%.
- **Bundles save fees.** Three $5 products sold one by one cost $4.35 in fees; one $15 bundle costs $2.74.
- **Your own traffic is cheaper than Discover.** Links you share are direct sales at 10% + $0.50 plus card processing (about 12.9% + $0.80 all in), not 30%.

For worked examples and pricing tactics, read [Gumroad fees in 2026, explained](gumroad-fees-explained). To compare platforms, see [Gumroad vs Lemon Squeezy vs Polar vs Paddle](gumroad-vs-lemon-squeezy-polar-paddle-fees).

## Want this on every Gumroad page?

- **[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz/LAUNCH30)** shows your direct and Discover payout in the browser while you set prices.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq/LAUNCH30)** imports your sales CSV, applies the fees to every row, and builds a P&L with a tax set-aside sheet.

Pricing a bundle or a discount code? Try the [Gumroad bundle & discount calculator](gumroad-bundle-discount-calculator). Taking payments with PayPal or Stripe? Use the [PayPal & Stripe fee calculator](paypal-stripe-fee-calculator). More guides: [Gumroad developer guides](./). Not affiliated with Gumroad.
