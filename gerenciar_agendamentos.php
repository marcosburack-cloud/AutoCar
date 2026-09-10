<?php
session_start();

if (!isset($_SESSION["admin_logado"]) || $_SESSION["admin_logado"] !== true) {
    header("Location: login_admin.php");
    exit;
}

include("conexao.php");

$mensagem = "";
$tipoMensagem = "";

if (isset($_GET["sucesso"])) {
    if ($_GET["sucesso"] === "edicao") {
        $mensagem = "Agendamento atualizado com sucesso!";
        $tipoMensagem = "success";
    } elseif ($_GET["sucesso"] === "exclusao") {
        $mensagem = "Agendamento excluído com sucesso!";
        $tipoMensagem = "success";
    }
}

if (isset($_GET["erro"])) {
    if ($_GET["erro"] === "nao_encontrado") {
        $mensagem = "Agendamento não encontrado.";
        $tipoMensagem = "warning";
    } elseif ($_GET["erro"] === "exclusao") {
        $mensagem = "Não foi possível excluir o agendamento.";
        $tipoMensagem = "danger";
    }
}

$sql = "
    SELECT
        a.id,
        a.nome_cliente,
        a.telefone,
        a.modelo_carro,
        a.placa,
        a.data_agendamento,
        a.hora_agendamento,
        s.nome AS nome_servico
    FROM agendamentos a
    LEFT JOIN servicos s
        ON a.servico_id = s.id
    ORDER BY a.data_agendamento DESC, a.hora_agendamento DESC
";

$resultado = $conn->query($sql);
?>

<?php include("header.php"); ?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Gerenciar Agendamentos</h2>
            <p class="text-muted mb-0">
                Área exclusiva para administradores.
            </p>
        </div>

        <a href="admin.php" class="btn btn-secondary">
            Voltar ao painel
        </a>
    </div>

    <?php if ($mensagem !== ""): ?>
        <div class="alert alert-<?= $tipoMensagem ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="mb-3">Agendamentos cadastrados</h4>

            <div class="table-responsive">

                <table class="table table-striped table-hover">

                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>Carro</th>
                            <th>Placa</th>
                            <th>Serviço</th>
                            <th>Data</th>
                            <th>Hora</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($resultado && $resultado->num_rows > 0): ?>

                            <?php while ($agendamento = $resultado->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($agendamento["nome_cliente"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento["telefone"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento["modelo_carro"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento["placa"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $agendamento["nome_servico"] ?? "Não informado"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento["data_agendamento"]) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($agendamento["hora_agendamento"]) ?>
                                    </td>

                                    <td class="text-nowrap">

                                        <a
                                            href="editar_agendamento.php?id=<?= (int) $agendamento["id"] ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="excluir_agendamento.php?id=<?= (int) $agendamento["id"] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este agendamento?');"
                                        >
                                            Excluir
                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="8" class="text-center">
                                    Nenhum agendamento cadastrado.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

<?php include("footer.php"); ?>