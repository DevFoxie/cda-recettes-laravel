<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class RecipeImporterFactory
{
    public function create($fileType)
    {
        $importerClass = Config::get("importer.file_types.$fileType");

        if ($importerClass) {
            // Créer une instance de l'importeur grâce au service container
            $importer = App::make($importerClass);

            // Si l'importeur supporte la persistance MySQL, injecter l'importeur de persistance MySQL
            if ($importer instanceof ImporterPersistenceAwareInterface) {
                $importer->setImporterPersistence(app(\App\Repository\ImporterPersistenceMysql::class));
            }

            return $importer;
        }

        return null;
    }
}
