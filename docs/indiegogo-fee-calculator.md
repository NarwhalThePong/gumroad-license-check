---
layout: page
title: "Indiegogo fee calculator (2026): what US creators keep after the 5% platform fee and payment processing"
description: "Free Indiegogo fee calculator for US creators. See the 5% platform fee, payment processing of 3% + $0.20 per payment, what you keep from your campaign, net after reward fulfillment and how many backers you need to keep a set amount. No fees if the project doesn't reach its goal."
---

Indiegogo charges a **5% platform fee on the amount collected** and **payment processing of 3% of each payment plus $0.20**. If your project doesn't reach its goal, you pay nothing, not even processing. Raise $12,000 from 200 backers pledging $60 each and you pay $600.00 to Indiegogo plus $400.00 in processing, so you keep $11,000.00, or 91.7% of the total. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="igg" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Funding goal (USD)<br><input id="igg-goal" type="number" min="0" step="0.01" value="10000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Backers at your main pledge<br><input id="igg-na" type="number" min="0" step="1" value="200" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Main pledge, including any shipping (USD)<br><input id="igg-pa" type="number" min="0" step="0.01" value="60" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Backers at a second pledge level (optional)<br><input id="igg-nb" type="number" min="0" step="1" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Second pledge amount (USD)<br><input id="igg-pb" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cost to make and ship each main reward (optional, USD)<br><input id="igg-cost" type="number" min="0" step="0.01" value="15" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="igg-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Your campaign</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Backers</td><td style="text-align:right"><span id="igg-backers">0</span></td></tr>
    <tr><td>Total raised</td><td style="text-align:right"><span id="igg-raised">$0.00</span></td></tr>
    <tr><td>Indiegogo platform fee (5%)</td><td style="text-align:right"><span id="igg-fee">$0.00</span></td></tr>
    <tr><td>Processing per main pledge</td><td style="text-align:right"><span id="igg-ppa">$0.00</span></td></tr>
    <tr><td>Processing per second-level pledge</td><td style="text-align:right"><span id="igg-ppb">$0.00</span></td></tr>
    <tr><td>Payment processing in total</td><td style="text-align:right"><span id="igg-proc">$0.00</span></td></tr>
    <tr><td>All fees</td><td style="text-align:right"><span id="igg-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of the total</td><td style="text-align:right"><span id="igg-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="igg-net">$0.00</strong></td></tr>
    <tr><td>Reward fulfillment</td><td style="text-align:right"><span id="igg-ful">$0.00</span></td></tr>
    <tr><td>Left after fulfillment</td><td style="text-align:right"><strong id="igg-profit">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Backers needed to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep after Indiegogo's fees (USD)<br><input id="igg-target" type="number" min="0" step="0.01" value="20000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="igg-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Indiegogo fee math for US creators (checked 2026-10-29 from help.indiegogo.com/article/596-fees). All math in integer cents; Indiegogo does not publish its rounding, so each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, PLAT_BP = 500, PROC_BP = 300, PROC_FIX = 20;
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(v) { return Math.round(v * 100); }
  function bp(c, b) { return Math.floor((c * b + 5000) / 10000); }
  function procFee(c) { return c <= 0 ? 0 : bp(c, PROC_BP) + PROC_FIX; }
  function partsC(na, pa, nb, pb, goal, cost) {
    var raised = na * pa + nb * pb, funded = raised > 0 && raised >= goal;
    var plat = funded ? bp(raised, PLAT_BP) : 0, proc = funded ? na * procFee(pa) + nb * procFee(pb) : 0;
    var net = funded ? raised - plat - proc : 0, ful = funded ? na * cost : 0;
    return { raised: raised, funded: funded, plat: plat, proc: proc, fees: plat + proc, net: net, ful: ful, profit: net - ful };
  }
  function calc(na, pa, nb, pb, goal, cost) {
    var a = count(na), b = count(nb), A = cents(amt(pa)), Bc = cents(amt(pb)), G = cents(big(goal)), C = cents(amt(cost));
    var p = partsC(a, A, b, Bc, G, C), d = function (x) { return x / 100; };
    return { backers: a + b, raised: d(p.raised), funded: p.funded, goal: d(G), plat: d(p.plat), proc: d(p.proc), fees: d(p.fees), net: d(p.net), ful: d(p.ful), profit: d(p.profit), effective: p.funded && p.raised > 0 ? p.fees / p.raised : null, perPledgeA: d(procFee(A)), perPledgeB: d(procFee(Bc)) };
  }
  /* fewest main-level backers at pledge pa (other inputs fixed) so that net after fees >= target and the goal is met */
  function backersFor(target, pa, nb, pb, goal) {
    var T = cents(big(target)), A = cents(amt(pa)), b = count(nb), Bc = cents(amt(pb)), G = cents(big(goal));
    if (T <= 0 || A <= 0) return null;
    var ok = function (n) { var p = partsC(n, A, b, Bc, G, 0); return p.funded && p.net >= T; };
    if (!ok(MAX_QTY)) return null;
    var lo = 0, hi = MAX_QTY;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (ok(m)) hi = m; else lo = m + 1; }
    var p = partsC(lo, A, b, Bc, G, 0);
    return { backers: lo, raised: p.raised / 100, net: p.net / 100 };
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, PLAT_BP: PLAT_BP, PROC_BP: PROC_BP, PROC_FIX: PROC_FIX, num: num, amt: amt, count: count, procFee: procFee, partsC: partsC, calc: calc, backersFor: backersFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.IggFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.IggFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var na = $("igg-na").value, pa = $("igg-pa").value, nb = $("igg-nb").value, pb = $("igg-pb").value, g = $("igg-goal").value, c = $("igg-cost").value, w = [];
    var r = B.calc(na, pa, nb, pb, g, c);
    if (B.amt(pa) >= B.MAX_AMT || B.amt(pb) >= B.MAX_AMT || B.count(na) >= B.MAX_QTY || B.count(nb) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (r.raised > 0 && !r.funded) w.push("This total is below your goal, so the project does not reach it: no fees apply and you receive nothing.");
    if (r.funded && r.profit < 0) w.push("After reward fulfillment this campaign loses money.");
    $("igg-warn").textContent = w.join(" ");
    set("igg-backers", r.backers.toLocaleString("en-US")); set("igg-raised", money(r.raised)); set("igg-fee", money(r.plat)); set("igg-proc", money(r.proc)); set("igg-fees", money(r.fees)); set("igg-eff", pctS(r.effective)); set("igg-net", money(r.net)); set("igg-ful", money(r.ful)); set("igg-profit", money(r.profit)); set("igg-ppa", money(r.perPledgeA)); set("igg-ppb", money(r.perPledgeB));
    var T = $("igg-target").value, need = B.backersFor(T, pa, nb, pb, g);
    set("igg-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(pa) <= 0 ? "Enter a main pledge amount." : need == null ? "No number of backers reaches that amount." : "You need " + need.backers.toLocaleString("en-US") + " backers at " + money(B.amt(pa)) + " (plus the second pledge level above), raising " + money(need.raised) + " and keeping " + money(need.net) + " after fees.");
  }
  ["igg-na", "igg-pa", "igg-nb", "igg-pb", "igg-goal", "igg-cost", "igg-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Indiegogo fees in the US (checked Oct 29, 2026)

| Fee | Rate | When it applies |
|---|---|---|
| Platform fee | 5% of the amount collected | on successfully collected payments |
| Payment processing | 3% of each payment + $0.20 | per transaction, in the project currency |
| Project misses its goal | no fees | nothing is charged, including processing |
| Pledge manager (after the campaign) | 5% + 3% + $0.20 per payment | no setup or subscription fee |

Since Indiegogo moved to its upgraded platform on October 16, 2025, the fee structure is a flat 5% platform fee plus processing, with no separate tier for small pledges. The $0.20 is charged on every payment, so many small pledges cost more in processing than a few large ones. A $60 pledge costs $2.00 to process and a $5 pledge costs $0.35.

These figures come from Indiegogo's own help article, [Fees](https://help.indiegogo.com/article/596-fees), and its note on [what changed with the platform upgrade](https://help.indiegogo.com/article/645-what-changed-with-the-platform-upgrade). Indiegogo does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It treats every backer in a group as pledging the same amount, counts one payment per backer, counts the shipping backers pay as part of their pledge, and applies the fulfillment cost only to backers at the main pledge. Installment plans, failed payments, refunds, currency conversion, sales tax and VAT handling, and optional tips (which now go to the creator) are not included. Your payout summary on Indiegogo is the final word.

## How the numbers are worked out

```
total raised       = backers x pledge, for each group
platform fee       = 5% x total raised
processing fee     = per payment: 3% + $0.20
you keep           = total raised - platform fee - processing fees   (goal missed: $0, no fees)
after fulfillment  = you keep - main-level backers x cost per reward
```

Indiegogo's own example is $10,000 raised from 100 payments: a $500 fee plus $320 in processing leaves a $9,180 payout, and the calculator gives the same answer. 200 backers at $60 raise $12,000.00, the platform fee is $600.00, processing is $400.00, and you keep $11,000.00. Add 50 backers pledging $25 and the total is $13,250.00: fees come to $1,110.00 ($662.50 to Indiegogo and $447.50 in processing) and you keep $12,140.00. If each $60 reward costs you $15.00 to make and ship, $9,140.00 is left after fulfillment. A single $25 pledge pays $2.20 in fees and leaves $22.80, a $5 pledge pays $0.60 and leaves $4.40, and a $100 pledge pays $8.20 and leaves $91.80. Raise $100,000 from 1,000 backers at $100 and you keep $91,800.00.

## FAQ

### How much does Indiegogo take from a campaign?

A 5% platform fee on the amount collected plus payment processing of 3% of each payment and $0.20 per payment. For 200 backers at $60, that is $600.00 plus $400.00, so you keep $11,000.00 of $12,000.00.

### Does Indiegogo charge fees if my project doesn't reach its goal?

No. Indiegogo says that if your project doesn't reach its goal, you won't pay anything, including payment processing fees.

### Is there a cheaper rate for small pledges on Indiegogo?

No. Every payment pays 3% plus $0.20, so a $5 pledge pays $0.35 in processing and $0.60 in total fees, which is 12% of the pledge.

### What percentage of my pledges do I keep on Indiegogo?

About 91% to 92% with pledges of $25 or more: you keep 91.2% of a $25 pledge, 91.7% of a $60 pledge and 91.8% of a $100 pledge, before paying for rewards.

### How many backers do I need to keep a set amount on Indiegogo?

Divide the amount you want to keep by what each pledge leaves after fees, which is $55.00 for a $60 pledge, then round up and make sure the total still meets your goal. The calculator above finds the exact number: to keep $20,000 with $60 pledges plus 50 pledges of $25 and a $10,000 goal, you need 343 backers at $60, raising $21,830.00 and keeping $20,005.00.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Indiegogo take from a campaign?", "acceptedAnswer": {"@type": "Answer", "text": "A 5% platform fee on the amount collected plus payment processing of 3% of each payment and $0.20 per payment. For 200 backers at $60, that is $600.00 plus $400.00, so you keep $11,000.00 of $12,000.00."}},
{"@type": "Question", "name": "Does Indiegogo charge fees if my project doesn't reach its goal?", "acceptedAnswer": {"@type": "Answer", "text": "No. Indiegogo says that if your project doesn't reach its goal, you won't pay anything, including payment processing fees."}},
{"@type": "Question", "name": "Is there a cheaper rate for small pledges on Indiegogo?", "acceptedAnswer": {"@type": "Answer", "text": "No. Every payment pays 3% plus $0.20, so a $5 pledge pays $0.35 in processing and $0.60 in total fees, which is 12% of the pledge."}},
{"@type": "Question", "name": "What percentage of my pledges do I keep on Indiegogo?", "acceptedAnswer": {"@type": "Answer", "text": "About 91% to 92% with pledges of $25 or more: you keep 91.2% of a $25 pledge, 91.7% of a $60 pledge and 91.8% of a $100 pledge, before paying for rewards."}},
{"@type": "Question", "name": "How many backers do I need to keep a set amount on Indiegogo?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want to keep by what each pledge leaves after fees, which is $55.00 for a $60 pledge, then round up and make sure the total still meets your goal. The calculator above finds the exact number: to keep $20,000 with $60 pledges plus 50 pledges of $25 and a $10,000 goal, you need 343 backers at $60, raising $21,830.00 and keeping $20,005.00."}}
]}
</script>

## Related tools and guides

- [Kickstarter fee calculator (2026)](kickstarter-fee-calculator): Kickstarter's 5% fee plus 3% + $0.30 per pledge, charged only if the project is funded
- [GoFundMe fee calculator (2026)](gofundme-fee-calculator): no platform fee, just 2.9% + $0.30 per donation (2.2% + $0.30 for certified charities)
- [Patreon fee calculator (2026)](patreon-fee-calculator): Patreon's platform fee plus processing on ongoing memberships
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your campaign

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Indiegogo. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
