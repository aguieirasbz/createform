<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Gerador de Formulários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card-dashboard { transition: transform 0.2s, box-shadow 0.2s; border-radius: 15px; }
        .card-dashboard:hover { transform: translateY(-5px); box-shadow: 0px 6px 18px rgba(0,0,0,0.15); }
    </style>
</head>
<body class="container py-5">
    <h1 class="mb-4 text-center">⚙️ Painel Administrativo</h1>
    <p class="text-center text-muted mb-5">Gerencie formulários, campos e relatórios em um só lugar</p>
    <div class="row g-4">
        <div class="col-md-4">
            <a href="novo_formulario.php" class="text-decoration-none">
                <div class="card card-dashboard text-center p-4 h-100">
                    <div class="card-body">
                        <i class="bi bi-plus-circle display-4 text-primary"></i>
                        <h4 class="mt-3">Novo Formulário</h4>
                        <p class="text-muted">Crie rapidamente um novo formulário para sua empresa</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="index.php" class="text-decoration-none">
                <div class="card card-dashboard text-center p-4 h-100">
                    <div class="card-body">
                        <i class="bi bi-list-check display-4 text-success"></i>
                        <h4 class="mt-3">Formulários</h4>
                        <p class="text-muted">Gerencie os formulários já criados e adicione campos</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="index.php" class="text-decoration-none">
                <div class="card card-dashboard text-center p-4 h-100">
                    <div class="card-body">
                        <i class="bi bi-bar-chart-line display-4 text-warning"></i>
                        <h4 class="mt-3">Relatórios</h4>
                        <p class="text-muted">Visualize as respostas enviadas e exporte dados</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="mt-5 text-center">
        <small class="text-muted">📌 Sistema de Gerador de Formulários - <?php echo date("Y"); ?></small>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!-- Link rápido para gerenciamento -->
<div class="text-center m-3"><a href="gerenciar_formularios.php" class="btn btn-outline-primary">Gerenciar formulários</a></div>
