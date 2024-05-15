<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilUsers;
use App\Models\Roles;
use App\Models\Statuts;
use App\Models\Habilitations;
use Illuminate\Support\Facades\Auth;
use DB;

class ProfilUsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
{
    try {
        $profilusers = ProfilUsers::with(['get_role', 'get_user', 'get_statut', 'get_habilitation'])->orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des profils récupérée avec succès',
            'data' => $profilusers,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Erreur lors de la récupération des profils',
            'message' => $e->getMessage(),
        ], 500);
    }
}


    public function create() {


     }

  /*   public function store(Request $request)
{

    try{

         // Validation des données
    $request->validate([
        'user_id' => 'required',
        'role_id' => 'required',
        'habilitation_id' => 'required|array',
        'habilitation_id.*' => 'exists:habilitations,id',
    ]);

    // Créer un nouvel utilisateur avec les détails fournis
    $user = Auth::user();
    $profilusers = new ProfilUsers();
    $profilusers->setAttribute('user_id', $request->user_id);
    $profilusers->setAttribute('role_id', $request->role_id);
    $profilusers->setAttribute("statut_id", 1);
    $profilusers->setAttribute('created_by', $user->id);
    $profilusers->setAttribute('updated_by', $user->id);
    $profilusers->setAttribute('created_at', new \DateTime());
    $profilusers->save();

    // Attacher les habilitations associées à l'utilisateur
    $profilusers->habilitations()->attach($request->habilitation_id);
    $success['status'] = true;
    $success['message'] = 'Enregistrement effectuée avec succès';
    $success['data'] = $profilusers;
    return response()->json($success, 200);


    }
    catch (\Exception $e) {
        $error['status'] = false;
        $error['error'] = 'Erreur lors de l\'enregistrement de objet !';
        $error['data'] = $e->getMessage();
        return response()->json($error, 500);
    }




}*/

    public function store(Request $request) {
        try {
            $this->validate($request, [
                'user_id' => 'required',
                'role_id' => 'required',
                'habilitation_id' => 'required|array',
                'habilitation_id.*' => 'distinct', // Assurez-vous que les habilitations sont uniques
            ]);

            // Récupération de l'utilisateur actuel
            $user = Auth::user();

            // Boucle sur chaque habilitation
            foreach ($request->habilitation_id as $habilitation) {
                // Création d'une nouvelle instance de ProfilUsers
                $profilUser = new ProfilUsers();
                $profilUser->user_id = $request->user_id;
                $profilUser->role_id = $request->role_id;
                $profilUser->habilitation_id = $habilitation;
                $profilUser->statut_id = 1; // Supposons que 1 signifie actif
                $profilUser->created_by = $user->id;
                $profilUser->updated_by = $user->id;
                $profilUser->created_at = now();
                $profilUser->save();
            }

            // Réponse de succès
            return response()->json([
                'status' => true,
                'message' => 'Enregistrements effectués avec succès',
                'data' => $profilUser,
            ], 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retournez un message d'erreur
            return response()->json([
                'status' => false,
                'error' => 'Erreur lors de l\'enregistrement des objets !',
                'data' => $e->getMessage(),
            ], 500);
        }
    }


        // get current user









     public function show(ProfilUsers $profiluser) { }

    public function edit($id) {

        //ici on récupere d'abord le profiluser à modifier par son id
        try{
            $profilUser = ProfilUsers::where('id', $id)->first();
            $success['status'] = true;
            $success['message'] = 'Succès !';
            $success['data'] = $profilUser;
            return response()->json($success, 200);

        }catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du rôle',
                'error' => $e->getMessage(),
            ], 500);
        }



    }

    public function update(Request $request, $id)
    {
        try {
            // Récupérer le profil utilisateur à mettre à jour
            $profilUser = ProfilUsers::find($id);

            // Vérifier si le profil utilisateur existe
            if (!$profilUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Profil utilisateur non trouvé',
                ], 404);
            }

            // Validation des données
            $request->validate([
                'user_id' => 'required',
                'role_id' => 'required',
                'habilitation_id' => 'required',
                'habilitation_id.*' => 'distinct',
            ]);


             // Récupération de l'utilisateur actuel
             $user = Auth::user();

            // Mettre à jour les habilitations
        foreach ($request->habilitation_id as $habilitation) {
            // Supprimer les habilitations existantes associées au profil utilisateur
            DB::table('profil_users')->where('habilitation_id', $habilitation)->delete();

            // Création d'une nouvelle instance de ProfilUsers
            $profilUser = new ProfilUsers();
            $profilUser->user_id = $request->user_id;
            $profilUser->role_id = $request->role_id;
            $profilUser->habilitation_id = $habilitation;
            $profilUser->statut_id = 1; // Supposons que 1 signifie actif
            $profilUser->created_by = $user->id;
            $profilUser->updated_by = $user->id;
            $profilUser->created_at = now();
            $profilUser->save();
        }
            // Réponse de succès
            return response()->json([
                'success' => true,
                'message' => 'Profil utilisateur mis à jour avec succès',
                'data' => $profilUser,
            ], 200);
        } catch (\Exception $e) {
            // En cas d'erreur, retournez un message d'erreur
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du profil utilisateur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function delete($id) {
        //logique de suppression
        try {
            // Suppression du rôle
            $profiluser = ProfilUsers::find($id);
            $profiluser->setAttribute("status_id", 2);
            $profiluser->delete();

            return response()->json([
                'success' => true,
                'message' => 'profil supprimé avec succès',
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur lors de la suppression du profil',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

}
