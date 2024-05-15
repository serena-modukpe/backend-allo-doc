<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;

class StatutsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $statuts = Statuts::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des statutss récupérée avec succès',
                'data' => $statuts,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des statutss',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'libelle' => 'required|unique:statuts,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $statuts = new Statuts();
            $statuts->setAttribute('libelle', $request->libelle);
            $statuts->setAttribute('description', $request->description);
            $statuts->setAttribute('created_at', new \DateTime());
            $statuts->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $statuts;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Statuts $statut) { }

    public function edit($id) {

        //ici on récupere d'abord le statu à modifier par son id
        $statut = statuts::find($id);
        $success['statuts'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $statut;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le statuts à mettre à jour
        $statut = statuts::find($id);

        // Vérifier si le statuts existe
        if (!$statut) {
            return response()->json([
                'success' => false,
                'message' => 'statuts non trouvé',
            ], 404);
        }

        // Validation des données
        $request->validate([
            'libelle' => 'required',
        ]);

        // Mise à jour du statuts
        $user = Auth::guard('api')->user();
        $statut->setAttribute('libelle', $request->libelle);
        $statut->setAttribute('description', $request->description);
        $statut->setAttribute('updated_at', new \DateTime());
        $statut->update();

        return response()->json([
            'success' => true,
            'message' => 'statuts mis à jour avec succès',
            'data' => $statut,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du statuts',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function destroy($id) {
        //logique de suppression
        try {
            // Suppression du statuts
            $statut = Statuts::find($id);
            $statut->delete();

            return response()->json([
                'success' => true,
                'message' => 'status supprimé avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression du status',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
