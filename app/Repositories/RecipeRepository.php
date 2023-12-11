<?php

namespace App\Repositories;

use App\Models\Recipe;

interface RecipeRepositoryInterface
{
    public function getAllRecipes();

    public function getRecipeById(int $id);

    public function addRecipe(array $recipeData);

    public function updateRecipe(int $id, array $recipeData);

    public function deleteRecipe(int $id);
}

class RecipeRepository implements RecipeRepositoryInterface
{
    public function getAllRecipes()
    {
        return Recipe::all()->toArray();
    }

    public function getRecipeById($id)
    {
        $recipe = Recipe::find($id);

        return $recipe ? $recipe->toArray() : null;
    }

    public function addRecipe($recipeData)
    {
        $recipe = Recipe::create($recipeData);

        return $recipe ? $recipe->toArray() : null;
    }

    public function updateRecipe($id, $recipeData)
    {
        $recipe = Recipe::find($id);

        if ($recipe) {
            $recipe->update($recipeData);
        }

        return $recipe ? $recipe->toArray() : null;
    }

    public function deleteRecipe($id)
    {
        $recipe = Recipe::find($id);

        if ($recipe) {
            $recipe->delete();
        }

        return $recipe ? $recipe->toArray() : null;
    }

    public function createRecipe($recipeData)
    {
        return Recipe::create($recipeData)->toArray();
    }
}
