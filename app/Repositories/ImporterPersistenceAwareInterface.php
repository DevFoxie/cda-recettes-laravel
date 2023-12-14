<?php

namespace App\Repositories;

interface ImporterPersistenceAwareInterface
{
    public function setImporterPersistence(ImporterPersistenceInterface $importerPersistence);
}
