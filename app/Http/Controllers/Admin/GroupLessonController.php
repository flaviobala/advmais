<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupLessonController extends Controller
{
    public function index(Group $group)
    {
        $courses = Course::where('is_active', true)
            ->with(['lessons' => fn($q) => $q->orderBy('order')])
            ->orderBy('title')
            ->get();

        $groupLessonIds = $group->accessibleLessons()->pluck('lessons.id')->toArray();
        $groupCourseIds = $group->courses()->pluck('courses.id')->toArray();

        return view('admin.groups.lessons', compact('group', 'courses', 'groupLessonIds', 'groupCourseIds'));
    }

    public function sync(Request $request, Group $group)
    {
        $request->validate([
            'lessons' => 'nullable|array',
            'lessons.*' => 'exists:lessons,id',
        ]);

        $group->accessibleLessons()->sync($request->lessons ?? []);

        return redirect()->route('admin.groups.lessons', $group)
            ->with('success', 'Aulas do grupo atualizadas com sucesso!');
    }
}
