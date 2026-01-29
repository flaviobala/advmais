<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class UserCourseController extends Controller
{
    public function index(User $user)
    {
        // Carrega todos os cursos com suas categorias
        $courses = Course::with('category')->orderBy('title')->get();

        // IDs dos cursos já associados ao usuário
        $userCourseIds = $user->courses()->pluck('course_id')->toArray();

        return view('admin.users.courses', compact('user', 'courses', 'userCourseIds'));
    }

    public function sync(Request $request, User $user)
    {
        $courseIds = $request->input('courses', []);

        // Sincroniza os cursos do usuário
        $user->courses()->sync($courseIds);

        return redirect()->route('admin.users.courses', $user)
            ->with('success', 'Cursos do usuário atualizados com sucesso!');
    }
}
