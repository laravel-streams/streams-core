# Streams consumer gap analysis — GroupVitals pass 1 (DRAFT)

**Draft date:** October 12, 2026 (CT) · **Task:** Streams consumer gap analysis — Operations task 10, first pass (Streams Core / branch 2.0).
**Status:** DRAFT for Ryan's snap-brief review (§5.3). Nothing in this document has left draft. No compatibility, release, RC, or support claim is made anywhere below.
**Scope:** GroupVitals GV2 pins against `streams/core`, `streams/ui`, `streams/api` only. PinClicks and Operations-registered consumers are a later pass (their pin evidence already sits in the matrix fill, task 11). GV2 sibling surfaces beyond the GV2 repo are a later pass.

## 1. Method and evidence sources (read-only)

- **GV2 repo:** `GroupVitals/app.groupvitals.com` (`gv-app`), checkout `/Users/ryanthompson/Sites/_gv/app`, branch `master` == `origin/master` (in sync), HEAD `e6d0b3d3c9347d06fff2a38650e33dd4cce130da` (2026-09-10 16:05:21 -0500, "Ship wave-1 insights metrics, did-not-meet attendance, and related product polish.").
- `composer.json` and `composer.lock` are both git-tracked in gv-app (lock not ignored). Both were last committed together at `e6d0b3d3` (2026-09-10); the prior composer change was `750774df` (2026-09-02 22:36:53 -0500, "Updates").
- **Streams package state:** `ops/package-checkout-baseline.md` + `ops/repository-map.json` (task 9 refresh, 2026-10-12 18:33 UTC): core `2.0` @ `5fd458f43`, ui `1.0` @ `3a30c867`, api `1.0` @ `22d23513`, tag inventories and release-prep worktrees.
- **Legacy packets:** `streams-packet-streams-consumer-gap-analysis.json` (rev 3) and `streams-packet-ops-repo-consumer-inventory-including-groupvitals.json` (rev 3), `fundamental.operations.bak/operations/records/` — guardrails: requires ≠ support; no "compatible"/release claim without matrix evidence; no invented pins/gates/recovery.
- **Matrix:** `ops/streams-consumer-compatibility-matrix.md` (task 11 fill of artifact #66, commit `d54f6c663`). This document does not start a second matrix; it supplies the per-package gap list the matrix's ops-registered row and Packet 1 both call for.
- **GV surface map:** legacy `fundamental.operations.bak/operations/agents/assets/groupvitals/repository-map.json` (owner-confirmed 2026-09-22).
- Survey commands: read-only git (`show`, `log`, `ls-files`, `check-ignore`, `tag -l`, `branch -a`, `rev-parse`) plus `composer.json`/`composer.lock` reads. Nothing was modified in any Streams package or any consumer checkout.

## 2. Rule applied throughout (observation, not support)

A Composer require is a dependency observation — never a support contract, never a "compatible = yes", never a release claim (matrix filling rule 3; artifact 12 rule; Packet 1 guardrails). Every require and lock pin below is recorded as an observation only.

## 3. GroupVitals GV2 composer requires — enumeration

From the GV2 repo (`gv-app`) `composer.json` `require` block (committed @ `e6d0b3d3`, 2026-09-10), with `composer.lock` resolution:

| Package | `composer.json` require | Lock version | Locked ref | Locked-ref commit evidence |
| --- | --- | --- | --- | --- |
| `streams/core` | `^2.0` | `2.0.x-dev` | `8fd4c718877aa59dcee01b78a17e7779234c8339` | "Adapters", 2026-08-26 14:36:12 -0500 (Ryan Thompson) |
| `streams/api` | `1.0.x-dev` | `1.0.x-dev` | `22d2351345631480102aa1377e6a6a73d765c7a5` | "Match with[]= eager-loading by relation name, not raw field handle", 2026-07-22 13:40:41 -0500 |
| `streams/ui` | `^1.0` | `1.0.x-dev` | `3a30c8676df7815804a31cf5388b8fee80cdb541` | "Support HTML attribteus:", 2026-09-10 13:52:36 -0500 |

All three in-scope packages sit in `require` (runtime), not `require-dev`. Context in the same block: `php ^8.0.2`, `laravel/framework ^10.0`, `laravel/cashier ^15.3`, `laravel/sanctum ^3.3`.

Adjacent observations (out of this pass's three packages): `require-dev` carries `streams/sdk ^1.0` (lock `1.0.x-dev` @ `192dc07…`, older than the sdk line tip `198c74c`, 2026-09-29) and `streams/testing 1.0.x-dev` (lock `1.0.x-dev` @ `ec5dd5f…`, equal to the testing line tip). Identity observation: gv-app's project `name` is `streams/streams` (composer.json line 2, "Streams is an open-source web application platform for Laravel.") — the GV2 app declares the Streams project name; starter lineage unverified; flagged for Ryan, no claim made.

## 4. Gaps per package — GV2 pins vs current package state

### 4.1 `streams/core` — GV2 pins `^2.0`, locks `2.0.x-dev` @ `8fd4c7188` (2026-08-26)

- **G-C1 — No stable 2.x release to pin.** Every tag in streams-core is 1.x (`git tag -l` sorted: latest `v1.10.0`–`v1.10.4`; task-9 baseline recent tags `v1.10.4`…`v1.7.52`); no 2.x tag exists. `^2.0` can only resolve to the `2.0` branch as `2.0.x-dev` — the lock's version field is literally a dev ref (zip dist of a branch snapshot). The owner requirement for this package is "stable, compatible, semantically versioned, and lockable before mission-critical GV2 release" (GV repository-map, `shared_release_dependencies`) — unmet by a branch dev ref. *Evidence:* gv-app `composer.lock` packages[] `streams/core`; streams-core `git tag -l` (this pass + task-9 baseline); GV repository-map.json.
- **G-C2 — Lock drift behind a moving line.** Locked ref `8fd4c7188` (2026-08-26) is exactly one commit behind the `2.0` line tip `5fd458f43` ("Add the streams.dev package reference.", 2026-09-29): `git rev-parse 5fd458f43^` → `8fd4c7188`. A branch lock has no tag holding it; any `composer update` moves it again. *Evidence:* streams-core git rev-parse/log (this pass); task-9 baseline core surface (`5fd458f43`, upstream 0/0).
- **G-C3 — Laravel line direction (risk, not a claim).** gv-app declares `laravel/framework ^10.0` (GV map: resolves 10.50.3; Laravel 10 called unsupported there) and `php ^8.0.2`; streams-core `2.0` requires `laravel/framework ^10|^11|^12` (core composer.json require block). Within range today, but core's release-prep track targets Laravel 11/12 (G-C4 below), so the direction core is preparing can move past GV2's Laravel 10 floor. *Evidence:* gv-app composer.json; streams-core composer.json; task-9 baseline rc/prep entry.
- **RC-candidate isolation (no release claimed):** core has a dedicated release-prep worktree, `rc/prep` @ `929145636` (2026-09-28 03:15:09 -0500, "Support the Laravel 11/12 Filesystem contract and Carbon 3"), distinct from the `2.0` line the GV2 lock sits on. *Evidence:* task-9 baseline / repository-map core worktrees.

### 4.2 `streams/ui` — GV2 pins `^1.0`, locks `1.0.x-dev` @ `3a30c867` (2026-09-10)

- **G-U1 — No tagged ui release at all.** streams-ui has zero tags (`git tag -l` → empty; task-9 baseline "no tags"). `^1.0` resolves to the `1.0` branch as `1.0.x-dev` — same "no stable, lockable release" gap as core, and unlike core there is not even a maintenance-tag line (core's 1.10) to fall back to. *Evidence:* streams-ui `git tag -l` (this pass); gv-app composer.lock `streams/ui`.
- **G-U2 — Lock equals the line tip by coincidence, not by pin.** Locked ref `3a30c867…` is byte-identical to the current ui `1.0` line tip `3a30c867` (2026-09-10 13:52:36 -0500, "Support HTML attribteus:"). Nothing holds it there; the next push to `origin/1.0` silently outdates the lock. *Evidence:* gv-app composer.lock; task-9 baseline ui surface `current_ref`.
- **G-U3 — No release-prep track exists for ui.** core, api and sdk each have an rc worktree (task-9 baseline); ui has none — ui is the only one of the three GV2-required packages with no observed release-candidate track. *Evidence:* task-9 baseline ui worktrees (main checkout only).
- **Evidence caveat (checkout state, not a GV2 gap):** the ui checkout itself carries 19 dirty docs files and its `git pull --ff-only` was refused (`pull.rebase` + unstaged changes; task-9 flag) — observed HEAD may not equal the working tree there. Nothing was changed in that checkout this pass.

### 4.3 `streams/api` — GV2 pins `1.0.x-dev`, locks `1.0.x-dev` @ `22d23513` (2026-07-22)

- **G-A1 — The require is itself a dev ref.** Unlike core/ui (caret ranges), gv-app pins api with the explicit branch constraint `1.0.x-dev` — the consumer has already given up on a stable api release existing. streams-api has zero tags (`git tag -l` → empty; task-9 baseline "none in repository"). *Evidence:* gv-app composer.json line 22; streams-api `git tag -l`.
- **G-A2 — Lock equals the line tip while the prep line runs ahead, unpinned.** Locked ref `22d23513…` equals the api `1.0` line tip exactly (2026-07-22 13:40:41 -0500, "Match with[]= eager-loading by relation name, not raw field handle"), while api's release-prep line `rc/prep` @ `0d3ba86d` ("Add homepage and support URLs and a PHP 8.2 constraint", 2026-09-28 02:23:36 -0500) is ahead of the consumer's line and unreleased. The owner requirement makes api release-critical "because the REST surface depends on it" (GV repository-map `shared_release_dependencies`); the public-integrator contract and the Groups PWA ride the same boundary. No release claim is made. *Evidence:* gv-app composer.lock; task-9 baseline api worktrees; GV repository-map.json.

## 5. Adjacent observations (recorded, out of this pass)

- **GV2 sibling surfaces** (GV repository-map: marketing `groupvitals.com`, help, docs, support backend) also require Streams — later pass. Task 11's matrix row already records the marketing surface's pins (`groupvitals.com/composer.lock`: core `2.0.x-dev`, api `1.0.x-dev`, ui `1.0.x-dev`, sdk `1.0.x-dev`; checkout ref `1575cfa3`, 2026-07-30, branch `feature/branding-refresh`) — noting the GV map flags GV2 marketing's `composer.lock` as ignored/untracked (deployed dependency state not reproducible), whereas gv-app's lock is tracked.
- **PinClicks and Operations-registered consumers:** later pass; pin evidence for both already sits in the matrix fill (task 11). The Fundamental Operations repo itself requires `streams/core 2.0.x-dev` (ops composer.json; matrix ops-registered row).
- **Local core workspace state:** the local `2.0` checkout carries unpushed commits beyond `5fd458f43` (task 9/11 ops docs, and `59f406bb` "Allow symfony/yaml ^6.2 or ^7.0") — workspace bookkeeping and an unpushed constraint change, not shipped package releases; the consumer-relevant line tip per the task-9 baseline (upstream 0/0) is `5fd458f43`.

## 6. Release-candidate isolation (no release claimed)

Observed RC-candidate tracks, all 2026-09-28, none claimed as releases: core `rc/prep` @ `929145636` ("Support the Laravel 11/12 Filesystem contract and Carbon 3"); api `rc/prep` @ `0d3ba86d` ("Add homepage and support URLs and a PHP 8.2 constraint"); sdk `sdk/rc` @ `2aff9eb`. ui: no RC track observed. Every GV2 lock sits on the consumer lines (`core 2.0`, `ui 1.0`, `api 1.0`), not on any rc/prep line. The Streams RC decision is not made here (per the matrix, that decision is task 67's).

## 7. Snap brief for Ryan (draft — nothing leaves draft without your go)

1. GV2 (gv-app, the dashboard/API app) requires core `^2.0` / ui `^1.0` / api `1.0.x-dev`; its tracked lock resolves all three to **branch dev refs** — core `8fd4c7188` (one commit behind the 2.0 tip), ui `3a30c867` (== tip), api `22d23513` (== tip).
2. None of the three packages has a release the constraints could pin to: core's newest tags are all 1.x (`v1.10.4` latest); ui and api have **no tags at all**. Every GV2 Streams pin is a development ref.
3. api is the sharpest gap: the require itself is a dev branch pin, and GV2's release-critical REST surface rides it.
4. Release-prep tracks exist for core and api (`rc/prep`, 2026-09-28); ui has none.
5. Requires are observations, not support; no compatibility or release claim is made anywhere above.
6. **Asks:** (a) confirm gv-app is the right GV2 repo for this pass — task 11's matrix row used the marketing surface `groupvitals.com` for the GroupVitals pins; (b) does ui need an RC track, or does it stay on the dev line until core 2.0 stabilizes; (c) is the Laravel 10 floor vs core's Laravel 11/12 prep direction (G-C3) a compatibility gap to name, or an accepted risk?
