<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Painel - Formulários</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
    <h1>📑 Formulários Cadastrados</h1>
    <a href="novo_formulario.php" class="btn btn-primary mb-3">➕ Novo Formulário</a>
    <table class="table table-bordered">
        <tr><th>ID</th><th>Nome</th><th>Ações</th></tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM formularios ORDER BY id DESC");
        while ($f = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>{$f['id']}</td>
                    <td>{$f['nome']}</td>
                    <td>
                        <a href='editar_formulario.php?id={$f['id']}' class='btn btn-sm btn-warning'>Editar</a> 
                        <a href='gerar_formulario.php?id={$f['id']}' class='btn btn-sm btn-success'>Visualizar</a> 
                        <a href='gerar_formulario.php?id={$f['id']}' target='_blank' class='btn btn-sm btn-primary'>Acessar Formulário</a>
                        <a href='relatorio.php?id={$f['id']}' class='btn btn-sm btn-info'>Relatório</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>

<!-- Link rápido para gerenciamento -->
<a href="gerenciar_formularios.php" class="btn btn-outline-primary m-3">⚙️ Gerenciar formulários</a>
