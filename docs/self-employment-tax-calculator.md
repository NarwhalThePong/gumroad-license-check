---
layout: page
title: "Self-employment tax calculator 2026: Social Security, Medicare and the 0.9% surtax"
description: "Free 2026 self-employment tax calculator for freelancers and sole proprietors. Enter your Schedule C net profit, any W-2 wages and your filing status to see Social Security tax up to the $184,500 wage base, Medicare tax, the 0.9% Additional Medicare Tax, the deductible half and the quarterly share."
---

If you freelance or run a sole proprietorship, you pay **self-employment tax** on your profit: 12.4% for Social Security and 2.9% for Medicare, the employee and employer halves that a job would split with you. This calculator follows Schedule SE and Form 8959 for tax year 2026. It shows each part of the tax, how a W-2 job uses up part of the $184,500 Social Security wage base, the 0.9% Additional Medicare Tax for high earners, the half you can deduct, and how much of each quarterly estimated payment goes to self-employment tax. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Planning the whole tax year?** The [Freelancer Quarterly Tax Planner 2026 (Excel + Google Sheets)](https://payhip.com/b/UspdI) ($9) logs each payment and expense, works out how much of every dollar to set aside, the safe-harbor and full quarterly payments, and tracks what you've paid against the 2026 due dates. *Our own paid product; not tax advice.*

<div id="se" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <table><tbody>
    <tr><td>2026 net profit from self-employment (Schedule C line 31, or your share from Schedule K-1)</td><td><input id="se-netProfit" type="number" step="100" value="80000"></td></tr>
    <tr><td>Your W-2 wages from a job this year (Social Security wages, box 3; leave 0 if none)</td><td><input id="se-w2Wages" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>Filing status</td><td><select id="se-status"><option value="single">Single</option><option value="mfj">Married filing jointly</option><option value="mfs">Married filing separately</option><option value="hoh">Head of household</option><option value="qss">Qualifying surviving spouse</option></select></td></tr>
    <tr><td>Your spouse's W-2 wages (Medicare wages, box 5; married filing jointly only)</td><td><input id="se-spouseW2" type="number" min="0" step="100" value="0"></td></tr>
  </tbody></table>
  <div id="se-out" aria-live="polite"></div>
</div>

<script>
// 2026 self-employment tax (Schedule SE) + Additional Medicare Tax (Form 8959), one self-employed person
var SETAX = (function () {
  var L = { year: 2026, ssBase: 184500, ssRate: 0.124, medRate: 0.029, nef: 0.9235, minSE: 400, addRate: 0.009,
    addThr: { single: 200000, hoh: 200000, qss: 200000, mfj: 250000, mfs: 125000 } };
  function r2(x) { return Math.round(x * 100) / 100; }
  function num(v, name, allowNeg) {
    var n = (v === "" || v == null) ? 0 : Number(v);
    if (!isFinite(n)) throw new Error(name + " must be a number");
    if (!allowNeg && n < 0) throw new Error(name + " can't be negative");
    return n;
  }
  function compute(o) {
    o = o || {};
    var profit = Math.max(0, num(o.netProfit, "Net profit", true));
    var w2 = num(o.w2Wages, "W-2 wages");
    var st = o.status || "single";
    if (!L.addThr.hasOwnProperty(st)) throw new Error("Unknown filing status");
    var spouse = st === "mfj" ? num(o.spouseW2, "Spouse's W-2 wages") : 0;
    var ne = profit * L.nef, below = ne < L.minSE;
    if (below) ne = 0;
    var ssRoom = Math.max(0, L.ssBase - w2), ssEarn = Math.min(ne, ssRoom);
    var ss = ssEarn * L.ssRate, med = ne * L.medRate, se = ss + med, half = se / 2;
    var wages = w2 + spouse, thr = L.addThr[st], thrLeft = Math.max(0, thr - wages);
    var addW = L.addRate * Math.max(0, wages - thr), addS = L.addRate * Math.max(0, ne - thrLeft);
    return {
      year: L.year, netProfit: r2(profit), netEarnings: r2(ne), belowMinimum: below && profit > 0,
      ssRoom: r2(ssRoom), ssEarnings: r2(ssEarn), socialSecurity: r2(ss), medicare: r2(med), seTax: r2(se),
      deductibleHalf: r2(half), threshold: thr, thresholdLeft: r2(thrLeft),
      addMedicareSE: r2(addS), addMedicareWages: r2(addW), addMedicare: r2(addS + addW),
      totalSE: r2(se + addS), quarterly: r2(se / 4), quarterlyWithAdd: r2((se + addS) / 4),
      effectiveRate: profit > 0 ? r2((se + addS) / profit * 100) : 0, limits: L
    };
  }
  return { compute: compute, LIMITS: L };
})();

(function () {
  function $(id) { return document.getElementById(id); }
  function money(x) { return "$" + Number(x).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); }
  var IDS = ["netProfit", "w2Wages", "status", "spouseW2"];
  function run() {
    var h = "";
    try {
      var o = {}; IDS.forEach(function (k) { o[k] = $("se-" + k).value; });
      var r = SETAX.compute(o);
      if (r.netEarnings === 0) {
        h += '<p style="font-size:1.15em"><strong>No self-employment tax.</strong> ' + (r.belowMinimum ? "92.35% of your profit is under $400, so you don't owe self-employment tax or file Schedule SE for it." : "There is no self-employment tax on a zero profit or a loss.") + "</p>";
      } else {
        h += '<p style="font-size:1.15em"><strong>2026 self-employment tax: ' + money(r.seTax) + "</strong>" + (r.addMedicareSE > 0 ? " plus " + money(r.addMedicareSE) + " Additional Medicare Tax on your self-employment income" : "") + " (" + r.effectiveRate + "% of your profit).</p>";
      }
      h += "<table><tbody>";
      h += "<tr><td>Net earnings from self-employment (92.35% of profit)</td><td>" + money(r.netEarnings) + "</td></tr>";
      h += "<tr><td>Social Security part: 12.4% of " + money(r.ssEarnings) + (r.ssEarnings < r.netEarnings ? " (wage base left after W-2 wages: " + money(r.ssRoom) + ")" : "") + "</td><td>" + money(r.socialSecurity) + "</td></tr>";
      h += "<tr><td>Medicare part: 2.9% of all net earnings</td><td>" + money(r.medicare) + "</td></tr>";
      h += "<tr><td><strong>Self-employment tax (Schedule SE)</strong></td><td><strong>" + money(r.seTax) + "</strong></td></tr>";
      h += "<tr><td>Additional Medicare Tax 0.9% on self-employment income over " + money(r.thresholdLeft) + " (Form 8959 Part II)</td><td>" + money(r.addMedicareSE) + "</td></tr>";
      if (r.addMedicareWages > 0) h += "<tr><td>Additional Medicare Tax on W-2 wages over " + money(r.threshold) + " (Form 8959 Part I; your employer may already withhold some)</td><td>" + money(r.addMedicareWages) + "</td></tr>";
      h += "<tr><td>Deductible half of self-employment tax (Schedule 1, lowers income tax only)</td><td>" + money(r.deductibleHalf) + "</td></tr>";
      h += "<tr><td>Self-employment tax share of each quarterly estimated payment (÷ 4)</td><td>" + money(r.quarterly) + (r.addMedicareSE > 0 ? "<br><small>" + money(r.quarterlyWithAdd) + " with the Additional Medicare Tax</small>" : "") + "</td></tr>";
      h += "</tbody></table>";
      h += "<p><small>Income tax comes on top of this. The <a href=\"freelance-quarterly-estimated-tax-calculator\">quarterly estimated tax calculator</a> adds it and works out your four payments.</small></p>";
    } catch (e) { h = '<p style="color:#b00">' + esc(e.message) + "</p>"; }
    $("se-out").innerHTML = h;
  }
  IDS.forEach(function (k) { var el = $("se-" + k); el.addEventListener("change", run); el.addEventListener("input", run); });
  run();
})();
</script>

