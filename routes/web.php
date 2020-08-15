<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('pertanyaan','PertanyaanController');
Route::resource('jawaban','JawabanController');
Route::resource('pertanyaan.komentarpertanyaan','KomentarPertanyaanController');
Route::resource('jawaban.komentarjawaban','KomentarJawabanController');
Route::resource('komentarjawaban','KomentarJawabanController');
Route::resource('komentarpertanyaan','KomentarPertanyaanController');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
