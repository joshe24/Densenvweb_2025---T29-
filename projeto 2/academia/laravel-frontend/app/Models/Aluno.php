<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'data_nascimento',
        'endereco',
        'ativo',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'ativo' => 'boolean',
    ];

    // Relacionamentos
    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function matriculaAtiva()
    {
        return $this->hasOne(Matricula::class)->where('status', 'Ativa');
    }
}
