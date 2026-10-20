---
layout: page
title: "How to sell access to a private GitHub repo on Gumroad (invite on sale, remove on refund)"
description: "Automatically invite Gumroad buyers to a private GitHub repo and remove them on refunds, chargebacks and ended memberships, with read-only access and spoof-proof pings."
---

Selling source code as a private GitHub repo is a popular Gumroad setup: starter kits, boilerplates, paid libraries, course code. The hard part isn't the sale. It's the access: inviting every buyer by hand, and remembering to remove people who refund.

## The basic flow

1. Add a **custom field** to your Gumroad product asking for the buyer's GitHub username.
2. Set Gumroad's **Ping** URL (Settings → Advanced) to a small endpoint you host.
3. On each ping, invite the username as a collaborator:

```js
await fetch(`https://api.github.com/repos/${OWNER}/${REPO}/collaborators/${username}`, {
  method: "PUT",
  headers: {
    Authorization: `Bearer ${process.env.GITHUB_TOKEN}`,
    Accept: "application/vnd.github+json",
  },
  body: JSON.stringify({ permission: "pull" }),
});
```

## Four things that bite people

**1. Pings aren't signed.** Gumroad's ping is a plain form POST. If someone learns your endpoint URL, they can post a fake `sale_id` and get themselves invited. Treat the ping only as a signal: take the `sale_id`, re-fetch the real sale from `GET https://api.gumroad.com/v2/sales/:id` with your access token, and act on that record. Also require a long random secret in the URL and compare it in constant time.

**2. Personal repos can't be read-only.** On a repo owned by a personal account, every collaborator gets write access, whatever `permission` you send. For read-only buyers, move the repo into a free GitHub **organization**, where `pull` really means read-only (or add buyers to an org team).

**3. Refunds don't remove anyone.** Nothing happens on GitHub when a buyer refunds. Subscribe to Gumroad's refund, dispute and cancellation resources, and on each one re-check the sale. If it's refunded, charged back, or the membership ended, cancel any pending invitation and remove the collaborator:

```js
await fetch(`https://api.github.com/repos/${OWNER}/${REPO}/collaborators/${username}`, {
  method: "DELETE",
  headers: { Authorization: `Bearer ${process.env.GITHUB_TOKEN}` },
});
```

Before removing, check the person doesn't still own another product that grants the same repo, and never remove yourself or your team.

**4. Pings get lost.** Hosts restart and requests fail. Run a periodic reconcile that lists your sales, invites anyone missing, and removes anyone whose purchase is no longer active. Note that GitHub limits repo invitations to 50 per repo per day, and removing access doesn't delete a copy someone already cloned.

## Done-for-you version

The [Gumroad → GitHub Access Kit](https://paudrudis.gumroad.com/l/znsmji) packages all of this: invite on sale, removal on refund, chargeback and ended membership, Sales API verification, retry-safe handling, a backfill and reconcile command, and optional Discord or Slack alerts. It runs on Cloudflare Workers' free tier or any Node 18+ host, with zero dependencies and 19 tests.

If you gate an app with license keys instead, start with the free [refund-aware license check](refunded-gumroad-license-keys).

---
[All guides](./)
