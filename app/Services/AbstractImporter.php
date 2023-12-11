<?php

namespace App\Services;

use App\Services\ImporterInterface;
use Illuminate\Support\Facades\File;

// Classe Abstraite pour les importers
abstract class AbstractImporter implements ImporterInterface, ImporterPersistenceAwareInterface
{
    abstract protected function parseRecord(array $record);

    protected $importerPersistence;

    public function getRecipes($filename)
    {
        $fileContent = File::get(storage_path("app/$filename"));

        $data = $this->parseFileContent($fileContent);

        $recipes = [];
        foreach ($data as $record) {
            $recipes[] = $this->parseRecord($record);
        }

        return $recipes;
    }

    abstract protected function parseFileContent($content);

    public function setImporterPersistence(ImporterPersistenceInterface $importerPersistence)
    {
        $this->importerPersistence = $importerPersistence;
    }
}
