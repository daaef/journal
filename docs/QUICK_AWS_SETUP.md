# Quick AWS Ubuntu Setup Commands

## One-Line Installation
```bash
# Connect to your AWS server first, then run:
sudo apt update && sudo apt install -y unoconv libreoffice --no-install-recommends pandoc fonts-liberation && unoconv --version && libreoffice --version && echo "✅ Installation complete!"
```

## Step-by-Step Commands
```bash
# 1. Update system
sudo apt update

# 2. Install core tools
sudo apt install -y unoconv libreoffice --no-install-recommends

# 3. Install optional tools
sudo apt install -y pandoc fonts-liberation fonts-dejavu-core

# 4. Test installation
unoconv --version
libreoffice --version
pandoc --version

# 5. Set permissions (adjust path to your Laravel project)
sudo chown -R www-data:www-data /var/www/html/storage
sudo chmod -R 755 /var/www/html/storage

# 6. Test from Laravel (navigate to your project first)
cd /var/www/html  # or your project path
php artisan conversion:test
```

## Expected Success Output
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

Test completed.
```

That's it! Your AWS Ubuntu server will be ready for document conversion.
