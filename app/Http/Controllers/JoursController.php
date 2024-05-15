<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jours;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;

class JoursController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $jours = Jours::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des jours récupérée avec succès',
                'data' => $jours,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des jours',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'jours' => 'required|unique:jours,jours'
            ]);
            // get current user
            $user = Auth::user();
            $jours = new Jours();
            $jours->setAttribute('jours', $request->jours);
            $jours->setAttribute("statut_id", 1);
            $jours->setAttribute('created_by', $user->id);
            $jours->setAttribute('updated_by', $user->id);
            $jours->setAttribute('created_at', new \DateTime());
            $jours->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $jours;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(jours $role) { }

    public function edit($id) {

        //ici on récupere d'abord le role à modifier par son id
        $jour = Jours::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $jour;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $jour = Jours::find($id);

        // Vérifier si le rôle existe
        if (!$jour) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'jours' => 'required',
        ]);

        // Mise à jour du rôle
        $user = Auth::user();
        $jour->setAttribute('jours', $request->jours);
        $jour->setAttribute('updated_by', $user->id);
        $jour->setAttribute('updated_at', new \DateTime());
        $jour->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $jour,
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
            $jour = Jours::find($id);
            $jour->setAttribute("status_id", 2);
            $jour->delete();

            return response()->json([
                'success' => true,
                'message' => 'Rôle supprimé avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression du rôle',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
