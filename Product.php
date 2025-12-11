<?php

class Product {

    private $name;
    private $price;
    private $stock;

    public function __construct($name, $price, $stock)
    {
        $this->name=$name;
        $this->price=$price;
        $this->stock=$stock;
    }

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
        $this->price=$price;
    }

    public function getStock(){
        return $this->stock;
    }

    public function setStock($stock){
        $this->stock=$stock;
    }
}

class Store {
    
    private array $products = [];

    public function addProduct(Product $product){
        array_push($this->products,$product);
    }

    public function searchProductByName($name){

        foreach($this->products as $product){
            if($product->getName() === $name){
                return $product;
            }
        }
        return null;
    }

    public function allProducts(){
       return $this->products;
    }
}

$store=new Store;
$store->addProduct(new Product("Mouse",21,12));
$store->addProduct(new Product("Laptop",4221,5));
$store->addProduct(new Product("Keyboard",12321,4));
$found = $store->searchProductByName("Keyboard");
if($found){

    echo $found->getName()."\n";
}else{
    echo "Product not found \n";
}
var_dump($store->allProducts());