using Microsoft.AspNetCore.Mvc;
using Microsoft.EntityFrameworkCore;
using AcademiaAPI.Data;
using AcademiaAPI.Models;
using AcademiaAPI.DTOs;

namespace AcademiaAPI.Controllers
{
    [ApiController]
    [Route("api/[controller]")]
    [Produces("application/json")]
    public class MatriculasController : ControllerBase
    {
        private readonly AcademiaContext _context;

        public MatriculasController(AcademiaContext context)
        {
            _context = context;
        }

        /// <summary>Lista todas as matrículas</summary>
        [HttpGet]
        public async Task<ActionResult<IEnumerable<MatriculaResponseDto>>> GetAll(
            [FromQuery] StatusMatricula? status = null,
            [FromQuery] int? alunoId = null,
            [FromQuery] int? professorId = null)
        {
            var query = _context.Matriculas
                .Include(m => m.Aluno)
                .Include(m => m.Plano)
                .Include(m => m.Professor)
                .AsQueryable();

            if (status.HasValue) query = query.Where(m => m.Status == status.Value);
            if (alunoId.HasValue) query = query.Where(m => m.AlunoId == alunoId.Value);
            if (professorId.HasValue) query = query.Where(m => m.ProfessorId == professorId.Value);

            var matriculas = await query
                .OrderByDescending(m => m.CriadoEm)
                .Select(m => new MatriculaResponseDto
                {
                    Id = m.Id,
                    AlunoId = m.AlunoId,
                    AlunoNome = m.Aluno!.Nome,
                    PlanoId = m.PlanoId,
                    PlanoNome = m.Plano!.Nome,
                    ValorPlano = m.Plano!.ValorMensal,
                    ProfessorId = m.ProfessorId,
                    ProfessorNome = m.Professor!.Nome,
                    DataInicio = m.DataInicio,
                    DataFim = m.DataFim,
                    Status = m.Status.ToString(),
                    Observacoes = m.Observacoes,
                    CriadoEm = m.CriadoEm
                })
                .ToListAsync();

            return Ok(matriculas);
        }

        /// <summary>Busca matrícula por ID</summary>
        [HttpGet("{id}")]
        public async Task<ActionResult<MatriculaResponseDto>> GetById(int id)
        {
            var m = await _context.Matriculas
                .Include(x => x.Aluno)
                .Include(x => x.Plano)
                .Include(x => x.Professor)
                .FirstOrDefaultAsync(x => x.Id == id);

            if (m == null)
                return NotFound(new { message = $"Matrícula com ID {id} não encontrada." });

            return Ok(new MatriculaResponseDto
            {
                Id = m.Id,
                AlunoId = m.AlunoId,
                AlunoNome = m.Aluno!.Nome,
                PlanoId = m.PlanoId,
                PlanoNome = m.Plano!.Nome,
                ValorPlano = m.Plano!.ValorMensal,
                ProfessorId = m.ProfessorId,
                ProfessorNome = m.Professor!.Nome,
                DataInicio = m.DataInicio,
                DataFim = m.DataFim,
                Status = m.Status.ToString(),
                Observacoes = m.Observacoes,
                CriadoEm = m.CriadoEm
            });
        }

