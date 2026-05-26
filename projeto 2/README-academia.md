# 🏋️ Sistema de Academia — BackEnd REST API

> Projeto acadêmico: Laravel + ASP.NET Core Web API  
> Entidades: **Aluno, Professor, Plano, Matrícula**

---

## 📁 Estrutura do Projeto

```
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
```

---

## 🚀 Como Executar

### ASP.NET Core (BackEnd Principal)

```bash
cd aspnet-backend/AcademiaAPI

# Restaurar pacotes
dotnet restore

# Rodar a API (porta 5000)
dotnet run

# Acessar Swagger UI:
# http://localhost:5000
```

> O banco SQLite (`academia.db`) é criado automaticamente com seed data.

---

### Laravel (BackEnd alternativo)

```bash
cd laravel-frontend

# Instalar dependências
composer install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Configurar banco (.env):
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/academia.db

# Executar migrations + seeds
php artisan migrate --seed

# Rodar servidor (porta 8000)
php artisan serve

# Instalar L5-Swagger (Swagger para Laravel)
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
php artisan l5-swagger:generate
# Acessar: http://localhost:8000/api/documentation
```

---

## 📊 Diagrama de Entidades (ER)

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

---

## 🛣️ Rotas da API

### Base URL: `http://localhost:5000/api`

---

### 👤 ALUNOS — `/api/alunos`

| Método   | Rota                    | Descrição                    | Status Code  |
|----------|-------------------------|------------------------------|--------------|
| `GET`    | `/api/alunos`           | Lista todos os alunos        | 200          |
| `GET`    | `/api/alunos?ativo=true`| Filtra por status            | 200          |
| `GET`    | `/api/alunos/{id}`      | Busca aluno por ID           | 200 / 404    |
| `GET`    | `/api/alunos/cpf/{cpf}` | Busca aluno por CPF          | 200 / 404    |
| `POST`   | `/api/alunos`           | Cria novo aluno              | 201 / 409    |
| `PUT`    | `/api/alunos/{id}`      | Atualiza aluno               | 200 / 404    |
| `DELETE` | `/api/alunos/{id}`      | Remove aluno                 | 204 / 409    |

**POST /api/alunos — Body:**
```json
{
  "nome": "João Pereira",
  "cpf": "333.333.333-33",
  "email": "joao@email.com",
  "telefone": "(49) 98888-0001",
  "dataNascimento": "1990-05-15",
  "endereco": "Rua das Flores, 123 - Joaçaba/SC"
}
```

---

### 👨‍🏫 PROFESSORES — `/api/professores`

| Método   | Rota                          | Descrição                        | Status Code  |
|----------|-------------------------------|----------------------------------|--------------|
| `GET`    | `/api/professores`            | Lista todos os professores       | 200          |
| `GET`    | `/api/professores/{id}`       | Busca professor por ID           | 200 / 404    |
| `GET`    | `/api/professores/{id}/alunos`| Lista alunos ativos do professor | 200          |
| `POST`   | `/api/professores`            | Cria novo professor              | 201 / 409    |
| `PUT`    | `/api/professores/{id}`       | Atualiza professor               | 200 / 404    |
| `DELETE` | `/api/professores/{id}`       | Remove professor                 | 204 / 409    |

**POST /api/professores — Body:**
```json
{
  "nome": "Carlos Silva",
  "cpf": "111.111.111-11",
  "email": "carlos@academia.com",
  "especialidade": "Musculação",
  "cref": "001234-G/SC",
  "telefone": "(49) 99999-0001"
}
```

---

### 📋 PLANOS — `/api/planos`

| Método   | Rota              | Descrição           | Status Code  |
|----------|-------------------|---------------------|--------------|
| `GET`    | `/api/planos`     | Lista todos os planos | 200        |
| `GET`    | `/api/planos/{id}`| Busca plano por ID  | 200 / 404    |
| `POST`   | `/api/planos`     | Cria novo plano     | 201          |
| `PUT`    | `/api/planos/{id}`| Atualiza plano      | 200 / 404    |
| `DELETE` | `/api/planos/{id}`| Remove plano        | 204 / 409    |

**POST /api/planos — Body:**
```json
{
  "nome": "Premium",
  "descricao": "Acesso total + Personal Trainer",
  "valorMensal": 249.90,
  "duracaoMeses": 6,
  "acessoAulasGrupais": true,
  "acessoPersonal": true
}
```

---

### 📝 MATRÍCULAS — `/api/matriculas`

