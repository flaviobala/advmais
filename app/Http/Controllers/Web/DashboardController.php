<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Busca os IDs dos grupos do usuário
        $userGroupIds = $user->groups()->pluck('groups.id');

        // Busca cursos ativos que pertencem aos grupos do usuário
        $courses = Course::active()
            ->withCount('lessons')
            ->whereHas('groups', function($query) use ($userGroupIds) {
                $query->whereIn('groups.id', $userGroupIds);
            })
            ->with('lessons') // Carrega as aulas para calcular progresso
            ->get()
            ->map(function($course) use ($user) {
                // Adiciona o progresso do usuário no curso
                $course->progress = $course->getProgressForUser($user->id);

                // Calcula a duração total do curso em minutos
                $course->total_duration_minutes = $course->lessons->sum('duration_seconds') / 60;

                return $course;
            });

        // Retorna a view enviando a variável $courses e o nome do usuário
        return view('dashboard', compact('courses', 'user'));
    }
}