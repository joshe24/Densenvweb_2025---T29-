<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matricula extends Model
{
    use HasFactory;

    protected $fillable = [
        'aluno_id',
        'plano_id',
        'professor_id',
        'data_inicio',
        'data_fim',
        'status',
        'observacoes',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim'    => 'date',
    ];

    // Status possíveis
    const STATUS_ATIVA     = 'Ativa';
    const STATUS_SUSPENSA  = 'Suspensa';
    const STATUS_CANCELADA = 'Cancelada';
    const STATUS_VENCIDA   = 'Vencida';

    // Relacionamentos
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    // Scopes
    public function scopeAtivas($query)
    {
        return $query->where('status', self::STATUS_ATIVA);
    }

    public function scopeVencendo($query, $dias = 30)
    {
        return $query->where('status', self::STATUS_ATIVA)
                     ->where('data_fim', '<=', now()->addDays($dias));
    }
}
