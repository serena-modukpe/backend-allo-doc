<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description','created_by', 'updated_by' ,'statut_id'];


    public function get_statut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }

}
