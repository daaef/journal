<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Exception;

class PandocDocumentPreviewService
{
    /**
     * Convert document to HTML for preview using Pandoc
     *
     * @param string $documentPath
     * @return array
     */
    public function convertToHtml(string $documentPath): array
    {
        try {
            Log::info('PandocDocumentPreviewService: Converting document to HTML', ['path' => $documentPath]);

            // Try multiple path resolution strategies
            $possiblePaths = [
                // Strategy 1: Direct storage path (if already relative to storage/app/public)
                storage_path('app/public/' . $documentPath),
                // Strategy 2: If path already includes storage/app/public
                $documentPath,
                // Strategy 3: Using Laravel Storage facade
                Storage::disk('public')->path($documentPath),
                // Strategy 4: Remove leading slash if present
                storage_path('app/public/' . ltrim($documentPath, '/')),
            ];

            $fullPath = null;
            $actualPath = null;

            // Find the actual file path
            foreach ($possiblePaths as $testPath) {
                Log::debug('Testing path: ' . $testPath);
                if (file_exists($testPath) && is_readable($testPath)) {
                    $fullPath = $testPath;
                    $actualPath = $testPath;
                    break;
                }
            }

            // If not found, try using Storage::disk to check existence
            if (!$fullPath && Storage::disk('public')->exists($documentPath)) {
                $fullPath = Storage::disk('public')->path($documentPath);
                $actualPath = $fullPath;
            }

            if (!$fullPath || !file_exists($fullPath)) {
                Log::error('PandocDocumentPreviewService: File not found', [
                    'original_path' => $documentPath,
                    'tested_paths' => $possiblePaths,
                    'storage_exists' => Storage::disk('public')->exists($documentPath),
                    'storage_path' => Storage::disk('public')->path($documentPath)
                ]);

                return [
                    'success' => false,
                    'message' => 'Document file not found at any expected location',
                    'html' => null
                ];
            }

            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            Log::info('PandocDocumentPreviewService: File details', [
                'original_path' => $documentPath,
                'resolved_path' => $fullPath,
                'extension' => $extension,
                'file_exists' => file_exists($fullPath),
                'file_size' => filesize($fullPath)
            ]);

            // Check if Pandoc is available
            if (!$this->isPandocAvailable()) {
                return [
                    'success' => false,
                    'message' => 'Pandoc is not available on this system',
                    'html' => null
                ];
            }

            // Handle different file types
            switch ($extension) {
                case 'pdf':
                    return $this->handlePdfPreview($documentPath);
                case 'docx':
                case 'doc':
                    return $this->convertDocxToHtml($fullPath);
                case 'txt':
                    return $this->convertTextToHtml($fullPath);
                case 'md':
                    return $this->convertMarkdownToHtml($fullPath);
                default:
                    return [
                        'success' => false,
                        'message' => "File type '{$extension}' is not supported for preview",
                        'html' => null
                    ];
            }

        } catch (Exception $e) {
            Log::error('PandocDocumentPreviewService: Error converting document', [
                'path' => $documentPath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to convert document: ' . $e->getMessage(),
                'html' => null
            ];
        }
    }

    /**
     * Check if Pandoc is available on the system
     *
     * @return bool
     */
    private function isPandocAvailable(): bool
    {
        try {
            return Process::run('pandoc --version')->successful();
        } catch (Exception $e) {
            Log::warning('PandocDocumentPreviewService: Pandoc not available', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Convert DOCX/DOC to HTML using Pandoc
     *
     * @param string $filePath
     * @return array
     */
    private function convertDocxToHtml(string $filePath): array
    {
        try {
            Log::info('PandocDocumentPreviewService: Converting DOCX to HTML', ['file' => $filePath]);

            // Create temporary output file
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $tempDir));
                }
            }

            $outputFile = $tempDir . '/' . uniqid('', true) . '.html';

            // Pandoc command to convert DOCX to HTML with styling
            $command = sprintf(
                'pandoc "%s" -t html5 --standalone --embed-resources --metadata title="Document Preview" -o "%s"',
                escapeshellarg($filePath),
                escapeshellarg($outputFile)
            );

            Log::info('PandocDocumentPreviewService: Executing Pandoc command', ['command' => $command]);

            $result = Process::timeout(60)->run($command);

            if (!$result->successful()) {
                Log::error('PandocDocumentPreviewService: Pandoc conversion failed', [
                    'command' => $command,
                    'output' => $result->output(),
                    'error' => $result->errorOutput()
                ]);

                return [
                    'success' => false,
                    'message' => 'Failed to convert document with Pandoc: ' . $result->errorOutput(),
                    'html' => null
                ];
            }

            // Read the generated HTML
            if (!file_exists($outputFile)) {
                return [
                    'success' => false,
                    'message' => 'Pandoc conversion completed but output file not found',
                    'html' => null
                ];
            }

            $html = file_get_contents($outputFile);

            // Clean up temporary file
            unlink($outputFile);

            // Process and sanitize HTML
            $processedHtml = $this->processAndSanitizeHtml($html);

            Log::info('PandocDocumentPreviewService: DOCX conversion successful', [
                'output_size' => strlen($processedHtml)
            ]);

            return [
                'success' => true,
                'message' => 'Document converted successfully',
                'html' => $processedHtml,
                'type' => 'docx'
            ];

        } catch (Exception $e) {
            Log::error('PandocDocumentPreviewService: Error in DOCX conversion', [
                'file' => $filePath,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error converting DOCX: ' . $e->getMessage(),
                'html' => null
            ];
        }
    }

    /**
     * Convert plain text to HTML
     *
     * @param string $filePath
     * @return array
     */
    private function convertTextToHtml(string $filePath): array
    {
        try {
            $content = file_get_contents($filePath);
            $html = '<div style="font-family: monospace; white-space: pre-wrap; padding: 20px;">' .
                    htmlspecialchars($content) .
                    '</div>';

            return [
                'success' => true,
                'message' => 'Text file loaded successfully',
                'html' => $html,
                'type' => 'text'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Failed to read text file: ' . $e->getMessage(),
                'html' => null
            ];
        }
    }

    /**
     * Convert Markdown to HTML using Pandoc
     *
     * @param string $filePath
     * @return array
     */
    private function convertMarkdownToHtml(string $filePath): array
    {
        try {
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $tempDir));
                }
            }

            $outputFile = $tempDir . '/' . uniqid('', true) . '.html';

            $command = sprintf(
                'pandoc "%s" -t html5 --standalone -o "%s"',
                escapeshellarg($filePath),
                escapeshellarg($outputFile)
            );

            $result = Process::timeout(30)->run($command);

            if (!$result->successful()) {
                return [
                    'success' => false,
                    'message' => 'Failed to convert Markdown: ' . $result->errorOutput(),
                    'html' => null
                ];
            }

            $html = file_get_contents($outputFile);
            unlink($outputFile);

            return [
                'success' => true,
                'message' => 'Markdown converted successfully',
                'html' => $this->processAndSanitizeHtml($html),
                'type' => 'markdown'
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error converting Markdown: ' . $e->getMessage(),
                'html' => null
            ];
        }
    }

    /**
     * Handle PDF preview (return special case)
     *
     * @param string $documentPath
     * @return array
     */
    private function handlePdfPreview(string $documentPath): array
    {
        return [
            'success' => true,
            'message' => 'PDF preview should use native browser viewer',
            'html' => null,
            'type' => 'pdf',
            'url' => Storage::disk('public')->url($documentPath)
        ];
    }    /**
     * Process and sanitize HTML output from Pandoc
     *
     * @param string $html
     * @return string
     */
    private function processAndSanitizeHtml(string $html): string
    {
        // Add custom styling for better preview with body reset
        $customStyles = '
        <style>
            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                line-height: 1.6;
                color: #333;
                margin: 0;
                padding: 0 !important;
                max-width: 100% !important;
                background-color: #fff;
            }
            h1, h2, h3, h4, h5, h6 {
                color: #2c3e50;
                margin-top: 1.5em;
                margin-bottom: 0.5em;
            }
            p {
                text-align: justify;
            }
            img {
                max-width: 100%;
                height: auto;
                display: block;
                margin: 1em auto;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 1em 0;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            blockquote {
                border-left: 4px solid #3498db;
                margin: 1em 0;
                padding-left: 1em;
                color: #666;
            }
            code {
                background-color: #f4f4f4;
                padding: 2px 4px;
                border-radius: 3px;
                font-family: "Courier New", monospace;
            }
            pre {
                background-color: #f4f4f4;
                padding: 1em;
                border-radius: 5px;
                overflow-x: auto;
            }
                border-collapse: collapse;
                width: 100%;
                margin: 1em 0;
            }            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 3em;
                color: rgba(0, 0, 0, 0.1);
                pointer-events: none;
                z-index: 1000;
                font-weight: bold;
            }
        </style>
        ';

        // Add watermark
        $watermark = '<div class="watermark">JAPR - Preview Only</div>';

        // Insert custom styles and watermark
        if (strpos($html, '</head>') !== false) {
            $html = str_replace('</head>', $customStyles . '</head>', $html);
        } else {
            $html = $customStyles . $html;
        }

        if (strpos($html, '<body>') !== false) {
            $html = str_replace('<body>', '<body>' . $watermark, $html);
        } else {
            $html = $watermark . $html;
        }

        // Disable right-click and selection
        $protectionScript = '
        <script>
            document.addEventListener("contextmenu", function(e) {
                e.preventDefault();
                return false;
            });

            document.addEventListener("selectstart", function(e) {
                e.preventDefault();
                return false;
            });

            document.addEventListener("dragstart", function(e) {
                e.preventDefault();
                return false;
            });

            // Disable common keyboard shortcuts
            document.addEventListener("keydown", function(e) {
                if (e.ctrlKey && (e.keyCode === 65 || e.keyCode === 67 || e.keyCode === 83 || e.keyCode === 80)) {
                    e.preventDefault();
                    return false;
                }
            });
        </script>
        ';

        if (strpos($html, '</body>') !== false) {
            $html = str_replace('</body>', $protectionScript . '</body>', $html);
        } else {
            $html = $html . $protectionScript;
        }

        return $html;
    }

    /**
     * Get supported file extensions
     *
     * @return array
     */
    public function getSupportedExtensions(): array
    {
        return ['pdf', 'docx', 'doc', 'txt', 'md'];
    }

    /**
     * Check if file type is supported
     *
     * @param string $extension
     * @return bool
     */
    public function isSupported(string $extension): bool
    {
        return in_array(strtolower($extension), $this->getSupportedExtensions());
    }
}
