<?php

require_once dirname(__FILE__) . '/../..//persistance/DAO/RestauranteDAO.php';
require_once dirname(__FILE__) . '/../..//persistance/DAO/CategoriaDAO.php';
require_once dirname(__FILE__) . '/../models/Restaurante.php';
require_once dirname(__FILE__) . '/../..//utils/SessionUtils.php';
require_once dirname(__FILE__) . '/AuthController.php';

SessionUtils::startSessionIfNotStarted();

$restauranteCtrl = new RestauranteController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $userEmail = $_SESSION['email'] ?? null;

    if ($action === 'new' && $userEmail) {
        $restauranteCtrl->crearRestaurante();
    } elseif ($action === 'delete') {
        if ($userEmail === 'admin') {
            $restauranteCtrl->borrarRestaurante();
        } else {
            header('Location: ../views/private/index.php?errores=errorPermisos');
            exit;
        }
    } elseif ($action === 'edit' && $userEmail) {
        $restauranteCtrl->editarRestaurante();
    }
}

class RestauranteController
{
    public function obtenerRestaurantesFiltrados()
    {
        $restauranteDAO = new RestauranteDAO();
        $buscador = $_GET['buscador'] ?? '';

        if (empty($buscador)) {
            return $restauranteDAO->selectTodosLosRestaurantes();
        }

        $categoriaDAO = new CategoriaDAO();
        $id = $categoriaDAO->selectIDbyName(strtoupper($buscador));

        if (is_null($id)) {
            return [];
        }

        return $restauranteDAO->selectRestauranteByCategoria($id);
    }

    public function editarRestaurante()
    {
        if (!in_array(AuthController::validateUser(), ['admin', 'gestor'])) {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            exit;
        }

        $priceRange = explode('-', $_POST['price'] ?? '');
        $minPrice = $priceRange[0] ?? null;
        $maxPrice = $priceRange[1] ?? null;

        if (!is_numeric($minPrice) || !is_numeric($maxPrice)) {
            header("Location: ../views/private/editar.php?error=rangoIncorrecto&id={$_POST['id']}");
            exit;
        }

        if (empty($_POST['name']) || empty($_POST['picture']) || empty($_POST['mane']) || empty($_POST['price'])) {
            header('Location: ../views/private/editar.php?error=DatosVacios');
            exit;
        }

        $categoriaDAO = new CategoriaDAO();
        if (!$categoriaDAO->comprobarPorId($_POST['opciones'])) {
            return;
        }

        $restauranteDAO = new RestauranteDAO();
        $restaurante = new Restaurante();
        $restaurante->setName($_POST['name']);
        $restaurante->setImage($_POST['picture']);
        $restaurante->setMenu($_POST['mane']);
        $restaurante->setMinorprice($minPrice);
        $restaurante->setMayorprice($maxPrice);
        $restaurante->setId($_POST['id']);
        $restaurante->setIdCategory($_POST['opciones']);

        $restauranteDAO->updateRestaurante($restaurante);
        header('Location: ../views/private/index.php');
    }

    public function crearRestaurante()
    {
        if (!in_array(AuthController::validateUser(), ['admin', 'gestor'])) {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            exit;
        }

        $priceRange = explode('-', $_POST['price'] ?? '');
        $minPrice = $priceRange[0] ?? null;
        $maxPrice = $priceRange[1] ?? null;

        if (!is_numeric($minPrice) || !is_numeric($maxPrice)) {
            header('Location: ../views/private/insert.php?error=rangoIncorrecto');
            exit;
        }

        if (empty($_POST['name']) || empty($_POST['picture']) || empty($_POST['mane']) || empty($_POST['price'])) {
            header('Location: ../views/private/insert.php?error=DatosVacios');
            exit;
        }

        $categoriaDAO = new CategoriaDAO();
        if (!$categoriaDAO->comprobarPorId($_POST['opciones'])) {
            return;
        }

        $restauranteDAO = new RestauranteDAO();
        $restaurante = new Restaurante();
        $restaurante->setName($_POST['name']);
        $restaurante->setImage($_POST['picture']);
        $restaurante->setMenu($_POST['mane']);
        $restaurante->setMinorprice($minPrice);
        $restaurante->setMayorprice($maxPrice);
        $restaurante->setIdCategory($_POST['opciones']);

        $restauranteDAO->insertRestaurante($restaurante);
        header('Location: ../views/private/index.php');
    }

    public function borrarRestaurante()
    {
        if (AuthController::validateUser() !== 'admin') {
            header('Location: ../views/private/index.php?error=permisoInsuficiente');
            exit;
        }

        $restauranteDAO = new RestauranteDAO();
        if (!$restauranteDAO->comprobarPorId($_POST['id'])) {
            header('Location: ../views/private/index.php');
            return;
        }

        $restauranteDAO->deleteRestaurante($_POST['id']);
        header('Location: ../views/private/index.php');
    }

    public function obtenerPorId($id)
    {
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectRestauranteByID($id);
    }

    public function obtenerRestaurantes()
    {
        $restauranteDAO = new RestauranteDAO();
        return $restauranteDAO->selectTodosLosRestaurantes();
    }
}
