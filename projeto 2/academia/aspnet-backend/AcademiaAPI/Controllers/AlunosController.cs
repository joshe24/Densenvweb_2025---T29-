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
    public class AlunosController : ControllerBase
    {
        private readonly AcademiaContext _context;

        public AlunosController(AcademiaContext context)
        {
            _context = context;
        }

        /// <summary>Lista todos os alunos</summary>
        [HttpGet]
        public async Task<ActionResult<IEnumerable<AlunoResponseDto>>> GetAll([FromQuery] bool? ativo = null)
        {
            var query = _context.Alunos
                .Include(a => a.Matriculas)
                .AsQueryable();

            if (ativo.HasValue)
                query = query.Where(a => a.Ativo == ativo.Value);

            var alunos = await query
                .OrderBy(a => a.Nome)
                .Select(a => new AlunoResponseDto
                {
                    Id = a.Id,
                    Nome = a.Nome,
                    Cpf = a.Cpf,
                    Email = a.Email,
                    Telefone = a.Telefone,
                    DataNascimento = a.DataNascimento,
                    Endereco = a.Endereco,
                    Ativo = a.Ativo,
                    CriadoEm = a.CriadoEm,
                    TotalMatriculas = a.Matriculas.Count
                })
                .ToListAsync();

            return Ok(alunos);
        }

        /// <summary>Busca aluno por ID</summary>
        [HttpGet("{id}")]
        public async Task<ActionResult<AlunoResponseDto>> GetById(int id)
        {
            var aluno = await _context.Alunos
                .Include(a => a.Matriculas)
                .FirstOrDefaultAsync(a => a.Id == id);

            if (aluno == null)
                return NotFound(new { message = $"Aluno com ID {id} não encontrado." });

            return Ok(new AlunoResponseDto
            {
                Id = aluno.Id,
                Nome = aluno.Nome,
                Cpf = aluno.Cpf,
                Email = aluno.Email,
                Telefone = aluno.Telefone,
                DataNascimento = aluno.DataNascimento,
                Endereco = aluno.Endereco,
                Ativo = aluno.Ativo,
                CriadoEm = aluno.CriadoEm,
                TotalMatriculas = aluno.Matriculas.Count
            });
        }

        /// <summary>Cria novo aluno</summary>
        [HttpPost]
        public async Task<ActionResult<AlunoResponseDto>> Create([FromBody] AlunoCreateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            if (await _context.Alunos.AnyAsync(a => a.Cpf == dto.Cpf))
                return Conflict(new { message = "CPF já cadastrado." });

            if (await _context.Alunos.AnyAsync(a => a.Email == dto.Email))
                return Conflict(new { message = "E-mail já cadastrado." });

            var aluno = new Aluno
            {
                Nome = dto.Nome,
                Cpf = dto.Cpf,
                Email = dto.Email,
                Telefone = dto.Telefone,
                DataNascimento = dto.DataNascimento,
                Endereco = dto.Endereco,
                Ativo = true,
                CriadoEm = DateTime.UtcNow
            };

            _context.Alunos.Add(aluno);
            await _context.SaveChangesAsync();

            var response = new AlunoResponseDto
            {
                Id = aluno.Id,
                Nome = aluno.Nome,
                Cpf = aluno.Cpf,
                Email = aluno.Email,
                Telefone = aluno.Telefone,
                DataNascimento = aluno.DataNascimento,
                Endereco = aluno.Endereco,
                Ativo = aluno.Ativo,
                CriadoEm = aluno.CriadoEm,
                TotalMatriculas = 0
            };

            return CreatedAtAction(nameof(GetById), new { id = aluno.Id }, response);
        }

        /// <summary>Atualiza aluno existente</summary>
        [HttpPut("{id}")]
        public async Task<ActionResult<AlunoResponseDto>> Update(int id, [FromBody] AlunoUpdateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var aluno = await _context.Alunos.FindAsync(id);
            if (aluno == null)
                return NotFound(new { message = $"Aluno com ID {id} não encontrado." });

            if (await _context.Alunos.AnyAsync(a => a.Email == dto.Email && a.Id != id))
                return Conflict(new { message = "E-mail já cadastrado por outro aluno." });

            aluno.Nome = dto.Nome;
            aluno.Email = dto.Email;
            aluno.Telefone = dto.Telefone;
            aluno.DataNascimento = dto.DataNascimento;
            aluno.Endereco = dto.Endereco;
            aluno.Ativo = dto.Ativo;

            await _context.SaveChangesAsync();

            return Ok(new AlunoResponseDto
            {
                Id = aluno.Id,
                Nome = aluno.Nome,
                Cpf = aluno.Cpf,
                Email = aluno.Email,
                Telefone = aluno.Telefone,
                DataNascimento = aluno.DataNascimento,
                Endereco = aluno.Endereco,
                Ativo = aluno.Ativo,
                CriadoEm = aluno.CriadoEm
            });
        }

        /// <summary>Remove aluno</summary>
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var aluno = await _context.Alunos.FindAsync(id);
            if (aluno == null)
                return NotFound(new { message = $"Aluno com ID {id} não encontrado." });

            var temMatricula = await _context.Matriculas.AnyAsync(m => m.AlunoId == id);
            if (temMatricula)
                return Conflict(new { message = "Não é possível excluir aluno com matrículas vinculadas. Desative-o." });

            _context.Alunos.Remove(aluno);
            await _context.SaveChangesAsync();

            return NoContent();
        }

        /// <summary>Busca aluno por CPF</summary>
        [HttpGet("cpf/{cpf}")]
        public async Task<ActionResult<AlunoResponseDto>> GetByCpf(string cpf)
        {
            var aluno = await _context.Alunos
                .Include(a => a.Matriculas)
                .FirstOrDefaultAsync(a => a.Cpf == cpf);

            if (aluno == null)
                return NotFound(new { message = "Aluno não encontrado." });

            return Ok(new AlunoResponseDto
            {
                Id = aluno.Id,
                Nome = aluno.Nome,
                Cpf = aluno.Cpf,
                Email = aluno.Email,
                Telefone = aluno.Telefone,
                DataNascimento = aluno.DataNascimento,
                Endereco = aluno.Endereco,
                Ativo = aluno.Ativo,
                CriadoEm = aluno.CriadoEm,
                TotalMatriculas = aluno.Matriculas.Count
            });
        }
    }
}