        /// <summary>Cria nova matrícula</summary>
        [HttpPost]
        public async Task<ActionResult<MatriculaResponseDto>> Create([FromBody] MatriculaCreateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var aluno = await _context.Alunos.FindAsync(dto.AlunoId);
            if (aluno == null) return NotFound(new { message = "Aluno não encontrado." });
            if (!aluno.Ativo) return BadRequest(new { message = "Aluno está inativo." });

            var plano = await _context.Planos.FindAsync(dto.PlanoId);
            if (plano == null) return NotFound(new { message = "Plano não encontrado." });
            if (!plano.Ativo) return BadRequest(new { message = "Plano está inativo." });

            var professor = await _context.Professores.FindAsync(dto.ProfessorId);
            if (professor == null) return NotFound(new { message = "Professor não encontrado." });
            if (!professor.Ativo) return BadRequest(new { message = "Professor está inativo." });

            var matriculaAtiva = await _context.Matriculas
                .AnyAsync(m => m.AlunoId == dto.AlunoId && m.Status == StatusMatricula.Ativa);
            if (matriculaAtiva)
                return Conflict(new { message = "Aluno já possui uma matrícula ativa." });

            var matricula = new Matricula
            {
                AlunoId = dto.AlunoId,
                PlanoId = dto.PlanoId,
                ProfessorId = dto.ProfessorId,
                DataInicio = dto.DataInicio,
                DataFim = dto.DataInicio.AddMonths(plano.DuracaoMeses),
                Status = StatusMatricula.Ativa,
                Observacoes = dto.Observacoes,
                CriadoEm = DateTime.UtcNow
            };

            _context.Matriculas.Add(matricula);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetById), new { id = matricula.Id }, new MatriculaResponseDto
            {
                Id = matricula.Id,
                AlunoId = matricula.AlunoId,
                AlunoNome = aluno.Nome,
                PlanoId = matricula.PlanoId,
                PlanoNome = plano.Nome,
                ValorPlano = plano.ValorMensal,
                ProfessorId = matricula.ProfessorId,
                ProfessorNome = professor.Nome,
                DataInicio = matricula.DataInicio,
                DataFim = matricula.DataFim,
                Status = matricula.Status.ToString(),
                Observacoes = matricula.Observacoes,
                CriadoEm = matricula.CriadoEm
            });
        }

        /// <summary>Atualiza matrícula (status, professor, observações)</summary>
        [HttpPut("{id}")]
        public async Task<ActionResult<MatriculaResponseDto>> Update(int id, [FromBody] MatriculaUpdateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var matricula = await _context.Matriculas
                .Include(m => m.Aluno)
                .Include(m => m.Plano)
                .Include(m => m.Professor)
                .FirstOrDefaultAsync(m => m.Id == id);

            if (matricula == null)
                return NotFound(new { message = $"Matrícula com ID {id} não encontrada." });

            var professor = await _context.Professores.FindAsync(dto.ProfessorId);
            if (professor == null) return NotFound(new { message = "Professor não encontrado." });

            matricula.ProfessorId = dto.ProfessorId;
            matricula.Status = dto.Status;
            matricula.Observacoes = dto.Observacoes;

            await _context.SaveChangesAsync();

            return Ok(new MatriculaResponseDto
            {
                Id = matricula.Id,
                AlunoId = matricula.AlunoId,
                AlunoNome = matricula.Aluno!.Nome,
                PlanoId = matricula.PlanoId,
                PlanoNome = matricula.Plano!.Nome,
                ValorPlano = matricula.Plano!.ValorMensal,
                ProfessorId = matricula.ProfessorId,
                ProfessorNome = professor.Nome,
                DataInicio = matricula.DataInicio,
                DataFim = matricula.DataFim,
                Status = matricula.Status.ToString(),
                Observacoes = matricula.Observacoes,
                CriadoEm = matricula.CriadoEm
            });
        }

        /// <summary>Cancela matrícula</summary>
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var matricula = await _context.Matriculas.FindAsync(id);
            if (matricula == null)
                return NotFound(new { message = $"Matrícula com ID {id} não encontrada." });

            matricula.Status = StatusMatricula.Cancelada;
            await _context.SaveChangesAsync();

            return NoContent();
        }

        /// <summary>Cancela matrícula explicitamente via PATCH</summary>
        [HttpPatch("{id}/cancelar")]
        public async Task<IActionResult> Cancelar(int id)
        {
            var matricula = await _context.Matriculas.FindAsync(id);
            if (matricula == null)
                return NotFound(new { message = $"Matrícula com ID {id} não encontrada." });

            matricula.Status = StatusMatricula.Cancelada;
            await _context.SaveChangesAsync();

            return Ok(new { message = "Matrícula cancelada com sucesso.", id });
        }

        /// <summary>Suspende matrícula</summary>
        [HttpPatch("{id}/suspender")]
        public async Task<IActionResult> Suspender(int id)
        {
            var matricula = await _context.Matriculas.FindAsync(id);
            if (matricula == null)
                return NotFound(new { message = $"Matrícula com ID {id} não encontrada." });

            if (matricula.Status != StatusMatricula.Ativa)
                return BadRequest(new { message = "Somente matrículas ativas podem ser suspensas." });

            matricula.Status = StatusMatricula.Suspensa;
            await _context.SaveChangesAsync();

            return Ok(new { message = "Matrícula suspensa com sucesso.", id });
        }
    }
}
