---
layout: page
title: "Home office deduction calculator: simplified vs regular method"
description: "Free home office deduction calculator for the self-employed. Compare the IRS simplified method ($5 per square foot, up to 300 sq ft, max $1,500) with the regular method (business share of rent or mortgage interest, taxes, insurance, utilities, repairs and depreciation, Form 8829) side by side, with the income limit and carryovers."
---

The IRS gives self-employed people two ways to figure the home office deduction. The **simplified method** is $5 for each square foot of the office, up to 300 square feet, so it tops out at $1,500. The **regular method** deducts the office's share of your actual home costs: rent or mortgage interest, real estate taxes, insurance, utilities, repairs and depreciation, figured on Form 8829. You can pick whichever is better each year. This calculator runs both and shows which one gives the bigger deduction. Everything runs in your browser and nothing is sent anywhere.

<div id="ho" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <table><tbody>
    <tr><td>Office area (sq ft)</td><td><input id="ho-officeSqft" type="number" min="0" step="1" value="200"></td></tr>
    <tr><td>Whole home area (sq ft)</td><td><input id="ho-homeSqft" type="number" min="0" step="1" value="1600"></td></tr>
    <tr><td>Months used for business this year (count months with 15 or more days of use)</td><td><input id="ho-months" type="number" min="0" max="12" step="1" value="12"></td></tr>
    <tr><td>Gross income from the business</td><td><input id="ho-grossIncome" type="number" min="0" step="1" value="60000"></td></tr>
    <tr><td>Other business expenses, not from the home</td><td><input id="ho-otherExpenses" type="number" min="0" step="1" value="5000"></td></tr>
  </tbody></table>
  <p><strong>Whole-home costs for the year</strong> (enter yearly totals for the whole home; the calculator takes the office share for the months used)</p>
  <table><tbody>
    <tr><td>Rent</td><td><input id="ho-rent" type="number" min="0" step="1" value="0"></td></tr>
    <tr><td>Mortgage interest</td><td><input id="ho-mortgageInterest" type="number" min="0" step="1" value="9000"></td></tr>
    <tr><td>Real estate taxes</td><td><input id="ho-realEstateTaxes" type="number" min="0" step="1" value="4000"></td></tr>
    <tr><td>Homeowners or renters insurance</td><td><input id="ho-insurance" type="number" min="0" step="1" value="1200"></td></tr>
    <tr><td>Utilities (electric, gas, water, trash, internet share)</td><td><input id="ho-utilities" type="number" min="0" step="1" value="3000"></td></tr>
    <tr><td>Repairs and maintenance for the whole home</td><td><input id="ho-repairs" type="number" min="0" step="1" value="800"></td></tr>
    <tr><td>Other whole-home costs (HOA dues, security)</td><td><input id="ho-otherHome" type="number" min="0" step="1" value="0"></td></tr>
    <tr><td>Direct office costs (painting or repairs to the office only)</td><td><input id="ho-direct" type="number" min="0" step="1" value="0"></td></tr>
  </tbody></table>
  <p><strong>Depreciation (owners only, optional)</strong></p>
  <table><tbody>
    <tr><td>Home cost or adjusted basis, not counting land (use fair market value if that was lower when the office started)</td><td><input id="ho-basis" type="number" min="0" step="1" value="240000"></td></tr>
    <tr><td>Month the office first went into use, if it was this year</td><td><select id="ho-firstMonth"><option value="0" selected>Before this year</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option></select></td></tr>
    <tr><td>Operating expense carryover from last year's Form 8829</td><td><input id="ho-priorOperating" type="number" min="0" step="1" value="0"></td></tr>
    <tr><td>Depreciation carryover from last year's Form 8829</td><td><input id="ho-priorDepreciation" type="number" min="0" step="1" value="0"></td></tr>
  </tbody></table>
  <div id="ho-out" aria-live="polite"></div>
</div>

