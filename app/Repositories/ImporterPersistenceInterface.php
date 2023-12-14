<?php

namespace App\Repositories;
interface ImporterPersistenceInterface
{
    public function saveRecipe(array $recipeData);
}
