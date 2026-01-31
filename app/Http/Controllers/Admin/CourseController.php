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
    private function authorizeCourse(Course $course): void
    {
        if (auth()->user()->isProfessor() && $course->created_by !== auth()->id()) {
            abort(403, 'Você não possui permissão para acessar este curso.');
        }
    }

    public function index(Request $request)
    {
        $query = Course::withCount('lessons');

        // Professor só vê seus próprios cursos
        if (auth()->user()->isProfessor()) {
            $query->where('created_by', auth()->id());
        }

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

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('courses/thumbnails', 'public');
        }

        $data['is_active'] = $request->has('is_active');
        $data['created_by'] = auth()->id();

        // Cursos criados por professor precisam de aprovação do admin
        if (auth()->user()->isProfessor()) {
            $data['is_approved'] = false;
        }

        $course = Course::create($data);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Curso criado com sucesso! Agora você pode adicionar as aulas.');
    }

    public function show(Course $course)
    {
        $this->authorizeCourse($course);
        $course->load(['lessons' => fn($q) => $q->orderBy('order')]);
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorizeCourse($course);
        $categories = Category::active()->orderBy('order')->orderBy('name')->get();
        $course->load([
            'modules' => fn($q) => $q->orderBy('order')->withCount('lessons'),
            'modules.lessons' => fn($q) => $q->orderBy('order')->withCount('attachments'),
            'modules.materials' => fn($q) => $q->orderBy('order'),
            'lessons' => fn($q) => $q->whereNull('module_id')->orderBy('order')->withCount('attachments'),
            'materials' => fn($q) => $q->orderBy('order'),
        ]);
        return view('admin.courses.edit', compact('course', 'categories'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorizeCourse($course);
        $data = $request->validated();

        // Remover campos de imagem do data para não sobrescrever com null
        unset($data['cover_image'], $data['thumbnail']);

        if ($request->hasFile('cover_image')) {
            if ($course->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('courses', 'public');
        } elseif ($request->input('remove_cover_image') == '1') {
            if ($course->cover_image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->cover_image);
            }
            $data['cover_image'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('courses/thumbnails', 'public');
        } elseif ($request->input('remove_thumbnail') == '1') {
            if ($course->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        $data['is_active'] = $request->has('is_active');

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso atualizado com sucesso!');
    }

    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso excluído com sucesso!');
    }

    public function toggleActive(Course $course)
    {
        $this->authorizeCourse($course);
        $course->update(['is_active' => !$course->is_active]);

        $status = $course->is_active ? 'ativado' : 'desativado';

        return redirect()->back()->with('success', "Curso {$status} com sucesso!");
    }

    public function approve(Course $course)
    {
        $course->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Curso aprovado com sucesso!');
    }

    public function reject(Course $course)
    {
        $course->update(['is_approved' => false]);

        return redirect()->back()->with('success', 'Curso reprovado com sucesso!');
    }
}
