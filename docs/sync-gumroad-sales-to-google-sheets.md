---
layout: page
title: "Sync Gumroad sales to Google Sheets automatically (free, no Zapier)"
description: "A copy-paste Google Apps Script that pulls your Gumroad sales into a Google Sheet every hour, keeps refunds up to date, and blocks formula injection from buyer fields."
---

Gumroad lets you export sales as a CSV, but that is a manual download (if you already have one, the free [Gumroad sales CSV analyzer](gumroad-sales-csv-analyzer) totals it by product, month and referrer in your browser). If you want a sheet that fills itself, you don't need Zapier or a server. A short Google Apps Script can read the Gumroad Sales API on a timer, for free, inside your own Google account.

This version does three things most quick setups skip:

- **Refunds update the existing row.** Every run re-reads the last 7 days, so a refund or chargeback flips the flag on the original sale instead of being missed.
- **No duplicates.** Rows are keyed by Gumroad's sale ID.
- **Buyer fields can't run formulas.** A name or email starting with `=`, `+`, `-` or `@` is stored as text, so a buyer can't plant `=IMPORTXML(...)` in your sheet.

## 1. Get a Gumroad access token

In Gumroad, open **Settings → Advanced**, create an application (any name, and any redirect URI such as `https://localhost`), then click **Generate access token**. Treat the token like a password: it can read all of your sales.

## 2. Add the script to a sheet

Create a Google Sheet, open **Extensions → Apps Script**, delete the sample code and paste this:

```javascript
// Gumroad -> Google Sheets sales sync. Free, runs on a timer in your own Google account.
// Setup: Project Settings > Script properties > add GUMROAD_TOKEN (your access token).
const SHEET_NAME = 'Sales';
const HEADERS = ['sale_id', 'date', 'product', 'permalink', 'email', 'country',
  'price', 'gumroad_fee', 'net', 'refunded', 'chargedback', 'discover', 'referrer'];
const LOOKBACK_DAYS = 7; // re-read the last week so refunds update existing rows

function syncGumroadSales() {
  const token = PropertiesService.getScriptProperties().getProperty('GUMROAD_TOKEN');
  if (!token) throw new Error('Add GUMROAD_TOKEN in Project Settings > Script properties');

  const ss = SpreadsheetApp.getActiveSpreadsheet();
  const sheet = ss.getSheetByName(SHEET_NAME) || ss.insertSheet(SHEET_NAME);
  if (sheet.getLastRow() === 0) sheet.appendRow(HEADERS);

  // Map existing sale ids to their row numbers.
  const rowById = {};
  const last = sheet.getLastRow();
  if (last > 1) {
    sheet.getRange(2, 1, last - 1, 1).getValues()
      .forEach((r, i) => { rowById[String(r[0])] = i + 2; });
  }
  const firstRun = last <= 1;
  const after = new Date(Date.now() - LOOKBACK_DAYS * 864e5);
  const afterStr = Utilities.formatDate(after, 'UTC', 'yyyy-MM-dd');

  const sales = [];
  let pageKey = null;
  do {
    let url = 'https://api.gumroad.com/v2/sales?access_token=' + encodeURIComponent(token);
    if (!firstRun) url += '&after=' + afterStr; // first run imports everything
    if (pageKey) url += '&page_key=' + encodeURIComponent(pageKey);
    const res = UrlFetchApp.fetch(url, { muteHttpExceptions: true });
    const body = JSON.parse(res.getContentText());
    if (res.getResponseCode() !== 200 || !body.success) {
      throw new Error('Gumroad API error ' + res.getResponseCode() + ': ' + res.getContentText().slice(0, 200));
    }
    sales.push(...body.sales);
    pageKey = body.next_page_key || null;
  } while (pageKey);

  const newRows = [];
  sales.forEach(s => {
    const price = (s.price || 0) / 100;          // API amounts are in cents
    const fee = (s.gumroad_fee || 0) / 100;
    const row = [s.id, s.created_at, safe(s.product_name), s.product_permalink,
      safe(s.email), safe(s.country), price, fee, Math.round((price - fee) * 100) / 100,
      !!s.refunded, !!s.chargedback, !!s.discover_fee_charged, safe(s.referrer)];
    const existing = rowById[String(s.id)];
    if (existing) sheet.getRange(existing, 1, 1, row.length).setValues([row]); // refunds update in place
    else newRows.push(row);
  });
  newRows.reverse(); // API returns newest first; keep the sheet oldest to newest
  if (newRows.length) {
    sheet.getRange(sheet.getLastRow() + 1, 1, newRows.length, HEADERS.length).setValues(newRows);
  }
}

// Stops a buyer-supplied value like =IMPORTXML(...) from running as a formula.
function safe(v) {
  const s = v == null ? '' : String(v);
  return /^[=+\-@]/.test(s) ? "'" + s : s;
}

// Run once by hand to schedule the sync every hour.
function installHourlyTrigger() {
  ScriptApp.getProjectTriggers()
    .filter(t => t.getHandlerFunction() === 'syncGumroadSales')
    .forEach(t => ScriptApp.deleteTrigger(t));
  ScriptApp.newTrigger('syncGumroadSales').timeBased().everyHours(1).create();
}
```

