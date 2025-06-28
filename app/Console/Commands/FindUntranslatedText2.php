<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FindUntranslatedText2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translations:find-untranslated2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find all text in views that needs to be translated (improved version)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $viewsPath = base_path('resources/views');
        $files = File::allFiles($viewsPath);
        
        $untranslatedText = [];
        
        foreach ($files as $file) {
            if ($file->getExtension() !== 'blade.php') continue;
            
            $content = File::get($file->getPathname());
            
            // Find all text between quotes that isn't in translation functions
            preg_match_all('/(?<!\{\{\s*__(?:messages|auth|validation)\.)("[^"]+")/', $content, $matches);
            
            foreach ($matches[1] as $text) {
                // Remove quotes
                $text = trim($text, '"');
                
                // Skip URLs and paths
                if (
                    strpos($text, 'http') === 0 ||
                    strpos($text, 'www.') === 0 ||
                    strpos($text, '://') !== false ||
                    strpos($text, '/') !== false
                ) {
                    continue;
                }
                
                // Skip CSS/JS values
                if (
                    strpos($text, 'px') !== false ||
                    strpos($text, 'rem') !== false ||
                    strpos($text, 'em') !== false ||
                    strpos($text, 'vh') !== false ||
                    strpos($text, 'vw') !== false
                ) {
                    continue;
                }
                
                // Skip HTML attributes
                if (
                    strpos($text, 'class=') !== false ||
                    strpos($text, 'id=') !== false ||
                    strpos($text, 'name=') !== false
                ) {
                    continue;
                }
                
                $untranslatedText[$text] = $text;
            }
        }
        
        $this->info('Found ' . count($untranslatedText) . ' untranslated text strings:');
        
        foreach ($untranslatedText as $text) {
            $this->line($text);
        }
    }
}
