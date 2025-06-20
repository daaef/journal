# Document Conversion Setup Guide

This guide will help you set up document conversion tools to automatically convert Word documents (DOC/DOCX) to PDF format.

> **Current Status**: No conversion tools are installed. The system will store original files as fallback until conversion tools are installed.

> **Quick Setup Guides**:
> - **AWS Ubuntu Server**: See [AWS_UBUNTU_CONVERSION_SETUP.md](AWS_UBUNTU_CONVERSION_SETUP.md) for detailed server setup
> - **Windows Development**: See [WINDOWS_CONVERSION_SETUP.md](WINDOWS_CONVERSION_SETUP.md) for local development setup

## Overview

The system supports automatic conversion of Microsoft Word documents to PDF using several conversion tools. The system will try different methods in order of preference:

1. **UnoconvService** (Recommended - Fast and reliable Laravel integration)
2. **LibreOffice** (Legacy method - Most reliable)
3. **unoconv** (Legacy alternative method)  
4. **pandoc** (Legacy fallback method)

## Installation Instructions

### Option 1: unoconv (Recommended - Used by UnoconvService)

unoconv is a command-line tool that uses LibreOffice/OpenOffice for conversion and is the primary method used by our `UnoconvService`.

#### Ubuntu/Debian:
```bash
sudo apt update
sudo apt install unoconv
```

#### CentOS/RHEL/Fedora:
```bash
sudo yum install unoconv
# or for newer versions:
sudo dnf install unoconv
```

#### Windows:
1. Install LibreOffice first (see Option 2 below)
2. Install Python if not already installed
3. Install unoconv via pip:
```bash
pip install unoconv
```

#### macOS:
```bash
brew install unoconv
```

### Option 2: LibreOffice (Legacy Method)

LibreOffice is still supported as a legacy conversion method.

#### Ubuntu/Debian:
```bash
sudo apt update
sudo apt install libreoffice --no-install-recommends
```

#### CentOS/RHEL/Fedora:
```bash
sudo yum install libreoffice-headless
# or for newer versions:
sudo dnf install libreoffice-headless
```

#### Windows:
1. Download LibreOffice from https://www.libreoffice.org/download/download/
2. Install with default settings
3. Ensure the installation directory is in your system PATH

#### macOS:
```bash
brew install --cask libreoffice
```

### Option 3: pandoc (Alternative Fallback)

Pandoc is a universal document converter.

#### Ubuntu/Debian:
```bash
sudo apt update
sudo apt install pandoc
```

#### CentOS/RHEL/Fedora:
```bash
sudo yum install pandoc
# or for newer versions:
sudo dnf install pandoc
```

#### Windows:
1. Download from https://pandoc.org/installing.html
2. Install and ensure it's in your system PATH

#### macOS:
```bash
brew install pandoc
```

## Verification

To verify that the conversion tools are properly installed, you can use our Laravel Artisan command:

```bash
php artisan conversion:test
```

Or test individual tools manually:

```bash
# Check unoconv (recommended)
unoconv --version

# Check LibreOffice (legacy)
libreoffice --version

# Check pandoc (legacy fallback)
pandoc --version
```

## Configuration

### File Permissions

Ensure that your web server has the necessary permissions to:
1. Create temporary files in `storage/app/temp/`
2. Execute the conversion commands
3. Write to the `storage/app/public/journals/` directory

### Server Requirements

- **Memory**: At least 512MB available for PHP processes (document conversion can be memory-intensive)
- **Execution time**: Increase `max_execution_time` in php.ini if you expect large documents
- **Disk space**: Ensure adequate disk space for temporary files during conversion

### Environment Variables (Optional)

You can set custom paths for conversion tools in your `.env` file:

```env
# Custom paths (optional)
UNOCONV_PATH=/usr/bin/unoconv
LIBREOFFICE_PATH=/usr/bin/libreoffice
PANDOC_PATH=/usr/bin/pandoc

# Conversion settings
CONVERSION_TIMEOUT=120
CONVERSION_MAX_FILE_SIZE=10240
CONVERSION_FALLBACK=store_original
LOG_CONVERSIONS=true
```

## Troubleshooting

### Common Issues

1. **Permission Denied**: Ensure web server has execute permissions for conversion tools
2. **Command Not Found**: Verify tools are installed and in system PATH
3. **Conversion Fails**: Check server logs for detailed error messages
4. **Memory Issues**: Increase PHP memory limit for large documents

### Fallback Behavior

If conversion fails, the system will:
1. Log the error for debugging
2. Store the original document (DOC/DOCX files)
3. Notify the user that conversion failed
4. Continue with the submission process

> **Note**: Currently, since no conversion tools are installed, all Word documents will be stored in their original format. Users can still submit manuscripts, but they won't be automatically converted to PDF.

### Testing

To test the conversion functionality:
1. Upload a Word document through the manuscript submission form
2. Check the server logs for conversion status
3. Verify the final stored file is in PDF format

## Docker Setup

If you're using Docker, add these to your Dockerfile:

```dockerfile
# Install LibreOffice
RUN apt-get update && apt-get install -y \
    libreoffice \
    --no-install-recommends && \
    rm -rf /var/lib/apt/lists/*
```

## Production Considerations

1. **Performance**: Document conversion can be resource-intensive. Consider using a queue system for large files.
2. **Security**: Ensure uploaded files are scanned for malware before conversion.
3. **Monitoring**: Monitor conversion success rates and performance.
4. **Backup**: Keep original files as backup in case conversion issues arise.

## Support

For issues with document conversion:
1. Check server logs in `storage/logs/laravel.log`
2. Verify conversion tool installation
3. Test conversion tools manually from command line
4. Check file permissions and disk space
