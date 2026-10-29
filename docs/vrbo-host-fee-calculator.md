---
layout: page
title: "Vrbo host fee calculator (2026): your payout after Vrbo's 12% commission"
description: "Free Vrbo host fee calculator for US hosts. Pay-per-booking: Vrbo charges a 12% commission on your rental amount plus cleaning and other fees, with no separate payment processing fee when Vrbo processes the payment. See your payout per stay, monthly and yearly totals, the nightly price to charge and a legacy subscription break-even."
---

Vrbo charges hosts on the **pay-per-booking** model a **12% commission** on the rental amount plus any fees you charge the traveler, such as cleaning, pet and boat fees. It isn't charged on the traveler service fee, taxes, refundable deposits or insurance, and when Vrbo processes the payment there's **no separate payment processing fee**. The yearly **subscription** is closed to new hosts, and starting October 2026 most hosts still on it are being moved to pay-per-booking. A 3-night stay at $150 a night with a $75 cleaning fee has a $525.00 rental total. Vrbo's commission is $63.00 and you're paid $462.00, or $154.00 a night. On Airbnb's 15.5% single fee the same stay would pay you $443.62 (see the [Airbnb host fee calculator](airbnb-host-fee-calculator)). Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="vb" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Fee model<br><select id="vb-m"><option value="ppb" selected>Pay-per-booking (12% commission)</option><option value="sub">Legacy yearly subscription (no commission)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Commission % (pay-per-booking)<br><input id="vb-cp" type="number" min="0" step="0.01" value="12" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment processing % (0 if Vrbo processes)<br><input id="vb-pp" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Traveler service fee % (optional, guest pays)<br><input id="vb-gp" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Yearly subscription fee, if you still have one (USD)<br><input id="vb-a" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px;font-size:0.9em">Your exact rate is in your Vrbo Owner Dashboard; edit the percentages to match. Leave payment processing at 0% if Vrbo processes your payments, or enter your own processor's rate if you use one. Vrbo doesn't publish its traveler service fee, so it's optional and only changes what the guest pays.</p>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Nightly price (USD)<br><input id="vb-p" type="number" min="0" step="0.01" value="150" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Nights per stay<br><input id="vb-n" type="number" min="0" step="1" value="3" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cleaning fee per stay (USD)<br><input id="vb-c" type="number" min="0" step="0.01" value="75" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Other host fees per stay, e.g. pet fee (USD)<br><input id="vb-o" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Stays a month<br><input id="vb-s" type="number" min="0" step="1" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="vb-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per stay</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Rental total (nights + your fees)</td><td style="text-align:right"><span id="vb-sub">$0.00</span></td></tr>
    <tr><td>Traveler service fee</td><td style="text-align:right"><span id="vb-gfee">$0.00</span></td></tr>
    <tr><td>Guest pays (before taxes)</td><td style="text-align:right"><span id="vb-guest">$0.00</span></td></tr>
    <tr><td>Vrbo commission</td><td style="text-align:right"><span id="vb-comm">$0.00</span></td></tr>
    <tr><td>Payment processing</td><td style="text-align:right"><span id="vb-proc">$0.00</span></td></tr>
    <tr><td>Your payout per stay</td><td style="text-align:right"><strong id="vb-pay">$0.00</strong></td></tr>
    <tr><td>Payout per night</td><td style="text-align:right"><span id="vb-pn">$0.00</span></td></tr>
    <tr><td>Fees as a share of the rental total</td><td style="text-align:right"><span id="vb-eff">0%</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and per year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Stays</td><td style="text-align:right"><span id="vb-count">0</span></td></tr>
    <tr><td>Bookings a month (rental totals)</td><td style="text-align:right"><span id="vb-msub">$0.00</span></td></tr>
    <tr><td>Subscription share a month</td><td style="text-align:right"><span id="vb-msubs">$0.00</span></td></tr>
    <tr><td>Vrbo fees a month</td><td style="text-align:right"><span id="vb-mfee">$0.00</span></td></tr>
    <tr><td>Payout a month</td><td style="text-align:right"><strong id="vb-mpay">$0.00</strong></td></tr>
    <tr><td>Vrbo fees a year</td><td style="text-align:right"><span id="vb-yfee">$0.00</span></td></tr>
    <tr><td>Payout a year</td><td style="text-align:right"><strong id="vb-ypay">$0.00</strong></td></tr>
    <tr><td>Fees as a share of a year of bookings</td><td style="text-align:right"><span id="vb-yeff">0%</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Subscription vs pay-per-booking</h3>
  <p id="vb-be" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to charge and stays needed</h3>
  <p style="margin:0 0 8px"><label>I want to be paid this much per stay (USD)<br><input id="vb-want" type="number" min="0" step="0.01" value="500" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="vb-price" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to be paid this much a month (USD)<br><input id="vb-target" type="number" min="0" step="0.01" value="3000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="vb-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Vrbo host fee math for US hosts (checked 2026-10-29 from help.vrbo.com). Pay-per-booking: 12% commission on the rental amount plus any fees the host charges the traveler (cleaning, pet, boat fees); not charged on the traveler service fee, taxes, refundable deposits or insurance; no separate payment processing fee when Vrbo processes the payment (help.vrbo.com/articles/How-is-the-booking-fee-calculated). Subscription: closed to new hosts, most legacy subscribers move to pay-per-booking from October 2026 (help.vrbo.com/articles/How-do-I-pay-for-my-new-subscription); no commission on subscription listings, the yearly fee is entered by the user. Traveler service fee: a percentage of the reservation total before taxes and refundable fees that varies with the amount; Vrbo doesn't publish it, so it's an optional input (help.vrbo.com/articles/what-is-the-service-fee). All math in integer cents; each fee rounds to the nearest cent, half up; taxes left out. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 100000, MAX_NIGHTS = 365;
  var RATES = { commission: 1200, processingVrbo: 0, guestFee: null };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function nights(v) { return Math.max(1, Math.min(Math.floor(num(v)), MAX_NIGHTS)); }
  function pct(v) { return Math.min(num(v), 100); }
  function bps(v) { return Math.round(pct(v) * 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  /* one stay: P = nightly price cents, n nights, F = host-charged fees cents; cB/pB/gB = commission, processing, traveler fee in basis points */
  function stayC(P, n, F, cB, pB, gB) {
    var sub = P * n + F, comm = half(sub * cB), proc = half(sub * pB), guest = half(sub * gB);
    return { nightly: P, nights: n, subtotal: sub, commission: comm, processing: proc, hostFee: comm + proc, guestFee: guest, guestPays: sub + guest, payout: sub - comm - proc };
  }
  function args(n, clean, other, model, commPct, procPct, guestPct) {
    return [nights(n), cents(amt(clean)) + cents(amt(other)), model === "sub" ? 0 : bps(commPct), bps(procPct), bps(guestPct)];
  }
  function one(price, n, clean, other, model, commPct, procPct, guestPct) { var a = args(n, clean, other, model, commPct, procPct, guestPct); return stayC(cents(amt(price)), a[0], a[1], a[2], a[3], a[4]); }
  function annualC(model, annual) { return model === "sub" ? cents(amt(annual)) : 0; }
  function calc(stays, price, n, clean, other, model, commPct, procPct, guestPct, annual) {
    var S = count(stays), O = one(price, n, clean, other, model, commPct, procPct, guestPct), A = annualC(model, annual), Am = Math.floor((A + 6) / 12), d = function (x) { return x / 100; };
    var yFees = 12 * S * O.hostFee + A, ySub = 12 * S * O.subtotal;
    return { stays: S, nights: O.nights, subtotal: d(O.subtotal), commission: d(O.commission), processing: d(O.processing), hostFee: d(O.hostFee), guestFee: d(O.guestFee), guestPays: d(O.guestPays), payout: d(O.payout), perNight: O.payout / O.nights / 100,
      monthSubtotal: d(S * O.subtotal), monthSubscription: d(Am), monthFees: d(S * O.hostFee + Am), monthPayout: d(S * O.payout - Am), yearSubtotal: d(ySub), yearFees: d(yFees), yearPayout: d(12 * S * O.payout - A),
      effective: O.subtotal > 0 ? O.hostFee / O.subtotal : null, yearEffective: ySub > 0 ? yFees / ySub : null };
  }
  /* lowest nightly price (whole cents) whose payout per stay reaches `want` */
  function priceForC(W, a) {
    var k = function (p) { return stayC(p, a[0], a[1], a[2], a[3], a[4]).payout; };
    if (W <= 0) return null; var lo = 0, hi = MAX_AMT * 100; if (k(hi) < W) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (k(m) >= W) hi = m; else lo = m + 1; }
    return lo;
  }
  function priceFor(want, n, clean, other, model, commPct, procPct, guestPct) { var p = priceForC(cents(amt(want)), args(n, clean, other, model, commPct, procPct, guestPct)); return p == null ? null : p / 100; }
  /* fewest stays a month whose monthly payout (after any subscription share) reaches target */
  function staysFor(target, price, n, clean, other, model, commPct, procPct, guestPct, annual) {
    var T = cents(big(target)), K = one(price, n, clean, other, model, commPct, procPct, guestPct).payout, A = annualC(model, annual), Am = Math.floor((A + 6) / 12);
    if (T <= 0 || K <= 0) return null;
    var s = Math.ceil((T + Am) / K); if (s > MAX_QTY) return null;
    return { stays: s, payout: (s * K - Am) / 100 };
  }
  /* legacy subscription vs pay-per-booking: yearly commission at this stay size, and the fewest stays a month at which a year of commission reaches the yearly subscription fee */
  function breakEven(annual, price, n, clean, other, commPct) {
    var A = cents(amt(annual)), O = one(price, n, clean, other, "ppb", commPct, 0, 0), C = O.commission, cB = bps(commPct);
    if (A <= 0) return null;
    var yearSub = cB > 0 ? Math.ceil(A * 10000 / cB) : null;
    return { annual: A / 100, commissionPerStay: C / 100, staysPerMonth: C > 0 ? Math.ceil(A / (12 * C)) : null, yearBookings: yearSub == null ? null : yearSub / 100 };
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, RATES: RATES, num: num, amt: amt, count: count, nights: nights, pct: pct, half: half, stayC: stayC, one: one, calc: calc, priceFor: priceFor, staysFor: staysFor, breakEven: breakEven };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.VrboFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.VrboFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var m = $("vb-m").value, cp = $("vb-cp").value, pp = $("vb-pp").value, gp = $("vb-gp").value, a = $("vb-a").value, p = $("vb-p").value, n = $("vb-n").value, c = $("vb-c").value, o = $("vb-o").value, s = $("vb-s").value, w = [];
    var r = B.calc(s, p, n, c, o, m, cp, pp, gp, a);
    if (B.amt(p) >= B.MAX_AMT || B.amt(c) >= B.MAX_AMT || B.amt(o) >= B.MAX_AMT || B.amt(a) >= B.MAX_AMT || B.count(s) >= B.MAX_QTY || Number(n) > 365) w.push("Large numbers are capped.");
    if ([cp, pp, gp].some(function (v) { return Number(v) > 100; })) w.push("A rate above 100% counts as 100%.");
    if (m === "ppb" && B.pct(cp) !== 12) w.push("Vrbo's help center lists a 12% commission for pay-per-booking.");
    if (m === "sub" && B.amt(a) <= 0) w.push("Enter the yearly fee you pay for your subscription.");
    $("vb-warn").textContent = w.join(" ");
    set("vb-sub", money(r.subtotal)); set("vb-gfee", money(r.guestFee)); set("vb-guest", money(r.guestPays)); set("vb-comm", money(r.commission)); set("vb-proc", money(r.processing)); set("vb-pay", money(r.payout)); set("vb-pn", money(r.perNight)); set("vb-eff", pctS(r.effective));
    set("vb-count", r.stays.toLocaleString("en-US")); set("vb-msub", money(r.monthSubtotal)); set("vb-msubs", money(r.monthSubscription)); set("vb-mfee", money(r.monthFees)); set("vb-mpay", money(r.monthPayout)); set("vb-yfee", money(r.yearFees)); set("vb-ypay", money(r.yearPayout)); set("vb-yeff", pctS(r.yearEffective));
    var be = B.breakEven(a, p, n, c, o, cp);
    set("vb-be", be == null ? "Still on a yearly subscription? Enter what it costs you a year to see when pay-per-booking would cost more." : be.staysPerMonth == null ? "Enter a nightly price and a commission rate to compare." : "At " + pctS(B.pct(cp) / 100) + ", commission on this stay is " + money(be.commissionPerStay) + ", so a year of commission passes your " + money(be.annual) + " subscription at " + be.staysPerMonth.toLocaleString("en-US") + " stays a month, or " + money(be.yearBookings) + " of bookings a year. With " + B.count(s).toLocaleString("en-US") + " stays a month, pay-per-booking costs " + money(be.commissionPerStay * 12 * B.count(s)) + " a year in commission.");
    var W = $("vb-want").value, pr = B.priceFor(W, n, c, o, m, cp, pp, gp);
    set("vb-price", B.amt(W) <= 0 ? "Enter how much you want to be paid per stay." : pr == null ? "No nightly price reaches that payout." : pr === 0 ? "Your cleaning and other fees already pay you that much." : "Set the nightly price to " + money(pr) + " to be paid at least " + money(B.amt(W)) + " per " + B.nights(n) + "-night stay with these settings.");
    var T = $("vb-target").value, need = B.staysFor(T, p, n, c, o, m, cp, pp, gp, a);
    set("vb-need", B.amt(T) <= 0 ? "Enter how much you want to be paid a month." : need == null ? "Enter a nightly price or fees that leave you a payout." : "You need " + need.stays.toLocaleString("en-US") + " stays a month (" + (need.stays * B.nights(n)).toLocaleString("en-US") + " nights), paying you " + money(need.payout) + ".");
  }
  ["vb-m", "vb-cp", "vb-pp", "vb-gp", "vb-a", "vb-p", "vb-n", "vb-c", "vb-o", "vb-s", "vb-want", "vb-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Vrbo host fees for US hosts (checked Oct 29, 2026)

| | What you pay | Charged on |
|---|---|---|
| Pay-per-booking commission | 12% | rental amount plus fees you charge the traveler (cleaning, pet, boat fees) |
| Payment processing, when Vrbo processes the payment | no separate fee | |
| Payment processing, with your own processor | your processor's fees | set by your processor |
| Not charged commission | | traveler service fee, taxes, refundable deposits, insurance |
| Yearly subscription | closed to new hosts; most legacy subscribers move to pay-per-booking from October 2026 | |
| Traveler service fee (paid by the guest) | a percentage that varies with the reservation amount; Vrbo doesn't publish it | reservation total before taxes and refundable fees |

These figures come from Vrbo's help articles [About the pay-per-booking (PPB) model](https://help.vrbo.com/articles/How-is-the-booking-fee-calculated), [Pay for your listing subscription](https://help.vrbo.com/articles/How-do-I-pay-for-my-new-subscription) and [About Vrbo's service fee](https://help.vrbo.com/articles/what-is-the-service-fee). Vrbo says to check your Owner Dashboard for the exact rate on your listings, and in some regions outside the US rates can be up to 15%. Hosts can't waive or reduce the traveler service fee. Vrbo can change its fees at any time. The calculator leaves out taxes such as lodging taxes, refundable damage deposits, cancellations and refunds, and rounds each fee to the nearest cent.

## How the numbers are worked out

```
rental total     = nightly price x nights + cleaning fee + other host fees
commission       = 12% x rental total          (0 on a subscription listing)
processing       = your processor's % x rental total   (0 when Vrbo processes the payment)
your payout      = rental total - commission - processing
guest pays       = rental total + traveler service fee (before taxes)
subscription     = yearly fee, spread as 1/12 a month in the monthly totals
```

For a single $100 night with no cleaning fee, you're paid $88.00. Hosting the 3-night, $150 a night stay with a $75 cleaning fee 8 times a month pays $3,696.00 a month and $44,352.00 a year, after $504.00 a month and $6,048.00 a year in commission. The $75 cleaning fee adds $9.00 to the commission on each stay. If you're still on a subscription, compare its yearly cost with a year of commission: taking $1,000 a year as an example only (Vrbo doesn't publish subscription prices any more), a year of commission on this stay passes $1,000 at 2 stays a month, or $8,333.34 of bookings a year, and at 8 stays a month the subscription would pay you $49,400.00 a year instead of $44,352.00.

## FAQ

### How much does Vrbo charge hosts in 2026?

On pay-per-booking, Vrbo charges a 12% commission on the rental amount plus any fees you charge the traveler, such as cleaning and pet fees. When Vrbo processes the payment there's no separate payment processing fee. On a 3-night stay at $150 a night with a $75 cleaning fee, that's $63.00 of a $525.00 rental total.

### How much will I get paid for a Vrbo booking?

Your payout is the nightly price times the nights plus your cleaning and other fees, minus Vrbo's commission and any fees your own payment processor charges. A 3-night stay at $150 a night with a $75 cleaning fee pays you $462.00, or $154.00 a night. Taxes and refundable deposits the guest pays aren't part of the calculation.

### What nightly price should I set on Vrbo to be paid a set amount?

Raise the price until the payout after the commission reaches your number. To be paid $500 for a 3-night stay with a $75 cleaning fee, charge $164.40 a night. At $150 a night it takes 7 stays a month to be paid $3,000, which pays $3,234.00.

### Does Vrbo's commission apply to the cleaning fee and taxes?

It applies to the cleaning fee and other fees you charge the traveler, such as pet and boat fees, but not to taxes, refundable deposits, insurance or the traveler service fee. A $75 cleaning fee adds $9.00 to the commission.

### Can I still pay for a Vrbo subscription instead of commission?

No new subscriptions are offered: hosts can no longer opt in, and starting October 2026 most hosts still on a subscription are being switched to pay-per-booking. Subscription listings don't pay the commission, so if you still have one, enter its yearly cost in the calculator to see how many stays a month it takes for 12% commission to cost more.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Vrbo charge hosts in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "On pay-per-booking, Vrbo charges a 12% commission on the rental amount plus any fees you charge the traveler, such as cleaning and pet fees. When Vrbo processes the payment there's no separate payment processing fee. On a 3-night stay at $150 a night with a $75 cleaning fee, that's $63.00 of a $525.00 rental total."}},
{"@type": "Question", "name": "How much will I get paid for a Vrbo booking?", "acceptedAnswer": {"@type": "Answer", "text": "Your payout is the nightly price times the nights plus your cleaning and other fees, minus Vrbo's commission and any fees your own payment processor charges. A 3-night stay at $150 a night with a $75 cleaning fee pays you $462.00, or $154.00 a night. Taxes and refundable deposits the guest pays aren't part of the calculation."}},
{"@type": "Question", "name": "What nightly price should I set on Vrbo to be paid a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Raise the price until the payout after the commission reaches your number. To be paid $500 for a 3-night stay with a $75 cleaning fee, charge $164.40 a night. At $150 a night it takes 7 stays a month to be paid $3,000, which pays $3,234.00."}},
{"@type": "Question", "name": "Does Vrbo's commission apply to the cleaning fee and taxes?", "acceptedAnswer": {"@type": "Answer", "text": "It applies to the cleaning fee and other fees you charge the traveler, such as pet and boat fees, but not to taxes, refundable deposits, insurance or the traveler service fee. A $75 cleaning fee adds $9.00 to the commission."}},
{"@type": "Question", "name": "Can I still pay for a Vrbo subscription instead of commission?", "acceptedAnswer": {"@type": "Answer", "text": "No new subscriptions are offered: hosts can no longer opt in, and starting October 2026 most hosts still on a subscription are being switched to pay-per-booking. Subscription listings don't pay the commission, so if you still have one, enter its yearly cost in the calculator to see how many stays a month it takes for 12% commission to cost more."}}
]}
</script>

## Related tools and guides

- [Airbnb host fee calculator (2026)](airbnb-host-fee-calculator): the 15.5% single fee taken from your payout vs the 3% split fee plus the guest's 14.1% to 16.5%, on nightly price and cleaning fees
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): Social Security and Medicare tax on self-employment income, with the deductible half and the quarterly share
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator): how much to set aside each quarter from income that has no tax withheld

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Vrbo or Expedia Group. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
