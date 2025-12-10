<?php

abstract class Employee {

    public $name;

    abstract public function calculateSalary();

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }


}