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
    if ($_GET["sucesso"] === "cadastro") {
        $mensagem = "Produto cadastrado com sucesso!";
        $tipoMensagem = "success";
    } elseif ($_GET["sucesso"] === "edicao") {
        $mensagem = "Produto atualizado com sucesso!";
        $tipoMensagem = "success";
    } elseif ($_GET["sucesso"] === "exclusao") {
        $mensagem = "Produto excluído com sucesso!";
        $tipoMensagem = "success";
    }
}

if (isset($_GET["erro"])) {
    if ($_GET["erro"] === "nao_encontrado") {
        $mensagem = "Produto não encontrado.";
        $tipoMensagem = "warning";
    } elseif ($_GET["erro"] === "exclusao") {
        $mensagem = "Não foi possível excluir o produto.";
        $tipoMensagem = "danger";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $acao = $_POST["acao"] ?? "";

    if ($acao === "cadastrar") {

        $nome = trim($_POST["nome"] ?? "");
        $descricao = trim($_POST["descricao"] ?? "");
        $preco = (float) ($_POST["preco"] ?? 0);

        if ($nome !== "" && $preco >= 0) {

            $sql = "INSERT INTO produtos (nome, descricao, preco)
                    VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssd", $nome, $descricao, $preco);
            $stmt->execute();
            $stmt->close();

            header("Location: gerenciar_produtos.php?sucesso=cadastro");
            exit;
        }
    }

    if ($acao === "editar") {

        $id = (int) ($_POST["id"] ?? 0);
        $nome = trim($_POST["nome"] ?? "");
        $descricao = trim($_POST["descricao"] ?? "");
        $preco = (float) ($_POST["preco"] ?? 0);

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

            $stmt->execute();
            $stmt->close();

            header("Location: gerenciar_produtos.php?sucesso=edicao");
            exit;
        }
    }
}

$resultado = $conn->query(
    "SELECT id, nome, descricao, preco
     FROM produtos
     ORDER BY id DESC"
);
?>

<?php include("header.php"); ?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Gerenciar Produtos</h2>
            <p class="text-muted">
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

    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <h4 class="mb-3">Cadastrar produto</h4>

            <form method="POST">

                <input
                    type="hidden"
                    name="acao"
                    value="cadastrar"
                >

                <div class="mb-3">
                    <label class="form-label">
                        Nome
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
                    class="btn btn-primary"
                >
                    Cadastrar produto
                </button>

            </form>

        </div>
    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <h4 class="mb-3">Produtos cadastrados</h4>

            <div class="table-responsive">

                <table class="table table-striped table-hover">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if ($resultado && $resultado->num_rows > 0): ?>

                            <?php while ($produto = $resultado->fetch_assoc()): ?>

                                <tr>

                                    <td>
                                        <?= (int) $produto["id"] ?>
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

                                    <td>

                                        <a
                                            href="editar_produto.php?id=<?= (int) $produto["id"] ?>"
                                            class="btn btn-sm btn-warning"
                                        >
                                            Editar
                                        </a>

                                        <a
                                            href="excluir_produto.php?id=<?= (int) $produto["id"] ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                                        >
                                            Excluir
                                        </a>

                                    </td>

                                </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5" class="text-center">
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

<?php include("footer.php"); ?>