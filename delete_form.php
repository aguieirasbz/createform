<?php
require "config.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    $pdo->beginTransaction();
    try {
        // Delete dependent rows if tables exist
        $pdo->prepare("DELETE FROM respostas_campos WHERE resposta_id IN (SELECT id FROM respostas WHERE formulario_id = ?)")->execute([$id]);
        $pdo->prepare("DELETE FROM respostas WHERE formulario_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM campos WHERE formulario_id = ?")->execute([$id]);
        $pdo->prepare("DELETE FROM formularios WHERE id = ?")->execute([$id]);
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo "Erro ao excluir: " . htmlspecialchars($e->getMessage());
        exit;
    }
}
header("Location: gerenciar_formularios.php");
exit;
