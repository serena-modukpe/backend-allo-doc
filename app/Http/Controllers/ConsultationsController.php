<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultations;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;

class ConsultationsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $consultations = Consultations::orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des rôles récupérée avec succès',
                'data' => $consultations,
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
                'libelle' => 'required|unique:consultations,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $consultations = new Consultations();
            $consultations->setAttribute('libelle', $request->libelle);
            $consultations->setAttribute('description', $request->description);
            $consultations->setAttribute('cout', $request->cout);
            $consultations->setAttribute("statut_id", 1);
            $consultations->setAttribute('created_by', $user->id);
            $consultations->setAttribute('updated_by', $user->id);
            $consultations->setAttribute('created_at', new \DateTime());
            $consultations->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $consultations;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Consultations $consultation) { }

    public function edit($id) {

        //ici on récupere d'abord le consultation à modifier par son id
        $consultation = Consultations::find($id);
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $consultation;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $consultation = Consultations::find($id);

        // Vérifier si le rôle existe
        if (!$consultation) {
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
        $consultation->setAttribute('libelle', $request->libelle);
        $consultation->setAttribute('description', $request->description);
        $consultations->setAttribute('cout', $request->cout);
        $consultation->setAttribute('updated_by', $user->id);
        $consultation->setAttribute('updated_at', new \DateTime());
        $consultation->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $consultation,
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
            $consultation = Consultations::find($id);
            $consultation->setAttribute("status_id", 2);
            $consultation->delete();

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
