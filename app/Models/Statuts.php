<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statuts extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description'];
}
