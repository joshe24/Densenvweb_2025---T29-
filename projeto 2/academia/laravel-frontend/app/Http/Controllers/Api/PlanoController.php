<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlanoController extends Controller
{
    /**
     * GET /api/planos
     */
    public function index(Request $request): JsonResponse
    {
        $query = Plano::query();

        if ($request->has('ativo')) {
            $query->where('ativo', filter_var($request->ativo, FILTER_VALIDATE_BOOLEAN));
        }

        return response()->json($query->orderBy('valor_mensal')->get());
    }

    /**
     * POST /api/planos
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nome'                => 'required|string|max:100',
            'descricao'           => 'nullable|string|max:500',
            'valor_mensal'        => 'required|numeric|min:0.01',
            'duracao_meses'       => 'required|integer|min:1|max:36',
            'acesso_aulas_grupais'=> 'boolean',
            'acesso_personal'     => 'boolean',
        ]);

        $validated['ativo'] = true;

        $plano = Plano::create($validated);

        return response()->json($plano, 201);
    }

    /**
     * GET /api/planos/{id}
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(Plano::findOrFail($id));
    }

    /**
     * PUT /api/planos/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $plano = Plano::findOrFail($id);

        $validated = $request->validate([
            'nome'                => 'required|string|max:100',
            'descricao'           => 'nullable|string|max:500',
            'valor_mensal'        => 'required|numeric|min:0.01',
            'duracao_meses'       => 'required|integer|min:1|max:36',
            'acesso_aulas_grupais'=> 'boolean',
            'acesso_personal'     => 'boolean',
            'ativo'               => 'boolean',
        ]);

        $plano->update($validated);

        return response()->json($plano);
    }

    /**
     * DELETE /api/planos/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $plano = Plano::findOrFail($id);

        if ($plano->matriculas()->exists()) {
            return response()->json([
                'message' => 'Não é possível excluir plano com matrículas vinculadas. Desative-o.'
            ], 409);
        }

        $plano->delete();

        return response()->json(null, 204);
    }
}
