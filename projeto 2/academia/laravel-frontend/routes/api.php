<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlunoController;
use App\Http\Controllers\Api\ProfessorController;
use App\Http\Controllers\Api\PlanoController;
use App\Http\Controllers\Api\MatriculaController;

/*
|--------------------------------------------------------------------------
| Academia API Routes
|--------------------------------------------------------------------------
| Todas as rotas retornam JSON.
| Base URL: http://localhost:8000/api
|--------------------------------------------------------------------------
*/

// ========== ALUNOS ==========
Route::prefix('alunos')->group(function () {
    Route::get('/',          [AlunoController::class, 'index']);      // GET    /api/alunos
    Route::post('/',         [AlunoController::class, 'store']);      // POST   /api/alunos
    Route::get('/cpf/{cpf}', [AlunoController::class, 'findByCpf']); // GET    /api/alunos/cpf/{cpf}
    Route::get('/{id}',      [AlunoController::class, 'show']);       // GET    /api/alunos/{id}
    Route::put('/{id}',      [AlunoController::class, 'update']);     // PUT    /api/alunos/{id}
    Route::delete('/{id}',   [AlunoController::class, 'destroy']);    // DELETE /api/alunos/{id}
});

// ========== PROFESSORES ==========
Route::prefix('professores')->group(function () {
    Route::get('/',           [ProfessorController::class, 'index']);   // GET    /api/professores
    Route::post('/',          [ProfessorController::class, 'store']);   // POST   /api/professores
    Route::get('/{id}',       [ProfessorController::class, 'show']);    // GET    /api/professores/{id}
    Route::put('/{id}',       [ProfessorController::class, 'update']);  // PUT    /api/professores/{id}
    Route::delete('/{id}',    [ProfessorController::class, 'destroy']); // DELETE /api/professores/{id}
    Route::get('/{id}/alunos',[ProfessorController::class, 'alunos']);  // GET    /api/professores/{id}/alunos
});

// ========== PLANOS ==========
Route::prefix('planos')->group(function () {
    Route::get('/',         [PlanoController::class, 'index']);   // GET    /api/planos
    Route::post('/',        [PlanoController::class, 'store']);   // POST   /api/planos
    Route::get('/{id}',     [PlanoController::class, 'show']);    // GET    /api/planos/{id}
    Route::put('/{id}',     [PlanoController::class, 'update']);  // PUT    /api/planos/{id}
    Route::delete('/{id}',  [PlanoController::class, 'destroy']); // DELETE /api/planos/{id}
});

// ========== MATRÍCULAS ==========
Route::prefix('matriculas')->group(function () {
    Route::get('/',                    [MatriculaController::class, 'index']);    // GET    /api/matriculas
    Route::post('/',                   [MatriculaController::class, 'store']);    // POST   /api/matriculas
    Route::get('/{id}',                [MatriculaController::class, 'show']);     // GET    /api/matriculas/{id}
    Route::put('/{id}',                [MatriculaController::class, 'update']);   // PUT    /api/matriculas/{id}
    Route::delete('/{id}',             [MatriculaController::class, 'destroy']);  // DELETE /api/matriculas/{id}
    Route::patch('/{id}/cancelar',     [MatriculaController::class, 'cancelar']); // PATCH  /api/matriculas/{id}/cancelar
    Route::patch('/{id}/suspender',    [MatriculaController::class, 'suspender']);// PATCH  /api/matriculas/{id}/suspender
});
