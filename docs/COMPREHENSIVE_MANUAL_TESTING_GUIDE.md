# COMPREHENSIVE MANUAL TESTING GUIDE
## Journal Management System Workflow Validation

### 🎯 **TESTING OVERVIEW**
This guide provides step-by-step manual testing procedures to validate all workflows in the journal management system after automated tests have passed with 95.5% success rate.

**Site URL:** http://journal.test
**Test Environment:** Laravel Herd Local Development

---

## 📋 **TEST USER ACCOUNTS**

| Role | Email | Password | Purpose |
|------|-------|----------|---------|
| Admin | admin@example.com | password | System administration |
| Editor in Chief | editor@example.com | password | Overall editorial control |
| Managing Editor | managing@example.com | password | Editorial management |
| Associate Editor | associate@example.com | password | Manuscript review |
| Associate Editor | afe@example.com | password | Manuscript review |
| Associate Editor | nani@example.com | password | Manuscript review |
| Author | author@example.com | password | Manuscript submission |
| Desk Editor | desk@example.com | password | Editorial assistance |

---

## 🔒 **PHASE 1: AUTHENTICATION & ROLE VERIFICATION**

### Test 1.1: Login Authentication
1. Navigate to http://journal.test/login
2. Test each user account:
   - ✅ Verify login success
   - ✅ Check role-based dashboard redirection
   - ✅ Confirm proper navigation menu visibility
   - ✅ Test logout functionality

### Test 1.2: Role-Based Access Control
1. **Admin Access:**
   - ✅ Can access all system areas
   - ✅ User management capabilities
   - ✅ System configuration access

2. **Editor in Chief Access:**
   - ✅ Full editorial dashboard
   - ✅ All manuscript oversight
   - ✅ Reviewer management
   - ✅ Final approval authority

3. **Author Access:**
   - ✅ Author dashboard only
   - ✅ Cannot access editor functions
   - ✅ Manuscript submission forms

---

## 📝 **PHASE 2: AUTHOR DASHBOARD & MANUSCRIPT SUBMISSION**

### Test 2.1: Author Dashboard Navigation
**Login as:** author@example.com

1. **Dashboard Overview:**
   - ✅ View manuscript statistics
   - ✅ Check draft vs submitted counts
   - ✅ Review status breakdown display
   - ✅ Recent activity feed

2. **Navigation Menu:**
   - ✅ "New Submission" button accessible
   - ✅ "My Manuscripts" list view
   - ✅ "Drafts" section
   - ✅ "Review Sessions" if any exist

### Test 2.2: Manuscript Creation Workflow
1. **Start New Submission:**
   - ✅ Click "New Manuscript" or "Submit Article"
   - ✅ Verify form loads with all required fields
   - ✅ Check category dropdown populated (81 categories)

2. **Form Field Validation:**
   - ✅ Title field (required)
   - ✅ Abstract field (required)
   - ✅ Description/Content field
   - ✅ Author information pre-filled
   - ✅ Institution field
   - ✅ Category selection
   - ✅ Keywords field
   - ✅ File upload functionality
   - ✅ License agreement checkbox

3. **Draft Functionality:**
   - ✅ Save as draft without submission
   - ✅ Edit existing draft multiple times
   - ✅ Verify draft appears in "Drafts" section
   - ✅ Draft status indicators

4. **Submission Process:**
   - ✅ Convert draft to submission
   - ✅ Verify status change from draft to "pending"
   - ✅ Confirm submission appears in "My Manuscripts"
   - ✅ Check submission timestamp

### Test 2.3: Manuscript Version Management
1. **Version History:**
   - ✅ Initial submission version (v1.0)
   - ✅ Track changes when corrections requested
   - ✅ Version numbering (v1.1, v1.2, etc.)
   - ✅ Compare versions functionality

2. **Correction Submission:**
   - ✅ Receive change request notification
   - ✅ View specific change requirements
   - ✅ Submit corrected version
   - ✅ Verify version increment
   - ✅ Change request status update

---

## 👥 **PHASE 3: EDITOR REVIEWER MANAGEMENT**

### Test 3.1: Editor Dashboard Access
**Login as:** editor@example.com