## How the math works

```
net SE earnings      = net profit x 92.35%        (no SE tax if this is under $400)
Social Security part = 12.4% x the smaller of net SE earnings and ($184,500 - your W-2 wages)
Medicare part        = 2.9% x net SE earnings     (no cap)
SE tax               = Social Security part + Medicare part
Additional Medicare  = 0.9% x net SE earnings over (threshold - W-2 Medicare wages)
                       threshold: $200,000 single, head of household, surviving spouse
                                  $250,000 married filing jointly (both spouses' wages count)
                                  $125,000 married filing separately
deductible half      = SE tax / 2                 (the 0.9% is not part of it)
quarterly share      = SE tax / 4
```

Example with the default inputs: $80,000 of profit gives $73,880 of net SE earnings. Social Security is 12.4% of that, $9,161.12, and Medicare is 2.9%, $2,142.52, so self-employment tax is **$11,303.64** (about 14.1% of profit). Half of it, $5,651.82, comes off your income for income tax, and $2,825.91 of each quarterly payment covers it.

## The rules this follows

- **Why 92.35%.** You pay the employer half of Social Security and Medicare yourself, so the law lets you first take 7.65% (the employer share) off your profit. Schedule SE line 4a multiplies your profit by 92.35%, and if the result is under $400 you don't owe self-employment tax. That means a profit of $433 or less owes none.
- **The 2026 Social Security wage base is $184,500.** Only the first $184,500 of combined wages and self-employment earnings pays the 12.4% Social Security part. Wages from a job count first, so a W-2 job leaves less room: with $120,000 of Social Security wages, only $64,500 of self-employment earnings pays the 12.4%. Medicare has no cap. A spouse's wages never reduce your wage base.
- **Additional Medicare Tax.** An extra 0.9% applies to wages and self-employment income over $200,000 ($250,000 married filing jointly, $125,000 married filing separately). On Form 8959, your wages use up the threshold first, so self-employment income pays the 0.9% on whatever is over what's left. On a joint return both spouses' wages and self-employment income count. A self-employment loss doesn't lower your wages for this test.
- **The deduction.** You deduct half of your self-employment tax on Schedule 1. It lowers your income tax, not your self-employment tax, and the 0.9% Additional Medicare Tax isn't included in it.
- **Paying it.** Self-employment tax is paid through your quarterly estimated payments along with income tax. The quarterly share shown is a simple quarter of the year's self-employment tax.
- **What this leaves out.** The farm and nonfarm optional methods, church employee income, Conservation Reserve Program payments, unreported tips (Form 4137) and Form 8919 wages, and the case where both spouses are self-employed (each figures their own Schedule SE). If you're an S corporation owner, your salary pays payroll tax instead.

