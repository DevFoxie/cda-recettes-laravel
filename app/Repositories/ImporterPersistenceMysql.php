<?php

namespace App\Repositories;

use App\Repositories\RecipeRepositoryInterface;

class ImporterPersistenceMysql implements ImporterPersistenceInterface
{
    protected $recipeRepository;

    public function __construct(RecipeRepositoryInterface $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    public function saveRecipe(array $recipeData)
    {
        return $this->recipeRepository->addRecipe($recipeData);
    }

    public function persist(array $recipes)
    {
        foreach ($recipes as $recipe) {
            $this->saveRecipe($recipe);
        }
    }
}
