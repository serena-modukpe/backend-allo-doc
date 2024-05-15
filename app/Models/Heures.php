<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heures extends Model
{
    use HasFactory;
    protected $fillable = ['heures', 'created_by', 'updated_by' ,'statut_id'];
}
