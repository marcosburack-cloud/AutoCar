<?php

header('Content-Type: application/json');

include '../conexao.php';

$limite = 1000;
$offset = 0;
$servico = null;

$sql = "CALL sp_dashboard_agendamentos(?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "erro" => "Erro ao preparar a consulta."
    ]);
    exit;
}

$stmt->bind_param("iis", $limite, $offset, $servico);

if (!$stmt->execute()) {
    echo json_encode([
        "erro" => "Erro ao executar a Stored Procedure."
    ]);
    $stmt->close();
    exit;
}

$resultado = $stmt->get_result();

$agendamentos = [];

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $agendamentos[] = $linha;
    }
}

$stmt->close();

while ($conn->more_results() && $conn->next_result()) {
}

// Quantidade de serviços
$resultadoServicos = $conn->query(
    "SELECT COUNT(*) AS total FROM servicos"
);

$servicos = 0;

if ($resultadoServicos) {
    $dadosServicos = $resultadoServicos->fetch_assoc();
    $servicos = (int) $dadosServicos["total"];
}

// Quantidade de produtos
$resultadoProdutos = $conn->query(
    "SELECT COUNT(*) AS total FROM produtos"
);

$produtos = 0;

if ($resultadoProdutos) {
    $dadosProdutos = $resultadoProdutos->fetch_assoc();
    $produtos = (int) $dadosProdutos["total"];
}

// Faturamento estimado dos agendamentos
$faturamento = 0;

foreach ($agendamentos as $agendamento) {
    $preco = (float) ($agendamento["preco_servico"] ?? 0);
    $faturamento += $preco;
}

// Serviço mais agendado
$frequenciaServicos = [];

foreach ($agendamentos as $agendamento) {

    $nomeServico = $agendamento["nome_servico"] ?? "";

    if ($nomeServico === "") {
        continue;
    }

    if (!isset($frequenciaServicos[$nomeServico])) {
        $frequenciaServicos[$nomeServico] = 0;
    }

    $frequenciaServicos[$nomeServico]++;
}

$servicoMaisAgendado = "Nenhum";

if (!empty($frequenciaServicos)) {
    arsort($frequenciaServicos);
    $servicoMaisAgendado = array_key_first($frequenciaServicos);
}

echo json_encode([
    "agendamentos" => count($agendamentos),
    "servicos" => $servicos,
    "produtos" => $produtos,
    "faturamento" => $faturamento,
    "servicoMaisAgendado" => $servicoMaisAgendado,
    "dadosAgendamentos" => $agendamentos
]);