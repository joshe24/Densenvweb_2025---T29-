README

Este projeto foi desenvolvido para que estabelecimentos possam coletar avaliações de clientes de forma simples e organizada. Ele permite registrar notas e feedbacks sobre diferentes setores, como Recepção, Vendas, Caixa, Estacionamento, entre outros.

O sistema possui:

Uma página de avaliação adaptada para tablets

Um painel administrativo com login

Cadastro e gerenciamento de perguntas

Cadastro de dispositivos (tablets/setores)

Exibição das avaliações e médias por setor

Funcionalidades:
Coleta de Avaliações:

Interface responsiva para tablets

Perguntas carregadas automaticamente a partir do banco

Notas de 0 a 10

Feedback textual (opcional)

Registra data e hora automaticamente

Associação da resposta ao setor/dispositivo

Painel Administrativo:

Login com autenticação

Cadastro/edição/ativação/inativação de perguntas

Cadastro de dispositivos

Listagem completa das avaliações

Cálculo de médias por pergunta e por setor

Gráficos simples (opcional)

Tecnologias Utilizadas:

PHP

PostgreSQL

HTML / CSS

JavaScript

Código organizado com require_once e funções

Segurança:

Autenticação obrigatória para o painel administrativo

Sanitização de inputs

Proteção contra SQL Injection

Banco de Dados:

O banco contém as seguintes tabelas:

usuarios

perguntas

dispositivos

avaliacoes

Todos os campos, chaves primárias e relacionamentos estão definidos no arquivo setup.sql.

Passo a Passo de Instalação
1. Clonar o repositório
git clone https://github.com/SEU_USUARIO/NOME_DO_REPOSITORIO.git

2. Importar o banco de dados

Abra o terminal e rode:

psql -U postgres -f sql/setup.sql


Isso criará todas as tabelas necessárias.

3. Configurar o arquivo de conexão

No arquivo config.php, ajuste suas credenciais:

$db_host = "localhost";
$db_user = "postgres";
$db_pass = "SUA_SENHA";
$db_name = "avaliacao";

4. Colocar o projeto no servidor

Copie a pasta para dentro do:

htdocs (XAMPP)

www (WAMP)

ou servidor Apache/Nginx configurado

5. Acessar o sistema

Página de Avaliação:

http://localhost/public/index.php

Painel Administrativo:

http://localhost/public/admin.php


Use o login criado no script SQL.

Considerações:

Este projeto foi desenvolvido com foco em praticidade e organização, garantindo que tanto o cliente quanto o administrador tenham uma experiência simples e eficiente.
O sistema pode ser facilmente expandido, incluindo novos gráficos, filtros e módulos conforme necessário.