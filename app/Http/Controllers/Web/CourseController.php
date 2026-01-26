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

        // Verifica se o usuário tem acesso ao curso
        if (!$user->hasAccessToCourse($id)) {
            abort(403, 'Você não tem permissão para acessar este curso.');
        }

        // Busca o curso com suas aulas ordenadas
        $course = Course::with(['lessons' => function($query) {
            $query->orderBy('order');
        }])
        ->findOrFail($id);

        // Calcula o progresso do usuário no curso
        $course->progress = $course->getProgressForUser($user->id);

        // Adiciona informações de progresso para cada aula
        $course->lessons->each(function($lesson) use ($user) {
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

        // Verifica se o usuário tem acesso ao curso
        if (!$user->hasAccessToCourse($courseId)) {
            abort(403, 'Você não tem permissão para acessar esta aula.');
        }

        $course = Course::findOrFail($courseId);
        $lesson = Lesson::where('course_id', $courseId)
            ->where('id', $lessonId)
            ->firstOrFail();

        return view('courses.lesson', compact('course', 'lesson'));
    }
}