Sources: [SSA contribution and benefit base table](https://www.ssa.gov/oact/cola/cbb.html) (2026: $184,500), [IRS Topic 554, Self-employment tax](https://www.irs.gov/taxtopics/tc554), [IRS self-employment tax page](https://www.irs.gov/businesses/small-businesses-self-employed/self-employment-tax-social-security-and-medicare-taxes), [Schedule SE (Form 1040)](https://www.irs.gov/forms-pubs/about-schedule-se-form-1040), [IRS Topic 560, Additional Medicare Tax](https://www.irs.gov/taxtopics/tc560) and [Form 8959](https://www.irs.gov/forms-pubs/about-form-8959). Figures and rules checked on October 27, 2026. This is general information, not tax advice.

## FAQ

### Is self-employment tax the same as income tax?

No. Self-employment tax is only Social Security and Medicare. You pay federal income tax on the same profit on top of it, after the half-of-SE-tax deduction and your standard deduction.

### I have a W-2 job and a side business. Do I still pay self-employment tax?

Yes, on your side profit. Your job's wages only matter for the 12.4% Social Security part: once wages plus self-employment earnings pass $184,500 in 2026, the rest pays just the 2.9% Medicare part.

### Does a retirement contribution lower self-employment tax?

No. For a sole proprietor, SEP IRA and Solo 401(k) contributions lower income tax, not self-employment tax. Business expenses on Schedule C do lower it, because they lower your profit.

## Tools from us

- [Freelancer Quarterly Tax Planner 2026 (Excel + Google Sheets)](https://payhip.com/b/UspdI): log income and expenses, see the share of every dollar to set aside for self-employment and income tax, and track your quarterly payments against the 2026 due dates. $9.
- [Home Office Deduction Worksheet (Excel + Google Sheets)](https://payhip.com/b/8bG3C): log every bill and get the simplified and regular (Form 8829) deductions side by side. A bigger deduction means a smaller profit and less self-employment tax. $9.
- [Mileage Log 2026 (Excel + Google Sheets)](https://payhip.com/b/TUHGi): log business trips by date at the split-year 2026 IRS rates, with parking, tolls and a year summary. $9.

*Disclosure: all three spreadsheets are our own paid products, and we earn the sale price if you buy one. Not affiliated with the IRS. Not tax advice.*

## Related tools and guides

- [QBI deduction calculator](qbi-deduction-calculator) for the Section 199A 20% Qualified Business Income deduction (Form 8995)
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator) to add income tax and get your four 2026 payments and the safe-harbor minimum
- [SEP IRA vs Solo 401(k) calculator](self-employed-retirement-contribution-calculator) for the most you can contribute and deduct
- [Home office deduction calculator](home-office-deduction-calculator) to compare the simplified and regular home office methods
- [2026 mileage deduction calculator](2026-mileage-deduction-calculator) for car expenses at the split-year IRS rates
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator) to price your work with tax built in

*Disclosure: the calculators on this site are our own. We don't earn anything from the links in this list, and none are affiliate links.* More guides: [Gumroad developer guides](./).
