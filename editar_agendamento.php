<?php

include 'conexao.php';
include 'header.php';

if (!isset($_GET["id"])) {
    header("Location: agendar.php");
    exit;
}

$id = (int) $_GET["id"];

// BUSCAR AGENDAMENTO
$sql = "SELECT
            id,
            nome_cliente,
            telefone,
            modelo_carro,
            placa,
            servico_id,
            data_agendamento,
            hora_agendamento
        FROM agendamentos
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$agendamento = $resultado->fetch_assoc();

$stmt->close();

if (!$agendamento) {
    header("Location: agendar.php?erro=nao_encontrado");
    exit;
}

?>

<div class="container mt-5">
    <div class="card">

        <div class="card-body">

            <h2 class="mb-4">
                Editar Agendamento
            </h2>

            <form method="POST" action="agendar.php">

                <input
                    type="hidden"
                    name="acao"
                    value="editar"
                >

                <input
                    type="hidden"
                    name="id"
                    value="<?= $agendamento["id"] ?>"
                >


                <div class="mb-3">

                    <label>Nome</label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= htmlspecialchars($agendamento["nome_cliente"]) ?>"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Telefone</label>

                    <input
                        type="text"
                        name="telefone"
                        class="form-control"
                        value="<?= htmlspecialchars($agendamento["telefone"]) ?>"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Modelo do Carro</label>

                    <input
                        type="text"
                        name="carro"
                        class="form-control"
                        value="<?= htmlspecialchars($agendamento["modelo_carro"]) ?>"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Placa</label>

                    <input
                        type="text"
                        name="placa"
                        class="form-control"
                        value="<?= htmlspecialchars($agendamento["placa"]) ?>"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Serviço</label>

                    <select
                        name="servico"
                        class="form-control"
                        required
                    >

                        <?php

                        $sqlServicos = "SELECT id, nome FROM servicos ORDER BY nome";
                        $resultadoServicos = $conn->query($sqlServicos);

                        while ($servico = $resultadoServicos->fetch_assoc()):

                        ?>

                            <option
                                value="<?= $servico["id"] ?>"
                                <?= $servico["id"] == $agendamento["servico_id"] ? "selected" : "" ?>
                            >
                                <?= htmlspecialchars($servico["nome"]) ?>
                            </option>

                        <?php endwhile; ?>

                    </select>

                </div>


                <div class="mb-3">

                    <label>Data</label>

                    <input
                        type="date"
                        name="data"
                        class="form-control"
                        value="<?= $agendamento["data_agendamento"] ?>"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Hora</label>

                    <input
                        type="time"
                        name="hora"
                        class="form-control"
                        value="<?= $agendamento["hora_agendamento"] ?>"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="btn btn-success"
                >
                    💾 Salvar alterações
                </button>

                <a
                    href="agendar.php"
                    class="btn btn-secondary"
                >
                    ↩️ Voltar
                </a>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>