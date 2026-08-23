<?php
include 'conexao.php';
include 'header.php';

function calcularPrazo($servico){

    $prazos = [
        "Troca de óleo" => 1,
        "Alinhamento e balanceamento" => 1,
        "Revisão completa" => 3,
        "Troca de freios" => 2
    ];

    return $prazos[$servico] ?? 1;
}
function gerarOferta($servico){

    $ofertas = [
        "Troca de óleo" => "Por apenas R$ 12,00 a mais, adicione Shampoo Automotivo.",
        "Alinhamento e balanceamento" => "Por apenas R$ 15,00 a mais, adicione Pretinho para Pneus.",
        "Revisão completa" => "Por apenas R$ 20,00 a mais, adicione Cera Protetora.",
        "Troca de freios" => "Por apenas R$ 10,00 a mais, adicione Limpeza Completa."
    ];

    return $ofertas[$servico] ?? "Confira nossas promoções!";
}
?>
<div class="container mt-5">
<div class="card">
    <div class="card-body">
        <h2>Consultar Agendamento</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Placa do Veículo</label>
                <input type="text" name="placa" class="form-control" required>
            </div>
            <button type="submit" name="buscar" class="btn btn-danger">
                Consultar
            </button>
        </form>
        <?php
        if(isset($_POST['buscar'])){
            $placa = $_POST['placa'];
           $sql = "SELECT
            a.nome_cliente,
            a.modelo_carro,
            a.placa,
            s.nome AS servico,
            s.preco,
            a.data_agendamento,
            a.hora_agendamento
            FROM agendamentos a
            INNER JOIN servicos s
            ON a.servico_id = s.id
            WHERE a.placa = '$placa'";
            $resultado = mysqli_query($conn, $sql);
            if(mysqli_num_rows($resultado) == 0){
                echo "
                <div class='alert alert-danger mt-3'>
                    Nenhum agendamento encontrado para esta placa.
                </div>
                ";
            }else{
                while($agenda = mysqli_fetch_assoc($resultado)){
                    $prazo = calcularPrazo($agenda['servico']);
                    $dataFinalizacao = date(
                    "d/m/Y",
                    strtotime($agenda['data_agendamento'] . " +$prazo days")
                );
                    $oferta = gerarOferta($agenda['servico']);
                    ?>
                    <div class="card mt-4 p-3">
                        <h4><?php echo $agenda['nome_cliente']; ?></h4>
                        <p>
                            <strong>Carro:</strong>
                            <?php echo $agenda['modelo_carro']; ?>
                        </p>
                        <p>
                            <strong>Placa:</strong>
                            <?php echo $agenda['placa']; ?>
                        </p>
                        <p>
                            <strong>Serviço:</strong>
                            <?php echo $agenda['servico']; ?>
                        </p>
                        <p>
                            <strong>Valor do Serviço:</strong>
                            R$<?php echo number_format($agenda['preco'], 2, ',', '.'); ?>
                        </p>
                        <p>
                            <strong>Data:</strong>
                            <?php echo date("d/m/Y", strtotime($agenda['data_agendamento'])); ?>
                        </p>
                        <p>
                            <strong>Hora:</strong>
                            <?php echo $agenda['hora_agendamento']; ?>
                        </p>
                        <p>
                            <strong>Previsão de Finalização:</strong>
                            <?php echo $dataFinalizacao; ?>
                        </p>
                        <div class="alert alert-warning mt-3">
                            <strong>Oferta Especial!</strong><br>
                            <?php echo $oferta; ?>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>
</div>
<?php include 'footer.php'; ?>
