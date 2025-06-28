# JAPR - Journal Article Publishing & Review System

A comprehensive Laravel-based academic journal management system for peer review, manuscript submission, and publication workflows with secure document preview capabilities.

## 🚀 Implementation Status

### ✅ Completed Features

#### 🔄 **Workflow Management**
- **Reviewer Assignment**: Dynamic UI with 2-4 reviewer limits, reviewer selection dropdown, assignment guidelines
- **Associate Editor Review Interface**: Comprehensive review form with criteria ratings, overall assessment, and detailed feedback
- **Editorial Decision System**: Complete workflow for manuscript approval, rejection, and revision requests with modals and validation
- **Status Tracking**: Real-time manuscript status updates throughout the review process

#### 📝 **Document Management**  
- **Multi-format Support**: PDF, DOC, and DOCX files with intelligent handling
- **Advanced Preview System**: Pandoc-powered conversion with real-time preview
- **Document Protection**: Watermarked previews, disabled copying/downloading/printing
- **Secure Storage**: Protected file access with authenticated-only viewing

#### 👥 **User Interfaces**
- **Role-Based Dashboards**: Separate interfaces for authors, reviewers, editors, and administrators
- **Modern UI Components**: Bootstrap-based responsive design with Tailwind CSS enhancements
- **Form Validation**: Client-side and server-side validation with user-friendly error messages
- **Interactive Elements**: Dynamic forms, character counters, and loading states

### 🔄 In Progress
- **Testing Suite**: Expanding automated tests for workflow validation
- **Notification System**: Email notifications for status changes and assignments
- **Performance Optimization**: Caching and query optimization

### 📋 Ready for Testing
The following workflows are implemented and ready for comprehensive testing:
1. **Manuscript Submission** → Functional with file validation
2. **Reviewer Assignment** → Complete with 2-4 reviewer limits  
3. **Review Submission** → Comprehensive review form with validation
4. **Editorial Decisions** → Approve/Reject/Request Revisions with detailed feedback
5. **Author Feedback** → Status updates and decision communication

### 🚀 **Next Steps for Further Enhancement**

#### 🔧 **Administrative Platform Improvements**
1. **Comprehensive Admin Dashboard**
   - System-wide statistics and performance metrics
   - Real-time monitoring of submission volumes and processing times
   - User activity analytics and engagement tracking
   - Storage usage and system resource monitoring
   - Revenue tracking and subscription management (if applicable)

2. **Advanced User Management**
   - Bulk user import/export with CSV/Excel support
   - Advanced user search and filtering capabilities
   - Role assignment and permission matrix management
   - User account verification and approval workflows
   - Automated user account cleanup and archival
   - User activity logs and audit trails

3. **Content Management System**
   - Journal category and subcategory management interface
   - Editorial board member assignment and hierarchy management
   - Institution and affiliation database management
   - Journal template and formatting guidelines editor
   - Automated SEO optimization for published articles
   - Custom field management for manuscripts

4. **System Configuration Panel**
   - Dynamic system settings without code deployment
   - Email template customization with preview functionality
   - File upload restrictions and security policy management
   - Review timeline and deadline configuration
   - Automated backup scheduling and restoration
   - System maintenance mode controls

5. **Advanced Reporting & Analytics**
   - Editorial workflow performance reports
   - Reviewer workload distribution analysis
   - Submission trends and acceptance rate tracking
   - Geographic distribution of submissions and authors
   - Time-to-publication analytics
   - Export capabilities for institutional reporting (PDF/Excel/CSV)

6. **Quality Assurance & Compliance Tools**
   - Plagiarism detection integration (Turnitin/iThenticate)
   - Automated manuscript formatting validation
   - Editorial decision audit trails and versioning
   - Review quality assessment metrics
   - Compliance monitoring for academic standards
   - GDPR and data protection compliance tools

#### 📧 **Communication & Notification Enhancements**
1. **Email Notifications**: Automated email notifications for all workflow transitions
2. **SMS Integration**: Critical deadline reminders via SMS for editors/reviewers
3. **In-app Messaging**: Internal communication system between platform users
4. **Newsletter Management**: Automated journal updates and announcements
5. **Notification Preferences**: User-customizable notification settings
6. **Multi-language Support**: Notification templates in multiple languages

