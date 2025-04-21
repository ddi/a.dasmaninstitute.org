<?php

namespace App\Http\Controllers;

use App\Actions\HelloHealthData\ConsentFormData;
use App\Models\Patient;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF as PDF;

class PatientsController extends Controller
{
    private $patientData;

    private $pdf;

    private $pdfTextArray;
    private $fieldTitleFont;
    private $fieldContentsFont;

    public function forms()
    {
        $calibriFontPath = getcwd() . "/assets/fonts/calibrib.ttf";

        $fieldTitleFont = \TCPDF_FONTS::addTTFfont($calibriFontPath, 'TrueTypeUnicode', '', 32);

        $normalFontSize = 30;

        PDF::AddPage();
        PDF::setRTL(false);
        PDF::SetFont($fieldTitleFont, '', $normalFontSize);
        PDF::Text(0, 0, "data");

        PDF::setRTL(true);
        PDF::SetFont($fieldTitleFont, '', $normalFontSize);
        PDF::Text(0, 0, "عربي");
        //PDF::Write(0, 'Hello World');
        PDF::Output('consentform.pdf', 'I');

        // PDF::SetTitle('Hello World');
        // PDF::AddPage();
        // PDF::Write(0, 'Hello World');
        // PDF::Output('hello_world.pdf');
        //return view('patient.forms');
    }

