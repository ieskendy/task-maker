<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Controllers
use App\Http\Controllers\TaskController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/tasks', [TaskController::class, 'index'])->name('tasks');
Route::middleware(['auth:sanctum', 'verified'])->get('/tasks/export', [TaskController::class, 'export'])->name('export-task');
Route::middleware(['auth:sanctum', 'verified'])->get('/tasks/{id}', [TaskController::class, 'show'])->name('task');
Route::middleware(['auth:sanctum', 'verified'])->get('/tasks/trashed', [TaskController::class, 'trashed'])->name('tasks-trashed');
Route::middleware(['auth:sanctum', 'verified'])->get('/tasks/create', [TaskController::class, 'create'])->name('create-task');
Route::middleware(['auth:sanctum', 'verified'])->put('/tasks/{id}', [TaskController::class, 'update'])->name('task-update');
Route::middleware(['auth:sanctum', 'verified'])->post('/tasks', [TaskController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/tasks/restore', [TaskController::class, 'restore']);
Route::middleware(['auth:sanctum', 'verified'])->delete('/tasks', [TaskController::class, 'delete']);
