<?php

require_once (dirname(__FILE__) . '\..\conf\PersistentManager.php');
require_once (dirname(__FILE__) . '\..\..\app\models\Restaurante.php');

class RestauranteDAO {

    const RESTAURANTE_TABLE = 'restaurant';

    private $conex = null;

    public function __construct() {
        $this->conex = PersistentManager::getInstance()->get_connection();
    }

    public function selectTodosLosRestaurantes() {

        $query = "SELECT * FROM " . self::RESTAURANTE_TABLE;
        $result = mysqli_query($this->conex, $query);
        $restaurantes = array();

        while ($restauranteBD = mysqli_fetch_array($result)) {
            $restaurante = new Restaurante();
            $restaurante->setId($restauranteBD['id']);
            $restaurante->setName($restauranteBD['name']);
            $restaurante->setImage($restauranteBD['image']);
            $restaurante->setMenu($restauranteBD['menu']);
            $restaurante->setMinorprice($restauranteBD['minorprice']);
            $restaurante->setMayorprice($restauranteBD['mayorprice']);

            array_push($restaurantes, $restaurante);
        }

        return $restaurantes;
    }

    public function insertRestaurante($restaurante) {
        $query = "INSERT INTO " . self::RESTAURANTE_TABLE . "( name, image, menu, minorprice, mayorprice, category_id) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_prepare($this->conex, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        $categoryID = $restaurante->getIdCategory();

        mysqli_stmt_bind_param($stmt, 'sssddi', $name, $image, $menu, $minorprice, $mayorprice,$categoryID);
        return $stmt->execute();
    }

    public function deleteRestaurante($id) {
        $query = "DELETE FROM " . self::RESTAURANTE_TABLE . " WHERE id =?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        return $stmt->execute();
    }

    public function comprobarPorId($id) {
        $query = "SELECT * FROM " . self::RESTAURANTE_TABLE . " where id=?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);

        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            return true;  
        } else {
            return false; 
        }

       
    }
    
    public function updateRestaurante($restaurante) {
        $query = "UPDATE " . self::RESTAURANTE_TABLE . " SET name=?, image=?, menu=?, minorprice=?, mayorprice=?,category_id=? where id=?";
        $stmt = mysqli_prepare($this->conex, $query);
        $name = $restaurante->getName();
        $image = $restaurante->getImage();
        $menu = $restaurante->getMenu();
        $minorprice = $restaurante->getMinorprice();
        $mayorprice = $restaurante->getMayorprice();
        $categoria = $restaurante->getIdCategory();
        $id = $restaurante->getId();
        mysqli_stmt_bind_param($stmt, 'sssddii', $name, $image, $menu, $minorprice, $mayorprice,$categoria, $id);
        return $stmt->execute();
    }
    
    public function selectRestauranteByID($id) {
        $query = "SELECT * FROM " . self::RESTAURANTE_TABLE . " where id=?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $image, $menu, $minorprice, $mayorprice,$idCategory);
        $restaurante = null;
        while (mysqli_stmt_fetch($stmt)) {
            $restaurante = new Restaurante();
            $restaurante->setId($id);
            $restaurante->setName($name);
            $restaurante->setImage($image);
            $restaurante->setMenu($menu);
            $restaurante->setMinorprice($minorprice);
            $restaurante->setMayorprice($mayorprice);
            $restaurante->setIdCategory($idCategory);
        }

        return $restaurante;
    }
    
    public function selectRestauranteByCategoria($idcategoria) {
        $query = "SELECT * FROM " . self::RESTAURANTE_TABLE . " where idCategory=?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, "i", $idcategoria);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name, $image, $menu, $minorprice, $mayorprice,$idCategory);
        $restaurantes = array();
        while (mysqli_stmt_fetch($stmt)) {
            $restaurante = new Restaurante();
            $restaurante->setId($id);
            $restaurante->setName($name);
            $restaurante->setImage($image);
            $restaurante->setMenu($menu);
            $restaurante->setMinorprice($minorprice);
            $restaurante->setMayorprice($mayorprice);
            array_push($restaurantes,$restaurante);
        }
        return $restaurantes;
    }
}

?>