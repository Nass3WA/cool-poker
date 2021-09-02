<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OldUserController;

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

//Affichage de la Homepage
Route::get('/', [HomeController::class, 'home'])->name('homepage');


// Users Routes
Route::name('users.')->prefix('users')->group(function() {

    // //Affichage de la partie authentification (login, register, logout)
    // Middleware -> these pages can only be accessed if user is not logged in (guest)
    Route::middleware('guest')->group(function() {
        Route::get('register', [UserController::class, 'create'])->name('create');
        Route::post('register', [UserController::class, 'store'])->name('store');

        Route::get('login', [UserController::class, 'login'])->name('login');
        Route::post('login', [UserController::class, 'signin'])->name('signin');
    });

    // Middleware -> these pages can only be accessed if user is logged in
    Route::middleware('auth')->group(function() {

        Route::get('logout', [UserController::class, 'logout'])->name('logout');

        //Affichage de la partie mise à jour du profil
        Route::get('update', [UserController::class, 'edit'])->name('edit');
        Route::post('update', [UserController::class, 'update'])->name('update');
    });

});


// //Affichage de tous les jeux
// Route::get('/games', [GameController::class, 'index'])->name('games.index');

// //Affichage de l'ajout d'un jeu
// Route::get('games/create', [GameController::class,'create'])->name('games.create');
// Route::post('games/create', [GameController::class,'store'])->name('games.store');

// //Affichage de l'ajout d'un studio
// Route::get('studios/create', [StudioController::class,'create'])->name('studios.create');
// Route::post('studios/create', [StudioController::class,'store'])->name('studios.store');

// //Affichage de l'ajout d'une plateforme
// Route::get('platforms/create', [PlatformController::class,'create'])->name('platforms.create');
// Route::post('platforms/create', [PlatformController::class,'store'])->name('platforms.store');

// //Affichage de l'ajout d'une categorie
// Route::get('categories/create', [CategorieController::class,'create'])->name('categories.create');
// Route::post('categories/create', [CategorieController::class,'store'])->name('categories.store');


// //Affichage de la partie avis
// Route::post('/games/{game}/comments', [CommentController::class, 'store'])->name('games.comments.store');

// //Affichage d'un jeux
// Route::get('/games/{id}', [GameController::class, 'show'])->name('games.show');
