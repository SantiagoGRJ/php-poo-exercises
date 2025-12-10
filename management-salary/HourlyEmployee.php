<?php

require './Employee.php';

class HourlyEmployee extends Employee {

    private $hoursWorked;
    private $hourlyRate;


    public function getHoursWorked(){
        return $this->hoursWorked;
    }
    public function setHoursWorked($hoursWorked){
        $this->hoursWorked=$hoursWorked;
    }

    public function getHourlyRate(){
        return $this->hourlyRate;
    }

    public function setHourlyRate($hourlyRate){
        $this->hourlyRate=$hourlyRate;
    }
   

    public function calculateSalary()
    {
       return $this->hoursWorked * $this->hourlyRate;
    }
}

$hourly= new HourlyEmployee;
$hourly->setName("Santiago");
$hourly->setHoursWorked(3);
$hourly->setHourlyRate(32);
echo "Employee called is ".$hourly->getName()."\n";
echo $hourly->calculateSalary();