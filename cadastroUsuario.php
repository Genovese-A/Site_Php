<?php
require_once "valida.php";
require_once "conexao.php";

function h(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Carrega usuários
$usuarios = [];
$res = $conn->query("SELECT cpf, nome, senha FROM usuarios ORDER BY nome");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Cadastro de Usuários</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f5f5f5; }
        .topbar { background:#2e0152ff; color:#fff; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; }
        .topbar a { color:#fff; text-decoration:none; padding:8px 12px; border-radius:6px; background:#b78323ff; }
        .wrap { max-width: 1100px; margin: 18px auto; padding: 0 14px; }
        .card { background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.08); padding:18px; }
        h2 { margin: 0 0 12px; }
        label { display:block; font-size: 13px; margin: 10px 0 6px; color:#333; }
        input[type="text"], input[type="password"] { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; }
        .row { display:grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; }
        .btn { cursor:pointer; border:0; padding:10px 14px; border-radius:8px; font-weight:700; }
        .btn-primary { background:#004080; color:#fff; }
        .btn-danger { background:#b00020; color:#fff; }
        .btn-muted { background:#444; color:#fff; }
        table { width:100%; border-collapse:collapse; margin-top: 18px; }
        th, td { border-bottom:1px solid #eee; padding: 10px; text-align:left; vertical-align:middle; }
        th { background:#f7f7f7; }
        td input { width: 100%; }
        .actions { display:flex; gap:8px; }
        .small { font-size: 12px; color:#666; }
        .nav { display:flex; gap:10px; margin: 12px 0 0; }
        .nav a { color:#004080; text-decoration:none; font-weight:700; }
    </style>
</head>
<body>

<div class="topbar">
    <div>Olá, <?= h((string)($_SESSION['nome'] ?? '')) ?></div>
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="principal.php">Voltar</a>
        <a href="sair.php">Sair</a>
    </div>
</div>

<div class="wrap">
    <div class="card">
        <h2>Cadastrar usuário</h2>
        <p class="small">Dica: CPF sem pontos/traços (apenas números).</p>

        <form method="post" action="inserirUsuario.php" autocomplete="off">
            <div class="row">
                <div>
                    <label>CPF</label>
                     <input
                        type="text"
                        name="cpf"
                        id="cpf"
                        inputmode="numeric"
                        pattern="[0-9]{3,11}"
                        maxlength="11"
                        minlength="3"
                        required
                        oninput="this.value = this.value.replace(/\D/g,'')"
                        />
                </div>
                <div>
                    <label>Nome</label>
                    <input type="text" name="nome" required />
                </div>
                <div>
                    <label>Senha</label>
                    <input type="text" name="senha" required />
                </div>
            </div>
            <div style="margin-top: 12px;">
                <button class="btn btn-primary" type="submit">Inserir</button>
            </div>
        </form>

        <div class="nav">
            <a href="cadastroFilmes.php">Cadastro de Filmes</a>
            <a href="cadastroGeneros.php">Cadastro de Gêneros</a>
        </div>

        <h2 style="margin-top: 22px;">Usuários cadastrados</h2>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Senha</th>
                    <th style="width: 220px;">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u):
                $cpf = (string)$u['cpf'];
                $uid = preg_replace('/[^a-zA-Z0-9_]/', '_', $cpf);
                $formUpd = 'u_' . $uid;
                $formDel = 'd_' . $uid;
            ?>
                <tr>
                    <td><input form="<?= h($formUpd) ?>" type="text" name="nome" value="<?= h((string)$u['nome']) ?>" required /></td>
                    <td><input form="<?= h($formUpd) ?>" type="text" name="cpf" value="<?= h($cpf) ?>" required /></td>
                    <td><input form="<?= h($formUpd) ?>" type="text" name="senha" value="<?= h((string)$u['senha']) ?>" required /></td>
                    <td>
                        <div class="actions">
                            <input form="<?= h($formUpd) ?>" type="hidden" name="cpfAnterior" value="<?= h($cpf) ?>" />
                            <button form="<?= h($formUpd) ?>" class="btn btn-muted" type="submit">Alterar</button>

                            <input form="<?= h($formDel) ?>" type="hidden" name="cpf" value="<?= h($cpf) ?>" />
                            <button form="<?= h($formDel) ?>" class="btn btn-danger" type="submit" onclick="return confirm('Apagar este usuário?');">Apagar</button>
                        </div>

                        <!-- Forms reais (vazios), só para os inputs acima anexarem via atributo form -->
                        <form id="<?= h($formUpd) ?>" method="post" action="alterarUsuarios.php"></form>
                        <form id="<?= h($formDel) ?>" method="post" action="apagarUsuario.php"></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
