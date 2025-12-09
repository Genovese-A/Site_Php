<?php
require_once "valida.php";
require_once "conexao.php";

function h(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// Carrega gêneros
$generos = [];
$resG = $conn->query("SELECT genero, descricao FROM generos ORDER BY descricao");
if ($resG) {
    while ($row = $resG->fetch_assoc()) {
        $generos[] = $row;
    }
}

// Carrega filmes (com descrição do gênero)
$filmes = [];
$sqlF = "SELECT f.filme, f.nome, f.ano, f.genero, g.descricao AS genero_desc
         FROM filmes f
         INNER JOIN generos g ON g.genero = f.genero
         ORDER BY f.nome";
$resF = $conn->query($sqlF);
if ($resF) {
    while ($row = $resF->fetch_assoc()) {
        $filmes[] = $row;
    }
}

function renderGeneroOptions(array $generos, int $selected = 0): string {
    $html = '';
    foreach ($generos as $g) {
        $id = (int)$g['genero'];
        $desc = (string)$g['descricao'];
        $sel = ($id === $selected) ? ' selected' : '';
        $html .= '<option value="' . htmlspecialchars((string)$id, ENT_QUOTES) . '"' . $sel . '>' . htmlspecialchars($desc, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</option>';
    }
    return $html;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Cadastro de Filmes</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f5f5f5; }
        .topbar { background:#2e0152ff; color:#fff; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; }
        .topbar a { color:#fff; text-decoration:none; padding:8px 12px; border-radius:6px; background:#b78323ff; }
        .wrap { max-width: 1100px; margin: 18px auto; padding: 0 14px; }
        .card { background:#fff; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,.08); padding:18px; }
        h2 { margin: 0 0 12px; }
        label { display:block; font-size: 13px; margin: 10px 0 6px; color:#333; }
        input[type="text"], select { width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:8px; }
        .row { display:grid; grid-template-columns: 2fr 1fr 1.5fr; gap: 12px; }
        .btn { cursor:pointer; border:0; padding:10px 14px; border-radius:8px; font-weight:700; }
        .btn-primary { background:#004080; color:#fff; }
        .btn-danger { background:#b00020; color:#fff; }
        .btn-muted { background:#444; color:#fff; }
        table { width:100%; border-collapse:collapse; margin-top: 18px; }
        th, td { border-bottom:1px solid #eee; padding: 10px; text-align:left; vertical-align:middle; }
        th { background:#f7f7f7; }
        td input, td select { width: 100%; }
        .actions { display:flex; gap:8px; }
        .nav { display:flex; gap:10px; margin: 12px 0 0; }
        .nav a { color:#004080; text-decoration:none; font-weight:700; }
        .warn { background:#fff3cd; border:1px solid #ffeeba; padding:10px 12px; border-radius:10px; margin-top:12px; color:#856404; }
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
        <h2>Cadastrar filme</h2>

        <?php if (count($generos) === 0): ?>
            <div class="warn">
                Você ainda não tem gêneros cadastrados. Cadastre pelo menos 1 em <a href="cadastroGeneros.php">Cadastro de Gêneros</a>.
            </div>
        <?php endif; ?>

        <form method="post" action="inserirFilme.php" autocomplete="off">
            <div class="row">
                <div>
                    <label>Nome</label>
                    <input type="text" name="nome" required />
                </div>
                <div>
                    <label>Ano</label>
                    <input type="text" name="ano" required />
                </div>
                <div>
                    <label>Gênero</label>
                    <select name="genero" required>
                        <option value="">Selecione</option>
                        <?= renderGeneroOptions($generos) ?>
                    </select>
                </div>
            </div>
            <div style="margin-top: 12px;">
                <button class="btn btn-primary" type="submit">Inserir</button>
            </div>
        </form>

        <div class="nav">
            <a href="cadastroUsuario.php">Cadastro de Usuários</a>
            <a href="cadastroGeneros.php">Cadastro de Gêneros</a>
        </div>

        <h2 style="margin-top: 22px;">Filmes cadastrados</h2>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ano</th>
                    <th>Gênero</th>
                    <th style="width: 220px;">Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($filmes as $f):
                $fid = (int)$f['filme'];
                $formUpd = 'fu_' . $fid;
                $formDel = 'fd_' . $fid;
            ?>
                <tr>
                    <td><input form="<?= h($formUpd) ?>" type="text" name="nome" value="<?= h((string)$f['nome']) ?>" required /></td>
                    <td><input form="<?= h($formUpd) ?>" type="text" name="ano" value="<?= h((string)$f['ano']) ?>" required /></td>
                    <td>
                        <select form="<?= h($formUpd) ?>" name="genero" required>
                            <?= renderGeneroOptions($generos, (int)$f['genero']) ?>
                        </select>
                    </td>
                    <td>
                        <div class="actions">
                            <input form="<?= h($formUpd) ?>" type="hidden" name="filmeId" value="<?= h((string)$fid) ?>" />
                            <button form="<?= h($formUpd) ?>" class="btn btn-muted" type="submit">Alterar</button>

                            <input form="<?= h($formDel) ?>" type="hidden" name="filme" value="<?= h((string)$fid) ?>" />
                            <button form="<?= h($formDel) ?>" class="btn btn-danger" type="submit" onclick="return confirm('Apagar este filme?');">Apagar</button>
                        </div>

                        <form id="<?= h($formUpd) ?>" method="post" action="alterarFilmes.php"></form>
                        <form id="<?= h($formDel) ?>" method="post" action="apagarFilme.php"></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

</body>
</html>
