<?php
include 'header.php';
include 'conexao.php';

if (!isset($_GET["id"])) {
    header("Location: produtos.php");
    exit;
}

$id = (int) $_GET["id"];

$sql = "SELECT id, nome, descricao, preco
        FROM produtos
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();
$produto = $resultado->fetch_assoc();

$stmt->close();

if (!$produto) {
    header("Location: produtos.php?erro=nao_encontrado");
    exit;
}
?>

<div class="container mt-4">

    <h1 class="textoproduto mb-5"
        style="color:red; text-align:center; text-shadow: 0 0 8px rgba(255,0,0,0.6);">
        Editar Produto
    </h1>

    <div class="card">

        <div class="card-body">

            <h3 class="mb-4">
                Editar produto #<?= $produto["id"] ?>
            </h3>

            <form method="POST" action="produtos.php">

                <input
                    type="hidden"
                    name="acao"
                    value="editar"
                >

                <input
                    type="hidden"
                    name="id"
                    value="<?= $produto["id"] ?>"
                >

                <div class="mb-3">

                    <label class="form-label">
                        Nome do produto
                    </label>

                    <input
                        type="text"
                        name="nome"
                        class="form-control"
                        value="<?= htmlspecialchars($produto["nome"]) ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Descrição
                    </label>

                    <textarea
                        name="descricao"
                        class="form-control"
                        rows="3"
                        required
                    ><?= htmlspecialchars($produto["descricao"]) ?></textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Preço
                    </label>

                    <input
                        type="number"
                        name="preco"
                        class="form-control"
                        step="0.01"
                        min="0"
                        value="<?= $produto["preco"] ?>"
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
                    href="produtos.php"
                    class="btn btn-secondary"
                >
                    ↩️ Voltar
                </a>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>