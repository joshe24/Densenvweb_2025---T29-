using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using AcademiaAPI.Data;
using AcademiaAPI.Models;

namespace AcademiaAPI.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    [Produces("application/json")]
    public class DashboardController : ControllerBase
    {
        private readonly AcademiaContext _context;

        public DashboardController(AcademiaContext context)
        {
            _context = context;
        }

        /// <summary>Resumo geral da academia</summary>
        [HttpGet]
        public async Task<ActionResult> GetResumo()
        {
            var totalAlunos = await _context.Alunos.CountAsync(a => a.Ativo);
            var totalProfessores = await _context.Professores.CountAsync(p => p.Ativo);
            var totalPlanos = await _context.Planos.CountAsync(p => p.Ativo);
            var matriculasAtivas = await _context.Matriculas.CountAsync(m => m.Status == StatusMatricula.Ativa);
            var matriculasSuspensas = await _context.Matriculas.CountAsync(m => m.Status == StatusMatricula.Suspensa);
            var matriculasCanceladas = await _context.Matriculas.CountAsync(m => m.Status == StatusMatricula.Cancelada);

            var receitaMensal = await _context.Matriculas
                .Where(m => m.Status == StatusMatricula.Ativa)
                .Include(m => m.Plano)
                .SumAsync(m => m.Plano!.ValorMensal);

            var planosMaisUsados = await _context.Matriculas
                .Where(m => m.Status == StatusMatricula.Ativa)
                .GroupBy(m => m.Plano!.Nome)
                .Select(g => new { Plano = g.Key, Total = g.Count() })
                .OrderByDescending(x => x.Total)
                .ToListAsync();

            return Ok(new
            {
                totalAlunosAtivos = totalAlunos,
                totalProfessoresAtivos = totalProfessores,
                totalPlanosAtivos = totalPlanos,
                matriculasAtivas,
                matriculasSuspensas,
                matriculasCanceladas,
                receitaMensalEstimada = receitaMensal,
                planosMaisUsados
            });
        }

        /// <summary>Matrículas próximas do vencimento (30 dias)</summary>
        [HttpGet("vencimentos")]
        public async Task<ActionResult> GetVencimentos([FromQuery] int dias = 30)
        {
            var dataLimite = DateTime.UtcNow.AddDays(dias);

            var vencimentos = await _context.Matriculas
                .Where(m => m.Status == StatusMatricula.Ativa && m.DataFim <= dataLimite)
                .Include(m => m.Aluno)
                .Include(m => m.Plano)
                .OrderBy(m => m.DataFim)
                .Select(m => new
                {
                    MatriculaId = m.Id,
                    AlunoNome = m.Aluno!.Nome,
                    AlunoEmail = m.Aluno.Email,
                    PlanoNome = m.Plano!.Nome,
                    DataFim = m.DataFim,
                    DiasRestantes = (int)(m.DataFim - DateTime.UtcNow).TotalDays
                })
                .ToListAsync();

            return Ok(vencimentos);
        }
    }
}
