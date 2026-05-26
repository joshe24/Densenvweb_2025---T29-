using Microsoft.EntityFrameworkCore;
using AcademiaAPI.Data;
using Microsoft.OpenApi.Models;
using System.Reflection;

var builder = WebApplication.CreateBuilder(args);


builder.Services.AddControllers();


builder.Services.AddDbContext<AcademiaContext>(options =>
    options.UseSqlite(builder.Configuration.GetConnectionString("DefaultConnection")
        ?? "Data Source=academia.db"));


builder.Services.AddCors(options =>
{
    options.AddPolicy("AllowAll", policy =>
        policy.AllowAnyOrigin()
              .AllowAnyMethod()
              .AllowAnyHeader());
});


builder.Services.AddEndpointsApiExplorer();
builder.Services.AddSwaggerGen(c =>
{
    c.SwaggerDoc("v1", new OpenApiInfo
    {
        Title = "Academia API",
        Version = "v1",
        Description = "Sistema de Gerenciamento de Academia — REST WebService\n\n" +
                      "## Entidades\n" +
                      "- **Aluno** — Cadastro e gestão de alunos\n" +
                      "- **Professor** — Cadastro e gestão de professores\n" +
                      "- **Plano** — Planos de associação disponíveis\n" +
                      "- **Matrícula** — Vínculo entre Aluno, Plano e Professor\n\n" +
                      "## Status de Matrícula\n" +
                      "`1 = Ativa | 2 = Suspensa | 3 = Cancelada | 4 = Vencida`",
        Contact = new OpenApiContact { Name = "Sistema Academia", Email = "admin@academia.com" }
    });


    var xmlFile = $"{Assembly.GetExecutingAssembly().GetName().Name}.xml";
    var xmlPath = Path.Combine(AppContext.BaseDirectory, xmlFile);
    if (File.Exists(xmlPath))
        c.IncludeXmlComments(xmlPath);
});

var app = builder.Build();


using (var scope = app.Services.CreateScope())
{
    var db = scope.ServiceProvider.GetRequiredService<AcademiaContext>();
    db.Database.EnsureCreated();
}


app.UseSwagger();
app.UseSwaggerUI(c =>
{
    c.SwaggerEndpoint("/swagger/v1/swagger.json", "Academia API v1");
    c.RoutePrefix = string.Empty; 
    c.DocumentTitle = "Academia API — Swagger UI";
});

app.UseCors("AllowAll");
app.UseAuthorization();
app.MapControllers();

app.Run();
