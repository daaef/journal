# JAPR Deployment Checklist

## 🚀 Pre-Deployment Checklist

### System Requirements
- [ ] PHP 8.1+ installed
- [ ] Composer installed
- [ ] Node.js & NPM installed
- [ ] MySQL/PostgreSQL database available
- [ ] Pandoc installed and accessible
- [ ] Web server configured (Apache/Nginx)

### Environment Setup
- [ ] `.env` file configured with proper database credentials
- [ ] `APP_KEY` generated (`php artisan key:generate`)
- [ ] Mail server settings configured
- [ ] File storage configured (`FILESYSTEM_DISK`)
- [ ] Queue driver configured if using queues

### Database Setup
- [ ] Database created
- [ ] Migrations run (`php artisan migrate`)
- [ ] Seeders run if needed (`php artisan db:seed`)

### File Permissions
- [ ] Storage directory writable (`chmod -R 775 storage`)
- [ ] Cache directory writable (`chmod -R 775 bootstrap/cache`)
- [ ] Storage link created (`php artisan storage:link`)

### Dependencies
- [ ] Composer dependencies installed (`composer install --optimize-autoloader`)
- [ ] NPM dependencies installed (`npm install`)
- [ ] Assets compiled (`npm run build`)

### Cache & Optimization
- [ ] Configuration cached (`php artisan config:cache`)
- [ ] Routes cached (`php artisan route:cache`)
- [ ] Views cached (`php artisan view:cache`)
- [ ] Application optimized (`php artisan optimize`)

## 🔧 Production Configuration

### Security
- [ ] `APP_DEBUG=false` in production
- [ ] `APP_ENV=production`
- [ ] HTTPS enabled
- [ ] Secure session cookies configured
- [ ] CSRF protection enabled

### Performance
- [ ] OPcache enabled
- [ ] Redis/Memcached configured for sessions/cache
- [ ] CDN configured for static assets
- [ ] Database indexes optimized

### Monitoring
- [ ] Error logging configured
- [ ] Application monitoring setup
- [ ] Database monitoring enabled
- [ ] Backup system configured

## 🧪 Post-Deployment Testing

### Basic Functionality
- [ ] Application loads without errors
- [ ] User registration works
- [ ] User authentication works
- [ ] File upload works
- [ ] Document preview works (PDF and DOCX)
- [ ] Email notifications work

### Role-Based Testing
- [ ] Author can submit manuscripts
- [ ] Reviewers can access assignments
- [ ] Editors can manage reviews
- [ ] Admin functions work properly

### Security Testing
- [ ] Document protection works (no copy/download)
- [ ] User permissions properly enforced
- [ ] File access restricted to authorized users
- [ ] SQL injection protection active

## 🔄 Maintenance Tasks

### Regular Tasks
- [ ] Database backups scheduled
- [ ] Log rotation configured
- [ ] Security updates applied
- [ ] Performance monitoring active

### Weekly Tasks
- [ ] Check error logs
- [ ] Monitor storage usage
- [ ] Review user activity
- [ ] Validate backup integrity

### Monthly Tasks
- [ ] Security audit
- [ ] Performance optimization
- [ ] Dependency updates
- [ ] Documentation updates

## 🆘 Troubleshooting

### Common Issues
- **500 Error**: Check storage permissions and `.env` configuration
- **Pandoc Not Working**: Verify Pandoc installation and PATH
- **File Uploads Failing**: Check PHP upload limits and storage permissions
- **Email Not Sending**: Verify SMTP configuration in `.env`
- **Database Connection**: Check database credentials and server availability

### Debug Commands
```bash
# Check application status
php artisan about

# Clear all caches
php artisan optimize:clear

# Check logs
tail -f storage/logs/laravel.log

# Test Pandoc
pandoc --version

# Check file permissions
ls -la storage/
```

---

**Note**: Always test deployments in a staging environment before production.