#### 📊 **Performance & Analytics Enhancements**
1. **Advanced Dashboard Analytics**: Editorial performance and workflow analytics
2. **Reviewer Performance Tracking**: Response times, quality metrics, and reliability scores
3. **Business Intelligence**: Advanced reporting with interactive data visualization
4. **Performance Optimization**: Advanced caching strategies and database optimization
5. **Load Balancing**: Multi-server deployment and scaling capabilities
6. **API Rate Limiting**: Comprehensive API management and monitoring

#### 🔗 **Integration & Export Capabilities**
1. **Export Functionality**: PDF/Word export for review reports and editorial decisions
2. **RESTful API Development**: Third-party integrations and mobile app support
3. **ORCID Integration**: Automatic author verification and profile linking
4. **CrossRef Integration**: Automated DOI assignment and metadata submission
5. **Institutional Repository**: Integration with university and institutional repositories
6. **Reference Management**: Mendeley, Zotero, and EndNote integration
7. **Social Media**: Automated sharing of published articles on academic networks

#### 🔐 **Security & Compliance Enhancements**
1. **Two-Factor Authentication**: Enhanced security for admin and editor accounts
2. **Single Sign-On (SSO)**: Integration with institutional authentication systems
3. **Advanced Audit Logging**: Comprehensive system activity monitoring
4. **Data Encryption**: Enhanced encryption for sensitive manuscript data
5. **Backup & Recovery**: Automated disaster recovery and data archival
6. **Security Scanning**: Regular vulnerability assessments and penetration testing

---

## 🎯 Overview

JAPR (Journal Article Publishing & Review) is a complete academic journal management platform that handles the entire lifecycle of academic paper submission, peer review, editorial management, and publication. The system features a modern, secure document preview system powered by Pandoc, role-based access control, and streamlined workflows.

## ✨ Key Features

### 📝 Secure Document Management
- **Multi-format Support**: PDF, DOC, and DOCX files with intelligent handling
- **Advanced Preview System**: Pandoc-powered conversion with real-time preview
- **Document Protection**: Watermarked previews, disabled copying/downloading/printing
- **Secure Storage**: Protected file access with authenticated-only viewing
- **Error Handling**: Robust fallback for unsupported or corrupted files

### 👥 Role-Based Access Control
- **Authors**: Submit manuscripts, track review progress, view secure previews
- **Reviewers**: Access assigned manuscripts, submit detailed reviews and ratings
- **Associate Editors**: Manage review assignments and editorial decisions
- **Managing Editors**: Complete oversight of editorial processes
- **Desk Editors**: Administrative support and initial manuscript processing

### 🔄 Streamlined Workflow
- **Smart Assignment**: Automated reviewer matching based on expertise
- **Review Management**: Double-blind peer review with structured feedback
- **Status Tracking**: Real-time manuscript status updates and notifications
- **Editorial Decisions**: Clear approval/rejection workflow with comments
- **Collection Management**: Personal manuscript collections for users

### 🎨 Modern User Interface
- **Responsive Design**: Mobile-friendly interface with clean, professional layout
- **Minimalistic UI**: Focus on content with reduced distractions
- **Real-time Updates**: Live preview loading with progress indicators
- **Accessibility**: Screen reader friendly and keyboard navigation support

## 🛠️ Technical Stack

- **Framework**: Laravel 10.x
- **Database**: MySQL/PostgreSQL with migrations
- **Frontend**: Blade templates with Tailwind CSS
- **Document Processing**: Pandoc for DOC/DOCX to HTML conversion
- **Authentication**: Laravel built-in authentication
- **File Storage**: Laravel File Storage (local/cloud compatible)
- **UI Icons**: Phosphor Icons
- **Build Tools**: Vite for asset compilation

## 📋 Prerequisites

- **PHP**: 8.1 or higher with required extensions
- **Composer**: Latest version for dependency management
- **Node.js**: 16+ for frontend asset compilation
- **Pandoc**: Required for document conversion (install separately)
- **Database**: MySQL 8.0+ or PostgreSQL 13+
- **Web Server**: Apache/Nginx with proper configuration
- Node.js & NPM
- MySQL or PostgreSQL
- Pandoc (for document conversion)

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL database
- Pandoc (for document conversion)
- **Laravel Herd** (recommended for local development)

### 1. Installation
```bash
# Clone the repository
git clone https://github.com/yourusername/japr-journal-system.git
cd japr-journal-system

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Copy environment configuration
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Environment Setup
Edit your `.env` file with the following essential settings:

```env
# Application
APP_NAME="JAPR Journal System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=japr_journal
DB_USERNAME=your_username
DB_PASSWORD=your_password

