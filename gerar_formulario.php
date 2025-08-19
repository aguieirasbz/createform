<?php
require "config.php";
$formulario_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM formularios WHERE id = ? AND COALESCE(ativo,1)=1");
$stmt->execute([$formulario_id]);
$form = $stmt->fetch();
if (!$form) { die("Formulário indisponível."); }
$campos = $pdo->prepare("SELECT * FROM campos WHERE formulario_id = ? AND COALESCE(ativo,1)=1 ORDER BY ordem");
$campos->execute([$formulario_id]);
$campos = $campos->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($form['nome']); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #fff;
        }
        .header-custom {
            background: <?= htmlspecialchars($form['cor_fundo'] ?? '#0d6efd') ?>;
            color: #fff;
            padding: 1.5rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        .footer-custom {
            background: <?= htmlspecialchars($form['cor_botao'] ?? '#0d6efd') ?>;
            color: #fff;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 2rem;
            text-align: center;
        }
        .banner {
            width: 100%;
            height: 200px;
            background: url('<?= htmlspecialchars($form['banner_img'] ?? '') ?>') center/cover no-repeat;
            display: <?= empty($form['banner_img']) ? 'none' : 'block' ?>;
            border-radius: 8px 8px 0 0;
        }
    </style>
</head>
<body class="container py-4">
    <div class="banner"></div>
    <div class="header-custom">
        <h1><?= htmlspecialchars($form['banner_text'] ?: $form['nome']); ?></h1>
        <p><?= htmlspecialchars($form['descricao'] ?? ''); ?></p>
    </div>

    <form method="post" action="salvar_resposta.php" class="row g-3">
        <input type="hidden" name="formulario_id" value="<?= (int)$formulario_id ?>">
        <?php foreach ($campos as $campo): ?>
            <div class="col-12">
                <label class="form-label"><?= htmlspecialchars($campo['label']) ?><?= (int)$campo['obrigatorio']===1?' *':'' ?></label>
                <?php
                $name = 'campo_' . (int)$campo['id'];
                $required = ((int)$campo['obrigatorio']===1) ? 'required' : '';
                switch ($campo['tipo']) {
                    case 'textarea':
                        echo "<textarea class='form-control' name='$name' $required></textarea>";
                        break;
                    case 'select':
                        echo "<select class='form-select' name='$name' $required>";
                        $opcoes = array_map('trim', explode(',', $campo['opcoes'] ?? ''));
                        foreach ($opcoes as $o) { if ($o==='') continue; echo "<option value='".htmlspecialchars($o,ENT_QUOTES)."'>".htmlspecialchars($o)."</option>"; }
                        echo "</select>";
                        break;
                    case 'checkbox':
                        $opcoes = array_map('trim', explode(',', $campo['opcoes'] ?? ''));
                        foreach ($opcoes as $o) {
                            if ($o==='') continue;
                            $idc = md5($name.$o);
                            echo "<div class='form-check'><input class='form-check-input' id='$idc' type='checkbox' name='{$name}[]' value='".htmlspecialchars($o,ENT_QUOTES)."'><label class='form-check-label' for='$idc'>".htmlspecialchars($o)."</label></div>";
                        }
                        break;
                    case 'radio':
                        $opcoes = array_map('trim', explode(',', $campo['opcoes'] ?? ''));
                        foreach ($opcoes as $o) {
                            if ($o==='') continue;
                            $idc = md5($name.$o);
                            echo "<div class='form-check'><input class='form-check-input' id='$idc' type='radio' name='{$name}' value='".htmlspecialchars($o,ENT_QUOTES)."' $required><label class='form-check-label' for='$idc'>".htmlspecialchars($o)."</label></div>";
                        }
                        break;
                    default:
                        $type = in_array($campo['tipo'], ['email','number','date','text']) ? $campo['tipo'] : 'text';
                        echo "<input class='form-control' type='$type' name='$name' $required>";
                }
                ?>
            </div>
        <?php endforeach; ?>
        <div class="col-12"><button type="submit" class="btn btn-success">Enviar</button></div>
    </form>
    <footer class="footer-custom">
        <small><?= htmlspecialchars($form['footer_text'] ?? '') ?></small>
    </footer>
</body>
</html>
