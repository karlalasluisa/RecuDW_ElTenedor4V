<?php
require_once (dirname(__FILE__) . '\..\conf\PersistentManager.php');
require_once (dirname(__FILE__) . '\..\..\app\models\Categoria.php');
class CategoriaDAO {

    const CATEGORIA_TABLE = 'category';

    private $conex = null;

    public function __construct() {
        $this->conex = PersistentManager::getInstance()->get_connection();
    }
    
    public function selectRestauranteByID($id) {
        $query = "SELECT * FROM " . self::CATEGORIA_TABLE . " where id=?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name);
        $categoria = null;
        while (mysqli_stmt_fetch($stmt)) {
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria->setName($name);
        
        }

        return $categoria;
    }
    
    public function selectIDbyName($name) {
        $query = "SELECT * FROM " . self::CATEGORIA_TABLE . " where name=?";
        $stmt = mysqli_prepare($this->conex, $query);
        mysqli_stmt_bind_param($stmt, "s", $name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id, $name);
        $categoria = null;
        while (mysqli_stmt_fetch($stmt)) {
            $categoria = new Categoria();
            $categoria->setId($id);
            $categoria->setName($name);
        
        }

        return $categoria == null ? null: $categoria->getId();
    }
    
    public function selectTodasLasCategorias() {

        $query = "SELECT * FROM " . self::CATEGORIA_TABLE;
        $result = mysqli_query($this->conex, $query);
        $categorias = array();

        while ($categoriaBD = mysqli_fetch_array($result)) {
            $categoria = new Categoria();
            $categoria->setId($categoriaBD['id']);
            $categoria->setName($categoriaBD['name']);
          

            array_push($categorias, $categoria);
        }

        return $categorias;
    }
    
    public function comprobarPorId($id) {
        $query = "SELECT * FROM " . self::CATEGORIA_TABLE . " where id=?";
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
}

?>
