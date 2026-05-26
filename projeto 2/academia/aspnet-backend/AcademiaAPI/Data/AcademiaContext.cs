using Microsoft.EntityFrameworkCore;
using AcademiaAPI.Models;

namespace AcademiaAPI.Data
{
    public class AcademiaContext : DbContext
    {
        public AcademiaContext(DbContextOptions<AcademiaContext> options) : base(options) { }

        public DbSet<Aluno> Alunos { get; set; }
        public DbSet<Professor> Professores { get; set; }
        public DbSet<Plano> Planos { get; set; }
        public DbSet<Matricula> Matriculas { get; set; }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            base.OnModelCreating(modelBuilder);


            modelBuilder.Entity<Aluno>(entity =>
            {
                entity.HasIndex(a => a.Cpf).IsUnique();
                entity.HasIndex(a => a.Email).IsUnique();
                entity.Property(a => a.ValorMensal).HasColumnType("decimal(10,2)");
            });


            modelBuilder.Entity<Professor>(entity =>
            {
                entity.HasIndex(p => p.Cpf).IsUnique();
                entity.HasIndex(p => p.Cref).IsUnique();
                entity.HasIndex(p => p.Email).IsUnique();
            });


            modelBuilder.Entity<Plano>(entity =>
            {
                entity.Property(p => p.ValorMensal).HasColumnType("decimal(10,2)");
            });


            modelBuilder.Entity<Matricula>(entity =>
            {
                entity.HasOne(m => m.Aluno)
                    .WithMany(a => a.Matriculas)
                    .HasForeignKey(m => m.AlunoId)
                    .OnDelete(DeleteBehavior.Restrict);

                entity.HasOne(m => m.Plano)
                    .WithMany(p => p.Matriculas)
                    .HasForeignKey(m => m.PlanoId)
                    .OnDelete(DeleteBehavior.Restrict);

                entity.HasOne(m => m.Professor)
                    .WithMany(p => p.Matriculas)
                    .HasForeignKey(m => m.ProfessorId)
                    .OnDelete(DeleteBehavior.Restrict);
            });
     
            modelBuilder.Entity<Plano>().HasData(
                new Plano { Id = 1, Nome = "Básico", Descricao = "Acesso à musculação", ValorMensal = 89.90m, DuracaoMeses = 1, AcessoAulasGrupais = false, AcessoPersonal = false },
                new Plano { Id = 2, Nome = "Intermediário", Descricao = "Musculação + Aulas em grupo", ValorMensal = 129.90m, DuracaoMeses = 3, AcessoAulasGrupais = true, AcessoPersonal = false },
                new Plano { Id = 3, Nome = "Premium", Descricao = "Acesso total + Personal", ValorMensal = 249.90m, DuracaoMeses = 6, AcessoAulasGrupais = true, AcessoPersonal = true }
            );

            modelBuilder.Entity<Professor>().HasData(
                new Professor { Id = 1, Nome = "Carlos Silva", Cpf = "111.111.111-11", Email = "carlos@academia.com", Especialidade = "Musculação", Cref = "001234-G/SC", Telefone = "(49) 99999-0001" },
                new Professor { Id = 2, Nome = "Ana Souza", Cpf = "222.222.222-22", Email = "ana@academia.com", Especialidade = "Pilates e Yoga", Cref = "005678-G/SC", Telefone = "(49) 99999-0002" }
            );
        }
    }
}
