---
layout: page
title: "Tito fee calculator (2026): what you keep from ti.to ticket sales"
description: "Free Tito (ti.to) fee calculator for US organizers. Tito charges 3% per paid ticket (2.5% for charity, non-profit and community events), Stripe adds 2.9% + $0.30 per order, and Tito can't pass fees on to buyers. See what you keep, orders needed and the price to charge."
---

Tito (ti.to) has no subscription and is free for free events. On **paid tickets** it charges **3% per ticket**, or **2.5%** for charity, non-profit and community events that apply for that rate, and your payment gateway charges its own fee on top: **2.9% + $0.30 per order** with Stripe in the US. Tito has **no option to pass fees on to buyers**, so buyers pay exactly the ticket price and both fees come out of it. A $25 ticket sold on its own costs $0.75 in Tito fees and $1.03 in Stripe fees and leaves you $23.22, or 92.9%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="tt" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tito rate<br><select id="tt-plan"><option value="standard" selected>Standard (3% per ticket)</option><option value="community">Charity, non-profit or community (2.5%)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Orders a month<br><input id="tt-n" type="number" min="0" step="1" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tickets per order<br><input id="tt-q" type="number" min="0" step="1" value="1" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Ticket price (USD)<br><input id="tt-p" type="number" min="0" step="0.01" value="25" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Tito fee cap per ticket in USD (0 = none)<br><input id="tt-cap" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Processing % per order<br><input id="tt-sp" type="number" min="0" step="0.01" value="2.9" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Processing fixed fee per order (USD)<br><input id="tt-sf" type="number" min="0" step="0.01" value="0.30" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="tt-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per order and per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Tickets</td><td style="text-align:right"><span id="tt-count">0</span></td></tr>
    <tr><td>Tito fee per ticket</td><td style="text-align:right"><span id="tt-tito1">$0.00</span></td></tr>
    <tr><td>Processing fee per order</td><td style="text-align:right"><span id="tt-gw1">$0.00</span></td></tr>
    <tr><td>You keep per order</td><td style="text-align:right"><span id="tt-keepo">$0.00</span></td></tr>
    <tr><td>You keep per ticket</td><td style="text-align:right"><span id="tt-keept">$0.00</span></td></tr>
    <tr><td>Ticket sales</td><td style="text-align:right"><span id="tt-sales">$0.00</span></td></tr>
    <tr><td>Tito fees in total</td><td style="text-align:right"><span id="tt-titot">$0.00</span></td></tr>
    <tr><td>Processing fees in total</td><td style="text-align:right"><span id="tt-gwt">$0.00</span></td></tr>
    <tr><td>All fees</td><td style="text-align:right"><span id="tt-fees">$0.00</span></td></tr>
    <tr><td>Fees as a share of ticket sales</td><td style="text-align:right"><span id="tt-eff">$0.00</span></td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="tt-net">$0.00</strong></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Orders needed and price to charge</h3>
  <p style="margin:0 0 8px"><label>I want to keep this much a month (USD)<br><input id="tt-target" type="number" min="0" step="0.01" value="5000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="tt-need" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to keep this much per ticket (USD)<br><input id="tt-want" type="number" min="0" step="0.01" value="50" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="tt-price" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Tito (ti.to) ticket fee math for US organizers (checked 2026-10-29 from ti.to/pricing and the Tito support blog). Tito fee per paid ticket: 3% standard, 2.5% for charity, non-profit and community events, capped at EUR 25 per ticket (entered here in USD, blank = no cap). Tito has no option to pass fees on to buyers, so the buyer pays the ticket price and both fees come out of it. Payment gateway fee charged separately per order; Stripe US 2.9% + $0.30 by default (editable). All math in integer cents; each component rounds to the nearest cent, half up; taxes, refunds and disputes left out. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 1000000, MAX_PER = 1000;
  var RATES = { standard: 300, community: 250 };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function per(v) { return Math.max(1, Math.min(Math.floor(num(v)), MAX_PER)); }
  function pct(v) { return Math.min(num(v), 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  function rateOf(plan) { return RATES[plan] || RATES.standard; }
  /* one order of q tickets at P cents each; capC = per-ticket Tito fee cap in cents (0 = none); spBps = gateway % in basis points; sfC = gateway fixed fee in cents per order */
  function orderC(P, q, plan, capC, spBps, sfC) {
    if (P <= 0) return { price: P > 0 ? P : 0, tickets: q, titoPer: 0, tito: 0, gateway: 0, fees: 0, total: 0, keep: 0 };
    var t = half(P * rateOf(plan)); if (capC > 0 && t > capC) t = capC;
    var total = P * q, g = half(total * spBps) + sfC;
    return { price: P, tickets: q, titoPer: t, tito: t * q, gateway: g, fees: t * q + g, total: total, keep: total - t * q - g };
  }
  function args(perOrder, plan, cap, sp, sf) { return [per(perOrder), plan, cents(amt(cap)), Math.round(pct(sp) * 100), cents(amt(sf))]; }
  function one(price, perOrder, plan, cap, sp, sf) { var a = args(perOrder, plan, cap, sp, sf); return orderC(cents(amt(price)), a[0], a[1], a[2], a[3], a[4]); }
  function calc(orders, perOrder, price, plan, cap, sp, sf) {
    var N = count(orders), O = one(price, perOrder, plan, cap, sp, sf), d = function (x) { return x / 100; };
    var sales = N * O.total, net = N * O.keep;
    return { orders: N, tickets: N * O.tickets, perTito: d(O.titoPer), perOrderGateway: d(O.gateway), perOrderKeep: d(O.keep), perTicketKeep: O.tickets > 0 ? d(O.keep) / O.tickets : 0,
      sales: d(sales), tito: d(N * O.tito), gateway: d(N * O.gateway), fees: d(N * O.fees), net: d(net), effective: sales > 0 ? (sales - net) / sales : null };
  }
  /* fewest orders whose total keep reaches target */
  function ordersFor(target, perOrder, price, plan, cap, sp, sf) {
    var T = cents(big(target)), K = one(price, perOrder, plan, cap, sp, sf).keep;
    if (T <= 0 || K <= 0) return null;
    var n = Math.ceil(T / K); if (n > MAX_QTY) return null;
    return { orders: n, tickets: n * per(perOrder), net: n * K / 100 };
  }
  /* lowest ticket price (whole cents) that keeps at least `want` per ticket */
  function priceFor(want, perOrder, plan, cap, sp, sf) {
    var W = cents(amt(want)); if (W <= 0) return null;
    var a = args(perOrder, plan, cap, sp, sf), q = a[0], k = function (p) { return orderC(p, q, a[1], a[2], a[3], a[4]).keep; };
    var lo = 1, hi = MAX_AMT * 100; if (k(hi) < W * q) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (k(m) >= W * q) hi = m; else lo = m + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, RATES: RATES, num: num, amt: amt, count: count, per: per, pct: pct, orderC: orderC, one: one, calc: calc, ordersFor: ordersFor, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.TitoFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.TitoFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var pl = $("tt-plan").value, n = $("tt-n").value, q = $("tt-q").value, p = $("tt-p").value, cap = $("tt-cap").value, sp = $("tt-sp").value, sf = $("tt-sf").value, w = [];
    var r = B.calc(n, q, p, pl, cap, sp, sf);
    if (B.amt(p) >= B.MAX_AMT || B.count(n) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (Number(sp) > 100) w.push("A processing rate above 100% counts as 100%.");
    if (B.amt(p) > 0 && r.perOrderKeep <= 0) w.push("At this price the fees take the whole order.");
    $("tt-warn").textContent = w.join(" ");
    set("tt-count", r.tickets.toLocaleString("en-US")); set("tt-tito1", money(r.perTito)); set("tt-gw1", money(r.perOrderGateway)); set("tt-keepo", money(r.perOrderKeep)); set("tt-keept", money(r.perTicketKeep)); set("tt-sales", money(r.sales)); set("tt-titot", money(r.tito)); set("tt-gwt", money(r.gateway)); set("tt-fees", money(r.fees)); set("tt-eff", pctS(r.effective)); set("tt-net", money(r.net));
    var T = $("tt-target").value, need = B.ordersFor(T, q, p, pl, cap, sp, sf);
    set("tt-need", B.amt(T) <= 0 ? "Enter how much you want to keep." : B.amt(p) <= 0 ? "Enter a ticket price." : need == null ? "No number of orders reaches that amount." : "You need " + need.orders.toLocaleString("en-US") + " orders a month (" + need.tickets.toLocaleString("en-US") + " tickets at " + money(B.amt(p)) + "), keeping " + money(need.net) + " after fees.");
    var W = $("tt-want").value, pr = B.priceFor(W, q, pl, cap, sp, sf);
    set("tt-price", B.amt(W) <= 0 ? "Enter how much you want to keep per ticket." : pr == null ? "No ticket price reaches that amount." : "Set the ticket price to " + money(pr) + " to keep at least " + money(B.amt(W)) + " per ticket with these settings.");
  }
  ["tt-plan", "tt-n", "tt-q", "tt-p", "tt-cap", "tt-sp", "tt-sf", "tt-target", "tt-want"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Tito fees for US organizers (checked Oct 29, 2026)

| | Fee |
|---|---|
| Tito fee, standard | 3% per paid ticket |
| Tito fee, charity, non-profit and community events | 2.5% per paid ticket (apply first) |
| Tito fee cap | €25 per ticket, reached above €833.33 at 3% |
| Free events | free |
| Stripe in the US (payment gateway) | 2.9% + $0.30 per transaction |
| Subscription, setup or premium-feature fees | none |

Tito's fee is charged on each paid ticket and the gateway's fee is charged on each payment, so buying several tickets in one order pays the $0.30 only once. The buyer always pays the listed ticket price: Tito chose not to offer a "pass fees on" setting, so if you want to cover the fees you raise the price and, if you like, say in the ticket description that it includes fees. The cap is set in euros, so the calculator lets you enter it in dollars at the current exchange rate; it is off by default because it only matters for tickets above roughly €833. PayPal is also supported with its own fees, which you can type into the processing fields.

These figures come from Tito's [pricing page](https://ti.to/pricing) and its support post [10 helpful answers for your FAQs](https://blog.tito.io/posts/tito-common-support-questions/), with the reasoning for no pass-on fees in [this Tito blog post](https://blog.tito.io/posts/added-booking-fees-on-tickets-or-how-we-want-to-reduce-stress/). The calculator leaves out taxes, refunds and disputes, and rounds each fee to the nearest cent.

## How the numbers are worked out

```
Tito fee      = 3% x ticket price per ticket   (2.5% charity or community), capped
Stripe fee    = 2.9% x order total + $0.30 per order
you keep      = order total - Tito fees - Stripe fee
```

Sold one per order, a $10 ticket keeps $9.11, a $50 ticket pays $3.25 in fees and keeps $46.75, and a $100 ticket keeps $93.80. Selling 100 single-ticket orders a month at $25 brings in $2,500.00, costs $75.00 in Tito fees and $103.00 in Stripe fees, and leaves $2,322.00. Sell the same 100 tickets as 50 orders of two and Stripe's fixed fee is paid half as often, so you keep $2,337.50. Tito's own blog example matches this math: a €95 ticket with 2.4% + €0.30 European card processing pays €2.85 to Tito and €2.58 to Stripe, leaving €89.57.

## FAQ

### How much does Tito charge per ticket?

Tito charges 3% of each paid ticket's price, or 2.5% for charity, non-profit and community events that apply for that rate, with the fee capped at €25 per ticket. Free tickets cost nothing. Your payment gateway charges separately, which is 2.9% + $0.30 per order with Stripe in the US. On a $25 ticket that is $0.75 to Tito and $1.03 to Stripe.

### Can I pass Tito fees on to ticket buyers?

No. Tito deliberately doesn't offer an option to add booking fees at checkout, so buyers pay the listed price and both fees come out of it. To cover the fees, raise the ticket price and mention that it includes fees if you want to.

### How much do I keep from a Tito ticket?

With one ticket per order and Stripe's US rate, you keep 91.1% of a $10 ticket, 92.9% of a $25 ticket, 93.5% of a $50 ticket and 93.8% of a $100 ticket. On the 2.5% charity or community rate you keep 91.6%, 93.4%, 94.0% and 94.3%. Stripe's fixed $0.30 per order is why cheaper tickets keep less.

### What should I charge on Tito to keep a set amount per ticket?

Raise the price to cover both fees. To keep $50 per ticket sold one per order, charge $53.45 on the standard rate or $53.17 on the charity or community rate. If buyers usually get four tickets per order, $53.22 is enough, because the $0.30 is shared.

### How many tickets do I need to sell on Tito to make a set amount?

Divide the amount you want by what each order leaves you and round up. At $25 a ticket, one ticket per order leaves $23.22, so keeping $5,000 a month takes 216 orders, which leaves $5,015.52. With two tickets per order it takes 107 orders, or 214 tickets, and on the charity or community rate it takes 215 single-ticket orders. The calculator above works this out for any price.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Tito charge per ticket?", "acceptedAnswer": {"@type": "Answer", "text": "Tito charges 3% of each paid ticket's price, or 2.5% for charity, non-profit and community events that apply for that rate, with the fee capped at €25 per ticket. Free tickets cost nothing. Your payment gateway charges separately, which is 2.9% + $0.30 per order with Stripe in the US. On a $25 ticket that is $0.75 to Tito and $1.03 to Stripe."}},
{"@type": "Question", "name": "Can I pass Tito fees on to ticket buyers?", "acceptedAnswer": {"@type": "Answer", "text": "No. Tito deliberately doesn't offer an option to add booking fees at checkout, so buyers pay the listed price and both fees come out of it. To cover the fees, raise the ticket price and mention that it includes fees if you want to."}},
{"@type": "Question", "name": "How much do I keep from a Tito ticket?", "acceptedAnswer": {"@type": "Answer", "text": "With one ticket per order and Stripe's US rate, you keep 91.1% of a $10 ticket, 92.9% of a $25 ticket, 93.5% of a $50 ticket and 93.8% of a $100 ticket. On the 2.5% charity or community rate you keep 91.6%, 93.4%, 94.0% and 94.3%. Stripe's fixed $0.30 per order is why cheaper tickets keep less."}},
{"@type": "Question", "name": "What should I charge on Tito to keep a set amount per ticket?", "acceptedAnswer": {"@type": "Answer", "text": "Raise the price to cover both fees. To keep $50 per ticket sold one per order, charge $53.45 on the standard rate or $53.17 on the charity or community rate. If buyers usually get four tickets per order, $53.22 is enough, because the $0.30 is shared."}},
{"@type": "Question", "name": "How many tickets do I need to sell on Tito to make a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Divide the amount you want by what each order leaves you and round up. At $25 a ticket, one ticket per order leaves $23.22, so keeping $5,000 a month takes 216 orders, which leaves $5,015.52. With two tickets per order it takes 107 orders, or 214 tickets, and on the charity or community rate it takes 215 single-ticket orders. The calculator above works this out for any price."}}
]}
</script>

## Related tools and guides

- [Humanitix fee calculator (2026)](humanitix-fee-calculator): a 5% + $1.29 booking fee per paid ticket with card processing included, passed on to buyers by default
- [Luma fee calculator (2026)](luma-fee-calculator): a 5% platform fee on paid tickets plus Stripe's 2.9% + $0.30, or 0% on Luma Plus
- [Eventbrite fee calculator (2026)](eventbrite-fee-calculator): 3.7% + $1.79 per paid ticket plus 2.9% processing, whether you absorb the fees or pass them on
- [Airbnb host fee calculator (2026)](airbnb-host-fee-calculator): the 15.5% single fee taken from your payout vs the 3% split fee plus the guest's 14.1% to 16.5%, on nightly price and cleaning fees

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Tito. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
