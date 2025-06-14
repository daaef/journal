<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Renderer\RendererConstant;

class ManuscriptVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id', 'version_number', 'title', 'abstract', 'content',
        'changes_summary', 'created_by', 'parent_version_id', 'change_requests', 'status',
        'file_path', 'revision_notes', 'uploaded_by', 'uploaded_at'
    ];

    protected $casts = [
        'change_requests' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'uploaded_at' => 'datetime'
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function parentVersion()
    {
        return $this->belongsTo(ManuscriptVersion::class, 'parent_version_id');
    }

    public function childVersions()
    {
        return $this->hasMany(ManuscriptVersion::class, 'parent_version_id');
    }

    // Generate next version number
    public static function getNextVersionNumber($journalId, $isMinorChange = true)
    {
        $latestVersion = self::where('journal_id', $journalId)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$latestVersion) {
            return '1.0';
        }

        $parts = explode('.', $latestVersion->version_number);
        $major = intval($parts[0]);
        $minor = intval($parts[1] ?? 0);

        if ($isMinorChange) {
            $minor++;
        } else {
            $major++;
            $minor = 0;
        }

        return $major . '.' . $minor;
    }

    // Compare with another version using advanced diff
    public function compareWith(ManuscriptVersion $otherVersion)
    {
        $diffOptions = [
            'ignoreWhitespace' => true,
            'ignoreCase' => false,
            'context' => 3
        ];

        $comparison = [
            'title_changed' => $this->title !== $otherVersion->title,
            'abstract_changed' => $this->abstract !== $otherVersion->abstract,
            'content_changed' => $this->content !== $otherVersion->content,
            'title_diff' => $this->getAdvancedDiff($otherVersion->title ?? '', $this->title ?? '', $diffOptions),
            'abstract_diff' => $this->getAdvancedDiff($otherVersion->abstract ?? '', $this->abstract ?? '', $diffOptions),
            'content_diff' => $this->getAdvancedDiff($otherVersion->content ?? '', $this->content ?? '', $diffOptions),
            'title_side_by_side' => $this->getAdvancedDiff($otherVersion->title ?? '', $this->title ?? '', array_merge($diffOptions, ['renderer' => 'SideBySide'])),
            'abstract_side_by_side' => $this->getAdvancedDiff($otherVersion->abstract ?? '', $this->abstract ?? '', array_merge($diffOptions, ['renderer' => 'SideBySide'])),
            'content_side_by_side' => $this->getAdvancedDiff($otherVersion->content ?? '', $this->content ?? '', array_merge($diffOptions, ['renderer' => 'SideBySide'])),
            'changes_summary' => $this->changes_summary,
            'version_comparison' => [
                'from' => $otherVersion->version_number,
                'to' => $this->version_number,
                'created_at' => $this->created_at,
                'author' => $this->author->fullname ?? 'Unknown'
            ],
            'statistics' => [
                'additions' => 0,
                'deletions' => 0,
                'modifications' => 0
            ]
        ];

        // Add file comparison if both versions have files
        $comparison['file_comparison'] = $this->compareFileWith($otherVersion);

        // Calculate statistics from diffs
        $comparison['statistics'] = $this->calculateDiffStatistics([
            $comparison['title_diff'],
            $comparison['abstract_diff'], 
            $comparison['content_diff']
        ]);

        return $comparison;
    }

    // Get advanced diff using jfcherng/php-diff
    private function getAdvancedDiff($oldText, $newText, $options = [])
    {
        if ($oldText === $newText) {
            return '';
        }

        $renderer = $options['renderer'] ?? 'Inline';
        
        try {
            $diffOptions = [
                'context' => $options['context'] ?? 3,
                'ignoreWhitespace' => $options['ignoreWhitespace'] ?? true,
                'ignoreCase' => $options['ignoreCase'] ?? false,
            ];

            $rendererOptions = [
                'detailLevel' => 'line',
                'language' => 'eng',
                'lineNumbers' => true,
                'separateBlock' => true,
                'showHeader' => false,
                'spacesToNbsp' => true,
                'tabSize' => 4,
                'wrapperClasses' => ['diff-wrapper']
            ];

            return DiffHelper::calculate($oldText, $newText, $renderer, $diffOptions, $rendererOptions);
        } catch (\Exception $e) {
            return '<div class="alert alert-warning">Error generating diff: ' . $e->getMessage() . '</div>';
        }
    }

    /**
     * Calculate diff statistics from HTML diffs
     */
    private function calculateDiffStatistics($diffs)
    {
        $statistics = [
            'additions' => 0,
            'deletions' => 0,
            'modifications' => 0
        ];

        foreach ($diffs as $diff) {
            if (empty($diff)) continue;
            
            // Count insertions (additions)
            $statistics['additions'] += substr_count($diff, '<ins');
            
            // Count deletions
            $statistics['deletions'] += substr_count($diff, '<del');
            
            // Count modifications (lines with both ins and del)
            $lines = explode("\n", $diff);
            foreach ($lines as $line) {
                if (strpos($line, '<ins') !== false && strpos($line, '<del') !== false) {
                    $statistics['modifications']++;
                }
            }
        }

        return $statistics;
    }

    // Get changes since specific version
    public function getChangesSince(ManuscriptVersion $sinceVersion)
    {
        $changes = [];
        $currentVersion = $this;

        while ($currentVersion && $currentVersion->id !== $sinceVersion->id) {
            $changes[] = [
                'version' => $currentVersion->version_number,
                'summary' => $currentVersion->changes_summary,
                'created_at' => $currentVersion->created_at,
                'author' => $currentVersion->author->fullname ?? 'Unknown',
                'revision_notes' => $currentVersion->revision_notes
            ];

            $currentVersion = $currentVersion->parentVersion;
        }

        return array_reverse($changes);
    }

    // Get version tree (all versions in chronological order)
    public function getVersionTree()
    {
        $journal = $this->journal;
        return ManuscriptVersion::where('journal_id', $journal->id)
            ->with(['author:id,fullname'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($version) {
                return [
                    'id' => $version->id,
                    'version_number' => $version->version_number,
                    'summary' => $version->changes_summary,
                    'revision_notes' => $version->revision_notes,
                    'created_at' => $version->created_at,
                    'author' => $version->author->fullname ?? 'Unknown',
                    'is_current' => $version->id === $this->id,
                    'file_path' => $version->file_path
                ];
            });
    }

    /**
     * Compare file content with another version (for PDF documents)
     */
    public function compareFileWith(ManuscriptVersion $otherVersion)
    {
        // Check if both versions have files
        if (!$this->file_path || !$otherVersion->file_path) {
            return [
                'has_files' => false,
                'message' => 'One or both versions do not have associated files'
            ];
        }

        $thisFilePath = storage_path('app/public/' . $this->file_path);
        $otherFilePath = storage_path('app/public/' . $otherVersion->file_path);

        // Check if files exist
        if (!file_exists($thisFilePath) || !file_exists($otherFilePath)) {
            return [
                'has_files' => false,
                'message' => 'One or both files could not be found on disk'
            ];
        }

        // Get file information
        $thisFileInfo = [
            'size' => filesize($thisFilePath),
            'modified' => filemtime($thisFilePath),
            'exists' => true
        ];

        $otherFileInfo = [
            'size' => filesize($otherFilePath),
            'modified' => filemtime($otherFilePath),
            'exists' => true
        ];

        return [
            'has_files' => true,
            'files_identical' => $thisFileInfo['size'] === $otherFileInfo['size'] && 
                               hash_file('md5', $thisFilePath) === hash_file('md5', $otherFilePath),
            'current_file' => [
                'version' => $this->version_number,
                'path' => $this->file_path,
                'size' => $thisFileInfo['size'],
                'size_human' => $this->formatBytes($thisFileInfo['size']),
                'modified' => date('Y-m-d H:i:s', $thisFileInfo['modified']),
                'url' => asset('storage/' . $this->file_path)
            ],
            'other_file' => [
                'version' => $otherVersion->version_number,
                'path' => $otherVersion->file_path,
                'size' => $otherFileInfo['size'],
                'size_human' => $this->formatBytes($otherFileInfo['size']),
                'modified' => date('Y-m-d H:i:s', $otherFileInfo['modified']),
                'url' => asset('storage/' . $otherVersion->file_path)
            ],
            'size_difference' => $thisFileInfo['size'] - $otherFileInfo['size'],
            'size_difference_human' => $this->formatBytes(abs($thisFileInfo['size'] - $otherFileInfo['size']))
        ];
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($size, $precision = 2)
    {
        if ($size === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $base = log($size, 1024);
        
        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $units[floor($base)];
    }

    /**
     * Check if this version has an associated file
     */
    public function hasFile()
    {
        if (!$this->file_path) {
            return false;
        }

        $filePath = storage_path('app/public/' . $this->file_path);
        return file_exists($filePath);
    }

    /**
     * Get file information
     */
    public function getFileInfo()
    {
        if (!$this->hasFile()) {
            return null;
        }

        $filePath = storage_path('app/public/' . $this->file_path);
        
        return [
            'path' => $this->file_path,
            'size' => filesize($filePath),
            'size_human' => $this->formatBytes(filesize($filePath)),
            'modified' => date('Y-m-d H:i:s', filemtime($filePath)),
            'url' => asset('storage/' . $this->file_path),
            'extension' => pathinfo($this->file_path, PATHINFO_EXTENSION)
        ];
    }
}
