<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conseils_medicaux extends Model
{
    use HasFactory;
    protected $fillable = ['type', 'description', 'created_by', 'updated_by' ,'statut_id'];
}
