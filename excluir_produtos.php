<?php
include 'conexao.php';

if (!isset($_GET["id"])) {
    header("Location: produtos.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM produtos WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        header("Location: produtos.php?sucesso=exclusao");
    } else {
        header("Location: produtos.php?erro=nao_encontrado");
    }

} else {
    header("Location: produtos.php?erro=exclusao");
}

$stmt->close();
exit;