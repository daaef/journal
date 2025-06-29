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

            // Ubuntu-specific file validation
            if (!$this->validateFileForUbuntu($filePath)) {
                return [
                    'success' => false,
                    'message' => 'File validation failed for Ubuntu environment',
                    'html' => null
                ];
            }

            // Create temporary output file
            $tempDir = storage_path('app/temp');
            if (!file_exists($tempDir)) {
                if (!mkdir($tempDir, 0755, true) && !is_dir($tempDir)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $tempDir));
                }
                // Set proper permissions for Ubuntu
                chmod($tempDir, 0755);
            }

            $outputFile = $tempDir . '/' . uniqid('pandoc_', true) . '.html';

            // Normalize file path for Ubuntu (resolve any symbolic links, etc.)
            $normalizedPath = realpath($filePath);
            if (!$normalizedPath) {
                Log::error('PandocDocumentPreviewService: Could not normalize file path', [
                    'original_path' => $filePath,
                    'realpath_result' => $normalizedPath
                ]);
                return [
                    'success' => false,
                    'message' => 'Could not resolve file path: ' . $filePath,
                    'html' => null
                ];
            }

            // Test Pandoc with simple command first
            $pandocTest = Process::timeout(10)->run('pandoc --version');
            if (!$pandocTest->successful()) {
                Log::error('Pandoc is not working', [
                    'error' => $pandocTest->errorOutput(),
                    'output' => $pandocTest->output()
                ]);
                return [
                    'success' => false,
                    'message' => 'Pandoc is not available: ' . $pandocTest->errorOutput(),
                    'html' => null
                ];
            }

            // Enhanced Pandoc command with better error handling
            $command = sprintf(
                'pandoc --from=docx --to=html5 --standalone --embed-resources --metadata title="Document Preview" %s -o %s',
                escapeshellarg($normalizedPath),
                escapeshellarg($outputFile)
            );

            Log::info('PandocDocumentPreviewService: Executing Pandoc command', [
                'command' => $command,
                'normalized_path' => $normalizedPath,
                'output_file' => $outputFile,
                'file_exists' => file_exists($normalizedPath),
                'file_readable' => is_readable($normalizedPath),
                'file_size' => file_exists($normalizedPath) ? filesize($normalizedPath) : 'N/A',
                'working_directory' => getcwd(),
                'temp_dir_writable' => is_writable($tempDir)
            ]);

            $result = Process::timeout(120)->run($command);

            // Enhanced error logging
            if (!$result->successful()) {
                $errorOutput = $result->errorOutput();
                $standardOutput = $result->output();

                Log::error('PandocDocumentPreviewService: Pandoc conversion failed', [
                    'command' => $command,
                    'exit_code' => $result->exitCode(),
                    'error_output' => $errorOutput,
                    'standard_output' => $standardOutput,
                    'working_directory' => getcwd(),
                    'pandoc_version' => $this->getPandocVersion(),
                    'file_info' => [
                        'path' => $normalizedPath,
                        'exists' => file_exists($normalizedPath),
                        'readable' => is_readable($normalizedPath),
                        'size' => file_exists($normalizedPath) ? filesize($normalizedPath) : 0,
                        'mime_type' => file_exists($normalizedPath) ? mime_content_type($normalizedPath) : 'unknown'
                    ]
                ]);

                // Provide more specific error messages
                $userMessage = 'Failed to convert document with Pandoc';
                if (strpos($errorOutput, 'does not exist') !== false) {
                    $userMessage .= ': File not found';
                } elseif (strpos($errorOutput, 'permission') !== false) {
                    $userMessage .= ': Permission denied';
                } elseif (strpos($errorOutput, 'format') !== false) {
                    $userMessage .= ': Unsupported file format';
                } else {
                    $userMessage .= ': ' . trim($errorOutput ?: $standardOutput);
                }

                return [
                    'success' => false,
                    'message' => $userMessage,
                    'html' => null,
                    'debug_info' => [
                        'command' => $command,
                        'exit_code' => $result->exitCode(),
                        'error' => $errorOutput,
                        'output' => $standardOutput
                    ]
                ];
            }

            // Check if output file was created
            if (!file_exists($outputFile)) {
                Log::error('PandocDocumentPreviewService: Output file not created', [
                    'expected_output' => $outputFile,
                    'temp_dir_contents' => scandir($tempDir)
                ]);

                return [
                    'success' => false,
                    'message' => 'Pandoc completed but no HTML output file was generated',
                    'html' => null
                ];
            }

            // Read the generated HTML
            $html = file_get_contents($outputFile);
            if ($html === false) {
                return [
                    'success' => false,
                    'message' => 'Failed to read generated HTML file',
                    'html' => null
                ];
            }

            // Clean up temporary file
            unlink($outputFile);

            // Process and sanitize HTML
            $processedHtml = $this->processAndSanitizeHtml($html);

            Log::info('PandocDocumentPreviewService: DOCX conversion successful', [
                'output_size' => strlen($processedHtml),
                'original_file' => $normalizedPath
            ]);

            return [
                'success' => true,
                'message' => 'Document converted successfully',
                'html' => $processedHtml,
                'type' => 'docx'
            ];

        } catch (Exception $e) {
            Log::error('PandocDocumentPreviewService: Exception in DOCX conversion', [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Error converting DOCX: ' . $e->getMessage(),
                'html' => null
            ];
        }
    }

    /**
     * Validate file for Ubuntu-specific requirements
     *
     * @param string $filePath
     * @return bool
     */
    private function validateFileForUbuntu(string $filePath): bool
    {
        // Check file exists
        if (!file_exists($filePath)) {
            Log::error('File does not exist', ['path' => $filePath]);
            return false;
        }

        // Check file is readable
        if (!is_readable($filePath)) {
            Log::error('File is not readable', [
                'path' => $filePath,
                'permissions' => substr(sprintf('%o', fileperms($filePath)), -4),
                'owner' => fileowner($filePath),
                'current_user' => get_current_user()
            ]);
            return false;
        }

        // Check file is not empty
        if (filesize($filePath) === 0) {
            Log::error('File is empty', ['path' => $filePath]);
            return false;
        }

        // Check if file is actually a DOCX file (magic number check)
        $handle = fopen($filePath, 'rb');
        if ($handle) {
            $header = fread($handle, 4);
            fclose($handle);

            // DOCX files start with PK (ZIP magic number)
            if (substr($header, 0, 2) !== 'PK') {
                Log::warning('File does not appear to be a valid DOCX file', [
                    'path' => $filePath,
                    'header' => bin2hex($header)
                ]);
                // Don't return false here, just log warning
            }
        }

        return true;
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
     * Get Pandoc version for debugging
     *
     * @return string
     */
    private function getPandocVersion(): string
    {
        try {
            $result = Process::run('pandoc --version');
            return $result->successful() ? trim($result->output()) : 'Unknown';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
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
