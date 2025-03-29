<?php

use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/homepage', function () {
//     return view('student/homepage');
// })->middleware(['auth', 'verified'])->name('homepage');

Route::get('/homepage', [HomepageController::class, 'homepage'])->middleware(['auth', 'verified'])->name('homepage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/teacheInfo', [ProfileController::class, 'teacheInfoInsert'])->name('teacheInfo.Insert');
    Route::delete('/teacheInfo/{subject}', [ProfileController::class, 'teacheInfoDestroy'])->name('teacheInfo.destroy');
    
});

Route::get('/students', [StudentController::class, 'registerStudent'])->name('registerStudent');
Route::post('/students', [StudentController::class, 'storeStudent'])->name('storeStudent');
Route::get('/students/{classroom_id}', [StudentController::class, 'viewListStudent'])->name('viewListStudent');
Route::post('/storePerformance', [StudentController::class, 'storePerformance'])->name('storePerformance');
Route::get('/performance/data', [StudentController::class, 'getPerformance'])->name('performance.data');
Route::post('/storeAttendance', [StudentController::class, 'storeAttendance'])->name('storeAttendance');
Route::get('/attendance/data', [StudentController::class, 'getAttendance'])->name('attendance.data');
Route::post('/updateBehaviour/{id}', [StudentController::class, 'updateBehaviour'])->name('behaviour.update');
Route::get('/viewStudent/{id}', [StudentController::class, 'viewStudent'])->name('viewStudent');


Route::post('/searchStudent', [StudentController::class, 'searchStudent'])->name('searchStudent');


require __DIR__.'/auth.php';
