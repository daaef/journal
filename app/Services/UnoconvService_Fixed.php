<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Exception;

class UnoconvService
{
    /**
     * Convert a document to PDF using unoconv
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @return array ['success' => bool, 'path' => string|null, 'message' => string]
     */
    public function convertToPdf(UploadedFile $file, string $targetPath, string $fileName): array
    {
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
     * Convert Word document to PDF using unoconv
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @return array
     */
    private function convertWordToPdf(UploadedFile $file, string $targetPath, string $fileName): array
    {
        try {
            // Check if unoconv is available
            if (!$this->isUnoconvAvailable()) {
                return $this->fallbackToOriginalFile($file, $targetPath, $fileName, 'unoconv is not available on this system');
            }
            
            // Create temporary directories
            $tempDir = storage_path('app/temp');
            $tempOutputDir = storage_path('app/temp/output');
            
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            if (!file_exists($tempOutputDir)) {
                mkdir($tempOutputDir, 0755, true);
            }
            
            // Save uploaded file to temp location
            $originalExtension = $file->getClientOriginalExtension();
            $tempFileName = uniqid() . '.' . $originalExtension;
            $tempFilePath = $tempDir . '/' . $tempFileName;
            
            $file->move($tempDir, $tempFileName);
            
            // Generate PDF filename
            $pdfFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.pdf';
            
            // Run unoconv conversion
            $conversionResult = $this->runUnoconvConversion($tempFilePath, $tempOutputDir);
            
            if ($conversionResult['success']) {
                // Find the converted PDF file
                $convertedPdfPath = $tempOutputDir . '/' . pathinfo($tempFileName, PATHINFO_FILENAME) . '.pdf';
                
                if (file_exists($convertedPdfPath)) {
                    // Store the converted PDF
                    $finalPath = storage_path('app/public/' . $targetPath);
                    if (!file_exists($finalPath)) {
                        mkdir($finalPath, 0755, true);
                    }
                    
                    $finalFilePath = $finalPath . '/' . $pdfFileName;
                    if (copy($convertedPdfPath, $finalFilePath)) {
                        // Clean up temporary files
                        $this->cleanupTempFiles([$tempFilePath, $convertedPdfPath]);
                        
                        return [
                            'success' => true,
                            'path' => $targetPath . '/' . $pdfFileName,
                            'message' => 'Document converted to PDF successfully using unoconv'
                        ];
                    }
                }
            }
            
            // Clean up on failure
            $this->cleanupTempFiles([$tempFilePath]);
            
            return $this->fallbackToOriginalFile($file, $targetPath, $fileName, $conversionResult['message']);
            
        } catch (Exception $e) {
            Log::error('Unoconv conversion error', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            
            return $this->fallbackToOriginalFile($file, $targetPath, $fileName, 'Conversion failed due to an error: ' . $e->getMessage());
        }
    }
    
    /**
     * Check if unoconv is available
     *
     * @return bool
     */
    public function isUnoconvAvailable(): bool
    {
        try {
            $unoconvPath = config('document_conversion.paths.unoconv', 'unoconv');
            
            // Ensure we have a valid command
            if (empty($unoconvPath)) {
                return false;
            }
            
            // Try using Symfony Process directly for better compatibility
            $process = new Process([$unoconvPath, '--version']);
            $process->run();
            
            return $process->isSuccessful();
        } catch (Exception $e) {
            Log::debug('UnoconvService availability check failed', ['error' => $e->getMessage()]);
            return false;
        }
    }
    
    /**
     * Run unoconv conversion
     *
     * @param string $inputPath
     * @param string $outputDir
     * @return array
     */
    private function runUnoconvConversion(string $inputPath, string $outputDir): array
    {
        try {
            $unoconvPath = config('document_conversion.paths.unoconv', 'unoconv');
            $timeout = config('document_conversion.timeout', 120);
            
            // Ensure we have a valid command
            if (empty($unoconvPath)) {
                return [
                    'success' => false,
                    'message' => 'Unoconv path is not configured'
                ];
            }
            
            // Use Symfony Process for better control
            $process = new Process([
                $unoconvPath,
                '-f', 'pdf',
                '-o', $outputDir,
                $inputPath
            ]);
            
            $process->setTimeout($timeout);
            $process->run();
            
            if ($process->isSuccessful()) {
                return [
                    'success' => true,
                    'message' => 'Conversion completed successfully'
                ];
            } else {
                Log::warning('Unoconv conversion failed', [
                    'command' => $process->getCommandLine(),
                    'output' => $process->getOutput(),
                    'error' => $process->getErrorOutput()
                ]);
                
                return [
                    'success' => false,
                    'message' => 'Unoconv conversion failed: ' . $process->getErrorOutput()
                ];
            }
        } catch (Exception $e) {
            Log::error('Unoconv execution error', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Unoconv execution error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Fallback to storing original file when conversion fails
     *
     * @param UploadedFile $file
     * @param string $targetPath
     * @param string $fileName
     * @param string $reason
     * @return array
     */
    private function fallbackToOriginalFile(UploadedFile $file, string $targetPath, string $fileName, string $reason): array
    {
        Log::warning('PDF conversion failed, storing original file', [
            'file' => $file->getClientOriginalName(),
            'reason' => $reason
        ]);
        
        try {
            // Store original file
            $storedPath = $file->storeAs($targetPath, $fileName, 'public');
            
            return [
                'success' => true,
                'path' => $storedPath,
                'message' => 'Conversion failed (' . $reason . '), original file stored. Please consider uploading a PDF version.',
                'conversion_failed' => true
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'path' => null,
                'message' => 'Failed to store file: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Clean up temporary files
     *
     * @param array $filePaths
     * @return void
     */
    private function cleanupTempFiles(array $filePaths): void
    {
        foreach ($filePaths as $filePath) {
            if (file_exists($filePath)) {
                try {
                    unlink($filePath);
                } catch (Exception $e) {
                    Log::warning('Failed to cleanup temp file: ' . $filePath, ['error' => $e->getMessage()]);
                }
            }
        }
    }
    
    /**
     * Get unoconv version information
     *
     * @return string|null
     */
    public function getVersion(): ?string
    {
        try {
            $unoconvPath = config('document_conversion.paths.unoconv', 'unoconv');
            
            // Ensure we have a valid command
            if (empty($unoconvPath)) {
                return null;
            }
            
            $process = new Process([$unoconvPath, '--version']);
            $process->run();
            
            if ($process->isSuccessful()) {
                return trim($process->getOutput());
            }
        } catch (Exception $e) {
            Log::debug('UnoconvService version check failed', ['error' => $e->getMessage()]);
        }
        
        return null;
    }
    
    /**
     * Test unoconv installation with a sample conversion
     *
     * @return array
     */
    public function testInstallation(): array
    {
        if (!$this->isUnoconvAvailable()) {
            return [
                'success' => false,
                'message' => 'unoconv is not available or not properly installed'
            ];
        }
        
        $version = $this->getVersion();
        
        return [
            'success' => true,
            'message' => 'unoconv is available and ready to use',
            'version' => $version
        ];
    }
}
