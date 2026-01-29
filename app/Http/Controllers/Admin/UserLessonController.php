<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class UserLessonController extends Controller
{
    public function index(User $user)
    {
        $courses = Course::where('is_active', true)
            ->with(['lessons' => fn($q) => $q->orderBy('order')])
            ->orderBy('title')
            ->get();

        $userLessonIds = $user->accessibleLessons()->pluck('lessons.id')->toArray();

        // Sem grupos: nenhum curso é automaticamente completo via grupo
        $fullAccessCourseIds = [];

        return view('admin.users.lessons', compact('user', 'courses', 'userLessonIds', 'fullAccessCourseIds'));
    }

    public function sync(Request $request, User $user)
    {
        $request->validate([
            'lessons' => 'nullable|array',
            'lessons.*' => 'exists:lessons,id',
        ]);

        $user->accessibleLessons()->sync($request->lessons ?? []);

        return redirect()->route('admin.users.lessons', $user)
            ->with('success', 'Aulas do usuário atualizadas com sucesso!');
    }
}
