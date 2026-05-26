<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlunoController;
use App\Http\Controllers\Api\ProfessorController;
use App\Http\Controllers\Api\PlanoController;
use App\Http\Controllers\Api\MatriculaController;


Route::prefix('alunos')->group(function () {
    Route::get('/',          [AlunoController::class, 'index']);     
    Route::post('/',         [AlunoController::class, 'store']);      
    Route::get('/cpf/{cpf}', [AlunoController::class, 'findByCpf']); 
    Route::get('/{id}',      [AlunoController::class, 'show']);      
    Route::put('/{id}',      [AlunoController::class, 'update']);     
    Route::delete('/{id}',   [AlunoController::class, 'destroy']);    
});


Route::prefix('professores')->group(function () {
    Route::get('/',           [ProfessorController::class, 'index']);   
    Route::post('/',          [ProfessorController::class, 'store']);   
    Route::get('/{id}',       [ProfessorController::class, 'show']);   
    Route::put('/{id}',       [ProfessorController::class, 'update']);  
    Route::delete('/{id}',    [ProfessorController::class, 'destroy']); 
    Route::get('/{id}/alunos',[ProfessorController::class, 'alunos']);  
});


Route::prefix('planos')->group(function () {
    Route::get('/',         [PlanoController::class, 'index']);   
    Route::post('/',        [PlanoController::class, 'store']);  
    Route::get('/{id}',     [PlanoController::class, 'show']);    
    Route::put('/{id}',     [PlanoController::class, 'update']);  
    Route::delete('/{id}',  [PlanoController::class, 'destroy']); 
});


Route::prefix('matriculas')->group(function () {
    Route::get('/',                    [MatriculaController::class, 'index']);    
    Route::post('/',                   [MatriculaController::class, 'store']);    
    Route::get('/{id}',                [MatriculaController::class, 'show']);     
    Route::put('/{id}',                [MatriculaController::class, 'update']);   
    Route::delete('/{id}',             [MatriculaController::class, 'destroy']);  
    Route::patch('/{id}/cancelar',     [MatriculaController::class, 'cancelar']); 
    Route::patch('/{id}/suspender',    [MatriculaController::class, 'suspender']);
});
