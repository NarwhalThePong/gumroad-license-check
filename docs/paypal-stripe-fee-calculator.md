---
layout: page
title: "PayPal & Stripe fee calculator (2026): fee, payout and the price to charge"
description: "Free 2026 PayPal and Stripe fee calculator for US sellers. Enter an amount to see the fee, what you keep and the effective rate for Stripe cards and every PayPal payment type (checkout, card, goods and services, Pay Later, international), or work out the price to charge to net a target amount."
---

What does PayPal or Stripe take from a payment, and what should you charge to end up with a set amount? Enter the amount and pick the payment method. The calculator shows the **fee**, your **payout** and the **effective fee %**, compares every method side by side, and solves for the **price to charge to net $X**. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

Rates are the US standard rates as of Oct 20, 2026 (sources below). Every rate box can be edited, so you can plug in your own pricing if it's different.

<div id="ppsf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:720px">
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Amount the buyer pays ($)<br><input id="ppsf-amt" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Platform / payment method<br><select id="ppsf-method" style="width:100%;max-width:280px">
      <option value="stripe" selected>Stripe, card payment</option>
      <option value="checkout">PayPal Checkout / Guest Checkout</option>
      <option value="venmo">PayPal, Pay with Venmo</option>
      <option value="card">PayPal, credit/debit card</option>
      <option value="goods">PayPal, goods &amp; services (send/receive money)</option>
      <option value="paylater">PayPal Pay Later</option>
      <option value="other">PayPal, all other commercial transactions</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Percentage fee (%)<br><input id="ppsf-pct" type="number" min="0" max="99" step="0.01" value="2.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Fixed fee per payment ($)<br><input id="ppsf-fixed" type="number" min="0" step="0.01" value="0.30" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="ppsf-intl" type="checkbox"> International buyer</label><br>
      <label>Extra % for international<br><input id="ppsf-xpct" type="number" min="0" step="0.01" value="1.5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Amount you want to net ($)<br><input id="ppsf-net" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><small>Picking a method fills in its standard rate. Edit the boxes if your rate is different. The international extra (1.5% for PayPal) is added to the percentage only when the box is ticked; for Stripe, enter whatever extra percentage applies to your account.</small></p>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Fee</td><td style="text-align:right"><strong id="ppsf-o-fee">$0.00</strong></td></tr>
    <tr><td>You receive (payout)</td><td style="text-align:right"><strong id="ppsf-o-pay">$0.00</strong></td></tr>
    <tr><td>Effective fee</td><td style="text-align:right"><strong id="ppsf-o-eff">0%</strong></td></tr>
    <tr><td>Rate used</td><td style="text-align:right" id="ppsf-o-rate">-</td></tr>
    <tr><td>Price to charge to net <span id="ppsf-o-netx">$100.00</span></td><td style="text-align:right"><strong id="ppsf-o-price">$0.00</strong></td></tr>
    <tr><td>Fee at that price</td><td style="text-align:right" id="ppsf-o-pfee">$0.00</td></tr>
  </table>
  <p id="ppsf-o-note" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Every method for this amount</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <thead><tr><th style="text-align:left">Method</th><th style="text-align:right">Fee</th><th style="text-align:right">Payout</th><th style="text-align:right">Effective</th><th style="text-align:right">Price to net target</th></tr></thead>
    <tbody id="ppsf-cmp"></tbody>
  </table>
  <p style="margin:0"><small>Uses the international box and extra % above, but the standard rate for each method (not your edited rate).</small></p>
</div>

