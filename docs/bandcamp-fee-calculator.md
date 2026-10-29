---
layout: page
title: "Bandcamp fee calculator (2026): the 15% or 10% revenue share, Stripe or PayPal processing fees and what you keep"
description: "Free Bandcamp fee calculator for artists and labels. Enter your price, sales per month and whether it is digital music or merch to see Bandcamp's 15% or 10% revenue share, the payment processing fee under the new Stripe system or legacy PayPal, payout and label plan costs, your monthly and yearly take-home, and the price to charge to keep a set amount."
---

Bandcamp takes a **15% revenue share on digital sales and 10% on physical merch**. The digital share drops to 10% once you pass $5,000 in sales, and stays there as long as you sold at least $5,000 in the past 12 months. Payment processing comes off on top: under Bandcamp's new Stripe-powered system it is 5% + $0.06 on sales of $8.06 or less and 2.9% + $0.30 on sales of $8.07 or more. The revenue share only applies to the first $100 of an item, and shipping is not included in it. Enter your numbers below to see what you actually keep. Everything runs in your browser and nothing is sent anywhere.

<div id="bc" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <div style="display:flex;flex-wrap:wrap;gap:0 16px">
    <p style="flex:1 1 200px;margin:0 0 8px"><label>What you sell<br><select id="bc-type" style="width:100%;max-width:220px"><option value="digital">Digital (album, track, discography)</option><option value="physical">Physical (vinyl, CD, tape, merch)</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Price the fan pays, including any extra they add (USD)<br><input id="bc-price" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Shipping charged per item (physical only, USD)<br><input id="bc-ship" type="number" min="0" step="0.01" value="0" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Sales per month<br><input id="bc-qty" type="number" min="0" step="1" value="100" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Payment system<br><select id="bc-sys" style="width:100%;max-width:220px"><option value="stripe">New Bandcamp payments (Stripe)</option><option value="ppcard">Legacy PayPal account, fan pays by card</option><option value="pppaypal">Legacy PayPal account, fan pays with PayPal</option></select></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>PayPal payouts per month (legacy only)<br><input id="bc-pay" type="number" min="0" step="1" value="4" inputmode="numeric" style="width:100%;max-width:160px"></label></p>
    <p style="flex:1 1 200px;margin:0 0 8px"><label>Label account<br><select id="bc-label" style="width:100%;max-width:220px"><option value="none">No, artist account (free)</option><option value="l20">Label, up to 15 artists ($20 a month)</option><option value="l50">Label, unlimited artists ($50 a month)</option></select></label></p>
  </div>
  <p style="margin:0 0 8px"><label><input id="bc-tier" type="checkbox"> I have sold at least $5,000 on Bandcamp in the past 12 months (digital share drops to 10%)</label></p>
  <p style="margin:0 0 8px"><label><input id="bc-fx" type="checkbox"> Fans buy in another currency (2% foreign exchange fee, Stripe only)</label></p>
  <p id="bc-warn" style="margin:0 0 8px;color:#a00"></p>
  <h3 style="margin:16px 0 8px">Per sale</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Fan pays (price plus shipping)</td><td style="text-align:right" id="bc-s-total">$0.00</td></tr>
    <tr><td>Bandcamp revenue share</td><td style="text-align:right" id="bc-s-share">$0.00</td></tr>
    <tr><td>Payment processing fee</td><td style="text-align:right" id="bc-s-proc">$0.00</td></tr>
    <tr><td>You keep</td><td style="text-align:right"><strong id="bc-s-net">$0.00</strong></td></tr>
    <tr><td>Total fees as a share of what the fan paid</td><td style="text-align:right" id="bc-s-eff">n/a</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Per month</h3>
  <table style="width:100%;border-collapse:collapse;margin:8px 0">
    <tr><td>Fans pay</td><td style="text-align:right" id="bc-m-gross">$0.00</td></tr>
    <tr><td>Bandcamp revenue share</td><td style="text-align:right" id="bc-m-share">$0.00</td></tr>
    <tr><td>Payment processing fees</td><td style="text-align:right" id="bc-m-proc">$0.00</td></tr>
    <tr><td>PayPal payout fees</td><td style="text-align:right" id="bc-m-pfee">$0.00</td></tr>
    <tr><td>Label account</td><td style="text-align:right" id="bc-m-label">$0.00</td></tr>
    <tr><td>What you keep</td><td style="text-align:right"><strong id="bc-m-net">$0.00</strong></td></tr>
    <tr><td>Total cost as a share of what fans paid</td><td style="text-align:right" id="bc-m-eff">n/a</td></tr>
    <tr><td>What you keep per year (12 months like this)</td><td style="text-align:right" id="bc-y-net">$0.00</td></tr>
  </table>
  <h3 style="margin:16px 0 8px">Price to keep a set amount</h3>
  <p style="margin:0 0 8px"><label>I want to keep per sale after Bandcamp's share and processing (USD)<br><input id="bc-target" type="number" min="0" step="0.01" value="10" inputmode="decimal" style="width:100%;max-width:160px"></label></p>
  <p id="bc-need" style="margin:0;font-weight:bold"></p>
