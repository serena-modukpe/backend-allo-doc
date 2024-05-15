<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Statuts;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
        try {
            $roles = Roles::with(['get_statut'])->orderBy('id', 'desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Liste des rôles récupérée avec succès',
                'data' => $roles,
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
                'libelle' => 'required|unique:roles,libelle'
            ]);
            // get current user
            $user = Auth::user();
            $roles = new Roles();
            $roles->setAttribute('libelle', $request->libelle);
            $roles->setAttribute('description', $request->description);
            $roles->setAttribute("statut_id", 1);
            $roles->setAttribute('created_by', $user->id);
            $roles->setAttribute('updated_by', $user->id);
            $roles->setAttribute('created_at', new \DateTime());
            $roles->save();


            $success['status'] = true;
            $success['message'] = 'Enregistrement effectuée avec succès';
            $success['data'] = $roles;
            return response()->json($success, 200);

        } catch (\Exception $e) {
            $error['status'] = false;
            $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
            $error['data'] = $e->getMessage();
            return response()->json($error, 500);
        }



     }



     public function show(Roles $role) { }

    public function edit($id) {

        //ici on récupere d'abord le role à modifier par son id
        $role = Roles::where('id', $id)->first();
        $success['status'] = true;
        $success['message'] = 'Succès !';
        $success['data'] = $role;
        return response()->json($success, 200);


    }

    public function update(Request $request, $id)
{
    try {
        // Récupérer le rôle à mettre à jour
        $role = Roles::find($id);

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
        $role->setAttribute('libelle', $request->libelle);
        $role->setAttribute('description', $request->description);

        $role->setAttribute('updated_by', $user->id);
        $role->setAttribute('updated_at', new \DateTime());
        $role->update();

        return response()->json([
            'success' => true,
            'message' => 'Rôle mis à jour avec succès',
            'data' => $role,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du rôle',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    public function delete($id) {
        //logique de suppression
        try {
            // Suppression du rôle
            $role = Roles::find($id);
            $role->setAttribute("status_id", 2);
            $role->delete();

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
