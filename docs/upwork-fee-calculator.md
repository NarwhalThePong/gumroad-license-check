---
layout: page
title: "Upwork fee calculator (2026): the 0% to 15% freelancer service fee, Connects, withdrawal fees and what you keep"
description: "Free Upwork fee calculator for freelancers. Enter your rate, hours or projects per month and the service fee shown on your contract (0% to 15%) to see the fee, what you earn, Connects and Freelancer Plus costs, the withdrawal fee by method, your monthly and yearly take-home, and the rate to charge to keep a set amount."
---

Since May 1, 2025, Upwork charges freelancers a **variable service fee from 0% to 15%** on each new contract, instead of the old flat 10%. You see the exact percentage before you send a proposal or accept an offer, and it stays locked for the life of that contract. On top of the fee, Connects for proposals cost $0.15 each, and moving money out can carry a withdrawal fee depending on the method. Enter your numbers below to see what you actually keep. Everything runs in your browser and nothing is sent anywhere.

<div id="uw" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Rate billed to the client (USD per hour or per project)<br><input id="uw-rate" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Hours or projects per month<br><input id="uw-qty" type="number" min="0" step="0.5" value="80" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Freelancer service fee on the contract (%)<br><input id="uw-fee" type="number" min="0" max="15" step="0.5" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Withdrawal method<br><select id="uw-method" style="width:100%;max-width:220px"><option value="usbank">Direct to U.S. Bank, U.S. tax address ($0)</option><option value="usbankintl">Direct to U.S. Bank, non-U.S. tax address ($2.99)</option><option value="local">Direct to Local Bank ($0.99)</option><option value="instant">Instant Pay, U.S. ($2.00)</option><option value="wire">U.S. dollar wire ($50)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Withdrawals per month<br><input id="uw-wd" type="number" min="0" step="1" value="2" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Connects bought per month<br><input id="uw-conn" type="number" min="0" step="1" value="0" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Conversion cost after it lands (%)<br><input id="uw-conv" type="number" min="0" max="100" step="0.1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="uw-plus" type="checkbox"> I pay for Freelancer Plus ($19.99 a month)</label></p>
  <p id="uw-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per hour or project</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Billed to the client</td><td style="text-align:right" id="uw-s-amt">$0.00</td></tr>
    <tr><td>Upwork service fee</td><td style="text-align:right" id="uw-s-fee">$0.00</td></tr>
    <tr><td>You earn</td><td style="text-align:right"><strong id="uw-s-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Billed</td><td style="text-align:right" id="uw-m-gross">$0.00</td></tr>
    <tr><td>Upwork service fee</td><td style="text-align:right" id="uw-m-fee">$0.00</td></tr>
    <tr><td>You earn</td><td style="text-align:right" id="uw-m-earn">$0.00</td></tr>
    <tr><td>Connects bought ($0.15 each)</td><td style="text-align:right" id="uw-m-conn">$0.00</td></tr>
    <tr><td>Freelancer Plus</td><td style="text-align:right" id="uw-m-plus">$0.00</td></tr>
    <tr><td>Withdrawal fees</td><td style="text-align:right" id="uw-m-wfee">$0.00</td></tr>
    <tr><td>Conversion cost</td><td style="text-align:right" id="uw-m-conv">$0.00</td></tr>
    <tr><td>What lands</td><td style="text-align:right"><strong id="uw-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what you billed</td><td style="text-align:right" id="uw-m-eff">n/a</td></tr>
    <tr><td>What lands per year (12 months like this)</td><td style="text-align:right" id="uw-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Rate to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to earn per hour or project after the service fee (USD)<br><input id="uw-target" type="number" min="0" step="0.01" value="45" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="uw-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Upwork fee math. Freelancer Service Fee is variable from 0% to 15% per contract, shown before you propose or accept and locked for the contract; charged on all earnings including bonuses (Upwork Help "Learn about the Freelancer Service Fee", support.upwork.com/hc/en-us/articles/211062538, and upwork.com/pricing/freelancer). Withdrawal fees (Upwork Help "How to get paid on Upwork", support.upwork.com/hc/en-us/articles/211060918): Direct to U.S. Bank free with a U.S. tax address, $2.99 with a non-U.S. tax address from Sept 1, 2026; Direct to Local Bank $0.99; Instant Pay $2.00; U.S. dollar wire $50. Connects cost $0.15 each (support.upwork.com/hc/en-us/articles/211062898). Freelancer Plus is $19.99 a month (upwork.com/resources/is-upwork-free). Checked Oct 28, 2026. */
