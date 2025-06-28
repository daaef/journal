<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Exception;

class DocumentPreviewService
{
    /**
     * Generate HTML preview for document
     *
     * @param UploadedFile $file
     * @return array ['success' => bool, 'html' => string|null, 'message' => string]
     */
    public function generatePreview(UploadedFile $file): array
    {
        $extension = strtolower($file->getClientOriginalExtension());
        
        switch ($extension) {
            case 'pdf':
                return $this->generatePdfPreview($file);
            case 'doc':
            case 'docx':
                return $this->generateDocxPreview($file);
            case 'txt':
                return $this->generateTextPreview($file);
            default:
                return [
                    'success' => false,
                    'html' => null,
                    'message' => 'Preview not supported for this file type'
                ];
        }
    }
    
    /**
     * Generate preview for DOCX files
     */
    private function generateDocxPreview(UploadedFile $file): array
    {
        try {
            // Method 1: Try pandoc (best for DOCX to HTML)
            if ($this->isPandocAvailable()) {
                $result = $this->convertDocxToHtmlWithPandoc($file);
                if ($result['success']) {
                    return $result;
                }
            }
            
            // Method 2: Try LibreOffice
            if ($this->isLibreOfficeAvailable()) {
                $result = $this->convertDocxToHtmlWithLibreOffice($file);
                if ($result['success']) {
                    return $result;
                }
            }
            
            // Method 3: Try unoconv
            if ($this->isUnoconvAvailable()) {
                $result = $this->convertDocxToHtmlWithUnoconv($file);
                if ($result['success']) {
                    return $result;
                }
            }
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'No tools available for DOCX preview. Please install pandoc, LibreOffice, or unoconv.'
            ];
            
        } catch (Exception $e) {
            Log::error('Document preview generation failed', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'Preview generation failed: ' . $e->getMessage()
            ];
        }
    }
      /**
     * Convert DOCX to HTML using pandoc
     */
    private function convertDocxToHtmlWithPandoc(UploadedFile $file): array
    {
        $tempFilePath = null;
        $htmlPath = null;
        
        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            // Save uploaded file to temp location - use storeAs to preserve original file
            $tempFileName = uniqid() . '.docx';
            $tempFilePath = $tempDir . '/' . $tempFileName;
            copy($file->getRealPath(), $tempFilePath);
            
            // Convert to HTML
            $htmlPath = $tempDir . '/' . uniqid() . '.html';
            
            $process = new Process([
                'pandoc',
                $tempFilePath,
                '--to', 'html',
                '--output', $htmlPath,
                '--standalone',
                '--self-contained'
            ]);
            
            $process->setTimeout(60);
            $process->run();
            
            if ($process->isSuccessful() && file_exists($htmlPath)) {
                $html = file_get_contents($htmlPath);
                
                // Clean up temp files
                if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
                if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
                
                return [
                    'success' => true,
                    'html' => $this->sanitizeHtml($html),
                    'message' => 'Preview generated successfully with pandoc'
                ];
            }
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'Pandoc conversion failed: ' . $process->getErrorOutput()
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'html' => null,
                'message' => 'Pandoc preview error: ' . $e->getMessage()
            ];
        } finally {
            // Ensure cleanup even if an exception occurs
            if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
            if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
        }
    }
      /**
     * Convert DOCX to HTML using LibreOffice
     */
    private function convertDocxToHtmlWithLibreOffice(UploadedFile $file): array
    {
        $tempFilePath = null;
        $htmlPath = null;
        
        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $tempFileName = uniqid() . '.docx';
            $tempFilePath = $tempDir . '/' . $tempFileName;
            copy($file->getRealPath(), $tempFilePath);
            
            $process = new Process([
                'soffice',
                '--headless',
                '--convert-to', 'html',
                '--outdir', $tempDir,
                $tempFilePath
            ]);
            
            $process->setTimeout(60);
            $process->run();
            
            $htmlPath = $tempDir . '/' . pathinfo($tempFileName, PATHINFO_FILENAME) . '.html';
            
            if ($process->isSuccessful() && file_exists($htmlPath)) {
                $html = file_get_contents($htmlPath);
                
                // Clean up temp files
                if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
                if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
                
                return [
                    'success' => true,
                    'html' => $this->sanitizeHtml($html),
                    'message' => 'Preview generated successfully with LibreOffice'
                ];
            }
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'LibreOffice conversion failed: ' . $process->getErrorOutput()
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'html' => null,
                'message' => 'LibreOffice preview error: ' . $e->getMessage()
            ];
        } finally {
            // Ensure cleanup even if an exception occurs
            if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
            if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
        }
    }
      /**
     * Convert DOCX to HTML using unoconv
     */
    private function convertDocxToHtmlWithUnoconv(UploadedFile $file): array
    {
        $tempFilePath = null;
        $htmlPath = null;
        
        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            
            $tempFileName = uniqid() . '.docx';
            $tempFilePath = $tempDir . '/' . $tempFileName;
            copy($file->getRealPath(), $tempFilePath);
            
            $htmlPath = $tempDir . '/' . uniqid() . '.html';
            
            $process = new Process([
                'unoconv',
                '-f', 'html',
                '-o', $htmlPath,
                $tempFilePath
            ]);
            
            $process->setTimeout(60);
            $process->run();
            
            if ($process->isSuccessful() && file_exists($htmlPath)) {
                $html = file_get_contents($htmlPath);
                
                // Clean up temp files
                if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
                if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
                
                return [
                    'success' => true,
                    'html' => $this->sanitizeHtml($html),
                    'message' => 'Preview generated successfully with unoconv'
                ];
            }
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'Unoconv conversion failed: ' . $process->getErrorOutput()
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'html' => null,
                'message' => 'Unoconv preview error: ' . $e->getMessage()
            ];
        } finally {
            // Ensure cleanup even if an exception occurs
            if ($tempFilePath && file_exists($tempFilePath)) unlink($tempFilePath);
            if ($htmlPath && file_exists($htmlPath)) unlink($htmlPath);
        }
    }
      /**
     * Generate preview for PDF files
     */    private function generatePdfPreview(UploadedFile $file): array
    {
        try {
            // Clean up old temporary files first
            $this->cleanupTempFiles();
            
            // Ensure temp/previews directory exists
            $tempDir = 'temp/previews';
            if (!Storage::disk('public')->exists($tempDir)) {
                Storage::disk('public')->makeDirectory($tempDir);
            }
              // Store the uploaded PDF file temporarily for preview
            $fileName = 'preview_' . time() . '_' . Str::random(8) . '.pdf';
            $filePath = $file->storeAs($tempDir, $fileName, 'public');
            
            // Generate URL for our PDF serving route instead of direct storage URL
            $previewUrl = route('document.preview.pdf', ['filename' => $fileName]);
            
            Log::info('PDF preview generated', [
                'file_path' => $filePath,
                'url' => $previewUrl,
                'original_name' => $file->getClientOriginalName()
            ]);
            
            // Return PDF information for browser viewing
            return [
                'success' => true,
                'html' => null,
                'type' => 'pdf',
                'url' => $previewUrl,
                'message' => 'PDF ready for preview'
            ];
        } catch (Exception $e) {
            Log::error('PDF preview generation failed', [
                'file' => $file->getClientOriginalName(),
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'html' => null,
                'message' => 'Failed to prepare PDF for preview: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Generate preview for text files
     */
    private function generateTextPreview(UploadedFile $file): array
    {
        try {
            $content = $file->get();
            $html = '<pre class="text-preview">' . htmlspecialchars($content) . '</pre>';
            
            return [
                'success' => true,
                'html' => $html,
                'message' => 'Text preview generated'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'html' => null,
                'message' => 'Failed to read text file'
            ];
        }
    }
    
    /**
     * Check if pandoc is available
     */
    private function isPandocAvailable(): bool
    {
        try {
            $process = new Process(['pandoc', '--version']);
            $process->run();
            return $process->isSuccessful();
        } catch (Exception $e) {
            return false;
        }
    }
      /**
     * Check if LibreOffice is available
     */
    private function isLibreOfficeAvailable(): bool
    {
        try {
            $process = new Process(['soffice', '--version']);
            $process->run();
            return $process->isSuccessful();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Check if unoconv is available
     */
    private function isUnoconvAvailable(): bool
    {
        try {
            $process = new Process(['unoconv', '--version']);
            $process->run();
            return $process->isSuccessful();
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Sanitize HTML content for safe display
     */
    private function sanitizeHtml(string $html): string
    {
        // Remove potentially dangerous elements and attributes
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        $html = preg_replace('/<link\b[^<]*(?:(?!<\/link>)<[^<]*)*<\/link>/mi', '', $html);
        $html = preg_replace('/on\w+\s*=\s*["\'].*?["\']/i', '', $html);
        
        // Clean up base64 images that might be too large
        $html = preg_replace('/data:image\/[^;]+;base64,[^"\'>\s]+/i', '#image-removed', $html);
        
        // Add basic styling for better appearance
        $html = '<div style="font-family: Arial, sans-serif; line-height: 1.6; max-width: 100%; overflow-wrap: break-word;">' . $html . '</div>';
        
        return $html;
    }
    
    /**
     * Clean up old temporary preview files (older than 1 hour)
     */
    public function cleanupTempFiles(): void
    {
        try {
            $tempDir = 'temp/previews';
            if (!Storage::disk('public')->exists($tempDir)) {
                return;
            }
            
            $files = Storage::disk('public')->files($tempDir);
            $oneHourAgo = time() - 3600;
            
            foreach ($files as $file) {
                $lastModified = Storage::disk('public')->lastModified($file);
                if ($lastModified < $oneHourAgo) {
                    Storage::disk('public')->delete($file);
                    Log::info('Deleted old preview file: ' . $file);
                }
            }
        } catch (Exception $e) {
            Log::error('Failed to cleanup temporary preview files', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
