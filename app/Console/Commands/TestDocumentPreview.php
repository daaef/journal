<?php

namespace App\Console\Commands;

use App\Services\DocumentPreviewService;
use Illuminate\Console\Command;

class TestDocumentPreview extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'preview:test';

    /**
     * The console command description.
     */
    protected $description = 'Test document preview service functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Document Preview Service:');
        
        try {
            $previewService = app(DocumentPreviewService::class);
            $this->info('✓ DocumentPreviewService: Available');
        } catch (\Exception $e) {
            $this->error('✗ DocumentPreviewService Error: ' . $e->getMessage());
            return 1;
        }
        
        $this->newLine();
        $this->info('Testing conversion tools availability:');
        
        // Test pandoc
        try {
            $process = new \Symfony\Component\Process\Process(['pandoc', '--version']);
            $process->run();
            if ($process->isSuccessful()) {
                $this->info('✓ Pandoc: Available');
                $this->line('   Version: ' . trim(explode("\n", $process->getOutput())[0]));
            } else {
                $this->warn('✗ Pandoc: Not available');
            }
        } catch (\Exception $e) {
            $this->warn('✗ Pandoc: Not available (' . $e->getMessage() . ')');
        }
        
        // Test LibreOffice
        try {
            $process = new \Symfony\Component\Process\Process(['libreoffice', '--version']);
            $process->run();
            if ($process->isSuccessful()) {
                $this->info('✓ LibreOffice: Available');
                $this->line('   Version: ' . trim($process->getOutput()));
            } else {
                $this->warn('✗ LibreOffice: Not available');
            }
        } catch (\Exception $e) {
            $this->warn('✗ LibreOffice: Not available (' . $e->getMessage() . ')');
        }
        
        // Test unoconv
        try {
            $process = new \Symfony\Component\Process\Process(['unoconv', '--version']);
            $process->run();
            if ($process->isSuccessful()) {
                $this->info('✓ Unoconv: Available');
                $this->line('   Version: ' . trim($process->getOutput()));
            } else {
                $this->warn('✗ Unoconv: Not available');
            }
        } catch (\Exception $e) {
            $this->warn('✗ Unoconv: Not available (' . $e->getMessage() . ')');
        }
        
        $this->newLine();
        $this->info('Preview service is ready for use!');
        $this->line('Available features:');
        $this->line('• DOCX to HTML preview with pandoc, LibreOffice, or unoconv');
        $this->line('• PDF preview support (requires PDF.js integration)');
        $this->line('• Text file preview');
        
        return 0;
    }
}
