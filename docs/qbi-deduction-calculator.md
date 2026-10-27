---
layout: page
title: "QBI deduction calculator 2026: Section 199A 20% for freelancers"
description: "Free 2026 Qualified Business Income (QBI) deduction calculator for freelancers and sole proprietors. See your Section 199A 20% deduction under Form 8995, the SSTB phase-out between $201,750 and $276,750 ($403,500–$553,500 joint), and the W-2 wage / UBIA limit above the threshold."
---

If you freelance or run a pass-through business, Section 199A lets you deduct up to **20% of your qualified business income (QBI)** on Form 8995 or 8995-A. Most freelancers (consulting, design, writing, law, health, accounting, financial services) are a **specified service trade or business (SSTB)**, so the deduction phases out once taxable income crosses the 2026 threshold and is gone above the upper limit. This calculator follows the 2026 Form 8995 instructions for tax year 2026. Everything runs in your browser and nothing is sent anywhere.

<div id="qbi" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <table><tbody>
    <tr><td>Qualified business income (QBI) for 2026</td><td><input id="qbi-qbi" type="number" step="100" value="80000"></td></tr>
    <tr><td>Taxable income <em>before</em> the QBI deduction</td><td><input id="qbi-ti" type="number" step="100" value="70000"></td></tr>
    <tr><td>Filing status</td><td><select id="qbi-status"><option value="single">Single</option><option value="mfj">Married filing jointly</option><option value="mfs">Married filing separately</option><option value="hoh">Head of household</option><option value="qss">Qualifying surviving spouse</option></select></td></tr>
    <tr><td>Is this a specified service trade or business (SSTB)?</td><td><select id="qbi-sstb"><option value="yes">Yes (most freelancers: consulting, design, writing, law, health, accounting, finance, athletics, performing arts)</option><option value="no">No (qualified trade or business that is not an SSTB)</option></select></td></tr>
    <tr><td>W-2 wages paid by the business (optional; for the wage limit above the threshold)</td><td><input id="qbi-w2" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>UBIA of qualified property (optional)</td><td><input id="qbi-ubia" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>Qualified REIT dividends + PTP income (optional)</td><td><input id="qbi-reit" type="number" min="0" step="100" value="0"></td></tr>
    <tr><td>Net capital gain + qualified dividends (optional; lowers the taxable-income cap)</td><td><input id="qbi-cg" type="number" min="0" step="100" value="0"></td></tr>
  </tbody></table>
  <div id="qbi-out" aria-live="polite"></div>
</div>

