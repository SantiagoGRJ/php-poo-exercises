<?php

class Employee {

    public function __construct(
        protected int $id,
        protected string $name,
        protected float $baseSalary) {
            $this->calculateSalary();
        }
    
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
        return $this->baseSalary;
    }

    protected function validateSalary() {
        if($this->baseSalary<=0){
            throw new InvalidArgumentException("Base Salary must be greather than 0");
        }
    }

    public function __toString() : string
    {
        return "Employee User with ID: ".$this->getId()." and with Name ".$this->getName()." have a Salary the ".$this->calculateSalary();
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

    protected $hoursWorked;

    public function __construct(int $id, string $name, float $baseSalary, int $hoursWorked)
    {
        $this->hoursWorked=$hoursWorked;
         parent::__construct($id, $name, $baseSalary);
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

    protected int $projectsCompleted;

    public function __construct(int $id, string $name, float $baseSalary,int $projectsCompleted)
    {
        $this->projectsCompleted=$projectsCompleted;
         parent::__construct($id, $name, $baseSalary);
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
        $this->validateRepeatEmployee($employee->getId());

        $this->employees[]=$employee;

    }

    public function searchEmployeeById(int $id){
         foreach($this->employees as $employee){
            if($employee->getId() === $id){
                return $employee;
            }
        }
        return null;
    }

    public function calculateTotalPayroll(){
         $payroll=0;
         foreach($this->employees as $employee){
            $payroll+=$employee->calculateSalary();
        }
        return $payroll;
    }

    public function listEmployees(){
        $text="\n";
        foreach($this->employees as $employee){
            $text.=$employee."\n";
        }
        return $text;
    }

    private function validateRepeatEmployee(int $id){
        foreach($this->employees as $employee){
            if($employee->getId() === $id){
                throw new InvalidArgumentException("Id is taken, try another different");
            }
        }
    }
} 
$payroll=new Payroll;
$payroll->addEmployee(new FullTimeEmployee(1,"Santi",21));
$payroll->addEmployee(new PartTimeEmployee(2,"javi",32.50,3));
$payroll->addEmployee(new Freelancer(3,"gomez",12.50,4));

for ($i = 1; $i <= 3; $i++) {
    $employee = $payroll->searchEmployeeById($i);
    echo $employee->calculateSalary() . "\n";
}
var_dump($payroll->listEmployees());
echo "Total salary: ".$payroll->calculateTotalPayroll()." \n";