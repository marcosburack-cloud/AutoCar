<?php

include 'conexao.php';
include 'header.php';

if(isset($_POST['agendar'])){

    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $carro = $_POST['carro'];
    $placa = $_POST['placa'];
    $servico = $_POST['servico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    $sql = "INSERT INTO agendamentos
    (nome_cliente, telefone, modelo_carro, placa, servico_id, data_agendamento, hora_agendamento)
    VALUES
    ('$nome','$telefone','$carro','$placa','$servico','$data','$hora')";

    mysqli_query($conn, $sql);

    echo "<div class='alert alert-success text-center'>
            Agendamento realizado com sucesso!
          </div>";
}

?>

<div class="container mt-5">

    <div class="card">

        <div class="card-body">

            <h2>Agendar Serviço</h2>

            <form method="POST">

                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Modelo do Carro</label>
                    <input type="text" name="carro" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Placa</label>
                    <input type="text" name="placa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Serviço</label>

                    <select name="servico" class="form-control" required>

                        <?php

                        $sqlServicos = "SELECT * FROM servicos";
                        $resultado = mysqli_query($conn, $sqlServicos);

                        while($s = mysqli_fetch_assoc($resultado)){

                        ?>

                            <option value="<?php echo $s['id']; ?>">
                                <?php echo $s['nome']; ?>
                            </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="mb-3">
                    <label>Data</label>
                    <input type="date" name="data" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Hora</label>
                    <input type="time" name="hora" class="form-control" required>
                </div>

                <button type="submit" name="agendar" class="btn btn-danger">
                    Agendar
                </button>

            </form>

        </div>

    </div>

</div>

<?php include 'footer.php'; ?>