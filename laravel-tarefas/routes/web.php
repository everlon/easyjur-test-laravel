<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\PermissaoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rota inicial do framework.
Route::get("/", function () {
    return view("welcome");
});

// Rotas para autenticação.
Auth::routes();

// Rota criada inicialmente
Route::get("/home", [AgendaController::class, "index"])->name("home");

// Rotas de permissões
Route::get("/permissoes", [PermissaoController::class, "index"])->name(
    "permissao"
);
Route::patch("/permissao/", [PermissaoController::class, "update"])->name(
    "update-permss"
);

// Rotas para exportação e downloads dos arquivos.
Route::get("/agenda/exportacao/{extensao}", [
    AgendaController::class,
    "exportacao",
])->name("exporta-excel");

// Rotas do CRUD das Tarefas.
Route::resource("/agenda", AgendaController::class);
