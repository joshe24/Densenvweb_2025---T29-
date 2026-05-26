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
    public class PlanosController : ControllerBase
    {
        private readonly AcademiaContext _context;

        public PlanosController(AcademiaContext context)
        {
            _context = context;
        }

        /// <summary>Lista todos os planos</summary>
        [HttpGet]
        public async Task<ActionResult<IEnumerable<PlanoResponseDto>>> GetAll([FromQuery] bool? ativo = null)
        {
            var query = _context.Planos.AsQueryable();

            if (ativo.HasValue)
                query = query.Where(p => p.Ativo == ativo.Value);

            var planos = await query
                .OrderBy(p => p.ValorMensal)
                .Select(p => new PlanoResponseDto
                {
                    Id = p.Id,
                    Nome = p.Nome,
                    Descricao = p.Descricao,
                    ValorMensal = p.ValorMensal,
                    DuracaoMeses = p.DuracaoMeses,
                    AcessoAulasGrupais = p.AcessoAulasGrupais,
                    AcessoPersonal = p.AcessoPersonal,
                    Ativo = p.Ativo,
                    CriadoEm = p.CriadoEm
                })
                .ToListAsync();

            return Ok(planos);
        }

        /// <summary>Busca plano por ID</summary>
        [HttpGet("{id}")]
        public async Task<ActionResult<PlanoResponseDto>> GetById(int id)
        {
            var plano = await _context.Planos.FindAsync(id);

            if (plano == null)
                return NotFound(new { message = $"Plano com ID {id} não encontrado." });

            return Ok(new PlanoResponseDto
            {
                Id = plano.Id,
                Nome = plano.Nome,
                Descricao = plano.Descricao,
                ValorMensal = plano.ValorMensal,
                DuracaoMeses = plano.DuracaoMeses,
                AcessoAulasGrupais = plano.AcessoAulasGrupais,
                AcessoPersonal = plano.AcessoPersonal,
                Ativo = plano.Ativo,
                CriadoEm = plano.CriadoEm
            });
        }

        /// <summary>Cria novo plano</summary>
        [HttpPost]
        public async Task<ActionResult<PlanoResponseDto>> Create([FromBody] PlanoCreateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var plano = new Plano
            {
                Nome = dto.Nome,
                Descricao = dto.Descricao,
                ValorMensal = dto.ValorMensal,
                DuracaoMeses = dto.DuracaoMeses,
                AcessoAulasGrupais = dto.AcessoAulasGrupais,
                AcessoPersonal = dto.AcessoPersonal,
                Ativo = true,
                CriadoEm = DateTime.UtcNow
            };

            _context.Planos.Add(plano);
            await _context.SaveChangesAsync();

            return CreatedAtAction(nameof(GetById), new { id = plano.Id }, new PlanoResponseDto
            {
                Id = plano.Id,
                Nome = plano.Nome,
                Descricao = plano.Descricao,
                ValorMensal = plano.ValorMensal,
                DuracaoMeses = plano.DuracaoMeses,
                AcessoAulasGrupais = plano.AcessoAulasGrupais,
                AcessoPersonal = plano.AcessoPersonal,
                Ativo = plano.Ativo,
                CriadoEm = plano.CriadoEm
            });
        }

        /// <summary>Atualiza plano</summary>
        [HttpPut("{id}")]
        public async Task<ActionResult<PlanoResponseDto>> Update(int id, [FromBody] PlanoUpdateDto dto)
        {
            if (!ModelState.IsValid)
                return BadRequest(ModelState);

            var plano = await _context.Planos.FindAsync(id);
            if (plano == null)
                return NotFound(new { message = $"Plano com ID {id} não encontrado." });

            plano.Nome = dto.Nome;
            plano.Descricao = dto.Descricao;
            plano.ValorMensal = dto.ValorMensal;
            plano.DuracaoMeses = dto.DuracaoMeses;
            plano.AcessoAulasGrupais = dto.AcessoAulasGrupais;
            plano.AcessoPersonal = dto.AcessoPersonal;
            plano.Ativo = dto.Ativo;

            await _context.SaveChangesAsync();

            return Ok(new PlanoResponseDto
            {
                Id = plano.Id,
                Nome = plano.Nome,
                Descricao = plano.Descricao,
                ValorMensal = plano.ValorMensal,
                DuracaoMeses = plano.DuracaoMeses,
                AcessoAulasGrupais = plano.AcessoAulasGrupais,
                AcessoPersonal = plano.AcessoPersonal,
                Ativo = plano.Ativo,
                CriadoEm = plano.CriadoEm
            });
        }

        /// <summary>Remove plano</summary>
        [HttpDelete("{id}")]
        public async Task<IActionResult> Delete(int id)
        {
            var plano = await _context.Planos.FindAsync(id);
            if (plano == null)
                return NotFound(new { message = $"Plano com ID {id} não encontrado." });

            var temMatricula = await _context.Matriculas.AnyAsync(m => m.PlanoId == id);
            if (temMatricula)
                return Conflict(new { message = "Não é possível excluir plano com matrículas vinculadas. Desative-o." });

            _context.Planos.Remove(plano);
            await _context.SaveChangesAsync();

            return NoContent();
        }
    }
}