# File Storage
FILESYSTEM_DISK=public

# Document Preview Settings
PANDOC_ENABLED=true
PANDOC_TIMEOUT=60
DOCUMENT_PREVIEW_PROTECTION=true

# Mail Configuration (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourjournal.com
MAIL_FROM_NAME="JAPR Journal System"
```

### 3. Database Setup
```bash
# Run database migrations
php artisan migrate

# Seed the database with initial data
php artisan db:seed

# Create storage symlink for file access
php artisan storage:link
```

### 4. Install Pandoc (Required for Document Conversion)

**Windows:**
```bash
# Using chocolatey
choco install pandoc

# Or download from: https://pandoc.org/installing.html
```

**macOS:**
```bash
# Using homebrew
brew install pandoc
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt-get update
sudo apt-get install pandoc
```

### 5. Build Assets and Start Development
```bash
# Build frontend assets
npm run build

# Start the development server
php artisan serve

# In a separate terminal, start the asset watcher (optional)
npm run dev
```

Your application will be available at `http://localhost:8000`

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run tests with coverage
php artisan test --coverage

# Check migration status
php artisan migrate:status
```

### Testing Infrastructure Status

✅ **Test Framework Ready**: Complete PHPUnit testing infrastructure implemented  
✅ **Database Testing**: RefreshDatabase trait for clean test environments  
✅ **Factory Support**: User and Journal factories for test data generation  
✅ **Editorial Workflow Tests**: Comprehensive test suite for workflow validation  

**Note**: Tests require database seeding for roles and categories. Run `php artisan db:seed` before testing.

```bash
# Prepare test environment
php artisan migrate:fresh --seed

# Run editorial workflow tests
php artisan test --filter=EditorialWorkflowTest
```

### Manual Testing Workflows

#### 1. **Reviewer Assignment Testing**
- Navigate to Editor Dashboard → Manuscripts → Select manuscript
- Test reviewer assignment with 2-4 reviewers (enforced limits)
- Verify dropdown functionality and assignment guidelines
- Confirm assignment notifications and status updates

#### 2. **Review Submission Testing**
- Login as assigned reviewer
- Access manuscript via secure preview
- Submit comprehensive review using the enhanced review form
- Test form validation and character limits
- Verify submission confirmation and notifications

#### 3. **Editorial Decision Testing**
- Login as editor and navigate to reviewed manuscripts
- Test approve/reject/revision request workflows
- Verify modal functionality and form validation
- Test decision notification to authors
- Confirm status updates across the system

### Database Seeding for Testing
```bash
# Reset database and seed with test data
php artisan migrate:fresh --seed

# Create additional test users
php artisan tinker
# Then run: User::factory(10)->create();
```

## 🎯 Core Functionality

### Document Preview System

The JAPR system features a sophisticated document preview system:

#### **PDF Files**
- Direct browser rendering using iframe
- Disabled toolbars and navigation panels
- Print and download protection
- Responsive viewing with zoom controls

#### **DOC/DOCX Files**
- Backend Pandoc conversion to HTML
- Real-time conversion with loading indicators
- Protected HTML output with watermarking
- Disabled text selection and copying
- Custom styling for professional appearance

#### **Security Features**
- Preview-only access (no downloads for DOC/DOCX)
- Right-click disabled in preview areas
- Keyboard shortcuts blocked (Ctrl+A, Ctrl+C, Ctrl+S, Ctrl+P)
- Watermarked content identification
- Session-based access control

### User Workflow

#### **For Authors**
1. **Registration & Profile**: Create account and complete academic profile
2. **Manuscript Submission**: Upload PDF, DOC, or DOCX files with metadata
3. **Preview Verification**: Review secure document preview before submission
4. **Status Tracking**: Monitor review progress and editorial decisions
5. **Revision Management**: Upload revised versions based on feedback
6. **Collection Management**: Organize published articles in personal collections

#### **For Reviewers**
1. **Assignment Notification**: Receive email notifications for new assignments
2. **Secure Access**: Access manuscripts through protected preview system
3. **Review Submission**: Provide detailed feedback and ratings (1-5 stars)
4. **Deadline Management**: Track review deadlines and submission status
5. **Quality Assurance**: Consistent review interface with structured forms

#### **For Editors**
1. **Manuscript Oversight**: Monitor all submissions and review progress
2. **Reviewer Assignment**: Assign qualified reviewers based on expertise
3. **Editorial Decisions**: Make final acceptance/rejection decisions
4. **Workflow Management**: Ensure smooth progression through review stages
5. **Communication**: Coordinate between authors, reviewers, and editorial team

## 🏗️ Project Structure

```
japr-journal-system/
├── app/
│   ├── Http/Controllers/
│   │   ├── JournalController.php      # Main manuscript handling
│   │   ├── DashboardController.php    # User dashboards
│   │   └── AuthController.php         # Authentication
│   ├── Models/
│   │   ├── Journal.php                # Manuscript model
│   │   ├── User.php                   # User accounts
│   │   ├── Review.php                 # Review submissions
│   │   └── Category.php               # Journal categories
│   ├── Services/
│   │   └── PandocDocumentPreviewService.php  # Document conversion
│   └── Middleware/                    # Authentication & authorization
├── resources/
│   ├── views/
│   │   ├── view-abstract.blade.php    # Main document preview page
│   │   ├── dashboard/                 # User dashboards
│   │   └── layouts/                   # Template layouts
│   ├── js/                           # Frontend JavaScript
│   └── css/                          # Tailwind CSS styles
├── routes/
│   ├── web.php                       # Web routes including preview endpoint
│   └── console.php                   # Artisan commands
├── database/
│   ├── migrations/                   # Database schema
│   └── seeders/                      # Sample data
├── storage/app/public/               # Uploaded manuscripts
├── docs/                            # Comprehensive documentation
└── tests/                           # Automated tests
```

## ⚙️ Configuration

### Document Preview Settings
Configure document processing in your `.env` file:

```env
# Enable/disable Pandoc conversion
PANDOC_ENABLED=true

