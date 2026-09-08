<?php
session_start();

if (!isset($_SESSION["admin_logado"])) {
    header("Location: login_admin.php");
    exit;
}

include("header.php");
?>

<div class="container mt-5 mb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1>Painel Administrativo</h1>
            <p class="text-muted">
                Bem-vindo!
            </p>
        </div>

        <a href="logout.php" class="btn btn-danger">
            Sair
        </a>

    </div>

    <div class="row g-4">

        <!-- Serviços -->
        <div class="col-md-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body text-center">

                    <h3>Serviços</h3>

                    <p class="text-danger">
                        Cadastre, edite e exclua os serviços
                        oferecidos pela empresa.
                    </p>

                    <a href="servicos.php"
                       class="btn btn-danger">
                        Gerenciar Serviços
                    </a>

                </div>

            </div>

        </div>

        <!-- Agendamentos -->
        <div class="col-md-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body text-center">

                    <h3>Agendamentos</h3>

                    <p class="text-danger">
                        Visualize, edite e exclua os
                        agendamentos dos clientes.
                    </p>

                    <a href="agendar.php"
                       class="btn btn-danger">
                        Gerenciar Agendamentos
                    </a>

                </div>

            </div>

        </div>

        <!-- Produtos -->
        <div class="col-md-4">

            <div class="card h-100 shadow-sm">

                <div class="card-body text-center">

                    <h3>Produtos</h3>

                    <p class="text-danger">
                        Cadastre, edite e exclua produtos
                        disponíveis.
                    </p>

                    <a href="produtos.php"
                       class="btn btn-danger">
                        Gerenciar Produtos
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include("footer.php"); ?>