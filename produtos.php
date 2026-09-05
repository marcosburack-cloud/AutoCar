<?php
include 'header.php';
include 'conexao.php';
$mensagem = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
if (
    $_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["acao"])
    && $_POST["acao"] === "editar"
) {
    $id = (int) $_POST["id"];
    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = (float) $_POST["preco"];
    if ($id > 0 && $nome !== "" && $preco >= 0) {
        $sql = "UPDATE produtos
                SET nome = ?, descricao = ?, preco = ?
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssdi",
            $nome,
            $descricao,
            $preco,
            $id
        );
        if ($stmt->execute()) {
            header("Location: produtos.php?sucesso=edicao");
            exit;
        } else {
            $mensagem = "Erro ao editar produto.";
        }
        $stmt->close();
    } else {
        $mensagem = "Dados inválidos para edição.";
    }
}
    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = (float) $_POST["preco"];
    if ($nome !== "" && $preco >= 0) {
        $sql = "INSERT INTO produtos (nome, descricao, preco)
                VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $nome, $descricao, $preco);
        if ($stmt->execute()) {
            header("Location: produtos.php?sucesso=cadastro");
            exit;
        } else {
            $mensagem = "Erro ao cadastrar produto.";
        }
        $stmt->close();
    } else {
        $mensagem = "Preencha o nome e informe um preço válido.";
    }
}
if (isset($_GET["sucesso"])) {
    if ($_GET["sucesso"] === "cadastro") {
        $mensagem = "Produto cadastrado com sucesso!";
    }
    if ($_GET["sucesso"] === "edicao") {
        $mensagem = "Produto editado com sucesso!";
    }
    if ($_GET["sucesso"] === "exclusao") {
        $mensagem = "Produto excluído com sucesso!";
    }
}

if (isset($_GET["erro"])) {

    if ($_GET["erro"] === "nao_encontrado") {
        $mensagem = "Não foi possível excluir: produto não encontrado.";
    }

    if ($_GET["erro"] === "exclusao") {
        $mensagem = "Erro ao excluir o produto.";
    }
}
$sql = "SELECT id, nome, descricao, preco
        FROM produtos
        ORDER BY id DESC";
$resultado = $conn->query($sql);
?>
<div class="container mt-4">
    <h1 class="textoproduto mb-5"
        style="color:red; text-align:center; text-shadow: 0 0 8px rgba(255,0,0,0.6);">
        Produtos para ajudar na sua limpeza!
    </h1>
    <div class="row mb-5">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img
                    src="img/shampoo_car.png"
                    class="card-img-top"
                    alt="Shampoo Automotivo"
                >
                <div class="card-body">
                    <h5 class="card-title">
                        Shampoo Automotivo
                    </h5>
                    <p class="card-text">
                        Limpeza profunda sem agredir a pintura.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img
                    src="img/cera_car.png"
                    class="card-img-top"
                    alt="Cera Protetora"
                >
                <div class="card-body">
                    <h5 class="card-title">
                        Cera Protetora
                    </h5>
                    <p class="card-text">
                        Brilho intenso e proteção da pintura.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img
                    src="img/lilpreto.png"
                    class="card-img-top"
                    alt="Pretinho para Pneus"
                >
                <div class="card-body">
                    <h5 class="card-title">
                        Pretinho para Pneus
                    </h5>
                    <p class="card-text">
                        Acabamento profissional para pneus.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php if ($mensagem !== ""): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>
    <div class="card mb-5">
        <div class="card-body">
            <h3 class="mb-4">
                Cadastrar Produto
            </h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">
                        Nome do produto
                    </label>
                    <input
                        type="text"
                        name="nome"
                        class="form-control"
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
                    ></textarea>
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
                        required
                    >
                </div>
                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Cadastrar Produto
                </button>
            </form>
        </div>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <h3 class="mb-4">
                Produtos cadastrados
            </h3>
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows > 0): ?>
                            <?php while ($produto = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <?= $produto["id"] ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($produto["nome"]) ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($produto["descricao"]) ?>
                                    </td>
                                    <td>
                                        R$
                                        <?= number_format(
                                            (float) $produto["preco"],
                                            2,
                                            ",",
                                            "."
                                        ) ?>
                                    </td>
                                    <td class="text-center">
                                        <a
                                            href="editar_produto.php?id=<?= $produto["id"] ?>"
                                            class="btn btn-warning btn-sm"
                                        >
                                            ✏️ Editar
                                        </a>
                                        <a
                                            href="excluir_produtos.php?id=<?= $produto["id"] ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                                        >
                                            🗑️ Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td
                                    colspan="5"
                                    class="text-center"
                                >
                                    Nenhum produto cadastrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>