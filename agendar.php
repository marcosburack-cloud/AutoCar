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

    try {

        if ($stmt->execute()) {

            header("Location: agendar.php?sucesso=edicao");
            exit;

        }

    } catch (mysqli_sql_exception $e) {

        if (strpos($e->getMessage(), "Não é permitido agendar") !== false) {

            $mensagem = "Não é possível realizar um agendamento para uma data anterior à atual.";

        } else {

            $mensagem = "Erro ao editar agendamento.";
        }
    }

    $stmt->close();
}
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

    try {

        if ($stmt->execute()) {

            header("Location: agendar.php?sucesso=cadastro");
            exit;

        }

    } catch (mysqli_sql_exception $e) {

        if (strpos($e->getMessage(), "Não é permitido agendar") !== false) {

            $mensagem = "Não é possível realizar um agendamento para uma data anterior à atual.";

        } else {

            $mensagem = "Erro ao realizar o agendamento.";
        }
    }

    $stmt->close();
}
if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'cadastro') {

    $mensagem = "Agendamento realizado com sucesso!";
}
?>
<div class="container mt-5">

    <?php if ($mensagem !== ""): ?>

        <div class="alert alert-warning text-center">
            <strong>⚠️ Atenção!</strong><br>
            <?= htmlspecialchars($mensagem) ?>
        </div>

    <?php endif; ?>

    <div class="card">

        <div class="card-body">

            <h2>Agendar Serviço</h2>

            <form method="POST">

                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Modelo do Carro</label>
                    <input type="text" name="carro" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Placa</label>
                    <input type="text" name="placa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Serviço</label>
                    <select name="servico" class="form-control" required>
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
                        min="<?= date('Y-m-d') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label>Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>

                <button type="submit" name="agendar" class="btn btn-danger">
                    Agendar
                </button>

            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>