# Conversion timeout (seconds)
PANDOC_TIMEOUT=60

# Enable document protection features
DOCUMENT_PREVIEW_PROTECTION=true

# Watermark settings
DOCUMENT_WATERMARK=true
WATERMARK_TEXT="PREVIEW ONLY - JAPR Journal System"
```

### File Upload Limits
Adjust PHP settings for large documents:

```env
# In .env or server configuration
PHP_UPLOAD_MAX_FILESIZE=50M
PHP_POST_MAX_SIZE=50M
PHP_MAX_EXECUTION_TIME=300
```

### Email Notifications
Configure SMTP for automated notifications:

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourjournal.com
MAIL_FROM_NAME="JAPR Journal System"
```

## 🎮 Usage Guide

### Getting Started

1. **Access the Application**: Navigate to your JAPR installation URL
2. **Create Account**: Register as a new user with your academic email
3. **Complete Profile**: Add your academic affiliation and research interests
4. **Explore Dashboard**: Familiarize yourself with the role-based interface

### Submitting a Manuscript

1. **Navigate to Submission**: Click "Submit New Journal" from dashboard
2. **Fill Manuscript Details**:
   - Title and abstract
   - Category and keywords
   - Author information
   - Journal language
3. **Upload Document**: Select PDF, DOC, or DOCX file (max 50MB)
4. **Preview Verification**: Review the secure document preview
5. **Submit for Review**: Confirm submission to enter review queue

### Document Preview Features

#### **For Authors (Own Manuscripts)**
- **Secure Preview**: View your manuscript exactly as reviewers will see it
- **Real-time Conversion**: Automatic DOC/DOCX to HTML conversion
- **Protection Indicators**: Visual confirmation of security features
- **Error Handling**: Clear messages for any preview issues

#### **Preview Security**
- **No Downloads**: DOC/DOCX files cannot be downloaded, only previewed
- **Copy Protection**: Text selection and copying disabled
- **Print Protection**: Printing blocked for sensitive content
- **Right-click Disabled**: Context menus blocked in preview areas
- **Keyboard Shortcuts**: Common shortcuts (Ctrl+A, Ctrl+C, etc.) disabled

### Review Process

#### **For Reviewers**
1. **Assignment Notification**: Receive email when assigned to review
2. **Access Manuscript**: Click secure link to view document preview
3. **Conduct Review**: Use structured review form with rating system
4. **Submit Feedback**: Provide detailed comments and recommendations
5. **Track Status**: Monitor review completion and editorial decisions

#### **For Editors**
1. **Monitor Submissions**: View all manuscripts in editorial dashboard
2. **Assign Reviewers**: Select qualified reviewers based on expertise
3. **Track Progress**: Monitor review deadlines and completion status
4. **Make Decisions**: Approve, reject, or request revisions
5. **Communicate**: Send notifications to authors and reviewers

## 🔧 Advanced Configuration

