---
layout: page
title: "Freelance hourly rate calculator: what to charge to hit your income goal"
description: "Free freelance rate calculator. Enter the income you want to take home, your business costs, time off and how many hours you can actually bill, and see the hourly rate, day rate and monthly revenue you need. Or check what a rate you already charge works out to per year."
---

Work out what to charge as a freelancer. Enter the yearly income you want to take home, what your business costs to run, how much time off you plan, and how many of your working hours you can actually bill to clients. The calculator works backwards to the **hourly rate**, **day rate** and **monthly revenue** you need, after tax and expenses. You can also check a rate you already charge to see what it pays you over a year. Everything runs in your browser and nothing is sent anywhere.

<!-- paid-cta -->
> **Planning the whole tax year?** The [Freelancer Quarterly Tax Planner 2026 (Excel + Google Sheets)](https://payhip.com/b/UspdI) ($9) logs each payment and expense, works out how much of every dollar to set aside, the safe-harbor and full quarterly payments, and tracks what you've paid against the 2026 due dates. *Our own paid product; not tax advice.*

<div id="frc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0;max-width:720px">
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Income you want to take home per year, after tax ($)<br><input id="frc-take" type="number" min="0" step="100" value="60000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Business costs per year ($)<br><input id="frc-exp" type="number" min="0" step="100" value="6000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Estimated tax rate on profit (%)<br><input id="frc-tax" type="number" min="0" max="90" step="0.5" value="30" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Weeks off per year (vacation, holidays, sick)<br><input id="frc-off" type="number" min="0" max="51" step="1" value="6" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Hours you work per week<br><input id="frc-hpw" type="number" min="0" max="100" step="1" value="40" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Share of those hours you can bill (%)<br><input id="frc-bill" type="number" min="1" max="100" step="1" value="65" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Buffer for slow months and unpaid invoices (%)<br><input id="frc-buf" type="number" min="0" max="90" step="1" value="10" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Billable hours in a full client day<br><input id="frc-day" type="number" min="1" max="24" step="0.5" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px"><small>Business costs are things like software, equipment, insurance, accounting, a coworking desk and health insurance you pay yourself. Non-billable hours are sales, admin, invoicing and learning. The tax rate is your own rough estimate of income tax plus any self-employment tax on profit; it is not tax advice.</small></p>
  <table style="width:100%">
    <tbody>
      <tr><td>Profit you need before tax</td><td style="text-align:right" id="frc-o-pre"></td></tr>
      <tr><td>Revenue you need per year (profit + costs + buffer)</td><td style="text-align:right" id="frc-o-rev"></td></tr>
      <tr><td>Working weeks per year</td><td style="text-align:right" id="frc-o-weeks"></td></tr>
      <tr><td>Billable hours per year</td><td style="text-align:right" id="frc-o-hours"></td></tr>
      <tr><td><strong>Hourly rate you need</strong></td><td style="text-align:right"><strong id="frc-o-rate"></strong></td></tr>
      <tr><td>Day rate</td><td style="text-align:right" id="frc-o-dayrate"></td></tr>
      <tr><td>Revenue you need per working week</td><td style="text-align:right" id="frc-o-week"></td></tr>
      <tr><td>Revenue you need per month (yearly / 12)</td><td style="text-align:right" id="frc-o-month"></td></tr>
      <tr><td>Set aside for tax per year</td><td style="text-align:right" id="frc-o-taxamt"></td></tr>
    </tbody>
  </table>
  <p id="frc-o-note" style="font-weight:bold"></p>
  <hr>
  <p><strong>Check a rate you charge</strong> (same hours, costs, tax and buffer as above)</p>
  <div style="display:flex;flex-wrap:wrap;gap:4px 24px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Your hourly rate ($)<br><input id="frc-cr" type="number" min="0" step="1" value="75" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <table style="width:100%">
    <tbody>
      <tr><td>Revenue you'd collect per year (after the buffer)</td><td style="text-align:right" id="frc-c-rev"></td></tr>
      <tr><td>Profit before tax (after costs)</td><td style="text-align:right" id="frc-c-pre"></td></tr>
      <tr><td><strong>Take-home per year, after tax</strong></td><td style="text-align:right"><strong id="frc-c-take"></strong></td></tr>
      <tr><td>Take-home per month</td><td style="text-align:right" id="frc-c-month"></td></tr>
      <tr><td>Take-home per hour you work (billable or not)</td><td style="text-align:right" id="frc-c-perhr"></td></tr>
    </tbody>
  </table>
  <p id="frc-c-note"><small></small></p>
</div>

<script>
(function () {
  /*calc-start*/
  function nz(v) { return isFinite(v) && v > 0 ? v : 0; }
  function clampPct(v, max) { return Math.min(nz(v), max) / 100; }
  function hours(o) {
    var weeks = Math.max(0, 52 - Math.min(nz(o.off), 52));
    return { weeks: weeks, worked: weeks * nz(o.hpw), billable: weeks * nz(o.hpw) * clampPct(o.bill, 100) };
  }
  // Rate needed so that, after the buffer, costs and tax, you take home o.take per year.
  function need(o) {
    var t = clampPct(o.tax, 90), b = clampPct(o.buf, 90), h = hours(o);
    var pre = nz(o.take) / (1 - t), rev = (pre + nz(o.exp)) / (1 - b);
    var rate = h.billable > 0 ? rev / h.billable : null;
    return { pre: pre, rev: rev, weeks: h.weeks, hours: h.billable, rate: rate, day: rate === null ? null : rate * nz(o.day),
      week: h.weeks > 0 ? rev / h.weeks : null, month: rev / 12, taxAmt: pre * t };
  }
  // What a given hourly rate pays you per year with the same assumptions.
  function check(o, rate) {
    var t = clampPct(o.tax, 90), b = clampPct(o.buf, 90), h = hours(o);
    var rev = nz(rate) * h.billable * (1 - b), pre = rev - nz(o.exp);
    var take = pre > 0 ? pre * (1 - t) : pre;
    return { rev: rev, pre: pre, take: take, month: take / 12, perHr: h.worked > 0 ? take / h.worked : null };
  }
  /*calc-end*/
  function $(id) { return document.getElementById(id); }
  function num(id) { var v = parseFloat($(id).value); return isFinite(v) && v >= 0 ? v : 0; }
  function money(n) { n = Math.round(n * 100) / 100; return (n < 0 ? "-$" : "$") + Math.abs(n).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
  function whole(n) { return Math.round(n).toLocaleString("en-US"); }
  function set(id, t) { $(id).textContent = t; }
  function update() {
    var o = { take: num("frc-take"), exp: num("frc-exp"), tax: num("frc-tax"), off: num("frc-off"), hpw: num("frc-hpw"),
      bill: num("frc-bill"), buf: num("frc-buf"), day: num("frc-day") };
    var n = need(o);
    set("frc-o-pre", money(n.pre)); set("frc-o-rev", money(n.rev)); set("frc-o-weeks", whole(n.weeks)); set("frc-o-hours", whole(n.hours));
    set("frc-o-rate", n.rate === null ? "n/a" : money(Math.ceil(n.rate * 100 - 1e-7) / 100));
    set("frc-o-dayrate", n.day === null ? "n/a" : money(Math.ceil(n.day * 100 - 1e-7) / 100));
    set("frc-o-week", n.week === null ? "n/a" : money(n.week)); set("frc-o-month", money(n.month)); set("frc-o-taxamt", money(n.taxAmt));
    set("frc-o-note", n.rate === null ? "Enter working weeks, hours and a billable share above zero to get a rate."
      : "Charge at least " + money(Math.ceil(n.rate * 100 - 1e-7) / 100) + " an hour to take home " + money(o.take) + " a year with "
        + whole(n.hours) + " billable hours.");
    var c = check(o, num("frc-cr"));
    set("frc-c-rev", money(c.rev)); set("frc-c-pre", money(c.pre)); set("frc-c-take", money(c.take)); set("frc-c-month", money(c.month));
    set("frc-c-perhr", c.perHr === null ? "n/a" : money(c.perHr));
    set("frc-c-note", c.pre < 0 ? "At this rate your costs are higher than what you collect, so you lose money before tax."
      : "Tax is only applied when profit is above zero. Per-hour take-home divides by every hour you work, billable or not.");
  }
  ["frc-take", "frc-exp", "frc-tax", "frc-off", "frc-hpw", "frc-bill", "frc-buf", "frc-day", "frc-cr"].forEach(function (id) {
    $(id).addEventListener("input", update); });
  update();
})();
</script>

Once you've set a rate, keep track of what you bill. The **[Freelancer Invoice & Client Tracker](https://paudrudis.gumroad.com/l/xjlrli)** (Excel and Google Sheets) logs your hours at each client's rate, works out invoice due dates from your payment terms, flags overdue invoices on its own, and shows invoiced vs. paid by month with a monthly tax set-aside.

To plan the tax side for the whole year, the **[Freelancer Quarterly Tax Planner 2026](https://payhip.com/b/UspdI)** (Excel and Google Sheets, $9) logs each payment and expense, works out the share of every dollar to set aside, the safe-harbor and full quarterly payments, and tracks what you've paid against the 2026 due dates.

*Disclosure: the Freelancer Invoice & Client Tracker and the Freelancer Quarterly Tax Planner 2026 are our own paid products, and we earn the sale price if you buy one.*

## How the numbers are worked out

```
profit before tax  = take-home / (1 - tax rate)
revenue needed     = (profit before tax + business costs) / (1 - buffer)
working weeks      = 52 - weeks off
billable hours     = working weeks * hours per week * billable share
hourly rate        = revenue needed / billable hours
day rate           = hourly rate * billable hours in a client day
check a rate:
  revenue          = rate * billable hours * (1 - buffer)
  take-home        = (revenue - business costs) * (1 - tax rate)
```

With the starting values (take home $60,000, $6,000 of costs, 30% tax, 6 weeks off, 40 hours a week, 65% billable, 10% buffer) you need about $101,905 of revenue over 1,196 billable hours, which is **$85.21 an hour** or $681.64 for an 8-hour day.

The tax rate is a single flat estimate to keep the math simple. Real income tax is progressive, and in the US self-employed people also pay self-employment tax for Social Security and Medicare (the free [self-employment tax calculator (2026)](self-employment-tax-calculator) shows that part on its own), so ask a tax professional or use your last return to pick a realistic number. *Not tax or financial advice.*

## FAQ

### How do I calculate my freelance hourly rate?

Start from the income you want to take home, add back tax to get the profit you need, add your business costs, then divide by the hours you can actually bill in a year. The mistake most people make is dividing by every hour they work: a lot of freelance time goes to finding clients, admin and invoicing, which nobody pays for.

### What share of my hours can I bill?

It depends on the work, but many freelancers bill somewhere around half to three quarters of their working hours, and less when they're starting out and spending more time finding clients. If you're not sure, track a few weeks of your time and use the real number.

### Why add a buffer?

Some months are slow, some clients pay late and a few never pay. A buffer of 5 to 15% of revenue covers those gaps so one bad month doesn't wipe out your income goal.

### How do I turn an hourly rate into a project price?

Estimate the billable hours the project will take, multiply by your hourly rate, and add a margin for revisions and scope creep. The day rate above is a quick way to quote work that's priced by the day.

### How does a freelance rate compare with a salary?

A salary hides costs an employer pays for you, such as paid time off, equipment, and in the US the employer's half of Social Security and Medicare. That's why a freelance hourly rate has to be well above a salary divided by 2,080 hours. Enter the salary you'd take home as an employee under "Income you want to take home" to see the rate that matches it.

Once you're sending invoices, the free [invoice late fee & payment terms calculator](invoice-late-fee-calculator) works out due dates, late fees and early-payment discounts like 2/10 Net 30. To see how much of each payment to put aside for tax and what to send the IRS each quarter, use the free [quarterly estimated tax calculator for freelancers](freelance-quarterly-estimated-tax-calculator). For just the 15.3% Social Security and Medicare part, see the [self-employment tax calculator (2026)](self-employment-tax-calculator).
Selling services on a marketplace instead? The free [Fiverr fee calculator (2026)](fiverr-fee-calculator) shows Fiverr's flat 20% cut, the withdrawal fee by payout method, and the price to charge to keep a set amount.

Freelancing on Upwork? The free [Upwork fee calculator (2026)](upwork-fee-calculator) shows the 0% to 15% service fee on your contract, Connects and withdrawal costs, and the rate to bill to keep a set amount.

To send and track those invoices, compare [freelance invoicing software: FreshBooks vs Bonsai vs HoneyBook vs Wave (2026)](freelance-invoicing-software-freshbooks-bonsai-honeybook-wave).

Traveling for work? The free [self-employed per diem meal deduction calculator (2026)](self-employed-per-diem-meal-deduction-calculator) finds the IRS standard meal allowance for any US city and your travel dates, and the 50% you can deduct.

More tools and guides: [all guides and free tools](./).
