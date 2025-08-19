<?php
require "config.php";

// Fetch forms
$stmt = $pdo->query("SELECT id, nome, descricao, COALESCE(ativo,1) as ativo FROM formularios ORDER BY id DESC");
$formularios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Formulários</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3">Gerenciar Formulários</h1>
    <a href="novo_formulario.php" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Novo</a>
  </div>
  <div class="alert alert-info">
    <strong>Gerenciamento de Formulários</strong> - Aqui você pode criar, editar, ativar/desativar e excluir formulários.
    <br>
    Use os botões abaixo para gerenciar os formulários existentes.
  </div>
  <table class="table table-striped align-middle">
    <thead><tr>
      <th>ID</th><th>Nome</th><th>Descrição</th><th>Status</th><th>Ações</th>
    </tr></thead>
    <tbody>
      <?php foreach ($formularios as $f): ?>
      <tr>
        <td><?= htmlspecialchars($f['id']) ?></td>
        <td><?= htmlspecialchars($f['nome']) ?></td>
        <td><?= htmlspecialchars($f['descricao']) ?></td>
        <td>
          <?php if ((int)$f['ativo'] === 1): ?>
            <span class="badge bg-success">Ativo</span>
          <?php else: ?>
            <span class="badge bg-secondary">Inativo</span>
          <?php endif; ?>
        </td>
        <td class="d-flex gap-2">
          <a class="btn btn-sm btn-outline-primary" href="editar_formulario.php?id=<?= (int)$f['id'] ?>"><i class="bi bi-pencil"></i> Editar</a>
          <a class="btn btn-sm btn-outline-warning" href="toggle_form.php?id=<?= (int)$f['id'] ?>"><i class="bi bi-power"></i> Ativar/Desativar</a>
          <a class="btn btn-sm btn-outline-danger" href="delete_form.php?id=<?= (int)$f['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este formulário e suas dependências?');"><i class="bi bi-trash"></i> Excluir</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <a href="dashboard.php" class="btn btn-link">Voltar</a>
</body>
</html>
