<?php
include("conexao.php");

if (!isset($_GET["id"])) {
    header("Location: servicos.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM servicos WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        header("Location: servicos.php?sucesso=exclusao");
    } else {
        header("Location: servicos.php?erro=nao_encontrado");
    }

} else {
    header("Location: servicos.php?erro=exclusao");
}

$stmt->close();
exit;