</div>

<script>
/* Bandcamp fee math. Revenue share 15% digital (10% once you reach $5,000 USD in sales, kept while you have $5,000 in the past 12 months), 10% physical; shipping and tax excluded; the share applies to the first $100 of an item only (Bandcamp Help "What are Bandcamp's fees?", get.bandcamp.help/en/articles/15263193). New Stripe-powered payments: 5% + $0.06 for sales of $8.06 or less, 2.9% + $0.30 for $8.07 or more, 2% foreign exchange fee may apply, bank payouts free (bandcamp.com/bandcamp_payments). Legacy PayPal: 1.9% + $0.30 PayPal, 2.2% + $0.30 card at $8.07 or more, 5% + $0.05 under $8.07; bulk payout fee 1% capped at $1 (get.bandcamp.help/en/articles/15263218). Label accounts $20 a month up to 15 artists, $50 unlimited (bandcamp.com/labels). Checked Oct 28, 2026. */
(function (root) {
  var CHECKED = "2026-10-28";
  var SHARE = { digital: 0.15, digitalTier: 0.10, physical: 0.10 }, SHARE_CAP = 100, SMALL = 8.07;
  var SYS = { stripe: { small: [0.05, 0.06], big: [0.029, 0.30], fx: 0.02 }, ppcard: { small: [0.05, 0.05], big: [0.022, 0.30], fx: 0 }, pppaypal: { small: [0.05, 0.05], big: [0.019, 0.30], fx: 0 } };
  var LABEL = { none: 0, l20: 20, l50: 50 }, PAYOUT_PCT = 0.01, PAYOUT_CAP = 1;
  var MAX_AMT = 1000000, MAX_QTY = 1000000;
  function r2(x) { return Math.round((x + 1e-9) * 100) / 100; }
  function num(v) { var n = Number(v); return isFinite(n) && n > 0 ? n : 0; }
  function amt(v) { return Math.min(r2(num(v)), MAX_AMT); }
  function count(v) { return Math.min(Math.floor(num(v)), MAX_QTY); }
  function kind(t) { return t === "physical" ? "physical" : "digital"; }
  function sys(k) { return SYS.hasOwnProperty(k) ? k : "stripe"; }
  function label(k) { return LABEL.hasOwnProperty(k) ? k : "none"; }
  function shareRate(t, tier) { return kind(t) === "physical" ? SHARE.physical : (tier ? SHARE.digitalTier : SHARE.digital); }
  function procFee(total, k, fx) {
    if (total <= 0) return 0;
    var s = SYS[sys(k)], f = total < SMALL ? s.small : s.big;
    return r2(total * (f[0] + (fx ? s.fx : 0)) + f[1]);
  }
  function calc(t, p, ship, tier, k, fx) {
    var price = amt(p), sh = kind(t) === "physical" ? amt(ship) : 0, total = r2(price + sh);
    if (total <= 0) return { price: 0, ship: 0, total: 0, share: 0, proc: 0, net: 0, effective: null };
    var share = r2(shareRate(t, tier) * Math.min(price, SHARE_CAP)), proc = procFee(total, k, fx);
    var net = r2(total - share - proc);
    return { price: price, ship: sh, total: total, share: share, proc: proc, net: net, effective: (share + proc) / total };
  }
  function perMonth(t, p, ship, q, tier, k, fx, payouts, lab) {
    var s = calc(t, p, ship, tier, k, fx), n = count(q);
    var gross = r2(s.total * n), share = r2(s.share * n), proc = r2(s.proc * n), afterFees = r2(gross - share - proc);
    var pfee = 0, np = count(payouts);
    if (sys(k) !== "stripe" && afterFees > 0 && np > 0) pfee = r2(Math.min(afterFees / np * PAYOUT_PCT, PAYOUT_CAP) * np);
    var lc = LABEL[label(lab)], net = r2(afterFees - pfee - lc);
    return { sale: s, count: n, gross: gross, share: share, proc: proc, pfee: pfee, label: lc, net: net, year: r2(net * 12), effective: gross > 0 ? (gross - net) / gross : null };
  }
  /* Smallest price (to the cent) that keeps at least T per sale. Net rises linearly inside each fee band, so the answer is either the
     exact solution in a band or that band's lower edge; candidates are checked a few cents either way because fees round to cents. */
  function priceFor(T, t, ship, tier, k, fx) {
    var target = amt(T); if (target <= 0) return null;
    var sh = kind(t) === "physical" ? amt(ship) : 0, r = shareRate(t, tier), s = SYS[sys(k)], c = [0.01, Math.max(0.01, r2(SMALL - sh)), SHARE_CAP + 0.01];
    [s.small, s.big].forEach(function (f) {
      var a = f[0] + (fx ? s.fx : 0), b = f[1];
      c.push(Math.ceil((target - sh * (1 - a) + b) / (1 - r - a) * 100) / 100);
      c.push(Math.ceil((target - sh * (1 - a) + b + SHARE_CAP * r) / (1 - a) * 100) / 100);
    });
    var best = null;
    c.forEach(function (x) { for (var d = -3; d <= 3; d++) { var p = r2(x + d / 100); if (p <= 0 || p > MAX_AMT) continue; if (calc(t, p, sh, tier, k, fx).net + 1e-9 >= target && (best === null || p < best)) best = p; } });
    return best;
  }
  var api = { CHECKED: CHECKED, SHARE: SHARE, SHARE_CAP: SHARE_CAP, SMALL: SMALL, SYS: SYS, LABEL: LABEL, MAX_AMT: MAX_AMT, MAX_QTY: MAX_QTY, amt: amt, count: count, shareRate: shareRate, procFee: procFee, calc: calc, perMonth: perMonth, priceFor: priceFor };
  if (typeof module !== "undefined" && module.exports) module.exports = api; else root.BandcampFees = api;
})(this);
</script>

