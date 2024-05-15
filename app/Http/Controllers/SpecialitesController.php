<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Specialites;
use App\Models\Statuts;

class SpecialitesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $specialites = Specialites::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des rôles récupérée avec succès',
                'data' => $specialites,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des rôles',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'libelle' => 'required|unique:specialites,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $specialites = new Specialites();
            $specialites->setAttribute('libelle', $request->libelle);
            $specialites->setAttribute('description', $request->description);
            $specialites->setAttribute("statut_id", 1);
            $specialites->setAttribute('created_by', $user->id);
            $specialites->setAttribute('updated_by', $user->id);
            $specialites->setAttribute('created_at', new \DateTime());
            $specialites->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $specialites;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Specialites $role) { }

    public function edit($id) {

        //ici on récupere d'abord le role à modifier par son id
        $specialite = Specialites::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $specialite;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $spacialite = Specialites::find($id);

        // Vérifier si le rôle existe
        if (!$role) {
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
        $specialite->setAttribute('libelle', $request->libelle);
        $specialite->setAttribute('description', $request->description);

        $specialite->setAttribute('updated_by', $user->id);
        $specialite->setAttribute('updated_at', new \DateTime());
        $specialite->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $specialite,
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
            $specialite = Specialites::find($id);
            $specialite->setAttribute("status_id", 2);
            $specialite->delete();

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
