<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialites extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description','created_by', 'updated_by' ,'statut_id'];
}
