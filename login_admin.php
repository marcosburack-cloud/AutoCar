<?php
session_start();

if (isset($_SESSION["admin_logado"])) {
    header("Location: admin.php");
    exit;
}

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $senha = $_POST["senha"] ?? "";

    if ($nome === "Marcos" && $senha === "Marcos627267@") {

        $_SESSION["admin_logado"] = true;
        $_SESSION["admin_nome"] = $nome;

        header("Location: admin.php");
        exit;

    } else {
        $erro = "Nome ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acesso Administrativo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<div class="container d-flex justify-content-center align-items-center"
     style="min-height: 100vh;">

    <div class="card border-danger shadow p-4" style="width: 400px;">

        <h2 class=" text-danger text-center mb-4">
            Acesso Administrativo
        </h2>

        <?php if ($erro !== ""): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($erro) ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">
                <label class="form-label">Nome</label>

                <input
                    type="text"
                    name="nome"
                    class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>

                <input
                    type="password"
                    name="senha"
                    class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-danger w-100">
                Entrar
            </button>

        </form>

        <a href="index.php"
           class="btn btn-outline-danger w-100 mt-3">
            Voltar para o site
        </a>

    </div>

</div>

</body>
</html>