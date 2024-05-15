<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;
use App\Models\Heures;

class HeuresController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $heures = Heures::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des heures récupérée avec succès',
                'data' => $heures,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des heures',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'heures' => 'required|unique:heures,heures'
            ]);
            // get current user
            $user = Auth::user();
            $heures = new Heures();
            $heures->setAttribute('heures', $request->heures);
            $heures->setAttribute("statut_id", 1);
            $heures->setAttribute('created_by', $user->id);
            $heures->setAttribute('updated_by', $user->id);
            $heures->setAttribute('created_at', new \DateTime());
            $heures->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $heures;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(heures $role) { }

    public function edit($id) {

        //ici on récupere d'abord l'heure à modifier par son id
        $heure = Heures::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $heure;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer l'heure à mettre à jour
        $heure = Heures::find($id);

        // Vérifier si l'heure existe
        if (!$heure) {
            return response()->json([
                'success' => false,
                'message' => 'heure non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'heure' => 'required',
        ]);

        // Mise à jour du heure
        $user = Auth::guard('api')->user();
        $heure->setAttribute('heures', $request->heures);
        $heure->setAttribute('updated_by', $user->id);
        $heure->setAttribute('updated_at', new \DateTime());
        $heure->update();

        return response()->json([
            'success' => true,
            'message' => 'heure mis à jour avec succès',
            'data' => $jour,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du heure',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function destroy($id) {
        //logique de suppression
        try {
            // Suppression du heure
            $heure = Heures::find($id);
            $heure->setAttribute("status_id", 2);
            $heure->delete();

            return response()->json([
                'success' => true,
                'message' => 'heure supprimé avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression du heure',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
