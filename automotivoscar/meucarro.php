<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Carro - Automotiva</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<header>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">

    <a class="navbar-brand" href="index.php">AutoCar</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="meucarro.php">
            Meu Carro
          </a>
        </li>

      </ul>

    </div>

    <button type="button"class="btn btn-danger"data-bs-toggle="popover"data-bs-title="Agendamento"data-bs-content="Aqui você poderá marcar uma revisão para seu veículo.">
      Marcar
    </button>

  </div>
</nav>
</header>

<main class="container mt-5">

    <h1>Meu Carro</h1>

    <div class="card mt-4">
        <div class="card-body">

            <h4 class="card-title">Dados do Veículo</h4>

            <p><strong>Modelo:</strong> Honda Civic</p>
            <p><strong>Ano:</strong> 2020</p>
            <p><strong>Placa:</strong> ABC-1234</p>
            <p><strong>Quilometragem:</strong> 58.000 km</p>

        </div>
    </div>

</main>

<footer class="text-center mt-5 mb-3">
    <p>© 2026 Automotiva</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
[...popoverTriggerList].map(
  popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl)
);
</script>

</body>
</html>