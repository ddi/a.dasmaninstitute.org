<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BmeSeeder extends Seeder
{
    public function run(): void
    {
        $csvFilePath = fopen(realpath(base_path('database'))
            . DIRECTORY_SEPARATOR
            . 'seeders'
            . DIRECTORY_SEPARATOR
            . 'data'
            . DIRECTORY_SEPARATOR
            . 'ddi_bme_bar_coding.csv', 'r');

        $timestamp = date('Y-m-d H:i:s');

        $brandNames = [];
        $modelNames = [];
        $insturmentTypeNames = [];
        $insertData_brands = [];
        $insertData_models = [];
        $insertData_instrumentsTypes = [];
        $insertData_instruments = [];
        fgetcsv($csvFilePath); // Skip the header row
        while (($row = fgetcsv($csvFilePath)) !== false) {
            $brandName = trim($row[2]);
            if (!in_array($brandName, $brandNames)) {
                $brandNames[] = $brandName;
                $insertData_brands[] = [
                    'name' => $brandName,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            $modelName = trim($row[3]);
            if (!in_array($modelName, $modelNames)) {
                $modelNames[] = $modelName;
                $insertData_models[] = [
                    'name' => $modelName,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            $instrumentTypeName = trim($row[1]);
            if (!in_array($instrumentTypeName, $insturmentTypeNames)) {
                $insturmentTypeNames[] = $instrumentTypeName;
                $insertData_instrumentsTypes[] = [
                    'name' => $instrumentTypeName,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            // Instruments
            $insertData_instruments[] = [
                'id' => $row[0],
                'serial_number' => $row[4],
                'location' => $row[5] . ' ' . $row[6] . ' ' . $row[7],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];

        }

        DB::table('bme_brands')->insert($insertData_brands);
        DB::table('bme_models')->insert($insertData_models);
        DB::table('bme_instrument_types')->insert($insertData_instrumentsTypes);
        DB::table('bme_instruments')->insert($insertData_instruments);

        fclose($csvFilePath);
    }
}
