---
layout: page
title: "Fiverr fee calculator (2026): the 20% seller fee, withdrawal fees and what you actually keep"
description: "Free Fiverr fee calculator for sellers. Enter your order amount and monthly orders to see Fiverr's flat 20% commission, what you earn, the PayPal, Payoneer or bank withdrawal fee, the optional 1% Early Payout, what lands after currency conversion, your monthly and yearly take-home, and the price to charge to keep a set amount."
---

Fiverr takes a **flat 20% commission** from every completed order, including Gig Extras and tips, so a seller keeps **80%** of the order amount. On top of that, moving your earnings out has a withdrawal fee that depends on the payout method, and non-US dollars get a conversion cost. Enter your numbers below to see the commission, what you earn, the withdrawal cost and what actually lands. Everything runs in your browser and nothing is sent anywhere.

<div id="fv" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Order amount (USD)<br><input id="fv-amt" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Orders per month<br><input id="fv-qty" type="number" min="0" step="1" value="20" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Withdrawal method<br><select id="fv-method" style="width:100%;max-width:200px"><option value="paypal">PayPal ($0)</option><option value="bank">Bank transfer via Payoneer ($1)</option><option value="payoneer">Payoneer account ($3)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Conversion cost after it lands (%)<br><input id="fv-conv" type="number" min="0" max="100" step="0.1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="fv-early" type="checkbox"> I use Early Payout (1% of cleared earnings; Top Rated and Seller Plus Premium only)</label></p>
  <p id="fv-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per order</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Order amount</td><td style="text-align:right" id="fv-s-amt">$0.00</td></tr>
    <tr><td>Fiverr 20% service fee</td><td style="text-align:right" id="fv-s-fee">$0.00</td></tr>
    <tr><td>You earn (80%)</td><td style="text-align:right"><strong id="fv-s-net">$0.00</strong></td></tr>
    <tr><td>What your buyer pays (with the buyer service fee)</td><td style="text-align:right" id="fv-s-buyer">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Sales</td><td style="text-align:right" id="fv-m-gross">$0.00</td></tr>
    <tr><td>Fiverr 20% commission</td><td style="text-align:right" id="fv-m-comm">$0.00</td></tr>
    <tr><td>You earn</td><td style="text-align:right" id="fv-m-earn">$0.00</td></tr>
    <tr><td>Early Payout (1%)</td><td style="text-align:right" id="fv-m-early">$0.00</td></tr>
    <tr><td>Withdrawal fee</td><td style="text-align:right" id="fv-m-wfee">$0.00</td></tr>
    <tr><td>Conversion cost</td><td style="text-align:right" id="fv-m-conv">$0.00</td></tr>
    <tr><td>What lands</td><td style="text-align:right"><strong id="fv-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of sales</td><td style="text-align:right" id="fv-m-eff">n/a</td></tr>
    <tr><td>What lands per year (12 months like this)</td><td style="text-align:right" id="fv-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to earn per order after Fiverr's 20% (USD)<br><input id="fv-target" type="number" min="0" step="0.01" value="80" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="fv-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Fiverr fee math. Seller commission is a flat 20% of every completed order including Gig Extras and tips, so the seller earns 80% (Fiverr Help Center "Your earnings page", help.fiverr.com/hc/en-us/articles/9234443621137, and the Payment Terms). Withdrawal fees per method (Fiverr Help Center "Payout methods", help.fiverr.com/hc/en-us/articles/360010530278): PayPal $0 (min $1), Bank transfer via Payoneer $1 (min $20 outside the US, $10 in the US), Payoneer account $3 (min $10). Non-USD withdrawals carry a currency conversion cost from your provider. Early Payout costs 1% of the cleared amount and is only for Top Rated or Seller Plus Premium sellers. Per withdrawal Fiverr sends at most $5,000, so larger balances are split into several withdrawals, each charged the fee. Buyer service fee is 5.5% of the order plus $3.50 on orders under $200 (Fiverr Help Center "Paying for orders, extras, or custom offers", help.fiverr.com/hc/en-us/articles/37332672658193); it is paid by the buyer, not deducted from the seller. Checked Oct 28, 2026. */
