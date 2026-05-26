using System.ComponentModel.DataAnnotations;
using AcademiaAPI.Models;

namespace AcademiaAPI.DTOs
{
    // ===== ALUNO =====
    public class AlunoCreateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [Required] [MaxLength(14)] public string Cpf { get; set; } = string.Empty;
        [Required] [EmailAddress] [MaxLength(150)] public string Email { get; set; } = string.Empty;
        [Required] [MaxLength(20)] public string Telefone { get; set; } = string.Empty;
        [Required] public DateTime DataNascimento { get; set; }
        [MaxLength(200)] public string? Endereco { get; set; }
    }

    public class AlunoUpdateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [Required] [EmailAddress] [MaxLength(150)] public string Email { get; set; } = string.Empty;
        [Required] [MaxLength(20)] public string Telefone { get; set; } = string.Empty;
        [Required] public DateTime DataNascimento { get; set; }
        [MaxLength(200)] public string? Endereco { get; set; }
        public bool Ativo { get; set; }
    }

    public class AlunoResponseDto
    {
        public int Id { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string Cpf { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string Telefone { get; set; } = string.Empty;
        public DateTime DataNascimento { get; set; }
        public string? Endereco { get; set; }
        public bool Ativo { get; set; }
        public DateTime CriadoEm { get; set; }
        public int TotalMatriculas { get; set; }
    }

    // ===== PROFESSOR =====
    public class ProfessorCreateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [Required] [MaxLength(14)] public string Cpf { get; set; } = string.Empty;
        [Required] [EmailAddress] [MaxLength(150)] public string Email { get; set; } = string.Empty;
        [Required] [MaxLength(100)] public string Especialidade { get; set; } = string.Empty;
        [Required] [MaxLength(30)] public string Cref { get; set; } = string.Empty;
        [MaxLength(20)] public string? Telefone { get; set; }
    }

    public class ProfessorUpdateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [Required] [EmailAddress] [MaxLength(150)] public string Email { get; set; } = string.Empty;
        [Required] [MaxLength(100)] public string Especialidade { get; set; } = string.Empty;
        [MaxLength(20)] public string? Telefone { get; set; }
        public bool Ativo { get; set; }
    }

    public class ProfessorResponseDto
    {
        public int Id { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string Cpf { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string Especialidade { get; set; } = string.Empty;
        public string Cref { get; set; } = string.Empty;
        public string? Telefone { get; set; }
        public bool Ativo { get; set; }
        public DateTime CriadoEm { get; set; }
        public int TotalAlunos { get; set; }
    }

    // ===== PLANO =====
    public class PlanoCreateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [MaxLength(500)] public string? Descricao { get; set; }
        [Required] [Range(0.01, 99999.99)] public decimal ValorMensal { get; set; }
        [Required] [Range(1, 36)] public int DuracaoMeses { get; set; }
        public bool AcessoAulasGrupais { get; set; }
        public bool AcessoPersonal { get; set; }
    }

    public class PlanoUpdateDto
    {
        [Required] [MaxLength(100)] public string Nome { get; set; } = string.Empty;
        [MaxLength(500)] public string? Descricao { get; set; }
        [Required] [Range(0.01, 99999.99)] public decimal ValorMensal { get; set; }
        [Required] [Range(1, 36)] public int DuracaoMeses { get; set; }
        public bool AcessoAulasGrupais { get; set; }
        public bool AcessoPersonal { get; set; }
        public bool Ativo { get; set; }
    }

    public class PlanoResponseDto
    {
        public int Id { get; set; }
        public string Nome { get; set; } = string.Empty;
        public string? Descricao { get; set; }
        public decimal ValorMensal { get; set; }
        public int DuracaoMeses { get; set; }
        public bool AcessoAulasGrupais { get; set; }
        public bool AcessoPersonal { get; set; }
        public bool Ativo { get; set; }
        public DateTime CriadoEm { get; set; }
    }

    // ===== MATRICULA =====
    public class MatriculaCreateDto
    {
        [Required] public int AlunoId { get; set; }
        [Required] public int PlanoId { get; set; }
        [Required] public int ProfessorId { get; set; }
        [Required] public DateTime DataInicio { get; set; }
        [MaxLength(500)] public string? Observacoes { get; set; }
    }

    public class MatriculaUpdateDto
    {
        [Required] public int ProfessorId { get; set; }
        [Required] public StatusMatricula Status { get; set; }
        [MaxLength(500)] public string? Observacoes { get; set; }
    }

    public class MatriculaResponseDto
    {
        public int Id { get; set; }
        public int AlunoId { get; set; }
        public string AlunoNome { get; set; } = string.Empty;
        public int PlanoId { get; set; }
        public string PlanoNome { get; set; } = string.Empty;
        public decimal ValorPlano { get; set; }
        public int ProfessorId { get; set; }
        public string ProfessorNome { get; set; } = string.Empty;
        public DateTime DataInicio { get; set; }
        public DateTime DataFim { get; set; }
        public string Status { get; set; } = string.Empty;
        public string? Observacoes { get; set; }
        public DateTime CriadoEm { get; set; }
    }
}
