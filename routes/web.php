<?php

use App\Http\Controllers\RedesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(RedesController::class)->group(function () {
    Route::get('/direcciones/{clase?}/{cantidad?}', 'obtenerDirecciones');
    
    Route::get('/subneteo/{clase?}/{subredes?}', 'obtenerSubneteo');
});
