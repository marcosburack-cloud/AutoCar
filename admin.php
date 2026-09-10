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

    <!-- Indicadores do Dashboard -->
    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Agendamentos</h5>
                    <h2 class="fw-bold text-danger" id="totalAgendamentos">
                        0
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5 >Serviços</h5>
                    <h2 class="fw-bold text-danger" id="totalServicos">
                        0
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Produtos</h5>
                    <h2 class="fw-bold text-danger" id="totalProdutos">
                        0
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>Faturamento</h5>
                    <h2 class="fw-bold text-danger" id="faturamento">
                        R$ 0,00
                    </h2>
                </div>
            </div>
        </div>
<div class="col-md-3 mb-4">
    <div class="card shadow-sm h-100">
        <div class="card-body">
            <h5 class="card-title">Agendamentos futuros</h5>
            <h2 class="fw-bold text-danger" id="agendamentosFuturos">0</h2>
        </div>
    </div>
</div>

<div class="col-md-9 mb-4">
    <div class="card shadow-sm h-100">
        <div class="card-body">
            <h5 class="card-title">Serviços agendados</h5>
            <p class="fw-bold text-danger" id="listaServicos" class="mb-0">
                Nenhum serviço
            </p>
        </div>
    </div>
</div>
<div class="col-md-12 mb-4">
    <div class="card shadow-sm mb-5">
        <div class="card-body text-center">

            <h5>
                Serviço mais agendado
            </h5>

            <h3 class="fw-bold text-danger" id="servicoMaisAgendado">
                Nenhum
            </h3>

        </div>
    </div>
</div>
    <h2 class="mb-4">Gerenciamento</h2>

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

                    <a href="gerenciar_agendamentos.php"
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

                    <a href="gerenciar_produtos.php"
                       class="btn btn-danger">
                        Gerenciar Produtos
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>
<script>
    console.log("ADMIN: carregando dashboard");
</script>

<script src="/automotivoscar/js/dashboard.js"></script>
<?php include("footer.php"); ?>