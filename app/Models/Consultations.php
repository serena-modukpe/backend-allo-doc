<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultations extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description', 'cout','created_by', 'updated_by' ,'statut_id'];
}
