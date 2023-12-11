<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="CDA Laravel API",
 *     description="API de recettes de cuisine",
 *     @OA\Contact(
 *         email="hakim@garage404.com"
 *     ),
 *     @OA\License(
 *         name="Licence API",
 *         url="https://www.monapi.com/licence"
 *     )
 * )
 */
class RecipeController extends Controller
{

    protected $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/recipes",
     *     summary="Récupérer la liste de toutes les recettes",
     *     @OA\Response(response=200, description="Liste des recettes"),
     * )
     */
    public function all()
    {
        $recipes = $this->recipeRepository->getAllRecipes();

        dd($recipes);

        return response()->json(['recipes' => $recipes]);
    }

    /**
     * @OA\Get(
     *     path="/api/recipe/{id}",
     *     summary="Récupérer une recette par son ID",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID de la recette",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Recette"),
     *     @OA\Response(response=404, description="Recette non trouvée"),
     * )
     */
    public function get($id)
    {
        $recipe = $this->recipeRepository->getRecipeById($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recette non trouvée.'], 404);
        }

        return response()->json(['recipe' => $recipe]);
    }

    /**
     * @OA\Post(
     *     path="/api/add",
     *     summary="Ajouter une recette",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données de la recette",
     *         @OA\JsonContent(
     *             required={"name","ingredients","preparationTime","cookingTime","serves"},
     *             @OA\Property(property="name", type="string", format="string", example="Poulet au curry"),
     *             @OA\Property(property="ingredients", type="string", format="string", example="Poulet, curry, riz"),
     *             @OA\Property(property="preparationTime", type="string", format="string", example="20 minutes"),
     *             @OA\Property(property="cookingTime", type="string", format="string", example="30 minutes"),
     *             @OA\Property(property="serves", type="integer", format="int64", example="4"),
     *         )
     *     ),
     *     @OA\Response(response=201, description="Recette créée"),
     *     @OA\Response(response=422, description="Erreur de validation"),
     * )
     */
    public function add(Request $request)
    {

        $recipe = $this->recipeRepository->addRecipe($request->all());

        return response()->json(['recipe' => $recipe], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/modify/{id}",
     *     summary="Modifier une recette",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID de la recette",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Données de la recette",
     *         @OA\JsonContent(
     *             required={"name","ingredients","preparationTime","cookingTime","serves"},
     *             @OA\Property(property="name", type="string", format="string", example="Poulet au curry"),
     *             @OA\Property(property="ingredients", type="string", format="string", example="Poulet, curry, riz"),
     *             @OA\Property(property="preparationTime", type="string", format="string", example="20 minutes"),
     *             @OA\Property(property="cookingTime", type="string", format="string", example="30 minutes"),
     *             @OA\Property(property="serves", type="integer", format="int64", example="4"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="Recette modifiée"),
     *     @OA\Response(response=404, description="Recette non trouvée"),
     *     @OA\Response(response=422, description="Erreur de validation"),
     * )
     */
    public function put(Request $request, $id)
    {
        $recipe = $this->recipeRepository->getRecipeById($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recette non trouvée.'], 404);
        }

        $this->recipeRepository->updateRecipe($recipe, $request->all());

        return response()->json(['recipe' => $recipe], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/delete/{id}",
     *     summary="Supprimer une recette",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID de la recette",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response=200, description="Recette supprimée"),
     *     @OA\Response(response=404, description="Recette non trouvée"),
     * )
     */
    public function delete($id)
    {
        $recipe = $this->recipeRepository->getRecipeById($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recette non trouvée.'], 404);
        }

        $this->recipeRepository->deleteRecipe($recipe);

        return response()->json(['message' => 'Recette supprimée.'], 200);
    }
}
