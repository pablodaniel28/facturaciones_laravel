<?php

use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\UsuarioHorarioController;
use App\Http\Controllers\verificarController;
use App\Models\Asistencia;
use App\Models\producto;
use App\Models\Services;

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

Route::redirect('/', '/dashboard');



Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route for the getting the data feed
    Route::get('/json-data-feed', [DataFeedController::class, 'getDataFeed'])->name('json_data_feed');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    route::resource('usuarios', UsuariosController::class);
    route::resource('services', ServicesController::class);

    Route::get('productos/pdf', [ProductoController::class, 'exportPdf'])->name('productos.pdf');
    Route::post('productos/import', [ProductoController::class, 'import'])->name('productos.import');
    Route::get('productos/export', [ProductoController::class, 'export'])->name('productos.export');
    route::resource('productos', ProductoController::class);



    route::resource('clientes', ClienteController::class);










    Route::get('/dashboard/analytics', [DashboardController::class, 'analytics'])->name('analytics');
    Route::get('/dashboard/fintech', [DashboardController::class, 'fintech'])->name('fintech');


    Route::fallback(function () {
        return view('pages/utility/404');
    });
});
