<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Models\Recipe;
use App\Http\Controllers\RecipeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Routes pour les recettes 

// Route::apiResources([
//     'recipes' => RecipeController::class,
// ]);

Route::get('/recipes', [RecipeController::class, 'all']);
Route::get('/recipe/{id}', [RecipeController::class, 'get']);
Route::post('/add', [RecipeController::class, 'add']);
Route::put('/modify/{id}', [RecipeController::class, 'update']);
Route::delete('/delete/{id}', [RecipeController::class, 'delete']);

