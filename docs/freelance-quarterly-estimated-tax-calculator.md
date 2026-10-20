---
layout: page
title: "Quarterly estimated tax calculator for freelancers (2026): how much to set aside"
description: "Free 2026 quarterly estimated tax calculator for US freelancers and 1099 contractors. Works out self-employment tax, federal income tax, the percentage of each payment to set aside, your four quarterly payments, the safe-harbor minimum and the 2026 due dates."
---

How much of each client payment should you put aside for tax, and what do you send the IRS each quarter? Enter your expected 2026 freelance profit (or what you've made so far this year), your filing status, any W-2 job, and last year's tax. The calculator estimates your **self-employment tax** and **federal income tax** with the 2026 rates, the **percentage of every payment to set aside**, your **four quarterly payments**, the **safe-harbor minimum** that avoids the underpayment penalty, and the **2026 due dates**. Everything runs in your browser and nothing is sent anywhere.

The starting numbers are only an example (a single freelancer with $60,000 of profit and no other job). Replace them with your own.

<style>#qet table th, #qet table td { padding: 6px 6px; }</style>

<div id="qet" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:720px">
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>How do you want to enter profit?<br><select id="qet-mode" style="width:100%;max-width:220px">
      <option value="full" selected>Full-year 2026 estimate</option>
      <option value="ytd">So far this year (projected)</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Expected 2026 net self-employment profit ($)<br><input id="qet-profit" type="number" min="0" step="100" value="60000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Net profit so far this year ($)<br><input id="qet-ytd" type="number" min="0" step="100" value="45000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Months that covers (1 to 12)<br><input id="qet-months" type="number" min="1" max="12" step="1" value="9" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>2026 filing status<br><select id="qet-status" style="width:100%;max-width:220px">
      <option value="single" selected>Single</option>
      <option value="mfj">Married filing jointly</option>
      <option value="mfs">Married filing separately</option>
      <option value="hoh">Head of household</option>
      <option value="qss">Qualifying surviving spouse</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your 2026 W-2 wages ($, optional)<br><input id="qet-w2" type="number" min="0" step="100" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Spouse's W-2 wages ($, joint returns only)<br><input id="qet-w2s" type="number" min="0" step="100" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Federal income tax withheld from W-2 pay in 2026 ($)<br><input id="qet-wh" type="number" min="0" step="100" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>State income tax rate on your profit (%, optional)<br><input id="qet-state" type="number" min="0" max="20" step="0.1" value="0" placeholder="e.g. 5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>2025 total tax ($, Form 1040 line 24)<br><input id="qet-ptax" type="number" min="0" step="100" value="9000" placeholder="leave blank if no 2025 return" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>2025 adjusted gross income ($, Form 1040 line 11)<br><input id="qet-pagi" type="number" min="0" step="100" value="55000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="qet-qbi" type="checkbox" checked> Include the 20% qualified business income (QBI) deduction (simplified)</label></p>
  </div>
  <details style="margin:0 0 8px">
    <summary>2026 figures used (all editable)</summary>
    <div style="display:flex;flex-wrap:wrap;gap:4px 24px;margin-top:8px">
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Social Security wage base ($)<br><input id="qet-ssbase" type="number" min="0" step="100" value="184500" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Social Security part of SE tax (%)<br><input id="qet-ssrate" type="number" min="0" step="0.1" value="12.4" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Medicare part of SE tax (%)<br><input id="qet-medrate" type="number" min="0" step="0.1" value="2.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Share of profit subject to SE tax (%)<br><input id="qet-nef" type="number" min="0" max="100" step="0.01" value="92.35" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>No SE tax if net earnings are under ($)<br><input id="qet-minse" type="number" min="0" step="1" value="400" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Additional Medicare Tax (%)<br><input id="qet-addrate" type="number" min="0" step="0.1" value="0.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Additional Medicare threshold, joint ($)<br><input id="qet-add-mfj" type="number" min="0" step="1000" value="250000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Additional Medicare threshold, separate ($)<br><input id="qet-add-mfs" type="number" min="0" step="1000" value="125000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Additional Medicare threshold, all others ($)<br><input id="qet-add-oth" type="number" min="0" step="1000" value="200000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Standard deduction, single ($)<br><input id="qet-std-single" type="number" min="0" step="50" value="16100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Standard deduction, joint and surviving spouse ($)<br><input id="qet-std-mfj" type="number" min="0" step="50" value="32200" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Standard deduction, separate ($)<br><input id="qet-std-mfs" type="number" min="0" step="50" value="16100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Standard deduction, head of household ($)<br><input id="qet-std-hoh" type="number" min="0" step="50" value="24150" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 100%;margin:0 0 8px"><label>Bracket rates (%, lowest to highest)<br><input id="qet-rates" type="text" value="10, 12, 22, 24, 32, 35, 37" style="width:100%;max-width:340px"></label></p>
      <p style="flex:1 1 100%;margin:0 0 8px"><label>Bracket tops, single ($)<br><input id="qet-br-single" type="text" value="12400, 50400, 105700, 201775, 256225, 640600" style="width:100%;max-width:340px"></label></p>
      <p style="flex:1 1 100%;margin:0 0 8px"><label>Bracket tops, joint and surviving spouse ($)<br><input id="qet-br-mfj" type="text" value="24800, 100800, 211400, 403550, 512450, 768700" style="width:100%;max-width:340px"></label></p>
      <p style="flex:1 1 100%;margin:0 0 8px"><label>Bracket tops, separate ($)<br><input id="qet-br-mfs" type="text" value="12400, 50400, 105700, 201775, 256225, 384350" style="width:100%;max-width:340px"></label></p>
      <p style="flex:1 1 100%;margin:0 0 8px"><label>Bracket tops, head of household ($)<br><input id="qet-br-hoh" type="text" value="17700, 67450, 105700, 201750, 256200, 640600" style="width:100%;max-width:340px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>QBI deduction (%)<br><input id="qet-qbirate" type="number" min="0" step="1" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Safe harbor, share of this year's tax (%)<br><input id="qet-sh90" type="number" min="0" step="1" value="90" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Safe harbor, share of last year's tax (%)<br><input id="qet-sh100" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>Same, if last year's AGI was high (%)<br><input id="qet-sh110" type="number" min="0" step="1" value="110" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>High AGI means over ($)<br><input id="qet-shagi" type="number" min="0" step="1000" value="150000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
      <p style="flex:1 1 200px;margin:0 0 8px"><label>High AGI, married filing separately ($)<br><input id="qet-shagimfs" type="number" min="0" step="1000" value="75000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    </div>
    <p id="qet-cfg-note" style="margin:0"><small></small></p>
  </details>
  <table style="width:100%">
    <tbody>
      <tr><td>2026 net profit used</td><td style="text-align:right" id="qet-o-profit"></td></tr>
      <tr><td>Net earnings from self-employment (92.35%)</td><td style="text-align:right" id="qet-o-ne"></td></tr>
      <tr><td>Social Security part (12.4%, up to the wage base)</td><td style="text-align:right" id="qet-o-ss"></td></tr>
      <tr><td>Medicare part (2.9%)</td><td style="text-align:right" id="qet-o-med"></td></tr>
      <tr><td><strong>Self-employment tax</strong></td><td style="text-align:right"><strong id="qet-o-se"></strong></td></tr>
      <tr><td>Additional Medicare Tax (0.9%)</td><td style="text-align:right" id="qet-o-add"></td></tr>
      <tr><td>Deduction for half of SE tax</td><td style="text-align:right" id="qet-o-half"></td></tr>
      <tr><td>Adjusted gross income (approx.)</td><td style="text-align:right" id="qet-o-agi"></td></tr>
      <tr><td>Standard deduction</td><td style="text-align:right" id="qet-o-std"></td></tr>
      <tr><td>QBI deduction</td><td style="text-align:right" id="qet-o-qbi"></td></tr>
      <tr><td>Taxable income</td><td style="text-align:right" id="qet-o-ti"></td></tr>
      <tr><td><strong>Federal income tax</strong></td><td style="text-align:right"><strong id="qet-o-inc"></strong></td></tr>
      <tr><td>Top bracket you reach</td><td style="text-align:right" id="qet-o-marg"></td></tr>
      <tr><td><strong>Total 2026 federal tax</strong></td><td style="text-align:right"><strong id="qet-o-total"></strong></td></tr>
      <tr><td>Minus W-2 withholding</td><td style="text-align:right" id="qet-o-wh"></td></tr>
      <tr><td>Federal tax still to pay</td><td style="text-align:right" id="qet-o-owe"></td></tr>
      <tr><td>State tax at your rate</td><td style="text-align:right" id="qet-o-state"></td></tr>
      <tr><td><strong>Set aside from every payment</strong></td><td style="text-align:right"><strong id="qet-o-pct"></strong></td></tr>
      <tr><td>Of each $1,000 you're paid</td><td style="text-align:right" id="qet-o-per"></td></tr>
      <tr><td><strong>Quarterly federal payment (full estimate)</strong></td><td style="text-align:right"><strong id="qet-o-q"></strong></td></tr>
      <tr><td>Safe harbor: 90% of 2026 tax</td><td style="text-align:right" id="qet-o-90"></td></tr>
      <tr><td>Safe harbor: <span id="qet-o-priorpct">100%</span> of 2025 tax</td><td style="text-align:right" id="qet-o-prior"></td></tr>
      <tr><td>Required to avoid the penalty (smaller of the two)</td><td style="text-align:right" id="qet-o-req"></td></tr>
      <tr><td><strong>Quarterly safe-harbor minimum</strong></td><td style="text-align:right"><strong id="qet-o-qmin"></strong></td></tr>
    </tbody>
  </table>
  <p id="qet-o-note" style="font-weight:bold"></p>
  <p id="qet-o-shnote"><small></small></p>
  <div style="overflow-x:auto">
  <table style="width:100%;font-size:0.9em">
    <thead>
      <tr><th style="text-align:left">Payment</th><th style="text-align:left">Due</th><th style="text-align:right">Full</th><th style="text-align:right">Minimum</th></tr>
    </thead>
    <tbody>
      <tr><td>1<br><small>Jan 1 to Mar 31</small></td><td id="qet-d1"></td><td style="text-align:right" id="qet-a1"></td><td style="text-align:right" id="qet-m1"></td></tr>
      <tr><td>2<br><small>Apr 1 to May 31</small></td><td id="qet-d2"></td><td style="text-align:right" id="qet-a2"></td><td style="text-align:right" id="qet-m2"></td></tr>
      <tr><td>3<br><small>Jun 1 to Aug 31</small></td><td id="qet-d3"></td><td style="text-align:right" id="qet-a3"></td><td style="text-align:right" id="qet-m3"></td></tr>
      <tr><td>4<br><small>Sep 1 to Dec 31</small></td><td id="qet-d4"></td><td style="text-align:right" id="qet-a4"></td><td style="text-align:right" id="qet-m4"></td></tr>
    </tbody>
  </table>
  </div>
  <p style="margin:4px 0 0"><small>Full = your whole estimated federal tax in four equal parts. Minimum = the safe-harbor amount in four equal parts.</small></p>
  <p id="qet-o-skip"><small></small></p>
</div>

<script>
(function () {
  /*calc-start*/
  function nz(v) { return isFinite(v) && v > 0 ? v : 0; }
  function pad(n) { return (n < 10 ? "0" : "") + n; }
  function dayNum(s) {
    var m = /^\s*(\d{4})-(\d{1,2})-(\d{1,2})\s*$/.exec(s || "");
    if (!m) return null;
    var y = +m[1], mo = +m[2], d = +m[3], t = Date.UTC(y, mo - 1, d), x = new Date(t);
    if (x.getUTCFullYear() !== y || x.getUTCMonth() !== mo - 1 || x.getUTCDate() !== d) return null;
    return Math.round(t / 864e5);
  }
  function dayStr(n) { var x = new Date(n * 864e5); return x.getUTCFullYear() + "-" + pad(x.getUTCMonth() + 1) + "-" + pad(x.getUTCDate()); }
  function D(y, m, d) { return Math.round(Date.UTC(y, m - 1, d) / 864e5); }
  function wd(n) { return (((n + 4) % 7) + 7) % 7; } // 0 = Sunday; day 0 (1970-01-01) was a Thursday
  // k-th weekday `dow` of month m (1-12) in year y; k = -1 for the last one
  function nth(y, m, dow, k) {
    if (k > 0) { var f = D(y, m, 1); return f + ((dow - wd(f) + 7) % 7) + 7 * (k - 1); }
    var l = D(y, m + 1, 0); return l - ((wd(l) - dow + 7) % 7);
  }
  function obs(n) { var w = wd(n); return w === 6 ? n - 1 : w === 0 ? n + 1 : n; } // Saturday -> Friday, Sunday -> Monday
  // Legal holidays in the District of Columbia (the ones that move IRS due dates), as observed, for year y
  function holidays(y) {
    var h = [obs(D(y, 1, 1)), nth(y, 1, 1, 3), nth(y, 2, 1, 3), nth(y, 5, 1, -1), obs(D(y, 7, 4)), nth(y, 9, 1, 1),
      nth(y, 10, 1, 2), obs(D(y, 11, 11)), nth(y, 11, 4, 4), obs(D(y, 12, 25))];
    if (y >= 2005) h.push(obs(D(y, 4, 16))); // DC Emancipation Day
    if (y >= 2021) h.push(obs(D(y, 6, 19))); // Juneteenth
    if (y % 4 === 1) { var i = D(y, 1, 20); h.push(wd(i) === 0 ? i + 1 : i); } // Inauguration Day
    return h;
  }
  function isHoliday(n) { var y = new Date(n * 864e5).getUTCFullYear(); return holidays(y).concat(holidays(y + 1)).indexOf(n) >= 0; }
  function nextBiz(n) { while (wd(n) === 0 || wd(n) === 6 || isHoliday(n)) n++; return n; }
  // Estimated tax due dates for tax year y: Apr 15, Jun 15, Sep 15, Jan 15 of y+1, each moved to the next business day.
  function dueDates(y) {
    return { q: [D(y, 4, 15), D(y, 6, 15), D(y, 9, 15), D(y + 1, 1, 15)].map(function (n) { return { set: n, due: nextBiz(n) }; }),
      skip: nextBiz(D(y + 1, 1, 31)) };
  }
  // Tax from a rate schedule: tops = upper bounds of every bracket but the last, rates in %.
  function sched(ti, tops, rates) {
    var t = 0, lo = 0, top = rates[0];
    for (var i = 0; i < rates.length; i++) {
      var hi = i < tops.length ? tops[i] : Infinity;
      if (ti > lo) { t += (Math.min(ti, hi) - lo) * rates[i] / 100; top = rates[i]; }
      lo = hi;
    }
    return { tax: t, top: top };
  }
  var DEF = { ssBase: 184500, ssRate: 12.4, medRate: 2.9, nef: 92.35, minSE: 400, addRate: 0.9, addThr: { mfj: 250000, mfs: 125000, other: 200000 },
    std: { single: 16100, mfj: 32200, mfs: 16100, hoh: 24150 }, rates: [10, 12, 22, 24, 32, 35, 37],
    tops: { single: [12400, 50400, 105700, 201775, 256225, 640600], mfj: [24800, 100800, 211400, 403550, 512450, 768700],
      mfs: [12400, 50400, 105700, 201775, 256225, 384350], hoh: [17700, 67450, 105700, 201750, 256200, 640600] },
    qbiRate: 20, qbiThr: { mfj: 403500, mfs: 201775, other: 201750 }, sh90: 90, sh100: 100, sh110: 110, shAgi: 150000, shAgiMfs: 75000 };
  // o: profit, status (single|mfj|mfs|hoh|qss), w2 (your wages), w2s (spouse's wages, joint only), wh (withholding), qbi (bool),
  // state (%), ptax (2025 total tax, or null if no 2025 return), pagi (2025 AGI, or null). P: the figures above.
  function est(o, P) {
    P = P || DEF;
    var st = o.status, sch = st === "qss" ? "mfj" : st, k = st === "mfj" ? "mfj" : st === "mfs" ? "mfs" : "other";
    var profit = nz(o.profit), w2 = nz(o.w2), wages = w2 + (st === "mfj" ? nz(o.w2s) : 0);
    var ne = profit * nz(P.nef) / 100; if (ne < nz(P.minSE)) ne = 0;
    var ssRoom = Math.max(0, nz(P.ssBase) - w2), ss = Math.min(ne, ssRoom) * nz(P.ssRate) / 100, med = ne * nz(P.medRate) / 100;
    var se = ss + med, half = se / 2, thr = nz(P.addThr[k]), ar = nz(P.addRate) / 100;
    var addW = ar * Math.max(0, wages - thr), addS = ar * Math.max(0, ne - Math.max(0, thr - wages));
    var agi = profit + wages - half, std = nz(P.std[sch]), pre = Math.max(0, agi - std);
    var qbi = o.qbi ? Math.min(Math.max(0, profit - half), pre) * nz(P.qbiRate) / 100 : 0, ti = pre - qbi;
    var s = sched(ti, P.tops[sch], P.rates), total = s.tax + se + addW + addS;
    var wh = nz(o.wh), owe = Math.max(0, total - wh), state = profit * nz(o.state) / 100;
    var cur90 = total * nz(P.sh90) / 100, hasPrior = typeof o.ptax === "number" && isFinite(o.ptax) && o.ptax >= 0;
    var high = hasPrior && typeof o.pagi === "number" && isFinite(o.pagi) && o.pagi > (st === "mfs" ? nz(P.shAgiMfs) : nz(P.shAgi));
    var priorPct = high ? nz(P.sh110) : nz(P.sh100), prior = hasPrior ? o.ptax * priorPct / 100 : null;
    var required = prior === null ? cur90 : Math.min(cur90, prior);
    return { profit: profit, ne: ne, ss: ss, med: med, se: se, half: half, add: addW + addS, addW: addW, addS: addS, agi: agi, std: std,
      qbi: qbi, qbiOver: o.qbi && pre > nz(P.qbiThr[k]), ti: ti, inc: s.tax, top: s.top, total: total, wh: wh, owe: owe, state: state,
      setAside: profit > 0 ? (owe + state) / profit : null, qFull: owe / 4, cur90: cur90, priorPct: priorPct, prior: prior,
      high: high, required: required, basis: prior === null || cur90 <= prior ? "current" : high ? "prior110" : "prior100",
      qMin: Math.max(0, required - wh) / 4, under1000: owe < 1000 };
  }
  function project(ytd, months) { var m = Math.min(12, Math.max(1, Math.floor(nz(months)) || 1)); return nz(ytd) * 12 / m; }
  // "12,400, 50,400" style lists are not allowed (commas split numbers); accept "12400, 50400" or spaces
  function list(s) {
    var a = String(s || "").replace(/\$/g, "").split(/[\s,;]+/).filter(function (x) { return x !== ""; }).map(Number);
    return a.length && a.every(function (x) { return isFinite(x) && x >= 0; }) ? a : null;
  }
  /*calc-end*/
  var DAYS = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"], MON = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  function fmtDay(n) { var x = new Date(n * 864e5); return DAYS[x.getUTCDay()] + ", " + MON[x.getUTCMonth()] + " " + x.getUTCDate() + ", " + x.getUTCFullYear(); }
  function $(id) { return document.getElementById(id); }
  function num(id) { var v = parseFloat($(id).value); return isFinite(v) && v >= 0 ? v : 0; }
  function opt(id) { var s = String($(id).value).trim(), v = parseFloat(s); return s !== "" && isFinite(v) && v >= 0 ? v : null; }
  function money(n) { n = Math.round(n * 100) / 100; return (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pct(x) { return (Math.round(x * 10000) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "%"; }
  function set(id, t) { $(id).textContent = t; }
  var OUT = ["qet-o-profit", "qet-o-ne", "qet-o-ss", "qet-o-med", "qet-o-se", "qet-o-add", "qet-o-half", "qet-o-agi", "qet-o-std", "qet-o-qbi", "qet-o-ti",
    "qet-o-inc", "qet-o-marg", "qet-o-total", "qet-o-wh", "qet-o-owe", "qet-o-state", "qet-o-pct", "qet-o-per", "qet-o-q", "qet-o-90", "qet-o-prior",
    "qet-o-req", "qet-o-qmin", "qet-a1", "qet-a2", "qet-a3", "qet-a4", "qet-m1", "qet-m2", "qet-m3", "qet-m4"];
  var STAT = { single: "single", mfj: "joint", mfs: "separate", hoh: "head of household", qss: "joint" };
  function config() {
    var rates = list($("qet-rates").value), tops = {}, bad = [];
    if (!rates) bad.push("bracket rates");
    ["single", "mfj", "mfs", "hoh"].forEach(function (s) {
      var t = list($("qet-br-" + s).value) || (rates && rates.length === 1 ? [] : null), ok = t && rates && t.length === rates.length - 1;
      for (var i = 1; ok && i < t.length; i++) if (!(t[i] > t[i - 1])) ok = false;
      if (!ok) bad.push("bracket tops (" + STAT[s] + ")"); else tops[s] = t;
    });
    return { bad: bad, P: { ssBase: num("qet-ssbase"), ssRate: num("qet-ssrate"), medRate: num("qet-medrate"), nef: num("qet-nef"), minSE: num("qet-minse"),
      addRate: num("qet-addrate"), addThr: { mfj: num("qet-add-mfj"), mfs: num("qet-add-mfs"), other: num("qet-add-oth") },
      std: { single: num("qet-std-single"), mfj: num("qet-std-mfj"), mfs: num("qet-std-mfs"), hoh: num("qet-std-hoh") }, rates: rates, tops: tops,
      qbiRate: num("qet-qbirate"), qbiThr: DEF.qbiThr, sh90: num("qet-sh90"), sh100: num("qet-sh100"), sh110: num("qet-sh110"),
      shAgi: num("qet-shagi"), shAgiMfs: num("qet-shagimfs") } };
  }
  var DD = dueDates(2026);
  function update() {
    var ytd = $("qet-mode").value === "ytd";
    $("qet-profit").disabled = ytd; $("qet-ytd").disabled = !ytd; $("qet-months").disabled = !ytd;
    $("qet-w2s").disabled = $("qet-status").value !== "mfj";
    DD.q.forEach(function (q, i) { set("qet-d" + (i + 1), fmtDay(q.due)); });
    set("qet-o-skip", "You can skip payment 4 if you file your 2026 return by " + fmtDay(DD.skip) + " and pay everything you owe with it.");
    var c = config();
    if (c.bad.length) {
      OUT.forEach(function (id) { set(id, "n/a"); });
      set("qet-cfg-note", "Check the " + c.bad.join(", ") + ": enter numbers separated by commas, with one fewer bracket top than rates, rising. Write 12400, not 12,400.");
      set("qet-o-note", "Fix the 2026 figures above to see results."); set("qet-o-shnote", "");
      return;
    }
    set("qet-cfg-note", "Checked against IRS.gov and SSA.gov on Oct 20, 2026 (sources below the calculator).");
    var st = $("qet-status").value, profit = ytd ? project(num("qet-ytd"), num("qet-months")) : num("qet-profit");
    var r = est({ profit: profit, status: st, w2: num("qet-w2"), w2s: num("qet-w2s"), wh: num("qet-wh"), qbi: $("qet-qbi").checked,
      state: num("qet-state"), ptax: opt("qet-ptax"), pagi: opt("qet-pagi") }, c.P);
    set("qet-o-profit", money(r.profit) + (ytd ? " (projected)" : "")); set("qet-o-ne", money(r.ne)); set("qet-o-ss", money(r.ss));
    set("qet-o-med", money(r.med)); set("qet-o-se", money(r.se)); set("qet-o-add", money(r.add)); set("qet-o-half", "-" + money(r.half));
    set("qet-o-agi", money(r.agi)); set("qet-o-std", "-" + money(r.std)); set("qet-o-qbi", $("qet-qbi").checked ? "-" + money(r.qbi) : "not included");
    set("qet-o-ti", money(r.ti)); set("qet-o-inc", money(r.inc)); set("qet-o-marg", r.top + "%"); set("qet-o-total", money(r.total));
    set("qet-o-wh", "-" + money(r.wh)); set("qet-o-owe", money(r.owe)); set("qet-o-state", money(r.state));
    set("qet-o-pct", r.setAside === null ? "n/a" : pct(r.setAside)); set("qet-o-per", r.setAside === null ? "n/a" : money(1000 * r.setAside));
    set("qet-o-q", money(r.qFull)); set("qet-o-90", money(r.cur90)); set("qet-o-priorpct", r.priorPct + "%");
    set("qet-o-prior", r.prior === null ? "n/a (no 2025 return)" : money(r.prior)); set("qet-o-req", money(r.required)); set("qet-o-qmin", money(r.qMin));
    for (var i = 1; i <= 4; i++) { set("qet-a" + i, money(r.qFull)); set("qet-m" + i, money(r.qMin)); }
    var note;
    if (r.profit <= 0) note = "Enter your expected profit to see how much to set aside.";
    else note = "Set aside " + pct(r.setAside) + " of every payment you receive" + (r.state > 0 ? " (state included)" : "") + ". Pay " + money(r.qFull)
      + " by each due date to cover your full federal estimate, or at least " + money(r.qMin) + " to meet the safe harbor.";
    set("qet-o-note", note);
    var sh = [];
    if (r.under1000) sh.push("You expect to owe less than $1,000 after withholding, so you may not have to make estimated payments at all.");
    if (r.prior === 0) sh.push("A 2025 tax of $0 means no estimated tax is required for 2026, if 2025 was a full 12-month year and you were a US citizen or resident all year.");
    else if (r.basis === "current") sh.push("The safe harbor here is 90% of your 2026 tax" + (r.prior === null ? " (no 2025 return entered)." : ", which is lower than the 2025 option."));
    else sh.push("The safe harbor here is " + r.priorPct + "% of your 2025 tax" + (r.high ? " because your 2025 AGI was over the high-income line." : ".")
      + " Pay at least that and you avoid the penalty even if you owe more in April 2027.");
    if (r.prior !== null && opt("qet-pagi") === null) sh.push("Enter your 2025 AGI: above $150,000 ($75,000 married filing separately) the 2025 option is 110%.");
    if (r.qbiOver) sh.push("Your taxable income is above the 2026 QBI threshold, where the deduction can shrink or disappear for some businesses. Treat this estimate as a low one.");
    if (r.ss < r.ne * c.P.ssRate / 100 - 1e-9) sh.push("Your W-2 wages use up part of the Social Security wage base, so less of your profit gets the 12.4% part.");
    set("qet-o-shnote", sh.join(" "));
  }
  ["qet-profit", "qet-ytd", "qet-months", "qet-w2", "qet-w2s", "qet-wh", "qet-state", "qet-ptax", "qet-pagi", "qet-ssbase", "qet-ssrate", "qet-medrate",
    "qet-nef", "qet-minse", "qet-addrate", "qet-add-mfj", "qet-add-mfs", "qet-add-oth", "qet-std-single", "qet-std-mfj", "qet-std-mfs", "qet-std-hoh",
    "qet-rates", "qet-br-single", "qet-br-mfj", "qet-br-mfs", "qet-br-hoh", "qet-qbirate", "qet-sh90", "qet-sh100", "qet-sh110", "qet-shagi", "qet-shagimfs"
  ].forEach(function (id) { $(id).addEventListener("input", update); });
  ["qet-mode", "qet-status", "qet-qbi"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

To see where every invoice stands, the **[Freelancer Invoice & Client Tracker](https://paudrudis.gumroad.com/l/xjlrli/LAUNCH30)** (Excel and Google Sheets) logs your hours at each client's rate, works out invoice due dates, flags overdue invoices on its own, and shows invoiced vs. paid by month with a monthly tax set-aside. Still setting your prices? Try the free [freelance hourly rate calculator](freelance-hourly-rate-calculator). Client paying late? The [invoice late fee & payment terms calculator](invoice-late-fee-calculator) works out what they owe.

## Quarterly estimated tax in 2026, in plain language

### Who has to pay estimated tax

Nobody withholds tax from freelance income, so the IRS expects you to pay it during the year in four installments. According to the 2026 Form 1040-ES instructions, you generally have to pay estimated tax for 2026 if both of these are true:

1. You expect to owe at least **$1,000** for 2026 after subtracting withholding and refundable credits, and
2. Your withholding and refundable credits will be less than the smaller of **90% of your 2026 tax** or **100% of the tax on your 2025 return** (110% if your 2025 AGI was over $150,000, or $75,000 if you'll file married filing separately).

You don't have to pay estimated tax for 2026 if you had no tax liability for a full 12-month 2025 and were a US citizen or resident alien for all of 2025. Self-employment tax applies once your net earnings from self-employment reach $400, and estimated payments cover it along with income tax.

### 2026 due dates

| Payment | Covers income earned | Due |
|---|---|---|
| 1 | Jan 1 to Mar 31, 2026 | Wednesday, April 15, 2026 |
| 2 | Apr 1 to May 31, 2026 | Monday, June 15, 2026 |
| 3 | Jun 1 to Aug 31, 2026 | Tuesday, September 15, 2026 |
| 4 | Sep 1 to Dec 31, 2026 | Friday, January 15, 2027 |

If a due date falls on a Saturday, Sunday or legal holiday, the payment is on time on the next day that isn't one. All four 2026 dates already fall on business days, so none of them move. (In 2028, for example, January 15 is a Saturday and Monday the 17th is Martin Luther King Jr. Day, so the January payment for 2027 is due Tuesday, January 18, 2028.) You can skip the January 15, 2027 payment if you file your 2026 return by February 1, 2027 and pay the whole balance with it. You can pay online at [IRS.gov/payments](https://www.irs.gov/payments).

### The safe harbor: the least you can pay without a penalty

The underpayment penalty is charged per payment period, for each day a payment is short. You avoid it if your withholding plus timely estimated payments add up to at least the smaller of:

- **90%** of your 2026 tax, or
- **100%** of your 2025 tax (**110%** if your 2025 AGI was over $150,000, or $75,000 married filing separately).

The 2025 option is the predictable one: it's a number you already know, so if your income is growing you can pay a quarter of last year's tax each quarter and settle the rest in April 2027. Your withholding from a W-2 job counts as if it were paid evenly through the year. If your income is lumpy, the annualized income installment method (see Form 2210 and IRS Publication 505) can lower the early payments. Farmers and fishermen have their own rules.

### How to set aside a percentage of every invoice

1. Run the calculator with your best guess for the year and note the **set aside** percentage.
2. Open a separate savings account just for tax. Every time a client pays, move that percentage of the payment into it the same day, before you spend anything.
3. Pay each quarter's amount from that account by the due date.
4. Once a quarter, switch to "So far this year" and enter your profit to date. If the percentage moves, use the new one from then on.
5. Keep any state estimated tax in the same account. Most states that have an income tax run their own estimated payments; check your state's tax agency for its dates.

With the example numbers ($60,000 of profit, single, no other job, QBI deduction included), the calculator suggests setting aside **20.06%**, about $501.55 of a $2,500 invoice. That's $12,037.20 of federal tax for the year, or about $3,009.30 a quarter. The safe-harbor minimum is $2,250.00 a quarter (100% of a $9,000 2025 tax).

## How the numbers are worked out

```
net earnings from SE  = profit x 92.35%  (no SE tax if under $400)
Social Security part  = 12.4% x the smaller of net earnings and
                        (wage base $184,500 - your W-2 wages), not below 0
Medicare part         = 2.9% x net earnings
SE tax                = Social Security part + Medicare part
Additional Medicare   = 0.9% x (W-2 wages + net earnings - threshold), not below 0
                        threshold: $250,000 joint, $125,000 separate, $200,000 others
AGI                   = profit + W-2 wages - SE tax / 2
taxable income        = AGI - standard deduction - QBI deduction
QBI deduction         = 20% x the smaller of (profit - SE tax / 2)
                        and (AGI - standard deduction)
income tax            = 2026 rate schedule for your filing status
total federal tax     = income tax + SE tax + Additional Medicare
still to pay          = total federal tax - W-2 withholding
set aside %           = (still to pay + state rate x profit) / profit
quarterly payment     = still to pay / 4
safe harbor           = smaller of 90% x 2026 tax and 100% (or 110%) x 2025 tax
quarterly minimum     = (safe harbor - W-2 withholding) / 4
so far this year      = profit to date x 12 / months
```

What it leaves out, so you can adjust: itemized deductions, tax credits (child tax credit and others), the newer deductions for tips, overtime, car loan interest and seniors, health insurance and retirement contributions you deduct as self-employed, capital gains and the net investment income tax, local taxes, and state tax tables (the state rate is a flat percentage you choose). If both spouses are self-employed, Form 1040-ES says to figure SE tax for each of you separately; this calculator handles one self-employed person. It uses one W-2 wages number for both income tax and the Social Security wage base, so if box 1 and box 3 of your W-2 differ a lot (for example because of 401(k) contributions), the estimate will be a little off.

The QBI deduction is simplified. Above $201,750 of taxable income ($403,500 joint, $201,775 married filing separately) it can be limited or phased out, especially for service businesses. Starting in 2026 there's also a minimum $400 deduction if you have at least $1,000 of qualified business income from an active trade or business, which isn't modeled here.

## 2026 figures and sources

All checked on IRS.gov and SSA.gov on October 20, 2026. Every figure can be changed under "2026 figures used" in the calculator.

- **Tax brackets and standard deduction** ($16,100 single and married filing separately, $32,200 joint, $24,150 head of household): [Rev. Proc. 2025-32](https://www.irs.gov/pub/irs-drop/rp-25-32.pdf), sections .01 and .14, and the [IRS announcement of the 2026 inflation adjustments](https://www.irs.gov/newsroom/irs-releases-tax-inflation-adjustments-for-tax-year-2026-including-amendments-from-the-one-big-beautiful-bill). The same rate schedules are printed in the [2026 Form 1040-ES](https://www.irs.gov/pub/irs-pdf/f1040es.pdf).
- **Self-employment tax** (92.35%, 12.4%, 2.9%) and the **$184,500 Social Security maximum**: the 2026 Self-Employment Tax and Deduction Worksheet in the [2026 Form 1040-ES](https://www.irs.gov/pub/irs-pdf/f1040es.pdf); wage base also on SSA's [contribution and benefit base](https://www.ssa.gov/oact/cola/cbb.html) table.
- **Additional Medicare Tax** (0.9% over $200,000, $250,000 joint, $125,000 separate): [IRS questions and answers on the Additional Medicare Tax](https://www.irs.gov/businesses/small-businesses-self-employed/questions-and-answers-for-the-additional-medicare-tax).
- **Due dates, who must pay, and the 90% / 100% / 110% safe harbor**: [2026 Form 1040-ES](https://www.irs.gov/pub/irs-pdf/f1040es.pdf).
- **Weekend and holiday rule**: [IRS estimated taxes page](https://www.irs.gov/businesses/small-businesses-self-employed/estimated-taxes) and [Publication 509](https://www.irs.gov/pub/irs-pdf/p509.pdf), which counts legal holidays in the District of Columbia, including Emancipation Day on April 16.
- **QBI thresholds** ($201,750, $403,500 joint, $201,775 separate): [Rev. Proc. 2025-32](https://www.irs.gov/pub/irs-drop/rp-25-32.pdf), section .26.

## FAQ

### What percentage of freelance income should I set aside for taxes?

It depends on your profit, filing status and other income, which is why the calculator works it out instead of guessing. Self-employment tax alone is about 14.1% of profit (15.3% of 92.35%) up to the Social Security wage base, and federal income tax comes on top. With the example numbers above it comes to about 20%; with more profit, a W-2 job pushing you into a higher bracket, or state tax, 30% or more is common.

### I have a W-2 job too. Do I still need to pay quarterly?

Maybe not. If your paycheck withholding already covers the safe harbor, you won't owe a penalty. You can also give your employer a new Form W-4 to withhold more instead of making estimated payments. Enter your wages and withholding above to see where you stand.

### What happens if I miss a payment or pay too little?

You may owe an underpayment penalty, figured like interest on the amount that was short for the days it was late. Paying late is cheaper than not paying, so catch up as soon as you can. Form 2210 works out the exact penalty.

### Can I pay more than four times?

Yes. The IRS accepts more frequent payments as long as each period's total reaches the amount due by that period's deadline. Some freelancers pay a little after every invoice.

More tools and guides: [all guides and free tools](./).

*Not tax advice. Not affiliated with the IRS.*
