<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'url',
        'description',
        'icon',
    ];
}
