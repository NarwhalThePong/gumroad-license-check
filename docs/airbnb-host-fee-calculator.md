---
layout: page
title: "Airbnb host fee calculator (2026): your payout after Airbnb's service fee"
description: "Free Airbnb host fee calculator for US hosts. Single fee: Airbnb deducts 15.5% from your payout for most hosts. Split fee (being phased out): you pay 3% and guests pay 14.1% to 16.5%. See your payout per stay, monthly totals, the nightly price to charge and what guests pay."
---

Airbnb charges a service fee on every confirmed booking, and there are two ways it's charged for stays. On the **single fee**, which Airbnb is moving all home hosts to, the **whole fee comes out of your payout: 15.5% for most hosts** (others typically pay 14% to 16%). On the older **split fee**, which is being phased out, **you pay 3%** and **the guest pays 14.1% to 16.5%** on top of your price. Both are worked out on the booking subtotal: your nightly price times the nights plus any fees you charge, such as cleaning, before taxes. A 3-night stay at $150 a night with a $75 cleaning fee has a $525.00 subtotal. On the single fee Airbnb keeps $81.38, you're paid $443.62 and the guest pays $525.00. On the split fee you pay $15.75 and are paid $509.25, while the guest pays $599.03, including a $74.03 guest fee at 14.1%. Enter your numbers below. Everything runs in your browser and nothing is sent anywhere.

<div id="ab" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Fee structure<br><select id="ab-fs"><option value="single" selected>Single fee (host pays all, 15.5%)</option><option value="split">Split fee (host 3%, guest 14.1% to 16.5%)</option></select></label></p>
  </div>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Single fee %<br><input id="ab-sg" type="number" min="0" step="0.01" value="15.5" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Split fee: your host fee %<br><input id="ab-hp" type="number" min="0" step="0.01" value="3" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Split fee: guest fee % (set by Airbnb)<br><input id="ab-gp" type="number" min="0" step="0.01" value="14.1" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p style="margin:0 0 8px;font-size:0.9em">Airbnb sets your fee and the guest's fee for each booking; you can't choose them. Check your own rate under Earnings and edit the percentages to match.</p>
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Nightly price (USD)<br><input id="ab-p" type="number" min="0" step="0.01" value="150" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Nights per stay<br><input id="ab-n" type="number" min="0" step="1" value="3" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Cleaning fee per stay (USD)<br><input id="ab-c" type="number" min="0" step="0.01" value="75" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Other host fees per stay (USD)<br><input id="ab-o" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Stays a month<br><input id="ab-s" type="number" min="0" step="1" value="8" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  </div>
  <p id="ab-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per stay</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Booking subtotal</td><td style="text-align:right"><span id="ab-sub">$0.00</span></td></tr>
    <tr><td>Guest service fee</td><td style="text-align:right"><span id="ab-gfee">$0.00</span></td></tr>
    <tr><td>Guest pays (before taxes)</td><td style="text-align:right"><span id="ab-guest">$0.00</span></td></tr>
    <tr><td>Airbnb host fee</td><td style="text-align:right"><span id="ab-hfee">$0.00</span></td></tr>
    <tr><td>Your payout per stay</td><td style="text-align:right"><strong id="ab-pay">$0.00</strong></td></tr>
    <tr><td>Payout per night</td><td style="text-align:right"><span id="ab-pn">$0.00</span></td></tr>
    <tr><td>Host fee as a share of the subtotal</td><td style="text-align:right"><span id="ab-eff">0%</span></td></tr>
    <tr><td>Airbnb's total fees as a share of what the guest pays</td><td style="text-align:right"><span id="ab-share">0%</span></td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month and per year</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Stays</td><td style="text-align:right"><span id="ab-count">0</span></td></tr>
    <tr><td>Bookings a month (subtotals)</td><td style="text-align:right"><span id="ab-msub">$0.00</span></td></tr>
    <tr><td>Host fees a month</td><td style="text-align:right"><span id="ab-mfee">$0.00</span></td></tr>
    <tr><td>Payout a month</td><td style="text-align:right"><strong id="ab-mpay">$0.00</strong></td></tr>
    <tr><td>Host fees a year</td><td style="text-align:right"><span id="ab-yfee">$0.00</span></td></tr>
    <tr><td>Payout a year</td><td style="text-align:right"><strong id="ab-ypay">$0.00</strong></td></tr>
  </table>
  <p id="ab-cmp" style="margin:0 0 8px"></p>
  <h3 style="margin:16px 0 8px">Price to charge and stays needed</h3>
  <p style="margin:0 0 8px"><label>I want to be paid this much per stay (USD)<br><input id="ab-want" type="number" min="0" step="0.01" value="500" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="ab-price" style="margin:0 0 8px;font-weight:bold"></p>
  <p style="margin:0 0 8px"><label>I want to be paid this much a month (USD)<br><input id="ab-target" type="number" min="0" step="0.01" value="3000" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="ab-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Airbnb stay service fee math for US hosts (checked 2026-10-29 from airbnb.com/help/article/1857). Single fee: the entire fee is deducted from the host payout, 15.5% for most hosts (others typically 14%-16%). Split fee (being phased out): host pays 3% for most hosts, guest pays 14.1%-16.5% of the booking subtotal (up to 16.5% on cross-currency bookings). Booking subtotal = nightly price x nights + fees charged by the host (cleaning and other fees), excluding the guest service fee and taxes. All math in integer cents; each fee rounds to the nearest cent, half up; taxes left out. */
