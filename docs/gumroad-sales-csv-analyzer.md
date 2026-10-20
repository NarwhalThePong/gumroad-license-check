---
layout: page
title: "Gumroad sales CSV analyzer: gross, refunds, fees and net by product, month, referrer and country"
description: "Free Gumroad sales CSV analyzer. Open your Gumroad sales export and see gross sales, refunds, fees, net, order count, average order value, revenue by product and month, top referrers and countries. Runs in your browser; the file is never uploaded."
---

Gumroad's sales export is a wide CSV with around 50 columns, and the dashboard doesn't break refunds, fees and referrers down the way you need for pricing or taxes. Pick your export below and this page totals it for you: gross sales, refunds, Gumroad fees, net, number of sales, average order value, and revenue by product, by month, by referrer and by country. The file is read by your browser with JavaScript and **never leaves your computer**; this page has no server and stores nothing.

To get the CSV: in Gumroad, open **Sales**, click the **Export** icon, choose a date range (add a day on each side, since the CSV uses UTC) and download. If the file is large, Gumroad emails it to you.

<div id="gsa" style="border:1px solid #ddd;border-radius:8px;padding:16px;margin:16px 0">
  <p><label>Your Gumroad sales CSV<br><input id="gsa-file" type="file" accept=".csv,text/csv"></label></p>
  <p><button type="button" id="gsa-sample">Try with example data</button> <button type="button" id="gsa-dl" disabled>Download summary CSV</button></p>
  <p id="gsa-status"></p>
  <div id="gsa-out" style="display:none">
    <h3>Totals</h3>
    <table style="width:100%;max-width:520px"><tbody id="gsa-totals"></tbody></table>
    <h3>By product</h3>
    <table style="width:100%"><thead><tr><th>Product</th><th>Sales</th><th>Gross</th><th>Refunds</th><th>Net</th></tr></thead><tbody id="gsa-products"></tbody></table>
    <h3>By month (UTC)</h3>
    <table style="width:100%"><thead><tr><th>Month</th><th>Sales</th><th>Gross</th><th>Refunds</th><th>Net</th></tr></thead><tbody id="gsa-months"></tbody></table>
    <h3>Top referrers</h3>
    <table style="width:100%"><thead><tr><th>Referrer</th><th>Sales</th><th>Gross</th><th>Refunds</th><th>Net</th></tr></thead><tbody id="gsa-refs"></tbody></table>
    <h3>Top countries</h3>
    <table style="width:100%"><thead><tr><th>Country</th><th>Sales</th><th>Gross</th><th>Refunds</th><th>Net</th></tr></thead><tbody id="gsa-countries"></tbody></table>
    <p id="gsa-cols"><small></small></p>
  </div>
</div>

