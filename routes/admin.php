<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
// removed GroupController and GroupLessonController routes (groups removed)
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLessonController;
use App\Http\Controllers\Admin\UserCategoryController;
use App\Http\Controllers\Admin\UserCourseController;

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Categorias
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::patch('categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

        // Cursos
        Route::resource('courses', CourseController::class);
        Route::patch('courses/{course}/toggle-active', [CourseController::class, 'toggleActive'])->name('courses.toggle-active');

        // Aulas (nested resource)
        Route::get('courses/{course}/lessons/create', [LessonController::class, 'create'])->name('courses.lessons.create');
        Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('courses.lessons.store');
        Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::patch('lessons/{lesson}/toggle-active', [LessonController::class, 'toggleActive'])->name('lessons.toggle-active');
        Route::delete('lessons/attachments/{attachment}', [LessonController::class, 'destroyAttachment'])->name('lessons.attachments.destroy');
        Route::post('lessons/reorder', [LessonController::class, 'reorder'])->name('lessons.reorder');

        // Usuários
        Route::resource('users', UserController::class);
        // (grupos removidos) removed user-group management routes
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::get('users/{user}/courses', [UserCourseController::class, 'index'])->name('users.courses');
        Route::post('users/{user}/courses', [UserCourseController::class, 'sync'])->name('users.courses.sync');
        Route::get('users/{user}/categories', [UserCategoryController::class, 'index'])->name('users.categories');
        Route::post('users/{user}/categories', [UserCategoryController::class, 'sync'])->name('users.categories.sync');
        Route::get('users/{user}/lessons', [UserLessonController::class, 'index'])->name('users.lessons');
        Route::post('users/{user}/lessons', [UserLessonController::class, 'sync'])->name('users.lessons.sync');
    });
