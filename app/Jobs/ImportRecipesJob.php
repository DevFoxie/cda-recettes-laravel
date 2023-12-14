<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Repositories\RecipeRepository;
use App\Services\RecipeImporterFactory;
use App\Events\ImportRecipesJobCompleted;

class ImportRecipesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;
    protected $delayInSeconds = 20;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function handle(RecipeRepository $recipeRepository, RecipeImporterFactory $recipeImporterFactory)
    {
        $fileType = pathinfo($this->filename, PATHINFO_EXTENSION);

        $recipeImporter = $recipeImporterFactory->create($fileType);

        if ($recipeImporter) {
            $recipesData = $recipeImporter->getRecipes($this->filename);

            foreach ($recipesData as $recipeData) {
                $recipeRepository->createRecipe($recipeData);
            }

            $fileTypeMessage = ($fileType === 'csv') ? 'CSV' : 'JSON';
            \Log::info("Recipes imported successfully from $fileTypeMessage file!");
        } else {
            \Log::error('Importer not found for the specified file type.');
        }

        event(new ImportRecipesJobCompleted($this->filename));
        // dd('Event TOTO!');
    }

    public function delay()
    {
        return now()->addSeconds($this->delayInSeconds);
    }

}
