<?php

namespace App\Services;

// Interface pour les importers

interface ImporterInterface
{
    public function getRecipes(string $filename);
}
