<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\RecipeRepository;
use App\Services\RecipeImporterFactory;

class ImportRecipes extends Command
{
    protected $signature = 'import:recipes {filename}';
    protected $description = 'Import recipes from file';

    protected $recipeRepository;
    protected $recipeImporterFactory;

    public function __construct(RecipeRepository $recipeRepository, RecipeImporterFactory $recipeImporterFactory)
    {
        parent::__construct();
        $this->recipeRepository = $recipeRepository;
        $this->recipeImporterFactory = $recipeImporterFactory;
    }

    public function handle()
    {
        $filename = $this->argument('filename');
        $fileType = pathinfo($filename, PATHINFO_EXTENSION);

        $recipeImporter = $this->recipeImporterFactory->create($fileType);

        if ($recipeImporter) {
            $recipesData = $recipeImporter->getRecipes($filename);

            foreach ($recipesData as $recipeData) {
                $this->recipeRepository->createRecipe($recipeData);
            }

            $fileTypeMessage = ($fileType === 'csv') ? 'CSV' : 'JSON';
            $this->info("Recipes imported successfully from $fileTypeMessage file!");
        } else {
            $this->error('Importer not found for the specified file type.');
        }
    }
}
