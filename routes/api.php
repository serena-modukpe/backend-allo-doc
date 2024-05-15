<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatutsController;
use App\Http\Controllers\SpecialitesController;
use App\Http\Controllers\HabilitationsController;
use App\Http\Controllers\TypesExamensController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\HeuresController;
use App\Http\Controllers\ProfilUsersController;
use App\Http\Controllers\JoursController;
use App\Http\Controllers\AgendasController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(
    [
        'prefix' => 'v01/web',
    ],
    function(){
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);

    });
Route::group(

    [
        'prefix' => 'v01/web',


    ],

    function()
    {
        Route::get('roles/index', [RolesController::class, 'index']);
        Route::post('roles/store', [RolesController::class, 'store']);
        Route::get('roles/{id}/edit', [RolesController::class, 'edit']);
        Route::put('roles/{id}/update', [RolesController::class, 'update']);
        Route::delete('roles/{id}/delete', [RolesController::class, 'delete']);
    }
);*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/refresh', [AuthController::class, 'refresh']);


Route::group(


        [
            'prefix' => 'v01/web',
            'middleware' => ['auth:api']
        ],
        function () {



         Route::get('listeUsers',[AuthController::class,'listeUsers']);
            //Déconnexion
         Route::post('logout',[AuthController::class,'logout']);

        //Routes pour les roles

        Route::get('roles/index', [RolesController::class, 'index']);
        Route::post('roles/store', [RolesController::class, 'store']);
        Route::get('roles/{id}/edit', [RolesController::class, 'edit']);
        Route::put('roles/{id}/update', [RolesController::class, 'update']);
        Route::delete('roles/{id}/delete', [RolesController::class, 'delete']);

        //Routes pour les statuts

        Route::get('statuts/index', [StatutsController::class, 'index']);
        Route::post('statuts/store', [StatutsController::class, 'store']);
        Route::get('statuts/{id}/edit', [StatutsController::class, 'edit']);
        Route::put('statuts/{id}/update', [StatutsController::class, 'update']);
        Route::delete('statuts/{id}/delete', [StatutsController::class, 'delete']);

        //Routes pour les spécialités

        Route::get('specialites/index', [SpecialitesController::class, 'index']);
        Route::post('specialites/store', [SpecialitesController::class, 'store']);
        Route::get('specialites/{id}/edit', [SpecialitesController::class, 'edit']);
        Route::put('specialites/{id}/update', [SpecialitesController::class, 'update']);
        Route::delete('specialites/{id}/delete', [SpecialitesController::class, 'delete']);

        //Routes pour les habilitations

        Route::get('habilitations/index', [HabilitationsController::class, 'index']);
        Route::post('habilitations/store', [HabilitationsController::class, 'store']);
        Route::get('habilitations/{id}/edit', [HabilitationsController::class, 'edit']);
        Route::put('habilitations/{id}/update', [HabilitationsController::class, 'update']);
        Route::delete('habilitations/{id}/delete', [HabilitationsController::class, 'delete']);

        //Routes pour les types-examens

        Route::get('types_examens/index', [TypesExamensController::class, 'index']);
        Route::post('types_examens/store', [TypesExamensController::class, 'store']);
        Route::get('types_examens/{id}/edit', [TypesExamensController::class, 'edit']);
        Route::put('types_examens/{id}/update', [TypesExamensController::class, 'update']);
        Route::delete('types_examens/{id}/delete', [TypesExamensController::class, 'delete']);

        //Routes pour les consultations

        Route::get('consultations/index', [ConsultationsController::class, 'index']);
        Route::post('consultations/store', [ConsultationsController::class, 'store']);
        Route::get('consultations/{id}/edit', [ConsultationsController::class, 'edit']);
        Route::put('consultations/{id}/update', [ConsultationsController::class, 'update']);
        Route::delete('consultations/{id}/delete', [ConsultationsController::class, 'delete']);

         //Routes pour les consultations

         Route::get('jours/index', [joursController::class, 'index']);
         Route::post('jours/store', [joursController::class, 'store']);
         Route::get('jours/{id}/edit', [joursController::class, 'edit']);
         Route::put('jours/{id}/update', [joursController::class, 'update']);
         Route::delete('jours/{id}/delete', [joursController::class, 'delete']);


         //Routes pour les consultations

         Route::get('heures/index', [HeuresController::class, 'index']);
         Route::post('heures/store', [HeuresController::class, 'store']);
         Route::get('heures/{id}/edit', [HeuresController::class, 'edit']);
         Route::put('heures/{id}/update', [HeuresController::class, 'update']);
         Route::delete('heures/{id}/delete', [HeuresController::class, 'delete']);


         //Routes pour les Profils

         Route::get('profils/index', [ProfilUsersController::class, 'index']);
         Route::post('profils/store', [ProfilUsersController::class, 'store']);
         Route::get('profils/{id}/edit', [ProfilUsersController::class, 'edit']);
         Route::put('profils/{id}/update', [ProfilUsersController::class, 'update']);
         Route::delete('profils/{id}/delete', [ProfilUsersController::class, 'delete']);


          //Routes pour les agendas

          Route::get('agendas/index', [AgendasController::class, 'index']);
          Route::post('agendas/store', [AgendasController::class, 'store']);
          Route::get('agendas/{id}/edit', [AgendasController::class, 'edit']);
          Route::put('agendas/{id}/update', [AgendasController::class, 'update']);
          Route::delete('agendas/{id}/delete', [AgendasController::class, 'delete']);


    }
);
