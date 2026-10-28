---
layout: page
title: "Seller fee comparison calculator (2026): Gumroad vs Payhip vs Ko-fi vs Lemon Squeezy vs Etsy and more"
description: "Free seller fee comparison calculator. Enter a price and monthly sales to see what you keep on Gumroad, Payhip, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe and PayPal, sorted by net, plus the price you need to keep a target amount."
---

Enter a price and how many sales you make a month. The table shows the fee per sale, what you keep per sale and per month, and the lowest price that leaves you a target amount, for 13 ways to sell a digital product. Rows are sorted by what you keep each month, so plans with a monthly fee only rise to the top once your volume pays for them. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

<div id="sfc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <p><label>Price per sale (USD)<br><input id="sfc-price" type="number" min="0" step="0.01" value="19" style="width:140px;font-size:1.1em"></label></p>
  <p><label>Sales per month<br><input id="sfc-qty" type="number" min="0" step="1" value="10" style="width:140px"></label></p>
  <p><label>I want to keep this much per sale (USD)<br><input id="sfc-target" type="number" min="0" step="0.01" value="20" style="width:140px"></label></p>
  <p><label>Payment processor on Payhip and Ko-fi<br><select id="sfc-proc"><option value="stripe">Stripe card (2.9% + $0.30)</option><option value="paypal">PayPal Checkout (3.49% + $0.49)</option></select></label></p>
  <p><label><input id="sfc-hv" type="checkbox"> Gumroad paid sales this month already past $20,000 (fee drops to 5% + $0.50)</label></p>
  <p><label><input id="sfc-intl" type="checkbox"> Buyer outside the US (adds PayPal's 1.5% international fee and Polar's 1.5% non-US card fee)</label></p>
  <div style="overflow-x:auto">
  <table id="sfc-table" style="width:100%">
    <thead><tr><th>Platform</th><th style="text-align:right">Fee per sale</th><th style="text-align:right">You keep per sale</th><th style="text-align:right">You keep per month</th><th style="text-align:right">Effective fee</th><th style="text-align:right">Price to keep target</th></tr></thead>
    <tbody></tbody>
  </table>
  </div>
  <p id="sfc-summary" style="font-weight:bold"></p>
</div>

