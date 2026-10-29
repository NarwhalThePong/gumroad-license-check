---
layout: page
title: "Square fee calculator (2026): Square Free, Plus and Premium processing fees and Instant transfers"
description: "Free Square fee calculator. See Square's fee on each payment for tap, dip or swipe, online and invoices, keyed-in cards, ACH and Afterpay on Square Free, Plus or Premium, add Instant transfer fees, compare plans by month and get the price to charge to keep a set amount."
---

Square takes its processing fee out of every card payment before the money reaches your bank. On the free plan, **Square Free**, a card you tap, dip or swipe in person costs **2.6% + 15¢**, an online or invoice card payment costs **3.3% + 30¢**, and a card you type in by hand or charge from a saved card costs **3.5% + 15¢**. The paid plans lower some of those rates: **Square Plus** ($49 a month per location) charges 2.5% + 15¢ in person and 2.9% + 30¢ online, and **Square Premium** ($149 a month per location) charges 2.4% + 15¢ in person and 2.9% + 30¢ online. Standard next-business-day transfers to your bank are free, and an **Instant transfer** costs **1.95%** of the amount. Enter your numbers below to see what you keep on each plan. Everything runs in your browser and nothing is sent anywhere.

<div id="sq" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 220px;margin:0 0 8px"><label>Square plan<br><select id="sq-plan" style="width:100%;max-width:320px"><option value="free">Square Free ($0 a month)</option><option value="plus">Square Plus ($49 a month)</option><option value="premium">Square Premium ($149 a month)</option></select></label></p>
    <p style="flex:1 1 260px;margin:0 0 8px"><label>How the customer pays<br><select id="sq-type" style="width:100%;max-width:320px"><option value="card">Tap, dip or swipe (in person)</option><option value="online">Online or invoice (card)</option><option value="api">Online API (your own app or site)</option><option value="keyed">Manual entry or card on file</option><option value="ach">ACH bank transfer (via invoice)</option><option value="afterpay">Afterpay</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment amount (USD)<br><input id="sq-price" type="number" min="0" step="0.01" value="20" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payments per month<br><input id="sq-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="sq-intl" type="checkbox"> Card issued outside the US (+1.5%)</label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label><input id="sq-instant" type="checkbox"> Use Instant transfers (1.95%)</label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Instant transfers per month<br><input id="sq-inst" type="number" min="0" step="1" value="1" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="sq-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per payment</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customer pays</td><td style="text-align:right" id="sq-s-price">$0.00</td></tr>
    <tr><td>Square rate for this payment</td><td style="text-align:right" id="sq-s-rate"></td></tr>
    <tr><td>Square processing fee</td><td style="text-align:right" id="sq-s-fee">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="sq-s-net">$0.00</strong></td></tr>
    <tr><td>Fee as a share of the payment</td><td style="text-align:right" id="sq-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Customers pay</td><td style="text-align:right" id="sq-m-gross">$0.00</td></tr>
    <tr><td>Square processing fees</td><td style="text-align:right" id="sq-m-fees">$0.00</td></tr>
    <tr><td>Plan fee (one location)</td><td style="text-align:right" id="sq-m-plan">$0.00</td></tr>
    <tr><td>Instant transfer fees</td><td style="text-align:right" id="sq-m-inst">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="sq-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what customers paid</td><td style="text-align:right" id="sq-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="sq-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Same month on each plan</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Square Free: you keep</td><td style="text-align:right" id="sq-c-free">$0.00</td></tr>
    <tr><td>Square Plus: you keep (after $49)</td><td style="text-align:right" id="sq-c-plus">$0.00</td></tr>
    <tr><td>Square Premium: you keep (after $149)</td><td style="text-align:right" id="sq-c-premium">$0.00</td></tr>
  </table>
  <p id="sq-c-best" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per payment after Square's fee (USD)<br><input id="sq-target" type="number" min="0" step="0.01" value="100" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="sq-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Square US fee math (squareup.com/us/en/pricing, squareup.com/help/us/en/article/5068-what-are-square-s-fees, squareup.com/help/us/en/article/3807-deposit-options-with-square, squareup.com/us/en/payments/instant-transfers, checked Oct 28, 2026). Square Free $0/mo, Plus $49/mo, Premium $149/mo per location. Tap, dip or swipe 2.6%/2.5%/2.4% + 15c; online or invoices 3.3% + 30c on Free, 2.9% + 30c on Plus and Premium; online API 2.9% + 30c; manual entry or card on file 3.5% + 15c; ACH bank transfer via invoice 1% with a $1 minimum (Plus and Premium cap it at $10); Afterpay 6% + 30c; extra 1.5% on cards issued outside the US; Instant transfer 1.95% of the amount ($25 minimum balance, $10,000 maximum per transfer); standard next-business-day transfer free. Square doesn't publish a rounding rule, so fees round to the nearest cent here. */
