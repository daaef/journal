# AWS Ubuntu Server Document Conversion Setup

This guide will help you set up document conversion tools on your AWS Ubuntu server for the JAPR journal system.

## Prerequisites

- AWS Ubuntu server (18.04, 20.04, 22.04, or newer)
- SSH access to your server
- Sudo privileges

## Quick Installation (Recommended)

### Step 1: Connect to Your AWS Server

```bash
ssh -i your-key.pem ubuntu@your-server-ip
```

### Step 2: Update System Packages

```bash
sudo apt update
sudo apt upgrade -y
```

### Step 3: Install unoconv (Primary Method)

```bash
# Install unoconv and its dependencies
sudo apt install -y unoconv

# Verify installation
unoconv --version
```

### Step 4: Install LibreOffice (Required for unoconv)

```bash
# Install LibreOffice headless (no GUI needed for server)
sudo apt install -y libreoffice --no-install-recommends

# Verify installation
libreoffice --version
```

### Step 5: Install Additional Tools (Optional but Recommended)

```bash
# Install pandoc as fallback
sudo apt install -y pandoc

# Install additional fonts for better document rendering
sudo apt install -y fonts-liberation fonts-dejavu-core fonts-freefont-ttf

# Install common codecs
sudo apt install -y poppler-utils
```

## Verification

### Test on Server

Run these commands on your Ubuntu server to verify everything is working:

```bash
# Test unoconv
unoconv --version

# Test LibreOffice
libreoffice --version

# Test pandoc
pandoc --version

# Check if LibreOffice can run in headless mode
libreoffice --headless --version
```

### Test from Laravel Application

Once you've installed the tools on your server, test from your Laravel application:

```bash
# SSH into your server and navigate to your Laravel project
cd /path/to/your/laravel/project

# Run the conversion test
php artisan conversion:test
```

You should see output like:
```
Testing Document Conversion Service
====================================

Testing UnoconvService:
✓ UnoconvService: Available
  Version: unoconv 0.x.x

Testing DocumentConversionService:
✓ DocumentConversionService: Available

Checking system conversion tools:
✓ unoconv: Available
✓ LibreOffice: Available
✓ pandoc: Available

✓ 3 conversion tool(s) available.
✓ UnoconvService will be used as the primary conversion method.
```

## Advanced Configuration

### Set Custom Paths (if needed)

If you installed tools in custom locations, update your `.env` file:

```env
# Custom paths (only if needed)
UNOCONV_PATH=/usr/bin/unoconv
LIBREOFFICE_PATH=/usr/bin/libreoffice
PANDOC_PATH=/usr/bin/pandoc

# Performance settings
CONVERSION_TIMEOUT=300
CONVERSION_MAX_FILE_SIZE=20480
```

### Optimize for Production

```bash
# Set proper permissions for web server
sudo chown -R www-data:www-data /path/to/your/laravel/storage
sudo chmod -R 755 /path/to/your/laravel/storage

# Create temp directory if it doesn't exist
sudo mkdir -p /path/to/your/laravel/storage/app/temp
sudo chown www-data:www-data /path/to/your/laravel/storage/app/temp
sudo chmod 755 /path/to/your/laravel/storage/app/temp
```

### Configure PHP Settings

Edit your PHP configuration for better performance:

```bash
# Edit PHP configuration
sudo nano /etc/php/8.x/fpm/php.ini

# Add/modify these settings:
max_execution_time = 300
memory_limit = 512M
upload_max_filesize = 10M
post_max_size = 10M
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.x-fpm
```

## Docker Alternative

If you prefer using Docker on your AWS server:

```dockerfile
# Add to your existing Dockerfile
FROM ubuntu:22.04

# Install conversion tools
RUN apt-get update && apt-get install -y \
    unoconv \
    libreoffice --no-install-recommends \
    pandoc \
    fonts-liberation \
    fonts-dejavu-core \
    fonts-freefont-ttf \
    poppler-utils \
    && rm -rf /var/lib/apt/lists/*

# ... rest of your Dockerfile
```

## Troubleshooting

### Common Issues on AWS Ubuntu

1. **Permission Issues**:
```bash
# Fix storage permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 755 storage/
```

2. **Memory Issues**:
```bash
# Increase swap if needed
sudo fallocate -l 1G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile
```

3. **LibreOffice Headless Issues**:
```bash
# Test LibreOffice headless mode
libreoffice --headless --convert-to pdf --outdir /tmp test.docx
```

4. **Font Issues** (for better document rendering):
```bash
# Install Microsoft fonts (optional)
sudo apt install -y ttf-mscorefonts-installer
```

### Security Considerations

1. **Firewall**: Ensure your conversion processes don't expose unnecessary ports
2. **File Validation**: The system already validates file types, but consider additional malware scanning
3. **Resource Limits**: Monitor CPU and memory usage during conversions
4. **Temp File Cleanup**: The system automatically cleans up temp files

## Performance Optimization

### For High Volume Servers

1. **Use Queue System**:
```bash
# Install Redis for queuing
sudo apt install -y redis-server

# Configure Laravel queues in .env
QUEUE_CONNECTION=redis
```

2. **Monitor Resource Usage**:
```bash
# Install monitoring tools
sudo apt install -y htop iotop
```

3. **Consider Separate Conversion Server**:
   - For very high volumes, consider dedicating a separate server just for document conversion
   - Use Laravel queues to send conversion jobs to the dedicated server

## Testing Your Setup

### Create a Test Document

```bash
# Create a simple test Word document
echo "Test Document Content" > test.txt
libreoffice --headless --convert-to docx test.txt

# Test conversion
unoconv -f pdf test.docx

# Verify PDF was created
ls -la test.pdf
```

### Monitor Logs

Check Laravel logs for conversion activity:
```bash
tail -f storage/logs/laravel.log | grep -i conversion
```

## Production Checklist

- ✅ unoconv installed and working
- ✅ LibreOffice installed and working
- ✅ Proper file permissions set
- ✅ PHP memory and execution time limits configured
- ✅ Storage directories created with correct permissions
- ✅ Conversion test passes (`php artisan conversion:test`)
- ✅ Log monitoring in place
- ✅ Backup strategy for original files

Your AWS Ubuntu server should now be ready to handle document conversions efficiently!
