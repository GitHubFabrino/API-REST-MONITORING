<?php

use App\Http\Controllers\Api\PredictionController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParcController;
use App\Http\Controllers\Api\BatterieController;
use App\Http\Controllers\Api\LectureController;
use App\Http\Controllers\Api\ParametreBatterieController;
use App\Http\Controllers\Api\TypeMontageController;
use App\Http\Controllers\Api\SystemeParametreController;
use App\Http\Controllers\Api\GraviterController;
use App\Http\Controllers\Api\TypeAlerteController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\AlerteGlobalController;
use App\Http\Controllers\Api\NiveauAnterioriteController;
use App\Http\Controllers\Api\HistoriqueMesureController;
use App\Http\Controllers\Api\HistoriqueMesureSystemeController;
use App\Http\Controllers\Api\MaintenanceController;
use App\Http\Controllers\Api\TypeMaintenanceController;
use App\Http\Controllers\Api\MaintenancesTypeMaintenanceController;
use App\Http\Controllers\Api\AlerteBatterieController;
use App\Http\Controllers\Api\LectureGlobalController;
use App\Http\Controllers\Api\ChargeController;

use App\Http\Controllers\Api\MqttController;

Route::get('/authors', [AuthorController::class, 'index']);
Route::post('/authors', [AuthorController::class, 'store']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::put('/authors/{id}', [AuthorController::class, 'update']);
Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);

Route::apiResource('products', ProductController::class);

// Route::apiResource('files', FileController::class);
Route::apiResource('files', FileController::class);
Route::post('parcs/{parcId}/upload', [ParcController::class, 'uploadFile']);




Route::get('/parcs', [ParcController::class, 'index']);
Route::post('/parcs', [ParcController::class, 'store']);
Route::get('/parcs/{id}', [ParcController::class, 'show']);
Route::get('/parcs/user/{id}', [ParcController::class, 'getParcsByUser']);
Route::put('/parcs/{id}', [ParcController::class, 'update']);
Route::delete('/parcs/{id}', [ParcController::class, 'destroy']);



Route::get('/batterie/parc/{idparc}', [BatterieController::class, 'getBatteriesByParcId']);

Route::get('/batterie', [BatterieController::class, 'index']);
Route::post('/batterie', [BatterieController::class, 'store']);
Route::get('/batterie/{id}', [BatterieController::class, 'show']);
Route::put('/batterie/{id}', [BatterieController::class, 'update']);
Route::delete('/batterie/{id}', [BatterieController::class, 'destroy']);

Route::get('/lecture', [LectureController::class, 'index']);
Route::post('/lecture', [LectureController::class, 'store']);
Route::get('/lecture/{id}', [LectureController::class, 'show']);
Route::put('/lecture/{id}', [LectureController::class, 'update']);
Route::get('/lecture/{id}/batterie', [LectureController::class, 'getByBatterieId']);

Route::get('/lecture/parc/{idparc}', [LectureController::class, 'getLectureByParcId']);




Route::get('/parametres-batteries', [ParametreBatterieController::class, 'index']);
Route::post('/parametres-batteries', [ParametreBatterieController::class, 'store']);
Route::get('/parametres-batteries/{id}', [ParametreBatterieController::class, 'show']);
Route::put('/parametres-batteries/{id}', [ParametreBatterieController::class, 'update']);
Route::delete('/parametres-batteries/{id}', [ParametreBatterieController::class, 'destroy']);

Route::get('/contacts', [ContactController::class, 'index']);
Route::get('/contacts/{id}', [ContactController::class, 'show']);
Route::post('/contacts', [ContactController::class, 'store']);
Route::put('/contacts/{id}', [ContactController::class, 'update']);
Route::delete('/contacts/{id}', [ContactController::class, 'destroy']);
Route::get('/contacts/parc/{parc_id}', [ContactController::class, 'getByParcId']);

Route::get('/graviters', [GraviterController::class, 'index']);
Route::post('/graviters', [GraviterController::class, 'store']);
Route::get('/graviters/{id}', [GraviterController::class, 'show']);
Route::put('/graviters/{id}', [GraviterController::class, 'update']);
Route::delete('/graviters/{id}', [GraviterController::class, 'destroy']);

Route::get('/type-alertes', [TypeAlerteController::class, 'index']);
Route::post('/type-alertes', [TypeAlerteController::class, 'store']);
Route::get('/type-alertes/{id}', [TypeAlerteController::class, 'show']);
Route::put('/type-alertes/{id}', [TypeAlerteController::class, 'update']);
Route::delete('/type-alertes/{id}', [TypeAlerteController::class, 'destroy']);

Route::get('/alerte-globals', [AlerteGlobalController::class, 'index']);
Route::post('/alerte-globals', [AlerteGlobalController::class, 'store']);
Route::get('/alerte-globals/{id}', [AlerteGlobalController::class, 'show']);
Route::put('/alerte-globals/{id}', [AlerteGlobalController::class, 'update']);
Route::delete('/alerte-globals/{id}', [AlerteGlobalController::class, 'destroy']);

Route::get('/type-montages', [TypeMontageController::class, 'index']);
Route::post('/type-montages', [TypeMontageController::class, 'store']);
Route::get('/type-montages/{id}', [TypeMontageController::class, 'show']);
Route::put('/type-montages/{id}', [TypeMontageController::class, 'update']);
Route::delete('/type-montages/{id}', [TypeMontageController::class, 'destroy']);

Route::get('/systeme-parametres', [SystemeParametreController::class, 'index']);
Route::post('/systeme-parametres', [SystemeParametreController::class, 'store']);
Route::get('/systeme-parametres/{id}', [SystemeParametreController::class, 'show']);
Route::put('/systeme-parametres/{id}', [SystemeParametreController::class, 'update']);
Route::delete('/systeme-parametres/{id}', [SystemeParametreController::class, 'destroy']);

