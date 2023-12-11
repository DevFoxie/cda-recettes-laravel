<?php

namespace App\Services;

use App\Services\AbstractImporter;

class ImportRecipesFromJson extends AbstractImporter implements ImporterInterface
{
    protected function parseRecord(array $record)
    {
        return $record; // pas besoin de parser, le format est déjà bon
    }

    protected function parseFileContent($content)
    {
        $data = json_decode($content, true);

        return isset($data['recipes']) && is_array($data['recipes']) ? $data['recipes'] : [];
    }
}