Then open **Project Settings** (the gear icon), scroll to **Script properties**, and add a property named `GUMROAD_TOKEN` with your token as the value. Keeping it there instead of in the code means you can share the sheet or the script without leaking it.

## 3. Run it once, then schedule it

Back in the editor, pick `syncGumroadSales` in the function menu and click **Run**. Google asks you to authorize the script to edit the sheet and connect to an external service; that external service is `api.gumroad.com`. The first run imports your full sales history into a tab called **Sales**.

Then pick `installHourlyTrigger` and run it once. From now on the sheet syncs every hour. You can see or delete the trigger under **Triggers** (the clock icon).

## How it works

- `GET https://api.gumroad.com/v2/sales` returns sales newest first, a page at a time, with a `next_page_key` when there is another page. The script follows it until there are no pages left.
- After the first import it passes `after=` (7 days back), so each run is a few small requests even for a big store.
- `price` and `gumroad_fee` come back in cents. The sheet stores dollars, plus a `net` column (price minus Gumroad's fee). Sales that came through Gumroad Discover show `discover = TRUE`.
- A refund older than 7 days won't be picked up automatically. If you refund old orders, change `LOOKBACK_DAYS` to 30 or 60. It costs a few more API calls per run and nothing else.

## Common problems

- **"Add GUMROAD_TOKEN..."**: the script property is missing or misspelled. The name is case sensitive.
- **"Gumroad API error 401"**: the token was revoked or copied with a space. Generate a new one.
- **Duplicate rows after editing**: don't sort or delete the `sale_id` column. Sort a filtered view or a second tab instead.
- **Nothing new appears**: check **Executions** in the Apps Script editor for errors, and make sure the trigger exists.

## Turning the sheet into reports

Raw rows answer "did I sell anything?" For monthly totals, fees, refunds and taxes you need more. These are our own paid products, and we earn the sale price if you buy one:

- **[Gumroad Seller Finance Tracker](https://paudrudis.gumroad.com/l/sudmq)** ($9+): paste or import your sales, and it applies Gumroad's fees to every row (10% + $0.50 plus 2.9% + $0.30 card processing on direct sales, 30% on Discover), with a P&L, a chart, refunds and a tax set-aside sheet.
- **[Gumroad Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm)** ($15+): one command turns your sales into a CSV and a Markdown report by product, referrer and day, net of fees, with refund rate.
- **[Gumroad Ping Relay](https://paudrudis.gumroad.com/l/tdohx)** ($9+): instant, verified sale and refund alerts in Discord, Slack or Telegram, if hourly isn't fast enough.
- **[n8n Workflows for Gumroad Sellers](https://payhip.com/b/st5cr)** ($19, on Payhip): if you already run n8n, verified sale alerts that append each sale to Google Sheets, plus refund revokes, a weekly digest and a monthly CSV export.

## Related guides

- [Gumroad fees in 2026, explained](gumroad-fees-explained)
- [Gumroad 1099-K and taxes](gumroad-1099-k-taxes)
- [Get Gumroad sale alerts in Discord, Slack or Telegram](gumroad-sale-alerts-discord-slack-telegram)

Not affiliated with Gumroad or Google.
