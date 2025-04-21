<?php

namespace Database\Seeders;

use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HubLink;

class HubLinkSeeder extends Seeder
{
    public function run(): void
    {
        $csvFilePath = fopen(realpath(base_path('database'))
            . DIRECTORY_SEPARATOR
            . 'seeders'
            . DIRECTORY_SEPARATOR
            . 'data'
            . DIRECTORY_SEPARATOR
            . 'hub_links.csv', 'r');

        while (($row = fgetcsv($csvFilePath, 1000, ",")) !== false) {

            $currentTimestamp = now()->toDateTimeString();
            HubLink::create([
                'id' => $row[0],
                'title' => $row[1],
                'url' => $row[2],
                'order' => $row[3],
                'description' => $row[4],
                'icon' => $row[5],
                'created_at' => $currentTimestamp,
                'updated_at' => $currentTimestamp,
            ]);
        }
        fclose($csvFilePath);

        $sourcePath = realpath(base_path('database')) .
            DIRECTORY_SEPARATOR
            . 'seeders'
            . DIRECTORY_SEPARATOR
            . 'data'
            . DIRECTORY_SEPARATOR
            . 'hubicons'
            . DIRECTORY_SEPARATOR;

        $destinationPath = public_path('uploads' . DIRECTORY_SEPARATOR . 'hubicons');

        if (File::exists($destinationPath)) {
            File::deleteDirectory($destinationPath);
        }
        File::copyDirectory($sourcePath, $destinationPath);
    }
}
