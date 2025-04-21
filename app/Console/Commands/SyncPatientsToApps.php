<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncPatientsToApps extends Command
{
    protected $signature = 'app:sync-patients-to-apps';
    protected $description = 'Command description';
    public function handle()
    {
        $ehrPatientsData = $this->getEhrPatients();
        $appsPatients = $this->getAppsPatients();
        $newPatients = array_diff($ehrPatientsData['civilIds'], $appsPatients);
        echo "EHR Patients:" . count($ehrPatientsData['patientsData']) . "\n";
        echo "Apps Patients:" . count($appsPatients) . "\n";
        if (count($newPatients) > 0) {
            $newPatientsData = $this->getEhrPatients($newPatients);
            echo "New Patients:" . count($newPatients) . "\n";
            $chunkedData = array_chunk($newPatientsData['patientsData'], 5000);
            foreach ($chunkedData as $chunk) {
                Patient::insert($chunk);
            }
            echo "Inserted " . count($newPatients) . " new patients\n";
            echo "Current Apps Patients:" . Patient::count() . "\n";
        }
        $this->info('Sync Patients To Apps Command Run Successfully');
    }

    private function getAppsPatients()
    {
        $patients = DB::table('patients')
            ->select(['id', 'civil_id'])
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
        $civilIds = [];
        foreach ($patients as $patient) {
            $civilIds[$patient->id] = trim($patient->civil_id);
        }
        return $civilIds;
    }

    private function getEhrPatients($newPatients = [])
    {
        $filter = '';
        if (count($newPatients) > 0) {
            $filter = 'AND per.personId IN (';
            foreach ($newPatients as $id => $civilId) {

                $filter .= $id . ',';
            }
            $filter = rtrim($filter, ',');
            $filter .= ')';
        }

        $sql = "SELECT 
                    per.personId as id,
                    percid.identifier AS civil_id,
                    perfid.identifier AS file_id,
                    per.firstname,
                    per.middleName,
                    per.lastname
                FROM patients AS p
                JOIN persons AS per ON p.patientId = per.personId
                JOIN personidentifiers AS percid ON per.personId = percid.personId
                JOIN personidentifiers AS perfid ON per.personId = perfid.personId
                WHERE
                    percid.deletedFlag = 0 AND perfid.deletedFlag = 0 # exclude deleted
                    AND per.isTestPerson = 0 # exclude test persons
                    AND percid.identifier <> '' # exclude empty civil IDs
                    AND perfid.clinicId = 2 # file ID for DDI Patients Only
                    AND percid.identifierTypeId = 10 # Civil ID
                    AND perfid.identifierTypeId = 15 # File ID
                    $filter
                ORDER BY per.personId ASC";
        $patientsData = DB::connection('hellohealth')->select($sql);
        // $civilIds = array_column($patientsData, 'civilId');
        $civilIds = [];
        $finalPatientsData = [];
        foreach ($patientsData as $patient) {
            $patientArray = (array) $patient;
            $patientArray['civil_id'] = trim($patientArray['civil_id']);
            $name = $patientArray['firstname'];
            if ($patientArray['middleName'] != "") $name .= " " . $patientArray['middleName'];
            if ($patientArray['lastname'] != "") $name .= " " . $patientArray['lastname'];
            $patientArray['name'] = $name;
            $timestamp = date("Y-m-d H:i:s");
            $patientArray['created_at'] = $timestamp;
            $patientArray['updated_at'] = $timestamp;
            unset($patientArray['firstname']);
            unset($patientArray['middleName']);
            unset($patientArray['lastname']);
            $finalPatientsData[$patientArray['civil_id']] = $patientArray;
            $civilIds[$patientArray['id']] = $patientArray['civil_id'];
        }

        return [
            'civilIds' => $civilIds,
            'patientsData' => $finalPatientsData
        ];
    }
}
