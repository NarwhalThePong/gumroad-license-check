---
layout: page
title: "Selling a paid Discord on Gumroad: remove roles on refund and chargeback"
description: "How to grant Discord roles from Gumroad license keys and revoke them on refunds, chargebacks and ended subscriptions, without trusting unsigned pings."
---

A paid Discord is one of the easiest things to sell on Gumroad: a course community, a trading channel, a mod-support server. The usual setup goes like this: buyer pays, buyer pastes their license key into a bot, and the bot gives them a role.

There are two quiet bugs in almost every version of that setup.

## Bug 1: `success: true` doesn't mean "paid"

Gumroad's `POST /v2/licenses/verify` returns `success: true` for a key **even after the purchase was refunded or charged back**. You have to check the purchase flags yourself:

```js
function isActive(p) {
  if (p.refunded || p.chargebacked || p.disputed) return false;
  if (p.subscription_ended_at || p.subscription_cancelled_at || p.subscription_failed_at) return false;
  return true;
}
```

If your bot only checks `success`, a buyer can pay, get the role, refund, and stay in your server indefinitely.

## Bug 2: Gumroad pings aren't signed

To remove roles on refund, you'll use Gumroad's Ping (Settings → Advanced). But the ping is a plain form POST with no signature. Anyone who learns the URL can send `sale_id=...` and pretend.

The fix is simple: **treat the ping only as a "something changed" signal**. Pull the sale ID out of it and re-fetch the real record:

```js
const r = await fetch(`https://api.gumroad.com/v2/sales/${saleId}`, {
  headers: { Authorization: `Bearer ${process.env.GUMROAD_ACCESS_TOKEN}` }
});
const { sale } = await r.json();
if (isActive(sale)) grantRole(); else revokeRole();
```

Also put a long random secret in the ping URL, and compare it with `crypto.timingSafeEqual`.

## Adding and removing the role

With a bot that has **Manage Roles**, and whose own role sits above the roles it grants:

```js
const url = `https://discord.com/api/v10/guilds/${GUILD}/members/${userId}/roles/${roleId}`;
await fetch(url, { method: 'PUT', headers: { Authorization: `Bot ${BOT_TOKEN}` } });   // grant
await fetch(url, { method: 'DELETE', headers: { Authorization: `Bot ${BOT_TOKEN}` } }); // revoke
```

## Two more things people miss
- **Key sharing.** Store `sale_id → discord_id` and refuse to link the same sale to a second account.
- **Missed pings.** Hosts restart, and pings get dropped. Run a nightly job that re-checks every linked sale and revokes anything inactive.

## Free check, or the full thing
The refund-aware license check on its own is free and MIT licensed: [gumroad-license-check](https://github.com/NarwhalThePong/gumroad-license-check).

If you'd rather not wire up the rest yourself, the [Gumroad → Discord Access Kit](https://paudrudis.gumroad.com/l/gskxf/LAUNCH30) packages all of it: the ping endpoint, the linking form, one-key-per-account, the nightly reconcile and 12 tests, with zero dependencies.

---
[All guides](./)
