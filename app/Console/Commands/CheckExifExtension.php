<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckExifExtension extends Command
{
    protected $signature = 'check:exif';
    protected $description = 'Check if the EXIF extension is loaded';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (extension_loaded('exif')) {
            $this->info('The EXIF extension is enabled.');
        } else {
            $this->error('The EXIF extension is not enabled.');
        }
    }
}