<script>
/* Home office deduction: simplified vs regular method (IRS Pub. 587 (2025), Form 8829, Rev. Proc. 2013-13, irs.gov simplified option page). Checked 2026-10-20. */
(function (root) {
  var RATE = 5, CAP = 300; // simplified option: $5 per sq ft, max 300 sq ft
  // MACRS 39-year nonresidential real property, mid-month, first-year % by month placed in service (Pub. 587 Table 2); later years 2.564%
  var FIRST_YEAR = [2.461, 2.247, 2.033, 1.819, 1.605, 1.391, 1.177, 0.963, 0.749, 0.535, 0.321, 0.107], LATER = 2.564;
  function r2(n) { return Math.round(n * 100) / 100; }
  function n(v, name, opt) {
    if ((v === undefined || v === null || v === "") && opt !== false) return 0;
    var x = typeof v === "number" ? v : parseFloat(String(v).replace(/[$,\s]/g, ""));
    if (!isFinite(x) || x < 0) throw new Error(name + " must be a number of 0 or more.");
    return x;
  }
  function simplified(o) {
    var office = n(o.officeSqft, "Office square feet"), months = n(o.months === undefined ? 12 : o.months, "Months");
    if (months > 12 || months % 1) throw new Error("Months must be a whole number from 0 to 12.");
    var sq = Math.min(office, CAP), avg = sq * months / 12, tentative = r2(avg * RATE);
    var limit = Math.max(0, r2(n(o.grossIncome, "Gross income") - n(o.otherExpenses, "Other business expenses")));
    var hasIncome = o.grossIncome !== undefined && o.grossIncome !== "";
    var deduction = hasIncome ? Math.min(tentative, limit) : tentative;
    return { method: "simplified", avgSqft: r2(avg), cappedSqft: sq, capped: office > CAP, tentative: tentative, limit: hasIncome ? limit : null,
      deduction: r2(deduction), lost: r2(tentative - deduction) };
  }
  function regular(o) {
    var office = n(o.officeSqft, "Office square feet"), home = n(o.homeSqft, "Home square feet"), months = n(o.months === undefined ? 12 : o.months, "Months");
    if (months > 12 || months % 1) throw new Error("Months must be a whole number from 0 to 12.");
    if (!home) throw new Error("Enter the total square feet of your home.");
    if (office > home) throw new Error("The office can't be bigger than the home.");
    var pct = office / home, part = months / 12, share = pct * part;
    var mortTax = r2((n(o.mortgageInterest, "Mortgage interest") + n(o.realEstateTaxes, "Real estate taxes")) * share);
    var indirectOp = n(o.rent, "Rent") + n(o.insurance, "Insurance") + n(o.utilities, "Utilities") + n(o.repairs, "Repairs") + n(o.otherHome, "Other home expenses");
    var operating = r2(indirectOp * share + n(o.direct, "Direct expenses") + n(o.priorOperating, "Operating carryover"));
    var basis = n(o.basis, "Home basis"), m = n(o.firstMonth, "First month"), rate = 0;
    if (basis) {
      if (m % 1 || m > 12) throw new Error("First month must be 1 to 12, or 0 if the office was in use before this year.");
      rate = m ? FIRST_YEAR[m - 1] : LATER * part;
    }
    var depreciation = r2(basis * pct * rate / 100 + n(o.priorDepreciation, "Depreciation carryover"));
    var hasIncome = o.grossIncome !== undefined && o.grossIncome !== "";
    var limit = hasIncome ? Math.max(0, r2(n(o.grossIncome, "Gross income") - n(o.otherExpenses, "Other business expenses") - mortTax)) : Infinity;
    var opAllowed = r2(Math.min(operating, limit)), deprAllowed = r2(Math.min(depreciation, Math.max(0, limit - opAllowed)));
    return { method: "regular", businessPct: r2(pct * 100), mortTax: mortTax, operating: operating, depreciation: depreciation, depreciationRate: r2(rate * 1000) / 1000,
      limit: hasIncome ? limit : null, operatingAllowed: opAllowed, depreciationAllowed: deprAllowed,
      carryOperating: r2(operating - opAllowed), carryDepreciation: r2(depreciation - deprAllowed),
      deduction: r2(mortTax + opAllowed + deprAllowed) };
  }
  function compare(o) {
    var s = simplified(o), g = regular(o);
    return { simplified: s, regular: g, better: g.deduction > s.deduction ? "regular" : "simplified", difference: r2(Math.abs(g.deduction - s.deduction)) };
  }
  var HO = { RATE: RATE, CAP: CAP, FIRST_YEAR: FIRST_YEAR, LATER: LATER, simplified: simplified, regular: regular, compare: compare };
  if (typeof module !== "undefined" && module.exports) module.exports = HO; else root.HO = HO;
})(this);
(function () {
  var $ = function (id) { return document.getElementById(id); };
  var money = function (n) { return "$" + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","); };
  var esc = function (s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); };
  var IDS = ["officeSqft", "homeSqft", "months", "grossIncome", "otherExpenses", "rent", "mortgageInterest", "realEstateTaxes", "insurance", "utilities", "repairs", "otherHome", "direct", "basis", "firstMonth", "priorOperating", "priorDepreciation"];
  function run() {
    var h = "";
    try {
      var o = {}; IDS.forEach(function (k) { o[k] = $("ho-" + k).value; });
      var r = HO.compare(o), s = r.simplified, g = r.regular;
      h += '<p style="font-size:1.15em"><strong>' + (r.better === "regular" ? "Regular method" : "Simplified method") + " is better: " + money(Math.max(s.deduction, g.deduction)) + "</strong>" +
        (r.difference ? ", which is " + money(r.difference) + " more than the " + (r.better === "regular" ? "simplified" : "regular") + " method." : ". Both methods give the same amount.") + "</p>";
      h += "<table><thead><tr><th></th><th>Simplified</th><th>Regular (Form 8829)</th></tr></thead><tbody>";
      h += "<tr><td>Area used</td><td>" + s.avgSqft + " sq ft average" + (s.capped ? " (capped at 300)" : "") + "</td><td>" + g.businessPct + "% of the home</td></tr>";
      h += "<tr><td>Mortgage interest and real estate taxes</td><td>Not part of it (deduct in full on Schedule A if you itemize)</td><td>" + money(g.mortTax) + "</td></tr>";
      h += "<tr><td>Rent, insurance, utilities, repairs, other</td><td>Not part of it</td><td>" + money(g.operatingAllowed) + (g.carryOperating ? " (" + money(g.carryOperating) + " carries over)" : "") + "</td></tr>";
      h += "<tr><td>Depreciation</td><td>None</td><td>" + money(g.depreciationAllowed) + (g.depreciation ? " at " + g.depreciationRate + "%" : "") + (g.carryDepreciation ? " (" + money(g.carryDepreciation) + " carries over)" : "") + "</td></tr>";
      h += "<tr><td><strong>Home office deduction</strong></td><td><strong>" + money(s.deduction) + "</strong></td><td><strong>" + money(g.deduction) + "</strong></td></tr>";
      h += "</tbody></table>";
      if (s.lost) h += "<p><small>The simplified amount is limited by the business's income: " + money(s.lost) + " can't be used and doesn't carry over.</small></p>";
      if (g.carryOperating || g.carryDepreciation) h += "<p><small>The regular method is limited by the business's income. " + money(g.carryOperating + g.carryDepreciation) + " carries over to the next year you use the regular method.</small></p>";
      if (g.mortTax && r.better === "regular") h += "<p><small>If you itemize, the " + money(g.mortTax) + " office share of mortgage interest and taxes would still be deductible on Schedule A under the simplified method, so the income tax gap is smaller than shown. On Schedule C it also lowers self-employment tax.</small></p>";
    } catch (e) { h = '<p style="color:#b00">' + esc(e.message) + "</p>"; }
    $("ho-out").innerHTML = h;
  }
  IDS.forEach(function (k) { var el = $("ho-" + k); el.addEventListener("change", run); el.addEventListener("input", run); });
  run();
})();
</script>

