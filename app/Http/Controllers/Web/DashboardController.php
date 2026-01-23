<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Busca cursos ativos e conta as aulas de cada um
        $courses = Course::withCount('lessons')->get();

        // Retorna a view enviando a variável $courses
        return view('dashboard', compact('courses'));
    }
}