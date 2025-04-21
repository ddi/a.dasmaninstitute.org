<?php

namespace App\Actions\HelloHealthData;

use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class ConsentFormData
{
    private Patient $patient;
    public function get(Patient $patient)
    {
        $this->patient = $patient;
        // echo "<pre>";
        // print_r($this->getConsentFormData());
        // exit;
        return $this->getConsentFormData();
    }

    private function getConsentFormData()
    {
        $phoneAndEmail = $this->getPhoneAndEmail();
        $patientData = $this->getPatientData();
        if (!$phoneAndEmail || !$patientData) {
            return false;
        }
        return array_merge($phoneAndEmail, $patientData);
    }

    private function getPhoneAndEmail()
    {
        $sql = "SELECT T1.FileId,
                    MAX(CASE WHEN telecomTypeId = 1 THEN PhoneNumbers END) AS home,
                    MAX(CASE WHEN telecomTypeId = 7 THEN PhoneNumbers END) AS mobile,
                    MAX(CASE WHEN telecomTypeId = 8 THEN PhoneNumbers END) AS work,
                    T2.Email AS email,
                    T3.relatedPersonName AS emergencyContactName,
                    T3.relation AS emergencyContactRelation,
                    T3.RPhoneNumber AS emergencyContactPhoneNumber,
                    T4.relatedPersonName AS nextOfKinName,
                    T4.relation AS nextOfKinRelation,
                    T4.RPhoneNumber AS nextOfKinPhoneNumber
                FROM
                (SELECT p.personId AS PatientId,
                        pi.identifier AS FileId,
                        t.phoneNumberClean AS PhoneNumbers,
                        tt.name,
                        t.telecomTypeId
                FROM persons p
                JOIN personidentifiers pi ON p.personId = pi.personId
                JOIN persontelecoms pt ON p.personId = pt.personId
                JOIN telecoms t ON pt.telecomId = t.telecomId
                JOIN telecomtypes tt ON t.telecomTypeId = tt.telecomTypeId
                WHERE t.telecomTypeId IN ('1', '7', '8')
                    AND pi.deletedFlag = 0
                    AND p.isTestPerson = 0
                    AND pi.clinicId = 2
                    AND t.phoneNumberClean IS NOT NULL
                    AND p.isDeceased = 0
                    AND pi.identifierTypeId = 15) T1
                LEFT OUTER JOIN
                (SELECT p.personId AS PatientId, t.value AS Email
                FROM persons p
                JOIN persontelecoms pt ON p.personId = pt.personId
                JOIN telecoms t ON pt.telecomId = t.telecomId
                JOIN telecomtypes tt ON t.telecomTypeId = tt.telecomTypeId
                WHERE t.telecomTypeId = 2
                    AND p.isTestPerson = 0
                    AND p.isDeceased = 0 ) T2 ON T1.PatientId = T2.PatientId
                LEFT OUTER JOIN
                (SELECT p.personId AS PatientId,
                        rp.relatedToPersonId AS rpId,
                        rpInfo.personId AS relatedPersonId,
                        CONCAT(rpInfo.firstname, ' ', rpInfo.lastname) AS relatedPersonName,
                        rp.relation,
                        rp.isEmergencyContact,
                        rp.isNextOfKin,
                        t.phoneNumberClean AS RPhoneNumber
                FROM persons p
                JOIN relatedpersons rp ON p.personId = rp.patientId
                JOIN persons rpInfo ON rp.relatedToPersonId = rpInfo.personId
                JOIN persontelecoms pt ON rpInfo.personId = pt.personId
                JOIN telecoms t ON pt.telecomId = t.telecomId
                WHERE rp.isEmergencyContact = 1) T3 ON T1.PatientId = T3.PatientId
                LEFT OUTER JOIN
                (SELECT p.personId AS PatientId,
                        rp.relatedToPersonId AS rpId,
                        rpInfo.personId AS relatedPersonId,
                        CONCAT(rpInfo.firstname, ' ', rpInfo.lastname) AS relatedPersonName,
                        rp.relation,
                        rp.isEmergencyContact,
                        rp.isNextOfKin,
                        t.phoneNumberClean AS RPhoneNumber
                FROM persons p
                JOIN relatedpersons rp ON p.personId = rp.patientId
                JOIN persons rpInfo ON rp.relatedToPersonId = rpInfo.personId
                JOIN persontelecoms pt ON rpInfo.personId = pt.personId
                JOIN telecoms t ON pt.telecomId = t.telecomId
                WHERE rp.isNextOfKin = 1 ) T4 ON T1.PatientId = T4.PatientId
                WHERE fileId = " . $this->patient->file_id;

        $patientsData = DB::connection('hellohealth')->select($sql);
        if (empty($patientsData)) {
            return false;
        }
        return (array)$patientsData[0];
    }

    private function getPatientData()
    {
        $sql = "SELECT 
                    fileID, civilID, `status`, `prefix`, patientName, arabicName, firstName, middleName, lastName,
                    arabicFirstName, arabicMiddleName, arabicLastName, age, DOB, gender, maritalStatus,
                    maritalStatusInArabic, bloodType, nationality, Primarylanguage, secondaryLanguage, countryAddress, 
                    address, address2, city, state, stateAbbreviation, zipCode
                FROM
                (SELECT 
                        p.personId, pid.identifier AS fileID, pid2.identifier AS civilID,
                        pt.`status` AS `status`, `prefix` AS `prefix`,
                        concat(p.firstname, ' ', p.middleName, ' ', p.lastname) AS patientName,
                        concat(pnl.firstname, ' ', pnl.middleName, ' ', pnl.lastname) AS arabicName,
                        pnl.firstname AS arabicFirstName,
                        pnl.middleName AS arabicMiddleName,
                        pnl.lastname AS arabicLastName,
                        p.firstname AS firstName,
                        p.middleName AS middleName,
                        p.lastname AS lastName,
                        TIMESTAMPDIFF(YEAR, p.birthDate, CURDATE()) AS age,
                        p.birthDate AS DOB,
                                    CASE
                                        WHEN p.gender = 1 THEN 'Female'
                                        WHEN p.gender = 2 THEN 'Male'
                                        ELSE 'Not Specified'
                                    END AS gender,
                                    p.maritalStatus AS maritalStatus,
                                    CASE
                                        WHEN p.maritalStatus like 'MARRIED'
                                            AND p.gender = 1 THEN 'متزوجة'
                                        WHEN p.maritalStatus like 'MARRIED'
                                            AND p.gender = 2 THEN 'متزوج'
                                        WHEN p.maritalStatus like 'DIVORCED'
                                            AND p.gender = 1 THEN 'مطلقة'
                                        WHEN p.maritalStatus like 'DIVORCED'
                                            AND p.gender = 2 THEN 'مطلق'
                                        WHEN p.maritalStatus like 'SINGLE'
                                            AND p.gender = 1 THEN 'عزباء'
                                        WHEN p.maritalStatus like 'SINGLE'
                                            AND p.gender = 2 THEN 'أعزب'
                                        WHEN p.maritalStatus like 'WIDOWED' THEN 'أرملة'
                                        WHEN p.maritalStatus like 'Law Partner' THEN 'شريك قانوني'
                                        ELSE 'غير مذكور'
                                    END AS maritalStatusInArabic,
                                    CASE
                                        WHEN p.bloodType like 'AB_NEG' THEN 'AB-'
                                        WHEN p.bloodType like 'AB_POS' THEN 'AB+'
                                        WHEN p.bloodType like 'A_NEG' THEN 'A-'
                                        WHEN p.bloodType like 'A_POS' THEN 'A+'
                                        WHEN p.bloodType like 'B_NEG' THEN 'B-'
                                        WHEN p.bloodType like 'B_POS' THEN 'B+'
                                        WHEN p.bloodType like 'O_NEG' THEN 'O-'
                                        WHEN p.bloodType like 'O_POS' THEN 'O+'
                                        ELSE 'UNKNOWN'
                                    END AS bloodType,
                                    n3.name AS nationality,
                                    l.name AS Primarylanguage,
                                    countryName AS countryAddress,
                                    address AS address,
                                    address2 AS address2,
                                    city AS city,
                                    stateName AS state,
                                    stateAbbr AS stateAbbreviation,
                                    zip AS zipCode
                FROM persons p
                JOIN patients pt ON p.personId = pt.patientId
                JOIN personnamelocales pnl ON p.personId = pnl.personId
                JOIN personidentifiers pid ON p.personId = pid.personId
                JOIN personidentifiers pid2 ON p.personid = pid2.personId
                JOIN personaddresses pa ON pt.patientId = pa.personId
                JOIN addresses a ON pa.addressId = a.addressId
                JOIN states s ON a.stateId = s.stateId
                JOIN countries c ON s.countryId = c.countryId
                JOIN personnationalities pn ON pn.personId = p.personId
                JOIN nationalities n3 ON pn.nationalityId = n3.nationalityId
                JOIN personlanguages plang ON p.personId = plang.personId
                JOIN languages l ON plang.languageId = l.languageId
                WHERE p.isTestPerson = 0
                    AND p.persontype = 'PATIENT'
                    AND p.isDeceased = 0
                    AND plang.isPreferred = 1
                    AND pid.identifierTypeId = 15
                    AND pid.deletedFlag = 0
                    AND pid.clinicId = 2
                    AND pid2.identifierTypeId = 10
                    AND pid2.deletedFlag = 0
                    AND pid.identifier = " . $this->patient->file_id . "
                ORDER BY fileID) X
                LEFT OUTER JOIN
                (SELECT personId,
                        `name` AS secondaryLanguage
                FROM personlanguages plang
                JOIN languages l ON plang.languageId = l.languageId
                WHERE plang.isPreferred = 0) Y ON X.personId = Y.personId;";
        $patientsData = DB::connection('hellohealth')->select($sql);
        if (empty($patientsData)) {
            return false;
        }
        return (array)$patientsData[0];
    }
}