<script>
/* Seller fee comparison math (same arithmetic as Seller Fee API v1.1.0). Rates as of 2026-10-20. */
(function (root) {
  var RATES_AS_OF = "2026-10-20";
  function r2(n) { return Math.round(n * 100) / 100; }
  function pf(p, pct, fixed) { return p > 0 ? r2(p * pct / 100 + fixed) : 0; }
  // Processing for platforms where you connect your own Stripe or PayPal (Payhip, Ko-fi, Stripe direct, PayPal direct)
  function processing(p, o) {
    if (o.processor === "paypal") return pf(p, 3.49 + (o.intl ? 1.5 : 0), 0.49); // PayPal Checkout, US
    return pf(p, 2.9, 0.30); // Stripe domestic card
  }
  var PLATFORMS = [
    { id: "gumroad", name: "Gumroad (direct sale, card)", monthly: 0,
      fee: function (p, o) { return p > 0 ? r2(pf(p, o.gumroadHV ? 5 : 10, 0.50) + pf(p, 2.9, 0.30)) : 0; },
      note: function (o) { return (o.gumroadHV ? "5% + $0.50 (high-volume)" : "10% + $0.50") + " + 2.9% + $0.30 card processing. Merchant of record."; } },
    { id: "gumroad-discover", name: "Gumroad (Discover sale)", monthly: 0,
      fee: function (p) { return p > 0 ? r2(p * 0.30) : 0; }, note: function () { return "30% flat, processing included."; } },
    { id: "stripe", name: "Stripe (your own checkout)", monthly: 0,
      fee: function (p) { return pf(p, 2.9, 0.30); }, note: function () { return "2.9% + $0.30, domestic card. You handle sales tax."; } },
    { id: "paypal", name: "PayPal Checkout (your own checkout)", monthly: 0,
      fee: function (p, o) { return pf(p, 3.49 + (o.intl ? 1.5 : 0), 0.49); }, note: function (o) { return "3.49% + $0.49" + (o.intl ? " + 1.5% international" : "") + ". You handle sales tax."; } },
    { id: "etsy", name: "Etsy (digital download)", monthly: 0,
      fee: function (p) { return p > 0 ? r2(0.20 + r2(p * 0.065) + pf(p, 3, 0.25)) : 0; },
      note: function () { return "$0.20 listing + 6.5% transaction + 3% + $0.25 processing. Offsite Ads not included."; } },
    { id: "payhip-free", name: "Payhip Free", monthly: 0,
      fee: function (p, o) { return p > 0 ? r2(r2(p * 0.05) + processing(p, o)) : 0; }, note: function (o) { return "5% + " + procLabel(o) + "."; } },
    { id: "payhip-plus", name: "Payhip Plus ($29/mo)", monthly: 29,
      fee: function (p, o) { return p > 0 ? r2(r2(p * 0.02) + processing(p, o)) : 0; }, note: function (o) { return "2% + " + procLabel(o) + ", plus $29/month."; } },
    { id: "payhip-pro", name: "Payhip Pro ($99/mo)", monthly: 99,
      fee: function (p, o) { return processing(p, o); }, note: function (o) { return "No transaction fee, " + procLabel(o) + ", plus $99/month."; } },
    { id: "kofi", name: "Ko-fi Shop", monthly: 0,
      fee: function (p, o) { return p > 0 ? r2(r2(p * 0.05) + processing(p, o)) : 0; }, note: function (o) { return "5% service fee + " + procLabel(o) + "."; } },
    { id: "lemonsqueezy", name: "Lemon Squeezy", monthly: 0,
      fee: function (p) { return pf(p, 5, 0.50); }, note: function () { return "5% + $0.50. Merchant of record; some payments may carry small extra fees."; } },
    { id: "paddle", name: "Paddle", monthly: 0,
      fee: function (p) { return pf(p, 5, 0.50); }, note: function () { return "5% + $0.50. Merchant of record; under $10, Paddle asks you to contact them."; } },
    { id: "polar", name: "Polar Starter", monthly: 0,
      fee: function (p, o) { return pf(p, 5 + (o.intl ? 1.5 : 0), 0.50); }, note: function (o) { return "5% + $0.50" + (o.intl ? " + 1.5% non-US card" : "") + ". Merchant of record."; } },
    { id: "polar-pro", name: "Polar Pro ($20/mo)", monthly: 20,
      fee: function (p, o) { return pf(p, 3.8 + (o.intl ? 1.5 : 0), 0.40); }, note: function (o) { return "3.8% + $0.40" + (o.intl ? " + 1.5% non-US card" : "") + ", plus $20/month."; } }
  ];
  function procLabel(o) { return o.processor === "paypal" ? "PayPal 3.49% + $0.49" + (o.intl ? " + 1.5%" : "") : "Stripe 2.9% + $0.30"; }
  function norm(o) { o = o || {}; return { processor: o.processor === "paypal" ? "paypal" : "stripe", intl: !!o.intl, gumroadHV: !!o.gumroadHV }; }
  // Fee per sale including the monthly plan fee spread across the month's sales
  function perSaleCost(pl, p, n, o) { return pl.fee(p, o) + (pl.monthly && n > 0 ? pl.monthly / n : (pl.monthly ? pl.monthly : 0)); }
  // Lowest price (to the cent) where you keep at least `target` per sale, monthly fee included
  function breakEven(pl, target, n, o) {
    o = norm(o); if (!(target > 0) && !pl.monthly) return 0;
    var lo = 0, hi = 1;
    while (hi - perSaleCost(pl, hi, n, o) < target - 1e-9) { hi *= 2; if (hi > 1e7) return null; }
    lo = Math.max(0, Math.floor(hi / 2 * 100) / 100);
    var c = Math.round(lo * 100), h = Math.round(hi * 100);
    while (c < h) { var m = Math.floor((c + h) / 2); if (m / 100 - perSaleCost(pl, m / 100, n, o) >= target - 1e-9) h = m; else c = m + 1; }
    // fees are not strictly monotonic at cent level because of rounding; step down while still valid
    return c / 100;
  }
  function compare(price, salesPerMonth, opts, target) {
    var o = norm(opts), n = Math.max(0, Math.floor(salesPerMonth || 0)), p = Math.max(0, +price || 0);
    var rows = PLATFORMS.map(function (pl) {
      var fee = pl.fee(p, o), net = r2(p - fee), monthNet = r2(net * n - pl.monthly);
      return { id: pl.id, name: pl.name, feePerSale: fee, netPerSale: net, monthlyPlan: pl.monthly,
        monthlyNet: monthNet, effectivePct: p > 0 ? r2((p * n - monthNet) / (p * n || 1) * 100) : null,
        breakEven: target == null ? null : breakEven(pl, target, n, o), note: pl.note(o) };
    });
    if (p > 0 && n === 0) rows.forEach(function (r) { r.effectivePct = r2(r.feePerSale / p * 100); });
    rows.sort(function (a, b) { return (b.monthlyNet - a.monthlyNet) || (b.netPerSale - a.netPerSale) || a.name.localeCompare(b.name); });
    return rows;
  }
  var api = { RATES_AS_OF: RATES_AS_OF, PLATFORMS: PLATFORMS, compare: compare, breakEven: function (id, t, n, o) { return breakEven(PLATFORMS.filter(function (x) { return x.id === id; })[0], t, n, o); },
    fee: function (id, p, o) { return PLATFORMS.filter(function (x) { return x.id === id; })[0].fee(p, norm(o)); } };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.SellerFees = api;
})(this);
(function () {
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toFixed(2); }
  function num(id, d) { var v = parseFloat(document.getElementById(id).value); return isFinite(v) && v >= 0 ? v : d; }
  function update() {
    var p = num("sfc-price", 0), q = Math.floor(num("sfc-qty", 0)), t = num("sfc-target", 0);
    var o = { processor: document.getElementById("sfc-proc").value, gumroadHV: document.getElementById("sfc-hv").checked, intl: document.getElementById("sfc-intl").checked };
    var rows = SellerFees.compare(p, q, o, t), tb = document.querySelector("#sfc-table tbody");
    tb.innerHTML = "";
    rows.forEach(function (r) {
      var tr = document.createElement("tr");
      [r.name, money(r.feePerSale), money(r.netPerSale), money(r.monthlyNet), r.effectivePct == null ? "n/a" : r.effectivePct.toFixed(1) + "%", money(r.breakEven)].forEach(function (v, i) {
        var td = document.createElement("td"); td.textContent = v; if (i) td.style.textAlign = "right"; if (!i) td.title = r.note; tr.appendChild(td);
      });
      tb.appendChild(tr);
    });
    var best = rows[0], worst = rows[rows.length - 1];
    document.getElementById("sfc-summary").textContent = q > 0 && p > 0 ? "At " + q + " sales a month, " + best.name + " keeps the most (" + money(best.monthlyNet) + "), " + money(best.monthlyNet - worst.monthlyNet) + " more than " + worst.name + "." : "";
  }
  ["sfc-price", "sfc-qty", "sfc-target", "sfc-proc", "sfc-hv", "sfc-intl"].forEach(function (id) { var el = document.getElementById(id); el.addEventListener("input", update); el.addEventListener("change", update); });
  update();
})();
</script>

