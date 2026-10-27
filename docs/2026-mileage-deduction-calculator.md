---
layout: page
title: "2026 mileage deduction calculator: 72.5¢ and 76¢ split-year IRS rates"
description: "Free 2026 mileage deduction calculator. The IRS business rate changed mid-year from 72.5 cents to 76 cents a mile on July 1, 2026, so each trip is priced by its date. Enter miles before and after July 1, or paste a trip log, for business, medical, military moving and charity miles. 2025 rates included."
---

The IRS changed the standard mileage rate in the middle of 2026. Business miles driven **January 1 to June 30, 2026** are worth **72.5 cents** a mile, and miles driven **July 1 to December 31, 2026** are worth **76 cents**. Medical and military moving miles went from 20.5 to 23.5 cents, and charity stays at 14 cents. That means one rate times your yearly miles gives the wrong 2026 number. This calculator prices every mile by the date you drove it. Everything runs in your browser and nothing is sent anywhere.

<div id="mil" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <p><label><input type="radio" name="mil-mode" id="mil-mode-split" value="split" checked> Quick: my 2026 miles before and after July 1</label><br>
     <label><input type="radio" name="mil-mode" id="mil-mode-log" value="log"> Trip log: paste dated trips (2025 or 2026)</label></p>
  <div id="mil-split">
    <table><thead><tr><th>Purpose</th><th>Miles Jan 1 to Jun 30</th><th>Miles Jul 1 to Dec 31</th></tr></thead><tbody>
      <tr><td>Business or self-employed</td><td><input id="mil-business-1" type="number" min="0" step="0.1" value="4000"></td><td><input id="mil-business-2" type="number" min="0" step="0.1" value="3000"></td></tr>
      <tr><td>Medical</td><td><input id="mil-medical-1" type="number" min="0" step="0.1" value="0"></td><td><input id="mil-medical-2" type="number" min="0" step="0.1" value="0"></td></tr>
      <tr><td>Moving (military only)</td><td><input id="mil-moving-1" type="number" min="0" step="0.1" value="0"></td><td><input id="mil-moving-2" type="number" min="0" step="0.1" value="0"></td></tr>
      <tr><td>Charity</td><td><input id="mil-charity-1" type="number" min="0" step="0.1" value="0"></td><td><input id="mil-charity-2" type="number" min="0" step="0.1" value="0"></td></tr>
    </tbody></table>
  </div>
  <div id="mil-log" style="display:none">
    <p><label>One trip per line: date, miles, purpose (business, medical, moving or charity). You can paste columns from a spreadsheet.<br>
    <textarea id="mil-text" rows="7" style="width:100%;font-family:monospace">date, miles, purpose
2026-03-14, 42, business
2026-06-30, 18.5, business
2026-07-01, 18.5, business
2026-08-09, 30, medical
2026-11-21, 12, charity</textarea></label></p>
  </div>
  <p><label>Business parking fees and tolls (optional, deductible on top of the rate)<br><input id="mil-extra" type="number" min="0" step="0.01" value="0"></label></p>
  <div id="mil-out" aria-live="polite"></div>
</div>

