<?php

require './Vehicle.php';

class Car extends Vehicle {

    public function move()
    {
        return "Car running";
    }
}
$car=new Car;
echo $car->start()."\n";
echo $car->move();