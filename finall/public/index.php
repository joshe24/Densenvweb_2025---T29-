
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <title>Avaliação de Qualidade</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <main class="container">
    <h1>Avaliação de Qualidade dos Serviços</h1>
    <p class="lead">Avalie nossos serviços de forma anônima. Sua opinião é muito importante!</p>

    <form id="formAvaliacao" action="../src/respostas.php" method="POST" novalidate>

      <section class="pergunta">
        <label class="q-title">1. Como você avalia nosso atendimento?</label>

        <div class="legendas">
          <span class="left">Improvável</span>
          <span class="right">Muito Provável</span>
        </div>

        <div class="escala">
          <?php for ($i = 0; $i <= 10; $i++): ?>
            <input 
              type="radio" 
              id="p1_<?= $i ?>" 
              name="pergunta_1" 
              value="<?= $i ?>" 
              class="radio-hidden" 
              required
            />
            <label for="p1_<?= $i ?>" class="nota" data-value="<?= $i ?>"><?= $i ?></label>
          <?php endfor; ?>
        </div>
      </section>


      <section class="pergunta">
        <label class="q-title">2. Como você avalia nossa estrutura?</label>

        <div class="legendas">
          <span class="left">Improvável</span>
          <span class="right">Muito Provável</span>
        </div>

        <div class="escala">
          <?php for ($i = 0; $i <= 10; $i++): ?>
            <input 
              type="radio" 
              id="p2_<?= $i ?>" 
              name="pergunta_2" 
              value="<?= $i ?>" 
              class="radio-hidden" 
              required
            />
            <label for="p2_<?= $i ?>" class="nota" data-value="<?= $i ?>"><?= $i ?></label>
          <?php endfor; ?>
        </div>
      </section>

    
      <section class="pergunta">
        <label class="q-title">3. Você recomendaria nosso estabelecimento?</label>

        <div class="legendas">
          <span class="left">Improvável</span>
          <span class="right">Muito Provável</span>
        </div>

        <div class="escala">
          <?php for ($i = 0; $i <= 10; $i++): ?>
            <input 
              type="radio" 
              id="p3_<?= $i ?>" 
              name="pergunta_3" 
              value="<?= $i ?>" 
              class="radio-hidden" 
              required
            />
            <label for="p3_<?= $i ?>" class="nota" data-value="<?= $i ?>"><?= $i ?></label>
          <?php endfor; ?>
        </div>
      </section>

    
      <section class="pergunta aberta">
        <label for="comentario" class="q-title">Deseja deixar algum comentário (opcional)?</label>
        <textarea
          id="comentario"
          name="comentario"
          placeholder="Escreva aqui (opcional)"
        ></textarea>
      </section>

      <p class="anonimo">Sua avaliação é totalmente anônima. Nenhuma informação pessoal é solicitada ou armazenada.</p>

      <div class="actions">
        <button type="submit" class="btn">Enviar Avaliação</button>
      </div>
    </form>
  </main>

  <script src="js/script.js"></script>
</body>
</html>
