<?php

namespace App\Http\Controllers;

use App\Services\DocumentPreviewService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DocumentPreviewController extends Controller
{
    protected $previewService;
    
    public function __construct(DocumentPreviewService $previewService)
    {
        $this->previewService = $previewService;
    }
    
    /**
     * Generate preview for uploaded document
     */
    public function preview(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx,txt|max:10240' // 10MB max
        ]);
        
        $file = $request->file('document');
          $result = $this->previewService->generatePreview($file);
        
        if ($result['success']) {
            $response = [
                'success' => true,
                'html' => $result['html'],
                'message' => $result['message']
            ];
            
            // Include type and URL for PDF files
            if (isset($result['type'])) {
                $response['type'] = $result['type'];
            }
            if (isset($result['url'])) {
                $response['url'] = $result['url'];
            }
            
            return response()->json($response);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }
    
    /**
     * Preview existing document by ID
     */
    public function previewExisting($journalId)
    {
        $journal = \App\Models\Journal::findOrFail($journalId);
        
        if (!$journal->journal_url) {
            return response()->json([
                'success' => false,
                'message' => 'No document found for this journal'
            ], 404);
        }
        
        $filePath = storage_path('app/public/' . $journal->journal_url);
        
        if (!file_exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'Document file not found'
            ], 404);
        }
        
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        if ($extension === 'pdf') {
            // For PDF, return URL for PDF.js viewer
            return response()->json([
                'success' => true,
                'type' => 'pdf',
                'url' => asset('storage/' . $journal->journal_url),
                'message' => 'PDF document ready for viewing'
            ]);
        } else {
            // For other formats, we'd need to convert them
            return response()->json([
                'success' => false,
                'message' => 'Preview not available for this file format'
            ], 400);
        }
    }
      /**
     * Serve PDF file with proper inline headers
     */
    public function servePdf(Request $request, $filename)
    {
        $filePath = storage_path('app/public/temp/previews/' . $filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'PDF file not found');
        }
        
        // Security check - ensure file is in the correct directory and is a PDF
        $realPath = realpath($filePath);
        $allowedDir = realpath(storage_path('app/public/temp/previews'));
        
        if (!$realPath || !$allowedDir || strpos($realPath, $allowedDir) !== 0) {
            abort(403, 'Access denied');
        }
        
        $extension = strtolower(pathinfo($realPath, PATHINFO_EXTENSION));
        if ($extension !== 'pdf') {
            abort(400, 'Only PDF files are allowed');
        }
        
        // Check if download is requested
        $isDownload = $request->has('download');
        $disposition = $isDownload ? 'attachment' : 'inline';
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $disposition . '; filename="' . basename($filename) . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Frame-Options' => 'SAMEORIGIN'
        ]);
    }
}
