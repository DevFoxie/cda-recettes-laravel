<?php

namespace App\Providers;

use App\Repositories\RecipeRepository;
use App\Services\ImportRecipesFromCsv;
use Illuminate\Support\ServiceProvider;
use App\Services\ImportRecipesFromJson;
use App\Repositories\ImporterPersistenceMysql;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);

        $this->app->bind(ImportRecipesFromJson::class, function ($app) {
            return new ImportRecipesFromJson();
        });

        $this->app->bind(RecipeRepository::class, function ($app) {
            return new RecipeRepository();
        });

        $this->app->bind(ImportRecipesFromCsv::class, function ($app) {
            return new ImportRecipesFromCsv();
        });

        $this->mergeConfigFrom(
            __DIR__.'/../../config/importer.php', 'importer'
        );

        $this->app->singleton(ImporterPersistenceMysql::class, function ($app) {
            return new ImporterPersistenceMysql();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
