<?php 
    include 'header.php'; 
    include 'conexao.php';
?>

<?php
$horaAtual = date("H");
$aberto = ($horaAtual >= 7 && $horaAtual<19);
?>

<div class="container mt-4">

    <div class="card">
        <img src="img/Oficina.png" class="card-img-top" alt="Oficina">
    </div>

</div>

<div class="container mt-5">

    <div class="card">

        <div class="card-body">

            <h2>O que fazemos aqui?</h2>

            <?php if($aberto){ ?>
                <p><strong>Status:</strong> Oficina aberta.</p>
            <?php } else { ?>
                <p><strong>Status:</strong> Oficina fechada.</p>
            <?php } ?>

            <p>
                A AutoCar é uma oficina especializada em manutenção preventiva e corretiva de veículos.
            </p>

            <ul class="list-group">

<?php

$sql = "SELECT * FROM servicos";
$resultado = mysqli_query($conn, $sql);

while($servico = mysqli_fetch_assoc($resultado)){

?>

    <li class="list-group-item">
        <strong><?php echo $servico['nome']; ?></strong>
        <br>
        <?php echo $servico['descricao']; ?>
        <br>
        <strong>R$ <?php echo $servico['preco']; ?></strong>
    </li>

<?php } ?>

</ul>

        </div>

    </div>

</div>

<div class="container mt-4">

    <div class="card">

        <img src="img/produto.png" class="card-img-top" alt="Produto">

        <div class="card-body">
            <h2>Produtos AutoCar</h2>

            <p>
                Trabalhamos com produtos de alta qualidade para limpeza,
                proteção e manutenção automotiva.
            </p>
        </div>

    </div>

</div>

<?php include 'footer.php'; ?>