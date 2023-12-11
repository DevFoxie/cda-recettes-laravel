<?php

namespace App\Repositories;

use App\Models\Recipe;

interface ImporterPersistenceInterface
{
    public function saveRecipe(array $recipeData);
}

class ImporterPersistenceMysql implements ImporterPersistenceInterface
{
    public function saveRecipe(array $recipeData)
    {
        return Recipe::create($recipeData)->toArray();
    }

    public function persist(array $recipes)
    {
        foreach ($recipes as $recipe) {
            $this->saveRecipe($recipe);
        }
    }
}
