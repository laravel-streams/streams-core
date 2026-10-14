# Streams consumer compatibility matrix

**Stub date:** September 24, 2026 (CT) · **Filled:** October 12, 2026 (Operations task 11 — extension of artifact #66, the 2026-09-24 matrix stub; no second matrix started)  
**Source:** Interview 2 of 5 — Consumer/version compatibility and release evidence  
**Conduct:** `conduct-streams-consumerversion-compatibility-and-release-evidence-interview`  
**Rule (§4.1):** No “compatible” or Streams release claim without this named matrix filled with verified evidence. Composer require ≠ support contract.  
**Status:** **Filled 2026-10-12** — rows carry cited evidence only; blank cells remain blank rather than guessed. **This fill is not a compatibility or release claim.** Release/compatibility language stays gated on §4.1 and the §4.3 GroupVitals hard gate; the Streams RC decision is task 67 and is not made here.

**In-scope consumers (Interview 2):** GroupVitals, PinClicks, ops-registered consumers.  
**Out of scope:** fundamental.company, Fundamental Syndicate, ryanthompson.com-ish, small marketing sites.

---

## Matrix

| Consumer | Streams version | Verified (yes/no) | Evidence | Notes |
| --- | --- | --- | --- | --- |
| GroupVitals | `composer.lock` pins, inspected 2026-10-12: `streams/core` `2.0.x-dev`, `streams/api` `1.0.x-dev`, `streams/ui` `1.0.x-dev`, `streams/sdk` `1.0.x-dev` (require-dev). `composer.json` requires: core `^2.0`, api `^1.0`, ui `*`, sdk `^1.0` (require-dev) — dependency observation only. | yes | 1. **Pin file:** `groupvitals.com/composer.lock` → streams/core 2.0.x-dev, streams/api 1.0.x-dev, streams/ui 1.0.x-dev, streams/sdk 1.0.x-dev. Checkout `/Users/ryanthompson/Sites/_gv/groupvitals.com`, ref `1575cfa3` (2026-07-30, branch `feature/branding-refresh`); inspected 2026-10-12. 2. **Repo tests:** `tests/` (Feature/Unit) + `phpunit.xml` present in the same checkout (inspected 2026-10-12); tests-run is owner FACT §3.1 (interview 2026-09-24) — not run in this pass. 3. **Owner-named gate:** §4.3 DECISION — Streams must reach RC before a GroupVitals release (hard gate, locked 2026-09-24). 4. **CI:** none observed — no CI workflow config found in the checkout (inspected 2026-10-12). | Hard gate: Streams RC before GV release (§4.3) — **unsatisfied**; Streams RC not established (RC decision = task 67, not made here). Tests run (FACT §3.1). Pins were OPEN at the interview (§3.1) and are now observed in `composer.lock` (2026-10-12). Recovery evidence remains OPEN (Interview 3 carries recovery). No compatibility or release claim is made by this row. |
| PinClicks | `composer.lock` pins, inspected 2026-10-12: `streams/core` `2.0.x-dev`, `streams/ui` `1.0.x-dev` in both checkouts; `streams/sdk` `1.0.x-dev` (require-dev) in admin. `composer.json` requires: core `^2.0`, ui `^1.0` (+ sdk `^1.0` require-dev in admin) — dependency observation only. | yes | 1. **Pin files:** `pinclicks.com/composer.lock` (checkout `/Users/ryanthompson/Sites/pinclicks.com`, ref `cbb33754`, 2026-10-07, branch `develop`) and `pinclicks.admin/composer.lock` (checkout `/Users/ryanthompson/Sites/pinclicks.admin`, ref `6da742d`, 2026-09-28, branch `develop`) → streams/core 2.0.x-dev, streams/ui 1.0.x-dev (+ sdk 1.0.x-dev require-dev in admin); inspected 2026-10-12. 2. **Repo tests:** `tests/` (Feature/Unit) + `phpunit.xml` present in both checkouts (inspected 2026-10-12); tests-run is owner FACT §3.1 (“each in-scope project runs tests”; PinClicks is in scope per §2.3) — not run in this pass. 3. **CI:** none observed — no CI workflow config found in either checkout (inspected 2026-10-12). | In-scope consumer (§2.3). No owner-named release gate and no CI evidence for PinClicks. Composer requires are dependency observations, not support contracts (§4.1 / artifact 12). No compatibility or release claim is made by this row. |
| Ops-registered consumers (aggregate / list TBD) | Operations app itself (the ops repo’s own project): `streams/core` `2.0.x-dev` — `composer.json` require + `composer.lock` pin, inspected 2026-10-12. Other registered consumers: TBD. | | **Pin file (partial):** `fundamental.operations/composer.lock` → streams/core 2.0.x-dev (checkout `/Users/ryanthompson/Sites/fundamental.operations`, ref `baca373a`, 2026-10-12, branch `main`; inspected 2026-10-12). **Enumeration:** ops registration lives in the Operations projects registry (Streams `projects` source, DB-backed) plus per-project composer requires — that enumeration is Packet 1 gap analysis (task 10), whose gap-list artifact does not exist in the Operations artifact registry as of 2026-10-12 (inspected: no gap-analysis artifact among #5, #8, #61–#67). | List TBD pending Packet 1 gap analysis (task 10; not delivered as of 2026-10-12). Verified left blank rather than guessed. The Operations app’s `streams/core` 2.0.x-dev require/pin is a dependency observation, not a support contract (§4.1 / artifact 12). |

---

## Filling rules (do not weaken)

1. **Verified = yes** only with cited evidence (repo tests, pin files, CI, owner-named gate). Tests-run alone does not fill Streams version or release-claim cells.  
2. Leave cells blank rather than guess.  
3. Observed `composer require` may appear in Notes as dependency observation — **never** as support contract or “compatible = yes”.  
4. Update after Packet 1 gap analysis; Ryan reviews via GV-style snap brief (§5.3).

---

## Fill provenance (2026-10-12, Operations task 11)

- **Single matrix:** this file extends artifact #66 (the 2026-09-24 matrix stub, `streams-consumer-compatibility-matrix-stub-2026-09-24.md`, legacy `fundamental.operations.bak/operations/artifacts/`; registered in the Operations artifact registry as #66). No second matrix was started; the stub’s table, rules and related packets are preserved, rows filled only.
- **Artifact 12 rules applied:** (1) a Composer require isn’t support — every `composer.json` require above is recorded as a dependency observation only; (2) no compatibility claim without a filled cell — no “compatible” or release claim is made anywhere in this fill; release/RC language stays with §4.1, §4.3 and task 67.
- **Verified = yes basis:** GroupVitals and PinClicks rows cite pin files (`composer.lock`, inspected 2026-10-12), repo test suites (present; tests-run per owner FACT §3.1, not run in this pass) and, for GroupVitals, the owner-named §4.3 gate. The ops-registered aggregate row stays unverified (blank) because the enumeration (task 10 gap list) does not exist.
- **Evidence inspection:** read-only inspection of `composer.json`/`composer.lock`, `tests/`/`phpunit.xml`, git refs and the Operations artifact registry. No code, composer or config change was made in the Streams packages or in any consumer repo (GroupVitals, PinClicks, Operations).
- **Task 10:** gap list does not exist (not delivered); the aggregate row was not guessed to compensate.
- **Recovery:** remains OPEN (Interview 3 carries recovery); not evidenced here.

## Related packets

1. `streams-packet-streams-consumer-gap-analysis` — fill evidence / RC candidates.  
2. `streams-packet-mark-streams-active-in-records` — status align (not matrix fill).  
3. `streams-packet-shared-agent-assert-rules` — what agents may assert from this matrix.
