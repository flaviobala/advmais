<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * Listar todos os cursos
     */
    public function index(): JsonResponse
    {
        // Por enquanto retornamos um texto de teste para confirmar que a rota funciona
        // Depois conectaremos com o Banco de Dados real
        return response()->json([
            'message' => 'Listagem de cursos funcionando!',
            'data' => [] 
        ]);
    }

    /**
     * Mostrar detalhes de um curso específico
     */
    public function show(string $id): JsonResponse
    {
       // Busca o curso ou falha (404) se não existir.
        // Traz junto as aulas ordenadas.
        $course = Course::with(['lessons' => function($query) {
            $query->orderBy('order', 'asc');
        }])->findOrFail($id);

        return response()->json([
            'message' => 'Curso detalhado recuperado.',
            'data' => $course
        ]);
    }
}