<script>
/* IRS standard mileage rates by date (irs.gov standard mileage rates table, Announcement 2026-11, IR-2026-29, IR-2025-128, IR-2024-312). Checked 2026-10-20. */
(function (root) {
  // cents per mile; each period applies to miles driven from `from` to `to` inclusive
  var RATES = [
    { from: "2025-01-01", to: "2025-12-31", label: "2025", business: 70, medical: 21, moving: 21, charity: 14, source: "IR-2024-312" },
    { from: "2026-01-01", to: "2026-06-30", label: "Jan 1 to Jun 30, 2026", business: 72.5, medical: 20.5, moving: 20.5, charity: 14, source: "IR-2025-128" },
    { from: "2026-07-01", to: "2026-12-31", label: "Jul 1 to Dec 31, 2026", business: 76, medical: 23.5, moving: 23.5, charity: 14, source: "IR-2026-29, Announcement 2026-11" }
  ];
  var PURPOSES = ["business", "medical", "moving", "charity"];
  var ALIAS = { business: "business", work: "business", biz: "business", b: "business", medical: "medical", med: "medical", m: "medical",
    moving: "moving", military: "moving", move: "moving", charity: "charity", charitable: "charity", volunteer: "charity", c: "charity" };
  function r2(n) { return Math.round(n * 100) / 100; }
  function parse(s) {
    var m = /^(\d{4})-(\d{1,2})-(\d{1,2})$/.exec(String(s || "").trim()) || /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/.exec(String(s || "").trim());
    if (!m) throw new Error("Use dates like 2026-07-15 or 7/15/2026: " + s);
    var y, mo, d;
    if (m[0].indexOf("/") > 0) { y = +m[3]; mo = +m[1]; d = +m[2]; } else { y = +m[1]; mo = +m[2]; d = +m[3]; }
    var dt = new Date(Date.UTC(y, mo - 1, d));
    if (dt.getUTCMonth() !== mo - 1 || dt.getUTCDate() !== d) throw new Error("Not a real date: " + s);
    return dt.toISOString().slice(0, 10);
  }
  function period(date) {
    var iso = parse(date);
    for (var i = 0; i < RATES.length; i++) if (iso >= RATES[i].from && iso <= RATES[i].to) return RATES[i];
    throw new Error("Rates here cover trips from Jan 1, 2025 to Dec 31, 2026. " + iso + " is outside that.");
  }
  function purpose(p) {
    var k = ALIAS[String(p || "business").trim().toLowerCase()];
    if (!k) throw new Error("Purpose must be business, medical, moving (military only) or charity: " + p);
    return k;
  }
  function miles(n) {
    var v = typeof n === "number" ? n : parseFloat(String(n == null ? "" : n).replace(/,/g, ""));
    if (!(v >= 0) || !isFinite(v)) throw new Error("Miles must be a number of 0 or more: " + n);
    return v;
  }
  function blank() { var o = {}; PURPOSES.forEach(function (p) { o[p] = { miles: 0, amount: 0 }; }); return o; }
  // trips: [{ date, miles, purpose }] -> per-period and per-purpose totals
  function trips(list) {
    var byPeriod = {}, byPurpose = blank(), rows = [];
    (list || []).forEach(function (t) {
      var P = period(t.date), k = purpose(t.purpose), mi = miles(t.miles), rate = P[k], amt = r2(mi * rate / 100);
      rows.push({ date: parse(t.date), miles: mi, purpose: k, rate: rate, period: P.label, amount: amt });
      var bp = byPeriod[P.label] || (byPeriod[P.label] = { label: P.label, from: P.from, rates: P, totals: blank() });
      bp.totals[k].miles += mi; bp.totals[k].amount += mi * rate / 100;
      byPurpose[k].miles += mi; byPurpose[k].amount += mi * rate / 100;
    });
    var periods = Object.keys(byPeriod).map(function (k) { return byPeriod[k]; }).sort(function (a, b) { return a.from < b.from ? -1 : 1; });
    periods.forEach(function (bp) { PURPOSES.forEach(function (p) { bp.totals[p].miles = r2(bp.totals[p].miles); bp.totals[p].amount = r2(bp.totals[p].amount); }); });
    var total = 0;
    PURPOSES.forEach(function (p) { byPurpose[p].miles = r2(byPurpose[p].miles); byPurpose[p].amount = r2(byPurpose[p].amount); total += byPurpose[p].amount; });
    return { rows: rows, periods: periods, purposes: byPurpose, total: r2(total) };
  }
  // 2026 split totals: { business: [milesJanJun, milesJulDec], medical: [...], ... }
  function split2026(o) {
    var list = [];
    PURPOSES.forEach(function (p) {
      var v = (o && o[p]) || [0, 0];
      if (miles(v[0] || 0)) list.push({ date: "2026-03-01", miles: v[0], purpose: p });
      if (miles(v[1] || 0)) list.push({ date: "2026-09-01", miles: v[1], purpose: p });
    });
    return trips(list);
  }
  // "date, miles, purpose" per line (comma, tab or semicolon); a header line is skipped
  function parseLog(text) {
    var out = [], errors = [];
    String(text || "").split(/\r?\n/).forEach(function (line, i) {
      var s = line.trim(); if (!s || s.charAt(0) === "#") return;
      var f = s.split(/\s*[,\t;]\s*/);
      if (i === 0 && /date/i.test(f[0])) return;
      try { out.push({ date: parse(f[0]), miles: miles(f[1]), purpose: purpose(f[2] || "business") }); }
      catch (e) { errors.push("Line " + (i + 1) + ": " + e.message); }
    });
    return { trips: out, errors: errors };
  }
  var MIL = { RATES: RATES, PURPOSES: PURPOSES, period: period, trips: trips, split2026: split2026, parseLog: parseLog };
  if (typeof module !== "undefined" && module.exports) module.exports = MIL; else root.MIL = MIL;
})(this);
(function () {
  var $ = function (id) { return document.getElementById(id); };
  var money = function (n) { return "$" + n.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","); };
  var num = function (n) { return String(Math.round(n * 100) / 100).replace(/\B(?=(\d{3})+(?!\d))/g, ","); };
  var esc = function (s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); };
  var NAMES = { business: "Business", medical: "Medical", moving: "Moving (military)", charity: "Charity" };
  function mode() { return $("mil-mode-log").checked ? "log" : "split"; }
  function run() {
    var out = $("mil-out"), h = "", errs = [];
    $("mil-split").style.display = mode() === "split" ? "" : "none";
    $("mil-log").style.display = mode() === "log" ? "" : "none";
    try {
      var r;
      if (mode() === "split") {
        var o = {};
        MIL.PURPOSES.forEach(function (p) { o[p] = [$("mil-" + p + "-1").value || 0, $("mil-" + p + "-2").value || 0]; });
        r = MIL.split2026(o);
      } else {
        var L = MIL.parseLog($("mil-text").value); errs = L.errors; r = MIL.trips(L.trips);
      }
      var extra = parseFloat($("mil-extra").value || 0); if (!(extra >= 0)) throw new Error("Parking and tolls must be a number of dollars.");
      var b = r.purposes.business;
      h += '<p style="font-size:1.15em"><strong>Business mileage deduction: ' + money(b.amount + extra) + "</strong>" +
        (extra ? " (" + money(b.amount) + " for " + num(b.miles) + " miles plus " + money(extra) + " parking and tolls)" : " for " + num(b.miles) + " miles") + "</p>";
      var others = MIL.PURPOSES.filter(function (p) { return p !== "business" && r.purposes[p].miles; });
      if (others.length) h += "<p>" + others.map(function (p) { return NAMES[p] + ": " + money(r.purposes[p].amount) + " for " + num(r.purposes[p].miles) + " miles"; }).join("<br>") + "</p>";
      if (r.periods.length) {
        h += "<table><thead><tr><th>Period</th><th>Purpose</th><th>Miles</th><th>Rate</th><th>Amount</th></tr></thead><tbody>";
        r.periods.forEach(function (bp) {
          MIL.PURPOSES.forEach(function (p) {
            var t = bp.totals[p]; if (!t.miles) return;
            h += "<tr><td>" + esc(bp.label) + "</td><td>" + NAMES[p] + "</td><td>" + num(t.miles) + "</td><td>" + bp.rates[p] + "¢</td><td>" + money(t.amount) + "</td></tr>";
          });
        });
        h += "</tbody></table>";
      }
      var b26 = r.periods.filter(function (bp) { return bp.from >= "2026-01-01"; }).reduce(function (s, bp) { return s + bp.totals.business.miles; }, 0);
      if (b26) {
        var amt26 = r.periods.filter(function (bp) { return bp.from >= "2026-01-01"; }).reduce(function (s, bp) { return s + bp.totals.business.amount; }, 0);
        var at76 = Math.round(b26 * 76) / 100;
        h += "<p><small>Pricing all " + num(b26) + " business miles of 2026 at 76¢ would give " + money(at76) + ", which overstates the deduction by " + money(Math.round((at76 - amt26) * 100) / 100) + ". Using 72.5¢ for the whole year would understate it.</small></p>";
      }
      if (!r.rows.length) h += "<p>Enter some miles to see the deduction.</p>";
    } catch (e) { h = '<p style="color:#b00">' + esc(e.message) + "</p>"; }
    if (errs.length) h += '<p style="color:#b00">Skipped: ' + errs.map(esc).join("<br>") + "</p>";
    out.innerHTML = h;
  }
  ["mil-mode-split", "mil-mode-log", "mil-text", "mil-extra"].concat([].concat.apply([], MIL.PURPOSES.map(function (p) { return ["mil-" + p + "-1", "mil-" + p + "-2"]; })))
    .forEach(function (id) { $(id).addEventListener("change", run); $(id).addEventListener("input", run); });
  run();
})();
</script>

