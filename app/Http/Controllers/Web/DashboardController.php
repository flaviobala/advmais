<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Trilhas ativas com contagem de cursos aprovados
        $isAdmin = in_array($user->role, ['admin', 'professor']);
        $userCategoryIds = $isAdmin ? [] : $user->categories()->pluck('category_id')->toArray();

        $categories = Category::active()
            ->withCount(['courses' => function ($q) {
                $q->where('is_active', true)->where('is_approved', true);
            }])
            ->orderBy('order')
            ->orderBy('name')
            ->get()
            ->map(function ($category) use ($isAdmin, $userCategoryIds) {
                $category->is_locked = !$isAdmin && !in_array($category->id, $userCategoryIds);
                return $category;
            })
            ->sortBy('is_locked')
            ->values();

        // Cursos sem trilha (orphans)
        $orphanCourses = Course::active()
            ->where('is_approved', true)
            ->whereNull('category_id')
            ->withCount('lessons')
            ->with('lessons')
            ->get()
            ->map(function ($course) use ($user) {
                $hasFullAccess = $user->hasAccessToCourse($course->id);
                $hasPartialAccess = !$hasFullAccess && $user->hasPartialAccessToCourse($course->id);

                $course->is_locked = !$hasFullAccess && !$hasPartialAccess;
                $course->has_full_access = $hasFullAccess;
                $course->access_type = $hasFullAccess ? 'full' : ($hasPartialAccess ? 'partial' : 'locked');

                if (!$course->is_locked) {
                    $accessibleIds = $user->getAccessibleLessonIdsForCourse($course->id);
                    if (!$hasFullAccess) {
                        $course->lessons_count = count($accessibleIds);
                    }
                    $course->progress = $course->getProgressForUser($user->id);
                    $course->total_duration_minutes = $course->lessons
                        ->whereIn('id', $accessibleIds)
                        ->sum('duration_seconds') / 60;
                } else {
                    $course->progress = 0;
                    $course->total_duration_minutes = $course->lessons->sum('duration_seconds') / 60;
                }

                return $course;
            });

        return view('dashboard', compact('categories', 'orphanCourses', 'user'));
    }
}