1. **Editorial Dashboard:**
   - ✅ Pending manuscripts list
   - ✅ Manuscripts needing reviewer assignment
   - ✅ Review progress tracking
   - ✅ Decision-making interface

2. **Manuscript Management:**
   - ✅ View manuscript details
   - ✅ Access manuscript files
   - ✅ Review submission history
   - ✅ Check author information

### Test 3.2: Reviewer Assignment Process
1. **Reviewer Pool Management:**
   - ✅ View available Associate Editors (3 total)
   - ✅ Check reviewer workload
   - ✅ Reviewer expertise matching

2. **Assignment Rules Validation:**
   - ✅ **MINIMUM 2 reviewers required**
   - ✅ **MAXIMUM 4 reviewers allowed**
   - ✅ Cannot assign less than 2
   - ✅ System prevents more than 4
   - ✅ Warning messages for rule violations

3. **Reviewer Invitation Process:**
   - ✅ Select 2-4 Associate Editors
   - ✅ Send reviewer invitations
   - ✅ Generate unique invitation tokens
   - ✅ Email notifications sent
   - ✅ Track invitation status

### Test 3.3: Review Status Management
1. **Status Transitions:**
   - ✅ `pending` → `in-review` (when reviewers assigned)
   - ✅ `in-review` → `reviewed` (when all reviews complete)
   - ✅ `reviewed` → `approved`/`declined` (editor decision)

2. **Review Progress Tracking:**
   - ✅ Individual reviewer status
   - ✅ Review completion percentage
   - ✅ Time tracking for each phase
   - ✅ Overdue review alerts

### Test 3.4: Editorial Decision Making
1. **After All Reviews Complete:**
   - ✅ Access review summaries
   - ✅ View reviewer recommendations
   - ✅ Make final decision interface
   - ✅ **Approve** or **Decline** options enabled

2. **Change Request Process:**
   - ✅ Request specific corrections
   - ✅ Specify fields needing changes
   - ✅ Provide suggested improvements
   - ✅ Set correction deadlines

---

## 🔔 **PHASE 4: NOTIFICATION SYSTEM TESTING**

### Test 4.1: In-App Notifications
**Test with all user roles:**

1. **Notification Bell/Icon:**
   - ✅ Unread notification count
   - ✅ Dropdown notification list
   - ✅ Mark as read functionality
   - ✅ Notification categories

2. **Author Notifications:**
   - ✅ Manuscript submission confirmation
   - ✅ Review status updates
   - ✅ Change requests received
   - ✅ Final decision notifications

3. **Editor Notifications:**
   - ✅ New manuscript submissions
   - ✅ Reviewer responses
   - ✅ Review completions
   - ✅ Author corrections submitted

4. **Reviewer Notifications:**
   - ✅ Review invitations
   - ✅ Review reminders
   - ✅ Manuscript corrections

### Test 4.2: Email Notifications
**Check email delivery for all stakeholders:**

1. **Author Email Notifications:**
   - ✅ Submission confirmation
   - ✅ Reviewer assignment notice
   - ✅ Review status changes
   - ✅ Change request details
   - ✅ Final decision notification

2. **Editor Email Notifications:**
   - ✅ New submissions alert
   - ✅ Reviewer acceptance/decline
   - ✅ Review completion alerts
   - ✅ Author correction submissions

3. **Reviewer Email Notifications:**
   - ✅ Review invitation with access link
   - ✅ Review deadline reminders
   - ✅ Manuscript update notifications

4. **Editor in Chief Oversight:**
   - ✅ **ALL critical actions notify Editor in Chief**
   - ✅ Weekly summary reports
   - ✅ System activity overview
   - ✅ Editorial decision summaries

---

## 🔄 **PHASE 5: COMPLETE WORKFLOW INTEGRATION**

### Test 5.1: End-to-End Manuscript Journey
**Follow one manuscript through complete process:**

1. **Author Submission:** (author@example.com)
   - ✅ Create and submit new manuscript
   - ✅ Verify submission confirmation

2. **Editor Review:** (editor@example.com)
   - ✅ Receive new submission notification
   - ✅ Assign 2-3 reviewers from Associate Editors
   - ✅ Verify status change to "in-review"

