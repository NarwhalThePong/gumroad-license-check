// gumroad-license-check (Node 18+, zero dependencies). MIT License.
export const API_URL = "https://api.gumroad.com/v2/licenses/verify";

// Gumroad returns success: true even for refunded or charged-back purchases.
// evaluate() also checks the purchase flags.
export function evaluate(resp) {
  if (!resp?.success) return { valid: false, reason: resp?.message ?? "invalid license" };
  const p = resp.purchase ?? {};
  if (p.refunded) return { valid: false, reason: "purchase refunded" };
  if (p.chargebacked) return { valid: false, reason: "purchase chargebacked" };
  if (p.disputed && !p.dispute_won) return { valid: false, reason: "purchase disputed" };
  if (p.subscription_ended_at) return { valid: false, reason: "subscription ended" };
  if (p.subscription_failed_at) return { valid: false, reason: "subscription payment failed" };
  return { valid: true, reason: "ok", purchase: p };
}

export async function verifyLicense(productId, licenseKey, { fetchFn = fetch } = {}) {
  const r = await fetchFn(API_URL, { method: "POST", body: new URLSearchParams({
    product_id: productId, license_key: String(licenseKey).trim(), increment_uses_count: "false" }) });
  return evaluate(await r.json()); // Gumroad answers with JSON even on 404
}