(function (root) {
  var CHECKED = "2026-10-28";
  var RATE = 0.20, EARLY = 0.01, LIMIT = 5000;
  var METHODS = { paypal: 0, bank: 1, payoneer: 3 };
  var BSVC = 0.055, BFIXED = 3.50, BTHRESH = 200;
  var MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function qty(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function share(v) { return Math.min(num(v), 100) / 100; }
  function method(k) { return METHODS.hasOwnProperty(k) ? k : "paypal"; }
  function perOrder(v) {
    var a = amt(v);
    if (a <= 0) return { amount: 0, fee: 0, net: 0, buyer: 0, effective: null };
    var fee = r2(a * RATE);
    return { amount: a, fee: fee, net: r2(a - fee), buyer: r2(a + buyerFee(a)), effective: fee / a };
  }
  function buyerFee(a) { return a <= 0 ? 0 : r2(a * BSVC + (a < BTHRESH ? BFIXED : 0)); }
  function withdrawals(net) { return net <= 0 ? 0 : Math.ceil(net / LIMIT); }
  function perMonth(v, q, k, early, conv) {
    var a = amt(v), n = qty(q), gross = r2(a * n);
    if (gross <= 0) { var pl0 = 0; return { gross: 0, comm: 0, earn: 0, early: 0, wfee: 0, conv: 0, net: 0, year: 0, effective: null, withdrawals: 0 }; }
    var comm = r2(gross * RATE), earn = r2(gross - comm);
    var earlyFee = early ? r2(earn * EARLY) : 0, afterEarly = r2(earn - earlyFee);
    var w = withdrawals(afterEarly), wfee = r2(METHODS[method(k)] * w), afterW = r2(afterEarly - wfee);
    var convCost = r2(afterW * share(conv)), net = r2(afterW - convCost);
    return { gross: gross, comm: comm, earn: earn, early: earlyFee, wfee: wfee, conv: convCost, net: net, year: r2(net * 12), effective: (gross - net) / gross, withdrawals: w };
  }
  /* Flat 20%, so to earn T after the commission charge T / 0.8. */
  function priceFor(v) { var t = amt(v); return t <= 0 ? null : r2(t / (1 - RATE)); }
  var api = { CHECKED: CHECKED, RATE: RATE, EARLY: EARLY, LIMIT: LIMIT, METHODS: METHODS, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, qty: qty, share: share, perOrder: perOrder, buyerFee: buyerFee, withdrawals: withdrawals, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.FiverrFees = api;
})(this);
</script>

<script>
(function () {
  var F = window.FiverrFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { return "$" + (Math.round(x * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var av = $("fv-amt").value, qv = $("fv-qty").value, k = $("fv-method").value, cv = $("fv-conv").value, early = $("fv-early").checked;
    var s = F.perOrder(av), m = F.perMonth(av, qv, k, early, cv);
    $("fv-warn").textContent = (F.amt(av) >= F.MAX_AMT || F.qty(qv) >= F.MAX_QTY) ? "Large numbers are capped." : "";
    set("fv-s-amt", money(s.amount)); set("fv-s-fee", money(s.fee)); set("fv-s-net", money(s.net)); set("fv-s-buyer", money(s.buyer));
    set("fv-m-gross", money(m.gross)); set("fv-m-comm", money(m.comm)); set("fv-m-earn", money(m.earn));
    set("fv-m-early", money(m.early)); set("fv-m-wfee", money(m.wfee) + (m.withdrawals > 1 ? " (" + m.withdrawals + " withdrawals)" : "")); set("fv-m-conv", money(m.conv));
    set("fv-m-net", money(m.net)); set("fv-m-eff", pctS(m.effective)); set("fv-y-net", money(m.year));
    var need = F.priceFor($("fv-target").value);
    set("fv-need", need == null ? "Enter how much you want to earn per order." : "Charge " + money(need) + " to earn " + money(F.amt($("fv-target").value)) + " per order after Fiverr's 20% (before any withdrawal fee).");
  }
  ["fv-amt", "fv-qty", "fv-method", "fv-conv", "fv-early", "fv-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Fiverr seller fees (checked Oct 28, 2026)

| Fee | What it is |
|---|---|
| Service fee (commission) | A flat 20% of every completed order, including Gig Extras and tips. You earn 80%. |
| Separate card or Stripe fee | None on the seller side. The buyer pays Fiverr; you earn 80% of the order amount. |
| Buyer service fee | 5.5% of the order plus $3.50 on orders under $200. Paid by the buyer, not taken from you. |
| Clearing period | Earnings clear in 14 days (shorter for Top Rated and Fiverr Pro) before you can withdraw. |
| Early Payout | Optional 1% of the cleared amount to skip the clearing period. Top Rated and Seller Plus Premium only; not on hourly orders. |
| Withdraw to PayPal | $0 Fiverr fee, minimum $1. PayPal's own conversion or cash-out fees may apply. |
| Withdraw by bank transfer (Payoneer) | $1, minimum $20 outside the US or $10 in the US. Non-USD includes conversion fees. |
| Withdraw to a Payoneer account | $3, minimum $10. Payoneer's own fees apply to move it to your bank. |
| Withdrawal limit | Up to $5,000 per withdrawal; larger balances are split into several, each charged the fee. |

The 20% commission is from Fiverr's [earnings page help article](https://help.fiverr.com/hc/en-us/articles/9234443621137-Your-earnings-page) and Payment Terms; the withdrawal fees from [Payout methods](https://help.fiverr.com/hc/en-us/articles/360010530278-Payout-methods); and the buyer service fee from [Paying for orders](https://help.fiverr.com/hc/en-us/articles/37332672658193-Paying-for-orders-extras-or-custom-offers), all checked Oct 28, 2026. Amounts are in US dollars; withdrawals in another currency carry a conversion cost that varies by provider. Treat the numbers as estimates and check your own Fiverr earnings and withdrawal screens.

## How the numbers are worked out

```
fiverr fee   = order x 20%
you earn     = order x 80%
buyer pays   = order + 5.5% + $3.50 (orders under $200)   ; buyer's cost, not yours
early payout = your monthly earnings x 1%                 ; only if you use it
withdrawals  = ceil(earnings / $5,000)                    ; each one is charged the fee
what lands   = earnings - early payout - withdrawal fees - conversion cost
price to earn T = T / 0.8
```

A $100 order has a $20 Fiverr fee, so you earn $80, while the buyer pays about $109 after the buyer service fee. At 20 orders of $100 a month, Fiverr's 20% is $400, you earn $1,600, and with a $0 PayPal withdrawal that is $1,600 that lands, or $19,200 a year. To earn $80 after the 20% cut on a single order you charge $100 ($80 / 0.8).

## FAQ

### How much does Fiverr take from sellers?

Fiverr takes a flat 20% service fee from every completed order, including Gig Extras and tips, so you keep 80%. On a $100 order that is $20 to Fiverr and $80 to you. There is no separate card or Stripe fee on the seller side.

### Does Fiverr charge a fee to withdraw my earnings?

It depends on the payout method. Withdrawing to PayPal has a $0 Fiverr fee (minimum $1), a bank transfer through Payoneer is $1 (minimum $20 outside the US, $10 in the US), and a Payoneer account is $3 (minimum $10). Your bank or PayPal may add its own conversion or cash-out fees, and Fiverr sends at most $5,000 per withdrawal.

### What is the Fiverr buyer service fee?

Separate from the seller's 20%, Fiverr adds a service fee to the buyer at checkout: 5.5% of the order plus $3.50 on orders under $200. The buyer pays it, so it does not come out of your 80%. The calculator shows it so you can see your buyer's full cost.

### What is Fiverr Early Payout and the clearing period?

Earnings clear in 14 days before you can withdraw (shorter for Top Rated and Fiverr Pro sellers). Top Rated and Seller Plus Premium sellers can use Early Payout to skip the wait for 1% of the cleared amount each time, though it is not available on hourly orders.

### How much should I charge on Fiverr to earn a set amount?

Because the fee is a flat 20%, divide your target by 0.8. To earn $80 after Fiverr's cut, charge $100; to earn $200, charge $250. Use the calculator's "price to keep a set amount" box to work it out for any target.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Fiverr take from sellers?", "acceptedAnswer": {"@type": "Answer", "text": "Fiverr takes a flat 20% service fee from every completed order, including Gig Extras and tips, so you keep 80%. On a $100 order that is $20 to Fiverr and $80 to you. There is no separate card or Stripe fee on the seller side."}},
{"@type": "Question", "name": "Does Fiverr charge a fee to withdraw my earnings?", "acceptedAnswer": {"@type": "Answer", "text": "It depends on the payout method. Withdrawing to PayPal has a $0 Fiverr fee (minimum $1), a bank transfer through Payoneer is $1 (minimum $20 outside the US, $10 in the US), and a Payoneer account is $3 (minimum $10). Your bank or PayPal may add its own conversion or cash-out fees, and Fiverr sends at most $5,000 per withdrawal."}},
{"@type": "Question", "name": "What is the Fiverr buyer service fee?", "acceptedAnswer": {"@type": "Answer", "text": "Separate from the seller's 20%, Fiverr adds a service fee to the buyer at checkout: 5.5% of the order plus $3.50 on orders under $200. The buyer pays it, so it does not come out of your 80%. The calculator shows it so you can see your buyer's full cost."}},
{"@type": "Question", "name": "What is Fiverr Early Payout and the clearing period?", "acceptedAnswer": {"@type": "Answer", "text": "Earnings clear in 14 days before you can withdraw (shorter for Top Rated and Fiverr Pro sellers). Top Rated and Seller Plus Premium sellers can use Early Payout to skip the wait for 1% of the cleared amount each time, though it is not available on hourly orders."}},
{"@type": "Question", "name": "How much should I charge on Fiverr to earn a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Because the fee is a flat 20%, divide your target by 0.8. To earn $80 after Fiverr's cut, charge $100; to earn $200, charge $250. Use the calculator's price-to-keep box to work it out for any target."}}
]}
</script>

## Related tools and guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): what you keep on each platform, sorted by net
- [Upwork fee calculator (2026)](upwork-fee-calculator): Upwork's 0% to 15% service fee, Connects and withdrawal fees, for comparing the two marketplaces
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% Social Security and Medicare tax on your Fiverr earnings
- [Freelance hourly rate calculator (2026)](freelance-hourly-rate-calculator): the rate to charge once tax and time off are built in
- [Freelance quarterly estimated tax calculator (2026)](freelance-quarterly-estimated-tax-calculator) and [what to include on a freelance invoice](what-to-include-on-a-freelance-invoice)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator) for the fees after money reaches PayPal
- [Gumroad fee calculator](gumroad-fee-calculator) and [Etsy fee & profit calculator](etsy-fee-calculator) for selling products instead of services

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Fiverr. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
