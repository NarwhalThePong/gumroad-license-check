---
layout: page
title: "PayPal & Stripe fees explained (2026)"
description: "PayPal and Stripe fees for US sellers in 2026: the rate for Stripe cards, PayPal Checkout, cards, goods and services, Pay Later and international payments, with worked examples, a comparison table and the formula for the price to charge to net a set amount."
---

PayPal and Stripe both charge a **percentage of each payment plus (usually) a fixed fee**. The percentage and fixed fee depend on how the buyer pays. This guide covers the US standard rates as of Oct 20, 2026, with worked examples and the formula for pricing so you keep the amount you want.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

**Skip the math:** the free [PayPal & Stripe fee calculator](paypal-stripe-fee-calculator) shows the fee, payout and effective rate for every method, and the price to charge to net a set amount.

**Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `STRIPEFEE`, `PAYPALFEE`, `ETSYFEE` and `GUMROADFEE`, plus price solvers that find the price you need for a target profit. Every rate is an optional argument, and they work on a whole column at once. *Disclosure: this is our own paid product, and we earn the sale price if you buy it.*

## The fees at a glance (US, as of Oct 20, 2026)

| Method | Percentage | Fixed fee |
|---|---|---|
| Stripe, domestic card | 2.9% | $0.30 |
| PayPal Checkout (and Guest Checkout, Pay with Venmo) | 3.49% | $0.49 |
| PayPal, standard credit and debit card payments | 2.99% | $0.49 |
| PayPal, send/receive money for goods and services | 2.99% | none |
| PayPal Pay Later | 4.99% | $0.49 |
| PayPal, international commercial payment | add 1.50% | same fixed fee |

What each one means:

- **Stripe, domestic card.** The standard rate for a successful card payment from a buyer in your own country. Stripe lists extra fees for international cards, currency conversion, disputes and some other payment methods on its pricing page.
- **PayPal Checkout.** The buyer pays with their PayPal account (or as a guest, or with Venmo) through a PayPal button or checkout on your site.
- **PayPal standard card payments.** The buyer pays by card through PayPal's card checkout rather than a PayPal account.
- **Goods and services.** Someone sends you money through PayPal marked as a payment for goods or services. No fixed fee, which makes it the cheapest option on small amounts.
- **Pay Later.** The buyer splits the payment with one of PayPal's Pay Later options. You get the full amount; the fee is higher.
- **International.** When the buyer is in a different market, PayPal adds 1.50% on top of the domestic rate. Currency conversion, if any, is a separate spread.

## Worked examples

Fee = amount x percentage + fixed fee, rounded to the cent. Payout = amount - fee.

| Sale | Stripe card | PayPal Checkout | PayPal card | Goods & services | Pay Later |
|---|---|---|---|---|---|
| $10 | $0.59 fee, keep $9.41 | $0.84, keep $9.16 | $0.79, keep $9.21 | $0.30, keep $9.70 | $0.99, keep $9.01 |
| $25 | $1.03, keep $23.97 | $1.36, keep $23.64 | $1.24, keep $23.76 | $0.75, keep $24.25 | $1.74, keep $23.26 |
| $50 | $1.75, keep $48.25 | $2.24, keep $47.76 | $1.99, keep $48.01 | $1.50, keep $48.50 | $2.99, keep $47.01 |
| $100 | $3.20, keep $96.80 | $3.98, keep $96.02 | $3.48, keep $96.52 | $2.99, keep $97.01 | $5.48, keep $94.52 |

Step by step for a $50 sale:

- **Stripe:** $50 x 2.9% = $1.45, plus $0.30 = **$1.75**. You keep $48.25, an effective rate of 3.5%.
- **PayPal Checkout:** $50 x 3.49% = $1.745, plus $0.49 = $2.235, rounded to **$2.24**. You keep $47.76 (4.48%).
- **PayPal Checkout, international buyer:** $50 x (3.49% + 1.50%) = $2.495, plus $0.49 = $2.985, rounded to **$2.99**. You keep $47.01.

Notice the fixed fee: on a $10 sale, PayPal Checkout's $0.49 alone is 4.9% of the price, so the effective rate is 8.4%. On $100 it falls to 3.98%.

## How to price so you net a set amount

Adding the percentage to your price doesn't quite work, because the fee is charged on the higher price. Use:

```
price to charge = (amount you want to keep + fixed fee) / (1 - percentage)
```

then round up to the cent. To keep $50:

| Method | Price to charge | Check |
|---|---|---|
| Stripe card | ($50 + $0.30) / 0.971 = **$51.81** | fee $1.80, keep $50.01 |
| PayPal Checkout | ($50 + $0.49) / 0.9651 = **$52.32** | fee $2.32, keep $50.00 |
| PayPal card | ($50 + $0.49) / 0.9701 = **$52.05** | fee $2.05, keep $50.00 |
| Goods & services | $50 / 0.9701 = **$51.55** | fee $1.54, keep $50.01 |
| Pay Later | ($50 + $0.49) / 0.9501 = **$53.15** | fee $3.14, keep $50.01 |

The [calculator](paypal-stripe-fee-calculator) does this for any amount and also handles the international add-on.

## FAQ

### Is Stripe or PayPal cheaper?

At standard US rates, a Stripe domestic card payment (2.9% + $0.30) costs less than PayPal Checkout (3.49% + $0.49) and PayPal card payments (2.99% + $0.49) at every amount. PayPal goods and services (2.99%, no fixed fee) is cheaper than Stripe on smaller payments. Fees are only part of the choice: some buyers prefer to pay with PayPal.

### Do I get the fee back if I refund?

Both say no for standard pricing: Stripe and PayPal don't charge to issue a refund, but the original processing fee isn't returned. See each provider's pricing page for details.

### Are there other fees?

Yes, depending on what you use: disputes and chargebacks, currency conversion, instant payouts or transfers, and some optional tools. They are listed on the official pages linked below and aren't included in the numbers above.

### Do these rates apply outside the US?

No. This page covers US standard rates. Other countries have their own rate tables, and negotiated or volume pricing differs.

## Sources

[Stripe pricing](https://stripe.com/pricing) and [PayPal merchant fees (US)](https://www.paypal.com/us/business/paypal-business-fees), checked Oct 20, 2026 (PayPal's page was last updated Oct 1, 2026). Fees can change at any time, so check the official pages and your own account before you rely on a number.

Comparing platforms? See [Gumroad vs Etsy vs Stripe vs PayPal vs Shopify fees](gumroad-vs-etsy-vs-stripe-vs-paypal-fees) for what you keep on a $10, $25 and $50 digital product.

More tools and guides: [all guides and free tools](./). Not affiliated with PayPal or Stripe. Not tax or financial advice.
