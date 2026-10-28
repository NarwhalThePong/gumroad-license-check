---
layout: page
title: "Free tax & seller fee APIs for developers (2026): self-employment tax, QBI, per diem, platform fees"
description: "Three free JSON APIs for 2026: US freelancer tax (self-employment tax, quarterly estimates, due dates, mileage, home office, SEP/Solo 401(k), QBI), seller fees (Gumroad, Etsy, Stripe, PayPal) and GSA per diem rates. No key needed, curl examples included."
---

The calculators on this site also run as three small **free JSON APIs**. They use the same math as the pages (same tests), so you can put 2026 self-employment tax, quarterly estimates, the QBI deduction, platform fees or GSA per diem rates into your own app, spreadsheet, invoice tool or AI agent. Each API answers `GET` with query parameters or `POST` with a JSON body, and sends CORS headers so it works from the browser. No API key is needed. Hit `/` on any of them to get a list of endpoints and a working example.

| API | Base URL | What it covers |
|---|---|---|
| US Freelancer Tax API (2026) | `https://us-freelancer-tax-api.narwhalapis.workers.dev` | Self-employment tax, quarterly estimated tax, 2026 due dates, IRS mileage (split-year rates), home office (simplified vs Form 8829), SEP IRA / Solo 401(k) limits, QBI (Section 199A) deduction |
| Seller Fee API | `https://seller-fee-api.narwhalapis.workers.dev` | Fee, net payout and effective rate for Gumroad (direct, high volume, Discover), Etsy, Stripe and PayPal (each payment type), plus the price you need to keep a target amount |
| US Per Diem API (GSA FY2026/FY2027) | `https://us-per-diem-api.narwhalapis.workers.dev` | GSA lodging and M&IE rates by ZIP, city or state, and trip totals with the 75% first and last day rule |

All three APIs are also listed on RapidAPI with a free plan: [US Freelancer Tax API on RapidAPI](https://rapidapi.com/narwhalapis/api/us-freelancer-tax-api-self-employment-quarterly-tax-2026), [Seller Fee API on RapidAPI](https://rapidapi.com/narwhalapis/api/seller-fee-api-gumroad-etsy-stripe-paypal-fees) and [US Per Diem API on RapidAPI](https://rapidapi.com/narwhalapis/api/us-per-diem-api-gsa-lodging-m-ie-rates-2026).

## Freelancer tax examples

Self-employment tax on $80,000 of net profit:

```bash
curl "https://us-freelancer-tax-api.narwhalapis.workers.dev/v1/se-tax?net_profit=80000"
```

You get net earnings from self-employment ($73,880), Social Security ($9,161.12), Medicare ($2,142.52), the total self-employment tax ($11,303.64) and the deductible half.

Quarterly estimated tax for a single filer, sent as JSON:

```bash
curl -X POST "https://us-freelancer-tax-api.narwhalapis.workers.dev/v1/estimate" \
  -H "content-type: application/json" \
  -d '{"net_profit": 80000, "filing_status": "single"}'
```

The answer has total federal tax ($16,647.47 in this example), the share of profit to set aside (20.81%) and the four quarterly payments with their 2026 due dates.

QBI (Section 199A) deduction:

```bash
curl "https://us-freelancer-tax-api.narwhalapis.workers.dev/v1/qbi?qbi=80000&taxable_income=70000&filing_status=single"
```

Here the 20% QBI amount is $16,000, but the taxable income cap (20% of $70,000) limits the deduction to $14,000. Other endpoints: `/v1/figures` (every 2026 figure with its IRS source), `/v1/due-dates`, `/v1/estimate/batch`, `/v1/mileage`, `/v1/mileage/rates`, `/v1/home-office` and `/v1/retirement`.

## Seller fee examples

What Gumroad takes on a $20 direct sale:

```bash
curl "https://seller-fee-api.narwhalapis.workers.dev/v1/fee?platform=gumroad&amount=20"
```

Fee $3.38 (10% + $0.50, plus card processing), net $16.62. To compare Gumroad, Etsy, Stripe and every PayPal payment type at once, sorted by what you keep, call `/v1/compare?amount=20`. To find the price that leaves you $20 after fees, call `/v1/price?platform=gumroad&target=20`, which gives $23.89. `/v1/platforms` lists every platform and the rates it uses, each with a link to the official fee page.

## Per diem examples

GSA rates for a ZIP code:

```bash
curl "https://us-per-diem-api.narwhalapis.workers.dev/v1/rates?zip=10001"
```

Trip total for New York City, Nov 10–12, 2026:

```bash
curl "https://us-per-diem-api.narwhalapis.workers.dev/v1/trip?zip=10001&start=2026-11-10&end=2026-11-12"
```

That's 2 nights at the $358 lodging maximum ($716) plus $230 of M&IE ($69 on each 75% travel day and $92 on the full day), so $946 in total. `/v1/meta` shows the fiscal years the data covers, and `/v1/mie` gives the M&IE breakdown table.

## Use them from an AI assistant (MCP)

If you'd rather ask an AI assistant than call HTTP, the same math ships as two free MCP servers on npm: [freelance-tax-mcp](https://www.npmjs.com/package/freelance-tax-mcp) (self-employment tax, quarterly estimates, hourly rate, QBI and more) and [seller-fees-mcp](https://www.npmjs.com/package/seller-fees-mcp) (platform fees and target prices). Run them with `npx -y freelance-tax-mcp` or `npx -y seller-fees-mcp`.

## Limits and fine print

- The APIs run on a free hosting plan. Please keep request rates reasonable and use the batch endpoints for bulk work.
- Results are estimates for planning. They follow published IRS, SSA, GSA and platform rates, which are listed in each response, but they are not tax advice. Check the official source before you file.
- Platform fees change. Every seller fee response includes `rates_as_of` and the source URL.

## Related tools and guides

- [Self-employment tax calculator](self-employment-tax-calculator), the page version of `/v1/se-tax`
- [Freelance quarterly estimated tax calculator](freelance-quarterly-estimated-tax-calculator), the page version of `/v1/estimate`
- [QBI deduction calculator](qbi-deduction-calculator), the page version of `/v1/qbi`
- [Seller fee comparison calculator](seller-fee-comparison-calculator), which also covers Payhip, Ko-fi, Lemon Squeezy, Paddle and Polar
- [GSA per diem calculator](gsa-per-diem-calculator), the page version of `/v1/trip`

*Disclosure: these APIs, MCP servers and calculators are our own, and they're free. We don't earn anything from the links on this page, and none are affiliate links. Not affiliated with the IRS, GSA or any of the platforms listed.* More guides: [Gumroad developer guides](./).