<script>
(function () {
  /*check-start*/
  function parseCSV(text) {
    text = String(text || "").replace(/^\uFEFF/, "");
    var first = text.split(/\r?\n/)[0] || "", delim = ",";
    var counts = { ",": first.split(",").length, ";": first.split(";").length, "\t": first.split("\t").length };
    if (counts[";"] > counts[delim]) delim = ";";
    if (counts["\t"] > counts[delim]) delim = "\t";
    var rows = [], row = [], field = "", q = false, i = 0, c;
    while (i < text.length) {
      c = text.charAt(i);
      if (q) {
        if (c === '"') { if (text.charAt(i + 1) === '"') { field += '"'; i += 2; continue; } q = false; i++; continue; }
        field += c; i++; continue;
      }
      if (c === '"') { q = true; i++; continue; }
      if (c === delim) { row.push(field); field = ""; i++; continue; }
      if (c === "\r") { i++; continue; }
      if (c === "\n") { row.push(field); rows.push(row); row = []; field = ""; i++; continue; }
      field += c; i++;
    }
    if (field !== "" || row.length) { row.push(field); rows.push(row); }
    return rows.filter(function (r) { return r.some(function (v) { return String(v).trim() !== ""; }); });
  }
  var COLS = {
    product: ["item name", "product name", "product", "item", "name"],
    price: ["sale price ($)", "sale price", "price ($)", "price", "amount", "total"],
    fee: ["gumroad fee ($)", "fees ($)", "gumroad fee", "fees", "fee"],
    affiliate: ["affiliate commission ($)", "affiliate commission"],
    refunded: ["fully refunded?", "fully refunded", "refunded?", "refunded"],
    partial: ["partial refund ($)", "partial refund", "refund amount ($)", "refund amount"],
    disputed: ["disputed?", "disputed", "chargebacked?", "chargebacked"],
    disputeWon: ["dispute won?", "dispute won"],
    date: ["purchase date", "sale date", "created at", "created_at", "date", "purchase time (utc timezone)", "sale timestamp"],
    referrer: ["referrer", "referer", "source"],
    country: ["country", "buyer country", "ip country"],
    discount: ["discount code", "offer code", "discount"]
  };
  function norm(h) { return String(h || "").trim().toLowerCase().replace(/\s+/g, " "); }
  function mapColumns(header) {
    var h = header.map(norm), map = {};
    Object.keys(COLS).forEach(function (k) {
      for (var j = 0; j < COLS[k].length; j++) { var ix = h.indexOf(COLS[k][j]); if (ix >= 0) { map[k] = ix; return; } }
    });
    if (map.refunded != null && h[map.refunded].indexOf("fully") < 0) {
      var f = h.indexOf("fully refunded?"); if (f >= 0) map.refunded = f;
    }
    return map;
  }
  function num(v) {
    var s = String(v == null ? "" : v).trim(); if (!s) return 0;
    var neg = /^\(.*\)$/.test(s) || /^-/.test(s.replace(/[^\d\-.,(]/g, ""));
    s = s.replace(/[^\d.,]/g, "");
    if (/,\d{1,2}$/.test(s) && s.lastIndexOf(".") < s.lastIndexOf(",")) s = s.replace(/\./g, "").replace(",", ".");
    else s = s.replace(/,/g, "");
    var n = parseFloat(s); if (!isFinite(n)) return 0;
    return neg ? -n : n;
  }
  function truthy(v) { var s = norm(v); return s === "1" || s === "true" || s === "yes" || s === "y" || s === "t"; }
  function month(v) {
    var s = String(v || "").trim(), m = s.match(/(\d{4})-(\d{1,2})/);
    if (m) return m[1] + "-" + ("0" + m[2]).slice(-2);
    m = s.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})/);
    if (m) return m[3] + "-" + ("0" + m[1]).slice(-2);
    var d = new Date(s); if (!isNaN(d.getTime())) return d.getUTCFullYear() + "-" + ("0" + (d.getUTCMonth() + 1)).slice(-2);
    return "Unknown";
  }
  function refName(v) {
    var s = String(v || "").trim();
    if (!s || norm(s) === "direct") return "direct";
    var m = s.match(/^[a-z]+:\/\/([^\/?#]+)/i); if (m) s = m[1];
    return s.replace(/^www\./i, "").toLowerCase();
  }
  function r2(n) { return Math.round(n * 100) / 100; }
  function analyze(text) {
    var rows = parseCSV(text);
    if (rows.length < 1) return { error: "The file is empty." };
    var header = rows[0], map = mapColumns(header);
    if (map.price == null) return { error: "Couldn't find a price column (looked for 'Sale Price ($)', 'Price', 'Amount'). Is this a Gumroad sales export?", map: map, header: header };
    var t = { sales: 0, gross: 0, refunds: 0, fees: 0, affiliate: 0, net: 0, refundedCount: 0, disputedCount: 0, discountCount: 0 };
    var groups = { product: {}, month: {}, referrer: {}, country: {} };
    function add(g, key, gross, ref, net) {
      var o = groups[g][key] || (groups[g][key] = { key: key, sales: 0, gross: 0, refunds: 0, net: 0 });
      o.sales++; o.gross += gross; o.refunds += ref; o.net += net;
    }
    for (var i = 1; i < rows.length; i++) {
      var r = rows[i]; function get(k) { return map[k] != null ? r[map[k]] : ""; }
      var price = num(get("price")), fee = num(get("fee")), aff = num(get("affiliate")), ref = 0;
      var part = num(get("partial")), fully = map.refunded != null && truthy(get("refunded")) && !(part > 0 && norm(header[map.refunded]).indexOf("fully") < 0);
      var disputed = map.disputed != null && truthy(get("disputed")) && !(map.disputeWon != null && truthy(get("disputeWon")));
      if (fully || disputed) ref = price; else if (part > 0) ref = Math.min(part, price);
      if (ref > 0) t.refundedCount++;
      if (disputed) t.disputedCount++;
      if (map.discount != null && String(get("discount")).trim()) t.discountCount++;
      var net = price - ref - fee - aff;
      t.sales++; t.gross += price; t.refunds += ref; t.fees += fee; t.affiliate += aff; t.net += net;
      add("product", String(get("product")).trim() || "(no name)", price, ref, net);
      add("month", map.date != null ? month(get("date")) : "Unknown", price, ref, net);
      add("referrer", map.referrer != null ? refName(get("referrer")) : "(no referrer column)", price, ref, net);
      add("country", map.country != null ? (String(get("country")).trim() || "Unknown") : "(no country column)", price, ref, net);
    }
    ["gross", "refunds", "fees", "affiliate", "net"].forEach(function (k) { t[k] = r2(t[k]); });
    t.aov = t.sales ? r2(t.gross / t.sales) : 0;
    function list(g, sortKey) {
      return Object.keys(groups[g]).map(function (k) { var o = groups[g][k]; o.gross = r2(o.gross); o.refunds = r2(o.refunds); o.net = r2(o.net); return o; })
        .sort(sortKey === "key" ? function (a, b) { return a.key < b.key ? -1 : a.key > b.key ? 1 : 0; } : function (a, b) { return b.gross - a.gross || b.sales - a.sales; });
    }
    var found = Object.keys(map).map(function (k) { return k + ": " + header[map[k]]; });
    return { totals: t, products: list("product"), months: list("month", "key"), referrers: list("referrer"), countries: list("country"), columns: found, hasFees: map.fee != null, hasAffiliate: map.affiliate != null };
  }
  function money(n) { return (n < 0 ? "-$" : "$") + Math.abs(n).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ","); }
  function safeCell(v) {
    var s = String(v);
    if (typeof v !== "number" && /^[=+\-@\t\r]/.test(s)) s = "'" + s;
    return /[",\r\n]/.test(s) ? '"' + s.replace(/"/g, '""') + '"' : s;
  }
  function summaryCSV(a) {
    var out = [["Section", "Name", "Sales", "Gross", "Refunds", "Net"]], t = a.totals;
    out.push(["Totals", "All sales", t.sales, t.gross, t.refunds, t.net]);
    out.push(["Totals", "Gumroad fees", "", t.fees, "", ""]);
    if (a.hasAffiliate) out.push(["Totals", "Affiliate commission", "", t.affiliate, "", ""]);
    out.push(["Totals", "Average order value", "", t.aov, "", ""]);
    [["Product", a.products], ["Month", a.months], ["Referrer", a.referrers], ["Country", a.countries]].forEach(function (s) {
      s[1].forEach(function (o) { out.push([s[0], o.key, o.sales, o.gross, o.refunds, o.net]); });
    });
    return out.map(function (r) { return r.map(safeCell).join(","); }).join("\r\n") + "\r\n";
  }
  var SAMPLE = [
    "Purchase ID,Item Name,Purchase Email,Purchase Date,Sale Price ($),Gumroad Fee ($),Net Total ($),Country,Referrer,Refunded?,Partial Refund ($),Fully Refunded?,Disputed?,Dispute Won?,Discount Code",
    "EX-1,Example Icon Pack,a@example.com,2026-08-03,19,2.40,16.60,United States,https://twitter.com/,0,0,0,0,0,",
    "EX-2,Example Icon Pack,b@example.com,2026-08-17,19,2.40,16.60,Germany,direct,1,0,1,0,0,",
    "EX-3,\"Example Course, Full Edition\",c@example.com,2026-09-02,49,5.40,43.60,United States,https://www.youtube.com/watch?v=x,0,0,0,0,0,LAUNCH20",
    "EX-4,\"Example Course, Full Edition\",d@example.com,2026-09-21,49,5.40,43.60,Canada,gumroad.com,1,10,0,0,0,",
    "EX-5,Example Notion Template,e@example.com,2026-10-05,9,1.40,7.60,United Kingdom,https://twitter.com/,0,0,0,0,0,",
    "EX-6,Example Notion Template,f@example.com,2026-10-11,9,1.40,7.60,United States,direct,0,0,0,1,0,"
  ].join("\n");
  /*check-end*/
  function $(i) { return document.getElementById(i); }
  var last = null;
  function fill(id, items, limit) {
    var tb = $(id); while (tb.firstChild) tb.removeChild(tb.firstChild);
    items.slice(0, limit || items.length).forEach(function (o) {
      var tr = document.createElement("tr");
      [o.key, String(o.sales), money(o.gross), money(o.refunds), money(o.net)].forEach(function (v, j) {
        var td = document.createElement("td"); td.textContent = v; if (j) td.style.textAlign = "right"; tr.appendChild(td);
      });
      tb.appendChild(tr);
    });
  }
  function render(text, label) {
    var a = analyze(text);
    if (a.error) { last = null; $("gsa-dl").disabled = true; $("gsa-out").style.display = "none"; $("gsa-status").textContent = a.error; return; }
    last = a; var t = a.totals;
    $("gsa-status").textContent = "Analyzed " + t.sales + " sales from " + label + ".";
    var rows = [["Gross sales", money(t.gross)], ["Refunds (incl. lost disputes)", "-" + money(t.refunds) + " (" + t.refundedCount + " orders)"],
      ["Gumroad fees", a.hasFees ? "-" + money(t.fees) : "no fee column"]];
    if (a.hasAffiliate) rows.push(["Affiliate commission", "-" + money(t.affiliate)]);
    rows.push(["Net (gross - refunds - fees" + (a.hasAffiliate ? " - affiliate" : "") + ")", money(t.net)], ["Number of sales", String(t.sales)],
      ["Average order value", money(t.aov)], ["Sales with a discount code", String(t.discountCount)]);
    var tb = $("gsa-totals"); while (tb.firstChild) tb.removeChild(tb.firstChild);
    rows.forEach(function (x) {
      var tr = document.createElement("tr"), c1 = document.createElement("td"), c2 = document.createElement("td");
      c1.textContent = x[0]; c2.textContent = x[1]; c2.style.textAlign = "right"; tr.appendChild(c1); tr.appendChild(c2); tb.appendChild(tr);
    });
    fill("gsa-products", a.products); fill("gsa-months", a.months); fill("gsa-refs", a.referrers, 15); fill("gsa-countries", a.countries, 15);
    $("gsa-cols").firstChild.textContent = "Columns used: " + a.columns.join("; ") + ".";
    $("gsa-out").style.display = ""; $("gsa-dl").disabled = false;
  }
  $("gsa-file").addEventListener("change", function () {
    var f = this.files && this.files[0]; if (!f) return;
    var rd = new FileReader();
    rd.onload = function () { render(String(rd.result), "your file"); };
    rd.onerror = function () { $("gsa-status").textContent = "Couldn't read that file."; };
    rd.readAsText(f);
  });
  $("gsa-sample").addEventListener("click", function () { render(SAMPLE, "the made-up example data (not real sales)"); });
  $("gsa-dl").addEventListener("click", function () {
    if (!last) return;
    var url = URL.createObjectURL(new Blob([summaryCSV(last)], { type: "text/csv" })), a = document.createElement("a");
    a.href = url; a.download = "gumroad-sales-summary.csv"; document.body.appendChild(a); a.click(); document.body.removeChild(a);
    setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
  });
})();
</script>

## How the numbers are worked out

- **Gross** is the sum of `Sale Price ($)`, what buyers paid including variants.
- **Refunds** count the full sale price for rows marked `Fully Refunded?` and lost disputes (`Disputed?` without `Dispute Won?`), and the `Partial Refund ($)` amount otherwise.
- **Fees** are the sum of `Gumroad Fee ($)` (older exports call it `Fees ($)`). Gumroad keeps its fee on refunded sales, so fees are not reduced by refunds.
- **Net** is gross minus refunds, fees and any `Affiliate commission ($)`. It can differ slightly from your payouts because of payout timing, currency conversion and payment processor adjustments.
- **Months** use the `Purchase Date` column, which Gumroad exports in UTC.
- Columns are matched by name, so trimmed or re-ordered exports and CSVs from spreadsheets work too. Missing columns are simply skipped.

## Want this automatically every day?

This page is for a quick look at one export. If you want the same report rebuilt from the Gumroad API on a schedule, with refund rate and daily trends, the [Gumroad Sales Dashboard Kit](https://paudrudis.gumroad.com/l/btvjm/LAUNCH30) does it with one command. For a live spreadsheet instead, see [Sync Gumroad sales to Google Sheets automatically](sync-gumroad-sales-to-google-sheets), and for tax season, [Gumroad 1099-K and taxes](gumroad-1099-k-taxes).

Related: [Gumroad fee calculator](gumroad-fee-calculator), [bundle & discount calculator](gumroad-bundle-discount-calculator) and [license key checker](gumroad-license-key-checker).
