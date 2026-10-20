import assert from "node:assert/strict";
import { evaluate, verifyLicense } from "./index.mjs";
const ok = (p = {}) => ({ success: true, purchase: p });
assert.equal(evaluate(ok()).valid, true);
assert.equal(evaluate({ success: false, message: "That license does not exist for the provided product." }).valid, false);
for (const [p, r] of [[{ refunded: true }, "purchase refunded"], [{ chargebacked: true }, "purchase chargebacked"],
  [{ disputed: true }, "purchase disputed"], [{ subscription_ended_at: "2026-01-01" }, "subscription ended"],
  [{ subscription_failed_at: "2026-01-01" }, "subscription payment failed"]]) assert.equal(evaluate(ok(p)).reason, r);
assert.equal(evaluate(ok({ disputed: true, dispute_won: true })).valid, true);
let body; const res = await verifyLicense("prod", " KEY ", { fetchFn: async (u, o) => { body = o.body; return { json: async () => ok({ refunded: true }) }; } });
assert.equal(res.valid, false); assert.equal(body.get("license_key"), "KEY"); assert.equal(body.get("increment_uses_count"), "false");
console.log("node tests passed");
