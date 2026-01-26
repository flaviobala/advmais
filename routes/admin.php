<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Cursos
        Route::resource('courses', CourseController::class);

        // Aulas (nested resource)
        Route::get('courses/{course}/lessons/create', [LessonController::class, 'create'])->name('courses.lessons.create');
        Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('courses.lessons.store');
        Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::post('lessons/reorder', [LessonController::class, 'reorder'])->name('lessons.reorder');

        // Grupos
        Route::resource('groups', GroupController::class);
        Route::get('groups/{group}/courses', [GroupController::class, 'courses'])->name('groups.courses');
        Route::post('groups/{group}/courses', [GroupController::class, 'syncCourses'])->name('groups.courses.sync');

        // Usuários
        Route::resource('users', UserController::class);
        Route::get('users/{user}/groups', [UserController::class, 'groups'])->name('users.groups');
        Route::post('users/{user}/groups', [UserController::class, 'syncGroups'])->name('users.groups.sync');
        Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    });
