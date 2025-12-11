<?php

class Productt {

    private string $name;
    private $price;
    private $stock;

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name=$name;
    }
    public function getPrice(){
        return $this->price;
    }
    public function setPrice($price){
        $this->price;
    }
    public function getStock(){
        return $this->stock;
    }
    public function setStock($stock){
        $this->stock=$stock;
    }

    public function sell($quantity){
        if($quantity>$this->stock){
          throw new RuntimeException("Quantity is greather than stock");
        }
        $this->stock-=$quantity;
    }
}
$product=new Productt;
$product->setName("Phone");
$product->setPrice(12);
$product->setStock(21);
echo $product->getStock()."\n";
$product->sell(11);
echo $product->getStock();