| Método    | Rota                            | Descrição                   | Status Code  |
|-----------|---------------------------------|-----------------------------|--------------|
| `GET`     | `/api/matriculas`               | Lista todas as matrículas   | 200          |
| `GET`     | `/api/matriculas?status=Ativa`  | Filtra por status           | 200          |
| `GET`     | `/api/matriculas?alunoId=1`     | Filtra por aluno            | 200          |
| `GET`     | `/api/matriculas/{id}`          | Busca matrícula por ID      | 200 / 404    |
| `POST`    | `/api/matriculas`               | Cria nova matrícula         | 201 / 409    |
| `PUT`     | `/api/matriculas/{id}`          | Atualiza matrícula          | 200 / 404    |
| `DELETE`  | `/api/matriculas/{id}`          | Cancela matrícula           | 204          |
| `PATCH`   | `/api/matriculas/{id}/cancelar` | Cancela explicitamente      | 200          |
| `PATCH`   | `/api/matriculas/{id}/suspender`| Suspende matrícula          | 200 / 400    |

**POST /api/matriculas — Body:**
```json
{
  "alunoId": 1,
  "planoId": 2,
  "professorId": 1,
  "dataInicio": "2024-01-15",
  "observacoes": "Foco em hipertrofia"
}
```

---

### 📊 DASHBOARD — `/api/dashboard`

| Método | Rota                          | Descrição                        |
|--------|-------------------------------|----------------------------------|
| `GET`  | `/api/dashboard`              | Resumo geral da academia         |
| `GET`  | `/api/dashboard/vencimentos`  | Matrículas próximas do vencimento|

---

## 🔢 Status de Matrícula

| Valor | Enum       | Descrição                     |
|-------|------------|-------------------------------|
| `1`   | `Ativa`    | Matrícula em vigor            |
| `2`   | `Suspensa` | Temporariamente suspensa      |
| `3`   | `Cancelada`| Encerrada pelo aluno/academia |
| `4`   | `Vencida`  | Prazo encerrado               |

---

## 🧪 Testes com Postman / Insomnia

### Fluxo básico de teste:

1. **Criar planos** (POST /api/planos)
2. **Criar professor** (POST /api/professores)
3. **Criar aluno** (POST /api/alunos)
4. **Criar matrícula** vinculando aluno + plano + professor
5. **Listar** alunos do professor (GET /api/professores/1/alunos)
6. **Suspender** matrícula (PATCH /api/matriculas/1/suspender)
7. **Dashboard** para ver resumo (GET /api/dashboard)

### Coleção Postman (importar como JSON):
```json
{
  "info": { "name": "Academia API", "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json" },
  "item": [
    { "name": "Listar Alunos",    "request": { "method": "GET",    "url": "http://localhost:5000/api/alunos" } },
    { "name": "Criar Aluno",      "request": { "method": "POST",   "url": "http://localhost:5000/api/alunos",
      "body": { "mode": "raw", "raw": "{\"nome\":\"Teste\",\"cpf\":\"000.000.000-01\",\"email\":\"teste@email.com\",\"telefone\":\"(49)99999-9999\",\"dataNascimento\":\"2000-01-01\"}", "options": {"raw":{"language":"json"}} } } },
    { "name": "Listar Planos",    "request": { "method": "GET",    "url": "http://localhost:5000/api/planos" } },
    { "name": "Dashboard",        "request": { "method": "GET",    "url": "http://localhost:5000/api/dashboard" } }
  ]
}
```

---

## 🛠️ Tecnologias

| Camada         | Tecnologia                  |
|----------------|-----------------------------|
| BackEnd REST   | ASP.NET Core 8 Web API (C#) |
| BackEnd Alt.   | Laravel 10 (PHP)            |
| ORM            | Entity Framework Core / Eloquent |
| Banco de Dados | SQLite (dev) / SQL Server / MySQL (prod) |
| Documentação   | Swagger / OpenAPI 3.0       |
| Testes         | Swagger UI, Postman, Insomnia |
| Padrão         | REST + OOP + DTO Pattern    |

---

## ✅ Checklist dos Requisitos

- [x] Projeto Laravel com Models, Controllers e Rotas
- [x] WebService REST BackEnd em ASP.NET Core C#
- [x] Integração com banco de dados (SQLite / EF Core / Eloquent)
- [x] 4 entidades: **Aluno, Professor, Plano, Matrícula**
- [x] CRUD completo para todas as entidades
- [x] Controllers REST com rotas documentadas
- [x] Relacionamentos entre entidades (FK)
- [x] Validação de dados
- [x] DTOs (Data Transfer Objects)
- [x] Swagger UI para testes
- [x] Seed data para testes iniciais
- [x] Rota extra: alunos por professor
- [x] Rota extra: dashboard com estatísticas
- [x] Ações específicas: suspender/cancelar matrícula
