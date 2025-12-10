<?php

require './Vehicle.php';

class Motorcycle extends Vehicle {

    public function move(){
        return "Motorcycle Running";
    }
}
$motorcycle=new Motorcycle;
echo $motorcycle->start()."\n";
echo $motorcycle->move()."\n";