<?php

require './Employeej.php';

class FixedEmployee extends Employee{

    private $monthlySalary;

    public function getMonthSalary(){
        return $this->monthlySalary;
    }

    public function setMothlySalary($monthlySalary){
        $this->monthlySalary=$monthlySalary;
    }

    public function calculateSalary()
    {
        return $this->monthlySalary;
    }
}
$fixed=new FixedEmployee;
$fixed->setName("Javier");
$fixed->setMothlySalary(30);
echo "Employee called is ".$fixed->getName()."\n";
echo $fixed->calculateSalary()."\n";