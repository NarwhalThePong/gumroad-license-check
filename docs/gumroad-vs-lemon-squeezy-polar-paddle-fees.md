---
layout: page
title: "Gumroad vs Lemon Squeezy vs Polar vs Paddle: fees in 2026 and what you keep"
description: "Side-by-side fees for selling software and digital products in 2026, with what you keep on a $9, $29 and $99 sale, and when Gumroad's higher fee is still worth it."
---

All four handle checkout and act as merchant of record, so they collect and remit sales tax and VAT for you. The real differences are the fee, how buyers find you, and what you have to build yourself.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

Prices below come from each company's public pricing page, checked on October 20, 2026. Fees change, so confirm on the linked page before you decide.

## The headline rates

| Platform | Standard fee | Notes |
| --- | --- | --- |
| [Gumroad](https://gumroad.com/help/article/66-gumroads-fees) | 10% + $0.50, plus card processing (2.9% + $0.30) or PayPal fees | Sales through your profile or direct links. **30%**, processing included, when a new buyer finds you through Gumroad Discover. 5% + $0.50 (plus processing) once paid sales pass $20,000 in a month. No monthly fee. |
| [Lemon Squeezy](https://www.lemonsqueezy.com/pricing) | 5% + $0.50 | No monthly fee. The pricing page says some payments may carry small additional fees. |
| [Polar](https://polar.sh/docs/merchant-of-record/fees) | 5% + $0.50 (Starter) | Free plan for organizations created on or after May 27, 2026. +1.5% for non-US cards. Paid plans from $20/month lower the rate (Pro: 3.8% + $0.40). |
| [Paddle](https://www.paddle.com/pricing) | 5% + $0.50 | No monthly fee. Paddle asks sellers with products under $10 to contact them for custom pricing. |

## What you keep on a $9, $29 and $99 sale

Before tax, one-time purchase, paid by card, standard plan. Gumroad direct includes Gumroad's 2.9% + $0.30 card processing:

| Price | Gumroad direct | Gumroad Discover | Lemon Squeezy / Paddle / Polar (US card) | Polar (non-US card) |
| --- | --- | --- | --- | --- |
| $9 | $7.04 | $6.30 | $8.05 | $7.92 |
| $29 | $24.46 | $20.30 | $27.05 | $26.62 |
| $99 | $85.43 | $69.30 | $93.55 | about $92.07 |

Once card processing is counted, Gumroad direct keeps $1.01 less than the 5% + $0.50 platforms on a $9 sale, $2.59 less on $29 and $8.12 less on $99. Polar's docs calculate the fee on the tax-inclusive total, so where VAT applies its fee is a little higher than the table shows.

## When Gumroad is still the better pick

- **You want buyers you didn't bring.** Discover costs 30%, but it is the only one of the four with a marketplace that sends you new customers. 70% of a sale you would not otherwise have beats 95% of nothing.
- **You sell cheap things.** On a $5 product the fixed per-sale fee hurts everywhere, and Paddle asks you to negotiate below $10.
- **You want it running tonight.** A product page, a PWYW price and a file upload take minutes, and the buyer flow is familiar.
- **Volume is small.** Below a few hundred dollars a month, 5% is a few dollars. Your time setting up a second platform costs more.

## When the 5% platforms win

- **Higher prices or steady volume.** At $99 a sale, 50 sales a month is about $406 a month you keep instead of paying in fees.
- **Subscriptions and SaaS billing.** Lemon Squeezy, Polar and Paddle are built around recurring billing, seats and usage.
- **You already have traffic.** If buyers come from your own site or audience, Discover's reach matters less.

## The gotcha people hit after picking Gumroad

Gumroad's license key API is simple, but its verify endpoint returns `success: true` for keys from refunded and charged-back purchases unless you check the `refunded`, `chargebacked` and `disputed` fields yourself. Subscriptions add more cases. The fix is a few lines, covered in [Block refunded and charged-back buyers in your Gumroad license check](refunded-gumroad-license-keys), with a free, MIT-licensed helper in [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check).

If you stay on Gumroad and want the rest built for you:

- **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)**: offline cache, activation limits and a proxy server for Node, Python and Electron apps.
- **[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz)**: direct and Discover payouts for any price, in your browser.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)**: imports your sales CSV and applies the fees to every row.

## Related guides

- [Seller fee comparison calculator (2026)](seller-fee-comparison-calculator): all of these platforms at your own price and sales volume
- [Lemon Squeezy fee calculator (2026)](lemon-squeezy-fee-calculator): Lemon Squeezy's surcharges (+1.5% international, +1.5% PayPal, +0.5% subscriptions), fees on VAT and payout fees
- [Polar fee calculator (2026)](polar-fee-calculator): Polar's Starter, Pro, Growth and Scale rates, payout fees and when a paid plan pays off
- [Paddle fee calculator (2026)](paddle-fee-calculator): Paddle's 5% + 50¢ on your own price, tax and sales, with payout costs
- [Gumroad fees in 2026, explained](gumroad-fees-explained)
- [Gumroad alternatives: Payhip vs Sellfy vs SendOwl (2026)](gumroad-alternatives-payhip-sellfy-sendowl)
- [Gumroad 1099-K and taxes](gumroad-1099-k-taxes)
- [Sell access to a private GitHub repo on Gumroad](sell-private-github-repo-on-gumroad)
- [Who collects sales tax and VAT on digital products? Gumroad, Lemon Squeezy, Payhip, Sellfy and Etsy](who-collects-sales-tax-vat-gumroad-lemon-squeezy-payhip-sellfy-etsy)

Not affiliated with Gumroad, Lemon Squeezy, Polar or Paddle. Rates are as published on October 20, 2026.
