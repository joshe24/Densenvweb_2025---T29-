<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Professor;
use App\Models\Plano;
use App\Models\Matricula;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Planos
        $planos = Plano::insert([
            [
                'nome' => 'Básico',
                'descricao' => 'Acesso à musculação',
                'valor_mensal' => 89.90,
                'duracao_meses' => 1,
                'acesso_aulas_grupais' => false,
                'acesso_personal' => false,
                'ativo' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nome' => 'Intermediário',
                'descricao' => 'Musculação + Aulas em grupo',
                'valor_mensal' => 129.90,
                'duracao_meses' => 3,
                'acesso_aulas_grupais' => true,
                'acesso_personal' => false,
                'ativo' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nome' => 'Premium',
                'descricao' => 'Acesso total + Personal Trainer',
                'valor_mensal' => 249.90,
                'duracao_meses' => 6,
                'acesso_aulas_grupais' => true,
                'acesso_personal' => true,
                'ativo' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // Professores
        Professor::insert([
            [
                'nome' => 'Carlos Silva',
                'cpf' => '111.111.111-11',
                'email' => 'carlos@academia.com',
                'especialidade' => 'Musculação',
                'cref' => '001234-G/SC',
                'telefone' => '(49) 99999-0001',
                'ativo' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
            [
                'nome' => 'Ana Souza',
                'cpf' => '222.222.222-22',
                'email' => 'ana@academia.com',
                'especialidade' => 'Pilates e Yoga',
                'cref' => '005678-G/SC',
                'telefone' => '(49) 99999-0002',
                'ativo' => true,
                'created_at' => now(), 'updated_at' => now(),
            ],
        ]);

        // Alunos
        $aluno1 = Aluno::create([
            'nome' => 'João Pereira',
            'cpf' => '333.333.333-33',
            'email' => 'joao@email.com',
            'telefone' => '(49) 98888-0001',
            'data_nascimento' => '1990-05-15',
            'endereco' => 'Rua das Flores, 123 - Joaçaba/SC',
            'ativo' => true,
        ]);

        $aluno2 = Aluno::create([
            'nome' => 'Maria Santos',
            'cpf' => '444.444.444-44',
            'email' => 'maria@email.com',
            'telefone' => '(49) 98888-0002',
            'data_nascimento' => '1995-08-22',
            'endereco' => 'Av. Central, 456 - Joaçaba/SC',
            'ativo' => true,
        ]);

        // Matrículas
        Matricula::create([
            'aluno_id'     => $aluno1->id,
            'plano_id'     => 2,
            'professor_id' => 1,
            'data_inicio'  => now(),
            'data_fim'     => now()->addMonths(3),
            'status'       => 'Ativa',
            'observacoes'  => 'Foco em hipertrofia',
        ]);

        Matricula::create([
            'aluno_id'     => $aluno2->id,
            'plano_id'     => 3,
            'professor_id' => 2,
            'data_inicio'  => now(),
            'data_fim'     => now()->addMonths(6),
            'status'       => 'Ativa',
            'observacoes'  => 'Aulas de Pilates às terças e quintas',
        ]);
    }
}
