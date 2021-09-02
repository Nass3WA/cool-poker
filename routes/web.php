<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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


// //Affichage de la partie authentification (login, register, logout)
Route::get('users/register', [UserController::class,'create'])->name('users.create');
Route::post('users/register', [UserController::class,'store'])->name('users.store');
Route::get('users/login', [UserController::class,'login'])->name('users.login');
Route::post('users/login', [UserController::class,'signin'])->name('users.signin');
Route::get('/users/logout', [UserController::class, 'logout'])->name('users.logout');

//Affichage de la partie mise à jour du profil
Route::get('users/update', [UserController::class,'edit'])->name('users.edit');
Route::post('users/update', [UserController::class,'update'])->name('users.update');

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
