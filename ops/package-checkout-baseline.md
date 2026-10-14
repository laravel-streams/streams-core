# Streams package checkout baseline — 2026-10-12

Refresh of every Streams package checkout under `~/Sites/_packages` and confirmation of canonical
identity per surface. OpenCode task 9 (Streams Core / *Package source and identity baseline*;
operating guide artifact #8 step 1; gap analysis §5.2 unblock).

- Machine-readable refresh: [`ops/repository-map.json`](repository-map.json) (schema 2).
  It supersedes the schema-1 map at
  `~/Sites/fundamental.operations.bak/operations/agents/assets/streams/repository-map.json`
  (that citation in the task source omits the leading `operations/` path segment).
- Refresh run 2026-10-12 18:33 UTC: `git fetch --all --prune` + `git pull --ff-only` per checkout.
  **No branches changed, no working-tree files touched**; local dirty state left exactly as found.
- Survey commands (read-only, per checkout): `git remote -v`, `status --short --branch`,
  `log -n 1 --format='%H | %ci | %an | %s'`, `describe --tags --always`,
  `rev-list --left-right --count @{u}...HEAD`, `worktree list`, `branch`, and
  `symbolic-ref refs/remotes/origin/HEAD`.

## Summary

| Surface | Canonical repository | Release line | Current commit | Commit date | Upstream | Release-prep worktrees | Local state |
| --- | --- | --- | --- | --- | --- | --- | --- |
| core | laravel-streams/streams-core | `2.0` (default; tagged line `1.10` @ v1.10.4) | `5fd458f43` | 2026-09-29 11:32:01 -0500 | 0/0 | `_rc/streams-core` `rc/prep` @ `929145636` | 1 dirty (`composer.json`) |
| api | laravel-streams/streams-api | `1.0` (default) | `22d23513` | 2026-07-22 13:40:41 -0500 | 0/0 | `_rc/streams-api` `rc/prep` @ `0d3ba86d` | 20 dirty (docs) |
| ui | laravel-streams/streams-ui | `1.0` (default) | `3a30c867` | 2026-09-10 13:52:36 -0500 | 0/0; pull refused | none | 19 dirty (docs) |
| sdk | laravel-streams/streams-sdk | `1.0` (default) | `198c74c` | 2026-09-29 11:32:06 -0500 | 0/0 | `_rc/streams-sdk` `sdk/rc` @ `2aff9eb` | clean |
| testing | laravel-streams/streams-testing | `1.0` | `ec5dd5f` | 2025-11-12 00:06:45 -0600 | 0/0 | none | 598 dirty (docs restructure) |
| api-client | laravel-streams/api-client | `master` @ tag `v3.0.0` (npm 3.x) | `1c4bfae` | 2026-01-07 17:11:09 -0600 | 0/0 | none | 9 dirty (docs) |

## Per-surface detail and evidence

### core — streams-core

- Checkout `/Users/ryanthompson/Sites/_packages/streams-core`, main worktree, branch `2.0`,
  tracking `origin/2.0` (remote default: `origin/HEAD -> origin/2.0`). Local branches `1.9`, `2.0`, `rc/prep`.
- Canonical repository: `https://github.com/laravel-streams/streams-core.git`.
- Release line: `2.0`; tagged maintenance line `1.10` (latest tag `v1.10.4`; `origin/1.10`
  advanced `6f5f0e256..32660af6c` in this fetch, 2026-10-12).
- Current ref `5fd458f43618f9e744f7c43646242491394508fc`, 2026-09-29 11:32:01 -0500,
  Ryan Thompson, "Add the streams.dev package reference." (`describe` `v1.7.14-2270-g5fd458f43`).
- Release-prep worktree: `/Users/ryanthompson/Sites/_rc/streams-core` `rc/prep` @
  `929145636` (2026-09-28 03:15:09 -0500, "Support the Laravel 11/12 Filesystem contract and Carbon 3").

```text
$ git -C <checkout> remote -v
origin  https://github.com/laravel-streams/streams-core.git (fetch)
origin  https://github.com/laravel-streams/streams-core.git (push)
$ git -C <checkout> status --short --branch
## 2.0...origin/2.0
 M composer.json
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
5fd458f43618f9e744f7c43646242491394508fc | 2026-09-29 11:32:01 -0500 | Ryan Thompson | Add the streams.dev package reference.
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0 (behind  ahead)
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/streams-core  5fd458f43 [2.0]
/Users/ryanthompson/Sites/_rc/streams-core        929145636 [rc/prep]
# refresh 18:33:52: fetch deleted origin/{develop,fixes,feature/webpack-mix-root-based-bundling};
#   6f5f0e256..32660af6c  1.10 -> origin/1.10 ; pull --ff-only: Already up to date.
```

### api — streams-api

- Checkout `/Users/ryanthompson/Sites/_packages/streams-api`, branch `1.0` tracking `origin/1.0`
  (remote default). Local branches `1.0`, `rc/prep`. No tags.
- Canonical repository: `https://github.com/laravel-streams/streams-api.git`.
- Current ref `22d2351345631480102aa1377e6a6a73d765c7a5`, 2026-07-22 13:40:41 -0500, Ryan Thompson,
  "Match with[]= eager-loading by relation name, not raw field handle".
- Release-prep worktree: `/Users/ryanthompson/Sites/_rc/streams-api` `rc/prep` @ `0d3ba86d`
  (2026-09-28 02:23:36 -0500, "Add homepage and support URLs and a PHP 8.2 constraint").
- Local state: 20 dirty files (docs edits) — untouched.

```text
$ git -C <checkout> remote -v
origin  https://github.com/laravel-streams/streams-api.git (fetch)
origin  https://github.com/laravel-streams/streams-api.git (push)
$ git -C <checkout> status --short --branch | head -5
## 1.0...origin/1.0
 M docs/configuration.md
 M docs/custom-endpoints.md
 M docs/custom-interfaces.md
 M docs/introduction.md
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
22d2351345631480102aa1377e6a6a73d765c7a5 | 2026-07-22 13:40:41 -0500 | Ryan Thompson | Match with[]= eager-loading by relation name, not raw field handle
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/streams-api  22d23513 [1.0]
/Users/ryanthompson/Sites/_rc/streams-api        0d3ba86d [rc/prep]
# refresh 18:33:53: fetch deleted origin/{develop,feature/webpack-mix-root-based-bundling,json-requests};
#   pull --ff-only: Already up to date.
```

### ui — streams-ui

- Checkout `/Users/ryanthompson/Sites/_packages/streams-ui`, branch `1.0` tracking `origin/1.0`
  (remote default). Local branch `1.0` only. No tags. No release-prep worktree.
- Canonical repository: `git@github.com:laravel-streams/streams-ui.git` (SSH remote form).
- Current ref `3a30c8676df7815804a31cf5388b8fee80cdb541`, 2026-09-10 13:52:36 -0500, Ryan Thompson,
  "Support HTML attribteus:" (subject as committed).
- **Flag:** `pull --ff-only` refused — `error: cannot pull with rebase: You have unstaged changes.`
  (`pull.rebase` configured; 19 dirty files). HEAD already equals `origin/1.0` (0/0), so nothing
  was missed; remote-tracking refs were refreshed, branch not advanced, dirty state untouched.

```text
$ git -C <checkout> remote -v
origin  git@github.com:laravel-streams/streams-ui.git (fetch)
origin  git@github.com:laravel-streams/streams-ui.git (push)
$ git -C <checkout> status --short --branch | head -5
## 1.0...origin/1.0
 M docs/installation.md
 M docs/introduction.md
?? docs/actions.md
?? docs/architecture.md
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
3a30c8676df7815804a31cf5388b8fee80cdb541 | 2026-09-10 13:52:36 -0500 | Ryan Thompson | Support HTML attribteus:
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/streams-ui  3a30c867 [1.0]
# refresh 18:33:54: fetch deleted origin/{feature/js-components,feature/theme,livewire};
#   pull --ff-only: error: cannot pull with rebase: You have unstaged changes.
```

### sdk — streams-sdk

- Checkout `/Users/ryanthompson/Sites/_packages/streams-sdk`, branch `1.0` tracking `origin/1.0`
  (remote default). Local branches `1.0`, `mcp/track-c`, `sdk/rc`, `wip/ryan-uncommitted`. No tags.
- Canonical repository: `https://github.com/laravel-streams/streams-sdk.git`.
- Current ref `198c74c32e52b7abe0d99e4f74ee13296eee4d63`, 2026-09-29 11:32:06 -0500, Ryan Thompson,
  "Add the streams.dev package reference.". Working tree clean.
- Release-prep worktree: `/Users/ryanthompson/Sites/_rc/streams-sdk` `sdk/rc` @ `2aff9eb`
  (2026-09-28 03:44:38 -0500, "Accept @ field imports and object allowed types in the stream schema").
- `streams-sdk-track-c` is a linked worktree of this repo (`mcp/track-c` @ `580881d`, 2026-09-28
  00:56:05 -0500, "Accept route constraints as a list, like core"; untracked `.dossier/`,
  `DOSSIER.md`) — a working track, not release prep, and not a duplicate clone.

```text
$ git -C <checkout> remote -v
origin  https://github.com/laravel-streams/streams-sdk.git (fetch)
origin  https://github.com/laravel-streams/streams-sdk.git (push)
$ git -C <checkout> status --short --branch
## 1.0...origin/1.0
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
198c74c32e52b7abe0d99e4f74ee13296eee4d63 | 2026-09-29 11:32:06 -0500 | Ryan Thompson | Add the streams.dev package reference.
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/streams-sdk          198c74c [1.0]
/Users/ryanthompson/Sites/_packages/streams-sdk-track-c  580881d [mcp/track-c]
/Users/ryanthompson/Sites/_rc/streams-sdk                2aff9eb [sdk/rc]
# refresh 18:33:55: fetch clean; pull --ff-only: Already up to date.
```

### testing — streams-testing

- Checkout `/Users/ryanthompson/Sites/_packages/streams-testing`, branch `1.0` tracking `origin/1.0`.
  Local branch `1.0` only. No tags. No release-prep worktree.
- Canonical repository: `https://github.com/laravel-streams/streams-testing.git`.
- Current ref `ec5dd5f41b814a2b15b5dc1aa8a9f5911281781c`, 2025-11-12 00:06:45 -0600,
  Ryan Thompson, "Docs".
- **Flag:** upstream deleted `origin/master` during the fetch, so `refs/remotes/origin/HEAD`
  now dangles (still points at the deleted ref). Recommend `git remote set-head origin -a`
  during the next hands-on pass (not run here — it mutates checkout config).
- **Flag:** 598 dirty entries (README, composer.json, docs restructure renames like
  `docs/04-configuration.md -> docs/configuration.md`) — untouched.

```text
$ git -C <checkout> remote -v
origin  https://github.com/laravel-streams/streams-testing.git (fetch)
origin  https://github.com/laravel-streams/streams-testing.git (push)
$ git -C <checkout> status --short --branch | head -5
## 1.0...origin/1.0
 M README.md
 M composer.json
RM docs/04-configuration.md -> docs/configuration.md
RM docs/01-installation.md -> docs/installation.md
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
ec5dd5f41b814a2b15b5dc1aa8a9f5911281781c | 2025-11-12 00:06:45 -0600 | Ryan Thompson | Docs
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/streams-testing  ec5dd5f [1.0]
# refresh 18:33:55: fetch deleted origin/master ("refs/remotes/origin/HEAD has become dangling");
#   pull --ff-only: Already up to date.
```

### api-client — api-client

- Checkout `/Users/ryanthompson/Sites/_packages/api-client`, branch `master` tracking `origin/master`
  (remote default). Local branches `develop`, `master`.
- Canonical repository: `git@github.com:laravel-streams/api-client.git` (SSH remote form).
- Release line: `master` at tag `v3.0.0` exactly (`describe` `v3.0.0`); npm package with GitHub
  Actions npm publishing. Tags: `v3.0.0`, `2.0.0`, `1.2.7`, `1.2.5`, `1.2.4`.
- Current ref `1c4bfaebf307a278a6cfdb752808f57d5a46b121`, 2026-01-07 17:11:09 -0600,
  Ryan Thompson, "Add GitHub Actions workflow for npm publishing".
- **Gap fixed:** this surface is missing from the prior schema-1 repository map; it is added here
  as the sixth package surface.

```text
$ git -C <checkout> remote -v
origin  git@github.com:laravel-streams/api-client.git (fetch)
origin  git@github.com:laravel-streams/api-client.git (push)
$ git -C <checkout> status --short --branch | head -5
## master...origin/master
 M docs/client.md
 M docs/criteria.md
 M docs/entries.md
 M docs/examples.md
$ git -C <checkout> log -n 1 --format='%H | %ci | %an | %s'
1c4bfaebf307a278a6cfdb752808f57d5a46b121 | 2026-01-07 17:11:09 -0600 | Ryan Thompson | Add GitHub Actions workflow for npm publishing
$ git -C <checkout> describe --tags --always   # v3.0.0
$ git -C <checkout> tag --sort=-creatordate | head -5   # v3.0.0 2.0.0 1.2.7 1.2.5 1.2.4
$ git -C <checkout> rev-list --left-right --count @{u}...HEAD   # 0 0
$ git -C <checkout> worktree list
/Users/ryanthompson/Sites/_packages/api-client  1c4bfae [master]
# refresh 18:33:56: fetch clean; pull --ff-only: Already up to date.
```

## Flagged: duplicates and stale checkouts (not canonical)

| Checkout | Repository | Branch / ref | Last commit | Verdict |
| --- | --- | --- | --- | --- |
| `~/Sites/streams.local` | laravel-streams/streams | `develop` @ `5c07059` | 2021-12-30 (Robin Radic) | **Stale duplicate** — the task's example; legacy clone of the monolith. Not canonical. |
| `~/Sites/_packages/streams` | laravel-streams/streams | `develop` @ `e3aef89` | 2025-01-09 | **Legacy monolith** — predates the package split; superseded by the six split surfaces. Not canonical for any surface. |
| `~/Sites/_packages/streams-cms` | laravel-streams/cms | `master` @ `4a37b5f` | 2023-03-10 | Prior-map role `cms`; idle, dirty build artifacts. Not one of the six surfaces — needs Ryan's classification. |
| `~/Sites/_packages/streams-sdk-track-c` | laravel-streams/streams-sdk | `mcp/track-c` @ `580881d` | 2026-09-28 | **Not a duplicate** — linked worktree of streams-sdk (working track). |
| `~/Sites/streams.dev` | laravel-streams/streams.dev | `develop` @ `6a9df60` | 2026-09-29 | Docs site (prior-map `streams-site`); active; distinct repo, not a package duplicate. |

## Notes and follow-ups

1. Remote URL forms differ across surfaces: `streams-ui` and `api-client` use SSH
   (`git@github.com:`), the rest HTTPS. Same canonical `laravel-streams` GitHub namespace either
   way — worth normalizing eventually, cosmetic only.
2. Release-prep lines live in worktrees under `~/Sites/_rc`: `rc/prep` (core, api) and `sdk/rc`
   (sdk), all last touched 2026-09-28 by Ryan Thompson.
3. No branches were changed during this refresh; only remote-tracking refs moved
   (`git fetch --all --prune`) and fast-forward-only pulls were attempted. `streams-ui`'s pull
   refusal and `streams-testing`'s dangling `origin/HEAD` are recorded above as follow-ups for
   the next hands-on pass, not silently "fixed" here.
