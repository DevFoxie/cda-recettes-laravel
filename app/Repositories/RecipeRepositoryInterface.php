<?php

namespace App\Repositories;

interface RecipeRepositoryInterface
{
    public function getAllRecipes();

    public function getRecipeById(int $id);

    public function addRecipe(array $recipeData);

    public function updateRecipe(int $id, array $recipeData);

    public function deleteRecipe(int $id);
}
