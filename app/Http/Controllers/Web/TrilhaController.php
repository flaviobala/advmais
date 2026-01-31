<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;

class TrilhaController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();

        $category = Category::active()->findOrFail($id);

        $courses = Course::active()
            ->where('is_approved', true)
            ->where('category_id', $id)
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

        return view('trilhas.show', compact('category', 'courses', 'user'));
    }
}
