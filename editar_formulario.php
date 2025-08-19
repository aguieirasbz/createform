<?php
require 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { die("Formulário inválido."); }
$form = $pdo->prepare("SELECT * FROM formularios WHERE id=?");
$form->execute([$id]);
$form = $form->fetch();
if (!$form) { die("Formulário não encontrado."); }

// adicionar campo
if (isset($_POST['add'])) {
    $label = trim($_POST['label'] ?? '');
    $tipo  = $_POST['tipo'] ?? 'text';
    $opcoes = trim($_POST['opcoes'] ?? '');
    $obrigatorio = isset($_POST['obrigatorio']) ? 1 : 0;
    $ordemStmt = $pdo->prepare("SELECT COALESCE(MAX(ordem),0)+1 as prox FROM campos WHERE formulario_id=?");
    $ordemStmt->execute([$id]);
    $ordem = (int)$ordemStmt->fetch()['prox'];
    $stmt = $pdo->prepare("INSERT INTO campos (formulario_id, label, tipo, opcoes, obrigatorio, ordem, ativo) VALUES (?, ?, ?, ?, ?, ?, 1)");
    $stmt->execute([$id, $label, $tipo, $opcoes, $obrigatorio, $ordem]);
    header("Location: editar_formulario.php?id=".$id); exit;
}

// listar campos
$campos = $pdo->prepare("SELECT id, label, tipo, opcoes, obrigatorio, ordem, COALESCE(ativo,1) AS ativo FROM campos WHERE formulario_id=? ORDER BY ordem");
$campos->execute([$id]);
$campos = $campos->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Formulário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="container py-4">
    <div class="d-flex justify-content-between align-items-center">
      <h1 class="h3">Editar: <?= htmlspecialchars($form['nome']) ?></h1>
      <div class="d-flex gap-2">
        <a class="btn btn-outline-secondary" href="gerenciar_formularios.php">Voltar</a>
        <a class="btn btn-outline-warning" href="toggle_form.php?id=<?= (int)$id ?>"><i class="bi bi-power"></i> Ativar/Desativar</a>
      </div>
    </div>
    <p class="text-muted"><?= htmlspecialchars($form['descricao'] ?? '') ?></p>

    <div class="card mb-4">
      <div class="card-header">Adicionar campo</div>
      <div class="card-body">
        <form method="post" class="row g-3">
          <div class="col-md-4">
            <label class="form-label">Label</label>
            <input name="label" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select">
              <option value="text">Texto</option>
              <option value="textarea">Área de texto</option>
              <option value="select">Seleção</option>
              <option value="checkbox">Checkbox</option>
              <option value="radio">Radio</option>
              <option value="email">Email</option>
              <option value="number">Número</option>
              <option value="date">Data</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">Opções (se aplicável, vírgulas)</label>
            <input name="opcoes" class="form-control" placeholder="Ex: A,B,C">
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="obrig" name="obrigatorio">
              <label class="form-check-label" for="obrig">Obrigatório</label>
            </div>
          </div>
          <div class="mb-3">
            <label>Texto do Banner</label>
            <input type="text" name="banner_text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Texto do Rodapé</label>
            <input type="text" name="footer_text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Cor de Fundo</label>
            <input type="color" name="cor_fundo" value="#ffffff" class="form-control form-control-color">
        </div>
        <div class="mb-3">
            <label>Cor do Botão</label>
            <input type="color" name="cor_botao" value="#0d6efd" class="form-control form-control-color">
        </div>


          <div class="col-12">
            <button class="btn btn-primary" name="add" value="1">Adicionar</button>
          </div>
        </form>
      </div>
    </div>

    <h2 class="h5">Campos</h2>
    <table class="table table-hover align-middle">
      <thead><tr><th>#</th><th>Label</th><th>Tipo</th><th>Obrig.</th><th>Status</th><th>Ações</th></tr></thead>
      <tbody>
        <?php foreach ($campos as $c): ?>
          <tr>
            <td><?= (int)$c['id'] ?></td>
            <td><?= htmlspecialchars($c['label']) ?></td>
            <td><?= htmlspecialchars($c['tipo']) ?></td>
            <td><?= ((int)$c['obrigatorio']===1?'Sim':'Não') ?></td>
            <td><?= ((int)$c['ativo']===1?'<span class="badge bg-success">Ativo</span>':'<span class="badge bg-secondary">Inativo</span>') ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-outline-warning" href="toggle_field.php?id=<?= (int)$c['id'] ?>&form=<?= (int)$id ?>"><i class="bi bi-power"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</body>
</html>
