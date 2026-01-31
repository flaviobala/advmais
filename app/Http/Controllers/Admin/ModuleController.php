<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    private function authorizeCourse(Course $course): void
    {
        if (auth()->user()->isProfessor() && $course->created_by !== auth()->id()) {
            abort(403, 'Você não possui permissão para acessar este curso.');
        }
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        unset($data['cover_image']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('modules/covers', 'public');
        }

        $data['course_id'] = $course->id;
        $data['order'] = ($course->modules()->max('order') ?? -1) + 1;

        Module::create($data);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Módulo criado com sucesso!');
    }

    public function update(Request $request, Module $module)
    {
        $this->authorizeCourse($module->course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
        ]);

        unset($data['cover_image']);

        if ($request->hasFile('cover_image')) {
            if ($module->cover_image) {
                Storage::disk('public')->delete($module->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('modules/covers', 'public');
        } elseif ($request->input('remove_cover_image')) {
            if ($module->cover_image) {
                Storage::disk('public')->delete($module->cover_image);
            }
            $data['cover_image'] = null;
        }

        $module->update($data);

        return redirect()->route('admin.courses.edit', $module->course_id)
            ->with('success', 'Módulo atualizado com sucesso!');
    }

    public function destroy(Module $module)
    {
        $this->authorizeCourse($module->course);

        if ($module->cover_image) {
            Storage::disk('public')->delete($module->cover_image);
        }

        $module->lessons()->update(['module_id' => null]);
        $module->delete();

        return redirect()->route('admin.courses.edit', $module->course_id)
            ->with('success', 'Módulo excluído. As aulas foram mantidas como aulas diretas.');
    }

    public function toggleActive(Module $module)
    {
        $this->authorizeCourse($module->course);

        $module->update(['is_active' => !$module->is_active]);
        $status = $module->is_active ? 'ativado' : 'desativado';

        return redirect()->back()->with('success', "Módulo {$status} com sucesso!");
    }
}
