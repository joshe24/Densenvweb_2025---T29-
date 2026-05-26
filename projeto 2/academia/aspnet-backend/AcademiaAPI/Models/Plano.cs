using System.ComponentModel.DataAnnotations;

namespace AcademiaAPI.Models
{
    public class Plano
    {
        [Key]
        public int Id { get; set; }

        [Required(ErrorMessage = "Nome do plano é obrigatório")]
        [MaxLength(100)]
        public string Nome { get; set; } = string.Empty;

        [MaxLength(500)]
        public string? Descricao { get; set; }

        [Required(ErrorMessage = "Valor mensal é obrigatório")]
        [Range(0.01, 99999.99, ErrorMessage = "Valor deve ser maior que zero")]
        public decimal ValorMensal { get; set; }

        [Required(ErrorMessage = "Duração em meses é obrigatória")]
        [Range(1, 36, ErrorMessage = "Duração deve ser entre 1 e 36 meses")]
        public int DuracaoMeses { get; set; }

        public bool AcessoAulasGrupais { get; set; } = false;

        public bool AcessoPersonal { get; set; } = false;

        public bool Ativo { get; set; } = true;

        public DateTime CriadoEm { get; set; } = DateTime.UtcNow;

        // Navigation
        public ICollection<Matricula> Matriculas { get; set; } = new List<Matricula>();
    }
}
