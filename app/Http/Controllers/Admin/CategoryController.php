<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('courses');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('order')->orderBy('name')->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')
                ->store('categories', 'public');
        }

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');
        $data['order'] = $data['order'] ?? 0;

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Trilha criada com sucesso!');
    }

    public function show(Category $category)
    {
        $category->load(['courses' => fn($q) => $q->withCount('lessons')->orderBy('title')]);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $category->load(['courses' => fn($q) => $q->withCount('lessons')->orderBy('title')]);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')
                ->store('categories', 'public');
        }

        if ($request->has('remove_cover_image') && !$request->hasFile('cover_image')) {
            if ($category->cover_image) {
                Storage::disk('public')->delete($category->cover_image);
            }
            $data['cover_image'] = null;
        }

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Trilha atualizada com sucesso!');
    }

    public function destroy(Category $category)
    {
        $category->courses()->update(['category_id' => null]);
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Trilha excluída com sucesso!');
    }

    public function toggleActive(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'ativada' : 'desativada';

        return redirect()->back()->with('success', "Trilha {$status} com sucesso!");
    }
}
