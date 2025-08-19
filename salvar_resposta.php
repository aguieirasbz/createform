<?php
require "config.php";
$formulario_id = (int)($_POST['formulario_id'] ?? 0);
if ($formulario_id <= 0) { die("Formulário inválido."); }

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare("INSERT INTO respostas (formulario_id, criado_em) VALUES (?, NOW())");
    $stmt->execute([$formulario_id]);
    $resposta_id = (int)$pdo->lastInsertId();

    foreach ($_POST as $chave => $valor) {
        if (strpos($chave, 'campo_') === 0) {
            $campo_id = (int)str_replace('campo_', '', $chave);
            if (is_array($valor)) { $valor = implode(', ', $valor); }
            $stmt2 = $pdo->prepare("INSERT INTO respostas_campos (resposta_id, campo_id, valor) VALUES (?, ?, ?)");
            $stmt2->execute([$resposta_id, $campo_id, $valor]);
        }
    }
    $pdo->commit();
    echo "<div style='padding:20px;font-family:sans-serif;'><h1>Resposta enviada com sucesso!</h1><a href='dashboard.php'>Voltar ao painel</a></div>";
} catch (Throwable $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo "Erro ao salvar resposta: " . htmlspecialchars($e->getMessage());
}
?>
