---
layout: page
title: "Whop fee calculator (2026): 2.7% + 30¢ processing, the 3% Discord app fee, add-ons and payout fees"
description: "Free Whop fee calculator. Enter your price and monthly sales to see Whop's 2.7% + 30¢ card fee or 1.5% ACH fee, international and currency surcharges, the 3% fee on products using the Discord, Telegram or TradingView app, billing and tax add-ons, payout fees and what you keep."
---

Whop has **no monthly fee**. Each card sale pays **2.7% + 30¢**, plus **1.5% for international cards** and **1% for currency conversion**. ACH bank payments cost **1.5%, capped at $5**. Optional add-ons stack on top when you turn them on: billing 0.5%, orchestration 0.8%, and tax and remittance 2% when tax is collected. Whop's Discord, Telegram and TradingView app listings also say adding the app to a product means **a 3% fee on every payment for that product**. Moving money out of your Whop balance costs a payout fee too. Enter your price and sales below to see each fee and what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="wf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price per sale (USD)<br><input id="wf-price" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="wf-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment method<br><select id="wf-method"><option value="card" selected>Card or wallet</option><option value="ach">ACH bank debit</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payout method (once a month)<br><select id="wf-payout"><option value="ach" selected>Next-day ACH ($2.50)</option><option value="rtp">Instant bank deposit (4% + $2.50)</option><option value="venmo">Venmo (5% + $2.50)</option><option value="crypto">Crypto (5% + $1.00)</option><option value="wire">Bank wire ($23)</option><option value="none">Don't include</option></select></label></p>
  </div>
  <p style="margin:0 0 4px"><label><input id="wf-app" type="checkbox" checked> Product uses Whop's Discord, Telegram or TradingView app (3%)</label></p>
  <p style="margin:0 0 4px"><label><input id="wf-intl" type="checkbox"> International card (+1.5%)</label> &nbsp; <label><input id="wf-fx" type="checkbox"> Currency conversion (+1%)</label></p>
  <p style="margin:0 0 4px"><label><input id="wf-billing" type="checkbox"> Billing add-on (0.5%)</label> &nbsp; <label><input id="wf-orch" type="checkbox"> Orchestration (0.8%)</label> &nbsp; <label><input id="wf-tax" type="checkbox"> Tax and remittance (2%)</label></p>
  <p style="margin:0 0 8px"><label><input id="wf-fraud" type="checkbox"> Fraud screening per card sale (Radar $0.07 + 3DS $0.03)</label></p>
  <p id="wf-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Buyer pays</td><td style="text-align:right" id="wf-s-price">$0.00</td></tr>
    <tr><td>Processing (<span id="wf-procrate">2.7% + $0.30</span>)</td><td style="text-align:right" id="wf-s-proc">$0.00</td></tr>
    <tr><td>App fee (3%)</td><td style="text-align:right" id="wf-s-app">$0.00</td></tr>
    <tr><td>Add-ons (<span id="wf-addrate">0%</span>)</td><td style="text-align:right" id="wf-s-add">$0.00</td></tr>
    <tr><td>Fraud screening</td><td style="text-align:right" id="wf-s-fraud">$0.00</td></tr>
    <tr><td>You keep per sale, before payout</td><td style="text-align:right"><strong id="wf-s-net">$0.00</strong></td></tr>
    <tr><td>Fees as a share of the price</td><td style="text-align:right" id="wf-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales revenue</td><td style="text-align:right" id="wf-m-gross">$0.00</td></tr>
    <tr><td>Sale fees</td><td style="text-align:right" id="wf-m-fees">$0.00</td></tr>
    <tr><td>Payout fee</td><td style="text-align:right" id="wf-m-payout">$0.00</td></tr>
    <tr><td>Lands in your account</td><td style="text-align:right"><strong id="wf-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of revenue</td><td style="text-align:right" id="wf-m-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale, before payout (USD)<br><input id="wf-target" type="number" min="0" step="0.01" value="45" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="wf-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Whop fee math. Rates from whop.com/network/pricing and docs.whop.com/fees (processing, surcharges, add-ons, fraud and payout fees), and the 3% line on Whop's Discord, Telegram and TradingView app listings, checked Oct 28, 2026. The 3% app fee is assumed to be charged on the full sale price. USD only; financing, disputes, refunds and sales tax amounts not modelled. */
