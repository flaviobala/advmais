<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserLessonController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\UserCategoryController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\UserCourseController;

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Cursos (admin + professor)
        Route::resource('courses', CourseController::class);
        Route::patch('courses/{course}/toggle-active', [CourseController::class, 'toggleActive'])->name('courses.toggle-active');

        // Módulos (admin + professor)
        Route::post('courses/{course}/modules', [ModuleController::class, 'store'])->name('courses.modules.store');
        Route::put('modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::patch('modules/{module}/toggle-active', [ModuleController::class, 'toggleActive'])->name('modules.toggle-active');

        // Aulas (admin + professor)
        Route::get('courses/{course}/lessons/create', [LessonController::class, 'create'])->name('courses.lessons.create');
        Route::post('courses/{course}/lessons', [LessonController::class, 'store'])->name('courses.lessons.store');
        Route::get('lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
        Route::put('lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
        Route::delete('lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');
        Route::patch('lessons/{lesson}/toggle-active', [LessonController::class, 'toggleActive'])->name('lessons.toggle-active');
        Route::delete('lessons/attachments/{attachment}', [LessonController::class, 'destroyAttachment'])->name('lessons.attachments.destroy');
        Route::post('lessons/reorder', [LessonController::class, 'reorder'])->name('lessons.reorder');

        // Materiais complementares (admin + professor)
        Route::post('materials', [MaterialController::class, 'store'])->name('materials.store');
        Route::delete('materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

        // Rotas restritas a admin
        Route::middleware('admin-only')->group(function () {
            // Aprovação de cursos
            Route::patch('courses/{course}/approve', [CourseController::class, 'approve'])->name('courses.approve');
            Route::patch('courses/{course}/reject', [CourseController::class, 'reject'])->name('courses.reject');

            // Trilhas
            Route::resource('categories', CategoryController::class);
            Route::patch('categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

            // Usuários
            Route::resource('users', UserController::class);
            Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
            Route::get('users/{user}/courses', [UserCourseController::class, 'index'])->name('users.courses');
            Route::post('users/{user}/courses', [UserCourseController::class, 'sync'])->name('users.courses.sync');
            Route::get('users/{user}/categories', [UserCategoryController::class, 'index'])->name('users.categories');
            Route::post('users/{user}/categories', [UserCategoryController::class, 'sync'])->name('users.categories.sync');
            Route::get('users/{user}/lessons', [UserLessonController::class, 'index'])->name('users.lessons');
            Route::post('users/{user}/lessons', [UserLessonController::class, 'sync'])->name('users.lessons.sync');

            // ADV+CONECTA (Sobre)
            Route::get('about', [AboutController::class, 'index'])->name('about.index');
            Route::post('about/events', [AboutController::class, 'storeEvent'])->name('about.events.store');
            Route::delete('about/events/{event}', [AboutController::class, 'destroyEvent'])->name('about.events.destroy');
            Route::post('about/founders', [AboutController::class, 'storeFounder'])->name('about.founders.store');
            Route::put('about/founders/{founder}', [AboutController::class, 'updateFounder'])->name('about.founders.update');
            Route::delete('about/founders/{founder}', [AboutController::class, 'destroyFounder'])->name('about.founders.destroy');
        });
    });
