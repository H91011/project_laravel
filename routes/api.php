<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\APIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/{process}/{entity}', function (Request $request, $process, $entity) {
    $apicontroller = new APIController();
    return $apicontroller->postProcess($request, $process, $entity);
});
Route::get('/{process}/{entity}/{entityName?}', function ($process, $entity, $entityName= null) {
    $apicontroller = new APIController();
    return $apicontroller->getProcess($process, $entity, $entityName);
});