Hover a platform name to see the exact rate used. "Price to keep target" includes any monthly plan fee spread across your monthly sales.

## Rates used (as of October 20, 2026)

| Platform | Fee | Source |
|---|---|---|
| Gumroad direct | 10% + $0.50, plus 2.9% + $0.30 card processing. 5% + $0.50 once paid sales pass $20,000 in a calendar month | [Gumroad's fees](https://gumroad.com/help/article/66-gumroads-fees) |
| Gumroad Discover | 30%, processing included | [Gumroad's fees](https://gumroad.com/help/article/66-gumroads-fees) |
| Stripe | 2.9% + $0.30 per domestic card payment | [Stripe pricing](https://stripe.com/pricing) |
| PayPal Checkout | 3.49% + $0.49, plus 1.50% for international payments | [PayPal merchant fees](https://www.paypal.com/us/business/paypal-business-fees) |
| Etsy | $0.20 listing, 6.5% transaction, 3% + $0.25 payment processing (US bank account) | [Etsy fee basics](https://help.etsy.com/hc/en-us/articles/360035902374-What-are-Etsy-s-Fees), [Etsy payment processing fees](https://help.etsy.com/hc/en-us/articles/115015628847-What-are-Payment-Processing-Fees-for-Selling-on-Etsy) |
| Payhip | Free: 5%. Plus: $29/month + 2%. Pro: $99/month, no transaction fee. Stripe or PayPal fees on top on every plan | [Payhip pricing](https://payhip.com/pricing) |
| Ko-fi | 5% service fee, plus normal card processing fees | [Ko-fi pricing](https://ko-fi.com/gold) |
| Lemon Squeezy | 5% + $0.50 | [Lemon Squeezy pricing](https://www.lemonsqueezy.com/pricing) |
| Paddle | 5% + $0.50 | [Paddle pricing](https://www.paddle.com/pricing) |
| Polar | Starter: 5% + $0.50. Pro: $20/month + 3.8% + $0.40. +1.5% for non-US cards | [Polar fees](https://polar.sh/docs/merchant-of-record/fees) |

## How the numbers are worked out

```
fee per sale       = percentage * price + fixed fee   (each part rounded to the cent)
you keep per sale  = price - fee per sale
you keep per month = you keep per sale * sales per month - monthly plan fee
effective fee      = (gross - what you keep per month) / gross
price to keep X    = lowest price (to the cent) where price - fee - monthly fee / sales >= X
```

What the table leaves out: sales tax and VAT (Gumroad, Lemon Squeezy, Paddle, Polar, Payhip and Etsy collect it for you; with your own Stripe or PayPal checkout you handle it), Etsy Offsite Ads, Stripe's extra fees for international cards and currency conversion, payout and withdrawal fees, refunds and chargebacks. Polar applies its fee to the tax-inclusive total, so where VAT applies its fee is a little higher. Ko-fi Gold (0% service fee for a monthly price) isn't included. Fees change, so confirm on each pricing page before you rely on these numbers.

## Quick takeaways

- **Low volume: no monthly fee wins.** Payhip Plus, Payhip Pro and Polar Pro only beat their free plans once your sales cover the monthly fee. Polar says its Pro plan pays off at about $1,379 a month in sales.
- **Cheap products feel the fixed fee.** Every fixed $0.25 to $0.80 per sale takes a bigger share of a $5 product than of a $49 one.
- **Gumroad direct costs about 12.9% + $0.80 once card processing is counted**, more than the 5% + $0.50 merchant-of-record platforms. Discover's 30% only makes sense for buyers you would not have found yourself.

## Related tools and guides

- [Free seller fee API for developers](free-tax-finance-api): the same fee math as a free JSON API (`/v1/fee`, `/v1/compare`, `/v1/price`)
- [Payhip fee calculator (2026)](payhip-fee-calculator): Payhip Free vs Plus vs Pro at your price and volume, with the break-even sales for each upgrade
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): Lemon Squeezy's 5% + 50¢ with the international, PayPal and subscription surcharges, fees on VAT and payout fees
- [Gumroad fee calculator](gumroad-fee-calculator), [PayPal & Stripe fee calculator](paypal-stripe-fee-calculator) and [Etsy fee & profit calculator](etsy-fee-calculator) for one platform in detail
- [Gumroad alternatives: Payhip vs Sellfy vs SendOwl (2026)](gumroad-alternatives-payhip-sellfy-sendowl)
- [Kit vs beehiiv vs MailerLite for creators (2026)](kit-vs-beehiiv-vs-mailerlite)
- [Freelance invoicing software: FreshBooks vs Bonsai vs HoneyBook vs Wave (2026)](freelance-invoicing-software-freshbooks-bonsai-honeybook-wave)
- [Gumroad vs Lemon Squeezy vs Polar vs Paddle](gumroad-vs-lemon-squeezy-polar-paddle-fees)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `ETSYFEE`, `STRIPEFEE` and `PAYPALFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once.

## Selling on Gumroad?

**[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz)** shows your direct and Discover payout in the browser while you set prices.

*Disclosure: Creator Payout Calculator Pro, Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. We don't earn anything from the platforms listed, and none of the links above are affiliate links. Not affiliated with Gumroad, Payhip, Ko-fi, Lemon Squeezy, Paddle, Polar, Etsy, Stripe or PayPal.* More guides: [Gumroad developer guides](./).
