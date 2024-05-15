<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuts;
use App\Models\Habilitations;
use Illuminate\Support\Facades\Auth;

class HabilitationsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $habilitations = Habilitations::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des habilitations récupérée avec succès',
                'data' => $habilitations,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des habilitations',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'libelle' => 'required|unique:habilitations,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $habilitations = new Habilitations();
            $habilitations->setAttribute('libelle', $request->libelle);
            $habilitations->setAttribute('description', $request->description);
            $habilitations->setAttribute("statut_id", 1);
            $habilitations->setAttribute('created_by', $user->id);
            $habilitations->setAttribute('updated_by', $user->id);
            $habilitations->setAttribute('created_at', new \DateTime());
            $habilitations->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $habilitations;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Habilitations $habilitation) { }

    public function edit($id) {

        //ici on récupere d'abord le habili$habilitation à modifier par son id
        $habilitation = Habilitations::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $habilitation;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $habilitation = Habilitations::find($id);

        // Vérifier si le rôle existe
        if (!$habilitation) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'libelle' => 'required',
        ]);

        // Mise à jour du rôle
        $user = Auth::guard('api')->user();
        $habilitation->setAttribute('libelle', $request->libelle);
        $habilitation->setAttribute('description', $request->description);

        $habilitation->setAttribute('updated_by', $user->id);
        $habilitation->setAttribute('updated_at', new \DateTime());
        $habilitation->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $habilitation,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du rôle',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function destroy($id) {
        //logique de suppression
        try {
            // Suppression du rôle
            $habilitation = Habilitations::find($id);
            $habilitation->setAttribute("status_id", 2);
            $habilitation->delete();

            return response()->json([
                'success' => true,
                'message' => 'habilitation supprimée avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression de habilitation',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

}
