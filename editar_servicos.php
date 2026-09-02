<?php
include("conexao.php");

if (!isset($_GET["id"])) {
    header("Location: servicos.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT id, nome, descricao, preco
        FROM servicos
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$servico = $resultado->fetch_assoc();

$stmt->close();

if (!$servico) {
    header("Location: servicos.php");
    exit;
}
?>

<?php include("header.php"); ?>

<div class="container py-5">

    <h1 class="mb-4">Editar Serviço</h1>

    <div class="card">
        <div class="card-body">

            <form method="POST" action="servicos.php">

                <input
                    type="hidden"
                    name="id"
                    value="<?= $servico["id"] ?>"
                >

                <input
                    type="hidden"
                    name="editar"
                    value="1"
                >

                <div class="mb-3">
                    <label for="nome" class="form-label">
                        Nome do serviço
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($servico["nome"]) ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">
                        Descrição
                    </label>

                    <textarea
                        class="form-control"
                        id="descricao"
                        name="descricao"
                        rows="3"
                    ><?= htmlspecialchars($servico["descricao"] ?? "") ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">
                        Preço
                    </label>

                    <input
                        type="number"
                        class="form-control"
                        id="preco"
                        name="preco"
                        value="<?= $servico["preco"] ?>"
                        step="0.01"
                        min="0"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-success">
                    Salvar alterações
                </button>

                <a href="servicos.php" class="btn btn-secondary">
                    Cancelar
                </a>

            </form>

        </div>
    </div>

</div>

<?php include("footer.php"); ?>