<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLessonRequest;
use App\Http\Requests\Admin\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Enums\VideoProvider;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function create(Course $course)
    {
        $nextOrder = $course->lessons()->max('order') + 1;
        $providers = VideoProvider::cases();
        return view('admin.lessons.create', compact('course', 'nextOrder', 'providers'));
    }

    public function store(StoreLessonRequest $request, Course $course)
    {
        $course->lessons()->create($request->validated());

        return redirect()->route('admin.courses.show', $course)
            ->with('success', 'Aula criada com sucesso!');
    }

    public function edit(Lesson $lesson)
    {
        $providers = VideoProvider::cases();
        return view('admin.lessons.edit', compact('lesson', 'providers'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());

        return redirect()->route('admin.courses.show', $lesson->course_id)
            ->with('success', 'Aula atualizada com sucesso!');
    }

    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('admin.courses.show', $courseId)
            ->with('success', 'Aula excluída com sucesso!');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:lessons,id',
            'lessons.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->lessons as $item) {
            Lesson::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
