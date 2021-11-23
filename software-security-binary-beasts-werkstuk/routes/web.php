<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventsController;

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
Route::post('events/create',[\App\Http\Controllers\EventsController::class,'createEvent']);
Route::post('events/accept',[\App\Http\Controllers\EventsController::class,'acceptEvent']);


Route::group(['middleware'=>'auth'],function(){
    Route::resource('events', EventsController::class);
    Route::resource('users', UserController::class);
    //Route::resource('groups',\App\Http\Controllers\GroupController::class);
    Route::get(
        '/groups',
        [GroupController::class, 'index']
    )->name('groups.index');
    Route::get(
        '/groups/edit/{id}',
        [GroupController::class, 'edit']
    )->name('groups.edit');
    Route::post(
        '/groups/edit/{id}',
        [GroupController::class, 'postEdit']
    )->name('groups.postEdit');
    Route::get(
        '/groups/users/{id}',
        [GroupController::class, 'showUser']
    )->name('groups.user');
    Route::get(
        '/groups/{id}',
        [GroupController::class, 'showGroup']
    )->name('groups.details');
    Route::post(
        '/groups/delete/{id}',
        [GroupController::class, 'delete']
    )->name('groups.delete');
    Route::post(
        '/groups/create',
        [GroupController::class, 'newGroup']
    )->name('groups.create');
    Route::post(
        '/groups/remove/',
        [GroupController::class, 'removeMember']
    )->name('groups.remove');
    Route::post(
        '/groups/add/',
        [GroupController::class, 'addMember']
    )->name('groups.add');
});

// Github oauth routes
Route::get("auth/github", [GitHubController::class, 'gitRedirect']);
Route::get("auth/github/callback", [GitHubController::class, 'gitCallback']);