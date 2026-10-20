=== License Gate for Gumroad ===
Contributors: paudrudis
Tags: gumroad, license key, content restriction, members, paywall
Requires at least: 6.3
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Hide posts, pages, and downloads until the visitor enters a valid Gumroad license key. Refunded and charged-back licenses stay locked.

== Description ==

Sell on Gumroad and want buyers to get members-only content on your WordPress site? License Gate for Gumroad puts that content behind the license key Gumroad already sends every buyer.

* **Shortcode:** `[license_gate product_id="YOUR_PRODUCT_ID"]Members-only content[/license_gate]`
* **Block:** add the "License Gate" block and put any blocks inside it.
* **Refund-aware:** Gumroad's license API answers "success" even for refunded purchases. This plugin also checks the refunded, charged-back, disputed, and subscription ended/failed flags, so those keys stay locked.
* **Subscriptions:** a cancelled subscription keeps access until its paid period ends, or you can lock it right away.
* **Fast and polite:** answers from Gumroad are cached (60 minutes by default), and each visitor IP gets a limited number of attempts per 10 minutes.
* **Remembers the unlock:** logged-in users keep access through a user setting; guests get a signed cookie. The raw license key is never stored, only a salted hash.
* **Your words:** change every message and the button text in Settings > License Gate.
* **Optional use counting:** turn on "Count uses in Gumroad" to increase the license "uses" counter on each new check.
* Translation-ready. No tracking, no ads in your dashboard.

= How it works =

1. In Gumroad, open your product and turn on "Generate a unique license key per sale". Copy the product ID shown there.
2. In WordPress, paste the product ID in Settings > License Gate (or on each gate).
3. Wrap content in the shortcode or the block. Visitors see a short form, enter their key, and the content appears.

The plugin is not affiliated with or endorsed by Gumroad.

== External services ==

This plugin connects to the Gumroad License API (https://api.gumroad.com/v2/licenses/verify) to check whether a license key is valid. This is required for the plugin to work.

* **When:** only when a visitor submits the unlock form on a gated page. Nothing is sent on page views, on activation, or in the admin.
* **What is sent:** the Gumroad product ID of the gate, the license key the visitor typed, and whether to increase the license "uses" counter. The request comes from your web server, so Gumroad also sees your server's IP address. No visitor IP, email, or cookie is sent.
* **What comes back:** Gumroad's purchase record for that key (for example the purchase date, buyer email, and refund/subscription status). The plugin keeps only the result (valid or not) in a temporary cache and does not store the buyer email.

The service is provided by Gumroad, Inc.: [Terms of Service](https://gumroad.com/terms), [Privacy Policy](https://gumroad.com/privacy).

== Installation ==

1. Upload the `license-gate-for-gumroad` folder to `/wp-content/plugins/`, or install the ZIP from Plugins > Add New > Upload Plugin.
2. Activate the plugin.
3. Go to Settings > License Gate and enter your Gumroad product ID.
4. Add the shortcode or the "License Gate" block to any post or page.

== Frequently Asked Questions ==

= Where do I find the product ID? =

In Gumroad, edit your product and open the license key section (enable "Generate a unique license key per sale"). The product ID is shown there.

= Does it work with page caching? =

Gated pages send no-cache headers and set `DONOTCACHEPAGE`, which most caching plugins respect. If your host caches full pages at the server level, exclude gated pages from that cache.

= Is this secure enough for valuable files? =

The gate hides content in the page HTML until a valid key is entered, which stops casual sharing and refund abuse. For large paid downloads, link to files that are not publicly guessable.

= Can one key be shared? =

Turn on "Count uses in Gumroad" to see how often a key is checked in your Gumroad dashboard, and refund or disable keys that are shared widely.

= What happens after a refund? =

New checks fail right away. Visitors who already unlocked keep access until the cached answer and their unlock period expire (both are configurable).

== Screenshots ==

1. The unlock form shown to visitors.
2. The License Gate block in the editor.
3. Settings > License Gate.

== Changelog ==

= 1.0.0 =
* First release: shortcode, block, settings page, refund-aware checks, caching, and attempt limits.

== Upgrade Notice ==

= 1.0.0 =
First release.