<script>
// 2026 Section 199A QBI deduction (Form 8995 / 8995-A), one trade or business
var QBI = (function () {
  var L = {
    year: 2026,
    thr: { single: 201750, hoh: 201750, qss: 201750, mfj: 403500, mfs: 201775 },
    upper: { single: 276750, hoh: 276750, qss: 276750, mfj: 553500, mfs: 276775 }
  };
  function r2(x) { return Math.round(x * 100) / 100; }
  function num(v, name, allowNeg) {
    var n = (v === "" || v == null) ? 0 : Number(v);
    if (!isFinite(n)) throw new Error(name + " must be a number");
    if (!allowNeg && n < 0) throw new Error(name + " can't be negative");
    return n;
  }
  function wageLimit(w2, ubia) {
    return Math.max(0.5 * w2, 0.25 * w2 + 0.025 * ubia);
  }
  function compute(o) {
    o = o || {};
    var qbi = Math.max(0, num(o.qbi, "QBI", true));
    var ti = Math.max(0, num(o.ti, "Taxable income", true));
    var st = o.status || "single";
    if (!L.thr.hasOwnProperty(st)) throw new Error("Unknown filing status");
    var sstb = (o.sstb === true || o.sstb === "yes" || o.sstb === "true");
    var w2 = num(o.w2, "W-2 wages");
    var ubia = num(o.ubia, "UBIA");
    var reit = num(o.reit, "REIT/PTP income");
    var cg = num(o.cg, "Net capital gain");
    var thr = L.thr[st], upper = L.upper[st], range = upper - thr;
    var cap = 0.2 * Math.max(0, ti - cg);
    var zone, appPct = 1, qbiEff = qbi, w2Eff = w2, ubiaEff = ubia;
    var tentative, wLim, reduction = 0, qbiComp, reitComp, deduction, form;

    if (ti <= thr) {
      zone = "below";
      form = "8995";
      tentative = 0.2 * qbi;
      wLim = null;
      qbiComp = tentative;
      reitComp = 0.2 * reit;
      deduction = Math.min(qbiComp + reitComp, cap);
    } else if (ti >= upper) {
      zone = "above";
      form = "8995-A";
      if (sstb) {
        appPct = 0;
        qbiEff = 0; w2Eff = 0; ubiaEff = 0;
        tentative = 0; wLim = 0; qbiComp = 0;
      } else {
        tentative = 0.2 * qbi;
        wLim = wageLimit(w2, ubia);
        qbiComp = Math.min(tentative, wLim);
      }
      reitComp = 0.2 * reit;
      deduction = Math.min(qbiComp + reitComp, cap);
    } else {
      zone = "phasein";
      form = "8995-A";
      var excess = ti - thr;
      var redPct = excess / range;
      appPct = sstb ? (1 - redPct) : 1;
      qbiEff = qbi * appPct;
      w2Eff = w2 * appPct;
      ubiaEff = ubia * appPct;
      tentative = 0.2 * qbiEff;
      wLim = wageLimit(w2Eff, ubiaEff);
      reduction = redPct * Math.max(0, tentative - wLim);
      qbiComp = Math.max(0, tentative - reduction);
      reitComp = 0.2 * reit;
      deduction = Math.min(qbiComp + reitComp, cap);
    }
    return {
      year: L.year, qbi: r2(qbi), taxableIncome: r2(ti), status: st, sstb: sstb,
      threshold: thr, upper: upper, phaseRange: range, zone: zone, form: form,
      applicablePct: r2(appPct * 100), qbiEffective: r2(qbiEff),
      tentative: r2(tentative), wageLimit: wLim == null ? null : r2(wLim),
      reduction: r2(reduction), qbiComponent: r2(qbiComp), reitComponent: r2(reitComp),
      taxableIncomeCap: r2(cap), deduction: r2(deduction),
      effectiveRate: qbi > 0 ? r2(deduction / qbi * 100) : 0, limits: L
    };
  }
  return { compute: compute, LIMITS: L, wageLimit: wageLimit };
})();

