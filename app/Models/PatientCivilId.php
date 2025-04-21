<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientCivilId extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'civil_id',
        'passport',
        'arabic_name_1', 'arabic_name_2', 'arabic_name_3', 'arabic_name_4', 'arabic_name_full',
        'english_name_1', 'english_name_2', 'english_name_3', 'english_name_4', 'english_name_full',
        'title',
        'birthdate',
        'sex_arabic', 'sex_english',
        'blood_type',
        'nationality_arabic', 'nationality_english',
        'e_mail_address',
        'address_unique_key', 'district', 'block_number', 'street_name', 'building_plot_number',
        'floor_number', 'unit_number', 'unit_type',
        'telephone_1', 'telephone_2',
        'guardian_civil_id',
        'card_expiry_date', 'card_issue_date', 'card_serial_number',
        'additional_f_1', 'additional_f_2',
        'moi_reference', 'moi_reference_indic',
        'document_number',
    ];
}
