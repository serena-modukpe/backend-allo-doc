<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jours extends Model
{
    use HasFactory;
    protected $fillable = ['jours','created_by', 'updated_by' ,'statut_id'];
}
