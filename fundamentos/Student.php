<?php

class Student {
    private $name;
    private $age;
    private $grade;

    public function __construct($name,$age,$grade){
        $this->name=$name;
        $this->age=$age;
        $this->grade=$grade;
    }

    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name=$name;
    }
    
    public function getAge(){
        return $this->age;
    }

    public function setAge($age){
        $this->age=$age;
    }

    public function getGrade(){
        return $this->grade;
    }

    public function setGrade($grade){
        $this->grade=$grade;
    }
}

class Classroom {
    private array $students = [];

    public function addStudent(Student $student){
        array_push($this->students,$student);
    }

    public function findStudentByName($name){
        foreach($this->students as $student){
            if($student->getName() === $name){
                return $student;
            }
        }
        return null;
    }

    public function getAverageGrade(){
        // count student / attribute grade
        $total=0;
        $count = count($this->students);
        if($count===0) return 0;
        foreach($this->students as $student){
                $total+= $student->getGrade();
        }
        return $total/$count;
        
    }

    public function getAllStudents(){
        return $this->students;
    }

}
$classroom = new Classroom;
$classroom->addStudent(new Student("santi",12,10));
$classroom->addStudent(new Student("Javi",13,10));
$classroom->addStudent(new Student("gomez",14,5));
$find = $classroom->findStudentByName("santi");
if($find){
    echo "Student found is ".$find->getName()."\n";
}else{
    echo "Student not found \n";
}
echo $classroom->getAverageGrade()."\n";
var_dump($classroom->getAllStudents());