<?php
require_once "valida.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Nossos Serviços</title>
  <style>
    body { font-family: Arial, sans-serif; background-color: #ffffff; margin: 0; }
    header { background-color: #2980b9; color: white; padding: 30px; text-align: center; }
    section { max-width: 900px; margin: 40px auto; padding: 30px; }
    .servico { background-color: #f4f4f4; margin-bottom: 20px; padding: 20px; border-left: 5px solid #2980b9; }
    .top { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:#2e0152ff; color:#fff; }
    .top a { color:#fff; text-decoration:none; background:#b78323ff; padding:8px 12px; border-radius:8px; }
  </style>
</head>
<body>
  <div class="top">
    <div>Olá, <?= htmlspecialchars((string)($_SESSION['nome'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></div>
    <div style="display:flex; gap:10px;">
      <a href="principal.php">Voltar</a>
      <a href="sair.php">Sair</a>
    </div>
  </div>

  <header>
    <h1>Nossos Serviços</h1>
    <p>Conheça o que oferecemos</p>
  </header>

  <section>
    <div class="servico">
      <h2>Cadastro de Usuários</h2>
      <p>Gerencie usuários (criar, editar e remover).</p>
    </div>
    <div class="servico">
      <h2>Cadastro de Gêneros</h2>
      <p>Crie e mantenha os gêneros, com segurança para não quebrar os filmes já cadastrados.</p>
    </div>
    <div class="servico">
      <h2>Cadastro de Filmes</h2>
      <p>Cadastre filmes e associe cada um ao seu gênero.</p>
    </div>
  </section>
</body>
</html>
