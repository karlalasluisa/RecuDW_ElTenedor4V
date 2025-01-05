<?php

require_once dirname(__FILE__) . '\..\..\persistance\DAO\CategoriaDAO.php';

class CategoriaController {

    public function __construct() {

        

    }
    
    function obtenerCategorias() {
            $categoriaDAO = new CategoriaDAO();
            return $categoriaDAO->selectTodasLasCategorias();
        }
}

?>
