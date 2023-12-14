<?php

namespace App\Services;

use League\Csv\Reader;
use App\Services\AbstractImporter;


class ImportRecipesFromCSV extends AbstractImporter implements ImporterInterface
{
    protected function parseRecord(array $record)
    {
        return [
            'name' => $record['name'],
            'ingredients' => explode(',', $record['ingredients']),
            'preparationTime' => $record['preparationTime'],
            'cookingTime' => $record['cookingTime'],
            'serves' => (int)$record['serves'],
        ];
    }

    protected function parseFileContent($content)
    {
        $csv = Reader::createFromString($content);
        $csv->setHeaderOffset(0);

        $records = iterator_to_array($csv->getRecords());

        if ($this->importerPersistence) {
            $this->setImporterPersistence($this->importerPersistence);
            foreach ($records as $record) {
                $this->importerPersistence->persist($record);
            }
        }

        return $records;
    }

}
