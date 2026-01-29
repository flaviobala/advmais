<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Sem grupos: o usuário vê cursos ativos por padrão.
        $fullAccessCourses = Course::active()
            ->withCount('lessons')
            ->with(['lessons', 'category'])
            ->get()
            ->map(function($course) use ($user) {
                $course->progress = $course->getProgressForUser($user->id);
                $course->total_duration_minutes = $course->lessons->sum('duration_seconds') / 60;
                $course->access_type = 'full';
                return $course;
            });

        // Aulas com acesso direto do usuário (parcial)
        $lessonCourseIdsDirect = $user->accessibleLessons()->distinct()->pluck('course_id');

        $partialAccessCourses = Course::active()
            ->whereIn('id', $lessonCourseIdsDirect)
            ->with(['lessons', 'category'])
            ->get()
            ->map(function($course) use ($user) {
                $accessibleIds = $user->getAccessibleLessonIdsForCourse($course->id);
                $course->lessons_count = count($accessibleIds);
                $course->progress = $course->getProgressForUser($user->id);
                $course->total_duration_minutes = $course->lessons
                    ->whereIn('id', $accessibleIds)
                    ->sum('duration_seconds') / 60;
                $course->access_type = 'partial';
                return $course;
            });

        $courses = $fullAccessCourses->merge($partialAccessCourses)->unique('id');

        // Agrupar por categoria
        $categories = Category::active()->orderBy('order')->orderBy('name')->get();
        $categorizedCourses = $courses->groupBy(function($course) {
            return $course->category_id ?? 0;
        });

        return view('dashboard', compact('courses', 'categories', 'categorizedCourses', 'user'));
    }
}
