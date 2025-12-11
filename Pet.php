<?php

class Pet {
    private string $name;
    private int $age;

    public function __construct(string $name, int $age)
    {
        $this->name=$name; 
        $this->age=$age; 
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

    public function makeSound(){
        return "...";
    }

    public function getInfo(){
        return " ".$this->name." ".$this->age;
    }
}

class Dog extends Pet{

    private $breed;

    public function __construct(string $name, int $age,string $breed)
    {
         parent::__construct($name,$age);
         $this->breed=$breed;
    }

     public function getBreed(): string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): void
    {
        $this->breed = $breed;
    }

    public function makeSound()
    {
        return "Woolf!";
    }
}

class Cat extends Pet {
     private $color;

     public function __construct(string $name, int $age,string $color)
     {
         parent::__construct($name, $age);
         $this->color=$color;
     }

      public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): void
    {
        $this->color = $color;
    }

     public function makeSound()
     {
        return "Meow!";
     }
}

class Bird extends Pet {
    private bool $canFly;

    public function __construct(string $name, int $age, bool $canFly)
    {
         parent::__construct($name, $age);
        $this->canFly=$canFly;
    }

     public function getCanFly(): bool
    {
        return $this->canFly;
    }

    public function setCanFly(bool $canFly): void
    {
        $this->canFly = $canFly;
    }

    public function makeSound()
    {
       return  "Chirp!";
    }
}

class PetStore {
    private array $pets = [];
    
    public function addPet(Pet $pet){
       $this->pets[]=$pet;
    }

    public function listPets(){
        foreach($this->pets as $pet){
             echo $pet->getInfo() . " — Sound: " . $pet->makeSound() . "\n";
        }
    }

    public function findByname($name){
        foreach ($this->pets as $pet) {
            if ($pet->getName() === $name) {
                return $pet;
            }
        }

        return null;
    }
}

$store = new PetStore();

$store->addPet(new Dog("Rocky", 4, "Labrador"));
$store->addPet(new Cat("Misha", 2, "Black"));
$store->addPet(new Bird("Paco", 1, true));

$store->listPets();

$found = $store->findByName("Misha");

if ($found) {
    echo "\nFound pet: " . $found->getInfo() . "\n";
} else {
    echo "\nPet not found.\n";
}