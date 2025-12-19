<?php

class Book {
    
    public function __construct(
        private int $id,
        private string $title,
        private string $author,
        private bool $isAvailable = true,
    )
    {}

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

   
    public function getAuthor(){
        return $this->author;
    }

    public function getAvailable(){
        return $this->isAvailable;
    }

    public function markAsBorrowed(){
        if($this->isAvailable){
            return;
        }
        $this->isAvailable=false;
    }

    public function markAsReturned(){
        if($this->isAvailable){
            return ;
        }
        $this->isAvailable=true;
    }
    
}

class Member {

    
   
    public function __construct( 
        private int $id,
        private string $name,
        private int $activeLoans,
    )
    {  }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getActiveLoans(){
        return $this->activeLoans;
    }

    public function canBorrow(){
        return $this->activeLoans < 3;
    }

    public function addLoan(){
        if(!$this->canBorrow()){
            return false;
        }
        $this->activeLoans++;
    }

    public function removeLoan(){
        if($this->activeLoans>0){

            $this->activeLoans--;
        }
        
    }


}

class Loan {

   

    public function __construct(
       private int $id,
        private Book $book,
        private Member $member,
        private DateTime $startDate,
        private ?DateTime $endDate = null,
    ) {}

    public function getId() {
        return $this->id;
    }

    public function getBook() {
        return $this->book;
    }

    public function getMember() {
        return $this->member;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function isActive() {
        return $this->endDate === null;
    }

    public function close() {
        return $this->endDate = new DateTime();
    }
}