## How the math works

```
simplified = $5 x office sq ft (max 300) x months used / 12
business % = office sq ft / home sq ft
regular    = business % x (mortgage interest + taxes)
           + business % x (rent + insurance + utilities + repairs + other) + direct office costs
           + business % x home basis without land x 2.564% (39-year MACRS)
           all whole-home costs x months used / 12
```

Example with the default inputs: a 200 sq ft office in a 1,600 sq ft home is 12.5% of the home. The simplified method gives 200 x $5 = **$1,000**. The regular method gives 12.5% of $13,000 mortgage interest and taxes ($1,625), plus 12.5% of $5,000 insurance, utilities and repairs ($625), plus 12.5% of $240,000 x 2.564% depreciation ($769.20), for **$3,019.20**. Here the regular method is better by $2,019.20.

## The rules this follows

- **Who can take it.** You must use the space regularly and only for your business (exclusive use), and it must be your main place of business or a place you meet clients. Self-employed people claim it on Schedule C. Employees can't take the deduction for tax years after 2017, even when they work from home.
- **Simplified method.** $5 per square foot of the area used for business, up to 300 square feet. Home mortgage interest and real estate taxes stay deductible in full on Schedule A if you itemize, and there's no depreciation, so nothing is recaptured when you sell. If you used the office for part of the year, the area is averaged by month: each month counts up to 300 square feet, a month with fewer than 15 days of business use counts as 0, and the total is divided by 12.
- **Regular method.** Costs for the whole home (indirect expenses) are deducted at the business percentage, and costs only for the office (direct expenses) are deducted in full. You can use any reasonable method for the percentage; area is the most common. Expenses only count for the part of the year you used the office, so this calculator takes months used / 12 of yearly totals.
- **Depreciation.** Owners depreciate the business share of the home, not the land, over 39 years using MACRS straight line with the mid-month convention. The first year depends on the month you started: 2.461% for January down to 0.107% for December (Pub. 587 Table 2), then 2.564% a year. When you sell, the depreciation you were allowed is taxed as unrecaptured section 1250 gain.
- **Income limit and carryover.** Either method is limited to the gross income from the business minus its other expenses. With the regular method, the office share of mortgage interest and taxes is deducted first, then operating costs, then depreciation, and anything over the limit carries over to the next year you use the regular method. With the simplified method, the excess is lost.
- **Switching.** You can choose either method each year on a timely filed original return. Once you file, you can't change that year's method. Regular-method carryovers wait during a simplified year.