<script>
(function () {
  /*calc-start*/
  // Same formulas as STRIPEFEE / PAYPALFEE / BREAKEVENPRICE in Seller Fee Formulas (Code.gs). Rates as of Oct 20, 2026.
  var RATES = {
    stripe: { name: "Stripe, card payment", pct: 2.9, fixed: 0.30, intl: false },
    checkout: { name: "PayPal Checkout", pct: 3.49, fixed: 0.49, intl: true },
    venmo: { name: "PayPal, Pay with Venmo", pct: 3.49, fixed: 0.49, intl: true },
    card: { name: "PayPal, card", pct: 2.99, fixed: 0.49, intl: true },
    goods: { name: "PayPal, goods & services", pct: 2.99, fixed: 0, intl: true },
    paylater: { name: "PayPal Pay Later", pct: 4.99, fixed: 0.49, intl: true },
    other: { name: "PayPal, other commercial", pct: 3.49, fixed: 0.49, intl: true }
  };
  var INTL_PCT = 1.5;
  function pos(n) { n = Number(n); return isFinite(n) && n > 0 ? n : 0; }
  function round2(n) { return Math.round(n * 100) / 100; }
  function ceil2(n) { return Math.ceil(n * 100 - 1e-7) / 100; }
  function fee(amount, pct, fixed) { var a = Number(amount); if (!(a > 0)) return 0; return round2(a * pos(pct) / 100 + pos(fixed)); }
  function payout(amount, pct, fixed) { var a = Number(amount) || 0; return round2(a - fee(a, pct, fixed)); }
  function eff(amount, pct, fixed) { var a = Number(amount); return a > 0 ? fee(a, pct, fixed) / a : null; }
  function priceFor(net, pct, fixed) { var p = pos(pct); if (p >= 100) return null; return ceil2(Math.max(0, (pos(net) + pos(fixed)) / (1 - p / 100))); }
  function rateFor(method, intl, xpct) { var r = RATES[method]; return { pct: r.pct + (intl && r.intl ? pos(xpct) : 0), fixed: r.fixed }; }
  /*calc-end*/
  var $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function num(id) { var v = parseFloat($(id).value); return isFinite(v) ? v : 0; }
  function money(n) { return (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n === null ? "n/a" : (Math.round(n * 10000) / 100) + "%"; }
  function fill() {
    var r = RATES[$("ppsf-method").value];
    $("ppsf-pct").value = r.pct; $("ppsf-fixed").value = r.fixed.toFixed(2);
    update();
  }
  function update() {
    var m = $("ppsf-method").value, A = num("ppsf-amt"), X = num("ppsf-net"), intl = $("ppsf-intl").checked, xp = num("ppsf-xpct");
    var p = pos(num("ppsf-pct")) + (intl ? pos(xp) : 0), f = pos(num("ppsf-fixed"));
    set("ppsf-o-fee", money(fee(A, p, f))); set("ppsf-o-pay", money(payout(A, p, f))); set("ppsf-o-eff", pctS(eff(A, p, f)));
    set("ppsf-o-rate", (Math.round(p * 100) / 100) + "% + " + money(f));
    set("ppsf-o-netx", money(X));
    var P = priceFor(X, p, f);
    set("ppsf-o-price", P === null ? "n/a" : money(P)); set("ppsf-o-pfee", P === null ? "n/a" : money(fee(P, p, f)));
    set("ppsf-o-note", P === null ? "The percentage fee must be below 100%."
      : "On " + money(A) + " you keep " + money(payout(A, p, f)) + ". To end up with " + money(X) + ", charge " + money(P) + " (the fee on that is " + money(fee(P, p, f)) + ").");
    var tb = $("ppsf-cmp");
    while (tb.firstChild) tb.removeChild(tb.firstChild);
    Object.keys(RATES).forEach(function (k) {
      var r = rateFor(k, intl, xp), tr = document.createElement("tr");
      var pr = priceFor(X, r.pct, r.fixed);
      [RATES[k].name, money(fee(A, r.pct, r.fixed)), money(payout(A, r.pct, r.fixed)), pctS(eff(A, r.pct, r.fixed)), pr === null ? "n/a" : money(pr)].forEach(function (t, i) {
        var td = document.createElement("td"); td.textContent = t; if (i) td.style.textAlign = "right";
        if (k === m) td.style.fontWeight = "bold";
        tr.appendChild(td);
      });
      tb.appendChild(tr);
    });
  }
  $("ppsf-method").addEventListener("change", fill);
  ["ppsf-amt", "ppsf-pct", "ppsf-fixed", "ppsf-xpct", "ppsf-net"].forEach(function (id) { $(id).addEventListener("input", update); });
  $("ppsf-intl").addEventListener("change", update);
  update();
})();
</script>

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once. *Disclosure: this is our own paid product, and we earn the sale price if you buy it.*

Want the rates explained with worked examples? Read [PayPal & Stripe fees explained (2026)](paypal-stripe-fees-explained).

Selling on Gumroad or Etsy too? See the free [Gumroad fee calculator](gumroad-fee-calculator) and the [Etsy fee & profit calculator](etsy-fee-calculator).

## Rates used (US, as of Oct 20, 2026)

| Method | Fee |
|---|---|
| Stripe, domestic card | 2.9% + $0.30 |
| PayPal Checkout and Guest Checkout | 3.49% + $0.49 |
| PayPal, Pay with Venmo | 3.49% + $0.49 |
| PayPal, standard credit and debit card payments | 2.99% + $0.49 |
| PayPal, send/receive money for goods and services | 2.99% |
| PayPal Pay Later | 4.99% + $0.49 |
| PayPal, all other commercial transactions | 3.49% + $0.49 |
| PayPal, international commercial payments | add 1.50% |

Sources: [Stripe pricing](https://stripe.com/pricing) and [PayPal merchant fees (US)](https://www.paypal.com/us/business/paypal-business-fees), checked Oct 20, 2026 (PayPal's page was last updated Oct 1, 2026). Rates change, negotiated and volume pricing differ, and currency conversion, disputes, chargebacks, instant transfers and other extras are not included. Check your own account before you rely on a number.

## How the numbers are worked out

```
fee              = amount x (percentage + international extra) + fixed fee, rounded to the cent
payout           = amount - fee
effective fee %  = fee / amount
price to net X   = (X + fixed fee) / (1 - percentage), rounded up to the cent
```

Example: a $50 Stripe card payment costs $50 x 2.9% + $0.30 = $1.75, so you keep $48.25 (3.5% effective). The same $50 through PayPal Checkout costs $50 x 3.49% + $0.49 = $2.24 and you keep $47.76; from an international buyer it's 4.99% + $0.49 = $2.99. To net $100 through Stripe, charge ($100 + $0.30) / 0.971 = $103.30.

## FAQ

### Is Stripe or PayPal cheaper?

At standard US rates, a Stripe card payment (2.9% + $0.30) costs less than PayPal Checkout (3.49% + $0.49) on every amount. PayPal's goods and services rate (2.99%, no fixed fee) is cheaper than both on small amounts. Buyers sometimes convert better with PayPal, so the cheaper fee isn't always the better choice.

### Why does the fixed fee matter so much on small sales?

On a $5 sale, PayPal Checkout's $0.49 fixed fee alone is almost 10%. The effective fee % column shows how quickly the fixed part fades as the price goes up.

### Can I just add the fee percentage to my price?

Not quite. Adding 2.9% to $100 gives $102.90, but the fee is charged on $102.90, not $100, so you'd come up short. Divide by (1 - percentage) instead, as the "price to charge" box does.

Selling on a platform instead? Compare them all in the [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator).

Selling music? The free [Bandcamp fee calculator (2026)](bandcamp-fee-calculator) adds Bandcamp's 15% or 10% revenue share on top of the Stripe or PayPal processing fee.

Selling games or assets? The free [itch.io fee calculator (2026)](itch-io-fee-calculator) adds itch.io's open revenue share (default 10%) on top of the $0.30 + 2.9% PayPal or Stripe fee.

Getting paid on Venmo? The free [Venmo fee calculator (2026)](venmo-fee-calculator) compares the 2.99% goods-and-services fee with the business profile's 1.9% + $0.10 and adds Instant Transfer's 1.75%.

Getting paid on Cash App? The free [Cash App for Business fee calculator (2026)](cash-app-fee-calculator) works out the 2.6% + $0.15 business payment fee, the 3% Tap to Pay fee and Instant transfer costs.

Taking card payments with Square? The free [Square fee calculator (2026)](square-fee-calculator) works out Square's in-person, online, invoice and keyed-in fees on Square Free, Plus and Premium, plus Instant transfer costs.

Selling on a Shopify store? The free [Shopify fee calculator (2026)](shopify-fee-calculator) works out Shopify Payments' online, premium-card and in-person fees on Basic, Grow and Advanced, plus the extra fee for third-party payment providers.

More tools and guides: [all guides and free tools](./). Not affiliated with PayPal or Stripe. Not tax or financial advice.
