<?php

include 'conexao.php';

$sql = "SELECT * FROM servicos";

$resultado = mysqli_query($conn, $sql);

while($servico = mysqli_fetch_assoc($resultado)){
    echo $servico['nome'] . "<br>";
}