## How the math works

```
each trip           = miles x the rate for that trip's purpose on the day you drove it
2026 business       = miles Jan 1 to Jun 30 x 72.5¢ + miles Jul 1 to Dec 31 x 76¢
plus                = business parking fees and tolls (deductible separately)
```

Example with the default inputs: 4,000 business miles from January to June and 3,000 from July to December. That's 4,000 x $0.725 = $2,900 plus 3,000 x $0.76 = $2,280, so the **2026 business mileage deduction is $5,180**. Pricing all 7,000 miles at 76¢ would give $5,320, which is $140 too much.

## 2025 and 2026 IRS standard mileage rates

| Miles driven | Business | Medical or military moving | Charity |
| --- | --- | --- | --- |
| Jul 1 to Dec 31, 2026 | 76¢ | 23.5¢ | 14¢ |
| Jan 1 to Jun 30, 2026 | 72.5¢ | 20.5¢ | 14¢ |
| 2025 | 70¢ | 21¢ | 14¢ |

## The rules this follows

- **The date of the trip picks the rate.** IRS Announcement 2026-11 raised the 2026 rates for expenses paid or incurred on or after July 1, 2026, and the earlier rates still apply before that. The charity rate is set by law at 14 cents and didn't change.
- **Who can deduct business miles.** Self-employed people deduct car expenses on Schedule C (or Schedule F for farmers). Most employees can't deduct unreimbursed car expenses; the exceptions are Armed Forces reservists, qualified performing artists and fee-basis state or local government officials. If you're an employee, ask your employer to reimburse you instead.
- **When you can use the standard rate.** You must own or lease the car, not run five or more cars at once, and not have claimed depreciation other than straight-line, MACRS, a Section 179 deduction or the special depreciation allowance on it. For a car you own, you must choose the standard rate in the first year you use it for business. For a leased car, choosing it means using it for the whole lease.
- **Actual expenses are the alternative.** Instead of the rate you can deduct the business share of gas, oil, repairs, tires, insurance, registration, and depreciation or lease payments. Figure both ways if you qualify for both.
- **Parking and tolls are extra.** Business parking fees and tolls are deductible on top of the standard rate. Commuting between home and a regular workplace isn't business mileage.
- **Medical, moving and charity miles.** Medical miles count as medical expenses on Schedule A, and only medical expenses above 7.5% of your adjusted gross income are deductible. The moving rate is only for members of the Armed Forces on active duty moving under military orders. Charity miles are driven for a qualified charitable organization.
- **Keep a log.** The IRS requires adequate records, so note the date, miles, place and business purpose of each trip as you go.
- **Reimbursing employees.** Many employers reimburse at the IRS business rate. The federal government's rate for a privately owned car is also 76 cents from July 1, 2026 (GSA FTR Bulletin 26-03).

