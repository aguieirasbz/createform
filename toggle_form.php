<?php
require "config.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
    // Flip ativo (assume default 1 if null)
    $pdo->exec("UPDATE formularios SET ativo = 1 - COALESCE(ativo,1) WHERE id = $id");
}
header("Location: gerenciar_formularios.php");
exit;
