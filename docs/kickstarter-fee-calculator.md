---
layout: page
title: "Kickstarter fee calculator (2026): what US creators keep after the 5% fee and payment processing"
description: "Free Kickstarter fee calculator for US creators. See the 5% Kickstarter fee, payment processing of 3% + $0.30 per pledge (5% + $0.08 under $10), what you keep from your funding total, net after reward fulfillment and how many backers you need to clear a set amount. No fees if the project isn't funded."
---

Kickstarter only charges fees when a project is **successfully funded**. It then takes a **5% Kickstarter fee on the total raised** and **payment processing of 3% + $0.30 per pledge**, or **5% + $0.08 for pledges under $10**. Raise $12,000 from 200 backers pledging $60 each and you pay $600.00 to Kickstarter plus $420.00 in processing, so you keep $10,980.00, or 91.5% of the total. If the project misses its goal, no one is charged and you pay nothing. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="ks" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Funding goal (USD)<br><input id="ks-goal" type="number" min="0" step="0.01" value="10000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Backers at your main pledge<br><input id="ks-na" type="number" min="0" step="1" value="200" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Main pledge, including any shipping (USD)<br><input id="ks-pa" type="number" min="0" step="0.01" value="60" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Backers pledging under $10 (optional)<br><input id="ks-nb" type="number" min="0" step="1" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Small pledge amount (USD)<br><input id="ks-pb" type="number" min="0" step="0.01" value="5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cost to make and ship each main reward (optional, USD)<br><input id="ks-cost" type="number" min="0" step="0.01" value="15" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="ks-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Your campaign</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Backers</td><td style="text-align:right"><span id="ks-backers">0</span></td></tr>
    <tr><td>Total raised</td><td style="text-align:right"><span id="ks-raised">$0.00</span></td></tr>
    <tr><td>Kickstarter fee (5%)</td><td style="text-align:right"><span id="ks-fee">$0.00</span></td></tr>
    <tr><td>Processing per main pledge</td><td style="text-align:right"><span id="ks-ppa">$0.00</span></td></tr>
    <tr><td>Processing per small pledge</td><td style="text-align:right"><span id="ks-ppb">$0.00</span></td></tr>
    <tr><td>Payment processing in total</td><td style="text-align:right"><span id="ks-proc">$0.00</span></td></tr>
    <tr><td>All fees</td><td style="text-align:right"><span id="ks-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of the total</td><td style="text-align:right"><span id="ks-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="ks-net">$0.00</strong></td></tr>
    <tr><td>Reward fulfillment</td><td style="text-align:right"><span id="ks-ful">$0.00</span></td></tr>
    <tr><td>Left after fulfillment</td><td style="text-align:right"><strong id="ks-profit">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Backers needed to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep after Kickstarter's fees (USD)<br><input id="ks-target" type="number" min="0" step="0.01" value="20000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="ks-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Kickstarter US creator fee math (kickstarter.com/help/fees, "Fees: United States", checked Oct 29, 2026). If the project is successfully funded: Kickstarter fee 5% of total funds raised, plus payment processing 3% + $0.30 per pledge, or 5% + $0.08 per pledge for pledges under $10. If funding is not successful there are no fees (and no money is collected). Fees are rounded to the nearest cent, halves up (Kickstarter does not publish its rounding). */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, KS_BP = 500, PROC_BP = 300, PROC_FIX = 30, MICRO_BP = 500, MICRO_FIX = 8, MICRO_UNDER = 1000;
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(v) { return Math.round(v * 100); }
  function bp(c, b) { return Math.floor((c * b + 5000) / 10000); }
  function procFee(c) { if (c <= 0) return 0; return c < MICRO_UNDER ? bp(c, MICRO_BP) + MICRO_FIX : bp(c, PROC_BP) + PROC_FIX; }
  function partsC(na, pa, nb, pb, goal, cost) {
    var raised = na * pa + nb * pb, funded = raised > 0 && raised >= goal;
    var ks = funded ? bp(raised, KS_BP) : 0, proc = funded ? na * procFee(pa) + nb * procFee(pb) : 0;
    var net = funded ? raised - ks - proc : 0, ful = funded ? na * cost : 0;
    return { raised: raised, funded: funded, ks: ks, proc: proc, fees: ks + proc, net: net, ful: ful, profit: net - ful };
  }
  function calc(na, pa, nb, pb, goal, cost) {
    var a = count(na), b = count(nb), A = cents(amt(pa)), Bc = cents(amt(pb)), G = cents(big(goal)), C = cents(amt(cost));
    var p = partsC(a, A, b, Bc, G, C), d = function (x) { return x / 100; };
    return { backers: a + b, raised: d(p.raised), funded: p.funded, goal: d(G), ks: d(p.ks), proc: d(p.proc), fees: d(p.fees), net: d(p.net), ful: d(p.ful), profit: d(p.profit), effective: p.funded && p.raised > 0 ? p.fees / p.raised : null, perPledgeA: d(procFee(A)), perPledgeB: d(procFee(Bc)) };
  }
  /* fewest main-tier backers at pledge pa (other inputs fixed) so that net after fees >= target and the goal is met */
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
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, KS_BP: KS_BP, PROC_BP: PROC_BP, PROC_FIX: PROC_FIX, MICRO_BP: MICRO_BP, MICRO_FIX: MICRO_FIX, MICRO_UNDER: MICRO_UNDER, num: num, amt: amt, count: count, procFee: procFee, partsC: partsC, calc: calc, backersFor: backersFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.KsFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.KsFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var na = $("ks-na").value, pa = $("ks-pa").value, nb = $("ks-nb").value, pb = $("ks-pb").value, g = $("ks-goal").value, c = $("ks-cost").value, w = [];
    var r = B.calc(na, pa, nb, pb, g, c);
    if (B.amt(pa) >= B.MAX_AMT || B.amt(pb) >= B.MAX_AMT || B.count(na) >= B.MAX_QTY || B.count(nb) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (B.amt(pb) >= 10) w.push("Pledges of $10 or more pay the standard 3% + $0.30, so the small-pledge rate does not apply to that amount.");
    if (r.raised > 0 && !r.funded) w.push("This total is below your goal, so the project is not funded: no backer is charged, no fees apply and you receive nothing.");
    if (r.funded && r.profit < 0) w.push("After reward fulfillment this campaign loses money.");
    $("ks-warn").textContent = w.join(" ");
    set("ks-backers", r.backers.toLocaleString("en-US")); set("ks-raised", money(r.raised)); set("ks-fee", money(r.ks)); set("ks-proc", money(r.proc)); set("ks-fees", money(r.fees)); set("ks-eff", pctS(r.effective)); set("ks-net", money(r.net)); set("ks-ful", money(r.ful)); set("ks-profit", money(r.profit)); set("ks-ppa", money(r.perPledgeA)); set("ks-ppb", money(r.perPledgeB));
    var T = $("ks-target").value, need = B.backersFor(T, pa, nb, pb, g);
    set("ks-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(pa) <= 0 ? "Enter a main pledge amount." : need == null ? "No number of backers reaches that amount." : "You need " + need.backers.toLocaleString("en-US") + " backers at " + money(B.amt(pa)) + " (plus the small pledges above), raising " + money(need.raised) + " and keeping " + money(need.net) + " after fees.");
  }
  ["ks-na", "ks-pa", "ks-nb", "ks-pb", "ks-goal", "ks-cost", "ks-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Kickstarter fees in the US (checked Oct 29, 2026)

| Fee | Rate | When it applies |
|---|---|---|
| Kickstarter fee | 5% of total funds raised | only if the project is successfully funded |
| Payment processing | 3% + $0.30 per pledge | pledges of $10 or more |
| Payment processing (micropledge) | 5% + $0.08 per pledge | pledges under $10 |
| Unfunded project | no fees | backers are never charged |

Kickstarter is all-or-nothing: backers are only charged if the project reaches its goal by the deadline, and only then are the fees collected from the funding total. The processing fee is charged on each pledge separately, so many small pledges cost more in processing than a few large ones. A $60 pledge costs $2.10 to process and a $5 pledge costs $0.33.

These figures come from Kickstarter's own page, [Fees: United States](https://www.kickstarter.com/help/fees). Kickstarter does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It treats every backer in a group as pledging the same amount, counts the shipping backers pay as part of their pledge, and applies the fulfillment cost only to backers at the main pledge, since small pledges usually get no physical reward. Dropped or failed payments, refunds, currency conversion for projects outside the US, sales tax and VAT handling, and the cost of any late pledge or pledge manager tool are not included. Your project's funds summary on Kickstarter is the final word.

## How the numbers are worked out

```
total raised       = backers x pledge, for each group
Kickstarter fee    = 5% x total raised
processing fee     = per pledge: 3% + $0.30, or 5% + $0.08 under $10
you keep           = total raised - Kickstarter fee - processing fees   (unfunded: $0, no fees)
after fulfillment  = you keep - main-tier backers x cost per reward
```

200 backers at $60 raise $12,000.00. The Kickstarter fee is $600.00, processing is $420.00, and you keep $10,980.00. Add 50 backers pledging $5 and the total is $12,250.00: fees come to $1,049.00 ($612.50 to Kickstarter and $436.50 in processing) and you keep $11,201.00. If each $60 reward costs you $15.00 to make and ship, $8,201.00 is left after fulfillment. A single $25 pledge pays $2.30 in fees and leaves $22.70, a $5 pledge pays $0.58 and leaves $4.42, and a $100 pledge pays $8.30 and leaves $91.70. Raise $100,000 from 1,000 backers at $100 and you keep $91,700.00. With a $10,000 goal and only 150 backers at $60, the $9,000 raised falls short, so nothing is charged and nothing is paid out. To keep $20,000 with $60 pledges, 50 small $5 pledges and a $10,000 goal, you need 361 backers at $60, raising $21,910.00 and keeping $20,039.90.

## FAQ

### How much does Kickstarter take in 2026?

For a US project that is successfully funded, Kickstarter takes 5% of the total raised, and payment processing takes another 3% + $0.30 per pledge, or 5% + $0.08 on pledges under $10. On 200 pledges of $60 that's $1,020.00 in total, so you keep $10,980.00 of $12,000.00.

### Does Kickstarter charge fees if the project isn't funded?

No. Kickstarter is all-or-nothing, so if a project misses its goal no backer is charged and there are no fees. You receive nothing, but you owe nothing either.

### What is the Kickstarter micropledge fee?

Pledges under $10 are processed at a discounted 5% + $0.08 per pledge instead of 3% + $0.30. A $5 pledge costs $0.33 to process, plus $0.25 for the 5% Kickstarter fee, so you keep $4.42.

### What percentage of a Kickstarter campaign do you actually keep?

Usually about 91% to 92% with pledges of $25 or more. The 5% Kickstarter fee is fixed, while the $0.30 per pledge weighs more on small pledges: you keep 90.8% of a $25 pledge, 91.5% of a $60 pledge and 91.7% of a $100 pledge, before paying for rewards.

### How many backers do I need to keep a set amount on Kickstarter?

Divide the amount you want to keep by what each pledge leaves after fees, which is $54.90 for a $60 pledge, then round up and make sure the total still meets your goal. The calculator above finds the exact number: to keep $20,000 with $60 pledges plus 50 pledges of $5 and a $10,000 goal, you need 361 backers at $60.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Kickstarter take in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "For a US project that is successfully funded, Kickstarter takes 5% of the total raised, and payment processing takes another 3% + $0.30 per pledge, or 5% + $0.08 on pledges under $10. On 200 pledges of $60 that's $1,020.00 in total, so you keep $10,980.00 of $12,000.00."}},
{"@type": "Question", "name": "Does Kickstarter charge fees if the project isn't funded?", "acceptedAnswer": {"@type": "Answer", "text": "No. Kickstarter is all-or-nothing, so if a project misses its goal no backer is charged and there are no fees. You receive nothing, but you owe nothing either."}},
{"@type": "Question", "name": "What is the Kickstarter micropledge fee?", "acceptedAnswer": {"@type": "Answer", "text": "Pledges under $10 are processed at a discounted 5% + $0.08 per pledge instead of 3% + $0.30. A $5 pledge costs $0.33 to process, plus $0.25 for the 5% Kickstarter fee, so you keep $4.42."}},
{"@type": "Question", "name": "What percentage of a Kickstarter campaign do you actually keep?", "acceptedAnswer": {"@type": "Answer", "text": "Usually about 91% to 92% with pledges of $25 or more. The 5% Kickstarter fee is fixed, while the $0.30 per pledge weighs more on small pledges: you keep 90.8% of a $25 pledge, 91.5% of a $60 pledge and 91.7% of a $100 pledge, before paying for rewards."}},
{"@type": "Question", "name": "How many backers do I need to keep a set amount on Kickstarter?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want to keep by what each pledge leaves after fees, which is $54.90 for a $60 pledge, then round up and make sure the total still meets your goal. The calculator above finds the exact number: to keep $20,000 with $60 pledges plus 50 pledges of $5 and a $10,000 goal, you need 361 backers at $60."}}
]}
</script>

## Related tools and guides

- [Patreon fee calculator (2026)](patreon-fee-calculator): Patreon's platform fee plus processing on ongoing memberships
- [Buy Me a Coffee fee calculator (2026)](buy-me-a-coffee-fee-calculator): the flat 5% platform fee plus Stripe processing on support and memberships
- [Seller fee comparison calculator](seller-fee-comparison-calculator): compare what you keep across marketplaces and payment processors
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your campaign

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Kickstarter. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
