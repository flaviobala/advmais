<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function index(User $user)
    {
        // Carrega todas as categorias ativas
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // IDs das categorias já associadas ao usuário
        $userCategoryIds = $user->categories()->pluck('category_id')->toArray();

        return view('admin.users.categories', compact('user', 'categories', 'userCategoryIds'));
    }

    public function sync(Request $request, User $user)
    {
        $categoryIds = $request->input('categories', []);

        // Sincroniza as categorias do usuário
        $user->categories()->sync($categoryIds);

        return redirect()->route('admin.users.index')
            ->with('success', 'Categorias do usuário atualizadas com sucesso!');
    }
}
