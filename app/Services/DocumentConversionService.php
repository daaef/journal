<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;

class DocumentConversionService
{
    protected $unoconvService;
    
    public function __construct(UnoconvService $unoconvService)
    {
        $this->unoconvService = $unoconvService;
    }
    
    /**
     * Convert a document to PDF if it's not already a PDF
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     */    public function convertToPdf(UploadedFile $file, string $targetPath, string $fileName): array
    {
        // Log the parameters for debugging
        Log::debug('DocumentConversionService convertToPdf called', [
            'original_name' => $file->getClientOriginalName(),
            'target_path' => $targetPath,
            'file_name' => $fileName,
            'extension' => $file->getClientOriginalExtension()
        ]);
        
        // Validate parameters
        if (empty($targetPath)) {
            Log::error('Target path is empty in DocumentConversionService convertToPdf');
            return [
                'success' => false,
                'path' => null,
                'message' => 'Target path cannot be empty'
            ];
        }
        
        if (empty($fileName)) {
            Log::error('File name is empty in DocumentConversionService convertToPdf');
            return [
                'success' => false,
                'path' => null,
                'message' => 'File name cannot be empty'
            ];
        }
        
        $extension = strtolower($file->getClientOriginalExtension());
        
        // If it's already a PDF, just store it
        if ($extension === 'pdf') {
            $storedPath = $file->storeAs($targetPath, $fileName, 'public');
            return [
                'success' => true,
                'path' => $storedPath,
                'message' => 'PDF file stored successfully'
            ];
        }
        
        // For Word documents, convert to PDF
        if (in_array($extension, ['doc', 'docx'])) {
            return $this->convertWordToPdf($file, $targetPath, $fileName);
        }
        
        return [
            'success' => false,
            'path' => null,
            'message' => 'Unsupported file format: ' . $extension
        ];
    }
    
    /**
     * Convert Word document to PDF using multiple methods
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @return array
     */
    private function convertWordToPdf(UploadedFile $file, string $targetPath, string $fileName): array
    {
        // Method 1: Try UnoconvService (most reliable and fast)
        if ($this->unoconvService->isUnoconvAvailable()) {
            $result = $this->unoconvService->convertToPdf($file, $targetPath, $fileName);
            if ($result['success'] && !isset($result['conversion_failed'])) {
                return $result;
            }
            Log::info('UnoconvService conversion failed, trying fallback methods', ['reason' => $result['message']]);
        }
        
        // Method 2: Try legacy LibreOffice method
        $result = $this->convertWithLegacyMethods($file, $targetPath, $fileName);
        return $result;
    }    /**
     * Convert Word document to PDF using legacy methods as fallback
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @return array
     */
    private function convertWithLegacyMethods(UploadedFile $file, string $targetPath, string $fileName): array
    {
        try {
            // Create temporary file for the uploaded document
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
              $originalExtension = $file->getClientOriginalExtension();
            $tempFileName = uniqid() . '.' . $originalExtension;
            $tempFilePath = $tempDir . '/' . $tempFileName;
            
            // Copy file to temp location instead of moving to preserve original for fallback
            if (!copy($file->getRealPath(), $tempFilePath)) {
                Log::error('Failed to copy file to temporary location for legacy conversion');
                return [
                    'success' => false,
                    'path' => null,
                    'message' => 'Failed to copy file for conversion'
                ];
            }
              // Generate PDF filename (replace original extension with .pdf)
            $baseFilename = pathinfo($fileName, PATHINFO_FILENAME);
            if (empty($baseFilename)) {
                Log::warning('Invalid filename in DocumentConversionService, using fallback', [
                    'original_filename' => $fileName,
                    'file' => $file->getClientOriginalName()
                ]);
                $baseFilename = 'converted-' . time() . '-' . uniqid();
            }
            $pdfFileName = $baseFilename . '.pdf';
            $tempPdfPath = $tempDir . '/' . uniqid() . '.pdf';
            
            // Try different conversion methods
            $conversionResult = $this->tryConversionMethods($tempFilePath, $tempPdfPath);
            
            if ($conversionResult['success']) {
                // Store the converted PDF
                $finalPath = storage_path('app/public/' . $targetPath);
                if (!file_exists($finalPath)) {
                    mkdir($finalPath, 0755, true);
                }
                
                $finalFilePath = $finalPath . '/' . $pdfFileName;
                if (copy($tempPdfPath, $finalFilePath)) {
                    // Clean up temporary files
                    unlink($tempFilePath);
                    unlink($tempPdfPath);
                    
                    return [
                        'success' => true,
                        'path' => $targetPath . '/' . $pdfFileName,
                        'message' => 'Document converted to PDF successfully'
                    ];
                }
            }
            
            // Clean up temporary files on failure
            if (file_exists($tempFilePath)) unlink($tempFilePath);
            if (file_exists($tempPdfPath)) unlink($tempPdfPath);
              // Fallback: Store original file and notify user
            Log::warning('PDF conversion failed, storing original file', [
                'file' => $file->getClientOriginalName(),
                'target_path' => $targetPath,
                'file_name' => $fileName,
                'error' => $conversionResult['message'] ?? 'Unknown error'
            ]);            // Validate parameters before storing
            if (empty($targetPath) || empty($fileName)) {
                Log::error('Cannot store original file: empty path or filename', [
                    'target_path' => $targetPath,
                    'file_name' => $fileName
                ]);
                return [
                    'success' => false,
                    'path' => null,
                    'message' => 'Failed to store file: path or filename is empty'
                ];
            }
            
            $storedPath = $file->storeAs($targetPath, $fileName, 'public');
            return [
                'success' => true,
                'path' => $storedPath,
                'message' => 'Conversion failed, original file stored. Please consider uploading a PDF version.',
                'conversion_failed' => true
            ];
              } catch (Exception $e) {
            Log::error('Document conversion error', [
                'file' => $file->getClientOriginalName(),
                'target_path' => $targetPath,
                'file_name' => $fileName,
                'error' => $e->getMessage()
            ]);            // Validate parameters before storing
            if (empty($targetPath) || empty($fileName)) {
                Log::error('Cannot store original file in exception handler: empty path or filename', [
                    'target_path' => $targetPath,
                    'file_name' => $fileName
                ]);
                return [
                    'success' => false,
                    'path' => null,
                    'message' => 'Failed to store file: path or filename is empty'
                ];
            }
            
            // Fallback: Store original file
            $storedPath = $file->storeAs($targetPath, $fileName, 'public');
            return [
                'success' => true,
                'path' => $storedPath,
                'message' => 'Conversion failed due to an error, original file stored.',
                'conversion_failed' => true
            ];
        }
    }
    
