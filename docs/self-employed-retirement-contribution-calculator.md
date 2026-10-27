---
layout: page
title: "SEP IRA vs Solo 401(k) calculator 2026: max contribution for the self-employed"
description: "Free 2026 SEP IRA vs Solo 401(k) contribution calculator for freelancers and sole proprietors. Enter your Schedule C net profit to see your self-employment tax, the 20% employer limit, the $24,500 employee deferral, age 50+ and 60-63 catch-ups, the $72,000 cap and the income tax you save."
---

If you work for yourself, you can put money for retirement into a **SEP IRA** or a **Solo 401(k)** and deduct it. Both let you contribute as the "employer", up to 20% of your net self-employment earnings. A Solo 401(k) also lets you contribute as the "employee", up to $24,500 for 2026 plus catch-up if you're 50 or older, so it usually allows much more at the same income. This calculator follows the IRS Publication 560 worksheet for a sole proprietor or single-member LLC and shows the most each plan allows. Everything runs in your browser and nothing is sent anywhere.

<div id="rc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <table><tbody>
    <tr><td>2026 net profit from self-employment (Schedule C line 31, or your share from Schedule K-1)</td><td><input id="rc-netProfit" type="number" min="0" step="100" value="100000"></td></tr>
    <tr><td>Your age at the end of 2026</td><td><select id="rc-age"><option value="under50">Under 50</option><option value="50plus">50 to 59, or 64 and older</option><option value="60to63">60, 61, 62 or 63</option></select></td></tr>
    <tr><td>W-2 wages from a job this year (Social Security wages, box 3)</td><td><input id="rc-w2Wages" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>401(k) or 403(b) deferrals you already make at a job this year</td><td><input id="rc-otherDeferrals" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>Your federal income tax bracket (%)</td><td><select id="rc-bracket"><option>10</option><option>12</option><option selected>22</option><option>24</option><option>32</option><option>35</option><option>37</option></select></td></tr>
    <tr><td>Plan's employer contribution rate (%, 25 is the most allowed)</td><td><input id="rc-planRate" type="number" min="0" max="25" step="1" value="25"></td></tr>
  </tbody></table>
  <div id="rc-out" aria-live="polite"></div>
</div>

<script>
// SEP IRA vs Solo 401(k) max contribution, 2026, sole proprietor / single-member LLC (Pub. 560 rate worksheet)
var SEP = (function () {
  var L = { year: 2026, ssBase: 184500, ssRate: 0.124, medRate: 0.029, nef: 0.9235, minSE: 400,
    total415: 72000, deferral: 24500, compCap: 360000, catch50: 8000, catch6063: 11250 };
  function r2(x) { return Math.round(x * 100) / 100; }
  function num(v, name) { var n = Number(v); if (!isFinite(n) || n < 0) throw new Error(name + " must be a number 0 or more"); return n; }
  function seTax(profit, w2ss) {
    var base = profit * L.nef;
    if (base < L.minSE) return { base: r2(base), ss: 0, medicare: 0, total: 0, half: 0 };
    var ss = L.ssRate * Math.min(base, Math.max(0, L.ssBase - w2ss)), med = L.medRate * base;
    var t = ss + med;
    return { base: r2(base), ss: r2(ss), medicare: r2(med), total: r2(t), half: r2(t / 2) };
  }
  function compute(o) {
    o = o || {};
    var profit = num(o.netProfit == null ? 0 : o.netProfit, "Net profit");
    var w2ss = num(o.w2Wages || 0, "W-2 wages");
    var otherDef = num(o.otherDeferrals || 0, "Other 401(k) deferrals");
    var ratePct = num(o.planRate == null ? 25 : o.planRate, "Plan rate");
    if (ratePct > 25) throw new Error("Plan rate can't be more than 25%");
    var bracket = num(o.bracket == null ? 22 : o.bracket, "Tax bracket");
    var age = o.age || "under50";
    var se = seTax(profit, w2ss);
    var earned = Math.max(0, profit - se.half);
    var r = ratePct / 100, rr = r / (1 + r);
    var employer = Math.min(earned * rr, L.compCap * r, L.total415);
    var sep = r2(employer);
    var defRoom = Math.max(0, L.deferral - otherDef);
    var deferral = Math.min(defRoom, Math.max(0, earned - employer), Math.max(0, L.total415 - employer));
    var catchLim = age === "60to63" ? L.catch6063 : age === "50plus" ? L.catch50 : 0;
    var catchup = Math.min(catchLim, Math.max(0, earned - employer - deferral));
    var solo = r2(employer + deferral + catchup);
    var better = solo > sep ? "solo401k" : "equal";
    return {
      year: L.year, netProfit: profit, seTax: se, earnedIncome: r2(earned), reducedRatePct: r2(rr * 100),
      sep: { employer: sep, total: sep },
      solo401k: { employer: r2(employer), deferral: r2(deferral), catchup: r2(catchup), total: solo },
      better: better, difference: r2(solo - sep),
      taxSaved: { sep: r2(sep * bracket / 100), solo401k: r2(solo * bracket / 100) }, limits: L
    };
  }
  return { compute: compute, seTax: seTax, LIMITS: L };
})();

