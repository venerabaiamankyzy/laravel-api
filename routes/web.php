<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Guest\HomeController as GuestHomeController;

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TypeController;


use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\MockObject\Rule\Parameters;

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

Route::get('/', [GuestHomeController::class, 'index']);

Route::get('/home', [AdminHomeController::class, 'index'])->middleware(['auth'])->name('home');

//Si fa cosi per il singolo url. Slug si usa sul frontffice, per leggere meglio l'url, per permettere il google d'indirizzarlo. Sul backoffice si usa l'id
// Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->middleware(['auth'])->name('custom.show'); 


Route::middleware('auth')
    ->prefix('/admin') 
    ->name('admin.')
    ->group(function() {

        //! softdeletes and trash for projects resource
        Route::get('/projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
        Route::put('/projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
        Route::delete('/projects/{project}/force-delete', [ProjectController::class, 'forceDelete'])->name('projects.force-delete');

        //!  projects resource        
        Route::resource('projects', ProjectController::class);
        // -›except ([' index' ]);
        // -›only (['show', 'create', 'store', 'edit', 'update', 'destroy']);
            // ->parameters(['projects' => 'project:slug']); // si usa il slug al posto di id

        //! types resource
        // Route::resource('types', TypeController::class);
        Route::resource('types', TypeController::class)->except('show');
    });


Route::middleware('auth')
    ->prefix('/profile') // * titti gli url hanno il prefisso "/profile"
    ->name('profile.') // * tutti i nomi delle route hanno il prefisso "profile"
    ->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';