### Pandoc Customization

Create custom Pandoc templates for document conversion:

```bash
# Create custom template directory
mkdir -p resources/pandoc/templates

# Add custom CSS for converted documents
cp resources/css/document-preview.css resources/pandoc/styles/
```

### Storage Configuration

For production environments, configure cloud storage:

```env
# AWS S3 Configuration
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-west-2
AWS_BUCKET=your-bucket-name
```

### Performance Optimization

```bash
# Cache configuration and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Queue configuration for background processing
php artisan queue:work
```

## 🔍 Troubleshooting

### Common Issues

**1. Pandoc Not Found Error**
```bash
# Verify Pandoc installation
pandoc --version

# Check system PATH
echo $PATH

# Reinstall if necessary (see installation section)
```

**2. Document Preview Not Loading**
- Check browser console for JavaScript errors
- Verify file exists in `storage/app/public`
- Ensure Pandoc is properly installed and accessible
- Check Laravel logs: `storage/logs/laravel.log`

**3. File Upload Issues**
```bash
# Check PHP limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Verify storage permissions
chmod -R 775 storage/
chown -R www-data:www-data storage/
```

**4. Email Notifications Not Working**
- Verify SMTP credentials in `.env`
- Test email configuration: `php artisan tinker` then `Mail::raw('Test', function($m) { $m->to('test@example.com')->subject('Test'); });`
- Check mail queue: `php artisan queue:work`

**5. CSS/JS Assets Not Loading**
```bash
# Rebuild assets
npm run build

# Clear cached files
php artisan view:clear
php artisan config:clear
```

## 📚 Documentation

Additional comprehensive documentation is available in the `docs/` directory:

- **[Workflow Analysis](docs/WORKFLOW_ANALYSIS.md)**: Detailed process documentation
- **[Implementation Guides](docs/IMPLEMENTATION_ROADMAP.md)**: Feature-specific setup instructions
- **[Testing Guide](docs/MANUAL_TESTING_GUIDE.md)**: Comprehensive testing procedures
- **[Deployment Guide](docs/DEPLOYMENT_CHECKLIST.md)**: Production deployment instructions
- **[Editorial Constraints](docs/EDITORIAL_CONSTRAINTS_IMPLEMENTATION.md)**: Editorial workflow documentation

## 🔒 Security Considerations

### Document Security
- All document previews are protected against unauthorized access
- DOC/DOCX files are converted server-side with no client-side exposure
- Watermarking prevents unauthorized distribution
- Session-based access control ensures proper authentication

### Data Protection
- User data encrypted in transit and at rest
- File uploads validated for type and size
- SQL injection protection through Laravel ORM
- CSRF protection on all forms
- XSS protection through Blade templating

### Access Control
- Role-based permissions strictly enforced
- Authors can only access their own manuscripts
- Reviewers see only assigned manuscripts
- Editors have controlled access based on role level

## 🤝 Contributing

We welcome contributions to improve the JAPR system:

### Development Setup
1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Make your changes and add tests
4. Ensure all tests pass: `php artisan test`
5. Commit your changes: `git commit -m 'Add amazing feature'`
6. Push to the branch: `git push origin feature/amazing-feature`
7. Open a Pull Request

### Code Standards
- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Add comments for complex logic
- Ensure responsive design for UI changes
- Test all new functionality thoroughly

# Queue worker (for background jobs)
php artisan queue:work
```

### Default Access
Visit `http://localhost:8000` to access the application.

## 🔄 Workflow Overview

### 1. Author Submission
1. **Registration**: Authors create accounts and complete profiles
2. **Manuscript Upload**: Submit papers in PDF, DOC, or DOCX format
3. **Metadata Entry**: Provide title, abstract, keywords, categories
4. **Submission Review**: Initial validation and formatting check

### 2. Editorial Processing
1. **Desk Review**: Initial screening by desk editors
2. **Assignment**: Managing editors assign associate editors
3. **Reviewer Selection**: Associate editors select peer reviewers
4. **Review Coordination**: Monitor review progress and deadlines

### 3. Peer Review
1. **Review Assignment**: Reviewers receive notification and access
2. **Document Review**: Secure preview system with protection features
3. **Feedback Submission**: Detailed comments and ratings
4. **Recommendation**: Accept, reject, or revise recommendations

### 4. Editorial Decision
1. **Review Compilation**: Associate editors compile reviewer feedback
2. **Decision Making**: Editorial board makes final decisions
3. **Author Notification**: Automated communication of decisions
4. **Revision Handling**: Manage revised manuscript submissions