(function () {
  function $(id) { return document.getElementById(id); }
  function money(x) { return "$" + Number(x).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); }
  var IDS = ["netProfit", "age", "w2Wages", "otherDeferrals", "bracket", "planRate"];
  function run() {
    var h = "";
    try {
      var o = {}; IDS.forEach(function (k) { var v = $("rc-" + k).value; o[k] = k === "age" ? v : (v === "" ? 0 : Number(v)); });
      var r = SEP.compute(o), s = r.solo401k;
      h += '<p style="font-size:1.15em"><strong>' + (r.better === "solo401k" ? "Solo 401(k) allows " + money(r.difference) + " more" : "Both plans allow the same amount") + "</strong>: Solo 401(k) up to " + money(s.total) + ", SEP IRA up to " + money(r.sep.total) + ".</p>";
      h += "<table><thead><tr><th></th><th>SEP IRA</th><th>Solo 401(k)</th></tr></thead><tbody>";
      h += "<tr><td>Employer contribution (" + r.reducedRatePct + "% of earned income)</td><td>" + money(r.sep.employer) + "</td><td>" + money(s.employer) + "</td></tr>";
      h += "<tr><td>Employee deferral</td><td>Not allowed</td><td>" + money(s.deferral) + "</td></tr>";
      h += "<tr><td>Catch-up (age 50+)</td><td>Not allowed</td><td>" + money(s.catchup) + "</td></tr>";
      h += "<tr><td><strong>Most you can contribute for 2026</strong></td><td><strong>" + money(r.sep.total) + "</strong></td><td><strong>" + money(s.total) + "</strong></td></tr>";
      h += "<tr><td>Federal income tax saved at your bracket (estimate)</td><td>" + money(r.taxSaved.sep) + "</td><td>" + money(r.taxSaved.solo401k) + "</td></tr>";
      h += "</tbody></table>";
      h += "<p><small>How we got there: net earnings from self-employment " + money(r.seTax.base) + " (92.35% of profit), self-employment tax " + money(r.seTax.total) + ", half of it deductible (" + money(r.seTax.half) + "), so earned income for the plan is " + money(r.earnedIncome) + ". Contributions lower income tax but not self-employment tax.</small></p>";
    } catch (e) { h = '<p style="color:#b00">' + esc(e.message) + "</p>"; }
    $("rc-out").innerHTML = h;
  }
  IDS.forEach(function (k) { var el = $("rc-" + k); el.addEventListener("change", run); el.addEventListener("input", run); });
  run();
})();
</script>

## How the math works

```
net SE earnings   = net profit x 92.35%
SE tax            = 12.4% x net SE earnings (up to $184,500 minus W-2 wages) + 2.9% x net SE earnings
earned income     = net profit - half of SE tax
employer limit    = earned income x 20%   (25% plan rate / 1.25), at most 25% x $360,000 and $72,000
SEP IRA max       = employer limit
Solo 401(k) max   = employer limit + employee deferral (up to $24,500, less deferrals at other jobs)
                    + catch-up ($8,000 at 50+, $11,250 at 60-63), never more than earned income
                    employer + deferral at most $72,000; catch-up goes on top
```

Example with the default inputs: $100,000 of profit gives $92,350 of net SE earnings and $14,129.55 of self-employment tax. Half of that ($7,064.78) comes off, so earned income is $92,935.22. The SEP IRA limit is 20% of that, **$18,587.04**. A Solo 401(k) allows the same $18,587.04 plus a $24,500 employee deferral, **$43,087.04** in total, or $51,087.04 at age 50 to 59.

## The rules this follows

- **Why 20% and not 25%.** The plan rate is 25% of compensation, but for a self-employed person compensation is figured after subtracting the contribution itself, so the effective rate on earned income is 25% / 1.25 = 20% (Pub. 560 rate table). A plan with a lower rate gets a matching lower reduced rate.
- **2026 limits.** Total contributions (employer plus employee, not counting catch-up) are capped at $72,000. Employee deferrals are capped at $24,500, shared across every 401(k) and 403(b) you contribute to that year, including at a day job. Compensation above $360,000 doesn't count. Catch-up is $8,000 at 50 or older, or $11,250 if you turn 60, 61, 62 or 63 in 2026. SEP IRAs have no employee deferral and no catch-up.
- **Who this fits.** A Solo 401(k) is for a business with no employees other than you and your spouse. If you have eligible employees, a SEP IRA must give them the same percentage you give yourself, and a regular 401(k) has testing rules this calculator doesn't cover. S corporation owners figure contributions on their W-2 salary instead of net profit.
- **Deadlines.** SEP IRA contributions for 2026 can be made, and the plan can even be opened, until your tax filing deadline including extensions (April 15, 2027, or October 15, 2027 with an extension). For a Solo 401(k), employer contributions can also be made up to the deadline with extensions. A sole proprietor who opens a new Solo 401(k) after the year ends can still make first-year employee deferrals up to the original due date of the return, without extensions.
- **Traditional or Roth.** The tax saving shown is for pre-tax (traditional) contributions. Roth contributions to a Solo 401(k) or SEP IRA count toward the same limits but give no deduction now.

Sources: [IRS Publication 560, Retirement Plans for Small Business](https://www.irs.gov/publications/p560), [IRS COLA table for 2026](https://www.irs.gov/retirement-plans/cola-increases-for-dollar-limitations-on-benefits-and-contributions), [IRS Notice 2025-67](https://www.irs.gov/pub/irs-drop/n-25-67.pdf), [One-participant 401(k) plans](https://www.irs.gov/retirement-plans/one-participant-401k-plans) and [Schedule SE](https://www.irs.gov/forms-pubs/about-schedule-se-form-1040). Figures checked on October 27, 2026. This is general information, not tax or investment advice.

## Related tools and guides

- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator) to see how a retirement deduction changes your quarterly payments
- [Home office deduction calculator](home-office-deduction-calculator) to compare the simplified and regular home office methods
- [2026 mileage deduction calculator](2026-mileage-deduction-calculator) for car expenses at the split-year IRS rates
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator) to price your work with retirement savings built in

*Disclosure: the calculators on this site are our own. We don't earn anything from the links in this list, and none are affiliate links.* More guides: [Gumroad developer guides](./).