<script>
(function () {
  var B = window.BandcampFees;
  function $(id) { return document.getElementById(id); }
  function money(x) { var s = (Math.round(Math.abs(x) * 100) / 100).toLocaleString("en-US", { minimumFractionDigits: 2, maximumFractionDigits: 2 }); return (x < 0 ? "-$" : "$") + s; }
  function pctS(x) { return x == null ? "n/a" : (Math.round(x * 1000) / 10).toFixed(1) + "%"; }
  function set(id, v) { var e = $(id); if (e) e.textContent = v; }
  function update() {
    var t = $("bc-type").value, p = $("bc-price").value, sh = $("bc-ship").value, k = $("bc-sys").value, tier = $("bc-tier").checked, fx = $("bc-fx").checked;
    var m = B.perMonth(t, p, sh, $("bc-qty").value, tier, k, fx, $("bc-pay").value, $("bc-label").value), s = m.sale;
    var w = [];
    if (B.amt(p) > B.SHARE_CAP) w.push("Bandcamp's revenue share only applies to the first $100 of an item, so the share is capped there.");
    if (t !== "physical" && B.amt(sh) > 0) w.push("Shipping only applies to physical items, so it is ignored for digital sales.");
    if (fx && k !== "stripe") w.push("The 2% foreign exchange fee is shown for the new Stripe system only.");
    if (B.amt(p) >= B.MAX_AMT || B.count($("bc-qty").value) >= B.MAX_QTY) w.push("Large numbers are capped.");
    $("bc-warn").textContent = w.join(" ");
    set("bc-s-total", money(s.total)); set("bc-s-share", money(s.share)); set("bc-s-proc", money(s.proc)); set("bc-s-net", money(s.net)); set("bc-s-eff", pctS(s.effective));
    set("bc-m-gross", money(m.gross)); set("bc-m-share", money(m.share)); set("bc-m-proc", money(m.proc)); set("bc-m-pfee", money(m.pfee)); set("bc-m-label", money(m.label));
    set("bc-m-net", money(m.net)); set("bc-m-eff", pctS(m.effective)); set("bc-y-net", money(m.year));
    var need = B.priceFor($("bc-target").value, t, sh, tier, k, fx);
    set("bc-need", need == null ? "Enter how much you want to keep per sale." : "Charge " + money(need) + (t === "physical" && B.amt(sh) > 0 ? " plus " + money(B.amt(sh)) + " shipping" : "") + " to keep " + money(B.amt($("bc-target").value)) + " per sale after a " + pctS(B.shareRate(t, tier)) + " revenue share and processing (before payout and label costs).");
  }
  ["bc-type", "bc-price", "bc-ship", "bc-qty", "bc-sys", "bc-pay", "bc-label", "bc-tier", "bc-fx", "bc-target"].forEach(function (id) { $(id).addEventListener("input", update); $(id).addEventListener("change", update); });
  update();
})();
</script>