Sources: [IRS standard mileage rates](https://www.irs.gov/tax-professionals/standard-mileage-rates), [IRS Announcement 2026-11 (IRB 2026-29)](https://www.irs.gov/irb/2026-29_irb), [IRS Topic 510, business use of car](https://www.irs.gov/taxtopics/tc510), [Publication 463](https://www.irs.gov/publications/p463) and [GSA FTR Bulletin 26-03](https://www.gsa.gov/policy-regulations/regulations/federal-travel-regulation/ftr-and-related-files/gsa-bulletin-ftr-2603). Rates and rules checked on October 20, 2026. This is general information, not tax advice.

## Tools from us

- [Mileage Log 2026 (Excel + Google Sheets)](https://payhip.com/b/TUHGi): log every trip and get each one priced at the IRS rate for its date (72.5¢ to June 30, 76¢ from July 1, plus medical, military moving and charity rates), with monthly totals, the Schedule C line 9 total and a reimbursement sheet. $9.
- [Per Diem Travel Expense Tracker (Excel + Google Sheets)](https://payhip.com/b/ztfN3): log trips day by day at GSA FY2026 and FY2027 rates, with 75% first and last days, provided-meal deductions, lodging vs the GSA cap, and the 50% or 80% deductible meal amount from IRS Pub. 463. $9.

*Disclosure: the Mileage Log 2026 and the Per Diem Travel Expense Tracker are our own paid products, and we earn the sale price if you buy one. Not affiliated with the IRS or GSA. Not tax advice.*

## Related tools and guides

- [Self-employed per diem meal deduction calculator](self-employed-per-diem-meal-deduction-calculator) for meals on overnight work trips
- [GSA per diem calculator](gsa-per-diem-calculator) for lodging and M&IE on employer or federal travel
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator) to see what a bigger deduction does to your quarterly payments
- [Self-employment tax calculator (2026)](self-employment-tax-calculator) to see how much Social Security and Medicare tax a bigger deduction saves
- [Home office deduction calculator](home-office-deduction-calculator) to compare the simplified and regular home office methods

*Disclosure: the calculators on this site are our own. We don't earn anything from the links in this list, and none are affiliate links.* More guides: [Gumroad developer guides](./).