(function (root) {
  var CHECKED = "2026-10-29", MAX_AMT = 100000, MAX_QTY = 100000, MAX_NIGHTS = 365;
  var RATES = { single: 1550, splitHost: 300, guestLow: 1410, guestHigh: 1650, singleLow: 1400, singleHigh: 1600 };
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(num(v), MAX_AMT); }
  function big(v) { return Math.min(num(v), MAX_AMT * 100); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function nights(v) { return Math.max(1, Math.min(Math.floor(num(v)), MAX_NIGHTS)); }
  function pct(v) { return Math.min(num(v), 100); }
  function bps(v) { return Math.round(pct(v) * 100); }
  function cents(v) { return Math.round(v * 100); }
  function half(x) { return Math.floor((x + 5000) / 10000); }
  /* one stay: P = nightly price cents, n nights, F = host-charged fees cents (cleaning + other); split = true for split fee; hB/gB = host/guest fee in basis points */
  function stayC(P, n, F, split, hB, gB) {
    var sub = P * n + F, host = half(sub * hB), guest = split ? half(sub * gB) : 0;
    return { nightly: P, nights: n, subtotal: sub, hostFee: host, guestFee: guest, guestPays: sub + guest, airbnb: host + guest, payout: sub - host };
  }
  function args(n, clean, other, structure, singlePct, hostPct, guestPct) {
    var split = structure === "split";
    return [nights(n), cents(amt(clean)) + cents(amt(other)), split, split ? bps(hostPct) : bps(singlePct), bps(guestPct)];
  }
  function one(price, n, clean, other, structure, singlePct, hostPct, guestPct) { var a = args(n, clean, other, structure, singlePct, hostPct, guestPct); return stayC(cents(amt(price)), a[0], a[1], a[2], a[3], a[4]); }
  function calc(stays, price, n, clean, other, structure, singlePct, hostPct, guestPct) {
    var S = count(stays), O = one(price, n, clean, other, structure, singlePct, hostPct, guestPct), d = function (x) { return x / 100; };
    return { stays: S, nights: O.nights, subtotal: d(O.subtotal), guestPays: d(O.guestPays), hostFee: d(O.hostFee), guestFee: d(O.guestFee), payout: d(O.payout), perNight: O.payout / O.nights / 100,
      monthSubtotal: d(S * O.subtotal), monthFees: d(S * O.hostFee), monthPayout: d(S * O.payout), yearPayout: d(12 * S * O.payout), yearFees: d(12 * S * O.hostFee),
      effective: O.subtotal > 0 ? O.hostFee / O.subtotal : null, airbnbShare: O.guestPays > 0 ? O.airbnb / O.guestPays : null };
  }
  /* lowest nightly price (whole cents) whose payout per stay reaches `want` */
  function priceForC(W, a) {
    var k = function (p) { return stayC(p, a[0], a[1], a[2], a[3], a[4]).payout; };
    if (W <= 0) return null; var lo = 0, hi = MAX_AMT * 100; if (k(hi) < W) return null;
    while (lo < hi) { var m = Math.floor((lo + hi) / 2); if (k(m) >= W) hi = m; else lo = m + 1; }
    return lo;
  }
  function priceFor(want, n, clean, other, structure, singlePct, hostPct, guestPct) { var p = priceForC(cents(amt(want)), args(n, clean, other, structure, singlePct, hostPct, guestPct)); return p == null ? null : p / 100; }
  /* fewest stays a month whose payout reaches target */
  function staysFor(target, price, n, clean, other, structure, singlePct, hostPct, guestPct) {
    var T = cents(big(target)), K = one(price, n, clean, other, structure, singlePct, hostPct, guestPct).payout;
    if (T <= 0 || K <= 0) return null;
    var s = Math.ceil(T / K); if (s > MAX_QTY) return null;
    return { stays: s, payout: s * K / 100 };
  }
  /* for the same payout per stay, the lowest nightly price under each structure and what the guest pays */
  function compare(want, n, clean, other, singlePct, hostPct, guestPct) {
    var W = cents(amt(want)), r = {};
    ["single", "split"].forEach(function (s) { var a = args(n, clean, other, s, singlePct, hostPct, guestPct), p = priceForC(W, a); r[s] = p == null ? null : (function (x) { return { nightly: x.nightly / 100, guestPays: x.guestPays / 100, payout: x.payout / 100 }; })(stayC(p, a[0], a[1], a[2], a[3], a[4])); });
    return r;
  }
  var api = { CHECKED: CHECKED, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, RATES: RATES, num: num, amt: amt, count: count, nights: nights, pct: pct, stayC: stayC, one: one, calc: calc, priceFor: priceFor, staysFor: staysFor, compare: compare };
  if (typeof module !== "undefined" && module.exports) module.exports = api;
  if (root) root.AirbnbFees = api;
})(typeof window !== "undefined" ? window : null);
</script>

