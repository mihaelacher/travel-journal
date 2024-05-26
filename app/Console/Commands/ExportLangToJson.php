<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ExportLangToJson extends Command
{
    protected $signature = 'lang:export';
    protected $description = 'Export Laravel translation files to JSON format';
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    public function handle()
    {
        $langPath = lang_path();
        $jsonPath = public_path('translation');

        if (!is_dir($jsonPath)) {
            mkdir($jsonPath, 0755, true);
        }

        foreach ($this->filesystem->directories($langPath) as $langDir) {
            $lang = basename($langDir);
            $translations = [];

            foreach ($this->filesystem->allFiles($langDir) as $file) {
                $fileName = basename($file->getRealPath(), '.php');
                $translations[$fileName] = require $file->getRealPath();
            }

            $this->filesystem->put(
                "{$jsonPath}/{$lang}.json",
                json_encode($translations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }

        $this->info('Translation files have been exported.');
    }
}
