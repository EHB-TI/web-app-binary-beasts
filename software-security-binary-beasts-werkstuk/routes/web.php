<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;

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

Route::get('/',[App\Http\Controllers\HomeController::class,'redirect']);


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('events',\App\Http\Controllers\EventsController::class);

Route::group(['middleware'=>'auth'],function(){
    Route::resource('events',\App\Http\Controllers\EventsController::class);
    Route::resource('users',\App\Http\Controllers\UserController::class);
    Route::resource('groups',\App\Http\Controllers\GroupController::class);
    Route::get("groups/users/{id}", [
        "uses" => "GroupController@showUser",
        "as" => "groups.user"
    ]);
});

// Github oauth routes
Route::get("auth/github", [GitHubController::class, 'gitRedirect']);
Route::get("auth/github/callback", [GitHubController::class, 'gitCallback']);
