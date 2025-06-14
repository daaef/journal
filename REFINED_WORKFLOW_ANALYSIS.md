# Academic Journal Workflow - Corrected Implementation

## **Role Definitions & Permissions**

### **Author**
- Submit manuscripts
- View own submissions
- Respond to revision requests
- Upload revised versions
- Participate in review discussions

### **Associate Editor** (Acts as Reviewer)
- **Primary responsibility**: Review assigned manuscripts (they ARE the reviewers)
- Review manuscripts assigned by Managing Editor/Editor in Chief
- Submit review comments and ratings
- Request revisions from authors during review process
- Participate in review discussions
- **All Associate Editors are equal** - no hierarchy among them
- **Cannot**: Final approve/reject for publication

### **Managing Editor / Editor in Chief**
- Assign Associate Editors to manuscripts
- Final approval/rejection decisions
- Publish approved manuscripts
- Oversee entire process
- **Cannot**: Directly participate in review process (that's Associate Editor's job)

## **Corrected Workflow**

### **Phase 1: Submission**
1. Author submits manuscript → Status: `pending`
2. System notifies Editors (in Chief, Managing)
3. Editor assigns 2-4 Associate Editors → Status: `assigned_for_review`

### **Phase 2: Review Process (Associate Editors)**
1. Associate Editors accept/decline review assignments
2. Review process occurs (Associate Editors review the manuscript independently)
3. Each Associate Editor submits their review comments and ratings
4. Associate Editors can request revisions from authors during review
5. When all Associate Editor reviews complete → Status: `reviewed`

### **Phase 3: Decision Phase**
1. Managing Editor/Editor in Chief reviews all Associate Editor feedback
2. Managing Editor/Editor in Chief makes final decision:
   - **Approve for publication** → Status: `approved`
   - **Request revisions** → Status: `revision_requested`
   - **Reject** → Status: `rejected`
   - **Reject** → Status: `rejected`

### **Phase 4: Revision Process (if needed)**
1. Author uploads revised version (with version tracking)
2. Associate Editors review changes as a team
3. May require additional review or direct recommendation
4. Back to Decision Phase

## **Key Clarifications**

1. **Associate Editors ARE the reviewers** - no external reviewers needed
2. **All Associate Editors are equal** - no hierarchy or lead editor among them
3. **Only Managing Editor/Editor in Chief** can make final publication decisions
4. **Associate Editors** handle all review-related activities including revision requests
5. **Manuscript versioning** needed for revision tracking
