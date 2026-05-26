<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plano extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'valor_mensal',
        'duracao_meses',
        'acesso_aulas_grupais',
        'acesso_personal',
        'ativo',
    ];

    protected $casts = [
        'valor_mensal'        => 'decimal:2',
        'acesso_aulas_grupais' => 'boolean',
        'acesso_personal'     => 'boolean',
        'ativo'               => 'boolean',
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