## Bandcamp fees for artists and labels (checked Oct 28, 2026)

| Fee | What it is |
|---|---|
| Revenue share, digital | 15% of each digital sale (albums, tracks, discographies, subscriptions). Drops to 10% once you reach $5,000 in sales, and stays at 10% while you have at least $5,000 in sales over the past 12 months. |
| Revenue share, physical | 10% of each physical item (vinyl, CDs, tapes, shirts). Shipping and tax are not included in the share. |
| $100 cap | The revenue share applies to the first $100 of an item only, so a $300 name-your-price payment pays the share on $100. Extra fan contributions count toward that $100. |
| Processing, new Stripe system | 5% + $0.06 on sales of $8.06 or less, 2.9% + $0.30 on sales of $8.07 or more. A 2% foreign exchange fee may apply to international purchases. Payouts to bank accounts are free. |
| Processing, legacy PayPal | 1.9% + $0.30 when the fan pays with PayPal and 2.2% + $0.30 by card on sales of $8.07 or more; 5% + $0.05 on smaller sales. PayPal remains available through the end of 2026. |
| PayPal bulk payout | 1% of the payout, capped at $1. |
| Label account | $20 a month for up to 15 artists, $50 a month for unlimited artists. Artist accounts are free. |
| Collection society share | On some sales, a percentage set by the fan's country is held back for songwriting royalties. It varies, so it is not in the calculator. |

The revenue share rules are from Bandcamp's [What are Bandcamp's fees?](https://get.bandcamp.help/en/articles/15263193-what-are-bandcamp-s-fees) help article; the Stripe processing fees from [Bandcamp Payments](https://bandcamp.com/bandcamp_payments); the legacy PayPal rates and payout fee from [How much are payment processor fees for digital sales?](https://get.bandcamp.help/en/articles/15263218-how-much-are-payment-processor-fees-for-digital-sales); and label pricing from [Bandcamp for Labels](https://bandcamp.com/labels). Bandcamp says payment processing usually runs 4% to 6% of a sale. Fees can vary by country and payment method, so check your sales and earnings details for the exact amounts.

## How the numbers are worked out

```
fan pays       = price + shipping (physical only)
revenue share  = share rate x the first $100 of the price (shipping excluded)
                 share rate = 15% digital, 10% digital past $5,000, 10% physical
processing     = fan pays x rate + fixed fee (5% + $0.06 up to $8.06, 2.9% + $0.30 from $8.07)
you keep       = fan pays - revenue share - processing
per month      = you keep x sales - PayPal payout fees - label plan
```

A $10 digital album sold 100 times a month at the 15% share keeps $7.91 a sale: $1.50 to Bandcamp and $0.59 for processing. That is $791 a month, or $9,492 a year. A $1 track keeps $0.74, because the small-sale rate is 5% + $0.06. A $25 record with $8 shipping keeps $29.24 of the $33 the fan pays, since the 10% share is only on the $25. To keep $10 on a digital sale at 15%, charge $12.54.

## FAQ

### How much does Bandcamp take from artists in 2026?

Bandcamp takes 15% of digital sales and 10% of physical sales, plus a payment processing fee that usually works out to 4% to 6%. Once you pass $5,000 in sales, the digital share drops to 10%. On average artists and labels keep about 82% of what fans pay.

### What are Bandcamp's payment processing fees?

Under Bandcamp's new Stripe-powered payment system, processing is 5% + $0.06 on sales of $8.06 or less and 2.9% + $0.30 on sales of $8.07 or more, with a 2% foreign exchange fee on some international purchases. Legacy PayPal accounts pay 1.9% + $0.30 or 2.2% + $0.30 on larger sales and 5% + $0.05 on smaller ones.

### Does Bandcamp take a cut of shipping?

No. The revenue share on physical items is 10% of the item price, and shipping and tax are not included. Processing fees are charged on the whole amount the fan pays, including shipping.

### Is there a maximum Bandcamp fee on expensive items?

Yes. The revenue share applies only to the first $100 of an item, so a $300 deluxe box or a large name-your-price payment pays the share on $100. Processing still applies to the full amount.

### What price should I charge on Bandcamp to keep a set amount?

Use the calculator's price-to-keep box. As a rule of thumb for digital sales over $8.07 at the 15% share, divide your target plus $0.30 by 0.821, which gives about $12.55 to keep $10 (the calculator's exact answer is $12.54, because fees round to the cent). At the 10% share, divide by 0.871 instead.

