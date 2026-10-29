---
layout: page
title: "Humanitix fee calculator (2026): what you keep from paid event tickets"
description: "Free Humanitix fee calculator for US hosts. The USD booking fee is 5% + $1.29 per paid ticket (3.9% + $1.29 for not-for-profits), with card processing included. See what buyers pay and what you keep when you pass on, absorb or split the fee, plus tickets needed and the price to charge."
---

Humanitix is free for free events and has no subscription. On **paid tickets** it charges a **booking fee of 5% + $1.29 per ticket** in US dollars, or **3.9% + $1.29** for registered not-for-profits and charities, and on Humanitix's own payment gateway that fee **already includes card processing**. By default the fee is **passed on**: buyers pay the ticket price plus the fee and you keep the full price. You can instead **absorb** it, so buyers pay only the ticket price, or **split** it. Absorbing the fee on a $25 ticket costs you $2.54 and leaves you $22.46, or 89.8%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="hx" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Rate<br><select id="hx-plan"><option value="standard" selected>Standard (5% + $1.29)</option><option value="nfp">Not-for-profit or charity (3.9% + $1.29)</option><option value="box">Box office card sale (3% + $1.00)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Who pays the booking fee<br><select id="hx-mode"><option value="pass">Passed on to buyers (default)</option><option value="absorb" selected>Absorbed by me</option><option value="split">Split with buyers</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tickets sold a month<br><input id="hx-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Ticket price (USD)<br><input id="hx-p" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Split: % of the percentage part buyers pay<br><input id="hx-sp" type="number" min="0" step="1" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Split: % of the fixed part buyers pay<br><input id="hx-sf" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="hx-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per ticket and per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Tickets</td><td style="text-align:right"><span id="hx-count">0</span></td></tr>
    <tr><td>Booking fee per ticket</td><td style="text-align:right"><span id="hx-fee1">$0.00</span></td></tr>
    <tr><td>Buyer pays per ticket</td><td style="text-align:right"><span id="hx-buyer1">$0.00</span></td></tr>
    <tr><td>You keep per ticket</td><td style="text-align:right"><span id="hx-keep1">$0.00</span></td></tr>
    <tr><td>Ticket sales at face value</td><td style="text-align:right"><span id="hx-sales">$0.00</span></td></tr>
    <tr><td>Buyers pay in total</td><td style="text-align:right"><span id="hx-paid">$0.00</span></td></tr>
    <tr><td>Booking fees in total</td><td style="text-align:right"><span id="hx-fees">$0.00</span></td></tr>
    <tr><td>Fees you pay</td><td style="text-align:right"><span id="hx-host">$0.00</span></td></tr>
    <tr><td>Fees you pay as a share of ticket sales</td><td style="text-align:right"><span id="hx-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="hx-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Tickets needed and price to charge</h3>
  <p style="margin:0 0 8px"><label>I want to keep this much a month (USD)<br><input id="hx-target" type="number" min="0" step="0.01" value="5000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="hx-need" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to keep this much per ticket (USD)<br><input id="hx-want" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="hx-price" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Humanitix booking fee math for US hosts (checked 2026-10-29 from humanitix.com/us/pricing and help.humanitix.com). USD booking fee per paid ticket: standard 5% + $1.29, registered not-for-profits and charities 3.9% + $1.29, box office card sales 3% + $1.00. On Humanitix's own payment gateway the booking fee includes card processing. The fee is passed on to buyers by default (buyer pays price + fee, host keeps the price), or absorbed (host keeps price - fee), or split (host passes on a chosen share of the percentage part and of the fixed part). All math in integer cents, per ticket; each component rounds to the nearest cent, half up; sales tax on the fee left out. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000;
  var RATES = { standard: { rate: 500, fixed: 129 }, nfp: { rate: 390, fixed: 129 }, box: { rate: 300, fixed: 100 } };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function share(v) { return Math.min(num(v), 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  function rateOf(plan) { return RATES[plan] || RATES.standard; }
  /* mode: "pass", "absorb" or "split"; for split, passPct and passFix are the % (0-100) of the percentage part and of the fixed part the buyer pays */
  function ticketC(P, plan, mode, passPct, passFix) {
    if (P <= 0) return { price: 0, pctFee: 0, fixFee: 0, fee: 0, buyerPays: 0, keep: 0 };
    var R = rateOf(plan), pf = half(P * R.rate), ff = R.fixed, fee = pf + ff, passed;
    if (mode === "absorb") passed = 0;
    else if (mode === "split") passed = Math.round(pf * share(passPct) / 100) + Math.round(ff * share(passFix) / 100);
    else passed = fee;
    return { price: P, pctFee: pf, fixFee: ff, fee: fee, buyerPays: P + passed, keep: P - (fee - passed) };
  }
  function calc(n, price, plan, mode, passPct, passFix) {
    var N = count(n), T = ticketC(cents(amt(price)), plan, mode, passPct, passFix), d = function (x) { return x / 100; };
    var sales = N * T.price, paid = N * T.buyerPays, fees = N * T.fee, net = N * T.keep;
    return { tickets: N, perFee: d(T.fee), perPct: d(T.pctFee), perFix: d(T.fixFee), perBuyer: d(T.buyerPays), perKeep: d(T.keep), sales: d(sales), buyersPay: d(paid), fees: d(fees), hostFees: d(sales - net), net: d(net), effective: sales > 0 ? (sales - net) / sales : null };
  }
  /* fewest tickets a month at this price so that the amount kept >= target */
  function ticketsFor(target, price, plan, mode, passPct, passFix) {
    var T = cents(big(target)), K = ticketC(cents(amt(price)), plan, mode, passPct, passFix).keep;
    if (T <= 0 || K <= 0) return null;
    var n = Math.ceil(T / K); if (n > MAX_QTY) return null;
    return { tickets: n, net: n * K / 100 };
  }
  /* lowest ticket price (whole cents) that keeps at least `want` per ticket */
  function priceFor(want, plan, mode, passPct, passFix) {
    var W = cents(amt(want)); if (W <= 0) return null;
    var lo = 1, hi = MAX_AMT * 100, k = function (p) { return ticketC(p, plan, mode, passPct, passFix).keep; };
    if (k(hi) < W) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (k(m) >= W) hi = m; else lo = m + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, RATES: RATES, num: num, amt: amt, count: count, share: share, ticketC: ticketC, calc: calc, ticketsFor: ticketsFor, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.HumanitixFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.HumanitixFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var pl = $("hx-plan").value, md = $("hx-mode").value, a = $("hx-sp").value, b = $("hx-sf").value, n = $("hx-n").value, p = $("hx-p").value, w = [];
    var r = B.calc(n, p, pl, md, a, b);
    if (B.amt(p) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (md === "split" && (Number(a) > 100 || Number(b) > 100)) w.push("Shares above 100% count as 100%.");
    if (B.amt(p) > 0 && r.perKeep <= 0) w.push("At this price the fee takes the whole ticket.");
    $("hx-warn").textContent = w.join(" ");
    set("hx-count", r.tickets.toLocaleString("en-US")); set("hx-fee1", money(r.perFee)); set("hx-buyer1", money(r.perBuyer)); set("hx-keep1", money(r.perKeep)); set("hx-sales", money(r.sales)); set("hx-paid", money(r.buyersPay)); set("hx-fees", money(r.fees)); set("hx-host", money(r.hostFees)); set("hx-eff", pctS(r.effective)); set("hx-net", money(r.net));
    var T = $("hx-target").value, need = B.ticketsFor(T, p, pl, md, a, b);
    set("hx-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(p) <= 0 ? "Enter a ticket price." : need == null ? "No number of tickets reaches that amount." : "You need to sell " + need.tickets.toLocaleString("en-US") + " tickets a month at " + money(B.amt(p)) + ", keeping " + money(need.net) + " after fees.");
    var W = $("hx-want").value, pr = B.priceFor(W, pl, md, a, b);
    set("hx-price", B.amt(W) <= 0 ? "Enter how much you want to keep per ticket." : pr == null ? "No ticket price reaches that amount." : "Set the ticket price to " + money(pr) + " to keep " + money(B.amt(W)) + " per ticket with these settings; buyers pay " + money(B.ticketC(Math.round(pr * 100), pl, md, a, b).buyerPays / 100) + ".");
  }
  ["hx-plan", "hx-mode", "hx-sp", "hx-sf", "hx-n", "hx-p", "hx-target", "hx-want"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Humanitix fees in the US (checked Oct 29, 2026)

| | Booking fee per paid ticket |
|---|---|
| Standard | 5% + $1.29 |
| Registered not-for-profits and charities | 3.9% + $1.29 |
| Box office card sales | 3% + $1.00 (cash sales are free) |
| Free tickets, manual orders, imported tickets | free |
| Subscription or sign-up fee | none |

The percentage is charged on each paid ticket's price and the fixed part is charged once per ticket, not per order. On Humanitix's default payment gateway the booking fee includes card processing, so there is no separate Stripe line. Some charges can't be moved: an American Express surcharge and a PayPal surcharge are always paid by the buyer, and buy-now-pay-later fees are always paid by you. If you connect your own Stripe account instead, Stripe's fees come on top.

These figures come from Humanitix's [US pricing page](https://humanitix.com/us/pricing) and its help articles on [booking fees](https://help.humanitix.com/en/articles/12292391-what-are-the-humanitix-booking-fees), [choosing who pays the fees](https://help.humanitix.com/en/articles/8896961-choose-who-pays-the-fees-for-your-event) and [splitting the fee](https://help.humanitix.com/en/articles/8913842-how-to-split-the-cost-of-the-humanitix-booking-fee-with-buyers). The standard rate is quoted before applicable taxes, which the calculator leaves out, along with refunds and disputes. It rounds each part of the fee to the nearest cent. The not-for-profit rate has to be requested before you start selling.

## How the numbers are worked out

```
booking fee    = 5% x ticket price + $1.29          (3.9% + $1.29 not-for-profit)
passed on      buyer pays price + fee, you keep the price
absorbed       buyer pays the price, you keep price - fee
split          buyer pays price + chosen share of each part, you pay the rest
```

When you absorb the fee, a $10 ticket keeps $8.21, a $50 ticket pays $3.79 and keeps $46.21, and a $100 ticket keeps $93.71. Selling 100 tickets a month at $25 brings in $2,500.00: absorbing the fee costs $254.00 and leaves $2,246.00, while passing it on means buyers pay $2,754.00 and you keep the full $2,500.00. If you pass on only the fixed $1.29 and absorb the 5%, a $20 ticket costs buyers $21.29 and you keep $19.00.

## FAQ

### How much does Humanitix charge per ticket in the US?

The standard US booking fee is 5% of the ticket price plus $1.29 per paid ticket, and it includes card processing on Humanitix's own payment gateway. On a $25 ticket that is $2.54. Registered not-for-profits and charities pay 3.9% + $1.29, which is $2.27 on a $25 ticket. Free tickets cost nothing.

### Who pays the Humanitix booking fee?

By default the buyer does: the fee is added on top of the ticket price at checkout and you keep 100% of the price. You can switch an event to absorb the fee, so buyers pay only the ticket price and the fee comes out of your payout, or split it by passing on a share of the percentage part and of the fixed part.

### How much do I keep if I absorb the Humanitix fee?

On the standard rate you keep 82.1% of a $10 ticket, 89.8% of a $25 ticket, 92.4% of a $50 ticket and 93.7% of a $100 ticket. On the not-for-profit rate you keep 83.2%, 90.9%, 93.5% and 94.8%. The fixed $1.29 is why cheaper tickets keep less.

### What should I charge on Humanitix to keep a set amount per ticket?

If you pass the fee on, charge the amount you want to keep, since buyers pay the fee on top. If you absorb it, raise the price to cover the fee: to keep $50 per ticket, charge $53.99 on the standard rate or $53.37 on the not-for-profit rate. Passing on only the fixed $1.29 needs $52.63.

### How many tickets do I need to sell on Humanitix to make a set amount?

Divide the amount you want by what each ticket leaves you and round up. At $25 a ticket with the fee absorbed, each ticket leaves $22.46, so keeping $5,000 a month takes 223 tickets, which leaves $5,008.58. With the fee passed on it takes 200 tickets, and at the not-for-profit rate with the fee absorbed it takes 220. The calculator above works this out for any price.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Humanitix charge per ticket in the US?", "acceptedAnswer": {"@type": "Answer", "text": "The standard US booking fee is 5% of the ticket price plus $1.29 per paid ticket, and it includes card processing on Humanitix's own payment gateway. On a $25 ticket that is $2.54. Registered not-for-profits and charities pay 3.9% + $1.29, which is $2.27 on a $25 ticket. Free tickets cost nothing."}},
{"@type": "Question", "name": "Who pays the Humanitix booking fee?", "acceptedAnswer": {"@type": "Answer", "text": "By default the buyer does: the fee is added on top of the ticket price at checkout and you keep 100% of the price. You can switch an event to absorb the fee, so buyers pay only the ticket price and the fee comes out of your payout, or split it by passing on a share of the percentage part and of the fixed part."}},
{"@type": "Question", "name": "How much do I keep if I absorb the Humanitix fee?", "acceptedAnswer": {"@type": "Answer", "text": "On the standard rate you keep 82.1% of a $10 ticket, 89.8% of a $25 ticket, 92.4% of a $50 ticket and 93.7% of a $100 ticket. On the not-for-profit rate you keep 83.2%, 90.9%, 93.5% and 94.8%. The fixed $1.29 is why cheaper tickets keep less."}},
{"@type": "Question", "name": "What should I charge on Humanitix to keep a set amount per ticket?", "acceptedAnswer": {"@type": "Answer", "text": "If you pass the fee on, charge the amount you want to keep, since buyers pay the fee on top. If you absorb it, raise the price to cover the fee: to keep $50 per ticket, charge $53.99 on the standard rate or $53.37 on the not-for-profit rate. Passing on only the fixed $1.29 needs $52.63."}},
{"@type": "Question", "name": "How many tickets do I need to sell on Humanitix to make a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want by what each ticket leaves you and round up. At $25 a ticket with the fee absorbed, each ticket leaves $22.46, so keeping $5,000 a month takes 223 tickets, which leaves $5,008.58. With the fee passed on it takes 200 tickets, and at the not-for-profit rate with the fee absorbed it takes 220. The calculator above works this out for any price."}}
]}
</script>

## Related tools and guides

- [Luma fee calculator (2026)](luma-fee-calculator): a 5% platform fee on paid tickets plus Stripe's 2.9% + $0.30, or 0% on Luma Plus
- [Eventbrite fee calculator (2026)](eventbrite-fee-calculator): 3.7% + $1.79 per paid ticket plus 2.9% processing, whether you absorb the fees or pass them on
- [Donorbox fee calculator (2026)](donorbox-fee-calculator): platform and processing fees on donations for US nonprofits
- [Tito fee calculator (2026)](tito-fee-calculator): 3% per paid ticket plus Stripe's 2.9% + $0.30 per order, always absorbed by the organizer

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Humanitix. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
