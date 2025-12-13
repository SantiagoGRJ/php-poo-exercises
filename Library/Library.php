<?php

class Book {
    private $title;
    private $author;
    private int $year;
    private bool $isBorrowed = false;

    public function __construct(string $title, string $author, int $year){
        $this->title=$title;
        $this->author=$author;
        $this->year=$year;
    }

    public function getTitle() : string {
        return $this->title;
    }

    public function setTitle($title){
        $this->title=$title;
    }

    public function getAuthor() : string{
        return $this->author;
    }
    public function setAuthor($author){
        $this->author=$author;
    }

    public function getYear() : int{
        return $this->year;
    }

    public function setYear(int $year) {
        $this->year=$year;
    }

    public function getIsBorrowed() : bool {
        return $this->isBorrowed;
    }

    public function setIsBorrowed(bool $isBorrowed) {
        $this->isBorrowed=$isBorrowed;
    }

    public function borrow(){
        if($this->isBorrowed){
            return false;
        }
        $this->isBorrowed=true;
        return true;
    }

    public function returnBook(){
        $this->isBorrowed=false;
        return true;
    }

    public function getBorrowTime(){
        return 14;
    }
}


class Novel extends Book {

    public function getBorrowTime(){
        return 7;
    } 

} 

class TextBook extends Book {

    public function getBorrowTime()
    {
        return 3;
    }
}

class Magazine extends Book {

    public function getBorrowTime()
    {
        return 2;
    }
}

class Library {

    private array $books = [];

    public function addBook(Book $book){
        foreach($this->books as $b){
            if($b->getTitle() === $book->getTitle() && $b->getAuthor() === $book->getAuthor() ){
                return "You cannot add books repeat";
            }
        }
        $this->books[] = $book; 
    }

    public function findByTitle(string $title){
        foreach($this->books as $book){
            if($book->getTitle() === $title){
                return $book;
            }
        }
        return null;
    }

    public function borrowBook(string $title){
        $book=$this->findByTitle($title);

        if($book && !$book->getIsBorrowed()){
            $book->borrow();
            return $book->getBorrowTime();
        }else {
            return "Book not found or is borrow";
        }
    }

    public function returnBook(string $title){
        $book=$this->findByTitle($title);
        $book->returnBook();
    }

    public function listAvailable(){
        $listbook = [];
          foreach($this->books as $book){
            if(!$book->getIsBorrowed()){
               array_push($listbook, $book);
            }
        }
        return $listbook;
    }


}
$library = new Library();

$library->addBook(new Novel("Clean Code", "Robert C. Martin", 2008));
$library->addBook(new TextBook("Math Basics", "John Smith", 2015));
$library->addBook(new Magazine("National Geographic", "NatGeo", 2023));

echo "Available books:\n";
foreach ($library->listAvailable() as $book) {
    echo $book->getTitle() . "\n";
}

echo "\nBorrow Clean Code:\n";
$days = $library->borrowBook("Clean Code");
if ($days !== null) {
    echo "Borrow time: $days days\n";
}

echo "\nBorrow Math Basics:\n";
$days = $library->borrowBook("Math Basics");
if ($days !== null) {
    echo "Borrow time: $days days\n";
}

echo "\nBorrow Clean Code again:\n";
$library->borrowBook("Clean Code");

echo "\nAvailable books after borrow:\n";
foreach ($library->listAvailable() as $book) {
    echo $book->getTitle() . "\n";
}

echo "\nReturn Clean Code:\n";
$library->returnBook("Clean Code");

echo "\nAvailable books after return:\n";
foreach ($library->listAvailable() as $book) {
    echo $book->getTitle() . "\n";
}
