<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendas extends Model
{
    use HasFactory;

    public function get_profil_user(){
        return $this->belongsTo(ProfilUsers::class, 'profil_user_id');
    }

    public function get_heure(){
        return $this->belongsTo(Heures::class, 'heure_id');
    }

    public function get_jour(){
        return $this->belongsTo(Jours::class, 'jour_id');
    }

    public function get_statut()
    {
        return $this->belongsTo(Statuts::class, 'statut_id');
    }
}
