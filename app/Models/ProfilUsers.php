<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilUsers extends Model
{
    use HasFactory;
    public $table='profil_users';

    protected $fillable = ['user_id','role_id','habilitation_id','created_by', 'updated_by' ,'statut_id'];


    public function get_role(){
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function get_user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function get_statut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }

    public function get_habilitation()
    {
        return $this->belongsTo(Habilitations::class, 'habilitation_id');
    }

    /*protected $casts = [
        'habilitation_id' => 'array'
    ];
    */
    /*public function setHabilitationAttribute($value)
    {
        $this->attributes['habilitation_id'] = json_encode($value);
    }

    /**
     * Get the categories
     *

    public function getHabilitationAttribute($value)
    {
        return $this->attributes['habilitation_id'] = json_decode($value);
    } */
}
