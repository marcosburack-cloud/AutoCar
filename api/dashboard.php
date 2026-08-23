<?php

header('Content-Type: application/json');

include '../conexao.php';

$sql = "SELECT COUNT(*) AS total FROM agendamentos";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    echo json_encode([
        "erro" => "Erro ao consultar o banco de dados"
    ]);
    exit;
}

$dados = mysqli_fetch_assoc($resultado);

echo json_encode([
    "agendamentos" => (int) $dados['total']
]);