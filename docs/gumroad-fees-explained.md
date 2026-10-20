---
layout: page
title: "Gumroad fees in 2026, explained: what you actually keep on a $5, $19 and $49 sale"
description: "Gumroad's 10% + $0.50 fee hits cheap products hardest, and Discover takes 30%. Worked examples, break-even prices and how to price around it."
---

Gumroad's pricing looks simple: **10% + $0.50 per sale** on direct sales, and **30%** when the sale comes through Gumroad Discover, its marketplace. Gumroad is also merchant of record, so it handles sales tax and VAT. In practice, that flat $0.50 is what decides whether a cheap product is worth selling.

*Check Gumroad's pricing page before relying on these numbers, since fees change.*

## What you keep

| Price | Direct sale (10% + $0.50) | You keep | Effective fee | Via Discover (30%) | You keep |
|---:|---:|---:|---:|---:|---:|
| $1 | $0.60 | $0.40 | 60% | $0.30 | $0.70 |
| $5 | $1.00 | $4.00 | 20% | $1.50 | $3.50 |
| $9 | $1.40 | $7.60 | 15.6% | $2.70 | $6.30 |
| $19 | $2.40 | $16.60 | 12.6% | $5.70 | $13.30 |
| $49 | $5.40 | $43.60 | 11.0% | $14.70 | $34.30 |
| $99 | $10.40 | $88.60 | 10.5% | $29.70 | $69.30 |

Two things stand out:

- **Under about $5, the $0.50 dominates.** A $1 product loses 60% to fees on a direct sale. That's why PWYW products with a $0 minimum or $1 tips barely move the needle.
- **Discover takes a big cut, but it's still extra reach.** Discover buyers are customers you wouldn't have found yourself. It's acquisition cost, not lost revenue.

Payment processing is on top of this in some cases, and payout methods can carry their own small fees. Look at a real payout once to see your true net.

## Pricing around the fee

- **Bundle low-priced items.** Three $5 products sold separately cost $3.00 in fees. One $15 bundle costs $2.00.
- **Use pay-what-you-want with a sensible minimum.** A $9 minimum loses 15.6% to fees, and many buyers pay above it.
- **Send your own traffic directly.** Links from your blog, newsletter or social profiles are charged as direct sales at 10% + $0.50, not 30%.
- **Price for the take-home amount.** If you want $20 per sale, price at $22.78 or more: `(target + 0.50) / 0.90`.

## Formula

```
direct_net   = price * 0.90 - 0.50
discover_net = price * 0.70
price_for_target_direct = (target + 0.50) / 0.90
```

## Tools

- **[Free Gumroad fee calculator](gumroad-fee-calculator)** works out your payout, effective fee and target price as you type.
- **[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz)** runs these numbers in your browser for any price, so you can see direct and Discover payouts before you set a price.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)** imports your sales CSV and applies the fees to every row automatically.

More guides: [Gumroad developer guides](./). Not affiliated with Gumroad.