3. **Reviewer Process:** (associate@example.com, afe@example.com)
   - ✅ Accept review invitations
   - ✅ Complete manuscript reviews
   - ✅ Submit review feedback

4. **Editorial Decision:** (editor@example.com)
   - ✅ Review all feedback
   - ✅ Make decision (approve/decline/request changes)
   - ✅ Send decision to author

5. **Author Response:** (author@example.com)
   - ✅ Receive decision notification
   - ✅ If changes requested: submit corrections
   - ✅ Version tracking validation

### Test 5.2: Git-like Version Control
1. **Version Management:**
   - ✅ Original submission = v1.0
   - ✅ First correction = v1.1
   - ✅ Second correction = v1.2
   - ✅ Version comparison tools

2. **Change Tracking:**
   - ✅ Field-level change detection
   - ✅ Before/after comparison
   - ✅ Change approval workflow
   - ✅ Rollback capabilities (if needed)

---

## 🏷️ **PHASE 6: CATEGORIES & CONTENT MANAGEMENT**

### Test 6.1: Category Management
**Login as:** admin@example.com

1. **Category Hierarchy:**
   - ✅ View 81 main categories
   - ✅ Subcategory management
   - ✅ Sub-subcategory levels
   - ✅ Category CRUD operations

2. **Category Assignment:**
   - ✅ Assign categories to manuscripts
   - ✅ Multiple category selection
   - ✅ Category-based filtering
   - ✅ Category statistics

### Test 6.2: Regional Management
1. **Geographic Data:**
   - ✅ Countries list (currently empty - needs population)
   - ✅ Region management
   - ✅ Author location tracking
   - ✅ Regional manuscript statistics

---

## 🔐 **PHASE 7: ROLE & PERMISSION MANAGEMENT**

### Test 7.1: Permission System
**Login as:** admin@example.com

1. **Role Management:**
   - ✅ View all system roles
   - ✅ Create new roles
   - ✅ Edit existing roles
   - ✅ Delete unused roles

2. **Permission Assignment:**
   - ✅ Assign permissions to roles
   - ✅ Remove permissions from roles
   - ✅ View permission matrix
   - ✅ Test permission enforcement

3. **User Role Assignment:**
   - ✅ Assign roles to users
   - ✅ Multiple role support
   - ✅ Role hierarchy respect
   - ✅ Permission inheritance

---

## ⚠️ **KNOWN ISSUES TO VERIFY**

Based on automated testing, verify these issues are resolved:

1. **Database Schema:**
   - ✅ Reviewers table has all required columns
   - ✅ Email and status fields functional
   - ✅ Token generation working

2. **Array Serialization:**
   - ✅ meta_keywords stored as JSON
   - ✅ license information properly serialized
   - ✅ change_requests parsing works

3. **Repository Methods:**
   - ✅ authorUpdate method handles arrays correctly
   - ✅ Change request parsing doesn't error
   - ✅ Version tracking functional

---

## 📊 **TEST COMPLETION CHECKLIST**

### Critical Workflows (Must Pass):
- [ ] Author can submit manuscripts
- [ ] Editor can assign 2-4 reviewers
- [ ] Review status transitions work
- [ ] Author can submit corrections
- [ ] All notifications are sent
- [ ] Editor in Chief receives updates
- [ ] Version control works (git-like)

### Secondary Features:
- [ ] Category management functional
- [ ] Role/permission system works
- [ ] Regional data management
- [ ] Email templates render correctly
- [ ] Dashboard statistics accurate

### Performance & Security:
- [ ] Page load times acceptable
- [ ] Role-based access enforced
- [ ] File upload security
- [ ] Data validation working
- [ ] SQL injection protection

---

## 🎯 **SUCCESS CRITERIA**

**System is ready for production when:**
- ✅ 95%+ manual test cases pass
- ✅ All critical workflows functional
- ✅ No security vulnerabilities
- ✅ Email notifications working
- ✅ Version control operational
- ✅ Role permissions enforced

**Current Automated Test Success Rate:** 95.5%
**Target Manual Test Success Rate:** 95%+

---

*Last Updated: June 6, 2025*
*Testing Environment: Laravel Herd - journal.test*
