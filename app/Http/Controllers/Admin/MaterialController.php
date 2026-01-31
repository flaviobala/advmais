<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'materialable_type' => 'required|in:course,module',
            'materialable_id' => 'required|integer',
            'files' => 'nullable|array',
            'files.*' => 'file|max:51200',
            'link_title' => 'nullable|string|max:255',
            'link_url' => 'nullable|url|max:500',
        ]);

        $type = $request->input('materialable_type');
        $id = $request->input('materialable_id');

        if ($type === 'course') {
            $parent = Course::findOrFail($id);
            $this->authorizeCourse($parent);
            $morphType = Course::class;
            $storagePath = 'materials/courses';
        } else {
            $parent = Module::findOrFail($id);
            $this->authorizeCourse($parent->course);
            $morphType = Module::class;
            $storagePath = 'materials/modules';
        }

        $maxOrder = $parent->materials()->max('order') ?? -1;

        // Upload de arquivos
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $maxOrder++;
                $filepath = $file->store($storagePath, 'public');

                Material::create([
                    'materialable_type' => $morphType,
                    'materialable_id' => $id,
                    'type' => 'file',
                    'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                    'filename' => $file->getClientOriginalName(),
                    'filepath' => $filepath,
                    'filetype' => Material::detectType($file->getClientOriginalName()),
                    'filesize' => $file->getSize(),
                    'order' => $maxOrder,
                ]);
            }
        }

        // Adicionar link
        if ($request->filled('link_url')) {
            $maxOrder++;
            Material::create([
                'materialable_type' => $morphType,
                'materialable_id' => $id,
                'type' => 'link',
                'title' => $request->input('link_title') ?: $request->input('link_url'),
                'url' => $request->input('link_url'),
                'order' => $maxOrder,
            ]);
        }

        return back()->with('success', 'Material adicionado com sucesso!');
    }

    public function destroy(Material $material)
    {
        if ($material->materialable_type === Course::class) {
            $this->authorizeCourse($material->materialable);
        } else {
            $this->authorizeCourse($material->materialable->course);
        }

        if ($material->type === 'file' && $material->filepath) {
            Storage::disk('public')->delete($material->filepath);
        }

        $material->delete();

        return back()->with('success', 'Material excluído com sucesso!');
    }

    private function authorizeCourse(Course $course): void
    {
        if (auth()->user()->isProfessor() && $course->created_by !== auth()->id()) {
            abort(403, 'Você não possui permissão para acessar este curso.');
        }
    }
}
