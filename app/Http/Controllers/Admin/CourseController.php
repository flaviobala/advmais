<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Http\Requests\Admin\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::withCount('lessons');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::active()->orderBy('order')->orderBy('name')->get();
        return view('admin.courses.create', compact('categories'));
    }

    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('courses', 'public');
        }

        if ($request->hasFile('course_video')) {
            $data['course_video'] = $request->file('course_video')
                ->store('courses/videos', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $course = Course::create($data);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Curso criado com sucesso! Agora você pode adicionar as aulas.');
    }

    public function show(Course $course)
    {
        $course->load(['lessons' => fn($q) => $q->orderBy('order')]);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::active()->orderBy('order')->orderBy('name')->get();
        $course->load(['lessons' => fn($q) => $q->orderBy('order')->withCount('attachments')]);
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('courses', 'public');
        }

        if ($request->hasFile('course_video')) {
            $data['course_video'] = $request->file('course_video')
                ->store('courses/videos', 'public');
        }

        $data['is_active'] = $request->has('is_active');

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso excluído com sucesso!');
    }

    public function toggleActive(Course $course)
    {
        $course->update(['is_active' => !$course->is_active]);

        $status = $course->is_active ? 'ativado' : 'desativado';

        return redirect()->back()->with('success', "Curso {$status} com sucesso!");
    }
}
