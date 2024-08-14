<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcribeTransactionController;
use App\Http\Controllers\TeacherController;
use App\Models\Course;
use App\Models\CourseVideo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [FrontController::class,'checkout'])->name('front.checkout')->middleware('role:student');
    Route::post('/checkout/store', [FrontController::class,'checkout_store'])->name('front.checkout.store')->middleware('role:student');

    Route::get('/learning/{course}/{courseVideoId}', [FrontController::class,'learning'])->name('front.learning')->middleware('role:student|teacher');
    
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('categories', CategoryController::class)->middleware('role:owner');
        
        Route::resource('teacher', TeacherController::class)->middleware('role:owner|teacher');

        Route::resource('courses', CourseController::class)->middleware('role:owner|teacher');
        
        Route::get('/add/video/{course:id}',[CourseVideoController::class,'create'])->middleware('role:teacher|owner')->name('course.add_video');
        Route::post('/add/video/save/{course:id}',[CourseVideoController::class,'store'])->middleware('role:teacher|owner')->name('course.add_video.save');
        
        Route::resource('subscribe_transactions', SubcribeTransactionController::class)->middleware('role:owner');
        Route::resource('course_videos', SubcribeTransactionController::class)->middleware('role:owner|teacher');
    });
});



require __DIR__.'/auth.php';
