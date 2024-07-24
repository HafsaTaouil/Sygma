<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\MarqueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModelesPiecesPartsController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    if (Auth::check()) {
        return view('dashboard');
    } else {
        return view('auth.login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dossiers', [DashboardController::class, 'dossiers'])->name('dossiers');


    Route::get('/add/dossier', [DashboardController::class, 'addDossierIndex'])->name('add.dossier');
    Route::get('/search', [DashboardController::class, 'SearchIndex']);
    Route::post('/add', [DashboardController::class, 'store'])->name('dossier.store');


    Route::get('/etapes', [DashboardController::class, 'etapes'])->name('etapes');
    Route::post('/etapes/add', [DashboardController::class, 'createEtape'])->name('create.etape');
    Route::post('/etapes/order', [DashboardController::class, 'orderEtape'])->name('create.order');

    Route::get('/details/{id}', [DashboardController::class, 'details'])->name('show.details');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/marques', [MarqueController::class, 'index'])->name('marques.index');
    Route::get('marques/{id}/modeles', [MarqueController::class, 'showModeles'])->name('marques.modeles');
    Route::post('/marques', [MarqueController::class, 'store'])->name('marques.store');

    Route::get('/pieces', [PieceController::class, 'index'])->name('pieces.index');
    //form piece 
    Route::get('/piece/add-to-model', [PieceController::class, 'showAddToModelForm'])->name('piece.add-to-model');
    Route::post('/piece/store-model', [PieceController::class, 'storeModelPiece'])->name('piece.store-model');

    Route::get('/add/pieces', [PieceController::class, 'assignPieceToModelePart'])->name('pieces.assign');
    Route::post('/pieces', [PieceController::class, 'store'])->name('pieces.store');
    Route::put('/pieces/{piece}', [PieceController::class, 'update'])->name('pieces.update');
    Route::delete('/pieces/{piece}', [PieceController::class, 'destroy'])->name('pieces.destroy');


    Route::post('/all/store', [ModelesPiecesPartsController::class, 'store'])->name('all.store');

    Route::get('/parts/{partId}/modele/{modeleId}/hasPieces', [ModelesPiecesPartsController::class, 'hasPieces']);

    Route::get('/marque/modeles/{name}', [MarqueController::class, 'getModelesByName']);

});



require __DIR__ . '/auth.php';
