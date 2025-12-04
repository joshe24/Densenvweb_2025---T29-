<?php
/*
CREATE TABLE avaliacoes (
  id SERIAL PRIMARY KEY,
  atendimento INT NOT NULL,
  limpeza INT NOT NULL,
  infraestrutura INT NOT NULL,
  comentario TEXT,
  data_registro TIMESTAMP WITH TIME ZONE DEFAULT now()
);
*/
$questions = [
    ['key' => 'atendimento', 'text' => '1. Como você avalia o Atendimento?'],
    ['key' => 'limpeza',       'text' => '2. Como você avalia a Limpeza?'],
    ['key' => 'infraestrutura','text' => '3. Como você avalia a Infraestrutura?']
];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Avaliação de Qualidade</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="styless.css">
</head>
<body>
  <main class="container">
    <h1>Avaliação de Qualidade dos Serviços</h1>
    <p class="lead">Avalie nossos serviços de forma anônima. Sua opinião é muito importante!</p>

    <form id="formAvaliacao" action="obrigado.php" method="POST" novalidate>
      <?php foreach ($questions as $q): ?>
        <section class="pergunta">
          <label class="q-title"><?= htmlspecialchars($q['text']) ?></label>

          <div class="legendas">
            <span class="left">Improvável</span>
            <span class="right">Muito Provável</span>
          </div>

          <div class="escala" role="radiogroup" aria-label="<?= htmlspecialchars($q['text']) ?>">
            <?php for ($i = 0; $i <= 10; $i++):      
                $id = $q['key'] . '_' . $i;
            ?>
              <input type="radio"
                     id="<?= $id ?>"
                     name="<?= htmlspecialchars($q['key']) ?>"
                     value="<?= $i ?>"
                     <?php if ($i === 0) echo 'required'; ?>
                     class="radio-hidden">
              <label for="<?= $id ?>" class="nota" data-value="<?= $i ?>"><?= $i ?></label>
            <?php endfor; ?>
          </div>
        </section>
      <?php endforeach; ?>
      <section class="pergunta aberta">
        <label for="comentario" class="q-title">4. Deseja deixar algum comentário (opcional)?</label>
        <textarea id="comentario" name="comentario" placeholder="Escreva aqui (opcional)"></textarea>
      </section>
      <p class="anonimo">Sua avaliação espontânea é anônima. Nenhuma informação pessoal é solicitada ou armazenada.</p>
      <div class="actions">
        <button type="submit" class="btn">Enviar Avaliação</button>
      </div>
    </form>
  </main>
  <script src="script.js"></script>
</body>
</html>