(function () {
  function $(id) { return document.getElementById(id); }
  function money(x) { return "$" + Number(x).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[c]; }); }
  var IDS = ["qbi", "ti", "status", "sstb", "w2", "ubia", "reit", "cg"];
  function run() {
    var h = "";
    try {
      var o = {}; IDS.forEach(function (k) { o[k] = $("qbi-" + k).value; });
      var r = QBI.compute(o);
      if (r.deduction === 0 && r.qbi === 0 && r.reitComponent === 0) {
        h += '<p style="font-size:1.15em"><strong>No QBI deduction.</strong> Enter some qualified business income (or REIT/PTP income).</p>';
      } else if (r.deduction === 0 && r.zone === "above" && r.sstb) {
        h += '<p style="font-size:1.15em"><strong>No QBI deduction from this SSTB.</strong> Your taxable income is at or above the 2026 upper limit (' + money(r.upper) + '), so a specified service trade or business does not qualify.</p>';
      } else if (r.deduction === 0 && r.zone !== "below" && (r.wageLimit === 0 || r.wageLimit === null)) {
        h += '<p style="font-size:1.15em"><strong>No QBI deduction.</strong> Above the threshold with no W-2 wages or UBIA, the wage limit is $0, so the deduction from this business is $0' + (r.reitComponent > 0 ? " (except any REIT/PTP piece)" : "") + '.</p>';
      } else {
        h += '<p style="font-size:1.15em"><strong>2026 QBI deduction: ' + money(r.deduction) + "</strong> (" + r.effectiveRate + "% of your QBI; Form " + r.form + ").</p>";
      }
      h += "<table><tbody>";
      h += "<tr><td>2026 threshold / upper limit for your filing status</td><td>" + money(r.threshold) + " / " + money(r.upper) + "</td></tr>";
      h += "<tr><td>Zone</td><td>" + (r.zone === "below" ? "At or below the threshold (full 20%, Form 8995)" : r.zone === "phasein" ? "In the phase-in range (Form 8995-A)" : "At or above the upper limit (Form 8995-A)") + "</td></tr>";
      if (r.sstb && r.zone !== "below") h += "<tr><td>SSTB applicable percentage</td><td>" + r.applicablePct + "%</td></tr>";
      if (r.sstb && r.zone === "phasein") h += "<tr><td>QBI after applicable percentage</td><td>" + money(r.qbiEffective) + "</td></tr>";
      h += "<tr><td>20% of (effective) QBI</td><td>" + money(r.tentative) + "</td></tr>";
      if (r.wageLimit != null) h += "<tr><td>W-2 wage / UBIA limit (greater of 50% of W-2 wages, or 25% of W-2 wages + 2.5% of UBIA)</td><td>" + money(r.wageLimit) + "</td></tr>";
      if (r.reduction > 0) h += "<tr><td>Phase-in reduction of the excess over the wage limit</td><td>" + money(r.reduction) + "</td></tr>";
      h += "<tr><td>QBI component</td><td>" + money(r.qbiComponent) + "</td></tr>";
      if (r.reitComponent > 0) h += "<tr><td>20% of qualified REIT dividends + PTP income</td><td>" + money(r.reitComponent) + "</td></tr>";
      h += "<tr><td>Overall limit: 20% of (taxable income − net capital gain)</td><td>" + money(r.taxableIncomeCap) + "</td></tr>";
      h += "<tr><td><strong>QBI deduction</strong></td><td><strong>" + money(r.deduction) + "</strong></td></tr>";
      h += "</tbody></table>";
      h += "<p><small>This lowers your income tax, not your self-employment tax. Pair it with the <a href=\"freelance-quarterly-estimated-tax-calculator\">quarterly estimated tax calculator</a> and the <a href=\"self-employment-tax-calculator\">self-employment tax calculator</a>.</small></p>";
    } catch (e) { h = '<p style="color:#b00">' + esc(e.message) + "</p>"; }
    $("qbi-out").innerHTML = h;
  }
  IDS.forEach(function (k) { var el = $("qbi-" + k); el.addEventListener("change", run); el.addEventListener("input", run); });
  run();
})();
</script>

## How the math works

```
below the threshold:
  deduction = the smaller of (20% × QBI + 20% × REIT/PTP) and (20% × (taxable income − net capital gain))

in the phase-in range (SSTB):
  applicable %     = 1 − (taxable income − threshold) / (upper − threshold)
  effective QBI    = QBI × applicable %
  tentative        = 20% × effective QBI
  wage limit       = greater of (50% × W-2 wages × applicable %,
                                25% × W-2 wages × applicable % + 2.5% × UBIA × applicable %)
  reduction        = phase-in % × max(0, tentative − wage limit)
  QBI component    = tentative − reduction
  deduction        = the smaller of (QBI component + 20% × REIT/PTP) and the taxable-income cap

at or above the upper limit:
  SSTB             → QBI component = $0
  non-SSTB         → QBI component = the smaller of (20% × QBI) and the wage limit
```

2026 thresholds (taxable income before the QBI deduction), from the draft 2026 Form 8995 instructions:

| Filing status | Threshold | Upper limit (end of phase-in) |
|---|---|---|
| Single, head of household, qualifying surviving spouse | $201,750 | $276,750 |
| Married filing jointly | $403,500 | $553,500 |
| Married filing separately | $201,775 | $276,775 |

Example with the default inputs: $80,000 of QBI and $70,000 of taxable income, single, SSTB. You are below the $201,750 threshold, so Form 8995 applies. 20% of QBI is $16,000; 20% of taxable income is $14,000; the deduction is the smaller one, **$14,000**.

## The rules this follows

