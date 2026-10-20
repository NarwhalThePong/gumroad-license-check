import unittest
from gumroad_license_check import evaluate, verify_license

ok = lambda **p: {"success": True, "purchase": p}

class T(unittest.TestCase):
    def test_valid(self): self.assertTrue(evaluate(ok())["valid"])
    def test_invalid(self): self.assertFalse(evaluate({"success": False, "message": "x"})["valid"])
    def test_flags(self):
        for p, r in [({"refunded": True}, "purchase refunded"), ({"chargebacked": True}, "purchase chargebacked"),
                     ({"disputed": True}, "purchase disputed"), ({"subscription_ended_at": "d"}, "subscription ended"),
                     ({"subscription_failed_at": "d"}, "subscription payment failed")]:
            self.assertEqual(evaluate(ok(**p))["reason"], r)
    def test_dispute_won(self): self.assertTrue(evaluate(ok(disputed=True, dispute_won=True))["valid"])
    def test_request(self):
        sent = {}
        def post(d, t): sent.update(d); return ok(refunded=True)
        self.assertFalse(verify_license("prod", " KEY ", post=post)["valid"])
        self.assertEqual(sent["license_key"], "KEY"); self.assertEqual(sent["increment_uses_count"], "false")

if __name__ == "__main__": unittest.main()