### 5. Publication
1. **Final Approval**: Managing editor final approval
2. **Publication Preparation**: Format and prepare for publication
3. **Publication**: Make articles publicly available
4. **Archive Management**: Long-term storage and access

## 📁 Project Structure

```
journal/
├── app/
│   ├── Http/Controllers/          # Application controllers
│   ├── Models/                    # Eloquent models
│   ├── Services/                  # Business logic services
│   │   └── PandocDocumentPreviewService.php
│   ├── Repositories/              # Data access layer
│   └── Notifications/             # Email notifications
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── view-abstract.blade.php
│   │   ├── dashboard/
│   │   └── layouts/
│   ├── js/                        # JavaScript assets
│   └── css/                       # Stylesheets
├── routes/
│   ├── web.php                    # Web routes
│   └── api.php                    # API routes
├── database/
│   ├── migrations/                # Database migrations
│   └── seeders/                   # Database seeders
├── storage/
│   └── app/public/                # Uploaded files
└── docs/                          # Project documentation
```

## 🔧 Configuration

### Document Preview Settings
The system uses Pandoc for document conversion. Configure in `.env`:
```env
PANDOC_ENABLED=true
PANDOC_TIMEOUT=60
DOCUMENT_PREVIEW_PROTECTION=true
```

### Email Configuration
Set up SMTP for notifications:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
```

### File Storage
Configure file storage location:
```env
FILESYSTEM_DISK=local
# or for cloud storage
FILESYSTEM_DISK=s3
```

## 🎯 Key Features Explained

### Document Preview System
- **PDF Files**: Direct browser preview with disabled toolbars
- **DOC/DOCX Files**: Pandoc conversion to HTML with custom styling
- **Security**: Watermarks, copy protection, print disabled
- **Fallback**: Error handling for unsupported formats

### Review Management
- **Assignment Logic**: Automatic matching based on expertise
- **Conflict Detection**: Prevent reviewer conflicts of interest
- **Deadline Tracking**: Automated reminders and escalation
- **Quality Control**: Review quality assessment and feedback

### User Interface
- **Responsive Design**: Mobile-friendly interface
- **Clean Layout**: Minimalistic, professional appearance
- **Role-based Views**: Customized interfaces per user role
- **Real-time Updates**: Live status updates and notifications

## 🔍 Troubleshooting

### Common Issues

**1. Pandoc Not Found**
```bash
# Verify Pandoc installation
pandoc --version

# Ensure Pandoc is in system PATH
```

**2. File Upload Issues**
```bash
# Check PHP upload limits
php -i | grep upload_max_filesize
php -i | grep post_max_size

# Verify storage permissions
chmod -R 775 storage/
```

**3. Preview Not Working**
- Check browser console for JavaScript errors
- Verify file exists in storage/app/public
- Ensure route is properly registered

## 📚 Documentation

Additional documentation is available in the `docs/` directory:

- **Workflow Analysis**: Detailed process documentation
- **Implementation Guides**: Feature-specific setup instructions
- **Testing Guides**: Comprehensive testing procedures
- **Deployment Guides**: Production deployment instructions

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License. You are free to use, modify, and distribute this software in accordance with the license terms.

## 🆘 Support & Community

### Getting Help
- **Documentation**: Check the comprehensive guides in the `docs/` directory
- **Troubleshooting**: Review the troubleshooting section above
- **Issues**: Report bugs or request features via GitHub Issues
- **Discussions**: Join community discussions for questions and ideas

### Community Guidelines
- Be respectful and constructive in all interactions
- Follow academic integrity standards in all submissions
- Report security vulnerabilities responsibly
- Contribute improvements back to the community

## 🔄 Version History

- **v2.0.0**: Complete document preview system refactor with Pandoc integration
- **v1.5.0**: Enhanced UI/UX with minimalistic design and improved workflows
- **v1.0.0**: Initial release with core academic journal management functionality

## 🏆 Acknowledgments

- **Laravel Framework**: For providing the robust foundation
- **Pandoc**: For powerful document conversion capabilities
- **Tailwind CSS**: For modern, responsive styling
- **Phosphor Icons**: For clean, professional iconography
- **Academic Community**: For feedback and feature requirements

---

<div align="center">

**JAPR Journal System** - *Empowering Academic Publishing with Modern Technology*

*Making scholarly communication secure, efficient, and accessible*

</div>
