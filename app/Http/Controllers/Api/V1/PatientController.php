<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientCivilId;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function show($personId)
    {
        // $patientCivilIds = PatientCivilId::where('patient_id', $personId)->get();
        // return response()->json($patientCivilIds, 200);

        Storage::disk('local')->put('example.txt', 'Contasdfaents');
        print_r(Storage::disk('local')->get('example.txt'));
    }

    public function store(Request $request)
    {
        $postData = $request->all();
        $postedData = [];
        $postedData['scannerUsername'] = $postData['username'];
        $postedData['civilId'] = $postData['civil_id'];
        $postedData['passport'] = $postData['passport'];
        $postedData['arabicName1'] = $postData['arabic_name_1'];
        $postedData['arabicName2'] = $postData['arabic_name_2'];
        $postedData['arabicName3'] = $postData['arabic_name_3'];
        $postedData['arabicName4'] = $postData['arabic_name_4'];
        $postedData['arabicNameFull'] = $postData['arabic_name_full'];
        $postedData['englishName1'] = $postData['english_name_1'];
        $postedData['englishName2'] = $postData['english_name_2'];
        $postedData['englishName3'] = $postData['english_name_3'];
        $postedData['englishName4'] = $postData['english_name_4'];
        $postedData['englishNameFull'] = $postData['english_name_full'];
        $postedData['title'] = $postData['title'];
        $postedData['birthdate'] = $postData['birthdate'];
        $postedData['sexArabic'] = $postData['sex_arabic'];
        $postedData['sexEnglish'] = $postData['sex_english'];
        $postedData['bloodType'] = $postData['blood_type'];
        $postedData['nationalityArabic'] = $postData['nationality_arabic'];
        $postedData['nationalityEnglish'] = $postData['nationality_english'];
        $postedData['district'] = $postData['district'];
        $postedData['blockNumber'] = $postData['block_number'];
        $postedData['streetName'] = $postData['street_name'];
        $postedData['buildingPlotNumber'] = $postData['building_plot_number'];
        $postedData['floorNumber'] = $postData['floor_number'];
        $postedData['unitNumber'] = $postData['unit_number'];
        $postedData['unitType'] = $postData['unit_type'];
        $postedData['telephone1'] = $postData['telephone_1'];
        $postedData['telephone2'] = $postData['telephone_2'];
        $postedData['guardianCivilId'] = $postData['guardian_civil_id'];
        $postedData['cardExpiryDate'] = $postData['card_expiry_date'];
        $postedData['cardIssueDate'] = $postData['card_issue_date'];

        echo json_encode($postedData);
        Storage::disk('local')->put($postData['civil_id'] . '.json', json_encode($postedData, JSON_PRETTY_PRINT));
        exit;
        Storage::disk('local')->put($postData['civil_id'] . '.json', 'Contasdfaents');

        $postData = $request->all();
        $patientId = $this->getPatientId($request->civil_id);
        $userId = $this->getUserId($request->username);
        unset($postData['username']);

        $postData['patient_id'] = $patientId;
        $postData['user_id'] = $userId;

        if (!$patientId or !$userId) {
            return response()->json([
                'message' => 'Card not saved, Make sure the patien exist and the user exist in hello health',
            ], 500);
        }

        $lastCivilIdScan = DB::table('patient_civil_ids')
            ->where('patient_id', $patientId)
            ->latest('updated_at');

        if ($lastCivilIdScan->exists()) {
            $lastCivilIdScan = (array) $lastCivilIdScan->first();
            unset($lastCivilIdScan['id']);
            unset($lastCivilIdScan['created_at']);
            unset($lastCivilIdScan['updated_at']);

            if (empty(array_diff($lastCivilIdScan, $postData))) {
                return response()->json([
                    'message' => 'No changes detected in the card data. Card not saved.',
                ], 200);
            }
        }

        PatientCivilId::create($postData);
        return response()->json([
            'message' => 'Card Saved Successfully',
        ], 201);
    }

    private function getUserId($username)
    {
        $user = User::where('username', $username)->first();
        if (!$user) {
            $newUserArray = ['username' => $username];
            $sql = "SELECT 
                        p.personId
                    FROM users AS u
                    JOIN persons AS p ON u.userId = p.personId
                    WHERE u.username = '" . $username . "';";
            $helloHealthUserData = DB::connection('hellohealth')->select($sql);

            if (count($helloHealthUserData) == 1) {
                $newUserArray['person_id'] = $helloHealthUserData[0]->personId;
            }

            $user = User::create($newUserArray);
        }
        if ($user) {
            return $user->id;
        }
        return null;
    }

    private function getPatientId($civil_id)
    {
        $patient = Patient::where('civil_id', $civil_id)->first();
        if (!$patient) {
            $sql = "SELECT
                        picid.personId AS id,
                        picid.identifier AS civil_id,
                        pifid.identifier AS file_id,
                        p.firstname, p.middleName, p.lastname
                    FROM personidentifiers AS picid
                    JOIN personidentifiers AS pifid ON picid.personId = pifid.personId 
                        AND pifid.identifierTypeId = 15 
                        AND pifid.clinicId = 2
                    JOIN persons AS p ON picid.personId = p.personId
                    
                    WHERE
                            picid.deletedFlag = 0 AND pifid.deletedFlag = 0
                            AND picid.identifier = '" . $civil_id . "'";

            $helloHealthPatientData = DB::connection('hellohealth')->select($sql);
            if (count($helloHealthPatientData) == 1) {
                $name = $helloHealthPatientData[0]->firstname;
                if ($helloHealthPatientData[0]->middleName != "") $name .= " " . $helloHealthPatientData[0]->middleName;
                if ($helloHealthPatientData[0]->lastname != "") $name .= " " . $helloHealthPatientData[0]->lastname;
                $patient = Patient::create([
                    'id' => $helloHealthPatientData[0]->id,
                    'civil_id' => $helloHealthPatientData[0]->civil_id,
                    'file_id' => $helloHealthPatientData[0]->file_id,
                    'name' => $name
                ]);
            }
        }
        if ($patient) {
            return $patient->id;
        }
        return null;
    }
}
