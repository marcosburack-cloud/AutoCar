<?php
include 'header.php';
include 'conexao.php';
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
<?php include 'footer.php'; ?>