<?php

namespace App\Http\Controllers;

use App\Models\Jours;
use App\Models\Statuts;
use App\Models\Heures;
use App\Models\ProfilUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class AgendasController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $agendas = Agendas::with(['get_profil_user','get_heure','get_statut','get_jour'])->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des agendas récupérée avec succès',
                'data' => $agendas,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des agendas',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {


     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'heure_id' => 'required',
                'jour_id' => 'required',
                'profil_user_id' => 'required|unique:agendas,profil_user_id',
            ]);

            /*$profil_user = ProfilUsers::find($request->profil_user_id);
            if ($profil_user && $profil_user->role_id !== 4) {
                return response()->json([
                    'success' => false,
                    'error' => 'Le profil_user doit avoir le rôle_id 4 pour enregistrer cet agenda.',
                ], 400);
            }*/

            $profil_user=ProfilUsers::where($role_id=4);
            // get current user
            $user = Auth::user();
            $agendas = new Agendas();
            $agendas->setAttribute('heure_id', $request->heure_id);
            $agendas->setAttribute('jour_id', $request->jour_id);
            $agendas->setAttribute('jour_id', $request->jour_id);
            $agendas->setAttribute('profil_user_id', $request->$profil_user);
            $agendas->setAttribute("statut_id", 1);
            $agendas->setAttribute('created_by', $user->id);
            $agendas->setAttribute('updated_by', $user->id);
            $agendas->setAttribute('created_at', new \DateTime());
            $agendas->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $agendas;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Agendas $profiluser) { }

    public function edit($id) {

        //ici on récupere d'abord le profiluser à modifier par son id
        $profiluser = Agendas::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $agenda;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $profiluser = Agendas::find($id);

        // Vérifier si le rôle existe
        if (!$profiluser) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
            'habilitation_id' => 'required',
        ]);


        // Mise à jour du rôle
        $user = Auth::guard('api')->user();
        $agenda->setAttribute('heure_id', $request->heure_id);
        $agenda->setAttribute('jour_id', $request->jour_id);
        $agenda->setAttribute('profil_user_id', $request->profil_user_id);
        $agenda->setAttribute('updated_by', $user->id);
        $agenda->setAttribute('updated_at', new \DateTime());
        $agenda->update();

        return response()->json([
            'success' => true,
            'message' => 'agendas mis à jour avec succès',
            'data' => $agenda,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du agendas',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function delete($id) {
        //logique de suppression
        try {
            // Suppression du rôle
            $agenda = Agendas::find($id);
            $agenda->setAttribute("status_id", 2);
            $agenda->delete();

            return response()->json([
                'success' => true,
                'message' => 'agendas supprimé avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression du agendas',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

}


