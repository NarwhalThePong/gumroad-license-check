---
layout: page
title: "Luma fee calculator (2026): what you keep from paid event tickets"
description: "Free Luma (lu.ma) fee calculator for US hosts. The free plan takes a 5% platform fee on paid tickets plus Stripe's 2.9% + $0.30. See what you keep per ticket and per month, when Luma Plus ($69/mo, or $59/mo billed yearly) pays for itself, and the price to charge."
---

Luma is free for free events. On **paid tickets**, the free plan takes a **5% platform fee**, and Stripe, Luma's payment processor, charges its card fee, **typically 2.9% + $0.30**, on top. **Luma Plus** drops the platform fee to **0%** for **$69 a month**, or **$59 a month billed yearly**, but the Stripe fee still applies. Guests pay exactly the price you set, because Luma does not add fees at checkout, so both fees come out of your price. On the free plan a $25 ticket pays $1.25 to Luma and $1.03 to Stripe, and you keep $22.72, or 90.9%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="lu" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <p style="margin:0 0 8px"><label>Luma plan<br><select id="lu-plan"><option value="free" selected>Free (5% platform fee)</option><option value="plus-monthly">Luma Plus, paid monthly ($69/mo, 0% platform fee)</option><option value="plus-annual">Luma Plus, billed yearly ($59/mo, 0% platform fee)</option></select></label></p>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tickets sold a month<br><input id="lu-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Ticket price (USD)<br><input id="lu-p" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="lu-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per ticket and per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Tickets</td><td style="text-align:right"><span id="lu-count">0</span></td></tr>
    <tr><td>Luma platform fee per ticket</td><td style="text-align:right"><span id="lu-plat">$0.00</span></td></tr>
    <tr><td>Stripe fee per ticket</td><td style="text-align:right"><span id="lu-stripe">$0.00</span></td></tr>
    <tr><td>You keep per ticket</td><td style="text-align:right"><span id="lu-keep1">$0.00</span></td></tr>
    <tr><td>Ticket sales</td><td style="text-align:right"><span id="lu-sales">$0.00</span></td></tr>
    <tr><td>Luma Plus subscription</td><td style="text-align:right"><span id="lu-sub">$0.00</span></td></tr>
    <tr><td>Fees in total</td><td style="text-align:right"><span id="lu-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of ticket sales</td><td style="text-align:right"><span id="lu-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="lu-net">$0.00</strong></td></tr>
  </table>
  <p id="lu-plus" style="margin:0 0 8px;font-weight:bold"></p>
  <h3 style="margin:16px 0 8px">Tickets needed and price to charge</h3>
  <p style="margin:0 0 8px"><label>I want to keep this much a month (USD)<br><input id="lu-target" type="number" min="0" step="0.01" value="5000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="lu-need" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to keep this much per ticket (USD)<br><input id="lu-want" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="lu-price" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Luma (lu.ma) ticket fee math for US hosts (checked 2026-10-29 from luma.com/pricing and help.luma.com). Free plan: 5% platform fee on paid tickets; Luma Plus ($69/mo monthly or $59/mo billed annually): 0% platform fee. Stripe card processing, typically 2.9% + $0.30, applies on every plan and comes out of the price on top of the platform fee. Guests pay the price you set; Luma does not add fees at checkout. All math in integer cents, one ticket per order, tax left out; each fee rounds to the nearest cent, half up. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000;
  var PLAT_RATE = 500, STRIPE_RATE = 290, STRIPE_FIX = 30, PLUS_MONTHLY = 6900, PLUS_ANNUAL = 5900;
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  /* plan: "free", "plus-monthly" or "plus-annual" */
  function subC(plan) { return plan === "plus-monthly" ? PLUS_MONTHLY : plan === "plus-annual" ? PLUS_ANNUAL : 0; }
  function ticketC(P, plan) {
    if (P <= 0) return { price: 0, platform: 0, stripe: 0, keep: 0 };
    var pl = plan === "free" ? half(P * PLAT_RATE) : 0, st = half(P * STRIPE_RATE) + STRIPE_FIX;
    return { price: P, platform: pl, stripe: st, keep: P - pl - st };
  }
  function calc(n, price, plan) {
    var N = count(n), T = ticketC(cents(amt(price)), plan), S = subC(plan), d = function (x) { return x / 100; };
    var sales = N * T.price, ticketFees = N * (T.platform + T.stripe), fees = ticketFees + S;
    return { tickets: N, perPlatform: d(T.platform), perStripe: d(T.stripe), perKeep: d(T.keep), sales: d(sales), platformTotal: d(N * T.platform), stripeTotal: d(N * T.stripe), subscription: d(S), fees: d(fees), net: d(sales - fees), effective: sales > 0 ? fees / sales : null };
  }
  /* fewest tickets a month at this price so that the amount kept (after any Plus fee) >= target */
  function ticketsFor(target, price, plan) {
    var T = cents(big(target)), K = ticketC(cents(amt(price)), plan).keep, S = subC(plan);
    if (T <= 0 || K <= 0) return null;
    var n = Math.ceil((T + S) / K); if (n > MAX_QTY) return null;
    return { tickets: n, net: (n * K - S) / 100 };
  }
  /* lowest ticket price (whole cents) that keeps at least `want` per ticket */
  function priceFor(want, plan) {
    var W = cents(amt(want)); if (W <= 0) return null;
    var lo = 1, hi = MAX_AMT * 100;
    if (ticketC(hi, plan).keep < W) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (ticketC(m, plan).keep >= W) hi = m; else lo = m + 1; }
    return lo / 100;
  }
  /* monthly ticket sales (USD) at which Plus costs the same as the 5% platform fee */
  function breakEven(plan) { var S = subC(plan); return S ? S * 10000 / PLAT_RATE / 100 : null; }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, PLAT_RATE: PLAT_RATE, STRIPE_RATE: STRIPE_RATE, STRIPE_FIX: STRIPE_FIX, PLUS_MONTHLY: PLUS_MONTHLY, PLUS_ANNUAL: PLUS_ANNUAL, num: num, amt: amt, count: count, subC: subC, ticketC: ticketC, calc: calc, ticketsFor: ticketsFor, priceFor: priceFor, breakEven: breakEven };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.LumaFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.LumaFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var pl = $("lu-plan").value, n = $("lu-n").value, p = $("lu-p").value, w = [];
    var r = B.calc(n, p, pl);
    if (B.amt(p) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (B.amt(p) > 0 && r.perKeep <= 0) w.push("At this price the fees take the whole ticket.");
    $("lu-warn").textContent = w.join(" ");
    set("lu-count", r.tickets.toLocaleString("en-US")); set("lu-plat", money(r.perPlatform)); set("lu-stripe", money(r.perStripe)); set("lu-keep1", money(r.perKeep)); set("lu-sales", money(r.sales)); set("lu-sub", money(r.subscription)); set("lu-fees", money(r.fees)); set("lu-eff", pctS(r.effective)); set("lu-net", money(r.net));
    var f = B.calc(n, p, "free"), m = B.calc(n, p, "plus-monthly"), a = B.calc(n, p, "plus-annual");
    set("lu-plus", f.sales <= 0 ? "Enter tickets and a price to compare plans." : "At these sales you keep " + money(f.net) + " a month on the free plan, " + money(m.net) + " on Plus paid monthly and " + money(a.net) + " on Plus billed yearly. Plus pays for itself above " + money(B.breakEven("plus-monthly")) + " a month in ticket sales (" + money(B.breakEven("plus-annual")) + " billed yearly).");
    var T = $("lu-target").value, need = B.ticketsFor(T, p, pl);
    set("lu-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(p) <= 0 ? "Enter a ticket price." : need == null ? "No number of tickets reaches that amount." : "You need to sell " + need.tickets.toLocaleString("en-US") + " tickets a month at " + money(B.amt(p)) + ", keeping " + money(need.net) + " after fees.");
    var W = $("lu-want").value, pr = B.priceFor(W, pl);
    set("lu-price", B.amt(W) <= 0 ? "Enter how much you want to keep per ticket." : pr == null ? "No ticket price reaches that amount." : "Set the ticket price to " + money(pr) + " to keep " + money(B.amt(W)) + " per ticket on this plan.");
  }
  ["lu-plan", "lu-n", "lu-p", "lu-target", "lu-want"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Luma fees in the US (checked Oct 29, 2026)

| | Free | Luma Plus |
|---|---|---|
| Subscription | $0 | $69 a month, or $59 a month billed yearly |
| Platform fee on paid tickets | 5% | 0% |
| Stripe card fee | typically 2.9% + $0.30 | typically 2.9% + $0.30 |
| Free events | free, unlimited events and guests | free, unlimited events and guests |

Luma's platform fee is on top of the Stripe fee, and both are taken out of each sale as it happens. There is no setting to add fees on top of your price at checkout, so if you want guests to cover the fees, raise the ticket price: to keep $50 a ticket on the free plan, charge $54.61. Plus is billed per calendar and only lowers fees on sales after you turn it on.

These figures come from Luma's [pricing page](https://luma.com/pricing) and its help articles on [creating a paid event](https://help.luma.com/p/creating-a-paid-event) and [Luma Plus](https://help.luma.com/p/luma-plus). Stripe's card fee varies by card and country, so the calculator uses the 2.9% + $0.30 that Luma quotes, rounds each fee to the nearest cent, and assumes one ticket per order. It leaves out sales tax, refunds, disputes, currency conversion and Luma's paid email-send add-ons. Your Stripe dashboard and Luma's Sales History export show the exact fee on each charge.

## How the numbers are worked out

```
platform fee  = 5% x ticket price           (0% on Luma Plus)
Stripe fee    = 2.9% x ticket price + $0.30
you keep      = ticket price - platform fee - Stripe fee
per month     = tickets x you keep - Plus subscription
Plus break-even: 5% x monthly ticket sales = $69  ->  $1,380 a month ($1,180 billed yearly)
```

On the free plan, a $10 ticket keeps $8.91, a $50 ticket pays $2.50 to Luma and $1.75 to Stripe and keeps $45.75, and a $100 ticket keeps $91.80. On Plus, the same $100 ticket keeps $96.80. Selling 100 tickets a month at $25 brings in $2,500.00: the free plan's fees come to $228.00 and you keep $2,272.00, while Plus paid monthly costs $172.00 including the subscription and leaves $2,328.00.

## FAQ

### How much does Luma charge for paid events?

On the free plan, Luma takes a 5% platform fee on each paid ticket, and Stripe charges its card fee, typically 2.9% + $0.30, on top. On a $25 ticket that is $1.25 to Luma and $1.03 to Stripe, so you keep $22.72. Free events cost nothing.

### Is Luma Plus worth it?

Luma Plus costs $69 a month, or $59 a month billed yearly, and removes the 5% platform fee. It pays for itself once you sell more than $1,380 in tickets a month, or $1,180 if you pay yearly. Below that, the free plan leaves you more.

### Can I pass Luma fees on to guests?

Not as a separate checkout fee. Luma shows guests one total price and has no option to add fees on top, so to have guests cover the fees you raise the ticket price. To keep $50 per ticket, charge $54.61 on the free plan or $51.80 on Luma Plus.

### What percentage of ticket sales do I keep on Luma?

On the free plan you keep 89.1% of a $10 ticket, 90.9% of a $25 ticket, 91.5% of a $50 ticket and 91.8% of a $100 ticket. On Luma Plus, before the subscription, you keep 94.1%, 95.9%, 96.5% and 96.8%. The fixed $0.30 Stripe fee is why cheaper tickets keep less.

### How many tickets do I need to sell on Luma to make a set amount?

Divide the amount you want by what each ticket leaves you, adding the Plus subscription if you have it, then round up. At $25 a ticket on the free plan, each one leaves $22.72, so keeping $5,000 a month takes 221 tickets, which leaves $5,021.12. On Plus paid monthly it takes 212 tickets. The calculator above works this out for any price.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Luma charge for paid events?", "acceptedAnswer": {"@type": "Answer", "text": "On the free plan, Luma takes a 5% platform fee on each paid ticket, and Stripe charges its card fee, typically 2.9% + $0.30, on top. On a $25 ticket that is $1.25 to Luma and $1.03 to Stripe, so you keep $22.72. Free events cost nothing."}},
{"@type": "Question", "name": "Is Luma Plus worth it?", "acceptedAnswer": {"@type": "Answer", "text": "Luma Plus costs $69 a month, or $59 a month billed yearly, and removes the 5% platform fee. It pays for itself once you sell more than $1,380 in tickets a month, or $1,180 if you pay yearly. Below that, the free plan leaves you more."}},
{"@type": "Question", "name": "Can I pass Luma fees on to guests?", "acceptedAnswer": {"@type": "Answer", "text": "Not as a separate checkout fee. Luma shows guests one total price and has no option to add fees on top, so to have guests cover the fees you raise the ticket price. To keep $50 per ticket, charge $54.61 on the free plan or $51.80 on Luma Plus."}},
{"@type": "Question", "name": "What percentage of ticket sales do I keep on Luma?", "acceptedAnswer": {"@type": "Answer", "text": "On the free plan you keep 89.1% of a $10 ticket, 90.9% of a $25 ticket, 91.5% of a $50 ticket and 91.8% of a $100 ticket. On Luma Plus, before the subscription, you keep 94.1%, 95.9%, 96.5% and 96.8%. The fixed $0.30 Stripe fee is why cheaper tickets keep less."}},
{"@type": "Question", "name": "How many tickets do I need to sell on Luma to make a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want by what each ticket leaves you, adding the Plus subscription if you have it, then round up. At $25 a ticket on the free plan, each one leaves $22.72, so keeping $5,000 a month takes 221 tickets, which leaves $5,021.12. On Plus paid monthly it takes 212 tickets. The calculator above works this out for any price."}}
]}
</script>

## Related tools and guides

- [Eventbrite fee calculator (2026)](eventbrite-fee-calculator): 3.7% + $1.79 per paid ticket plus 2.9% processing, whether you absorb the fees or pass them on
- [Humanitix fee calculator (2026)](humanitix-fee-calculator): a 5% + $1.29 booking fee per paid ticket with card processing included, passed on to buyers by default
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): what card payments cost on PayPal and Stripe
- [Square fee calculator (2026)](square-fee-calculator): what card payments cost on Square, online and in person

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Luma. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
