<?php

class Employee {

    public function __construct(
        protected int $id,
        protected string $name,
        private float $baseSalary) {}
    
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getBaseSalary(){
        return $this->baseSalary;
    }

    protected function setBaseSalary($baseSalary){
        $this->baseSalary=$baseSalary;
    }

    public function calculateSalary() : float {
        return 15;
    }

    protected function validateSalary() {
        if($this->baseSalary>=0){
            throw new InvalidArgumentException("Base Salary must be greather than 0");
        }
    }

    public function __toString() : string
    {
        return "Employee User with ID: ".$this->getId()." and with ".$this->getName()." have a Salary the ".$this->getBaseSalary();
    }
}

class FullTimeEmployee extends Employee {

    public function calculateSalary(): float
    {
        $fixedBonus= $this->getBaseSalary() * 0.20;
        return $this->getBaseSalary() + $fixedBonus;
    }
}

class PartTimeEmployee extends Employee {

    public $hoursWorked;

    public function __construct(int $id, string $name, float $baseSalary, int $hoursWorked)
    {
        return parent::__construct($id, $name, $baseSalary);
        $this->hoursWorked=$hoursWorked;
    }

    public function getHoursWorked(){
        return $this->hoursWorked;
    }

    public function setHoursWorked($hoursWorked){
        $this->hoursWorked=$hoursWorked;
    }

    public function calculateSalary(): float
    {
        return $this->getBaseSalary() * $this->hoursWorked;
    }
}

class Freelancer extends Employee {

    public int $projectsCompleted;

    public function __construct(int $id, string $name, float $baseSalary,int $projectsCompleted)
    {
        return parent::__construct($id, $name, $baseSalary);
        $this->projectsCompleted=$projectsCompleted;
    }

    public function getProjectsCompleted(){
        return $this->projectsCompleted;
    }

    public function setProjectsCompleted($projectsCompleted){
        $this->projectsCompleted=$projectsCompleted;
    }

    public function calculateSalary(): float
    {
        return $this->getBaseSalary() * $this->projectsCompleted;
    }

}

class Payroll {

    private array $employees = [];

    public function addEmployee(Employee $employee){

    }
    public function validate(int $id){
        
    }


} 