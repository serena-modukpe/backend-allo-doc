<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statuts;
use App\Models\Types_examens;
use Illuminate\Support\Facades\Auth;

class TypesExamensController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $types_examens = Types_examens::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des types_examens récupérée avec succès',
                'data' => $types_examens,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la récupération des types_examens',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function create() {

     }

    public function store(Request $request) {

        try {
            $this->validate($request, [
                'libelle' => 'required|unique:types_examens,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $types_examens = new Types_examens();
            $types_examens->setAttribute('libelle', $request->libelle);
            $types_examens->setAttribute('description', $request->description);
            $types_examens->setAttribute("statut_id", 1);
            $types_examens->setAttribute('created_by', $user->id);
            $types_examens->setAttribute('updated_by', $user->id);
            $types_examens->setAttribute('created_at', new \DateTime());
            $types_examens->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $types_examens;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Types_examens $type_examen) { }

    public function edit($id) {

        //ici on récupere d'abord le habili$habilitation à modifier par son id
        $type_examen = Types_examens::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $type_examen;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $type_examen = Types_examens::find($id);

        // Vérifier si le rôle existe
        if (!$type_examen) {
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
        $type_examen->setAttribute('libelle', $request->libelle);
        $type_examen->setAttribute('description', $request->description);

        $type_examen->setAttribute('updated_by', $user->id);
        $type_examen->setAttribute('updated_at', new \DateTime());
        $type_examen->update();

        return response()->json([
            'success' => true,
            'message' => 'Type_examen mis à jour avec succès',
            'data' => $type_examen,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du Type_examen',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function destroy($id) {
        //logique de suppression
        try {
            // Suppression du rôle
            $type_examen = Types_examens::find($id);
            $type_examen->setAttribute("status_id", 2);
            $type_examen->delete();

            return response()->json([
                'success' => true,
                'message' => 'type_examen supprimée avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression de type_examen',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
