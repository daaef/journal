# Windows Installation Guide for Document Conversion

This guide will help you set up document conversion on Windows for the JAPR journal system.

## Quick Setup for Windows

### Option 1: Install unoconv (Recommended)

1. **Install Python** (if not already installed):
   - Download from https://www.python.org/downloads/
   - During installation, make sure to check "Add Python to PATH"

2. **Install LibreOffice** (required for unoconv):
   - Download from https://www.libreoffice.org/download/download/
   - Install with default settings
   - Make sure it's added to your system PATH

3. **Install unoconv via pip**:
   ```cmd
   pip install unoconv
   ```

4. **Verify installation**:
   ```cmd
   unoconv --version
   ```

### Option 2: LibreOffice Only (Legacy)

If you prefer to use LibreOffice directly:

1. **Install LibreOffice**:
   - Download from https://www.libreoffice.org/download/download/
   - Install with default settings

2. **Add to System PATH**:
   - Add LibreOffice installation directory to your system PATH
   - Usually located at: `C:\Program Files\LibreOffice\program\`

3. **Verify installation**:
   ```cmd
   libreoffice --version
   ```

## Testing Your Installation

After installation, test the conversion service:

```cmd
php artisan conversion:test
```

## Troubleshooting

### Common Issues:

1. **"Command not found" errors**:
   - Make sure the tools are added to your system PATH
   - Restart your command prompt/PowerShell after installation

2. **Python not found**:
   - Install Python and ensure "Add Python to PATH" is checked during installation

3. **Permission errors**:
   - Run command prompt as Administrator
   - Check that your web server has proper permissions

### Alternative: Docker Setup

If you prefer using Docker:

```dockerfile
FROM php:8.4-fpm

# Install LibreOffice and unoconv
RUN apt-get update && apt-get install -y \
    libreoffice \
    python3-pip \
    && pip3 install unoconv \
    && rm -rf /var/lib/apt/lists/*
```

## Production Considerations

For production Windows servers:

1. **Windows Server**: Install LibreOffice in headless mode
2. **IIS**: Ensure proper permissions for conversion tools
3. **Service Account**: Run under a service account with appropriate permissions
4. **Monitoring**: Monitor conversion performance and success rates

## Support

If you encounter issues:

1. Check the Laravel logs: `storage/logs/laravel.log`
2. Test conversion tools manually from command line
3. Verify file permissions and disk space
4. Run the test command: `php artisan conversion:test`
