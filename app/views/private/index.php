<?php
require_once (dirname(__FILE__) . '\..\..\controllers\RestauranteController.php');
require_once (dirname(__FILE__) . '\..\..\..\utils\SessionUtils.php');
SessionUtils::startSessionIfNotStarted();

if (!isset($_SESSION["email"])) {
    header('Location: ../public/index.php');
}


$restauranteController = new RestauranteController();
$listaRestaurantes = $restauranteController->obtenerRestaurantes();

if (isset($_GET["buscador"])) {
    $listaRestaurantes = $restauranteController->obtenerRestaurantesFiltrados($_GET["buscador"]);
}
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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="insert.php" id="nuevo_restaurante">Nuevo Restaurante</a>
                        </li>
                    </ul>
                    <form class="d-flex" id="form-login" method="POST" action="../../controllers/AuthController.php">
                        <input type="hidden" name="type" value="logout">
                        <button class="btn btn-outline-success d-flex align-items-center" type="submit" id="btn-login"><i class="bi bi-door-open px-1"></i> logout</button>
                    </form>
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
                    <h1 class="display-3">Descubra y reserva el mejor restaurante</h1>
                    <p class="lead">una aplicación de 4Vientos.</p>
                    <form class="input-group" method="GET" action="./index.php">
                        <input name="buscador" class="form-control" />
                        <button class="btn btn-primary" type="submit" >Buscar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Row -->
        <div class="container mtop-5">
             <?php
            if (isset($_GET["errores"])) {
                echo '<h4>No tienes permisos para borrar</h4>';
            }
            ?>
            <div class="row">

                <?php
                if (count($listaRestaurantes) == 0) {
                    echo "<h4 class='text-center mt-2 text-danger'>ACTUALMENTE NO TENEMOS NINGUN RESTAURANTE</h4>";
                }

                foreach ($listaRestaurantes as $restaurante) {
                    echo '<div class="col-12 col-md-6 col-lg-4">';
                    echo '<div class="card h-100">';
                    echo '<img class="card-img-top" src="' . $restaurante->getImage() . '">';
                    echo '<div class="card-body">';
                    echo '<span class="badge bg-primary">' . $restaurante->getMinorprice() . '-' . $restaurante->getMayorprice() . ' €</span>';
                    echo '<h4 class="card-title">' . $restaurante->getName() . '</h4>';
                    echo '<p class="card-text">';
                    echo $restaurante->getMenu();
                    echo '</p>';
                    echo '</div>';
                    echo '<div class="card-footer d-flex justify-content-around">';
                    echo '<a href="./editar.php?id=' . $restaurante->getId() . '" class="btn btn-warning">Editar </a>';
                    if ($_SESSION["email"] == "admin"){
                        echo '<form action="../../controllers/RestauranteController.php" method="POST"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="' . $restaurante->getId() . '"><button class="btn btn-danger" type="submit">Borrar</button></form>';
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>



            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="">
            <span class=""> Cuatrovientos </span>
        </div>
    </footer>
    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</body>

</html>
