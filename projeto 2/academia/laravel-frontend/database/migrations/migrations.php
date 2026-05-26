<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cpf', 14)->unique();
            $table->string('email', 150)->unique();
            $table->string('telefone', 20);
            $table->date('data_nascimento');
            $table->string('endereco', 200)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('alunos'); }
};


return new class extends Migration {
    public function up(): void
    {
        Schema::create('professores', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('cpf', 14)->unique();
            $table->string('email', 150)->unique();
            $table->string('especialidade', 100);
            $table->string('cref', 30)->unique();
            $table->string('telefone', 20)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('professores'); }
};


return new class extends Migration {
    public function up(): void
    {
        Schema::create('planos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('descricao', 500)->nullable();
            $table->decimal('valor_mensal', 10, 2);
            $table->integer('duracao_meses');
            $table->boolean('acesso_aulas_grupais')->default(false);
            $table->boolean('acesso_personal')->default(false);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('planos'); }
};


return new class extends Migration {
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->restrictOnDelete();
            $table->foreignId('plano_id')->constrained('planos')->restrictOnDelete();
            $table->foreignId('professor_id')->constrained('professores')->restrictOnDelete();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->enum('status', ['Ativa', 'Suspensa', 'Cancelada', 'Vencida'])->default('Ativa');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('matriculas'); }
};
