# JAPR Manuscript Review Workflow Analysis

## Current Workflow Status Progression:

1. **pending** → Author submits manuscript
2. **under_peer_review** → Associate Editors assigned and reviewing
3. **ready_for_managing_editor_notice** → Reviews completed, ready for Managing Editor decision
4. **approved_for_copy_editing** → Managing Editor sends approval notice
5. **declined** → Managing Editor sends decline notice

## Current Issues Identified:

### 1. Missing Final Approval Step
Currently, "Send Approval Notice" moves the manuscript to "Approved for Copy Editing" but there's no final "Approved" or "Published" status.

### 2. Workflow Suggestions:

**Option A: Add Final Approval Steps**
- After copy editing: `copy_editing_complete` → `ready_for_final_approval` → `approved` (published)

**Option B: Rename Current Steps for Clarity**
- `approved_for_copy_editing` could be renamed to `conditionally_approved` 
- Add final step: `approved` (fully approved and published)

**Option C: Simplify to Direct Approval**
- Change "Send Approval Notice" to directly set status to `approved` 
- Remove copy editing step or make it internal

## Recommended Immediate Fix:

Change the "Send Approval Notice" action to give Managing Editor two clear options:
1. **Approve for Publication** (status: `approved`)
2. **Approve with Copy Editing Required** (status: `approved_for_copy_editing`)
3. **Decline** (status: `declined`)

This would make the workflow clearer and give the Managing Editor more control over the final decision.