Sources: [IRS simplified option for home office deduction](https://www.irs.gov/businesses/small-businesses-self-employed/simplified-option-for-home-office-deduction), [Publication 587, Business Use of Your Home](https://www.irs.gov/publications/p587), [Form 8829](https://www.irs.gov/forms-pubs/about-form-8829) and Rev. Proc. 2013-13. Rules checked on October 20, 2026. This is general information, not tax advice.

## Tools from us

- [Mileage Log 2026 (Excel + Google Sheets)](https://payhip.com/b/TUHGi): log business, medical and charity trips by date at the split-year 2026 IRS rates (72.5 cents to June 30, 76 cents from July 1), with parking and tolls and a year summary. $9.
- [Per Diem Travel Expense Tracker (Excel + Google Sheets)](https://payhip.com/b/ztfN3): log work trips day by day at GSA FY2026 and FY2027 rates, with the 50% or 80% deductible meal amount from IRS Pub. 463. $9.
- [Home Office Deduction Worksheet (Excel + Google Sheets)](https://payhip.com/b/8bG3C): log every bill and get the simplified and regular (Form 8829) deductions side by side, with depreciation, the income limit and carryovers. $9.

*Disclosure: all three spreadsheets are our own paid products, and we earn the sale price if you buy one. Not affiliated with the IRS. Not tax advice.*

## Related tools and guides

- [2026 mileage deduction calculator](2026-mileage-deduction-calculator) for car expenses at the split-year IRS rates
- [Self-employed per diem meal deduction calculator](self-employed-per-diem-meal-deduction-calculator) for meals on overnight work trips
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator) to see what a bigger deduction does to your quarterly payments
- [Self-employment tax calculator](self-employment-tax-calculator) to see how much self-employment tax a smaller profit saves
- [SEP IRA vs Solo 401(k) calculator](self-employed-retirement-contribution-calculator) for the biggest self-employed deduction most freelancers miss

*Disclosure: the calculators on this site are our own. We don't earn anything from the links in this list, and none are affiliate links.* More guides: [Gumroad developer guides](./).
