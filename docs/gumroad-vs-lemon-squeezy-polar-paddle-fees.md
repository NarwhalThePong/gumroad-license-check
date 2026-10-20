---
layout: page
title: "Gumroad vs Lemon Squeezy vs Polar vs Paddle: fees in 2026 and what you keep"
description: "Side-by-side fees for selling software and digital products in 2026, with what you keep on a $9, $29 and $99 sale, and when Gumroad's higher fee is still worth it."
---

All four handle checkout and act as merchant of record, so they collect and remit sales tax and VAT for you. The real differences are the fee, how buyers find you, and what you have to build yourself.

Prices below come from each company's public pricing page, checked on October 20, 2026. Fees change, so confirm on the linked page before you decide.

## The headline rates

| Platform | Standard fee | Notes |
| --- | --- | --- |
| [Gumroad](https://gumroad.com/pricing) | 10% + $0.50 | Sales through your profile or direct links. **30%** when a new buyer finds you through Gumroad Discover. No monthly fee. |
| [Lemon Squeezy](https://www.lemonsqueezy.com/pricing) | 5% + $0.50 | No monthly fee. The pricing page says some payments may carry small additional fees. |
| [Polar](https://polar.sh/docs/merchant-of-record/fees) | 5% + $0.50 (Starter) | Free plan for organizations created on or after May 27, 2026. +1.5% for non-US cards. Paid plans from $20/month lower the rate (Pro: 3.8% + $0.40). |
| [Paddle](https://www.paddle.com/pricing) | 5% + $0.50 | No monthly fee. Paddle asks sellers with products under $10 to contact them for custom pricing. |

## What you keep on a $9, $29 and $99 sale

Before tax, one-time purchase, standard plan, no extra fees:

| Price | Gumroad direct | Gumroad Discover | Lemon Squeezy / Paddle / Polar (US card) | Polar (non-US card) |
| --- | --- | --- | --- | --- |
| $9 | $7.60 | $6.30 | $8.05 | $7.92 |
| $29 | $25.60 | $20.30 | $27.05 | $26.62 |
| $99 | $88.60 | $69.30 | $93.55 | about $92.07 |

The gap between Gumroad direct and the 5% + $0.50 platforms is exactly 5% of the price: $0.45 on a $9 sale, $1.45 on $29 and $4.95 on $99. Polar's docs calculate the fee on the tax-inclusive total, so where VAT applies its fee is a little higher than the table shows.

## When Gumroad is still the better pick

- **You want buyers you didn't bring.** Discover costs 30%, but it is the only one of the four with a marketplace that sends you new customers. 70% of a sale you would not otherwise have beats 95% of nothing.
- **You sell cheap things.** On a $5 product the fixed $0.50 hurts everywhere, and Paddle asks you to negotiate below $10.
- **You want it running tonight.** A product page, a PWYW price and a file upload take minutes, and the buyer flow is familiar.
- **Volume is small.** Below a few hundred dollars a month, 5% is a few dollars. Your time setting up a second platform costs more.

## When the 5% platforms win

- **Higher prices or steady volume.** At $99 a sale, 50 sales a month is about $247 a month you keep instead of paying in fees.
- **Subscriptions and SaaS billing.** Lemon Squeezy, Polar and Paddle are built around recurring billing, seats and usage.
- **You already have traffic.** If buyers come from your own site or audience, Discover's reach matters less.

## The gotcha people hit after picking Gumroad

Gumroad's license key API is simple, but its verify endpoint returns `success: true` for keys from refunded and charged-back purchases unless you check the `refunded`, `chargebacked` and `disputed` fields yourself. Subscriptions add more cases. The fix is a few lines, covered in [Block refunded and charged-back buyers in your Gumroad license check](refunded-gumroad-license-keys), with a free, MIT-licensed helper in [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check).

If you stay on Gumroad and want the rest built for you:

- **[Gumroad License Kit](https://paudrudis.gumroad.com/l/dufcs)**: offline cache, activation limits and a proxy server for Node, Python and Electron apps.
- **[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz)**: direct and Discover payouts for any price, in your browser.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)**: imports your sales CSV and applies the fees to every row.

## Related guides

- [Gumroad fees in 2026, explained](gumroad-fees-explained)
- [Gumroad 1099-K and taxes](gumroad-1099-k-taxes)
- [Sell access to a private GitHub repo on Gumroad](sell-private-github-repo-on-gumroad)

Not affiliated with Gumroad, Lemon Squeezy, Polar or Paddle. Rates are as published on October 20, 2026.
