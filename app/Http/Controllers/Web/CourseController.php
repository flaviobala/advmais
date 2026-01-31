<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Exibe um curso específico com suas aulas.
     */
    public function show($id)
    {
        $user = auth()->user();

        $hasFullAccess = $user->hasAccessToCourse($id);
        $hasPartialAccess = $user->hasPartialAccessToCourse($id);

        if (!$hasFullAccess && !$hasPartialAccess) {
            return redirect()->route('dashboard')
                ->with('error', 'Você não tem acesso a este curso. Entre em contato com o administrador.');
        }

        $course = Course::where('is_approved', true)
        ->with([
            'modules' => fn($q) => $q->where('is_active', true)->orderBy('order'),
            'modules.lessons' => fn($q) => $q->orderBy('order'),
            'modules.materials' => fn($q) => $q->orderBy('order'),
            'lessons' => fn($q) => $q->orderBy('order'),
            'materials' => fn($q) => $q->orderBy('order'),
        ])
        ->findOrFail($id);

        $accessibleLessonIds = $user->getAccessibleLessonIdsForCourse($id);

        $course->progress = $course->getProgressForUser($user->id);
        $course->has_full_access = $hasFullAccess;

        $attachProgress = function($lesson) use ($user, $accessibleLessonIds) {
            $lesson->is_accessible = in_array($lesson->id, $accessibleLessonIds);
            $userLesson = $user->lessons()->where('lesson_id', $lesson->id)->first();
            $lesson->is_completed = $userLesson ? $userLesson->pivot->is_completed : false;
            $lesson->progress_percentage = $userLesson ? $userLesson->pivot->progress_percentage : 0;
        };

        $course->lessons->each($attachProgress);
        $course->modules->each(function($module) use ($attachProgress) {
            $module->lessons->each($attachProgress);
        });

        return view('courses.show', compact('course', 'user'));
    }

    /**
     * Exibe uma aula específica com o player de vídeo.
     */
    public function lesson($courseId, $lessonId)
    {
        $user = auth()->user();

        if (!$user->hasAccessToLesson($lessonId)) {
            return redirect()->route('courses.show', $courseId)
                ->with('error', 'Você não tem acesso a esta aula.');
        }

        $course = Course::findOrFail($courseId);
        $lesson = Lesson::where('course_id', $courseId)
            ->where('id', $lessonId)
            ->firstOrFail();

        return view('courses.lesson', compact('course', 'lesson'));
    }
}
