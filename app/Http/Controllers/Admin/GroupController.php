<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGroupRequest;
use App\Http\Requests\Admin\UpdateGroupRequest;
use App\Models\Course;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::withCount('users', 'courses');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $groups = $query->orderBy('name')->paginate(15);

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(StoreGroupRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        Group::create($data);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo criado com sucesso!');
    }

    public function edit(Group $group)
    {
        return view('admin.groups.edit', compact('group'));
    }

    public function update(UpdateGroupRequest $request, Group $group)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        $group->update($data);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo atualizado com sucesso!');
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return redirect()->route('admin.groups.index')
            ->with('success', 'Grupo excluído com sucesso!');
    }

    public function courses(Group $group)
    {
        $allCourses = Course::where('is_active', true)->orderBy('title')->get();
        $groupCourseIds = $group->courses()->pluck('courses.id')->toArray();

        return view('admin.groups.courses', compact('group', 'allCourses', 'groupCourseIds'));
    }

    public function syncCourses(Request $request, Group $group)
    {
        $request->validate([
            'courses' => 'array',
            'courses.*' => 'exists:courses,id',
        ]);

        $syncData = [];
        foreach ($request->courses ?? [] as $courseId) {
            $syncData[$courseId] = ['available_at' => now()];
        }

        $group->courses()->sync($syncData);

        return redirect()->route('admin.groups.index')
            ->with('success', 'Cursos do grupo atualizados!');
    }
}
