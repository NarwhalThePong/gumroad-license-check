---
layout: page
title: "Invoice late fee calculator: due date, late fee, interest and 2/10 Net 30 discounts"
description: "Free invoice late fee and payment terms calculator. Enter the invoice amount, date and terms (Net 7, 15, 30, 45, 60 or due on receipt) to see the due date, how many days late a payment is, the late fee or interest, the total due and the effective annual rate. Also works out early-payment discounts like 2/10 Net 30."
---

Work out when an invoice is due and what a late payment costs. Enter the invoice amount, the invoice date and your payment terms, then the date it was paid (or leave it as today if it's still open). The calculator shows the **due date**, **days late**, the **late fee or interest**, the **total due** and the **effective annual rate** of the fee. Below it, a second panel prices an early-payment discount such as **2/10 Net 30**. Everything runs in your browser and nothing is sent anywhere.

<div id="ilf" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:720px">
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Invoice amount ($)<br><input id="ilf-amt" type="number" min="0" step="0.01" value="1000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Invoice date<br><input id="ilf-inv" type="date" value="" style="width:100%;max-width:180px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment terms<br><select id="ilf-terms" style="width:100%;max-width:180px">
      <option value="0">Due on receipt</option>
      <option value="7">Net 7</option>
      <option value="15">Net 15</option>
      <option value="30" selected>Net 30</option>
      <option value="45">Net 45</option>
      <option value="60">Net 60</option>
      <option value="custom">Custom number of days</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Custom days (used when terms are Custom)<br><input id="ilf-custom" type="number" min="0" step="1" value="90" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Date paid<br><input id="ilf-paid" type="date" value="" style="width:100%;max-width:180px"></label><br>
      <label><input id="ilf-today" type="checkbox" checked> Not paid yet, use today</label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Late fee type<br><select id="ilf-type" style="width:100%;max-width:220px">
      <option value="flat">Flat fee (one time)</option>
      <option value="msimple" selected>% per month, simple</option>
      <option value="annual">% per year, charged daily</option>
      <option value="mcomp">% per month, compounding</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Late fee rate (<span id="ilf-rate-unit">% per month</span>)<br><input id="ilf-rate" type="number" min="0" step="0.1" value="1.5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Flat fee ($, for the flat fee type)<br><input id="ilf-flat" type="number" min="0" step="1" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Grace period (days after the due date)<br><input id="ilf-grace" type="number" min="0" step="1" value="0" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>After the grace period, charge from<br><select id="ilf-from" style="width:100%;max-width:220px">
      <option value="due" selected>the due date</option>
      <option value="grace">the end of the grace period</option>
    </select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cap on the late fee ($, optional)<br><input id="ilf-cap" type="number" min="0" step="1" value="" placeholder="no cap" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><small>Days are calendar days, weekends and holidays included. Monthly fees count each started 30-day period after the fee starts as a month.</small></p>
  <table style="width:100%">
    <tbody>
      <tr><td>Due date</td><td style="text-align:right" id="ilf-o-due"></td></tr>
      <tr><td>Paid (or today)</td><td style="text-align:right" id="ilf-o-paid"></td></tr>
      <tr><td>Days late</td><td style="text-align:right" id="ilf-o-late"></td></tr>
      <tr><td>How the fee is worked out</td><td style="text-align:right" id="ilf-o-basis"></td></tr>
      <tr><td><strong>Late fee</strong></td><td style="text-align:right"><strong id="ilf-o-fee"></strong></td></tr>
      <tr><td><strong>Total due</strong></td><td style="text-align:right"><strong id="ilf-o-total"></strong></td></tr>
      <tr><td>Effective annual rate of the fee</td><td style="text-align:right" id="ilf-o-ear"></td></tr>
    </tbody>
  </table>
  <p id="ilf-o-note" style="font-weight:bold"></p>
  <hr>
  <p><strong>Early-payment discount</strong> (same invoice amount and date as above)</p>
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 140px;margin:0 0 8px"><label>Discount (%)<br><input id="ilf-dp" type="number" min="0" max="99" step="0.5" value="2" inputmode="decimal" style="width:100%;max-width:120px"></label></p>
    <p style="flex:1 1 140px;margin:0 0 8px"><label>If paid within (days)<br><input id="ilf-dn" type="number" min="0" step="1" value="10" inputmode="numeric" style="width:100%;max-width:120px"></label></p>
    <p style="flex:1 1 140px;margin:0 0 8px"><label>Otherwise due in (days)<br><input id="ilf-dN" type="number" min="0" step="1" value="30" inputmode="numeric" style="width:100%;max-width:120px"></label></p>
  </div>
  <table style="width:100%">
    <tbody>
      <tr><td>Terms</td><td style="text-align:right" id="ilf-d-terms"></td></tr>
      <tr><td>Discount amount</td><td style="text-align:right" id="ilf-d-amt"></td></tr>
      <tr><td>Client pays if they take the discount</td><td style="text-align:right" id="ilf-d-pay"></td></tr>
      <tr><td>Discount deadline</td><td style="text-align:right" id="ilf-d-by"></td></tr>
      <tr><td><strong>Annualized cost of skipping the discount</strong></td><td style="text-align:right"><strong id="ilf-d-cost"></strong></td></tr>
      <tr><td>Same, compounded</td><td style="text-align:right" id="ilf-d-comp"></td></tr>
    </tbody>
  </table>
  <p id="ilf-d-note"><small></small></p>
</div>

<script>
(function () {
  /*calc-start*/
  function nz(v) { return isFinite(v) && v > 0 ? v : 0; }
  function pad(n) { return (n < 10 ? "0" : "") + n; }
  // "YYYY-MM-DD" -> whole day number (days since 1970-01-01, UTC), or null if it isn't a real date.
  function dayNum(s) {
    var m = /^\s*(\d{4})-(\d{1,2})-(\d{1,2})\s*$/.exec(s || "");
    if (!m) return null;
    var y = +m[1], mo = +m[2], d = +m[3], t = Date.UTC(y, mo - 1, d), x = new Date(t);
    if (x.getUTCFullYear() !== y || x.getUTCMonth() !== mo - 1 || x.getUTCDate() !== d) return null;
    return Math.round(t / 864e5);
  }
  function dayStr(n) { var x = new Date(n * 864e5); return x.getUTCFullYear() + "-" + pad(x.getUTCMonth() + 1) + "-" + pad(x.getUTCDate()); }
  // o: amount, inv and paid (day numbers), terms (days), type (flat|msimple|annual|mcomp), rate (%), flat ($), grace (days),
  // from (due|grace), cap ($ or null).
  function late(o) {
    var A = nz(o.amount), due = o.inv + Math.floor(nz(o.terms)), diff = o.paid - due, g = Math.floor(nz(o.grace));
    var daysLate = Math.max(0, diff), applies = daysLate > g, days = applies ? (o.from === "grace" ? daysLate - g : daysLate) : 0;
    var r = nz(o.rate) / 100, months = Math.ceil(days / 30), fee = 0;
    if (applies) {
      if (o.type === "flat") fee = nz(o.flat);
      else if (o.type === "msimple") fee = A * r * months;
      else if (o.type === "annual") fee = A * r * days / 365;
      else if (o.type === "mcomp") fee = A * (Math.pow(1 + r, months) - 1);
    }
    var capped = false;
    if (o.cap !== null && o.cap !== undefined && isFinite(o.cap) && o.cap >= 0 && fee > o.cap) { fee = o.cap; capped = true; }
    return { due: due, daysLate: daysLate, early: diff < 0 ? -diff : 0, applies: applies, days: days, months: months, fee: fee,
      capped: capped, total: A + fee, ear: daysLate > 0 && A > 0 ? fee / A * 365 / daysLate : null };
  }
  // Early-payment discount d% if paid within n days, otherwise net N days.
  function disc(o) {
    var A = nz(o.amount), d = Math.min(nz(o.pct), 99) / 100, n = Math.floor(nz(o.n)), N = Math.floor(nz(o.N)), ok = N > n && d > 0;
    return { amt: A * d, pay: A * (1 - d), cost: ok ? (d / (1 - d)) * (365 / (N - n)) : null,
      comp: ok ? Math.pow(1 + d / (1 - d), 365 / (N - n)) - 1 : null };
  }
  /*calc-end*/
  var DAYS = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"], MON = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
  function fmtDay(n) { var x = new Date(n * 864e5); return DAYS[x.getUTCDay()] + ", " + MON[x.getUTCMonth()] + " " + x.getUTCDate() + ", " + x.getUTCFullYear(); }
  function today() { var t = new Date(); return Math.round(Date.UTC(t.getFullYear(), t.getMonth(), t.getDate()) / 864e5); }
  function $(id) { return document.getElementById(id); }
  function num(id) { var v = parseFloat($(id).value); return isFinite(v) && v >= 0 ? v : 0; }
  function money(n) { n = Math.round(n * 100) / 100; return (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function pct(x) { return (Math.round(x * 10000) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + "%"; }
  function plural(n, w) { return n.toLocaleString("en-US") + " " + w + (n === 1 ? "" : "s"); }
  function set(id, t) { $(id).textContent = t; }
  var OUT = ["ilf-o-due", "ilf-o-paid", "ilf-o-late", "ilf-o-basis", "ilf-o-fee", "ilf-o-total", "ilf-o-ear", "ilf-d-by"];
  function update() {
    var type = $("ilf-type").value, tv = $("ilf-terms").value, terms = tv === "custom" ? num("ilf-custom") : parseFloat(tv) || 0;
    set("ilf-rate-unit", type === "annual" ? "% per year" : "% per month");
    $("ilf-paid").disabled = $("ilf-today").checked;
    var A = num("ilf-amt"), inv = dayNum($("ilf-inv").value), paid = $("ilf-today").checked ? today() : dayNum($("ilf-paid").value);
    var capV = parseFloat($("ilf-cap").value), cap = isFinite(capV) && capV >= 0 ? capV : null;
    var D = disc({ amount: A, pct: num("ilf-dp"), n: num("ilf-dn"), N: num("ilf-dN") });
    var dn = Math.floor(num("ilf-dn")), dN = Math.floor(num("ilf-dN"));
    set("ilf-d-terms", (Math.round(num("ilf-dp") * 100) / 100) + "/" + dn + " Net " + dN);
    set("ilf-d-amt", money(D.amt)); set("ilf-d-pay", money(D.pay));
    set("ilf-d-cost", D.cost === null ? "n/a" : pct(D.cost)); set("ilf-d-comp", D.comp === null ? "n/a" : pct(D.comp));
    set("ilf-d-note", D.cost === null ? "Enter a discount above zero and a net period longer than the discount period."
      : "A client who skips the discount keeps " + money(D.pay) + " for " + plural(dN - dn, "more day") + " at a cost of " + money(D.amt)
        + ", which works out to " + pct(D.cost) + " a year. If their money costs them less than that, taking the discount is the better deal for them.");
    if (inv === null || paid === null) {
      OUT.forEach(function (id) { set(id, "n/a"); });
      set("ilf-o-note", inv === null ? "Enter the invoice date." : "Enter the date the invoice was paid, or tick \"use today\".");
      return;
    }
    set("ilf-d-by", fmtDay(inv + dn));
    var r = late({ amount: A, inv: inv, paid: paid, terms: terms, type: type, rate: num("ilf-rate"), flat: num("ilf-flat"),
      grace: num("ilf-grace"), from: $("ilf-from").value, cap: cap });
    set("ilf-o-due", fmtDay(r.due)); set("ilf-o-paid", fmtDay(paid)); set("ilf-o-late", r.early ? "0 (" + plural(r.early, "day") + " early)" : r.daysLate.toLocaleString("en-US"));
    var basis;
    if (!r.applies) basis = r.daysLate > 0 ? "inside the grace period" : "not late";
    else if (type === "flat") basis = "flat fee";
    else if (type === "annual") basis = num("ilf-rate") + "% a year x " + plural(r.days, "day") + " / 365";
    else basis = num("ilf-rate") + "% x " + plural(r.months, "month") + (type === "mcomp" ? ", compounding" : "");
    set("ilf-o-basis", basis + (r.capped ? " (capped)" : ""));
    set("ilf-o-fee", money(r.fee)); set("ilf-o-total", money(r.total)); set("ilf-o-ear", r.ear === null ? "n/a" : pct(r.ear));
    var note;
    if (paid < inv) note = "The payment date is before the invoice date. Check the dates.";
    else if (r.early) note = "Paid " + plural(r.early, "day") + " before the due date. No late fee.";
    else if (r.daysLate === 0) note = "Paid on the due date. No late fee.";
    else if (!r.applies) note = plural(r.daysLate, "day") + " late, still inside the " + Math.floor(num("ilf-grace")) + "-day grace period. No late fee yet.";
    else note = plural(r.daysLate, "day") + " late. Late fee " + money(r.fee) + (r.capped ? " (held at your cap)" : "") + ", total due " + money(r.total) + ".";
    set("ilf-o-note", note);
  }
  if (dayNum($("ilf-inv").value) === null) $("ilf-inv").value = dayStr(today() - 45);
  if (dayNum($("ilf-paid").value) === null) $("ilf-paid").value = dayStr(today());
  ["ilf-amt", "ilf-inv", "ilf-custom", "ilf-paid", "ilf-rate", "ilf-flat", "ilf-grace", "ilf-cap", "ilf-dp", "ilf-dn", "ilf-dN"].forEach(function (id) {
    $(id).addEventListener("input", update); });
  ["ilf-terms", "ilf-today", "ilf-type", "ilf-from", "ilf-inv", "ilf-paid"].forEach(function (id) { $(id).addEventListener("change", update); });
  update();
})();
</script>

To keep on top of who owes you what, the **[Freelancer Invoice & Client Tracker](https://paudrudis.gumroad.com/l/xjlrli)** (Excel and Google Sheets) works out invoice due dates from your payment terms, flags overdue invoices on its own, logs hours at each client's rate, and shows invoiced vs. paid by month with a monthly tax set-aside. Not sure what to charge in the first place? Try the free [freelance hourly rate calculator](freelance-hourly-rate-calculator). And to know how much of each payment to keep for tax, there's the [quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator).

## How the numbers are worked out

```
due date          = invoice date + terms (calendar days; due on receipt = 0)
days late         = date paid - due date (0 if paid on time)
no fee while        days late <= grace period
fee days          = days late (from the due date)
                    or days late - grace (from the end of the grace period)
months            = fee days / 30, rounded up (each started 30 days counts)
flat fee          = the flat amount, once
% per month       = invoice x rate x months
% per year, daily = invoice x rate x fee days / 365
% per month, compounding = invoice x ((1 + rate) ^ months - 1)
late fee          = the smaller of the fee and your cap
total due         = invoice + late fee
effective annual rate = late fee / invoice x 365 / days late
early-payment discount d/n Net N:
  discount        = invoice x d
  annualized cost of skipping = (d / (1 - d)) x (365 / (N - n))
  compounded      = (1 + d / (1 - d)) ^ (365 / (N - n)) - 1
```

Example: a $1,000 invoice dated Jan 31, 2026 on Net 30 is due Mon, Mar 2, 2026 (February 2026 has 28 days). Paid on Apr 1, it's 30 days late: 1.5% a month comes to $15.00, and 18% a year charged daily comes to $14.79. On 2/10 Net 30 the client saves $20.00 by paying within 10 days, and skipping that discount costs them about 37.24% a year.

The effective annual rate shows what a fee really amounts to. A flat $25 fee on a $1,000 invoice paid 5 days late is 2.5% for 5 days, or 182.50% a year, which is the kind of number rules on late fees and interest tend to look at.

## How to write late fee terms on an invoice

Put the terms in your contract or proposal before the work starts, and repeat them on every invoice. Clients rarely argue with a fee they agreed to up front; a fee that first shows up on an overdue invoice is much harder to collect.

- **Give the due date as a date.** "Due March 2, 2026 (Net 30)" leaves less room for argument than "Net 30" on its own.
- **Say exactly how the fee works:** a flat amount or a percentage, per month or per year, whether it compounds, when it starts, and any grace period.
- **Say what it applies to,** usually the unpaid balance only.
- **Send a friendly reminder** a few days before the due date and on the day it's missed. Most late payments are forgotten invoices, not refusals.
- **Be consistent.** If you waive the fee, say so in writing so it doesn't become the new default.

Example wording, with numbers you should replace with your own: *"Payment is due within 30 days of the invoice date. Balances not paid by the due date incur a late fee of [rate]% per month on the unpaid amount, starting [number] days after the due date."*

**Legal limits on late fees and interest vary by US state and by country.** Many places cap the interest rate you can charge, treat business and consumer customers differently, or only allow a fee the customer agreed to in advance. Check the rules where you and your client are, or ask a lawyer or accountant, before you set a rate. This page explains the math only and is not legal advice.

One example of how this differs by country: in the UK, a business paid late by another business can claim "statutory interest" of 8% plus the Bank of England base rate, but not if the contract sets a different interest rate, and can also claim a fixed debt recovery sum of £40, £70 or £100 depending on the size of the debt (checked on GOV.UK in October 2026: [interest on late commercial payments](https://www.gov.uk/late-commercial-payments-interest-debt-recovery/charging-interest-commercial-debt) and [claiming debt recovery costs](https://www.gov.uk/late-commercial-payments-interest-debt-recovery/claim-debt-recovery-costs)). For UK statutory interest, choose "% per year, charged daily" above and enter 8% plus the current base rate.

## FAQ

### What does Net 30 mean?

The invoice is due 30 calendar days after the invoice date. Net 15, Net 45 and Net 60 work the same way, and "due on receipt" means it's due on the invoice date. Weekends and holidays count, so check whether the due date lands on a non-business day.

### What does 2/10 Net 30 mean?

The client can take 2% off if they pay within 10 days; otherwise the full amount is due in 30 days. Skipping the discount means paying 2% more to keep the money 20 days longer, which works out to about 37% a year, so many businesses with cash on hand take it.

### Is 1.5% a month the same as 18% a year?

Close, but not quite. Charged as simple interest, 1.5% a month for 12 months is 18%. If it compounds monthly, a year comes to (1.015)^12 - 1, about 19.56%. And "per started month" rounding means a payment 31 days late is charged two months at 1.5%.

### Should I charge a flat fee or a percentage?

A flat fee is simple and easy to understand, but on large invoices it's small and on very small invoices its effective annual rate can be very high. A monthly percentage scales with the invoice. Some people use the greater of the two; whichever you pick, put it in writing before the work starts.

### Does a grace period mean the fee starts later?

It depends on your wording, which is why the calculator lets you choose. With "from the due date", a payment one day past the grace period is charged for every day since the due date. With "from the end of the grace period", only the days after the grace period count.

More tools and guides: [all guides and free tools](./).

*Not legal or tax advice.*
