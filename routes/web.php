<?php

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

// Vues de la partie modélisation du projet

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/conception/', function() {
   return view('mesUE');
});

Route::get('/conception/mesUE', function() {
    return view('mesUE');
});


Route::get('/conception/mesEnseignements', function() {
    return view('mesEnseignements');
});

Route::get('/conception/mesFormations/L1Informatique', function() {
    return view('L1Informatique');
});

Route::get('/conception/recapEnseignants', function() {
    return view('recapEnseignants');
});


Route::get('/conception/journal', function() {
    return view('journal');
});


Route::get('/conception/annuaire', function() {
    return view('annuaire');
});

Route::get('/conception/connexion', function() {
    return view('connexion');
});

Route::get('/conception/inscription', function() {
    return view('inscription');
});

Route::get('/conception/reset', function() {
    return view('reinitPassword');
});

// ------------------------------------------------

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/profil', 'ProfilController@show');

Route::get('/di/annuaire', 'ResponsableDI\AnnuaireController@show')->middleware(\App\Http\Middleware\AdminMiddleware::class);
Route::get('/di/json/annuaire', 'ResponsableDI\AnnuaireController@getAnnuaireJSON')->middleware(\App\Http\Middleware\AdminMiddleware::class);