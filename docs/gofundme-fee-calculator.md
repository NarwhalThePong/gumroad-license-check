---
layout: page
title: "GoFundMe fee calculator (2026): what US fundraisers keep after the 2.9% + $0.30 transaction fee"
description: "Free GoFundMe fee calculator for US fundraisers. GoFundMe has no platform fee; each donation pays a transaction fee of 2.9% + $0.30 (2.2% + $0.30 for certified charities). See the fees, what you keep and how many donations you need to keep a set amount."
---

GoFundMe charges **no fee to start or run a fundraiser**. The only fee taken from your donations is a **transaction fee of 2.9% + $0.30 per donation** for personal fundraisers in the US, or **2.2% + $0.30** for certified charities. Raise $5,000 from 100 donations of $50 and the transaction fees come to $175.00, so you keep $4,825.00, or 96.5% of the total. Enter your numbers below to see what you keep. Everything runs in your browser and nothing is sent anywhere.

<div id="gfm" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <p style="margin:0 0 8px"><label>Who is the fundraiser for?<br><select id="gfm-kind"><option value="personal" selected>An individual, family, cause or business (2.9% + $0.30)</option><option value="charity">A certified charity (2.2% + $0.30)</option></select></label></p>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Number of donations<br><input id="gfm-na" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Typical donation (USD)<br><input id="gfm-pa" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Donations in a second group (optional)<br><input id="gfm-nb" type="number" min="0" step="1" value="40" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Second group donation (USD)<br><input id="gfm-pb" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="gfm-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Your fundraiser</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Donations</td><td style="text-align:right"><span id="gfm-count">0</span></td></tr>
    <tr><td>Total raised</td><td style="text-align:right"><span id="gfm-raised">$0.00</span></td></tr>
    <tr><td>Fee per typical donation</td><td style="text-align:right"><span id="gfm-pera">$0.00</span></td></tr>
    <tr><td>Fee per second-group donation</td><td style="text-align:right"><span id="gfm-perb">$0.00</span></td></tr>
    <tr><td>Transaction fees in total</td><td style="text-align:right"><span id="gfm-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of the total</td><td style="text-align:right"><span id="gfm-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="gfm-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Donations needed to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep after GoFundMe's fees (USD)<br><input id="gfm-target" type="number" min="0" step="0.01" value="10000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="gfm-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* GoFundMe fee math for US fundraisers (checked 2026-10-29 from gofundme.com/pricing). All math in integer cents; GoFundMe does not publish its rounding, so each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, FIX = 30, RATES = { personal: 290, charity: 220 };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(v) { return Math.round(v * 100); }
  function rate(kind) { return RATES[kind] || RATES.personal; }
  function fee(c, kind) { return c <= 0 ? 0 : Math.floor((c * rate(kind) + 5000) / 10000) + FIX; }
  function partsC(na, a, nb, b, kind) {
    var raised = na * a + nb * b, fees = na * fee(a, kind) + nb * fee(b, kind);
    return { raised: raised, fees: fees, net: raised - fees };
  }
  function calc(na, pa, nb, pb, kind) {
    var a = count(na), b = count(nb), A = cents(amt(pa)), Bc = cents(amt(pb)), p = partsC(a, A, b, Bc, kind), d = function (x) { return x / 100; };
    return { donations: a + b, raised: d(p.raised), fees: d(p.fees), net: d(p.net), effective: p.raised > 0 ? p.fees / p.raised : null, perA: d(fee(A, kind)), perB: d(fee(Bc, kind)), keepA: d(A > 0 ? A - fee(A, kind) : 0) };
  }
  /* fewest donations of size pa (second group fixed) so that the amount kept >= target */
  function donationsFor(target, pa, nb, pb, kind) {
    var T = cents(big(target)), A = cents(amt(pa)), b = count(nb), Bc = cents(amt(pb));
    if (T <= 0 || A <= 0 || A - fee(A, kind) <= 0) return null;
    var ok = function (n) { return partsC(n, A, b, Bc, kind).net >= T; };
    if (!ok(MAX_QTY)) return null;
    var lo = 0, hi = MAX_QTY;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (ok(m)) hi = m; else lo = m + 1; }
    var p = partsC(lo, A, b, Bc, kind);
    return { donations: lo, raised: p.raised / 100, net: p.net / 100 };
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, FIX: FIX, RATES: RATES, num: num, amt: amt, count: count, fee: fee, partsC: partsC, calc: calc, donationsFor: donationsFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.GfmFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.GfmFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var k = $("gfm-kind").value, na = $("gfm-na").value, pa = $("gfm-pa").value, nb = $("gfm-nb").value, pb = $("gfm-pb").value, w = [];
    var r = B.calc(na, pa, nb, pb, k);
    if (B.amt(pa) >= B.MAX_AMT || B.amt(pb) >= B.MAX_AMT || B.count(na) >= B.MAX_QTY || B.count(nb) >= B.MAX_QTY) w.push("Large numbers are capped.");
    $("gfm-warn").textContent = w.join(" ");
    set("gfm-count", r.donations.toLocaleString("en-US")); set("gfm-raised", money(r.raised)); set("gfm-pera", money(r.perA)); set("gfm-perb", money(r.perB)); set("gfm-fees", money(r.fees)); set("gfm-eff", pctS(r.effective)); set("gfm-net", money(r.net));
    var T = $("gfm-target").value, need = B.donationsFor(T, pa, nb, pb, k);
    set("gfm-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(pa) <= 0 ? "Enter a main donation amount." : need == null ? "No number of donations reaches that amount." : "You need " + need.donations.toLocaleString("en-US") + " donations of " + money(B.amt(pa)) + " (plus the second group above), raising " + money(need.raised) + " and keeping " + money(need.net) + " after fees.");
  }
  ["gfm-kind", "gfm-na", "gfm-pa", "gfm-nb", "gfm-pb", "gfm-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## GoFundMe fees in the US (checked Oct 29, 2026)

| Fee | Rate | Who pays |
|---|---|---|
| Starting or running a fundraiser | $0.00 | nobody |
| Transaction fee, personal fundraisers | 2.9% + $0.30 per donation | deducted from each donation |
| Transaction fee, certified charities | 2.2% + $0.30 per donation | deducted from each donation |
| Tip to GoFundMe | optional, chosen by the donor | the donor, on top of the donation |
| Recurring donations | 5% per donation | the donor, on top of the donation |

The $0.30 is charged on every donation, so many small donations cost more than a few large ones. A $50 donation pays $1.75 and a $10 donation pays $0.59, which is 5.9% of it. Tips are paid by donors on top of what they give, so they don't reduce what you receive. GoFundMe says international transaction and currency conversion fees may also apply depending on how a donor pays.

These figures come from GoFundMe's own [pricing page](https://www.gofundme.com/pricing). GoFundMe does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It treats every donation in a group as the same size and leaves out refunds, disputes, currency conversion and GoFundMe Pro, which has custom pricing for nonprofits. Your fundraiser dashboard on GoFundMe is the final word.

## How the numbers are worked out

```
total raised     = donations x amount, for each group
transaction fee  = per donation: 2.9% + $0.30   (certified charity: 2.2% + $0.30)
you keep         = total raised - transaction fees
```

100 donations of $50 raise $5,000.00, the fees are $175.00 and you keep $4,825.00. For a certified charity the same donations pay $140.00 and the charity keeps $4,860.00. Add 40 donations of $20 and the total is $5,800.00: fees come to $210.20 and you keep $5,589.80. A single $25 donation pays $1.03 and leaves $23.97, a $100 donation pays $3.20 and leaves $96.80, and a $5 donation pays $0.45 and leaves $4.55. Raise $50,000 from 500 donations of $100 and you keep $48,400.00.

## FAQ

### How much does GoFundMe take from donations?

For a personal fundraiser in the US, a transaction fee of 2.9% plus $0.30 on each donation, and nothing else. For 100 donations of $50 that is $175.00, so you keep $4,825.00 of $5,000.00.

### Does GoFundMe charge a fee to start a fundraiser?

No. GoFundMe says there's no fee to start or manage a fundraiser; the transaction fee on each donation is the only fee deducted.

### Do I lose money when donors tip GoFundMe?

No. A tip to GoFundMe is optional and paid by the donor on top of the donation, so it doesn't come out of what you receive.

### What percentage of donations do I keep on GoFundMe?

About 96% to 97% for donations of $25 or more: you keep 95.9% of a $25 donation, 96.5% of a $50 donation and 96.8% of a $100 donation. Certified charities keep a little more because their rate is 2.2% + $0.30.

### How many donations do I need to keep a set amount on GoFundMe?

Divide the amount you want to keep by what each donation leaves after fees, which is $48.25 for a $50 donation, then round up. The calculator above finds the exact number: to keep $10,000 with $50 donations plus 40 donations of $20, you need 192 donations of $50, raising $10,400.00 and keeping $10,028.80.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does GoFundMe take from donations?", "acceptedAnswer": {"@type": "Answer", "text": "For a personal fundraiser in the US, a transaction fee of 2.9% plus $0.30 on each donation, and nothing else. For 100 donations of $50 that is $175.00, so you keep $4,825.00 of $5,000.00."}},
{"@type": "Question", "name": "Does GoFundMe charge a fee to start a fundraiser?", "acceptedAnswer": {"@type": "Answer", "text": "No. GoFundMe says there's no fee to start or manage a fundraiser; the transaction fee on each donation is the only fee deducted."}},
{"@type": "Question", "name": "Do I lose money when donors tip GoFundMe?", "acceptedAnswer": {"@type": "Answer", "text": "No. A tip to GoFundMe is optional and paid by the donor on top of the donation, so it doesn't come out of what you receive."}},
{"@type": "Question", "name": "What percentage of donations do I keep on GoFundMe?", "acceptedAnswer": {"@type": "Answer", "text": "About 96% to 97% for donations of $25 or more: you keep 95.9% of a $25 donation, 96.5% of a $50 donation and 96.8% of a $100 donation. Certified charities keep a little more because their rate is 2.2% + $0.30."}},
{"@type": "Question", "name": "How many donations do I need to keep a set amount on GoFundMe?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want to keep by what each donation leaves after fees, which is $48.25 for a $50 donation, then round up. The calculator above finds the exact number: to keep $10,000 with $50 donations plus 40 donations of $20, you need 192 donations of $50, raising $10,400.00 and keeping $10,028.80."}}
]}
</script>

## Related tools and guides

- [Indiegogo fee calculator (2026)](indiegogo-fee-calculator): Indiegogo's 5% platform fee plus 3% + $0.20 per payment, with no fees if the goal isn't reached
- [Kickstarter fee calculator (2026)](kickstarter-fee-calculator): Kickstarter's 5% fee plus 3% + $0.30 per pledge, charged only if the project is funded
- [Buy Me a Coffee fee calculator (2026)](buy-me-a-coffee-fee-calculator): the flat 5% platform fee plus Stripe processing for tips and memberships
- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee and whether Ko-fi Gold pays off

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with GoFundMe. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
