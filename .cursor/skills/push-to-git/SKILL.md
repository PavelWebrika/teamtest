---
name: push-to-git
description: >-
  Stage all changes, commit with an agent-written message, and push to the
  current branch on origin. Use when the user says push to git, push to GitHub,
  commit and push, or similar requests to publish local changes.
---

# Push to Git

Run the full publish workflow: stage, commit, push.

Only use this skill when the user explicitly asks to push (or commit and push). Do not push unprompted.

## Autonomous execution (required)

When this skill is active, the user's request **is** their permission. Run the entire workflow yourself — do not delegate steps to the user.

**Do:**

- Execute every git command directly via the Shell tool
- Run inspect → stage → commit → push → verify in one continuous flow
- If Auto-review blocks a git command (especially `git push`), immediately retry the **same command** with `request_smart_mode_approval: true` and `smart_mode_block_reason` set to the exact block message — do not stop and ask the user to run it
- Report the final result after the push completes (or fails)

**Do not:**

- Ask the user to confirm before staging, committing, or pushing
- Ask the user to click Run, approve, or execute a command manually
- Pause between steps waiting for user input
- Suggest the user run git commands in their terminal instead of doing it yourself

The only acceptable stops are: no changes to commit, secrets detected in the diff, or a hard failure (hook error, auth error, non-fast-forward rejection) that cannot be resolved automatically.

## Safety rules

- NEVER update git config
- NEVER run destructive or irreversible git commands (`push --force`, `reset --hard`, etc.) unless the user explicitly requests them
- NEVER skip hooks (`--no-verify`, `--no-gpg-sign`, etc.) unless the user explicitly requests it
- NEVER force-push to `main` or `master`; warn the user if they request it
- Avoid `git commit --amend` unless the user explicitly requests amend AND all amend conditions from project rules are met
- Do not commit files that likely contain secrets (`.env`, credentials, tokens); warn the user instead
- Do not create an empty commit if there are no changes to commit

## Workflow

### Step 1: Inspect current state

Run these commands in parallel from the repository root:

```bash
git status
git diff
git diff --staged
git log -5 --oneline
git branch --show-current
```

Use the output to:

- Confirm there are changes worth committing
- Match the repo's existing commit message style
- Detect the current branch (use this for push, not a hardcoded branch name)

If there are no changes after staging inspection, stop and tell the user there is nothing to commit or push.

### Step 2: Stage all changes

```bash
git add .
```

Re-check with `git status` and `git diff --staged` before committing.

### Step 3: Write the commit message

Draft a concise message (1–2 sentences) that explains **why**, not just what changed.

Follow conventional commit style when it fits the repo:

```text
<type>(<scope>): <short summary>

Optional body with extra context when helpful.
```

Common types: `feat`, `fix`, `style`, `refactor`, `docs`, `chore`, `test`.

Examples:

```text
feat(product): add product gallery component with swiper thumbs

fix(header): prevent mobile menu from staying open after navigation

style(gallery): align thumbnail spacing with Figma spec
```

Rules:

- Summarize the nature of the change accurately (`add` vs `update` vs `fix`)
- Keep the subject line under ~72 characters when possible
- Do not commit unrelated changes under a misleading message; mention if the diff is mixed

Pass the message with a HEREDOC:

```bash
git commit -m "$(cat <<'EOF'
Your commit message here.

EOF
)"
```

On Windows PowerShell where HEREDOC may fail, use a quoted multi-line string or `-m "subject" -m "body"` instead.

If the commit fails due to a pre-commit hook, fix the issue and create a **new** commit. Do not amend a failed commit.

### Step 4: Push to origin

Push the **current branch** to origin. Run this yourself — never hand off to the user.

```bash
git push origin HEAD
```

Or, after reading the branch name from Step 1:

```bash
git push origin <current-branch>
```

Use whichever branch Cursor/git reports as checked out (`main`, `master`, a feature branch, etc.). Do not assume `main`.

If the branch has no upstream yet:

```bash
git push -u origin HEAD
```

If the push command is blocked by Auto-review, retry immediately with smart-mode approval (see **Autonomous execution**). Do not ask the user to approve or run the push manually.

### Step 5: Verify

```bash
git status
```

Confirm the working tree is clean and the branch is up to date with origin.

## Failure handling

| Situation | Action |
|-----------|--------|
| Nothing to commit | Stop; report no changes |
| Commit hook fails | Fix the issue; create a new commit |
| Push rejected (non-fast-forward) | Do not force-push; explain and ask how to proceed |
| Remote auth fails | Report the error; do not retry with credential changes |
| Secrets in diff | Stop; warn the user before committing |

## Report back

After a successful push, briefly tell the user:

- Branch pushed
- Commit message used
- Any files intentionally excluded or warnings
