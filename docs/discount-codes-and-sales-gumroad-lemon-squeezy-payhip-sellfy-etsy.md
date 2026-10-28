---
layout: page
title: "Discount codes and sales on Gumroad, Lemon Squeezy, Payhip, Sellfy and Etsy: coupons, limits, fees and pay what you want (2026)"
description: "How to set up discount codes, timed sales, bundle and upsell discounts and pay-what-you-want pricing on Gumroad, Lemon Squeezy, Payhip, Sellfy and Etsy, the rules on each, and what a 25% off code on a $20 product leaves you. Checked October 2026."
---

**Disclosure:** We sell our own digital products on Gumroad and make free tools for sellers. We have no partnership with Lemon Squeezy, Payhip, Sellfy, Etsy, Stripe or PayPal and aren't paid for any link.

<!-- paid-cta -->
> **Doing this math in a spreadsheet?** [Seller Fee Formulas for Google Sheets](https://payhip.com/b/6tHXR) ($9) adds custom functions such as `GUMROADFEE`, `STRIPEFEE`, `PAYPALFEE` and `ETSYFEE`, plus price solvers for the price you need to keep a target amount. *Our own paid product.*

A discount code is the cheapest marketing you can run, but each platform builds it differently: some let you cap the number of uses, some can show a crossed-out price without a code, some won't let a sale and pay-what-you-want sit on the same product, and Etsy has its own rules about what counts as a real sale. Here's how the five platforms handle it, and what a discount actually costs you once fees are taken out.

We read each company's own help pages, developer docs and pricing pages on October 20, 2026. Features and fees change, and where a company's own pages disagree or don't say something, we tell you, so check the linked pages before you rely on them.

## The short version

- **Codes everywhere, percent or fixed:** all five let you make a code for a percentage or a fixed amount off, for one product, several or the whole shop, with a cap on total uses. Etsy's percentage codes must be a whole number between 5% and 75%. Etsy is the only one whose pages describe a one-use-per-buyer limit; Gumroad, Payhip and Sellfy say their limit counts total uses, not uses per customer.
- **Sales without a code:** Payhip and Sellfy have a separate "sale" with an optional countdown timer, Etsy runs sales automatically with no code, and Gumroad can apply a code automatically and cross out the original price. Lemon Squeezy's docs only describe codes, though a code can be pre-filled in a checkout link or through its API.
- **Fees follow the price the buyer pays:** Lemon Squeezy and Etsy say their percentage fees are worked out on the order total, and Gumroad, Payhip, Stripe and PayPal charge per transaction, so a discount lowers the percentage part. Fixed per-sale fees ($0.50, $0.30, $0.25, $0.20) stay the same. On a $20 product, a 25% off code costs you between $4.36 and $4.86 of take-home pay, not the full $5.
- **Bundles and upsells:** Gumroad, Payhip and Etsy have discounted bundles; Gumroad, Payhip and Sellfy have discounted upsells or cross-sells (Sellfy only on its Business and Premium plans). Lemon Squeezy's pricing page lists "bundles + upsells" but its help docs don't explain how.
- **Pay what you want:** Gumroad, Lemon Squeezy, Payhip and Sellfy all offer it with a minimum price. None of the Etsy pages we read mention it. On Sellfy, running a sale switches pay what you want off for that product.

## Discounts compared

| | Gumroad | Lemon Squeezy | Payhip | Sellfy | Etsy |
| --- | --- | --- | --- | --- | --- |
| Code type | % or fixed amount | % or fixed amount | % or fixed amount | % or fixed amount | 5% to 75% (whole numbers), fixed amount, or free shipping |
| Applies to | chosen products, or all products with exclusions | chosen products/variants, or store-wide | whole order, one product, or one collection | one, several or all products (with exclusions); no category option | chosen listings, or all active listings |
| Use limit | total uses (each item in the cart counts as one use) | total redemptions | total uses (not per customer) | total redemptions (not per customer) | total uses (can't be changed later) and/or one per buyer |
| Start / end dates | validity period | start and expiry date | expiry date in UTC in the help article; the API also has a start date | start and expiry date, in your local time | expiry date |
| Minimum order | minimum amount or minimum quantity | none listed | in the API and changelog; not in the coupon help article | none listed; prices never drop below $0.90 | separate order-minimum discount (shop-wide) |
| Sale with no code | auto-applied code, original price crossed out | not described | "Run Sales": before/after price and a countdown timer | "Sale" with optional countdown timer | "Run a sale": % off or free shipping |
| Code in a link | `/l/product/CODE` | `?checkout[discount_code]=CODE` | not described | `/p/product/-CODE/` | not described in the pages we read |
| Bundle discount | bundle product, total value crossed out | "bundles" on the pricing page only | bundle product | no bundle type; up to 50 files in one product | up to 3 listings, one bundle per listing |
| Upsell discount | upsells and cross-sells at checkout | "upsells" on the pricing page only | cross-sells (before checkout) and upgrade discounts (after) | upsells, Business and Premium plans only | targeted offers emailed to interested buyers |
| Pay what you want | yes, minimum = price; $0.99 minimum if paying above $0 | yes, minimum and suggested price | yes, type "5+" or "0+" | yes; $0.50 minimum (conflicts with $0.90 elsewhere) | not offered |
| Stacking | never; the bigger discount wins | not stated | cross-sells: highest wins unless you turn on "circular reference" | never; coupon beats product sale beats store sale | highest sale wins; free shipping can combine; bundles don't stack |

## What to watch on each platform

**[Gumroad](https://gumroad.com/help/article/128-discount-codes).** Create codes under Checkout, then Discounts; codes can only contain letters and numbers. A code can cover chosen products or all products, with exclusions that also don't count toward a minimum. The use limit is overall, not per customer, and every item in the cart uses one, so a five-item cart uses five. You can also require a minimum amount or a minimum quantity (quantity needs "Allow customers to choose a quantity" on the product), limit a code to new or to existing customers, and schedule a validity period. Add the code to a product URL (`https://username.gumroad.com/l/product/CODE`, also on a custom domain, and it combines with `?affiliate_id=`) and the original price shows crossed out. "Automatically apply discount code" does the same for every visitor without a link. Discounts never stack: if a buyer qualifies for two, or for a purchasing power parity discount, Gumroad gives the larger one. The checkout code box only shows if you turn on "Only if a discount is available"; otherwise codes work only through the URL. On fees, Gumroad's fee page charges 10% + $0.50 per transaction plus 2.9% + $0.30 card processing on direct sales, and 30% on Discover sales; it doesn't spell out discounts, but the fee is per transaction, so we apply it to what the buyer pays.

**[Lemon Squeezy](https://docs.lemonsqueezy.com/help/orders/creating-discount-codes).** The help page is short: percentage or fixed amount, specific products or store-wide, start date, expiry date, a redemption limit, and a repeat option for subscriptions. The API docs add the detail: codes are 3 to 256 uppercase letters and numbers, and subscription discounts run `once`, `repeating` (a number of months) or `forever`. You can pre-fill a code in a checkout link with `?checkout[discount_code]=CODE`, or set `discount_code` when you create a checkout through the API, which can also hide the code field or set a custom price. Lemon Squeezy says its platform fee is "calculated on the total order value", so a discount lowers it; the standard fee is 5% + $0.50, plus 1.5% for buyers outside the US, 1.5% for PayPal and 0.5% for subscriptions. Its docs don't describe a code-free sale with a crossed-out price, a minimum order, or how bundles and upsells work, even though the pricing page lists "Create bundles + upsells".

**[Payhip](https://help.payhip.com/article/88-coupons).** Coupons are under Marketing and can cover the whole order, one product or one collection, with a percentage or fixed amount, an overall use limit and an expiry date. The expiry is in UTC: a coupon set to expire on January 1 stops at 00:00 UTC, which is the evening of December 31 in the US. You can bulk-create up to 50 unique codes at once. The help article doesn't mention a minimum spend or a start date, but the API has both (`minimum_purchase_amount`, `start_date`) and the changelog mentions minimum order spend, so check your dashboard. "Run Sales" is separate: it shows the before and after price, the percentage off and a countdown timer, uses your store's time zone, and doesn't work on subscriptions or payment plans. Cross-sells offer a discount when a product goes in the cart; upgrade discounts offer one after purchase, can expire, and are also put in the receipt. Payhip's fee (5% on the free plan, 2% on Plus at $29 a month, none on Pro at $99 a month) is described as a fee "on any transactions", and Stripe or PayPal charge their own fees on top. Payhip doesn't say in so many words that the 5% is on the discounted price; we assume it is, as it's charged on the transaction.

**[Sellfy](https://docs.sellfy.com/article/32-discount-codes).** Two kinds: coupon codes and sales, each percentage or fixed amount, for one, several or all products (with exclusions), with start and end dates, a redemption limit (overall, not per customer) and pause or resume. Codes aren't case sensitive, and a link like `sellfy.com/p/abcd/-30OFF/` applies one on the product page. Discounts expire at your local time. They never add up: a coupon beats a sale on one product, which beats a sale on all products. A paid product never drops below $0.90 after a discount; Sellfy shows an adjusted discount instead. Running a sale on a product turns off its pay-what-you-want pricing. Upsell discounts (up to 100% off, with an expiry date and a 140-character message) need the shopping cart and the Business or Premium plan. Sellfy takes no transaction fee; you pay the plan ($29 a month on Starter, or $22 a month billed yearly) plus PayPal or Stripe fees.

**[Etsy](https://help.etsy.com/hc/en-us/articles/115014260108-How-to-Set-Up-Sales-and-Discounts-for-Your-Shop).** Four tools under Marketing, then Sales and Discounts: promo codes, sales, discounted bundles (up to 3 listings) and targeted offers. Promo codes can be 5% to 75% off (whole numbers), a fixed amount, or free shipping (no use for downloads); if a code covers chosen listings, you have to add new listings to it by hand. The total-use limit can't be changed once the code exists, but you can deactivate it, and you can limit a code to one use per buyer. Sales apply without a code, but a sale with an order minimum is shop-wide and can't exclude items. When sales overlap, only the highest discount applies. Etsy's rule on honest sales: you can't raise a price and then lower it to look like a sale, and the original price must have been in place "for a substantial amount of time". Etsy's sales events page currently lists Cyber Specials from November 23 to December 1; to be considered for Etsy's own marketing you opt in by October 27 and offer at least 25% off. Coupons Etsy itself funds don't cost you: you get the full order amount and pay the same fees.

## A $20 product with a 25% off code

A $20 digital product, a code for 25% off (the buyer pays $15), a buyer in the US paying by card, no sales tax, a direct sale (not a marketplace or ad sale). Fees rounded to the cent, monthly plan prices not included.

| | Fees at $20 | You keep at $20 | Fees at $15 | You keep at $15 | The code cost you |
| --- | ---: | ---: | ---: | ---: | ---: |
| Gumroad (10% + $0.50, plus 2.9% + $0.30 processing) | $3.38 | $16.62 | $2.74 | $12.26 | $4.36 |
| Lemon Squeezy (5% + $0.50) | $1.50 | $18.50 | $1.25 | $13.75 | $4.75 |
| Payhip Free (5%, plus Stripe 2.9% + $0.30) | $1.88 | $18.12 | $1.49 | $13.51 | $4.61 |
| Payhip Plus (2%, plus Stripe; $29/month) | $1.28 | $18.72 | $1.04 | $13.96 | $4.76 |
| Payhip Pro or Sellfy (Stripe 2.9% + $0.30 only; monthly plan) | $0.88 | $19.12 | $0.74 | $14.26 | $4.86 |
| Etsy, US shop ($0.20 listing, 6.5% transaction, 3% + $0.25 processing) | $2.35 | $17.65 | $1.88 | $13.12 | $4.53 |

How the $15 rows add up:

- **Gumroad:** $1.50 + $0.50 + $0.44 (2.9% of $15) + $0.30 = $2.74. On a Gumroad Discover sale the 30% fee would be $6.00 at $20 and $4.50 at $15.
- **Lemon Squeezy:** $0.75 + $0.50 = $1.25. A buyer outside the US or paying with PayPal adds 1.5% each.
- **Payhip Free:** $0.75 Payhip fee + $0.74 Stripe ($0.44 + $0.30) = $1.49.
- **Sellfy and Payhip Pro:** only Stripe's $0.74. Sellfy's plan costs $29 a month (or $22 a month billed yearly) and Payhip Pro $99 a month, whatever you sell.
- **Etsy:** $0.20 listing fee (charged again when an auto-renewing listing sells) + $0.98 (6.5% of $15) + $0.45 (3%) + $0.25 = $1.88. An Offsite Ads sale would add 15% or 12%.

Payhip and Sellfy don't process cards themselves: the fee comes from your own Stripe or PayPal account. We used Stripe's published US rate for domestic cards, 2.9% + 30¢. If the card payment goes through PayPal instead, PayPal's own US page lists 2.99% + $0.49 for card payments and 3.49% + $0.49 for PayPal Checkout. Sellfy's help center still says PayPal costs 2.9% + $0.30 in the US, which doesn't match PayPal's page, so go by PayPal's.

The pattern: percentage fees shrink with the discount and soften it a little, but fixed fees don't, so the cheaper the product, the more of the discount comes out of your pocket. To run your own numbers, use the [Gumroad bundle & discount calculator](gumroad-bundle-discount-calculator) or the [seller fee comparison calculator](seller-fee-comparison-calculator).

## Best for

- **Launch codes with tight control:** Gumroad (minimum amount or quantity, new or existing customers only, validity period, crossed-out price from a link).
- **Timed sales with a countdown:** Payhip or Sellfy.
- **Codes from your own site or app:** Lemon Squeezy (create discounts by API and pre-fill them in checkout links).
- **Bundles and post-purchase offers:** Payhip (bundles, cross-sells and upgrade discounts, all on every plan).
- **Reaching marketplace shoppers:** Etsy, with automatic sales, targeted offers and site-wide sales events.

## Downsides

- **Gumroad:** the code box is hidden at checkout unless you turn it on; the use limit counts every item in the cart.
- **Lemon Squeezy:** thin help docs on discounts; no code-free sale, minimum order or bundle setup described.
- **Payhip:** coupon expiry is in UTC; sales don't work on subscriptions or payment plans; minimum spend isn't in the coupon help article.
- **Sellfy:** upsells need the $79-a-month Business plan or higher; a sale switches off pay what you want; its pages give two different minimum prices.
- **Etsy:** percentage codes capped at 75%; use limits are locked once set; no pay what you want; honest-pricing rules on sales.

## Tools and kits for sellers

- [Gumroad bundle & discount calculator](gumroad-bundle-discount-calculator) (free): price a bundle or offer code and compare your payout with selling each product separately
- [Gumroad fee calculator](gumroad-fee-calculator) (free): what you keep on direct and Discover sales
- [Seller fee comparison calculator](seller-fee-comparison-calculator) (free): what you keep per sale on each platform
- [Etsy fee & profit calculator](etsy-fee-calculator) (free): every Etsy fee on an order, including discounted ones
- [Gumroad sales CSV analyzer](gumroad-sales-csv-analyzer) (free, in your browser): see how your discounted sales did by product and month
- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)** (our product, pay what you want from $9)
- **[Gumroad Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm)** (our product)

Etsy's sale rules point to consumer protection laws, which differ by country and state. This guide isn't legal or tax advice.

## Sources

All checked 2026-10-20 on each company's official site.
- Gumroad, Discount codes (letters and numbers only; chosen or all products with exclusions; amount or percentage; checkout box toggle; automatic discount with crossed-out price; never stack, larger wins; total-use limit, each item counts; validity period; minimum amount and quantity; new/existing customers; code in URL and custom domain; PPP; affiliate link): https://gumroad.com/help/article/128-discount-codes ; Gumroad's fees (10% + $0.50 per transaction, plus 2.9% + $0.30 card processing or PayPal fees; 30% on Discover): https://gumroad.com/help/article/66-gumroads-fees ; Product bundles (cumulative value crossed out): https://gumroad.com/help/article/339-product-bundles ; Creating an Upsell (optional discount on an added product): https://gumroad.com/help/article/331-creating-upsells ; "Pay what you want" pricing (minimum is the Amount; $0.99 minimum above $0; suggested amount): https://gumroad.com/help/article/133-pay-what-you-want-pricing
- Lemon Squeezy, Creating Discount Codes (percentage or fixed, specific products or store-wide, start and expiry date, redemption limit, monthly repeat): https://docs.lemonsqueezy.com/help/orders/creating-discount-codes ; Create a Discount API (3 to 256 characters; percent or fixed; max_redemptions; starts_at/expires_at; once/repeating/forever): https://docs.lemonsqueezy.com/api/discounts/create-discount ; Create a Checkout API (discount_code, hide discount field, custom_price): https://docs.lemonsqueezy.com/api/checkouts/create-checkout ; Pre-Filled Checkout Fields (checkout[discount_code]): https://docs.lemonsqueezy.com/help/checkout/prefilled-checkout-fields ; Pay What You Want (minimum and suggested price): https://docs.lemonsqueezy.com/help/products/pay-what-you-want ; Fees (calculated on the total order value; +1.5% international, +1.5% PayPal, +0.5% subscriptions; payout fees): https://docs.lemonsqueezy.com/help/getting-started/fees ; Pricing (5% + 50¢ per transaction; "Create bundles + upsells"): https://www.lemonsqueezy.com/pricing
- Payhip, Coupons (whole order, product or collection; percentage or fixed; overall use limit; UTC expiry; bulk create up to 50): https://help.payhip.com/article/88-coupons ; API Reference, Coupons (start_date, end_date, minimum_purchase_amount, usage_limit): https://payhip.com/api-reference/coupons/create ; Running Sales (timer, percentage off, before and after price; not for subscriptions or payment plans; store time zone): https://help.payhip.com/article/278-running-sales ; Cross Selling (discount when added to cart; highest wins unless circular reference): https://help.payhip.com/article/89-cross-selling ; Upgrade Discount (after checkout, in the receipt, flexible or fixed expiry): https://help.payhip.com/article/125-upgrade-discount ; Product Bundles: https://help.payhip.com/article/212-product-bundles ; Pay What You Want Pricing ("0+" and "5+"): https://help.payhip.com/article/78-pay-what-you-want-pricing ; Pricing (5% free plan, 2% Plus $29/mo, 0% Pro $99/mo; PayPal and Stripe fees on all plans): https://payhip.com/pricing ; Billing and Upgrading (5% "on any transactions"): https://help.payhip.com/article/102-billing-and-upgrading
- Sellfy, How to add coupons and discounts (coupon and sale; percentage or amount; products with exclusions; dates in local time; redemption limits; countdown timer; prioritization; $0.90 minimum after discount; sale disables PWYW; link with -CODE; not case sensitive; no category discounts): https://docs.sellfy.com/article/32-discount-codes ; How does upselling work? (Business and Premium only; discount up to 100%, expiry, shopping cart required): https://docs.sellfy.com/article/136-how-does-upselling-work ; How to collect donations (pay what you want, $0.50 minimum): https://docs.sellfy.com/article/133-how-to-collect-donations ; How much does Sellfy cost? (no Sellfy transaction fees; Stripe 2.9% + $0.30; PayPal "2.9% + $0.30 in the US"; upselling not on Starter): https://docs.sellfy.com/article/211-how-much-does-sellfy-cost ; Pricing ($29 or $22/mo yearly Starter, $79/$59 Business, $159/$119 Premium; 0% transaction fees; upselling not on Starter): https://sellfy.com/pricing/ ; Selling digital products (up to 50 files per product): https://docs.sellfy.com/article/207-selling-digital-products
- Etsy, How to Set Up Sales and Discounts for Your Shop (promo codes 5% to 75% whole numbers, fixed amount or free shipping; use limits; one per buyer; sales; order minimum; bundles up to 3 listings; targeted offers; highest discount wins): https://help.etsy.com/hc/en-us/articles/115014260108-How-to-Set-Up-Sales-and-Discounts-for-Your-Shop ; How to Participate in Sales Events on Etsy (Cyber Specials November 23 to December 1, opt in by October 27, at least 25% off; no artificial price increases; original price in place for a substantial time; sales need no code): https://help.etsy.com/hc/en-us/articles/360039531534-How-to-Participate-in-Sales-Events-on-Etsy ; How Etsy Funded Coupons Work For Sellers (you get the full order amount and pay the same fees): https://help.etsy.com/hc/en-us/articles/1500005142242-How-Etsy-Funded-Coupons-Work-For-Sellers ; Etsy Fee Basics ($0.20 listing and auto-renew fee; 6.5% of the total order amount): https://help.etsy.com/hc/en-us/articles/360035902374-What-are-the-Fees-and-Taxes-for-Selling-on-Etsy ; Payment Processing Fees (US 3% + 0.25 USD of the total sale price): https://help.etsy.com/hc/en-us/articles/115015628847-What-are-Payment-Processing-Fees-for-Selling-on-Etsy
- Stripe, Pricing (2.9% + 30¢ per successful transaction for domestic cards): https://stripe.com/pricing
- PayPal, Merchant fees, US (Standard credit and debit card payments 2.99% + fixed fee; PayPal Checkout 3.49% + fixed fee; fixed fee 0.49 USD): https://www.paypal.com/us/business/paypal-business-fees

## Related guides

- [Gumroad fees in 2026, explained](gumroad-fees-explained)
- [Etsy fees explained (2026)](etsy-fees-explained)
- [Refunds and chargebacks on digital products](refunds-and-chargebacks-digital-products-gumroad-lemon-squeezy-payhip-sellfy-etsy)