<script>
(function () {
  var B = window.AirbnbFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var fs = $("ab-fs").value, sg = $("ab-sg").value, hp = $("ab-hp").value, gp = $("ab-gp").value, p = $("ab-p").value, n = $("ab-n").value, c = $("ab-c").value, o = $("ab-o").value, s = $("ab-s").value, w = [];
    var r = B.calc(s, p, n, c, o, fs, sg, hp, gp);
    if (B.amt(p) >= B.MAX_AMT || B.amt(c) >= B.MAX_AMT || B.amt(o) >= B.MAX_AMT || B.count(s) >= B.MAX_QTY || Number(n) > 365) w.push("Large numbers are capped.");
    if ([sg, hp, gp].some(function (v) { return Number(v) > 100; })) w.push("A fee above 100% counts as 100%.");
    if (fs === "split" && (B.pct(gp) < 14.1 || B.pct(gp) > 16.5)) w.push("Airbnb's guest fee on the split fee is 14.1% to 16.5%.");
    $("ab-warn").textContent = w.join(" ");
    set("ab-sub", money(r.subtotal)); set("ab-guest", money(r.guestPays)); set("ab-gfee", money(r.guestFee)); set("ab-hfee", money(r.hostFee)); set("ab-pay", money(r.payout)); set("ab-pn", money(r.perNight)); set("ab-eff", pctS(r.effective)); set("ab-share", pctS(r.airbnbShare));
    set("ab-count", r.stays.toLocaleString("en-US")); set("ab-msub", money(r.monthSubtotal)); set("ab-mfee", money(r.monthFees)); set("ab-mpay", money(r.monthPayout)); set("ab-ypay", money(r.yearPayout)); set("ab-yfee", money(r.yearFees));
    var cm = B.compare(r.payout, n, c, o, sg, hp, gp);
    set("ab-cmp", r.payout <= 0 ? "" : cm.single == null || cm.split == null ? "" : "For the same " + money(r.payout) + " payout per stay, on the single fee you would charge " + money(cm.single.nightly) + " a night and the guest pays " + money(cm.single.guestPays) + "; on the split fee you would charge " + money(cm.split.nightly) + " a night and the guest pays " + money(cm.split.guestPays) + ".");
    var W = $("ab-want").value, pr = B.priceFor(W, n, c, o, fs, sg, hp, gp);
    set("ab-price", B.amt(W) <= 0 ? "Enter how much you want to be paid per stay." : pr == null ? "No nightly price reaches that payout." : pr === 0 ? "Your cleaning and other fees already pay you that much." : "Set the nightly price to " + money(pr) + " to be paid at least " + money(B.amt(W)) + " per " + B.nights(n) + "-night stay with these settings.");
    var T = $("ab-target").value, need = B.staysFor(T, p, n, c, o, fs, sg, hp, gp);
    set("ab-need", B.amt(T) <= 0 ? "Enter how much you want to be paid a month." : need == null ? "Enter a nightly price or fees that leave you a payout." : "You need " + need.stays.toLocaleString("en-US") + " stays a month (" + (need.stays * B.nights(n)).toLocaleString("en-US") + " nights), paying you " + money(need.payout) + ".");
  }
  ["ab-fs", "ab-sg", "ab-hp", "ab-gp", "ab-p", "ab-n", "ab-c", "ab-o", "ab-s", "ab-want", "ab-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Airbnb service fees for US hosts (checked Oct 29, 2026)

| | Host pays | Guest pays |
|---|---|---|
| Single fee, most hosts | 15.5% of the booking subtotal, taken from the payout | no service fee |
| Single fee, other hosts | typically 14% to 16% | no service fee |
| Split fee, most hosts (being phased out) | 3% of the booking subtotal | 14.1% to 16.5% of the booking subtotal |
| Split fee, cross-currency bookings | 3% | up to 16.5% |
| Services (not stays) | typically 15%, $6 minimum | |
| Experiences (not stays) | typically 20% | |

The booking subtotal is the nightly price times the nights plus any fees you charge, such as a cleaning fee, and it leaves out the guest service fee and taxes. Airbnb is moving all home hosts to the single fee, and it's already required for most hosts, including hotels and serviced apartments and hosts who use property management software. Once you switch you can't switch back, but bookings made before the switch keep the old fees even if the stay comes later. On the split fee, Airbnb sets the guest fee for each booking, based on a variety of factors, so the calculator starts at the low end of 14.1% and lets you change it. Airbnb's article doesn't spell out what the single fee is a percentage of, so the calculator applies it to the same booking subtotal.

These figures come from Airbnb's help article [Airbnb service fees](https://www.airbnb.com/help/article/1857). Airbnb can change its fees at any time. The calculator leaves out taxes such as occupancy taxes (Airbnb's fees don't apply to them), cancellations and refunds, and rounds each fee to the nearest cent.

## How the numbers are worked out

```
booking subtotal = nightly price x nights + cleaning fee + other host fees
single fee:  host fee = 15.5% x subtotal      guest pays = subtotal
split fee:   host fee = 3% x subtotal         guest pays = subtotal + 14.1% to 16.5% x subtotal
your payout      = subtotal - host fee
```

For a single $100 night with no cleaning fee, the single fee pays you $84.50 and the guest pays $100.00, while the split fee pays you $97.00 and the guest pays $114.10. Hosting the 3-night, $150 a night stay with a $75 cleaning fee 8 times a month pays $3,548.96 a month and $42,587.52 a year on the single fee, after $651.04 a month in fees, or $4,074.00 a month on the split fee. On the same stay a 14% single fee would pay you $451.50 and a 16% fee $441.00. On the split fee a 16.5% guest fee would be $86.63, so the guest would pay $611.63. That's why hosts who move to the single fee usually raise their prices: to keep the same $509.25 they were paid on the split fee, the nightly price goes up to $175.89 and the guest pays $602.67 instead of $599.03.

## FAQ

### How much does Airbnb charge hosts in 2026?

On the single fee, which most hosts now use, Airbnb deducts 15.5% of the booking subtotal from your payout, and some hosts pay 14% to 16%. On the older split fee you pay 3% and the guest pays a separate 14.1% to 16.5%. On a 3-night stay at $150 a night with a $75 cleaning fee, that's $81.38 on the single fee or $15.75 on the split fee.

### What is the difference between Airbnb's split fee and single fee?

With the split fee, you pay 3% and the guest pays a service fee of 14.1% to 16.5% on top of your price. With the single fee, the guest pays no service fee and the whole fee, 15.5% for most hosts, comes out of your payout. Airbnb is moving all home hosts to the single fee, and once you switch you can't switch back.

### How much will I get paid for an Airbnb booking?

Your payout is the nightly price times the nights plus your cleaning and other fees, minus Airbnb's host fee. A 3-night stay at $150 a night with a $75 cleaning fee pays you $443.62 on the single fee, or $147.87 a night, and $509.25 on the split fee. Taxes the guest pays aren't part of your payout.

### What nightly price should I set on Airbnb to be paid a set amount?

Raise the price until the payout after the fee reaches your number. To be paid $500 for a 3-night stay with a $75 cleaning fee, charge $172.24 a night on the single fee or $146.82 on the split fee. At $150 a night it takes 7 stays a month to be paid $3,000 on the single fee, which pays $3,105.34, or 6 stays on the split fee.

### Does Airbnb's service fee apply to the cleaning fee and taxes?

It applies to the cleaning fee and any other fees you charge, because they're part of the booking subtotal, but not to taxes. On the split fee the guest service fee is also worked out on the subtotal, so a $75 cleaning fee adds $2.25 to your 3% fee and $10.58 to a 14.1% guest fee. On the single fee it adds $11.63 to your fee.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Airbnb charge hosts in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "On the single fee, which most hosts now use, Airbnb deducts 15.5% of the booking subtotal from your payout, and some hosts pay 14% to 16%. On the older split fee you pay 3% and the guest pays a separate 14.1% to 16.5%. On a 3-night stay at $150 a night with a $75 cleaning fee, that's $81.38 on the single fee or $15.75 on the split fee."}},
{"@type": "Question", "name": "What is the difference between Airbnb's split fee and single fee?", "acceptedAnswer": {"@type": "Answer", "text": "With the split fee, you pay 3% and the guest pays a service fee of 14.1% to 16.5% on top of your price. With the single fee, the guest pays no service fee and the whole fee, 15.5% for most hosts, comes out of your payout. Airbnb is moving all home hosts to the single fee, and once you switch you can't switch back."}},
{"@type": "Question", "name": "How much will I get paid for an Airbnb booking?", "acceptedAnswer": {"@type": "Answer", "text": "Your payout is the nightly price times the nights plus your cleaning and other fees, minus Airbnb's host fee. A 3-night stay at $150 a night with a $75 cleaning fee pays you $443.62 on the single fee, or $147.87 a night, and $509.25 on the split fee. Taxes the guest pays aren't part of your payout."}},
{"@type": "Question", "name": "What nightly price should I set on Airbnb to be paid a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Raise the price until the payout after the fee reaches your number. To be paid $500 for a 3-night stay with a $75 cleaning fee, charge $172.24 a night on the single fee or $146.82 on the split fee. At $150 a night it takes 7 stays a month to be paid $3,000 on the single fee, which pays $3,105.34, or 6 stays on the split fee."}},
{"@type": "Question", "name": "Does Airbnb's service fee apply to the cleaning fee and taxes?", "acceptedAnswer": {"@type": "Answer", "text": "It applies to the cleaning fee and any other fees you charge, because they're part of the booking subtotal, but not to taxes. On the split fee the guest service fee is also worked out on the subtotal, so a $75 cleaning fee adds $2.25 to your 3% fee and $10.58 to a 14.1% guest fee. On the single fee it adds $11.63 to your fee."}}
]}
</script>

## Related tools and guides

- [Tito fee calculator (2026)](tito-fee-calculator): 3% per paid ticket plus Stripe's 2.9% + $0.30 per order, for event organizers
- [Vrbo host fee calculator (2026)](vrbo-host-fee-calculator): Vrbo's 12% pay-per-booking commission on the rental amount plus cleaning and other fees, with no separate processing fee when Vrbo processes the payment
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): Social Security and Medicare tax on self-employment income, with the deductible half and the quarterly share
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator): how much to set aside each quarter from income that has no tax withheld

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Airbnb. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
