<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GitHubController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\AdminController;

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

Route::get('/',[App\Http\Controllers\HomeController::class,'redirect'])->name("index");


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('events',\App\Http\Controllers\EventsController::class);
Route::post('events/create',[\App\Http\Controllers\EventsController::class,'createEvent']);
Route::post('events/accept',[\App\Http\Controllers\EventsController::class,'acceptEvent']);
Route::post('events/reject',[\App\Http\Controllers\EventsController::class,'rejectEvent']);


Route::group(['middleware'=>'auth'],function(){
    Route::resource('events', EventsController::class);
    Route::resource('users', UserController::class);
    Route::prefix('groups')->group(function () {
        Route::get(
            '/',
            [GroupController::class, 'index']
        )->name('groups.index');
        Route::get(
            '/edit/{id}',
            [GroupController::class, 'edit']
        )->name('groups.edit');
        Route::post(
            '/edit/{id}',
            [GroupController::class, 'postEdit']
        )->name('groups.postEdit');
        Route::get(
            '/users/{id}',
            [GroupController::class, 'showUser']
        )->name('groups.user');
        Route::get(
            '/{id}',
            [GroupController::class, 'showGroup']
        )->name('groups.details');
        Route::post(
            '/delete/{id}',
            [GroupController::class, 'delete']
        )->name('groups.delete');
        Route::post(
            '/create',
            [GroupController::class, 'newGroup']
        )->name('groups.create');
        Route::post(
            '/remove/',
            [GroupController::class, 'removeMember']
        )->name('groups.remove');
        Route::post(
            '/add/',
            [GroupController::class, 'addMember']
        )->name('groups.add');
    });
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get("/", [AdminController::class, "index"])->name("admin.index");
    Route::post("/addAdmin", [AdminController::class, "addAdmin"])->name("admin.addAdmin");
    Route::post("/removeAdmin", [AdminController::class, "removeAdmin"])->name("admin.removeAdmin");
    Route::post("/addTeacher", [AdminController::class, "addTeacher"])->name("admin.addTeacher");
    Route::post("/removeTeacher", [AdminController::class, "removeTeacher"])->name("admin.removeTeacher");
    Route::post("/addStudent", [AdminController::class, "addStudent"])->name("admin.addStudent");
    Route::post("/removeStudent", [AdminController::class, "removeStudent"])->name("admin.removeStudent");
});

// Github oauth routes
Route::get("auth/github", [GitHubController::class, 'gitRedirect']);
Route::get("auth/github/callback", [GitHubController::class, 'gitCallback']);