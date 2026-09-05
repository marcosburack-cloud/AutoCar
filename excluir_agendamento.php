<?php

include 'conexao.php';

if (!isset($_GET["id"])) {
    header("Location: agendar.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "DELETE FROM agendamentos WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        header("Location: agendar.php?sucesso=exclusao");
    } else {
        header("Location: agendar.php?erro=nao_encontrado");
    }

} else {

    header("Location: agendar.php?erro=exclusao");
}

$stmt->close();
exit;