<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\Aluno;
use App\Models\Plano;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MatriculaController extends Controller
{
    /**
     * GET /api/matriculas
     */
    public function index(Request $request): JsonResponse
    {
        $query = Matricula::with(['aluno', 'plano', 'professor']);

        if ($request->has('status'))      $query->where('status', $request->status);
        if ($request->has('aluno_id'))    $query->where('aluno_id', $request->aluno_id);
        if ($request->has('professor_id'))$query->where('professor_id', $request->professor_id);

        return response()->json($query->latest()->get());
    }

    /**
     * POST /api/matriculas
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'aluno_id'     => 'required|exists:alunos,id',
            'plano_id'     => 'required|exists:planos,id',
            'professor_id' => 'required|exists:professores,id',
            'data_inicio'  => 'required|date',
            'observacoes'  => 'nullable|string|max:500',
        ]);

        $aluno     = Aluno::findOrFail($validated['aluno_id']);
        $plano     = Plano::findOrFail($validated['plano_id']);
        $professor = Professor::findOrFail($validated['professor_id']);

        if (!$aluno->ativo)
            return response()->json(['message' => 'Aluno está inativo.'], 400);

        if (!$plano->ativo)
            return response()->json(['message' => 'Plano está inativo.'], 400);

        if (!$professor->ativo)
            return response()->json(['message' => 'Professor está inativo.'], 400);

        $jaTemAtiva = Matricula::where('aluno_id', $aluno->id)
            ->where('status', Matricula::STATUS_ATIVA)
            ->exists();

        if ($jaTemAtiva)
            return response()->json(['message' => 'Aluno já possui uma matrícula ativa.'], 409);

        $dataInicio = \Carbon\Carbon::parse($validated['data_inicio']);
        $dataFim    = $dataInicio->copy()->addMonths($plano->duracao_meses);

        $matricula = Matricula::create([
            'aluno_id'     => $aluno->id,
            'plano_id'     => $plano->id,
            'professor_id' => $professor->id,
            'data_inicio'  => $dataInicio,
            'data_fim'     => $dataFim,
            'status'       => Matricula::STATUS_ATIVA,
            'observacoes'  => $validated['observacoes'] ?? null,
        ]);

        return response()->json($matricula->load(['aluno', 'plano', 'professor']), 201);
    }

    /**
     * GET /api/matriculas/{id}
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(
            Matricula::with(['aluno', 'plano', 'professor'])->findOrFail($id)
        );
    }

    /**
     * PUT /api/matriculas/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $matricula = Matricula::findOrFail($id);

        $validated = $request->validate([
            'professor_id' => 'required|exists:professores,id',
            'status'       => 'required|in:Ativa,Suspensa,Cancelada,Vencida',
            'observacoes'  => 'nullable|string|max:500',
        ]);

        $matricula->update($validated);

        return response()->json($matricula->load(['aluno', 'plano', 'professor']));
    }

    /**
     * DELETE /api/matriculas/{id}
     * Cancela a matrícula (soft-cancel via status)
     */
    public function destroy(int $id): JsonResponse
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update(['status' => Matricula::STATUS_CANCELADA]);

        return response()->json(null, 204);
    }

    /**
     * PATCH /api/matriculas/{id}/cancelar
     */
    public function cancelar(int $id): JsonResponse
    {
        $matricula = Matricula::findOrFail($id);
        $matricula->update(['status' => Matricula::STATUS_CANCELADA]);

        return response()->json(['message' => 'Matrícula cancelada com sucesso.', 'id' => $id]);
    }

    /**
     * PATCH /api/matriculas/{id}/suspender
     */
    public function suspender(int $id): JsonResponse
    {
        $matricula = Matricula::findOrFail($id);

        if ($matricula->status !== Matricula::STATUS_ATIVA) {
            return response()->json(['message' => 'Somente matrículas ativas podem ser suspensas.'], 400);
        }

        $matricula->update(['status' => Matricula::STATUS_SUSPENSA]);

        return response()->json(['message' => 'Matrícula suspensa com sucesso.', 'id' => $id]);
    }
}
