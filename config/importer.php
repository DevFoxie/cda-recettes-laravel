<?php

return [
    'file_types' => [
        'json' => \App\Services\ImportRecipesFromJson::class,
        'csv' => \App\Services\ImportRecipesFromCsv::class,
    ],
];