- **What counts as QBI.** Net income from a US trade or business that is not a C corporation — typically Schedule C profit after the deductible half of self-employment tax and similar adjustments, or your share from a partnership or S corporation (Schedule K-1). W-2 wages you earn as an employee are never QBI. Guaranteed payments for services and reasonable compensation paid to you by an S corporation are also out.
- **SSTB.** A specified service trade or business includes health, law, accounting, actuarial science, performing arts, consulting, athletics, financial services, brokerage, investing and investment management, trading, dealing in securities, and any trade or business where the principal asset is the reputation or skill of one or more employees or owners. Most freelancers check **Yes**. Below the threshold an SSTB is treated like any other business; above the upper limit it qualifies for none of the QBI deduction.
- **The wage / UBIA limit.** Above the threshold, the QBI component cannot exceed the greater of (a) 50% of the W-2 wages the business paid, or (b) 25% of those W-2 wages plus 2.5% of the unadjusted basis immediately after acquisition (UBIA) of qualified property. A sole proprietor with no employees and little depreciable property often has a $0 wage limit, so the deduction from that business drops to $0 once income is high enough — even if it is not an SSTB.
- **The overall cap.** The whole deduction (QBI component plus 20% of qualified REIT dividends and PTP income) cannot exceed 20% of your taxable income minus net capital gain (including qualified dividends).
- **What this leaves out.** Multiple trades or businesses and aggregation (Schedule B), agricultural/horticultural cooperatives (Schedule D), the separately stated REIT/PTP loss carryforward rules, taxable-income interactions with the standard deduction or itemizing beyond the number you enter, and state conformity. Enter taxable income *before* the QBI deduction.

Sources: [2026 Instructions for Form 8995](https://www.irs.gov/pub/irs-dft/i8995--dft.pdf) (draft; thresholds $201,750 / $403,500), [Form 8995](https://www.irs.gov/pub/irs-dft/f8995--dft.pdf), [Form 8995-A](https://www.irs.gov/pub/irs-dft/f8995a--dft.pdf), [Schedule A (Form 8995-A)](https://www.irs.gov/pub/irs-dft/f8995aa--dft.pdf), [IRS Tax Topic 560 / About Form 8995](https://www.irs.gov/forms-pubs/about-form-8995), [26 CFR 1.199A-5 (SSTB)](https://www.ecfr.gov/current/title-26/chapter-I/subchapter-A/part-1/subject-group-ECFRcc67ec453a5e514/section-1.199A-5). Figures and rules checked on October 27, 2026. This is general information, not tax advice.

## FAQ

### Does the QBI deduction lower my self-employment tax?

No. It is an income-tax deduction only. Self-employment tax is figured on Schedule SE from your profit before this deduction. Use the [self-employment tax calculator](self-employment-tax-calculator) for that part.

### I'm a freelance consultant. Am I an SSTB?

Usually yes. Consulting is listed as a specified service, and so are many other freelance fields (design and writing can fall under the reputation-or-skill category). Below the 2026 threshold that does not matter; above it, your deduction phases out.

### What if I have no employees?

Below the threshold you still get the full 20% (subject to the taxable-income cap). Above the threshold the wage limit is often $0 without W-2 wages or UBIA, so the QBI component becomes $0 once you leave the phase-in range — and for an SSTB it is already $0 at the upper limit.

## Tools from us

- [Freelancer Quarterly Tax Planner 2026 (Excel + Google Sheets)](https://payhip.com/b/UspdI): log income and expenses, see the share of every dollar to set aside for self-employment and income tax, and track your quarterly payments against the 2026 due dates. $9.
- [Home Office Deduction Worksheet (Excel + Google Sheets)](https://payhip.com/b/8bG3C): log every bill and get the simplified and regular (Form 8829) deductions side by side. A bigger deduction means smaller taxable income and more room under the QBI threshold. $9.
- [Mileage Log 2026 (Excel + Google Sheets)](https://payhip.com/b/TUHGi): log business trips by date at the split-year 2026 IRS rates, with parking, tolls and a year summary. $9.

*Disclosure: all three spreadsheets are our own paid products, and we earn the sale price if you buy one. Not affiliated with the IRS. Not tax advice.*

## Related tools and guides

- [Self-employment tax calculator](self-employment-tax-calculator) for Social Security, Medicare, the wage base and the 0.9% Additional Medicare Tax
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator) to add income tax and get your four 2026 payments
- [SEP IRA vs Solo 401(k) calculator](self-employed-retirement-contribution-calculator) — a bigger retirement deduction lowers taxable income and can keep you under the QBI threshold
- [Home office deduction calculator](home-office-deduction-calculator) to compare the simplified and regular home office methods
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator) to price your work with tax built in

*Disclosure: the calculators on this site are our own. We don't earn anything from the links in this list, and none are affiliate links.* More guides: [Gumroad developer guides](./).