(function (root) {
  var CHECKED = "2026-10-28";
  /* bp = percentage in hundredths of a percent, fixed/min/cap in cents, so the math stays in whole cents. */
  var PLANS = {
    free: { label: "Square Free", monthly: 0, card: 260, online: 330, achCap: 0 },
    plus: { label: "Square Plus", monthly: 49, card: 250, online: 290, achCap: 1000 },
    premium: { label: "Square Premium", monthly: 149, card: 240, online: 290, achCap: 1000 }
  };
  var TYPES = {
    card: { label: "Tap, dip or swipe (in person)", fixed: 15, intl: true },
    online: { label: "Online or invoice (card)", fixed: 30, intl: true },
    api: { label: "Online API (your own app or site)", bp: 290, fixed: 30, intl: true },
    keyed: { label: "Manual entry or card on file", bp: 350, fixed: 15, intl: true },
    ach: { label: "ACH bank transfer (via invoice)", bp: 100, fixed: 0, min: 100, intl: false },
    afterpay: { label: "Afterpay", bp: 600, fixed: 30, intl: false }
  };
  var INTL_BP = 150, IT_BP = 195, IT_MIN_BAL = 25, IT_MAX = 10000, MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function plan(p) { return PLANS[p] ? p : "free"; }
  function type(t) { return TYPES[t] ? t : "card"; }
  function cents(x) { return Math.round(x * 100); }
  /* round c*bp/10000 to the nearest cent (half a cent rounds up) */
  function pctCents(c, bp) { return Math.floor((c * bp + 5000) / 10000); }
  function rate(p, t, intl) {
    var P = PLANS[plan(p)], T = TYPES[type(t)];
    var bp = t === "card" ? P.card : t === "online" ? P.online : T.bp;
    return bp + (intl && T.intl ? INTL_BP : 0);
  }
  function feeCents(c, p, t, intl) {
    if (c <= 0) return 0;
    t = type(t); var T = TYPES[t], P = PLANS[plan(p)], f = pctCents(c, rate(p, t, intl)) + T.fixed;
    if (t === "ach") { f = Math.max(f, T.min); if (P.achCap) f = Math.min(f, P.achCap); f = Math.min(f, c); }
    return f;
  }
  function fee(x, p, t, intl) { return feeCents(cents(amt(x)), p, t, intl) / 100; }
  function calc(x, p, t, intl) {
    var price = amt(x); if (price <= 0) return { price: 0, fee: 0, net: 0, effective: null };
    var c = cents(price), f = feeCents(c, p, t, intl);
    return { price: price, fee: f / 100, net: (c - f) / 100, effective: f / c };
  }
  function instantFee(x) { var c = cents(amt(x)); return c > 0 ? pctCents(c, IT_BP) / 100 : 0; }
  /* Monthly: payments x fee, the plan's monthly fee for one location, then optional Instant transfers (what's left split evenly over k transfers). */
  function perMonth(x, p, t, q, k, intl) {
    var s = calc(x, p, t, intl), n = count(q), gross = r2(s.price * n), fees = r2(s.fee * n), sub = PLANS[plan(p)].monthly;
    var bal = r2(gross - fees), m = count(k), inst = 0, each = 0;
    if (m > 0 && bal > 0) { each = r2(bal / m); inst = r2(instantFee(each) * m); }
    var net = r2(bal - inst - sub);
    return { sale: s, count: n, gross: gross, fees: fees, plan: sub, instant: inst, each: each, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  function compare(x, t, q, k, intl) { var o = {}; for (var p in PLANS) o[p] = perMonth(x, p, t, q, k, intl); return o; }
  /* Smallest price (to the cent) that keeps at least T per payment. What you keep never drops as the price rises, so a binary search finds it. */
  function priceFor(T, p, t, intl) {
    var target = amt(T); if (target <= 0) return null;
    var tc = cents(target), lo = 1, hi = MAX_AMT * 100;
    if (hi - feeCents(hi, p, t, intl) < tc) return null;
    while (lo < hi) { var mid = Math.floor((lo + hi) / 2); if (mid - feeCents(mid, p, t, intl) >= tc) hi = mid; else lo = mid + 1; }
    return lo / 100;
  }
  var api = { CHECKED: CHECKED, PLANS: PLANS, TYPES: TYPES, INTL_BP: INTL_BP, IT_BP: IT_BP, IT_MIN_BAL: IT_MIN_BAL, IT_MAX: IT_MAX, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, plan: plan, type: type, rate: rate, fee: fee, calc: calc, instantFee: instantFee, perMonth: perMonth, compare: compare, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.SquareFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.SquareFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function rateText(p, t, intl) {
    var T = B.TYPES[B.type(t)], P = B.PLANS[B.plan(p)], pc = (B.rate(p, t, intl) / 100) + "%";
    if (B.type(t) === "ach") return pc + ", $1 minimum" + (P.achCap ? ", $10 cap" : "");
    return pc + " + " + T.fixed + "\u00a2";
  }
  function update() {
    var pl = $("sq-plan").value, ty = $("sq-type").value, x = $("sq-price").value, intl = $("sq-intl").checked, on = $("sq-instant").checked, k = on ? $("sq-inst").value : 0, w = [];
    var m = B.perMonth(x, pl, ty, $("sq-qty").value, k, intl), c = m.sale;
    if (B.amt(x) >= B.MAX_AMT || B.count($("sq-qty").value) >= B.MAX_QTY) w.push("Large numbers are capped.");
    if (intl && !B.TYPES[B.type(ty)].intl) w.push("The 1.5% international card fee doesn't apply to ACH or Afterpay payments.");
    if (on && m.each > 0 && m.each < B.IT_MIN_BAL) w.push("Each Instant transfer needs a balance of at least $25 after fees.");
    if (on && m.each > B.IT_MAX) w.push("One Instant transfer can move at most $10,000, so add more transfers.");
    $("sq-warn").textContent = w.join(" ");
    set("sq-s-price", money(c.price)); set("sq-s-rate", rateText(pl, ty, intl)); set("sq-s-fee", money(c.fee)); set("sq-s-net", money(c.net)); set("sq-s-eff", pctS(c.effective));
    set("sq-m-gross", money(m.gross)); set("sq-m-fees", money(m.fees)); set("sq-m-plan", money(m.plan)); set("sq-m-inst", money(m.instant));
    set("sq-m-net", money(m.net)); set("sq-m-eff", pctS(m.effective)); set("sq-y-net", money(m.year));
    var cmp = B.compare(x, ty, $("sq-qty").value, k, intl), best = "free";
    ["free", "plus", "premium"].forEach(function (p) { set("sq-c-" + p, money(cmp[p].net)); if (cmp[p].net > cmp[best].net + 1e-9) best = p; });
    set("sq-c-best", m.gross > 0 ? "At these numbers, " + B.PLANS[best].label + " leaves you the most each month." : "");
    var need = B.priceFor($("sq-target").value, pl, ty, intl);
    set("sq-need", B.amt($("sq-target").value) <= 0 ? "Enter how much you want to keep per payment." : need == null ? "No price works for that amount." : "Charge " + money(need) + " to keep " + money(B.amt($("sq-target").value)) + " per payment after Square's fee (" + B.PLANS[B.plan(pl)].label + ", " + B.TYPES[B.type(ty)].label.toLowerCase() + ").");
  }
  ["sq-plan", "sq-type", "sq-price", "sq-qty", "sq-intl", "sq-instant", "sq-inst", "sq-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Square fees in the US (checked Oct 28, 2026)

| How the customer pays | Square Free ($0/mo) | Square Plus ($49/mo) | Square Premium ($149/mo) |
|---|---|---|---|
| Tap, dip or swipe (card present, including Tap to Pay on iPhone and Android) | 2.6% + 15¢ | 2.5% + 15¢ | 2.4% + 15¢ |
| Online or invoices (card) | 3.3% + 30¢ | 2.9% + 30¢ | 2.9% + 30¢ |
| Online API (payments inside your own web or mobile app) | 2.9% + 30¢ | 2.9% + 30¢ | 2.9% + 30¢ |
| Manual entry or card on file | 3.5% + 15¢ | 3.5% + 15¢ | 3.5% + 15¢ |
| ACH bank transfer (via invoice) | 1%, $1 minimum | 1%, $1 minimum, $10 cap | 1%, $1 minimum, $10 cap |
| Afterpay | 6% + 30¢ | 6% + 30¢ | 6% + 30¢ |
| Card issued outside the US | extra 1.5% | extra 1.5% | extra 1.5% |
| Cash or check | Free | Free | Free |

| Getting your money | What it costs |
|---|---|
| Standard transfer to your bank | Free, as soon as the next business day. |
| Instant transfer to your bank or debit card | 1.95% of the amount. You need at least $25 after fees, and one transfer can move up to $10,000. |
| Same-day transfer (automatic, at your close of day) | 1.95% of the amount. |

Rates are from Square's own pages: [Square pricing](https://squareup.com/us/en/pricing), [Learn about Square fees](https://squareup.com/help/us/en/article/5068-what-are-square-s-fees), [Set up and edit transfer options](https://squareup.com/help/us/en/article/3807-deposit-options-with-square) and [Square Transfers](https://squareup.com/us/en/payments/instant-transfers). Square takes its fee from the full payment, including tax and tip, and the same rate applies to every card brand. The monthly plan fee is charged per location; the calculator counts one. ACH payments that land in a Square Checking account have no fee, and businesses processing over $250,000 a year can ask Square about custom rates, neither of which is modeled here. Square doesn't publish how it rounds a fraction of a cent, so the calculator rounds each fee to the nearest cent and may be a cent off on some amounts. Fees can change, so check the Pricing & subscriptions page in your Square Dashboard for your exact rates.

## How the numbers are worked out

```
processing fee = payment x rate + fixed fee        (card and Afterpay payments)
               = payment x 1%, at least $1         (ACH via invoice; at most $10 on Plus and Premium)
you keep       = payment - processing fee
instant fee    = transfer x 1.95%
per month      = you keep x payments - Instant transfer fees - plan fee
```

A $100 tap, dip or swipe payment on Square Free costs $2.75, so you keep $97.25. The same payment costs $2.65 on Square Plus and $2.55 on Square Premium. A $100 online or invoice card payment costs $3.60 on Square Free and $3.20 on Plus or Premium, and a $100 card typed in by hand costs $3.65 on every plan. A $2,000 invoice paid by ACH costs $20.00 on Square Free and $10.00 on Plus or Premium. At 100 in-person payments of $20 a month, Square Free keeps $1,933.00, or $23,196.00 a year. Square Plus keeps $1,886.00 after its $49 fee and Square Premium keeps $1,788.00 after its $149 fee. Moving Square Free's $1,933.00 with one Instant transfer costs $37.69, leaving $1,895.31. To keep $100 per payment, charge $102.82 in person on Square Free, or $103.72 for an online or invoice payment on Square Free ($103.30 on Plus or Premium).

## When does Square Plus or Premium pay off?

The paid plans only save money on in-person and online card payments. Square Plus takes 0.1 percentage points less than Square Free on tap, dip or swipe, so its $49 a month pays for itself at about $49,000 a month of in-person card sales. Online and invoice payments save 0.4 points on Plus, so the break-even there is about $12,250 a month. Square Premium saves 0.2 points in person and 0.4 points online against Square Free, which takes about $74,500 a month in person or about $37,250 a month online to cover its $149. Keyed-in, online API, ACH under $1,000 and Afterpay payments cost the same on every plan. The paid plans also add features such as loyalty, staff tools and phone support, which may matter more to you than the fee math.

## FAQ

### How much does Square charge per transaction in 2026?

On Square Free, 2.6% + 15¢ for a card you tap, dip or swipe in person, 3.3% + 30¢ for an online or invoice card payment, 2.9% + 30¢ through the online API, and 3.5% + 15¢ for a card entered by hand or charged from a saved card. Square Plus and Square Premium lower the in-person rate to 2.5% + 15¢ and 2.4% + 15¢, and the online and invoice rate to 2.9% + 30¢.

### How much is the Square fee on $100?

On Square Free, $2.75 for a tap, dip or swipe payment (you keep $97.25), $3.60 for an online or invoice card payment and $3.65 for a card typed in by hand. On Square Plus the in-person fee is $2.65 and on Square Premium it's $2.55.

### How much does a Square Instant transfer cost?

Square charges 1.95% of the amount for an Instant transfer or a same-day transfer. You need a balance of at least $25 after fees, and one Instant transfer can move up to $10,000. Standard transfers, which arrive as soon as the next business day, are free.

### Does Square charge for invoices?

Sending invoices is free, but each paid invoice has a processing fee. A card payment on an invoice costs 3.3% + 30¢ on Square Free and 2.9% + 30¢ on Square Plus or Premium. An invoice paid by ACH bank transfer costs 1% with a $1 minimum, capped at $10 on Square Plus and Premium.

### What should I charge on Square to keep a set amount?

Add the fixed fee to what you want to keep, divide by one minus the rate, and round up to the cent. Keeping $100 from an in-person payment on Square Free means (100 + 0.15) / 0.974, which gives $102.82. For an online or invoice payment on Square Free it's (100 + 0.30) / 0.967, or $103.72.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Square charge per transaction in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "On Square Free, 2.6% + 15¢ for a card you tap, dip or swipe in person, 3.3% + 30¢ for an online or invoice card payment, 2.9% + 30¢ through the online API, and 3.5% + 15¢ for a card entered by hand or charged from a saved card. Square Plus and Square Premium lower the in-person rate to 2.5% + 15¢ and 2.4% + 15¢, and the online and invoice rate to 2.9% + 30¢."}},
{"@type": "Question", "name": "How much is the Square fee on $100?", "acceptedAnswer": {"@type": "Answer", "text": "On Square Free, $2.75 for a tap, dip or swipe payment (you keep $97.25), $3.60 for an online or invoice card payment and $3.65 for a card typed in by hand. On Square Plus the in-person fee is $2.65 and on Square Premium it's $2.55."}},
{"@type": "Question", "name": "How much does a Square Instant transfer cost?", "acceptedAnswer": {"@type": "Answer", "text": "Square charges 1.95% of the amount for an Instant transfer or a same-day transfer. You need a balance of at least $25 after fees, and one Instant transfer can move up to $10,000. Standard transfers, which arrive as soon as the next business day, are free."}},
{"@type": "Question", "name": "Does Square charge for invoices?", "acceptedAnswer": {"@type": "Answer", "text": "Sending invoices is free, but each paid invoice has a processing fee. A card payment on an invoice costs 3.3% + 30¢ on Square Free and 2.9% + 30¢ on Square Plus or Premium. An invoice paid by ACH bank transfer costs 1% with a $1 minimum, capped at $10 on Square Plus and Premium."}},
{"@type": "Question", "name": "What should I charge on Square to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Add the fixed fee to what you want to keep, divide by one minus the rate, and round up to the cent. Keeping $100 from an in-person payment on Square Free means (100 + 0.15) / 0.974, which gives $102.82. For an online or invoice payment on Square Free it's (100 + 0.30) / 0.967, or $103.72."}}
]}
</script>

## Related tools and guides

- [Cash App for Business fee calculator (2026)](cash-app-fee-calculator): Cash App's 2.6% + $0.15 business payment fee and 3% Tap to Pay fee, plus Instant transfer costs
- [Venmo fee calculator (2026)](venmo-fee-calculator): Venmo's 2.99% goods-and-services fee against its business profile's 1.9% + $0.10
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): PayPal's own goods-and-services and checkout fees, next to Stripe's card fees
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Freelance hourly rate calculator](freelance-hourly-rate-calculator): set a rate that covers fees, taxes and time off
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from your sales
- [Invoice late fee calculator](invoice-late-fee-calculator): work out a late fee on an unpaid invoice

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Square or Block, Inc. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
