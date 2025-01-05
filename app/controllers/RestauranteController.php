<?php

require_once dirname(__FILE__) . '\..\..\persistance\DAO\RestauranteDAO.php';
require_once dirname(__FILE__) . '\..\..\persistance\DAO\CategoriaDAO.php';
require_once dirname(__FILE__) . '\..\models\Restaurante.php';
require_once(dirname(__FILE__) . '\..\..\utils\SessionUtils.php');
require_once (dirname(__FILE__) . '\AuthController.php');
SessionUtils::startSessionIfNotStarted();

$_restauranteController = new RestauranteController;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "new" && isset($_SESSION["email"])) {

    $_restauranteController->crearRestaurante();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "delete") {
    if ($_SESSION["email"] == "admin") {
        $_restauranteController->borrarRestaurante();
    } else {
        header('Location: ../views/private/index.php?errores=errorPermisos');
        return;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "edit" && isset($_SESSION["email"])) {

    $_restauranteController->editarRestaurante();
}

class RestauranteController
{

    public function __construct() {}

    public function obtenerRestaurantesFiltrados()
    {
        $restaurenteDAO = new RestauranteDAO();
        if ($_GET["buscador"] == "") {
            return $restaurenteDAO->selectTodosLosRestaurantes();
        }

        $categoriaDAO = new CategoriaDAO;
        $lista = array();
        //NO ES CASE SENSITIVE. EL CONTEXTO SERÍA QUE ESTAN GUARDADAS TODAS LAS CATEGORIAS EN MAYUSCULAS.
        $id = $categoriaDAO->selectIDbyName(strtoupper($_GET["buscador"]));

        if ($id == null) {
            return $lista;
        }
        return $restaurenteDAO->selectRestauranteByCategoria($id);
    }

    public function editarRestaurante()
    {
        if (AuthController::validateUser() != "admin" && AuthController::validateUser() != "gestor") {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            return;
        }
        $rangos = explode("-", $_POST["price"]);
        $precioMinimo = $rangos[0];
        $precioMaximo = $rangos[1];
        if (!is_numeric($precioMinimo) || !is_numeric($precioMaximo)) {
            header('Location: ../views/private/editar.php?error=rangoIncorrecto&id=' . $_POST["id"] . "'");
            return;
        }

        if ($_POST["name"] == "" || $_POST["picture"] == "" || $_POST["mane"] == "" || $_POST["price"] == "") {
            header('Location: ../views/private/editar.php?error=DatosVacios');
            return;
        }

        $categoriaDAO = new CategoriaDAO;

        if (!$categoriaDAO->comprobarPorId($_POST["opciones"])) {
            return;
        }


        $restaurenteDAO = new RestauranteDAO();
        $restaurante = new Restaurante();
        $restaurante->setName($_POST["name"]);
        $restaurante->setImage($_POST["picture"]);
        $restaurante->setMenu($_POST["mane"]);
        $restaurante->setMinorprice($precioMinimo);
        $restaurante->setMayorprice($precioMaximo);
        $restaurante->setId($_POST["id"]);
        $restaurante->setIdCategory($_POST["opciones"]);

        $restaurenteDAO->updateRestaurante($restaurante);
        header('Location: ../views/private/index.php');
    }

    function obtenerRestaurantes()
    {
        $restaurenteDAO = new RestauranteDAO();
        return $restaurenteDAO->selectTodosLosRestaurantes();
    }

    public function crearRestaurante()
    {
        if (AuthController::validateUser() != "admin" && AuthController::validateUser() != "gestor") {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            return;
        }
        $rangos = explode("-", $_POST["price"]);
        $precioMinimo = $rangos[0];
        $precioMaximo = $rangos[1];
        if (!is_numeric($precioMinimo) || !is_numeric($precioMaximo)) {
            header('Location: ../views/private/insert.php?error=rangoIncorrecto');
            return;
        }

        if ($_POST["name"] == "" || $_POST["picture"] == "" || $_POST["mane"] == "" || $_POST["price"] == "") {
            header('Location: ../views/private/insert.php?error=DatosVacios');
            return;
        }
        $categoriaDAO = new CategoriaDAO;

        if (!$categoriaDAO->comprobarPorId($_POST["opciones"])) {
            return;
        }


        $restaurenteDAO = new RestauranteDAO();
        $restaurante = new Restaurante();
        $restaurante->setName($_POST["name"]);
        $restaurante->setImage($_POST["picture"]);
        $restaurante->setMenu($_POST["mane"]);
        $restaurante->setMinorprice($precioMinimo);
        $restaurante->setMayorprice($precioMaximo);
        $restaurante->setIdCategory($_POST["opciones"]);

        $restaurenteDAO->insertRestaurante($restaurante);
        header('Location: ../views/private/index.php');
    }

    public function borrarRestaurante()
    {
        if (AuthController::validateUser() != "admin") {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            return;
        }
        $restaurenteDAO = new RestauranteDAO();

        if (!$restaurenteDAO->comprobarPorId($_POST["id"])) {
            header('Location: ../views/private/index.php');
            return;
        }

        $restaurenteDAO->deleteRestaurante($_POST["id"]);
        header('Location: ../views/private/index.php');
    }

    function obtenerPorId($id)
    {
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectRestauranteByID($id);
    }
}
