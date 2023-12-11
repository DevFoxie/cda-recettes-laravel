<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Writer;
use Illuminate\Support\Facades\File;

class ConvertJsonToCsv extends Command
{
    protected $signature = 'convert:json-to-csv {inputFile : Path to the input JSON file} {outputFile : Path to the output CSV file}';
    protected $description = 'Convert JSON file to CSV';

    public function handle()
    {
        $inputFile = $this->argument('inputFile');
        $outputFile = $this->argument('outputFile');

        $jsonContent = File::get($inputFile);
        $data = json_decode($jsonContent, true);

        if (!isset($data['recipes']) || !is_array($data['recipes'])) {
            $this->error('Invalid JSON format.');
            return;
        }

        $csv = Writer::createFromPath($outputFile, 'w+');
        $csv->insertOne(['name', 'ingredients', 'preparationTime', 'cookingTime', 'serves']);

        foreach ($data['recipes'] as $recipe) {

            $recipe['ingredients'] = implode(', ', $recipe['ingredients']);
            $csv->insertOne($recipe);
        }

        $this->info('Conversion completed successfully.');
    }
}
