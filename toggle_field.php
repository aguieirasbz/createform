<?php
require "config.php";
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$form = isset($_GET['form']) ? (int)$_GET['form'] : 0;
if ($id > 0) {
    $pdo->exec("UPDATE campos SET ativo = 1 - COALESCE(ativo,1) WHERE id = $id");
}
header("Location: editar_formulario.php?id=".$form);
exit;
