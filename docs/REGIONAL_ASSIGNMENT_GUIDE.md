# Regional Assignment System Guide

## Overview

The Regional Assignment System allows Managing Editors and Editor-in-Chief to intelligently assign Associate Editors (reviewers) to manuscripts based on regional expertise and research interests. This ensures that manuscripts are reviewed by experts who understand the cultural, contextual, and regional peculiarities of the research.

## How Regional Assignment Works

### 1. Automatic Region Detection
- When a manuscript is submitted, the system automatically detects the region based on the author's country
- Regions are mapped as follows:
  - **West Africa**: Nigeria, Ghana, Senegal, Ivory Coast, Mali, Burkina Faso, Niger, Togo, Benin, Guinea, Sierra Leone, Liberia, Gambia, Guinea-Bissau, Cape Verde, Mauritania
  - **East Africa**: Kenya, Tanzania, Uganda, Ethiopia, Somalia, Djibouti, Eritrea, Rwanda, Burundi, South Sudan
  - **Central Africa**: Cameroon, Chad, Central African Republic, Gabon, Congo, Democratic Republic of the Congo, Equatorial Guinea, Sao Tome and Principe
  - **Southern Africa**: South Africa, Namibia, Botswana, Zimbabwe, Zambia, Malawi, Mozambique, Angola, Lesotho, Eswatini, Madagascar, Mauritius, Seychelles, Comoros
  - **North Africa**: Egypt, Morocco, Algeria, Tunisia, Libya, Sudan
  - **Europe**: United Kingdom, Germany, France, Italy, Spain, Netherlands, Sweden, Norway, Denmark, Switzerland
  - **North America**: United States, Canada, Mexico
  - **Asia**: China, Japan, India, South Korea, Singapore, Malaysia, Thailand, Vietnam, Indonesia, Philippines
  - **South America**: Brazil, Argentina, Chile, Colombia, Peru
  - **Oceania**: Australia, New Zealand

### 2. Reviewer Matching Algorithm

The system uses a sophisticated scoring algorithm to match reviewers:

#### Regional Expertise Scoring:
- **Same Region**: +10 points (highest priority)
- **Regional Expertise**: +8 points (reviewer has declared expertise in that region)
- **Same Country**: +10 points (exact match)

#### Research Interest Scoring:
- **Category Match**: +8 points (reviewer's research interests match manuscript category)
- **Subcategory Match**: +6 points (additional bonus for subcategory match)

#### Performance Scoring:
- **Review Count**: Lower review count = higher priority (workload balancing)
- **Average Rating**: Higher rating = higher priority (quality consideration)

### 3. Assignment Process

#### Step 1: Access Pending Manuscripts
1. Go to **Editor Dashboard**
2. Click **"View Pending Manuscripts"** button
3. You'll see all manuscripts that need reviewer assignment

#### Step 2: Select Manuscript for Assignment
1. In the pending manuscripts list, look for manuscripts with status:
   - `pending` - New submissions
   - `in-review` - Currently under review
2. Click the **"Assign"** button next to the manuscript

#### Step 3: Review Assignment Interface
The assignment interface shows:
- **Manuscript Details**: Title, author, country, region, category
- **Assignment Strategy**: Explanation of how matching works
- **Optimal Suggestions**: System-recommended reviewers
- **Regional Statistics**: Available reviewers by region

#### Step 4: Select Reviewers
1. **Minimum**: 2 Associate Editors required
2. **Maximum**: 4 Associate Editors allowed
3. **Recommendation**: 3 reviewers for optimal coverage

#### Step 5: Confirm Assignment
1. Review selected reviewers
2. Click **"Assign Reviewers"**
3. System will send invitations automatically

## Regional Assignment Features

### Smart Suggestions
The system automatically suggests optimal reviewers based on:
- Regional expertise matching
- Research interest alignment
- Current workload balance
- Performance ratings

### Manual Override
Editors can manually select reviewers outside the suggestions if needed:
- Search by name
- Filter by region
- Filter by research interest
- View reviewer performance metrics

### Workload Balancing
The system considers:
- Current number of active reviews per reviewer
- Reviewer availability status
- Historical performance metrics

## Best Practices

### For Managing Editors:
1. **Review Regional Distribution**: Ensure manuscripts from different regions get appropriate coverage
2. **Monitor Workload**: Check that reviewers aren't overloaded
3. **Quality Control**: Consider reviewer ratings and performance history
4. **Timeliness**: Assign reviewers promptly to maintain review timeline

### For Editor-in-Chief:
1. **Strategic Assignment**: Consider the broader editorial strategy
2. **Expertise Matching**: Ensure high-quality manuscripts get top reviewers
3. **Diversity**: Promote diverse reviewer selection when appropriate
4. **Performance Monitoring**: Track assignment effectiveness

## Troubleshooting

### Common Issues:

#### No Regional Reviewers Available
- **Solution**: Expand reviewer pool or use reviewers with general expertise
- **Prevention**: Regular recruitment of regional experts

#### Reviewer Overload
- **Solution**: Check reviewer availability and current workload
- **Prevention**: Implement workload limits and rotation

#### Poor Match Quality
- **Solution**: Manually select reviewers with better expertise
- **Prevention**: Regular updates of reviewer expertise profiles

## Technical Implementation

### Database Structure:
- `users.regional_expertise` - JSON field storing regional expertise
- `users.research_interests` - JSON field storing research interests
- `users.available_for_review` - Boolean for availability status
- `users.average_rating` - Performance metric
- `users.review_count` - Workload metric

### API Endpoints:
- `GET /editor/regional-assignment/{journalUuid}` - Assignment interface
- `POST /editor/regional-assignment/{journalUuid}/assign` - Assign reviewers
- `GET /editor/regional-assignment/{journalUuid}/suggestions` - Get suggestions
- `GET /editor/reviewers/by-region` - Filter by region
- `GET /editor/reviewers/by-interest` - Filter by interest

## Future Enhancements

1. **AI-Powered Matching**: Machine learning for better suggestions
2. **Conflict of Interest Detection**: Automatic COI checking
3. **Reviewer Performance Analytics**: Advanced metrics and reporting
4. **Automated Assignment**: Rules-based automatic assignment for simple cases
5. **Integration with External Databases**: ORCID, Scopus integration for expertise validation

## Support

For technical support or questions about the regional assignment system:
1. Check this documentation
2. Review the system logs for errors
3. Contact the development team
4. Submit feature requests through the appropriate channels
