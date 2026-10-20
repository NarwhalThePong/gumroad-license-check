---
layout: page
title: "Gumroad 1099-K and taxes: reconcile what Gumroad reports with what you actually earned"
description: "Your Gumroad 1099-K shows gross sales, not what hit your bank. How to reconcile fees, refunds and sales tax for Schedule C."
---


Every January, Gumroad sellers in the US open a 1099-K and see a number bigger than anything that landed in their bank account. That's expected. The 1099-K reports **gross** payments. Fees, refunds and the sales tax/VAT Gumroad collected on your behalf are not taken out. Your job is to show the IRS how you get from that gross figure to your real profit.

*Not tax advice. Rules and thresholds change, so confirm with a tax professional.*

## The four numbers you need

1. **Gross sales**: what buyers paid for your products, before anything is deducted.
2. **Refunds and chargebacks**: money that went back to buyers.
3. **Gumroad fees**: currently 10% + $0.50 per direct sale, and 30% on sales through Gumroad Discover.
4. **Sales tax / VAT**: Gumroad acts as merchant of record and remits this. It isn't your income, but it can show up inside the gross total depending on the report.

Net = gross − refunds − fees. On Schedule C that typically looks like this:

| Schedule C line | What goes there |
|---|---|
| Line 1, gross receipts | Gross sales (should reconcile with the 1099-K) |
| Line 2, returns and allowances | Refunds and chargebacks |
| Line 10, commissions and fees | Gumroad fees |

## Getting the data out of Gumroad

Gumroad lets you export your sales as a CSV for a date range from the sales area of your dashboard (the menu names change from time to time). Export the whole tax year. If the export is too large, split it into two halves.

## Doing the math by hand (spreadsheet)

- Filter the CSV to the tax year using the purchase date.
- Sum the sale price column for **gross**.
- Sum the fee column. If there's no fee column, estimate each row: `price * 0.10 + 0.50` for direct sales, `price * 0.30` for Discover sales.
- Sum the refunded amounts for rows marked refunded.
- Sum any tax column separately and keep it **out** of income.
- Check: gross − refunds − fees should be close to your total payouts for the year, give or take payouts that crossed Dec 31.

## Common mistakes

- **Reporting payouts as income.** Payouts are net of fees, so you'd under-report gross and the IRS matching system will flag the gap against your 1099-K. Report gross, then deduct the fees.
- **Counting sales tax/VAT as revenue.** It isn't yours.
- **Using payout dates instead of sale dates.** A December 30 sale paid out on January 5 still belongs to the earlier year for most cash-basis sellers, since you received it when Gumroad collected it. Ask your preparer if you're unsure.
- **Forgetting refunds from the following January** on sales made in December. Count them in the year they happen.

## Automating it

If you'd rather not rebuild this spreadsheet every year, the **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)** spreadsheet imports your sales CSV, does the fee math above, tracks refunds and sets aside a tax buffer as you go. For charts and per-product reports, there's the **[Gumroad Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm)**.

Related: [Gumroad fees in 2026, explained](gumroad-fees-explained).