    /**
     * Try different conversion methods
     *
     * @param string $inputPath
     * @param string $outputPath
     * @return array
     */
    private function tryConversionMethods(string $inputPath, string $outputPath): array
    {
        // Method 1: Try LibreOffice (most reliable for server environments)
        if ($this->isLibreOfficeAvailable()) {
            $result = $this->convertWithLibreOffice($inputPath, $outputPath);
            if ($result['success']) return $result;
        }
        
        // Method 2: Try unoconv (if available)
        if ($this->isUnoconvAvailable()) {
            $result = $this->convertWithUnoconv($inputPath, $outputPath);
            if ($result['success']) return $result;
        }
        
        // Method 3: Try pandoc (if available)
        if ($this->isPandocAvailable()) {
            $result = $this->convertWithPandoc($inputPath, $outputPath);
            if ($result['success']) return $result;
        }
        
        return [
            'success' => false,
            'message' => 'No conversion tools available. Please install LibreOffice, unoconv, or pandoc.'
        ];
    }
    
    /**
     * Convert using LibreOffice
     */
    private function convertWithLibreOffice(string $inputPath, string $outputPath): array
    {
        $tempDir = dirname($outputPath);
        $command = sprintf(
            'libreoffice --headless --convert-to pdf --outdir %s %s 2>&1',
            escapeshellarg($tempDir),
            escapeshellarg($inputPath)
        );
        
        exec($command, $output, $returnCode);
        
        // LibreOffice generates PDF with same name as input but .pdf extension
        $generatedPdf = $tempDir . '/' . pathinfo($inputPath, PATHINFO_FILENAME) . '.pdf';
        
        if ($returnCode === 0 && file_exists($generatedPdf)) {
            // Move to desired output path
            if (rename($generatedPdf, $outputPath)) {
                return ['success' => true, 'message' => 'Converted with LibreOffice'];
            }
        }
        
        return ['success' => false, 'message' => 'LibreOffice conversion failed: ' . implode(' ', $output)];
    }
    
    /**
     * Convert using unoconv
     */
    private function convertWithUnoconv(string $inputPath, string $outputPath): array
    {
        $command = sprintf(
            'unoconv -f pdf -o %s %s 2>&1',
            escapeshellarg($outputPath),
            escapeshellarg($inputPath)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($outputPath)) {
            return ['success' => true, 'message' => 'Converted with unoconv'];
        }
        
        return ['success' => false, 'message' => 'Unoconv conversion failed: ' . implode(' ', $output)];
    }
    
    /**
     * Convert using pandoc
     */
    private function convertWithPandoc(string $inputPath, string $outputPath): array
    {
        $command = sprintf(
            'pandoc %s -o %s 2>&1',
            escapeshellarg($inputPath),
            escapeshellarg($outputPath)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($outputPath)) {
            return ['success' => true, 'message' => 'Converted with pandoc'];
        }
        
        return ['success' => false, 'message' => 'Pandoc conversion failed: ' . implode(' ', $output)];
    }
    
    /**
     * Check if LibreOffice is available
     */
    private function isLibreOfficeAvailable(): bool
    {
        exec('libreoffice --version 2>/dev/null', $output, $returnCode);
        return $returnCode === 0;
    }
    
    /**
     * Check if unoconv is available
     */
    private function isUnoconvAvailable(): bool
    {
        exec('unoconv --version 2>/dev/null', $output, $returnCode);
        return $returnCode === 0;
    }
    
    /**
     * Check if pandoc is available
     */
    private function isPandocAvailable(): bool
    {
        exec('pandoc --version 2>/dev/null', $output, $returnCode);
        return $returnCode === 0;
    }
}
