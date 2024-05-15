<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;
use App\Models\Conseils_medicaux;

class ConseilsMedicauxController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $conseils_medicaux = Conseils_medicaux::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des conseils médicaux récupérés avec succès',
                'data' => $conseils_medicaux,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des conseils médicaux',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'type' => 'required|unique:conseils_medicaux,type'
            ]);
            // get current user
            $user = Auth::user();
            $conseils_medicaux = new Conseils_medicaux();
            $conseils_medicaux->setAttribute('type', $request->type);
            $conseils_medicaux->setAttribute('description', $request->description);
            $conseils_medicaux->setAttribute("statut_id", 1);
            $conseils_medicaux->setAttribute('created_by', $user->id);
            $conseils_medicaux->setAttribute('updated_by', $user->id);
            $conseils_medicaux->setAttribute('created_at', new \DateTime());
            $conseils_medicaux->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $conseils_medicaux;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Conseils_medicaux $conseil_medical) { }

    public function edit($id) {

        //ici on récupere d'abord le conse$conseil_medical à modifier par son id
        $conseil_medical = Conseils_medicaux::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $conseil_medical;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $conseil_medical = Conseils_medicaux::find($id);

        // Vérifier si le rôle existe
        if (!$conseil_medical) {
            return response()->json([
                'success' => false,
                'message' => 'Rôle non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'type' => 'required',
        ]);

        // Mise à jour du rôle
        $user = Auth::guard('api')->user();
        $conseil_medical->setAttribute('type', $request->type);
        $conseil_medical->setAttribute('description', $request->description);

        $conseil_medical->setAttribute('updated_by', $user->id);
        $conseil_medical->setAttribute('updated_at', new \DateTime());
        $conseil_medical->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $conseil_medical,
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
            $conseil_medical = Conseils_medicaux::find($id);
            $conseil_medical->setAttribute("status_id", 2);
            $conseil_medical->delete();

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
