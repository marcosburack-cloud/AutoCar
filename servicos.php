<?php
include("conexao.php");
$mensagem = "";
if (isset($_GET["sucesso"]) && $_GET["sucesso"] === "cadastro") {
    $mensagem = "Serviço cadastrado com sucesso!";
}
if (isset($_POST["editar"])) {

    $id = (int) $_POST["id"];
    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = $_POST["preco"];

    if ($nome === "" || $preco === "") {
        $mensagem = "Preencha os campos obrigatórios.";
    } else {

        $sql = "UPDATE servicos
                SET nome = ?, descricao = ?, preco = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdi", $nome, $descricao, $preco, $id);

        if ($stmt->execute()) {
            $mensagem = "Serviço atualizado com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar serviço.";
        }

        $stmt->close();
    }
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = $_POST["preco"];

    if ($nome === "" || $preco === "") {
        $mensagem = "Preencha os campos obrigatórios.";
    } else {
        $sql = "INSERT INTO servicos (nome, descricao, preco)
                VALUES (?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssd", $nome, $descricao, $preco);

        if ($stmt->execute()) {
    header("Location: servicos.php?sucesso=cadastro");
    exit;
} else {
    $mensagem = "Erro ao cadastrar serviço.";
}

        $stmt->close();
    }
}

$sql = "SELECT id, nome, descricao, preco
        FROM servicos
        ORDER BY id DESC";

$resultado = $conn->query($sql);
?>

<?php include("header.php"); ?>

<div class="container py-5">

    <h1 class="mb-4">Gerenciar Serviços</h1>

    <?php if ($mensagem !== ""): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-5">
        <div class="card-body">

            <h3 class="card-title mb-4">Cadastrar Serviço</h3>

            <form method="POST">

                <div class="mb-3">
                    <label for="nome" class="form-label">
                        Nome do serviço
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        id="nome"
                        name="nome"
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
                    ></textarea>
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
                        step="0.01"
                        min="0"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Cadastrar Serviço
                </button>

            </form>

        </div>
    </div>
    <div class="table-responsive">
       <div class="card shadow-sm">
    <div class="card-body">

        <h3 class="mb-4">Serviços cadastrados</h3>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

            <thead class="table-dark">
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

                 <?php while ($servico = $resultado->fetch_assoc()): ?>

    <tr>
        <td><?= $servico["id"] ?></td>

        <td>
            <?= htmlspecialchars($servico["nome"]) ?>
        </td>

        <td>
            <?= htmlspecialchars($servico["descricao"] ?? "") ?>
        </td>

        <td>
            R$ <?= number_format(
                (float)$servico["preco"],
                2,
                ",",
                "."
            ) ?>
        </td>

        <td>
            <a
                href="editar_servicos.php?id=<?= $servico["id"] ?>"
                class="btn btn-warning btn-sm"
            >
                Editar
            </a>
             <a
        href="excluir_servico.php?id=<?= $servico["id"] ?>"
        class="btn btn-danger btn-sm"
        onclick="return confirm('Tem certeza que deseja excluir este serviço?');"
    >
        Excluir
    </a>
        </td>
    </tr>
<?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Nenhum serviço cadastrado.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("footer.php"); ?>