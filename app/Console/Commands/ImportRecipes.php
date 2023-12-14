<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ImportRecipesJob;

class ImportRecipes extends Command
{
    protected $signature = 'import:recipes {filename}';
    protected $description = 'Import recipes from file';

    public function handle()
    {
        $filename = $this->argument('filename');

        ImportRecipesJob::dispatch($filename);

        $this->info("Import job dispatched successfully. Check the queue for progress.");
    }
}
