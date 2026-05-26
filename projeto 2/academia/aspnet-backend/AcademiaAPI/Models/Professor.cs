using System.ComponentModel.DataAnnotations;

namespace AcademiaAPI.Models
{
    public class Professor
    {
        [Key]
        public int Id { get; set; }

        [Required(ErrorMessage = "Nome é obrigatório")]
        [MaxLength(100)]
        public string Nome { get; set; } = string.Empty;

        [Required(ErrorMessage = "CPF é obrigatório")]
        [MaxLength(14)]
        public string Cpf { get; set; } = string.Empty;

        [Required(ErrorMessage = "Email é obrigatório")]
        [EmailAddress]
        [MaxLength(150)]
        public string Email { get; set; } = string.Empty;

        [Required(ErrorMessage = "Especialidade é obrigatória")]
        [MaxLength(100)]
        public string Especialidade { get; set; } = string.Empty;

        [Required(ErrorMessage = "CREF é obrigatório")]
        [MaxLength(30)]
        public string Cref { get; set; } = string.Empty;

        [MaxLength(20)]
        public string? Telefone { get; set; }

        public bool Ativo { get; set; } = true;

        public DateTime CriadoEm { get; set; } = DateTime.UtcNow;


        public ICollection<Matricula> Matriculas { get; set; } = new List<Matricula>();
    }
}
