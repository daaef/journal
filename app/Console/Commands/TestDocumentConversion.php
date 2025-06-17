<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UnoconvService;
use App\Services\DocumentConversionService;

class TestDocumentConversion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversion:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test document conversion capabilities';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Testing Document Conversion Service');
        $this->info('====================================');

        // Test UnoconvService
        $this->line('');
        $this->info('Testing UnoconvService:');
        
        try {
            $unoconvService = app(UnoconvService::class);
            $testResult = $unoconvService->testInstallation();
            
            if ($testResult['success']) {
                $this->info('✓ UnoconvService: Available');
                $this->line('  Version: ' . ($testResult['version'] ?? 'Unknown'));
            } else {
                $this->error('✗ UnoconvService: ' . $testResult['message']);
            }
        } catch (\Exception $e) {
            $this->error('✗ UnoconvService Error: ' . $e->getMessage());
        }

        // Test DocumentConversionService
        $this->line('');
        $this->info('Testing DocumentConversionService:');
        
        try {
            $documentService = app(DocumentConversionService::class);
            $this->info('✓ DocumentConversionService: Available');
        } catch (\Exception $e) {
            $this->error('✗ DocumentConversionService Error: ' . $e->getMessage());
        }

        // Test conversion tools availability
        $this->line('');
        $this->info('Checking system conversion tools:');
        
        $tools = [
            'unoconv --version' => 'unoconv',
            'libreoffice --version' => 'LibreOffice',
            'pandoc --version' => 'pandoc'
        ];

        $availableCount = 0;
        foreach ($tools as $command => $name) {
            if ($this->testCommand($command)) {
                $this->info("✓ $name: Available");
                $availableCount++;
            } else {
                $this->error("✗ $name: Not available");
            }
        }

        $this->line('');
        
        if ($availableCount === 0) {
            $this->warn('⚠️  WARNING: No conversion tools are available!');
            $this->line('Please install at least one of the following:');
            $this->line('- unoconv (recommended for Laravel integration)');
            $this->line('- LibreOffice (general purpose)');
            $this->line('- pandoc (fallback)');
            $this->line('See DOCUMENT_CONVERSION_SETUP.md for installation instructions.');
        } else {
            $this->info("✓ $availableCount conversion tool(s) available.");
            
            if ($this->testCommand('unoconv --version')) {
                $this->info('✓ UnoconvService will be used as the primary conversion method.');
            } else {
                $this->line('ℹ️  UnoconvService not available, using legacy methods.');
            }
        }

        $this->line('');
        $this->info('Test completed.');

        return Command::SUCCESS;
    }

    /**
     * Test if a command is available
     *
     * @param string $command
     * @return bool
     */
    private function testCommand(string $command): bool
    {
        $result = shell_exec("$command 2>&1");
        return $result !== null && 
               strpos($result, 'not recognized') === false && 
               strpos($result, 'command not found') === false;
    }
}
