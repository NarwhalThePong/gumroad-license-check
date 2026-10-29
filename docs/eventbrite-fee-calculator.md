---
layout: page
title: "Eventbrite fee calculator (2026): what you keep per ticket in the US"
description: "Free Eventbrite fee calculator for US organizers. Paid tickets carry a 3.7% + $1.79 service fee plus 2.9% payment processing on the total order. See what buyers pay if you pass fees on, what you keep if you absorb them, and the ticket price you need."
---

Eventbrite is free for free events. For **paid tickets in the US**, Eventbrite charges a **service fee of 3.7% + $1.79 per ticket**, worked out on the ticket price, and a **payment processing fee of 2.9% of the total order**, which includes any service fee the buyer pays. By default your buyers pay the fees on top of your price and you keep the full ticket price. If you choose to **absorb the fees**, they come out of your price instead: a $25 ticket then pays $2.72 in service fee and $0.73 in processing, and you keep $21.55, or 86.2%. Passed on, the same ticket costs the buyer $28.52 and you keep $25.00. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="eb" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Who pays the fees<br><select id="eb-who"><option value="absorb" selected>I absorb the fees</option><option value="pass">Buyers pay the fees on top</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Ticket type<br><select id="eb-kind"><option value="paid" selected>Paid ticket (3.7% + $1.79 and 2.9%)</option><option value="donation">Donation ticket (2.9% only)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tickets sold<br><input id="eb-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Ticket price (USD)<br><input id="eb-p" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="eb-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per ticket and for your event</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Tickets</td><td style="text-align:right"><span id="eb-count">0</span></td></tr>
    <tr><td>Service fee per ticket</td><td style="text-align:right"><span id="eb-svc">$0.00</span></td></tr>
    <tr><td>Processing fee per ticket</td><td style="text-align:right"><span id="eb-proc">$0.00</span></td></tr>
    <tr><td>Buyer pays per ticket</td><td style="text-align:right"><span id="eb-buyer">$0.00</span></td></tr>
    <tr><td>You keep per ticket</td><td style="text-align:right"><span id="eb-keep1">$0.00</span></td></tr>
    <tr><td>Buyers pay in total</td><td style="text-align:right"><span id="eb-gross">$0.00</span></td></tr>
    <tr><td>Fees in total</td><td style="text-align:right"><span id="eb-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of ticket sales</td><td style="text-align:right"><span id="eb-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="eb-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Tickets needed and price to charge</h3>
  <p style="margin:0 0 8px"><label>I want to keep this much from the event (USD)<br><input id="eb-target" type="number" min="0" step="0.01" value="5000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="eb-need" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to keep this much per ticket while absorbing the fees (USD)<br><input id="eb-want" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="eb-price" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Eventbrite ticketing fee math for US organizers (checked 2026-10-29 from eventbrite.com/organizer/pricing and Eventbrite help article 755615). Service fee 3.7% + $1.79 per paid ticket on the ticket price; payment processing 2.9% of the total order (ticket price plus any passed-on service fee); donation tickets pay processing only. All math in integer cents, one ticket per order, tax left out; Eventbrite does not publish its rounding, so each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000;
  var SVC_RATE = 370, SVC_FIX = 179, PROC_RATE = 290;
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  /* per-ticket breakdown in cents: kind "paid" or "donation", who "pass" or "absorb" */
  function ticketC(P, kind, who) {
    if (P <= 0) return { price: 0, service: 0, processing: 0, buyerPays: 0, keep: 0 };
    var svc = kind === "donation" ? 0 : half(P * SVC_RATE) + SVC_FIX;
    if (who === "absorb") { var pr = half(P * PROC_RATE); return { price: P, service: svc, processing: pr, buyerPays: P, keep: P - svc - pr }; }
    var pr2 = half((P + svc) * PROC_RATE);
    return { price: P, service: svc, processing: pr2, buyerPays: P + svc + pr2, keep: P };
  }
  function calc(n, price, kind, who) {
    var N = count(n), T = ticketC(cents(amt(price)), kind, who), d = function (x) { return x / 100; };
    var gross = N * T.buyerPays, keep = N * T.keep, fees = N * (T.service + T.processing);
    return { tickets: N, perService: d(T.service), perProcessing: d(T.processing), perBuyer: d(T.buyerPays), perKeep: d(T.keep), buyerTotal: d(gross), fees: d(fees), net: d(keep), sales: d(N * T.price), effective: N * T.price > 0 ? fees / (N * T.price) : null };
  }
  /* fewest tickets at this price so that the amount kept >= target */
  function ticketsFor(target, price, kind, who) {
    var T = cents(big(target)), K = ticketC(cents(amt(price)), kind, who).keep;
    if (T <= 0 || K <= 0) return null;
    var n = Math.ceil(T / K); if (n > MAX_QTY) return null;
    return { tickets: n, net: n * K / 100 };
  }
  /* lowest absorbed-fee ticket price (whole cents) that keeps at least `want` per ticket */
  function priceFor(want, kind) {
    var W = cents(amt(want)); if (W <= 0) return null;
    var lo = 1, hi = MAX_AMT * 100;
    if (ticketC(hi, kind, "absorb").keep < W) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (ticketC(m, kind, "absorb").keep >= W) hi = m; else lo = m + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, SVC_RATE: SVC_RATE, SVC_FIX: SVC_FIX, PROC_RATE: PROC_RATE, num: num, amt: amt, count: count, ticketC: ticketC, calc: calc, ticketsFor: ticketsFor, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.EbFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.EbFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var who = $("eb-who").value, k = $("eb-kind").value, n = $("eb-n").value, p = $("eb-p").value, w = [];
    var r = B.calc(n, p, k, who);
    if (B.amt(p) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (B.amt(p) > 0 && r.perKeep <= 0) w.push("At this price the fees take the whole ticket.");
    $("eb-warn").textContent = w.join(" ");
    set("eb-count", r.tickets.toLocaleString("en-US")); set("eb-svc", money(r.perService)); set("eb-proc", money(r.perProcessing)); set("eb-buyer", money(r.perBuyer)); set("eb-keep1", money(r.perKeep)); set("eb-gross", money(r.buyerTotal)); set("eb-fees", money(r.fees)); set("eb-eff", pctS(r.effective)); set("eb-net", money(r.net));
    var T = $("eb-target").value, need = B.ticketsFor(T, p, k, who);
    set("eb-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(p) <= 0 ? "Enter a ticket price." : need == null ? "No number of tickets reaches that amount." : "You need to sell " + need.tickets.toLocaleString("en-US") + " tickets at " + money(B.amt(p)) + ", keeping " + money(need.net) + " after fees.");
    var W = $("eb-want").value, pr = B.priceFor(W, k);
    set("eb-price", B.amt(W) <= 0 ? "Enter how much you want to keep per ticket." : pr == null ? "No ticket price reaches that amount." : "Set the ticket price to " + money(pr) + " to keep " + money(B.amt(W)) + " per ticket when you absorb the fees.");
  }
  ["eb-who", "eb-kind", "eb-n", "eb-p", "eb-target", "eb-want"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Eventbrite fees in the US (checked Oct 29, 2026)

| Fee | Paid ticket | Donation ticket | Free ticket |
|---|---|---|---|
| Service fee | 3.7% of the ticket price + $1.79 per ticket | none | none |
| Payment processing | 2.9% of the total order | 2.9% of the total order | none |
| Tickets sold at the door in the Organizer app | $1 per paid ticket + 2.9% of the order | | |

The service fee is worked out on the ticket price. The processing fee is worked out on the whole order, including the service fee and any tax, so when buyers pay the fees on top they also pay processing on the service fee. When you absorb the fees, the buyer pays just your price and both fees come out of it. The $1.79 is charged on every paid ticket, so cheap tickets lose a bigger share: absorbing the fees on a $10 ticket leaves you $7.55, which is 75.5% of it. You choose who pays for each ticket type, and a change only applies to future orders.

These figures come from Eventbrite's [pricing page](https://www.eventbrite.com/organizer/pricing/) and its help article on [ticketing fees](https://www.eventbrite.com/help/en-us/articles/755615/how-much-does-it-cost-for-organizers-to-use-eventbrite/). Eventbrite does not publish how it rounds, so the calculator rounds each fee to the nearest cent, with half a cent going up. It assumes one ticket per order and leaves out sales tax, refunds, chargebacks, add-ons, Eventbrite Pro and Ads, and custom sales-partnership pricing. Your event's "How fees work" breakdown on Eventbrite is the final word.

## How the numbers are worked out

```
service fee     = 3.7% x ticket price + $1.79      (none on donation tickets)
absorb fees:      processing = 2.9% x ticket price
                  you keep   = ticket price - service fee - processing
pass fees on:     processing = 2.9% x (ticket price + service fee)
                  buyer pays = ticket price + service fee + processing, you keep the ticket price
```

Absorbing the fees, a $25 ticket keeps $21.55, a $50 ticket pays $3.64 in service fee and $1.45 in processing and keeps $44.91, and a $100 ticket keeps $91.61. Selling 100 tickets at $25 that way brings in $2,500.00, the fees come to $345.00 and you keep $2,155.00. Passing the fees on instead, a $50 ticket costs the buyer $55.20 and a $100 ticket costs $108.55, while you keep the full price. A $25 donation pays $0.73 in processing, so you keep $24.27.

## FAQ

### How much does Eventbrite charge per ticket?

In the US, Eventbrite charges a service fee of 3.7% of the ticket price plus $1.79 for every paid ticket, and a payment processing fee of 2.9% of the total order. On a $25 ticket that is $2.72 in service fee plus $0.80 in processing when the buyer pays the fees, or $0.73 in processing when you absorb them.

### Is Eventbrite free for free events?

Yes. Eventbrite charges no fees on free tickets, for you or your attendees, and you can publish unlimited free events. Fees start only when you sell paid tickets.

### Should I absorb Eventbrite fees or pass them on?

Passing the fees on is Eventbrite's default and lets you keep your full ticket price, but buyers see a higher total at checkout: $28.52 for a $25 ticket. Absorbing them keeps the price buyers see at $25 and leaves you $21.55. To absorb the fees and still keep $25 per ticket, set the price to $28.68.

### What percentage of ticket sales do I keep on Eventbrite?

If you absorb the fees, you keep 75.5% of a $10 ticket, 86.2% of a $25 ticket, 89.8% of a $50 ticket and 91.6% of a $100 ticket. The fixed $1.79 per ticket is why cheaper tickets keep less. If buyers pay the fees, you keep the whole ticket price.

### How many tickets do I need to sell on Eventbrite to make a set amount?

Divide the amount you want by what each ticket leaves you, then round up. Absorbing the fees on $25 tickets, each one leaves $21.55, so keeping $5,000 takes 233 tickets, which leaves $5,021.15. Passing the fees on, it takes 200 tickets. The calculator above works this out for any price.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Eventbrite charge per ticket?", "acceptedAnswer": {"@type": "Answer", "text": "In the US, Eventbrite charges a service fee of 3.7% of the ticket price plus $1.79 for every paid ticket, and a payment processing fee of 2.9% of the total order. On a $25 ticket that is $2.72 in service fee plus $0.80 in processing when the buyer pays the fees, or $0.73 in processing when you absorb them."}},
{"@type": "Question", "name": "Is Eventbrite free for free events?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. Eventbrite charges no fees on free tickets, for you or your attendees, and you can publish unlimited free events. Fees start only when you sell paid tickets."}},
{"@type": "Question", "name": "Should I absorb Eventbrite fees or pass them on?", "acceptedAnswer": {"@type": "Answer", "text": "Passing the fees on is Eventbrite's default and lets you keep your full ticket price, but buyers see a higher total at checkout: $28.52 for a $25 ticket. Absorbing them keeps the price buyers see at $25 and leaves you $21.55. To absorb the fees and still keep $25 per ticket, set the price to $28.68."}},
{"@type": "Question", "name": "What percentage of ticket sales do I keep on Eventbrite?", "acceptedAnswer": {"@type": "Answer", "text": "If you absorb the fees, you keep 75.5% of a $10 ticket, 86.2% of a $25 ticket, 89.8% of a $50 ticket and 91.6% of a $100 ticket. The fixed $1.79 per ticket is why cheaper tickets keep less. If buyers pay the fees, you keep the whole ticket price."}},
{"@type": "Question", "name": "How many tickets do I need to sell on Eventbrite to make a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want by what each ticket leaves you, then round up. Absorbing the fees on $25 tickets, each one leaves $21.55, so keeping $5,000 takes 233 tickets, which leaves $5,021.15. Passing the fees on, it takes 200 tickets. The calculator above works this out for any price."}}
]}
</script>

## Related tools and guides

- [Donorbox fee calculator (2026)](donorbox-fee-calculator): a 2.95% platform fee on the free Standard plan or 1.75% on Pro, plus Stripe or PayPal processing
- [Square fee calculator (2026)](square-fee-calculator): what card payments cost on Square, online and in person
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): what card payments cost on PayPal and Stripe

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Eventbrite. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
