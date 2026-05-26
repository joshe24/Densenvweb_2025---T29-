#  Sstema de Academia — BackEnd REST API

> Projeto acadêmico: Laravel + ASP.NET Core Web API  
> Entidades: **Aluno, Professor, Plano, Matrícula**


academia/
├── aspnet-backend/
│   └── AcademiaAPI/
│       ├── Controllers/
│       │   ├── AlunosController.cs
│       │   ├── ProfessoresController.cs
│       │   ├── PlanosController.cs
│       │   ├── MatriculasController.cs
│       │   └── DashboardController.cs
│       ├── Models/
│       │   ├── Aluno.cs
│       │   ├── Professor.cs
│       │   ├── Plano.cs
│       │   └── Matricula.cs
│       ├── Data/
│       │   └── AcademiaContext.cs
│       ├── DTOs/
│       │   └── Dtos.cs
│       ├── Program.cs
│       └── appsettings.json
│
└── laravel-frontend/
    ├── app/
    │   ├── Models/
    │   │   ├── Aluno.php
    │   │   ├── Professor.php
    │   │   ├── Plano.php
    │   │   └── Matricula.php
    │   └── Http/Controllers/Api/
    │       ├── AlunoController.php
    │       ├── ProfessorController.php
    │       ├── PlanoController.php
    │       └── MatriculaController.php
    ├── routes/
    │   └── api.php
    └── database/
        ├── migrations/
        └── seeders/
`
```
┌─────────────┐        ┌──────────────────┐        ┌─────────────┐
│   ALUNO     │        │    MATRÍCULA     │        │   PLANO     │
│─────────────│        │──────────────────│        │─────────────│
│ id (PK)     │◄───────│ aluno_id (FK)    │───────►│ id (PK)     │
│ nome        │        │ plano_id (FK)    │        │ nome        │
│ cpf (UNIQUE)│        │ professor_id (FK)│        │ descricao   │
│ email       │        │ data_inicio      │        │ valor_mensal│
│ telefone    │        │ data_fim         │        │ duracao_mes │
│ data_nasc.  │        │ status           │        │ aulas_grupo │
│ endereco    │        │ observacoes      │        │ personal    │
│ ativo       │        └──────────────────┘        │ ativo       │
└─────────────┘                  │                 └─────────────┘
                                 │
                        ┌────────▼────┐
                        │  PROFESSOR  │
                        │─────────────│
                        │ id (PK)     │
                        │ nome        │
                        │ cpf (UNIQUE)│
                        │ email       │
                        │ especialid. │
                        │ cref (UNIQ) │
                        │ telefone    │
                        │ ativo       │
                        └─────────────┘
```

