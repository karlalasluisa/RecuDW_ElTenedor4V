<?php
require_once(dirname(__FILE__) . '\..\..\controllers\RestauranteController.php');
$restauranteController = new RestauranteController();
$listaRestaurantes = $restauranteController->obtenerRestaurantes();
$error = isset($_GET['error']) ? $_GET['error'] : null;

if (isset($_GET["buscador"])) {
    $listaRestaurantes = $restauranteController->obtenerRestaurantesFiltrados($_GET["buscador"]);
}
$isLoggedIn = isset($_SESSION['email']);
$email = $isLoggedIn ? $_SESSION['email'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>El Tenedor 4V</title>
    <!-- Bootstrap Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">El Tenedor 4V</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>
                <?php
                    if ($error) {
                        echo "<div class='alert alert-danger m-2' role='alert'>";
                    if ($error == 'ContraseñaIncorrecta') {
                        echo "La contraseña es incorrecta";
                    } elseif ($error == 'UsuarioIncorrecto') {
                        echo "El usuario es incorrecto";
                    }
                    echo "</div>";
                    }
                ?>
                <?php if ($isLoggedIn): ?>
                    <div class="d-flex align-items-center">
                        <span class="me-3">Bienvenido, <?= $email; ?></span>
                        <a class="btn btn-outline-danger" href="../../controllers/AuthController.php?type=logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                <?php else: ?>
                    <form class="d-flex" id="form-login" method="POST" action="../../controllers/AuthController.php">
                        <input class="form-control me-2" type="text" placeholder="Usuario" name="email" required>
                        <input class="form-control me-2" type="password" placeholder="Contraseña" name="password" required>
                        <input type="hidden" name="type" value="login">
                        <button class="btn btn-outline-success" type="submit">
                            <i class="bi bi-door-open"></i> Acceder
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Page Content -->

    <div class="container-fluid bg-info mb-5">
        <div class="row py-2">
            <div class="col-md-3">
                <img class="img-fluid rounded" src="./assets/img/logo.png" alt="">
            </div>
            <div class="col">
                <h1 class="display-4">Descubra y reserva el mejor restaurante</h1>
                <p class="lead">una aplicación de 4Vientos.</p>
                <form class="input-group" method="GET" action="./index.php">
                    <input name="buscador" class="form-control" />
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="container mt-5">
        <div class="row g-4">
            <?php
            if (count($listaRestaurantes) === 0) {
                echo '<div class="col-12">';
                echo '<h4 class="text-center text-danger mt-2">ACTUALMENTE NO TENEMOS NINGÚN RESTAURANTE</h4>';
                echo '</div>';
            } else {
                foreach ($listaRestaurantes as $restaurante) {
                    echo '<div class="col-12 col-md-6 col-lg-4">';
                    echo '<div class="card h-100">';
                    echo '<img src="' . $restaurante->getImage() . '" class="card-img-top" alt="Imagen de ' . $restaurante->getName() . '">';
                    echo '<div class="card-body">';
                    echo '<span class="badge bg-primary">' . $restaurante->getMinorprice() . '-' . $restaurante->getMayorprice() . ' €</span>';
                    echo '<h4 class="card-title mt-2">' . $restaurante->getName() . '</h4>';
                    echo '<p class="card-text">' . $restaurante->getMenu() . '</p>';
                    echo '</div>';

                    if (!$isLoggedIn) {
                        echo '<div class="card-footer text-center">';
                        echo '<a href="reserva.php?id=' . $restaurante->getId() . '" class="btn btn-primary">Reservar</a>';
                        echo '</div>';
                    }

                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    </div>
    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>
