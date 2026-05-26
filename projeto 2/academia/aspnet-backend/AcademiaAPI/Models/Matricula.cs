using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace AcademiaAPI.Models
{
    public enum StatusMatricula
    {
        Ativa = 1,
        Suspensa = 2,
        Cancelada = 3,
        Vencida = 4
    }

    public class Matricula
    {
        [Key]
        public int Id { get; set; }

        [Required(ErrorMessage = "Aluno é obrigatório")]
        public int AlunoId { get; set; }

        [Required(ErrorMessage = "Plano é obrigatório")]
        public int PlanoId { get; set; }

        [Required(ErrorMessage = "Professor responsável é obrigatório")]
        public int ProfessorId { get; set; }

        [Required(ErrorMessage = "Data de início é obrigatória")]
        public DateTime DataInicio { get; set; }

        public DateTime DataFim { get; set; }

        public StatusMatricula Status { get; set; } = StatusMatricula.Ativa;

        [MaxLength(500)]
        public string? Observacoes { get; set; }

        public DateTime CriadoEm { get; set; } = DateTime.UtcNow;


        [ForeignKey("AlunoId")]
        public Aluno? Aluno { get; set; }

        [ForeignKey("PlanoId")]
        public Plano? Plano { get; set; }

        [ForeignKey("ProfessorId")]
        public Professor? Professor { get; set; }
    }
}
