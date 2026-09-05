<?php

include 'conexao.php';
include 'header.php';

$mensagem = "";
if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["acao"])
    && $_POST["acao"] === "editar"
) {

    $id = (int) $_POST["id"];
    $nome = trim($_POST["nome"]);
    $telefone = trim($_POST["telefone"]);
    $carro = trim($_POST["carro"]);
    $placa = trim($_POST["placa"]);
    $servico = (int) $_POST["servico"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];

    $sql = "UPDATE agendamentos
            SET nome_cliente = ?,
                telefone = ?,
                modelo_carro = ?,
                placa = ?,
                servico_id = ?,
                data_agendamento = ?,
                hora_agendamento = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssissi",
        $nome,
        $telefone,
        $carro,
        $placa,
        $servico,
        $data,
        $hora,
        $id
    );

    if ($stmt->execute()) {

        header("Location: agendar.php?sucesso=edicao");
        exit;

    } else {

        $mensagem = "Erro ao editar agendamento.";
    }

    $stmt->close();
}
// CADASTRAR AGENDAMENTO
if (isset($_POST['agendar'])) {

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $carro = trim($_POST['carro']);
    $placa = trim($_POST['placa']);
    $servico = (int) $_POST['servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO agendamentos
            (nome_cliente, telefone, modelo_carro, placa, servico_id, data_agendamento, hora_agendamento)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssiss",
        $nome,
        $telefone,
        $carro,
        $placa,
        $servico,
        $data,
        $hora
    );

    if ($stmt->execute()) {

        header("Location: agendar.php?sucesso=cadastro");
        exit;

    } else {

        $mensagem = "Erro ao realizar o agendamento.";
    }

    $stmt->close();
}


if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastro') {

    $mensagem = "Agendamento realizado com sucesso!";
}
if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'edicao') {
    $mensagem = "Agendamento editado com sucesso!";
}
if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'exclusao') {
    $mensagem = "Agendamento excluído com sucesso!";
}

if (isset($_GET['erro'])) {

    if ($_GET['erro'] === 'nao_encontrado') {
        $mensagem = "Não foi possível excluir: agendamento não encontrado.";
    }

    if ($_GET['erro'] === 'exclusao') {
        $mensagem = "Erro ao excluir o agendamento.";
    }
}
?>

<div class="container mt-5">

    <?php if ($mensagem !== ""): ?>

        <div class="alert alert-success text-center">
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>


    <div class="card">

        <div class="card-body">

            <h2>Agendar Serviço</h2>

            <form method="POST">

                <div class="mb-3">

                    <label>Nome</label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Telefone</label>

                    <input
                        type="text"
                        name="telefone"
                        class="form-control"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Modelo do Carro</label>

                    <input
                        type="text"
                        name="carro"
                        class="form-control"
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Placa</label>

                    <input
                        type="text"
                        name="placa"
                        class="form-control"
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

                        <option value="">
                            Selecione um serviço
                        </option>

                        <?php

                        $sqlServicos = "SELECT id, nome FROM servicos ORDER BY nome";
                        $resultado = mysqli_query($conn, $sqlServicos);

                        while ($s = mysqli_fetch_assoc($resultado)):

                        ?>

                            <option value="<?= $s['id'] ?>">
                                <?= htmlspecialchars($s['nome']) ?>
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
                        required
                    >

                </div>


                <div class="mb-3">

                    <label>Hora</label>

                    <input
                        type="time"
                        name="hora"
                        class="form-control"
                        required
                    >

                </div>


                <button
                    type="submit"
                    name="agendar"
                    class="btn btn-danger"
                >
                    Agendar
                </button>

            </form>

        </div>

    </div>

</div>
<!-- LISTA DE AGENDAMENTOS -->

<div class="card mt-5 mb-5">

    <div class="card-body">

        <h2 class="mb-4">
            Agendamentos realizados
        </h2>

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Telefone</th>
                        <th>Carro</th>
                        <th>Placa</th>
                        <th>Serviço</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th class="text-center">Ações</th>
                    </tr>

                </thead>

                <tbody>

                    <?php

                    $sqlAgendamentos = "
                        SELECT
                            a.id,
                            a.nome_cliente,
                            a.telefone,
                            a.modelo_carro,
                            a.placa,
                            s.nome AS nome_servico,
                            a.data_agendamento,
                            a.hora_agendamento
                        FROM agendamentos a
                        LEFT JOIN servicos s
                            ON a.servico_id = s.id
                        ORDER BY
                            a.data_agendamento DESC,
                            a.hora_agendamento DESC
                    ";

                    $resultadoAgendamentos = mysqli_query(
                        $conn,
                        $sqlAgendamentos
                    );

                    ?>

                    <?php if ($resultadoAgendamentos && mysqli_num_rows($resultadoAgendamentos) > 0): ?>

                        <?php while ($agendamento = mysqli_fetch_assoc($resultadoAgendamentos)): ?>

                            <tr>

                                <td>
                                    <?= $agendamento["id"] ?>
                                </td>

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
                                    <?= htmlspecialchars($agendamento["nome_servico"] ?? "Serviço não encontrado") ?>
                                </td>

                                <td>
                                    <?= date(
                                        "d/m/Y",
                                        strtotime($agendamento["data_agendamento"])
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($agendamento["hora_agendamento"]) ?>
                                </td>

                                <td class="text-center">

                                    <a
                                        href="editar_agendamento.php?id=<?= $agendamento["id"] ?>"
                                        class="btn btn-warning btn-sm"
                                    >
                                        Editar
                                    </a>

                                    <a
                                        href="excluir_agendamento.php?id=<?= $agendamento["id"] ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir este agendamento?');"
                                    >
                                        Excluir
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="9"
                                class="text-center"
                            >
                                Nenhum agendamento cadastrado.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<?php include 'footer.php'; ?>