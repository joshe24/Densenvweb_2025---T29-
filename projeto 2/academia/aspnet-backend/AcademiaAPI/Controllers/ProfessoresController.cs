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
    public class ProfessoresController : ControllerBase
    {
        private readonly AcademiaContext _context;

        public ProfessoresController(AcademiaContext context)
        {
            _context = context;
        }

        /// <summary>Lista todos os professores</summary>
        [HttpGet]
        public async Task<ActionResult<IEnumerable<ProfessorResponseDto>>> GetAll([FromQuery] bool? ativo = null)
        {
            var query = _context.Professores
                .Include(p => p.Matriculas)
                .AsQueryable();

            if (ativo.HasValue)
                query = query.Where(p => p.Ativo == ativo.Value);

            var professores = await query
                .OrderBy(p => p.Nome)
                .Select(p => new ProfessorResponseDto
                {
                    Id = p.Id,
                    Nome = p.Nome,
                    Cpf = p.Cpf,
                    Email = p.Email,
                    Especialidade = p.Especialidade,
                    Cref = p.Cref,
                    Telefone = p.Telefone,
                    Ativo = p.Ativo,
                    CriadoEm = p.CriadoEm,
                    TotalAlunos = p.Matriculas.Count(m => m.Status == StatusMatricula.Ativa)
                })
                .ToListAsync();

            return Ok(professores);
        }

        /// <summary>Busca professor por ID</summary>
        [HttpGet("{id}")]
        public async Task<ActionResult<ProfessorResponseDto>> GetById(int id)
        {
            var professor = await _context.Professores
                .Include(p => p.Matriculas)
                .FirstOrDefaultAsync(p => p.Id == id);

            if (professor == null)
                return NotFound(new { message = $"Professor com ID {id} não encontrado." });

            return Ok(new ProfessorResponseDto
            {
                Id = professor.Id,
                Nome = professor.Nome,
                Cpf = professor.Cpf,
                Email = professor.Email,
                Especialidade = professor.Especialidade,
                Cref = professor.Cref,
                Telefone = professor.Telefone,
                Ativo = professor.Ativo,
                CriadoEm = professor.CriadoEm,
                TotalAlunos = professor.Matriculas.Count(m => m.Status == StatusMatricula.Ativa)
            });
        }

        /// <summary>Cria novo professor</summary>
        [HttpPost]
        public async Task<ActionResult<ProfessorResponseDto>> Create([FromBody] ProfessorCreateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            if (await _context.Professores.AnyAsync(p => p.Cpf == dto.Cpf))
                return Conflict(new { message = "CPF já cadastrado." });

            if (await _context.Professores.AnyAsync(p => p.Cref == dto.Cref))
                return Conflict(new { message = "CREF já cadastrado." });

            if (await _context.Professores.AnyAsync(p => p.Email == dto.Email))
                return Conflict(new { message = "E-mail já cadastrado." });

            var professor = new Professor
            {
                Nome = dto.Nome,
                Cpf = dto.Cpf,
                Email = dto.Email,
                Especialidade = dto.Especialidade,
                Cref = dto.Cref,
                Telefone = dto.Telefone,
                Ativo = true,
                CriadoEm = DateTime.UtcNow
            };

            _context.Professores.Add(professor);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetById), new { id = professor.Id }, new ProfessorResponseDto
            {
                Id = professor.Id,
                Nome = professor.Nome,
                Cpf = professor.Cpf,
                Email = professor.Email,
                Especialidade = professor.Especialidade,
                Cref = professor.Cref,
                Telefone = professor.Telefone,
                Ativo = professor.Ativo,
                CriadoEm = professor.CriadoEm
            });
        }

        /// <summary>Atualiza professor</summary>
        [HttpPut("{id}")]
        public async Task<ActionResult<ProfessorResponseDto>> Update(int id, [FromBody] ProfessorUpdateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var professor = await _context.Professores.FindAsync(id);
            if (professor == null)
                return NotFound(new { message = $"Professor com ID {id} não encontrado." });

            if (await _context.Professores.AnyAsync(p => p.Email == dto.Email && p.Id != id))
                return Conflict(new { message = "E-mail já cadastrado." });

            professor.Nome = dto.Nome;
            professor.Email = dto.Email;
            professor.Especialidade = dto.Especialidade;
            professor.Telefone = dto.Telefone;
            professor.Ativo = dto.Ativo;

            await _context.SaveChangesAsync();

            return Ok(new ProfessorResponseDto
            {
                Id = professor.Id,
                Nome = professor.Nome,
                Cpf = professor.Cpf,
                Email = professor.Email,
                Especialidade = professor.Especialidade,
                Cref = professor.Cref,
                Telefone = professor.Telefone,
                Ativo = professor.Ativo,
                CriadoEm = professor.CriadoEm
            });
        }

        /// <summary>Remove professor</summary>
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var professor = await _context.Professores.FindAsync(id);
            if (professor == null)
                return NotFound(new { message = $"Professor com ID {id} não encontrado." });

            var temMatricula = await _context.Matriculas.AnyAsync(m => m.ProfessorId == id);
            if (temMatricula)
                return Conflict(new { message = "Não é possível excluir professor com matrículas vinculadas." });

            _context.Professores.Remove(professor);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        /// <summary>Lista alunos de um professor</summary>
        [HttpGet("{id}/alunos")]
        public async Task<ActionResult> GetAlunos(int id)
        {
            var professor = await _context.Professores.FindAsync(id);
            if (professor == null)
                return NotFound(new { message = $"Professor com ID {id} não encontrado." });

            var alunos = await _context.Matriculas
                .Where(m => m.ProfessorId == id && m.Status == StatusMatricula.Ativa)
                .Include(m => m.Aluno)
                .Include(m => m.Plano)
                .Select(m => new {
                    MatriculaId = m.Id,
                    AlunoId = m.AlunoId,
                    AlunoNome = m.Aluno!.Nome,
                    Plano = m.Plano!.Nome,
                    DataInicio = m.DataInicio,
                    DataFim = m.DataFim
                })
                .ToListAsync();

            return Ok(alunos);
        }
    }
}