<script type="application/ld+json">
{"@context":"https://schema.org","@type":"FAQPage","mainEntity":[
{"@type": "Question", "name": "How much does Bandcamp take from artists in 2026?", "acceptedAnswer": {"@type": "Answer", "text": "Bandcamp takes 15% of digital sales and 10% of physical sales, plus a payment processing fee that usually works out to 4% to 6%. Once you pass $5,000 in sales, the digital share drops to 10%. On average artists and labels keep about 82% of what fans pay."}},
{"@type": "Question", "name": "What are Bandcamp's payment processing fees?", "acceptedAnswer": {"@type": "Answer", "text": "Under Bandcamp's new Stripe-powered payment system, processing is 5% + $0.06 on sales of $8.06 or less and 2.9% + $0.30 on sales of $8.07 or more, with a 2% foreign exchange fee on some international purchases. Legacy PayPal accounts pay 1.9% + $0.30 or 2.2% + $0.30 on larger sales and 5% + $0.05 on smaller ones."}},
{"@type": "Question", "name": "Does Bandcamp take a cut of shipping?", "acceptedAnswer": {"@type": "Answer", "text": "No. The revenue share on physical items is 10% of the item price, and shipping and tax are not included. Processing fees are charged on the whole amount the fan pays, including shipping."}},
{"@type": "Question", "name": "Is there a maximum Bandcamp fee on expensive items?", "acceptedAnswer": {"@type": "Answer", "text": "Yes. The revenue share applies only to the first $100 of an item, so a $300 deluxe box or a large name-your-price payment pays the share on $100. Processing still applies to the full amount."}},
{"@type": "Question", "name": "What price should I charge on Bandcamp to keep a set amount?", "acceptedAnswer": {"@type": "Answer", "text": "Use the calculator's price-to-keep box. As a rule of thumb for digital sales over $8.07 at the 15% share, divide your target plus $0.30 by 0.821, which gives about $12.55 to keep $10 (the calculator's exact answer is $12.54, because fees round to the cent). At the 10% share, divide by 0.871 instead."}}
]}
</script>

## Related tools and guides

- [Patreon fee calculator (2026)](patreon-fee-calculator): Patreon's platform and processing fees, for fan memberships next to Bandcamp sales
- [Ko-fi fee calculator (2026)](ko-fi-fee-calculator): Ko-fi's 0% tip / 5% service fee on shop sales and memberships
- [itch.io fee calculator (2026)](itch-io-fee-calculator): itch.io's open revenue share and processing fees, for soundtracks and games sold next to Bandcamp
- [Discogs fee calculator (2026)](discogs-fee-calculator): Discogs' 9% selling fee on item and shipping ($0.10 minimum, $150 maximum per item) plus PayPal's 3.49% + $0.49 on the whole payment, for record sellers
- [PayPal & Stripe fee calculator (2026)](paypal-stripe-fee-calculator): the card and PayPal fees behind every Bandcamp sale
- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): Gumroad, Payhip, Ko-fi, Lemon Squeezy, Etsy and more side by side
- [Self-employment tax calculator (2026)](self-employment-tax-calculator): the 15.3% tax on what you keep from music sales

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE` and `GUMROADFEE`, plus `BREAKEVENPRICE`, which finds the price you need for a target profit under any percentage-plus-fixed fee. Every rate is an optional argument, and they work on a whole column at once.

*Disclosure: Seller Fee Formulas for Google Sheets and the calculators on this site are our own products, and we earn the sale price if you buy a paid one. None of the links above are affiliate links. Not affiliated with Bandcamp. Not tax or financial advice.* More guides: [Gumroad developer guides](./).
