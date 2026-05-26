<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class ProfessorController extends Controller
{
    /**
     * GET /api/professores
     */
    public function index(Request $request): JsonResponse
    {
        $query = Professor::withCount([
            'matriculas as total_alunos' => fn($q) => $q->where('status', 'Ativa')
        ]);

        if ($request->has('ativo')) {
            $query->where('ativo', filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json($query->orderBy('nome')->get());
    }

    /**
     * POST /api/professores
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome'         => 'required|string|max:100',
            'cpf'          => 'required|string|max:14|unique:professores,cpf',
            'email'        => 'required|email|max:150|unique:professores,email',
            'especialidade'=> 'required|string|max:100',
            'cref'         => 'required|string|max:30|unique:professores,cref',
            'telefone'     => 'nullable|string|max:20',
        ]);

        $validated['ativo'] = true;

        $professor = Professor::create($validated);

        return response()->json($professor, 201);
    }

    /**
     * GET /api/professores/{id}
     */
    public function show(int $id): JsonResponse
    {
        $professor = Professor::with([
            'matriculas' => fn($q) => $q->where('status', 'Ativa')->with('aluno', 'plano')
        ])->findOrFail($id);

        return response()->json($professor);
    }

    /**
     * PUT /api/professores/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $professor = Professor::findOrFail($id);

        $validated = $request->validate([
            'nome'         => 'required|string|max:100',
            'email'        => ['required', 'email', 'max:150', Rule::unique('professores')->ignore($id)],
            'especialidade'=> 'required|string|max:100',
            'telefone'     => 'nullable|string|max:20',
            'ativo'        => 'boolean',
        ]);

        $professor->update($validated);

        return response()->json($professor);
    }

    /**
     * DELETE /api/professores/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $professor = Professor::findOrFail($id);

        if ($professor->matriculas()->exists()) {
            return response()->json([
                'message' => 'Não é possível excluir professor com matrículas vinculadas.'
            ], 409);
        }

        $professor->delete();

        return response()->json(null, 204);
    }

    /**
     * GET /api/professores/{id}/alunos
     */
    public function alunos(int $id): JsonResponse
    {
        $professor = Professor::findOrFail($id);

        $alunos = $professor->matriculas()
            ->where('status', 'Ativa')
            ->with('aluno', 'plano')
            ->get()
            ->map(fn($m) => [
                'matricula_id' => $m->id,
                'aluno_id'     => $m->aluno_id,
                'aluno_nome'   => $m->aluno->nome,
                'plano'        => $m->plano->nome,
                'data_inicio'  => $m->data_inicio,
                'data_fim'     => $m->data_fim,
            ]);

        return response()->json($alunos);
    }
}
