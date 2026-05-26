<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AlunoController extends Controller
{
    
    public function index(Request $request): JsonResponse
    {
        $query = Aluno::withCount('matriculas');

        if ($request->has('ativo')) {
            $query->where('ativo', filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN));
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%$search%")
                  ->orWhere('cpf', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $alunos = $query->orderBy('nome')->get();

        return response()->json($alunos);
    }


    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome'            => 'required|string|max:100',
            'cpf'             => 'required|string|max:14|unique:alunos,cpf',
            'email'           => 'required|email|max:150|unique:alunos,email',
            'telefone'        => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'endereco'        => 'nullable|string|max:200',
        ]);

        $validated['ativo'] = true;

        $aluno = Aluno::create($validated);

        return response()->json($aluno, 201);
    }


    public function show(int $id): JsonResponse
    {
        $aluno = Aluno::with(['matriculas.plano', 'matriculas.professor'])->findOrFail($id);

        return response()->json($aluno);
    }


    public function update(Request $request, int $id): JsonResponse
    {
        $aluno = Aluno::findOrFail($id);

        $validated = $request->validate([
            'nome'            => 'required|string|max:100',
            'email'           => ['required', 'email', 'max:150', Rule::unique('alunos')->ignore($id)],
            'telefone'        => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'endereco'        => 'nullable|string|max:200',
            'ativo'           => 'boolean',
        ]);

        $aluno->update($validated);

        return response()->json($aluno);
    }


    public function destroy(int $id): JsonResponse
    {
        $aluno = Aluno::findOrFail($id);

        if ($aluno->matriculas()->exists()) {
            return response()->json([
                'message' => 'Não é possível excluir aluno com matrículas vinculadas. Desative-o.'
            ], 409);
        }

        $aluno->delete();

        return response()->json(null, 204);
    }


    public function findByCpf(string $cpf): JsonResponse
    {
        $aluno = Aluno::where('cpf', $cpf)->with('matriculas')->firstOrFail();

        return response()->json($aluno);
    }
}