(function (root) {
  var CHECKED = "2026-10-28";
  var CARD_PCT = 2.7, CARD_FIXED = 0.30, INTL = 1.5, FX = 1, ACH_PCT = 1.5, ACH_CAP = 5, APP = 3;
  var ADDONS = { billing: 0.5, orch: 0.8, tax: 2 }, FRAUD = 0.10;
  var PAYOUTS = { ach: { name: "Next-day ACH", pct: 0, flat: 2.5 }, rtp: { name: "Instant bank deposit", pct: 4, flat: 2.5 }, venmo: { name: "Venmo", pct: 5, flat: 2.5 }, crypto: { name: "Crypto", pct: 5, flat: 1 }, wire: { name: "Bank wire", pct: 0, flat: 23 }, none: { name: "None", pct: 0, flat: 0 } };
  var MAX_PRICE = 1000000, MAX_QTY = 1000000;
  function r2(n) { return Math.round(n * 100 + 1e-7) / 100; }
  function clean(v, max) { var n = Number(v); if (v === "" || v === null || !isFinite(n) || n <= 0) return 0; return Math.min(n, max); }
  function price(v) { return clean(v, MAX_PRICE); }
  function qty(v) { return Math.floor(clean(v, MAX_QTY)); }
  function addPct(o) { return (o.billing ? ADDONS.billing : 0) + (o.orch ? ADDONS.orch : 0) + (o.tax ? ADDONS.tax : 0); }
  function procPct(o) { return o.method === "ach" ? ACH_PCT : CARD_PCT + (o.intl ? INTL : 0) + (o.fx ? FX : 0); }
  function perSale(p, o) {
    o = o || {}; p = price(p); var ach = o.method === "ach", pp = procPct(o), ap = addPct(o);
    var proc = p > 0 ? (ach ? r2(Math.min(p * ACH_PCT / 100, ACH_CAP)) : r2(p * pp / 100 + CARD_FIXED)) : 0;
    var app = p > 0 && o.app ? r2(p * APP / 100) : 0, add = p > 0 ? r2(p * ap / 100) : 0, fraud = p > 0 && o.fraud && !ach ? FRAUD : 0;
    var fee = r2(proc + app + add + fraud);
    return { price: p, ach: ach, procPct: pp, procFixed: ach ? 0 : CARD_FIXED, proc: proc, app: app, addPct: Math.round(ap * 10) / 10, add: add, fraud: fraud, fee: fee, net: r2(p - fee), effective: p > 0 ? fee / p : null };
  }
  function payoutFee(balance, k) { var m = PAYOUTS[k] || PAYOUTS.ach; if (!(balance > 0) || k === "none") return 0; return Math.min(r2(balance * m.pct / 100 + m.flat), r2(balance)); }
  function perMonth(p, q, o) {
    o = o || {}; var s = perSale(p, o), n = qty(q), gross = r2(s.price * n), fees = r2(s.fee * n), bal = r2(gross - fees), pay = payoutFee(bal, o.payout || "ach");
    return { sales: n, gross: gross, fees: fees, payout: pay, net: r2(bal - pay), effective: gross > 0 ? (fees + pay) / gross : null };
  }
  function priceFor(target, o) {
    var k = price(target); if (!(k > 0)) return null; o = o || {}; var ach = o.method === "ach", other = (o.app ? APP : 0) + addPct(o), p;
    if (ach) { var g1 = 1 - (ACH_PCT + other) / 100; p = k / g1; if (p * ACH_PCT / 100 > ACH_CAP) p = (k + ACH_CAP) / (1 - other / 100); }
    else { var g = 1 - (procPct(o) + other) / 100; if (g <= 0) return null; p = (k + CARD_FIXED + (o.fraud ? FRAUD : 0)) / g; }
    p = Math.max(0.01, Math.ceil(p * 100 - 1e-6) / 100);
    while (p > 0.01 && perSale(r2(p - 0.01), o).net >= k) p = r2(p - 0.01);
    var guard = 0; while (perSale(p, o).net < k && guard++ < 1000) p = r2(p + 0.01);
    return p;
  }
  var api = { CHECKED: CHECKED, CARD_PCT: CARD_PCT, CARD_FIXED: CARD_FIXED, ACH_CAP: ACH_CAP, PAYOUTS: PAYOUTS, MAX_PRICE: MAX_PRICE, MAX_QTY: MAX_QTY, price: price, qty: qty, perSale: perSale, payoutFee: payoutFee, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.WhopFees = api;
})(this);
(function () {
  var F = window.WhopFees, $ = function (id) { return document.getElementById(id); };
  function set(id, t) { $(id).textContent = t; }
  function money(n) { return n == null ? "n/a" : (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(n) { return n == null ? "n/a" : (Math.round(n * 1000) / 10).toFixed(1) + "%"; }
  var boxes = ["wf-app", "wf-intl", "wf-fx", "wf-billing", "wf-orch", "wf-tax", "wf-fraud"];
  function update() {
    var p = $("wf-price").value, q = $("wf-qty").value;
    var o = { method: $("wf-method").value, payout: $("wf-payout").value, app: $("wf-app").checked, intl: $("wf-intl").checked, fx: $("wf-fx").checked, billing: $("wf-billing").checked, orch: $("wf-orch").checked, tax: $("wf-tax").checked, fraud: $("wf-fraud").checked };
    var w = [];
    if (Number(p) > F.MAX_PRICE) w.push("Price capped at " + money(F.MAX_PRICE) + ".");
    if (Number(q) > F.MAX_QTY) w.push("Sales capped at " + F.MAX_QTY.toLocaleString("en-US") + " a month.");
    if (Number(p) < 0 || Number(q) < 0) w.push("Negative numbers are treated as 0.");
    if (o.method === "ach" && (o.intl || o.fx || o.fraud)) w.push("International, currency and fraud fees apply to card sales only, so they are ignored for ACH.");
    set("wf-warn", w.join(" "));
    var s = F.perSale(p, o), m = F.perMonth(p, q, o);
    set("wf-procrate", s.ach ? "1.5%, max $5" : (Math.round(s.procPct * 10) / 10) + "% + " + money(s.procFixed)); set("wf-addrate", s.addPct + "%");
    set("wf-s-price", money(s.price)); set("wf-s-proc", money(s.proc)); set("wf-s-app", money(s.app)); set("wf-s-add", money(s.add)); set("wf-s-fraud", money(s.fraud)); set("wf-s-net", money(s.net)); set("wf-s-eff", pctS(s.effective));
    set("wf-m-gross", money(m.gross)); set("wf-m-fees", money(m.fees)); set("wf-m-payout", money(m.payout)); set("wf-m-net", money(m.net)); set("wf-m-eff", pctS(m.effective));
    var need = F.priceFor($("wf-target").value, o);
    set("wf-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + " to keep at least " + money(F.price($("wf-target").value)) + " per sale, before the payout fee.");
  }
  ["wf-price", "wf-qty", "wf-target"].forEach(function (id) { $(id).addEventListener("input", update); });
  ["wf-method", "wf-payout"].concat(boxes).forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

## Whop fees (checked Oct 28, 2026)

| Fee | Rate | When it applies |
|---|---|---|
| Cards and wallets (domestic) | 2.7% + 30¢ | Every successful card or wallet sale |
| International card | +1.5% | Cards issued outside the US |
| Currency conversion | +1% | Sales that need a currency conversion |
| ACH bank debit | 1.5%, max $5 | Payments from a US bank account |
| App fee | 3% | Products that use Whop's Discord, Telegram or TradingView app |
| Billing | 0.5% | When enabled |
| Orchestration | 0.8% | When enabled |
| Tax and remittance | 2% | When enabled and tax is collected |
| Radar and 3DS fraud checks | $0.07 and $0.03 | Per transaction |
| Dispute | $15 | Per chargeback |
| Financing (Klarna, Afterpay and similar) | 15%, or 20% for ClarityPay No Interest | Sales paid in installments |

| Payout method | Fee |
|---|---|
| Next-day ACH | $2.50 |
| Instant bank deposit | 4% + $2.50 |
| Venmo (US only) | 5% + $2.50 |
| Crypto | 5% + $1.00 |
| Bank wire | $23 |

Sources: [Whop's pricing page](https://whop.com/network/pricing/) and [Whop's fee docs](https://docs.whop.com/fees), checked Oct 28, 2026. The 3% app fee is not on either page. It appears on the listing of each app that applies it, which says that adding the app to a product "will subject you to a 3% fee for any payments on that product". Whop doesn't say whether the 3% is taken from the full price or from what's left after processing, so this calculator assumes the full price. Financing, disputes, refunds and the sales tax itself are not included, so treat the numbers as estimates and check your Whop dashboard.

## How the numbers are worked out

```
processing  = price x (2.7% + 1.5% if international + 1% if converted) + 30¢
              or, for ACH, price x 1.5%, capped at $5
app fee     = price x 3% if the product uses the Discord, Telegram or TradingView app
add-ons     = price x (0.5% billing + 0.8% orchestration + 2% tax), only those turned on
you keep    = price - processing - app fee - add-ons
per month   = you keep x sales - payout fee (one payout of the whole balance)
```

A $50 Discord membership paid by a US card costs $1.65 (2.7% + 30¢) plus $1.50 (3% app fee), so you keep $46.85. Without the Discord app you'd keep $48.35. At 20 sales a month, one next-day ACH payout of $937.00 costs $2.50, so $934.50 lands in your bank.

## FAQ

### How much does Whop take per sale?

A domestic card sale costs 2.7% + 30¢. International cards add 1.5% and currency conversion adds 1%. If the product uses Whop's Discord, Telegram or TradingView app, those app listings add a 3% fee on every payment, so a typical Discord sale costs 5.7% + 30¢.

### Does Whop have a monthly fee?

No. Whop's standard pricing is pay as you go, with no setup or monthly fee. You pay per sale, plus a fee when you move your balance out.

### Does Whop charge 3% for Discord access?

Whop's Discord app listing says adding the app to a product subjects you to a 3% fee for any payments on that product. The Telegram and TradingView apps say the same. The fee isn't listed on Whop's pricing page or fee docs.

### How much does it cost to withdraw from Whop?

Next-day ACH costs $2.50 per payout, an instant bank deposit costs 4% + $2.50, Venmo costs 5% + $2.50, crypto costs 5% + $1.00, and a bank wire costs $23.

### Is Whop cheaper than Gumroad, Lemon Squeezy or Patreon?

Often yes for a plain card sale, since 2.7% + 30¢ is below Gumroad's 10% + 50¢, Lemon Squeezy's 5% + 50¢ and Patreon's 10% plus processing. With the 3% app fee and a payout fee, the gap is smaller. Use the [seller fee comparison calculator](seller-fee-comparison-calculator) to compare at your own price.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type":"Question","name":"How much does Whop take per sale?","acceptedAnswer":{"@type":"Answer","text":"A domestic card sale costs 2.7% + 30 cents. International cards add 1.5% and currency conversion adds 1%. If the product uses Whop's Discord, Telegram or TradingView app, those app listings add a 3% fee on every payment, so a typical Discord sale costs 5.7% + 30 cents."}},
{"@type":"Question","name":"Does Whop have a monthly fee?","acceptedAnswer":{"@type":"Answer","text":"No. Whop's standard pricing is pay as you go, with no setup or monthly fee. You pay per sale, plus a fee when you move your balance out."}},
{"@type":"Question","name":"Does Whop charge 3% for Discord access?","acceptedAnswer":{"@type":"Answer","text":"Whop's Discord app listing says adding the app to a product subjects you to a 3% fee for any payments on that product. The Telegram and TradingView apps say the same. The fee isn't listed on Whop's pricing page or fee docs."}},
{"@type":"Question","name":"How much does it cost to withdraw from Whop?","acceptedAnswer":{"@type":"Answer","text":"Next-day ACH costs $2.50 per payout, an instant bank deposit costs 4% + $2.50, Venmo costs 5% + $2.50, crypto costs 5% + $1.00, and a bank wire costs $23."}},
{"@type":"Question","name":"Is Whop cheaper than Gumroad, Lemon Squeezy or Patreon?","acceptedAnswer":{"@type":"Answer","text":"Often yes for a plain card sale, since 2.7% + 30 cents is below Gumroad's 10% + 50 cents, Lemon Squeezy's 5% + 50 cents and Patreon's 10% plus processing. With the 3% app fee and a payout fee, the gap is smaller."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [Gumroad Discord roles and refunds](gumroad-discord-roles-refunds): selling Discord access through Gumroad instead
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): the 5% + 50¢ fee with its surcharges and payout fees
- [Patreon fee calculator (2026)](patreon-fee-calculator) and [Ko-fi fee calculator (2026)](ko-fi-fee-calculator) for memberships
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator)

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee, such as Whop's 5.7% + 30¢ on a Discord sale. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Whop, Discord, Stripe or PayPal. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