Route::get('/niveau-anteriorites', [NiveauAnterioriteController::class, 'index']);
Route::post('/niveau-anteriorites', [NiveauAnterioriteController::class, 'store']);
Route::get('/niveau-anteriorites/{id}', [NiveauAnterioriteController::class, 'show']);
Route::put('/niveau-anteriorites/{id}', [NiveauAnterioriteController::class, 'update']);
Route::delete('/niveau-anteriorites/{id}', [NiveauAnterioriteController::class, 'destroy']);

Route::get('/historique-mesures', [HistoriqueMesureController::class, 'index']);
Route::post('/historique-mesures', [HistoriqueMesureController::class, 'store']);
Route::get('/historique-mesures/{id}', [HistoriqueMesureController::class, 'show']);
Route::put('/historique-mesures/{id}', [HistoriqueMesureController::class, 'update']);
Route::delete('/historique-mesures/{id}', [HistoriqueMesureController::class, 'destroy']);

Route::get('/historique_mesures_systeme', [HistoriqueMesureSystemeController::class, 'index']);
Route::get('/historique_mesures_systeme/{id}', [HistoriqueMesureSystemeController::class, 'show']);
Route::post('/historique_mesures_systeme', [HistoriqueMesureSystemeController::class, 'store']);
Route::put('/historique_mesures_systeme/{id}', [HistoriqueMesureSystemeController::class, 'update']);
Route::delete('/historique_mesures_systeme/{id}', [HistoriqueMesureSystemeController::class, 'destroy']);

Route::get('/maintenances/batterie/{id}', [MaintenanceController::class, 'getMaintenancesByBatterie']);

Route::get('/maintenances', [MaintenanceController::class, 'index']);
Route::get('/maintenances/{id}', [MaintenanceController::class, 'show']);
Route::post('/maintenances', [MaintenanceController::class, 'store']);
Route::put('/maintenances/{id}', [MaintenanceController::class, 'update']);
Route::delete('/maintenances/{id}', [MaintenanceController::class, 'destroy']);

Route::get('/type-maintenance', [TypeMaintenanceController::class, 'index']);
Route::get('/type-maintenance/{id}', [TypeMaintenanceController::class, 'show']);
Route::post('/type-maintenance', [TypeMaintenanceController::class, 'store']);
Route::put('/type-maintenance/{id}', [TypeMaintenanceController::class, 'update']);
Route::delete('/type-maintenance/{id}', [TypeMaintenanceController::class, 'destroy']);

Route::get('maintenances-type-maintenance', [MaintenancesTypeMaintenanceController::class, 'index']);
Route::get('maintenances-type-maintenance/{id}', [MaintenancesTypeMaintenanceController::class, 'show']);
Route::post('maintenances-type-maintenance', [MaintenancesTypeMaintenanceController::class, 'store']);
Route::put('maintenances-type-maintenance/{id}', [MaintenancesTypeMaintenanceController::class, 'update']);
Route::delete('maintenances-type-maintenance/{id}', [MaintenancesTypeMaintenanceController::class, 'destroy']);

Route::get('alerte-batteries', [AlerteBatterieController::class, 'index']);
Route::get('alerte-batteries/{id}', [AlerteBatterieController::class, 'show']);
Route::post('alerte-batteries', [AlerteBatterieController::class, 'store']);
Route::put('alerte-batteries/{id}', [AlerteBatterieController::class, 'update']);
Route::delete('alerte-batteries/{id}', [AlerteBatterieController::class, 'destroy']);

Route::get('alerte-batteries/batterie/{id}', [AlerteBatterieController::class, 'getAlerteByBatterieId']);
Route::get('alerte-batteries/parc/{id}', [AlerteBatterieController::class, 'getAlerteByParcId']);




Route::get('lecture-globals', [LectureGlobalController::class, 'index']);
Route::get('lecture-globals/{id}', [LectureGlobalController::class, 'show']);
Route::post('lecture-globals', [LectureGlobalController::class, 'store']);
Route::put('lecture-globals/{id}', [LectureGlobalController::class, 'update']);
Route::delete('lecture-globals/{id}', [LectureGlobalController::class, 'destroy']);

Route::get('charges', [ChargeController::class, 'index']);
Route::get('charges/{id}', [ChargeController::class, 'show']);
Route::post('charges', [ChargeController::class, 'store']);
Route::put('charges/{id}', [ChargeController::class, 'update']);
Route::delete('charges/{id}', [ChargeController::class, 'destroy']);

Route::apiResource('admins', AdminController::class);   // Sin pas de JWT
Route::apiResource('roles', RoleController::class);

Route::post('admins/{adminId}/roles', [AdminController::class, 'attachRole']);
Route::post('roles/{roleId}/attach-admin', [RoleController::class, 'attachAdmin']);
Route::delete('admins/{adminId}/roles/{roleId}', [AdminController::class, 'detachRole']);
Route::get('admins/{adminId}/roles', [AdminController::class, 'getUserRoles']);
Route::get('roles/{roleId}/admins', [RoleController::class, 'getRoleUsers']);

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::middleware('auth:api')->group(function () {
    Route::get('profil', [AuthController::class, 'profil']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('user/{id}', [AuthController::class, 'update']);
    // Route::apiResource('admins', AdminController::class);    // Si avec JWT

});



Route::post('/mqtt/publish', [MqttController::class, 'publishMessage']);
Route::post('/mqtt/subscribe', [MqttController::class, 'subscribeToTopic']);

Route::post('/predict', [PredictionController::class, 'predict']);

