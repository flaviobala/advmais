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
            abort(403, 'Você não tem permissão para acessar este curso.');
        }

        $course = Course::with(['lessons' => function($query) {
            $query->orderBy('order');
        }])
        ->findOrFail($id);

        $accessibleLessonIds = $user->getAccessibleLessonIdsForCourse($id);

        $course->progress = $course->getProgressForUser($user->id);
        $course->has_full_access = $hasFullAccess;

        $course->lessons->each(function($lesson) use ($user, $accessibleLessonIds) {
            $lesson->is_accessible = in_array($lesson->id, $accessibleLessonIds);
            $userLesson = $user->lessons()->where('lesson_id', $lesson->id)->first();
            $lesson->is_completed = $userLesson ? $userLesson->pivot->is_completed : false;
            $lesson->progress_percentage = $userLesson ? $userLesson->pivot->progress_percentage : 0;
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
            abort(403, 'Você não tem permissão para acessar esta aula.');
        }

        $course = Course::findOrFail($courseId);
        $lesson = Lesson::where('course_id', $courseId)
            ->where('id', $lessonId)
            ->firstOrFail();

        return view('courses.lesson', compact('course', 'lesson'));
    }
}
