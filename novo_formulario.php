<?php require 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Novo Formulário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">

    <h1>Criar Novo Formulário</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descrição:</label>
            <textarea name="descricao" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="ativo" name="ativo" checked>
            <label class="form-check-label" for="ativo">Ativo</label>
        </div>

        <div class="mb-3">
            <label>Texto do Banner</label>
            <input type="text" name="banner_text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Imagem do Banner</label>
            <input type="file" name="banner_img" class="form-control">
            <small class="text-muted">Formatos aceitos: JPG, PNG</small>
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

        <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
        <a href="gerenciar_formularios.php" class="btn btn-link">Cancelar</a>
    </form>
</body>
</html>

<?php
if (isset($_POST['salvar'])) {
    $nome        = trim($_POST['nome'] ?? '');
    $descricao   = trim($_POST['descricao'] ?? '');
    $ativo       = isset($_POST['ativo']) ? 1 : 0;
    $banner_text = trim($_POST['banner_text'] ?? '');
    $footer_text = trim($_POST['footer_text'] ?? '');
    $cor_fundo   = $_POST['cor_fundo'] ?? '#ffffff';
    $cor_botao   = $_POST['cor_botao'] ?? '#0d6efd';
    $banner_img  = null;

    // Upload da imagem do banner
    if (!empty($_FILES['banner_img']['name'])) {
        $ext = strtolower(pathinfo($_FILES['banner_img']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png'])) {
            $newName = uniqid("banner_") . "." . $ext;
            $uploadDir = __DIR__ . "/uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $destPath = $uploadDir . $newName;
            if (move_uploaded_file($_FILES['banner_img']['tmp_name'], $destPath)) {
                $banner_img = "uploads/" . $newName;
            }
        }
    }

    $stmt = $pdo->prepare("INSERT INTO formularios 
        (nome, descricao, ativo, banner_text, banner_img, footer_text, cor_fundo, cor_botao) 
        VALUES (:n, :d, :a, :bt, :bi, :ft, :cf, :cb)");

    $stmt->execute([
        ':n'  => $nome,
        ':d'  => $descricao,
        ':a'  => $ativo,
        ':bt' => $banner_text,
        ':bi' => $banner_img,
        ':ft' => $footer_text,
        ':cf' => $cor_fundo,
        ':cb' => $cor_botao
    ]);

    header("Location: gerenciar_formularios.php");
    exit;
}
?>
