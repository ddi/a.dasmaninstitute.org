<?php

namespace App\Models\Publications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicationAuthor extends Model
{
    use HasFactory;
    protected $table = 'pub_publication_authors';
}
