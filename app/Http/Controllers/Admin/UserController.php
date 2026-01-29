<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->orderBy('name')->paginate(15);

        $roles = ['admin', 'advogado', 'cliente', 'funcionario'];

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $roles = ['admin', 'advogado', 'cliente', 'funcionario'];
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->has('is_active');

        User::create($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    public function edit(User $user)
    {
        $roles = ['admin', 'advogado', 'cliente', 'funcionario'];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->has('is_active');

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode excluir sua própria conta!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuário removido com sucesso!');
    }

    public function toggleActive(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Você não pode desativar sua própria conta!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'ativado' : 'desativado';

        return redirect()->route('admin.users.index')
            ->with('success', "Usuário {$status} com sucesso!");
    }

    public function show(User $user)
    {
        // Carrega cursos ativos com aulas
        $courses = \App\Models\Course::with(['lessons' => fn($q) => $q->orderBy('order'), 'category'])->orderBy('title')->get();

        // Para cada curso, determina se o usuário tem acesso completo, parcial ou nenhum
        $courses = $courses->map(function($course) use ($user) {
            $course->access = 'none';
            if ($user->hasAccessToCourse($course->id)) {
                $course->access = 'full';
            } elseif ($user->hasPartialAccessToCourse($course->id)) {
                $course->access = 'partial';
            }
            return $course;
        });

        return view('admin.users.show', compact('user', 'courses'));
    }
}
