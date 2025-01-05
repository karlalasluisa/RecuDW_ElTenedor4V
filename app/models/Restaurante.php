<?php
class Restaurante{
    private $id;
    private $name;
    private $image;
    private $menu;
    private $minorprice;
    private $mayorprice;
    private $idCategory;
    
    public function getIdCategory() {
        return $this->idCategory;
    }

    public function setIdCategory($idCategory): void {
        $this->idCategory = $idCategory;
    }

        
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getImage() {
        return $this->image;
    }

    public function getMenu() {
        return $this->menu;
    }

    public function getMinorprice() {
        return $this->minorprice;
    }

    public function getMayorprice() {
        return $this->mayorprice;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setImage($image): void {
        $this->image = $image;
    }

    public function setMenu($menu): void {
        $this->menu = $menu;
    }

    public function setMinorprice($minorprice): void {
        $this->minorprice = $minorprice;
    }

    public function setMayorprice($mayorprice): void {
        $this->mayorprice = $mayorprice;
    }


}
?>