    public function consentForm(Patient $patient)
    {
        $cfd = new ConsentFormData($patient);
        $this->patientData = $cfd->get($patient);
        //$this->pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
        PDF::setPrintHeader(false);
        PDF::setPrintFooter(false);

        $calibriFontPath = getcwd() . "/assets/fonts/calibrib.ttf";
        $this->fieldTitleFont = \TCPDF_FONTS::addTTFfont($calibriFontPath, 'TrueTypeUnicode', '', 32);

        $calibriFontPath = getcwd() . "/assets/fonts/calibri.ttf";
        $this->fieldContentsFont = \TCPDF_FONTS::addTTFfont($calibriFontPath, 'TrueTypeUnicode', '', 32);

        $ddiLogo = getcwd() . "/images/ddi-logo-transparent.png";

        $x = 15;
        $y = 5;

        $logoHeight = 25;

        $page1BoxXa = $x;
        $page1BoxYa = $y + $logoHeight + 2;
        $page1BoxXd = $page1BoxXa + 180;
        $page1BoxBorderThickness = 0.4;

        $page1BoxBottomLineOffset = 6;

        $page1EnglishTextX = $page1BoxXa + 2;
        $page1EnglishTextY = $page1BoxYa + 2;

        $page1ArabicTextX = 32 - $x;

        $normalFontSize = 12.2;
        $regularRowSpacing = 7.7;
        $enValueOffsetX = $page1EnglishTextX + 34;
        $arValueOffsetX = $page1ArabicTextX + 28;

        $titleBoxWidth = 90;

        $page2ConsentTextX = $page1BoxXa + 2;
        $page2ConsentTextY = $page1BoxYa + 3;
        $consentTextRowSpacing = 3.4;

        // page 1

        $page1EnglishTextY = $page1BoxYa + 2;
        PDF::AddPage();
        PDF::setRTL(false);
        PDF::Image($ddiLogo, $x, $y, 0, $logoHeight, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $rows = $this->getRowsArray();
        foreach ($rows as $row) {
            PDF::setTextColor(70, 35, 40, 100);
            if (array_key_exists("type", $row)) {
                if ($row["type"] == "last") {
                    PDF::Line(
                        $page1BoxXa,
                        $page1BoxYa,
                        $page1BoxXa,
                        $page1EnglishTextY + $page1BoxBottomLineOffset,
                        ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
                    );
                    PDF::Line(
                        $page1BoxXa,
                        $page1EnglishTextY + $page1BoxBottomLineOffset,
                        $page1BoxXd,
                        $page1EnglishTextY + $page1BoxBottomLineOffset,
                        ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
                    );
                    PDF::Line(
                        $page1BoxXd,
                        $page1EnglishTextY + $page1BoxBottomLineOffset,
                        $page1BoxXd,
                        $page1BoxYa,
                        ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
                    );
                    PDF::Line(
                        $page1BoxXd,
                        $page1BoxYa,
                        $page1BoxXa,
                        $page1BoxYa,
                        ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
                    );



                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                    PDF::Text($page1EnglishTextX, $page1EnglishTextY, $row['en_title']);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                    PDF::Text($enValueOffsetX, $page1EnglishTextY, array_key_exists("en_data", $row) ? $row['en_data'] : "");
                    PDF::setRTL(true);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                    PDF::Text($page1ArabicTextX, $page1EnglishTextY, $row['ar_title']);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                    PDF::Text($arValueOffsetX, $page1EnglishTextY, array_key_exists("ar_data", $row) ? $row['ar_data'] : "");
                } elseif ($row["type"] == "header") {
                    PDF::Rect(
                        $page1EnglishTextX - 2,
                        $page1EnglishTextY - .7,
                        $page1BoxXd - $x,
                        6,
                        'DF',
                        ['L' => 0, 'T' => 0, 'R' => 0, 'B' => 0],
                        array(100, 10, 0, 0)
                    );
                    PDF::setTextColor(0, 0, 0, 0);
                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                    PDF::Text($page1EnglishTextX, $page1EnglishTextY, $row['en_title']);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                    PDF::Text($enValueOffsetX, $page1EnglishTextY, array_key_exists("en_data", $row) ? $row['en_data'] : "");
                    PDF::setRTL(true);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                    PDF::Text($page1ArabicTextX, $page1EnglishTextY, $row['ar_title']);
                } elseif ($row["type"] == "small") {
                    $offset = 0;
                    if (array_key_exists("yOffset", $row)) {
                        $offset = $row["yOffset"];
                    }

                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize - 2.3);
                    PDF::setTextColor(70, 35, 40, 100);
                    PDF::Text($page1EnglishTextX - 3, $page1EnglishTextY - $offset, $row['en_title']);

                    PDF::setRTL(true);
                    PDF::setTextColor(70, 35, 40, 100);
                    PDF::Text($page1ArabicTextX - 3, $page1EnglishTextY - $offset, $row['ar_title']);
                    $page1EnglishTextY -= $offset;
                }
            } else {
                PDF::setRTL(false);
                PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                PDF::Text($page1EnglishTextX, $page1EnglishTextY, $row['en_title']);
                PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                PDF::Text($enValueOffsetX, $page1EnglishTextY, array_key_exists("en_data", $row) ? $row['en_data'] : "");
                PDF::setRTL(true);
                PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
                PDF::Text($page1ArabicTextX, $page1EnglishTextY, $row['ar_title']);
                PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                PDF::Text($arValueOffsetX, $page1EnglishTextY, array_key_exists("ar_data", $row) ? $row['ar_data'] : "");
            }

            $page1EnglishTextY += $regularRowSpacing;
        }

        PDF::Rect(
            $page1BoxXd - $titleBoxWidth,
            $y + 10,
            $titleBoxWidth,
            13,
            'DF',
            ['L' => 0, 'T' => 0, 'R' => 0, 'B' => 0],
            array(96, 89, 4, 0)
        );
        PDF::setTextColor(0, 0, 0, 0);
        PDF::setRTL(false);
        PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
        PDF::Text($page1BoxXd - $titleBoxWidth + 20, $y + 11, "PERSONAL INFORMATION");
        PDF::setTextColor(0, 0, 0, 0);
        PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
        PDF::Text($page1BoxXd - $titleBoxWidth + 30, $y + 16, "معلومات شخصية");

        // end page 1




        // page 2

        PDF::AddPage();
        PDF::Image($ddiLogo, $x, $y, 0, $logoHeight, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

        PDF::Rect(
            $page1BoxXd - $titleBoxWidth,
            $y + 10,
            $titleBoxWidth,
            13,
            'DF',
            ['L' => 0, 'T' => 0, 'R' => 0, 'B' => 0],
            array(96, 89, 4, 0)
        );
        PDF::setTextColor(0, 0, 0, 0);
        PDF::setRTL(false);
        PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
        PDF::Text($page1BoxXd - $titleBoxWidth + 2, $y + 11, "CONSENT FOR GENERAL MEDICAL TREATMENT");
        PDF::setTextColor(0, 0, 0, 0);
        PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
        PDF::Text($page1BoxXd - $titleBoxWidth + 16, $y + 16, "موافقة خطية على الرعاية الطبية العامة");

        $rows = $this->getConsentTextArray();
        foreach ($rows as $row) {
            if (!array_key_exists("type", $row)) {
                PDF::setTextColor(70, 35, 40, 100);
                PDF::setRTL(false);
                PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 3);
                PDF::Text($page2ConsentTextX, $page2ConsentTextY, "(" . $row['number'] . ")");
                PDF::setRTL(true);
                PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 3);
                PDF::Text($page2ConsentTextX, $page2ConsentTextY, "(" . $row['number'] . ")");
                foreach ($row['text'] as $text) {
                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 2);
                    PDF::setFontSpacing(-.1);
                    PDF::Text($page1EnglishTextX + 5, $page2ConsentTextY, $text['en']);
                    PDF::setRTL(true);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 3);
                    PDF::setFontSpacing(.1);
                    PDF::Text($page1EnglishTextX + 5, $page2ConsentTextY, $text['ar']);
                    $page2ConsentTextY += $consentTextRowSpacing;
                }
                $page2ConsentTextY += $consentTextRowSpacing - 1;
            } else {
                if ($row['type'] == "header") {
                    PDF::Rect(
                        $page1EnglishTextX - 2,
                        $page2ConsentTextY,
                        $page1BoxXd - $x,
                        6,
                        'DF',
                        ['L' => 0, 'T' => 0, 'R' => 0, 'B' => 0],
                        array(100, 10, 0, 0)
                    );
                    PDF::setTextColor(0, 0, 0, 0);
                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldTitleFont, '', $normalFontSize - 3);
                    PDF::setFontSpacing(-.25);
                    PDF::Text($page2ConsentTextX - 2, $page2ConsentTextY + 1, $row['en_text']);
                    //PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
                    //PDF::Text($enValueOffsetX, $page1EnglishTextY, array_key_exists("en_data", $row)? $row['en_data'] : "");
                    PDF::setRTL(true);
                    // PDF::SetFont($this->fieldTitleFont, '', $normalFontSize-1);
                    PDF::setFontSpacing(.2);
                    PDF::Text($page2ConsentTextX - 2, $page2ConsentTextY + 1, $row['ar_text']);
                    $page2ConsentTextY += $consentTextRowSpacing + 5;
                } elseif ($row['type'] == "infosection") {
                    PDF::setTextColor(70, 35, 40, 100);
                    PDF::setRTL(false);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 3);
                    PDF::Text($page2ConsentTextX, $page2ConsentTextY, $row['en_text']);
                    PDF::setRTL(true);
                    PDF::SetFont($this->fieldContentsFont, '', $normalFontSize - 3);
                    PDF::Text($page2ConsentTextX, $page2ConsentTextY, $row['ar_text']);
                    $page2ConsentTextY += $regularRowSpacing - 2;
                }
            }


            // PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
            // PDF::Text($enValueOffsetX, $page1EnglishTextY, array_key_exists("en_data", $row)? $row['en_data'] : "");
            // PDF::setRTL(true);
            // PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
            // PDF::Text($page1ArabicTextX, $page1EnglishTextY, $row['ar_title']);
            // PDF::SetFont($this->fieldContentsFont, '', $normalFontSize);
            // PDF::Text($arValueOffsetX, $page1EnglishTextY, array_key_exists("ar_data", $row)? $row['ar_data'] : "");
            // PDF::setRTL(false);
            // PDF::setTextColor(70, 35, 40, 100);
            // PDF::SetFont($this->fieldTitleFont, '', $normalFontSize);
            // PDF::Text(100, 100+ $rowNumber, $row['en_text']);
            // $rowNumber += 5;

        }


        PDF::Line(
            $page1BoxXa,
            $page1BoxYa,
            $page1BoxXa,
            $page2ConsentTextY,
            ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
        );

        $centerXOffset = ($page1BoxXd - $page1BoxXa) / 2;

        PDF::Line(
            $page1BoxXa + $centerXOffset,
            $page1BoxYa,
            $page1BoxXa + $centerXOffset,
            $page2ConsentTextY,
            ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
        );

        PDF::Line(
            $page1BoxXa,
            $page2ConsentTextY/*+$page1BoxBottomLineOffset*/,
            $page1BoxXd,
            $page2ConsentTextY/*+$page1BoxBottomLineOffset*/,
            ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
        );

        PDF::Line(
            $page1BoxXd,
            $page2ConsentTextY,
            $page1BoxXd,
            $page1BoxYa,
            ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
        );

        PDF::Line(
            $page1BoxXd,
            $page1BoxYa,
            $page1BoxXa,
            $page1BoxYa,
            ['width' => $page1BoxBorderThickness, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]
        );

        // end page 2








        /*
        PDF::Line($aX+$offSetRectX2, $aY, $bX+$offSetRectX2, $bY+$offSetRectY2, 
        ['width' => 0.1, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]);
        PDF::Line($bX+$offSetRectX2,$bY+$offSetRectY2, $dX+$offSetRectX2+$box2Extention, $bY+$offSetRectY2, 
        ['width' => 0.1, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]);
        PDF::Line($dX+$offSetRectX2+$box2Extention, $bY+$offSetRectY2, $dX+$offSetRectX2+$box2Extention, $aY, 
        ['width' => 0.1, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]);
        PDF::Line($dX+$offSetRectX2+$box2Extention, $aY, $aX+$offSetRectX2, $aY, 
        ['width' => 0.1, 'cap' => 'square', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 10, 0, 0)]);
        

        $rows = $this->getConsentTextArray();
        foreach($rows as $row)
        {
            PDF::setRTL(false);
            PDF::SetFont($this->fieldContentsFont, '', 6.2);
            PDF::Text($xConsentEnBox-4, $yConsentEnBox, "(".$row['number'].")");
            PDF::MultiCell($consentBoxWidth, 0, $row['en_text'], 0, 'L', 0, 1, $xConsentEnBox, $yConsentEnBox, true);
            PDF::MultiCell($consentBoxWidth, 0, $row['ar_text'], 0, 'R', 0, 1, $xConsentEnBox+$consentBoxWidth+$consentBoxVierticalSpacing, $yConsentEnBox, true);
            $yConsentEnBox += $row['yOffSet'];
        }
        */


        PDF::Output('consentform.pdf', 'I');
    }

    private function getRowsArray()
    {
        $gendersArabicArray["Male"] = "ذكر";
        $gendersArabicArray["Female"] = "أنثى";

        $rows = [];
        $rows[] = [
            "en_title" => "Civil ID #:",
            "ar_title" => "البطاقة المدنية:",
            "en_data" => $this->patientData['civilID'],
            "ar_data" => $this->patientData['civilID'],
        ];
        $rows[] = [
            "en_title" => "File ID #:",
            "ar_title" => "رقم الملف:",
            "en_data" => $this->patientData['fileID'],
            "ar_data" => $this->patientData['fileID'],
        ];
        $rows[] = [
            "en_title" => "First Name:",
            "ar_title" => "الإسم الأول:",
            "en_data" => $this->patientData['firstName'],
            "ar_data" => $this->patientData['arabicFirstName'],
        ];
        $rows[] = [
            "en_title" => "Middle Name:",
            "ar_title" => "الإسم الأوسط:",
            "en_data" => $this->patientData['middleName'],
            "ar_data" => $this->patientData['arabicMiddleName'],
        ];
        $rows[] = [
            "en_title" => "Last Name:",
            "ar_title" => "الإسم الأخير:",
            "en_data" => $this->patientData['lastName'],
            "ar_data" => $this->patientData['arabicLastName'],
        ];
        $rows[] = [
            "en_title" => "Gender:",
            "ar_title" => "الجنس:",
            "en_data" => $this->patientData['gender'],
            "ar_data" => $gendersArabicArray[$this->patientData['gender']],
        ];
        $rows[] = [
            "en_title" => "Marital Status:",
            "ar_title" => "الحالة الاجتماعية:",
            "en_data" => $this->patientData['maritalStatus'],
            "ar_data" => $this->patientData['maritalStatusInArabic'],
        ];
        $rows[] = [
            "en_title" => "Blood Type:",
            "ar_title" => "فصيلة الدم:",
            "en_data" =>  $this->patientData['bloodType'],
            "ar_data" =>  $this->patientData['bloodType'],
        ];
        $rows[] = [
            "en_title" => "Nationality:",
            "ar_title" => "الجنسية:",
            "en_data" => $this->patientData['nationality'],
            "ar_data" => $this->patientData['nationality'],
        ];
        $rows[] = [
            "en_title" => "Date of Birth:",
            "ar_title" => "تاريخ الميلاد:",
            "en_data" => $this->patientData['DOB'],
            "ar_data" => $this->patientData['DOB'],
        ];
        $rows[] = [
            "en_title" => "Primary Language:",
            "ar_title" => "اللغة الأساسية:",
            "en_data" => $this->patientData['Primarylanguage'],
            "ar_data" => $this->patientData['Primarylanguage'],
        ];

        $rows[] = [
            "en_title" => "Other languages:",
            "ar_title" => "لغات اخرى",
            "en_data" => $this->patientData['secondaryLanguage'],
            "ar_data" => $this->patientData['secondaryLanguage'],
        ];
        $rows[] = [
            "en_title" => "CONTACT INFORMATION",
            "ar_title" => "معلومات العنوان و التواصل",
            "type" => "header",
        ];
        $rows[] = [
            "en_title" => "Address 1:",
            "ar_title" => "",
            "en_data" => $this->patientData['address'],
            "ar_data" => "",
        ];
        $rows[] = [
            "en_title" => "Address 2:",
            "ar_title" => "",
            "en_data" => $this->patientData['city'] . " - " . $this->patientData['state'],
            "ar_data" => "",
        ];
        $rows[] = [
            "en_title" => "City:",
            "ar_title" => "",
            "en_data" => $this->patientData['city'],
            "ar_data" => "",
        ];
        $rows[] = [
            "en_title" => "State:",
            "ar_title" => "",
            "en_data" => $this->patientData['state'],
            "ar_data" => "",
        ];

        $phoneNumbers = $this->patientData['mobile'];
        $phoneNumbers = ($this->patientData['home']) ? $phoneNumbers . " - " . $this->patientData['home'] : $phoneNumbers;
        $phoneNumbers = ($this->patientData['work']) ? $phoneNumbers . " - " . $this->patientData['work'] : $phoneNumbers;

        $rows[] = [
            "en_title" => "Phone:",
            "ar_title" => "",
            "en_data" => $phoneNumbers, //$this->patientData['mobile'], 
            "ar_data" => ""
        ];
        $rows[] = [
            "en_title" => "Email:",
            "ar_title" => "",
            "en_data" => $this->patientData['email'],
            "ar_data" => "",
        ];
        $rows[] = [
            "type" => "header",
            "en_title" => "CONTACT INFORMATION (NEXT OF KIN)",
            "ar_title" => "معلومات اقرب شخص"
        ];
        $rows[] = [
            "en_title" => "Name:",
            "ar_title" => "الاسم:",
            "en_data" => $this->patientData['nextOfKinName'],
            "ar_data" => $this->patientData['nextOfKinName'],
        ];
        $rows[] = [
            "en_title" => "Relationship:",
            "ar_title" => "صلة القرابه:",
            "en_data" => $this->patientData['nextOfKinRelation'],
            "ar_data" => $this->patientData['nextOfKinRelation'],
        ];
        $rows[] = [
            "en_title" => "Telephone:",
            "ar_title" => "الهاتف:",
            "en_data" => $this->patientData['nextOfKinPhoneNumber'],
            "ar_data" => $this->patientData['nextOfKinPhoneNumber'],
        ];
        $rows[] = [
            "type" => "header",
            "en_title" => "EMERGENCY CONTACT",
            "ar_title" => "معلومات التواصل في حالة الطوارئ"
        ];
        $rows[] = [
            "en_title" => "Name:",
            "ar_title" => "الاسم:",
            "en_data" => $this->patientData['emergencyContactName'],
            "ar_data" => $this->patientData['emergencyContactName'],
        ];
        $rows[] = [
            "en_title" => "Relationship:",
            "ar_title" => "صلة القرابه:",
            "en_data" => $this->patientData['emergencyContactRelation'],
            "ar_data" => $this->patientData['emergencyContactRelation'],
        ];
        $rows[] = [
            "en_title" => "Telephone:",
            "ar_title" => "الهاتف:",
            "en_data" => $this->patientData['emergencyContactPhoneNumber'],
            "ar_data" => $this->patientData['emergencyContactPhoneNumber'],
            "type" => "last",
        ];
        $rows[] = [
            "en_title" => "I hereby certify that the information submitted here is true and correct.",
            "ar_title" => "أقر بصحة المعلومات التى قمت بتزويدها في هذا النموذج",
            "type" => "small"
        ];
        $rows[] = [
            "en_title" => "This consent form is valid for 1 year and I am obliged to update my ",
            "ar_title" => "هذا النموذج صالح لمدة عام واحد وأنا ملزم بتحديث",
            "type" => "small",
        ];
        $rows[] = [
            "en_title" => "information on an annual basis.",
            "ar_title" => "معلوماتي سنوياً.",
            "type" => "small",
            "yOffset" => "3"
        ];
        $rows[] = [
            "en_title" => "Signature:",
            "ar_title" => "التوقيع:",
            "type" => "small",
        ];
        $rows[] = [
            "en_title" => "Date:",
            "ar_title" => "التاريخ:",
            "type" => "small",
        ];

        return $rows;
    }


    private function getConsentTextArray()
    {
        $rows = [];
        $rows[] = [
            "number" => "1",
            "text" => [
                [
                    "en" => "I the undersigned, understand that my medical care at ",
                    "ar" => "أدرك أنا، الموقع  أدناه، أن  الرعاية  الطبية  التي يقدمها  لي معهد "
                ],
                [
                    "en" => "Dasman Diabetes Institute (DDI) will require the perfo-",
                    "ar" => "دسمان للسكري  ستتطلب  الخضوع  لفحوصات  طبية  اعتيادية "
                ],
                [
                    "en" => "rmance of standard medical examinations, laboratory ",
                    "ar" => "و فحوصات مخبرية و علاجات و إجراءات جراحية، سيتم تقريرها "
                ],
                [
                    "en" => "investigations, treatments, and operative procedures,",
                    "ar" => "و تنفيذها من قبل أطباء وممرضات وغيرهم من أخصائيي الرعاية "
                ],
                [
                    "en" => "which  will  be ordered  and  performed  by  physicians,",
                    "ar" => "الطبية  في معهد  دسمان للسكري. و بموجب توقيعي  على  هذه "
                ],
                [
                    "en" => "nurses, and other healthcare providers at Dasman Di-",
                    "ar" => "الوثيقة، أوافق على كافة الإجراءات الطبية الاعتيادية، كما أوافق "
                ],
                [
                    "en" => "abetes Institute. I hereby give my informed consent for ",
                    "ar" => "على الفحوصات أو العلاجات أو الإجراءات الجراحية الأخرى التي "
                ],
                [
                    "en" => "all standard medical procedures. I also consent for alt-",
                    "ar" => "يرى الأطباء المشرفين على حالتي ضرورة القيام بها فوراً."
                ],
                [
                    "en" => "ernative inquiries, treatments or operative procedures ",
                    "ar" => ""
                ],
                [
                    "en" => "that are  immediately  necessary in  the opinion of my ",
                    "ar" => ""
                ],
                [
                    "en" => "attending physicians.",
                    "ar" => ""
                ],
            ]
        ];

        $rows[] = [
            "number" => "2",
            "text" => [
                [
                    "en" => "I  understand  that  the  nature, anticipated  outcome, ",
                    "ar" => "أدرك  أن الأطباء  المشرفين  على  حالتي  سيشرحون  لي  طبيعة "
                ],
                [
                    "en" => "potential risks, and available alternatives of special pr-",
                    "ar" => "الاجراءات  الخاصة  و النتائج المرجوة  منها ومخاطرها  المحتملة "
                ],
                [
                    "en" => "ocedures  and  treatments  will be  explained to me by ",
                    "ar" => "والعلاجات وبدائلها."
                ],
                [
                    "en" => "the attending physicians.",
                    "ar" => ""
                ],
            ]
        ];

        $rows[] = [
            "number" => "3",
            "text" => [
                [
                    "en" => "I was made aware that I can retract my consent at any",
                    "ar" => "تم إبلاغي أنه بامكاني سحب موافقتي في أي وقت، وفي هذه الحالة "
                ],
                [
                    "en" => "given time, which will result in transfer of my care out",
                    "ar" => "سيتم نقل رعايتي الطبية لمركز / مستشفى آخر غير معهد دسمان "
                ],
                [
                    "en" => "of DDI.",
                    "ar" => "للسكري."
                ],
            ]
        ];

        $rows[] = [
            "number" => "4",
            "text" => [
                [
                    "en" => "I understand that all information recorded in my med-",
                    "ar" => "و أدرك أن  المعلومات الواردة  في سجلي  الطبي ستبقى سرية تامة، "
                ],
                [
                    "en" => "ical record will remain confidential  to  the  extent  per-",
                    "ar" => "بالقدر الذي تسمح به قوانين دولة الكويت، وأن الأشخاص المخولين "
                ],
                [
                    "en" => "mitted by the laws of the State of Kuwait; only author-",
                    "ar" => "فقط، يمكنكم  الإطلاع على سجلي  الطبي، كما  أدرك أن المعلومات "
                ],
                [
                    "en" => "ized  people  will  have  access  to  my  record. I further ",
                    "ar" => "الخاصة بحالتي الصحية سيتم تخزينها ضمن قواعد بيانات و سجلات "
                ],
                [
                    "en" => "understand that my health information will. be stored ",
                    "ar" => "الكترونية، سيتم  استخدامها لأغراض  وضع خطط الرعاية الصحية، "
                ],
                [
                    "en" => "in electronic  databases  and  registries and  that those ",
                    "ar" => "و كذلك لأغراض بحثية أخرى."
                ],
                [
                    "en" => "registries will be used for healthcare planning and res-",
                    "ar" => ""
                ],
                [
                    "en" => "earch purposes.   ",
                    "ar" => ""
                ],
            ]
        ];

        $rows[] = [
            "number" => "5",
            "text" => [
                [
                    "en" => "Cancellation  and  rescheduling   of  the  appointments ",
                    "ar" => "يتعين على المريض  الحرص على  عدم  المبالغة  في إلغاء المواعيد "
                ],
                [
                    "en" => "must not be very frequent. Cancellations must be repo-",
                    "ar" => "أو إعادة جدولتها، و في كلا الحالتين يجب الإبلاغ قبل 24 ساعة على "
                ],
                [
                    "en" => "rted at least 24 hours in advance during official working ",
                    "ar" => "الأقل، وذلك خلال ساعات العمل من 7:30 صباحاً وحتى 3:00 مساءاً"
                ],
                [
                    "en" => "hours  from 7:30 am  –  3:00 pm. Two  consecutive ",
                    "ar" => "،“عدم الحضور” لمرتين متتاليتين أو ثلاث مرات متفرقة خلال عام "
                ],
                [
                    "en" => "“NO SHOW”  or Three  “NO SHOW” in a  year will result ",
                    "ar" => "يؤدي إلى إيقاف الملف الطبي لدى معهد دسمان للسكري"
                ],
                [
                    "en" => "in suspension of medical care and closure of the ",
                    "ar" => ""
                ],
                [
                    "en" => "medical file.",
                    "ar" => ""
                ],

            ]
        ];

        $rows[] = [
            "number" => "6",
            "text" => [
                [
                    "en" => "I understand  that I  might be  eligible for  enrolment in ",
                    "ar" => "أدرك أنني قد أكون مؤهلا للمشاركة في دراسات بحثية مستقبلية، "
                ],
                [
                    "en" => "research studies and researchers from  DDI may  like to ",
                    "ar" => "و أن باحثين  من معهد  دسمان للسكري  قد يقومون  بالاتصال بي "
                ],
                [
                    "en" => "contact  me for my  willingness and consent to particip-",
                    "ar" => "للحصول على موافقتي على المشاركة في تلك الدراسات."
                ],
                [
                    "en" => "ate in those studies ",
                    "ar" => ""
                ],
            ]
        ];

        $rows[] = [
            "number" => "7",
            "text" => [
                [
                    "en" => "By signing this document, I further testify to have read ",
                    "ar" => "إن توقيعي على هذه الوثيقة هو إقرار مني بأني قد قرأت واستوعبت "
                ],
                [
                    "en" => "and understood information  provided in  the  Patients ",
                    "ar" => "المعلومات  التي وردت  في الكتيب  الخاص  بالمرضى،  وفي  وثيقة "
                ],
                [
                    "en" => "Booklet including the Patients’ Bill of Rights, Responsibi-",
                    "ar" => "حقوق و واجبات المرضى، وفي وثيقة سياسة المواعيد."
                ],
                [
                    "en" => "lities, and Appointment Policy.",
                    "ar" => ""
                ],
            ]
        ];

        $rows[] = [
            "type" => "header",
            "en_text" => "PATIENT SIGNATURE",
            "ar_text" => "توقيع المراجع",
            "yOffSet" => "10",
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Signature:",
            "ar_text" => "التوقيع:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "",
            "ar_text" => ""
        ];

        $rows[] = [
            "type" => "header",
            "en_text" => "FOR PATIENTS WHO ARE MINORS/INCAPACITATED/COGNITIVELY IMPAIRED",
            "ar_text" => "في حال كان المراجع قاصر أو عاجز أو ضعيف الإدراك",
            "yOffSet" => "10",
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Name:",
            "ar_text" => "الإسم:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Civil ID:",
            "ar_text" => "رقم البطاقة المدنية:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Signature:",
            "ar_text" => "التوقيع:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Relationship:",
            "ar_text" => "صلة القرابة:"
        ];

        $rows[] = [
            "type" => "header",
            "en_text" => "STAFF MEMBER TAKING THE CONSENT",
            "ar_text" => "الموظف القائم على استلام نموذج الموافقة",
            "yOffSet" => "10",
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Name:",
            "ar_text" => "الإسم:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Employee ID Number:",
            "ar_text" => "الرقم الوظيفي:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Signature:",
            "ar_text" => "التوقيع:"
        ];

        $rows[] = [
            "type" => "infosection",
            "en_text" => "Date:",
            "ar_text" => "التاريخ:"
        ];
        return $rows;
    }
}
