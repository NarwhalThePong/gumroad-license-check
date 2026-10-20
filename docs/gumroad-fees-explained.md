---
layout: page
title: "Gumroad fees in 2026, explained: what you actually keep on a $5, $19 and $49 sale"
description: "Gumroad's 10% + $0.50 fee plus 2.9% + $0.30 card processing hits cheap products hardest, and Discover takes 30%. Worked examples, break-even prices and how to price around it."
---

Gumroad's pricing looks simple: **10% + $0.50 per sale** on direct sales, plus **2.9% + $0.30 card processing** charged on top, and **30%** (processing included) when the sale comes through Gumroad Discover, its marketplace. Gumroad is also merchant of record, so it handles sales tax and VAT. In practice, the flat $0.80 per sale ($0.50 + $0.30) is what decides whether a cheap product is worth selling.

*Rates from [Gumroad's fees help page](https://gumroad.com/help/article/66-gumroads-fees), checked October 20, 2026. Fees change, so confirm there before relying on these numbers.*

## What you keep

| Price | Direct sale (10% + $0.50 + 2.9% + $0.30) | You keep | Effective fee | Via Discover (30%) | You keep |
|---:|---:|---:|---:|---:|---:|
| $1 | $0.93 | $0.07 | 93.0% | $0.30 | $0.70 |
| $5 | $1.45 | $3.55 | 29.0% | $1.50 | $3.50 |
| $9 | $1.96 | $7.04 | 21.8% | $2.70 | $6.30 |
| $19 | $3.25 | $15.75 | 17.1% | $5.70 | $13.30 |
| $49 | $7.12 | $41.88 | 14.5% | $14.70 | $34.30 |
| $99 | $13.57 | $85.43 | 13.7% | $29.70 | $69.30 |

Two things stand out:

- **Under about $5, the fixed $0.80 dominates.** A $1 product loses 93% to fees on a direct sale. That's why PWYW products with a $0 minimum or $1 tips barely move the needle.
- **Discover takes a big cut, but it's still extra reach.** Discover buyers are customers you wouldn't have found yourself. It's acquisition cost, not lost revenue.

The direct figures assume a card payment; PayPal payments carry PayPal's fees instead of the 2.9% + $0.30. Payout methods can carry their own small fees. Look at a real payout once to see your true net.

## Pricing around the fee

- **Bundle low-priced items.** Three $5 products sold separately cost $4.35 in fees. One $15 bundle costs $2.74.
- **Use pay-what-you-want with a sensible minimum.** A $9 minimum loses 21.8% to fees, and many buyers pay above it.
- **Send your own traffic directly.** Links from your blog, newsletter or social profiles are charged as direct sales at 10% + $0.50 plus card processing, not 30%.
- **Price for the take-home amount.** If you want $20 per sale, price at $23.88 or more: `(target + 0.80) / 0.871`.

## Selling over $20,000 a month?

Once your paid sales in a calendar month reach $20,000, new direct sales that month pay 5% + $0.50 instead of 10% + $0.50 (card processing still applies). It resets on the 1st.

## Formula

```
direct_net   = price * 0.871 - 0.80     # 10% + $0.50 Gumroad fee, 2.9% + $0.30 card processing
discover_net = price * 0.70             # processing included
price_for_target_direct = (target + 0.80) / 0.871
```

## Tools

- **[Free Gumroad fee calculator](gumroad-fee-calculator)** works out your payout, effective fee and target price as you type.
- **[Creator Payout Calculator Pro](https://paudrudis.gumroad.com/l/ijrzbz/LAUNCH30)** runs these numbers in your browser for any price, so you can see direct and Discover payouts before you set a price.
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq/LAUNCH30)** imports your sales CSV and applies the fees to every row automatically.

Looking at other platforms? See [Gumroad alternatives: Payhip vs Sellfy vs SendOwl (2026)](gumroad-alternatives-payhip-sellfy-sendowl) for fees and the real monthly cost at $500 and $3,000 a month.

Selling a course instead of downloads? See [Teachable vs Podia vs Payhip vs Gumroad](teachable-vs-podia-vs-payhip-vs-gumroad-courses).

What does a discount code actually cost you, and how do codes work on other platforms? See [Discount codes and sales](discount-codes-and-sales-gumroad-lemon-squeezy-payhip-sellfy-etsy).
More guides: [Gumroad developer guides](./). Not affiliated with Gumroad.