(function (root) {
  var CHECKED = "2026-10-28";
  var MAX_FEE = 0.15, CONNECT = 0.15, PLUS = 19.99;
  var METHODS = { usbank: 0, usbankintl: 2.99, local: 0.99, instant: 2, wire: 50 };
  var MAX_AMT = 1000000, MAX_QTY = 100000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function qty(v) { return Math.min(Math.round(num(v) * 100) / 100, MAX_QTY); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function rate(v) { return Math.min(num(v), MAX_FEE * 100) / 100; }
  function share(v) { return Math.min(num(v), 100) / 100; }
  function method(k) { return METHODS.hasOwnProperty(k) ? k : "usbank"; }
  function perUnit(v, f) {
    var a = amt(v), p = rate(f);
    if (a <= 0) return { amount: 0, fee: 0, net: 0, effective: null };
    var fee = r2(a * p);
    return { amount: a, fee: fee, net: r2(a - fee), effective: fee / a };
  }
  function perMonth(v, q, f, k, wd, conn, plus, conv) {
    var gross = r2(amt(v) * qty(q)), p = rate(f);
    var fee = r2(gross * p), earn = r2(gross - fee);
    var connCost = r2(count(conn) * CONNECT), plusCost = plus ? PLUS : 0;
    var wfee = gross > 0 ? r2(METHODS[method(k)] * count(wd)) : 0;
    var afterW = r2(earn - connCost - plusCost - wfee);
    var convCost = afterW > 0 ? r2(afterW * share(conv)) : 0;
    var net = r2(afterW - convCost);
    return { gross: gross, fee: fee, earn: earn, conn: connCost, plus: plusCost, wfee: wfee, conv: convCost, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  /* To earn T after a fee of p, bill T / (1 - p). Upwork's own example: $20 at 10% -> $22.22. */
  function rateFor(v, f) { var t = amt(v); return t <= 0 ? null : r2(t / (1 - rate(f))); }
  var api = { CHECKED: CHECKED, MAX_FEE: MAX_FEE, CONNECT: CONNECT, PLUS: PLUS, METHODS: METHODS, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, qty: qty, count: count, rate: rate, share: share, perUnit: perUnit, perMonth: perMonth, rateFor: rateFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.UpworkFees = api;
})(this);
</script>

<script>
(function () {
  var U = window.UpworkFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var rv = $("uw-rate").value, qv = $("uw-qty").value, fv = $("uw-fee").value, k = $("uw-method").value;
    var s = U.perUnit(rv, fv), m = U.perMonth(rv, qv, fv, k, $("uw-wd").value, $("uw-conn").value, $("uw-plus").checked, $("uw-conv").value);
    var w = [];
    if (Number(fv) > 15) w.push("Upwork's service fee tops out at 15%, so the fee is capped there.");
    if (U.amt(rv) >= U.MAX_AMT || U.qty(qv) >= U.MAX_QTY) w.push("Large numbers are capped.");
    $("uw-warn").textContent = w.join(" ");
    set("uw-s-amt", money(s.amount)); set("uw-s-fee", money(s.fee)); set("uw-s-net", money(s.net));
    set("uw-m-gross", money(m.gross)); set("uw-m-fee", money(m.fee)); set("uw-m-earn", money(m.earn));
    set("uw-m-conn", money(m.conn)); set("uw-m-plus", money(m.plus)); set("uw-m-wfee", money(m.wfee)); set("uw-m-conv", money(m.conv));
    set("uw-m-net", money(m.net)); set("uw-m-eff", pctS(m.effective)); set("uw-y-net", money(m.year));
    var need = U.rateFor($("uw-target").value, fv);
    set("uw-need", need == null ? "Enter how much you want to earn per hour or project." : "Bill " + money(need) + " to earn " + money(U.amt($("uw-target").value)) + " after a " + pctS(U.rate(fv)) + " service fee (before withdrawal fees).");
  }
  ["uw-rate", "uw-qty", "uw-fee", "uw-method", "uw-wd", "uw-conn", "uw-conv", "uw-plus", "uw-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Upwork freelancer fees (checked Oct 28, 2026)

| Fee | What it is |
|---|---|
| Freelancer service fee | Variable, 0% to 15% of what you bill on each contract, including bonuses. Shown before you propose or accept, and locked for that contract. Contracts started before May 1, 2025 keep their old fee. |
| Direct Contracts | 5% on Freelancer Basic, 0% on Freelancer Plus, for clients you bring to Upwork yourself. |
| Any Hire and Upwork Payroll | No freelancer service fee. |
| Connects | $0.15 each, bought in bundles or custom amounts of at least 10. Basic accounts may get 10 free a month. |
| Freelancer Plus | $19.99 a month, with 100 Connects a month and 0% on Direct Contracts. The service fee range on marketplace contracts is still 0% to 15%. |
| Direct to U.S. Bank | Free with a U.S. tax address; $2.99 per withdrawal with a non-U.S. tax address from Sept 1, 2026. |
| Direct to Local Bank | $0.99 per withdrawal, plus any incoming fee your bank charges. |
| Instant Pay (U.S.) | $2.00 per withdrawal. |
| U.S. dollar wire | $50 per transfer, plus any intermediary or receiving bank fees. |
| PayPal and Payoneer | Available in many countries; the provider may charge its own fees, so check your withdrawal settings for the current amount. |

The service fee rules are from Upwork's [Freelancer Service Fee help article](https://support.upwork.com/hc/en-us/articles/211062538-Learn-about-the-Freelancer-Service-Fee) and [freelancer pricing page](https://www.upwork.com/pricing/freelancer); the withdrawal fees from [How to get paid on Upwork](https://support.upwork.com/hc/en-us/articles/211060918-How-to-get-paid-on-Upwork); Connects from [Understanding and using Connects](https://support.upwork.com/hc/en-us/articles/211062898-Understanding-and-using-Connects); and Freelancer Plus from Upwork's [pricing breakdown](https://www.upwork.com/resources/is-upwork-free), all checked Oct 28, 2026. Treat the numbers as estimates and check the fee on your own contract and withdrawal screens.

## How the numbers are worked out

```
service fee   = billed x your contract's fee (0% to 15%)
you earn      = billed - service fee
connects      = connects bought x $0.15
withdrawals   = withdrawals per month x your method's fee
what lands    = earnings - connects - Freelancer Plus - withdrawal fees - conversion cost
rate to earn T = T / (1 - fee)
```

At $50 an hour for 80 hours a month on a 10% contract, you bill $4,000, Upwork's fee is $400, and you earn $3,600. With two free Direct to U.S. Bank withdrawals and no Connects bought, that is $3,600 that lands, or $43,200 a year. To earn $45 an hour after a 10% fee you bill $50 ($45 / 0.9), and Upwork's own example is $22.22 an hour to keep $20.

## FAQ

### How much does Upwork take from freelancers in 2026?

Upwork charges a freelancer service fee of 0% to 15% per contract, set when the contract starts and locked for its life. On $100 billed at 10% that is $10 to Upwork and $90 to you; at 15% it is $15 and $85. The fee also applies to bonuses.

### Is the Upwork fee still 10%?

Not for new contracts. Since May 1, 2025 the fee varies from 0% to 15% by contract, based on factors such as demand for the type of work. Contracts that started before then keep the fee they had, and Enterprise client contracts are typically 10%.

### How much does it cost to withdraw money from Upwork?

Direct to U.S. Bank is free with a U.S. tax address, and $2.99 per withdrawal with a non-U.S. tax address from Sept 1, 2026. Direct to Local Bank is $0.99, Instant Pay is $2.00, and a U.S. dollar wire is $50. Your bank, PayPal or Payoneer may add their own fees.

### How much do Upwork Connects cost?

Connects cost $0.15 each, with a minimum purchase of 10, so 100 Connects cost $15. Basic accounts may get 10 free Connects a month and Freelancer Plus includes 100. The calculator subtracts what you spend on Connects from your take-home.

### What rate should I charge on Upwork to earn a set amount?

Divide your target by one minus the fee. On a 10% contract, to earn $45 an hour bill $50; on a 15% contract bill $52.94. Use the calculator's "rate to keep a set amount" box with the fee shown on your offer.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Upwork take from freelancers in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "Upwork charges a freelancer service fee of 0% to 15% per contract, set when the contract starts and locked for its life. On $100 billed at 10% that is $10 to Upwork and $90 to you; at 15% it is $15 and $85. The fee also applies to bonuses."}},
{"@type": "Question", "name": "Is the Upwork fee still 10%?", "acceptedAnswer": {"@type": "Answer", "text": "Not for new contracts. Since May 1, 2025 the fee varies from 0% to 15% by contract, based on factors such as demand for the type of work. Contracts that started before then keep the fee they had, and Enterprise client contracts are typically 10%."}},
{"@type": "Question", "name": "How much does it cost to withdraw money from Upwork?", "acceptedAnswer": {"@type": "Answer", "text": "Direct to U.S. Bank is free with a U.S. tax address, and $2.99 per withdrawal with a non-U.S. tax address from Sept 1, 2026. Direct to Local Bank is $0.99, Instant Pay is $2.00, and a U.S. dollar wire is $50. Your bank, PayPal or Payoneer may add their own fees."}},
{"@type": "Question", "name": "How much do Upwork Connects cost?", "acceptedAnswer": {"@type": "Answer", "text": "Connects cost $0.15 each, with a minimum purchase of 10, so 100 Connects cost $15. Basic accounts may get 10 free Connects a month and Freelancer Plus includes 100. The calculator subtracts what you spend on Connects from your take-home."}},
{"@type": "Question", "name": "What rate should I charge on Upwork to earn a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide your target by one minus the fee. On a 10% contract, to earn $45 an hour bill $50; on a 15% contract bill $52.94. Use the calculator's rate-to-keep box with the fee shown on your offer."}}
]}
</script>

## Related tools and guides

- [Fiverr fee calculator (2026)](fiverr-fee-calculator): Fiverr's flat 20% seller fee, for comparing the two marketplaces
- [Freelance hourly rate calculator (2026)](freelance-hourly-rate-calculator): the rate to charge once tax and time off are built in
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% Social Security and Medicare tax on your Upwork earnings
- [Freelance quarterly estimated tax calculator (2026)](freelance-quarterly-estimated-tax-calculator) and [what to include on a freelance invoice](what-to-include-on-a-freelance-invoice)
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator) for the fees after money reaches PayPal

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Upwork. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
