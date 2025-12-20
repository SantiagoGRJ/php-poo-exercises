<?php

class Book {

    private bool $isAvailable = true;
    
    public function __construct(
        private int $id,
        private string $title,
        private string $author,
        
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

    private int $activeLoans;
   
    public function __construct( 
        private int $id,
        private string $name,
        
    )
    {
        $this->activeLoans=0;
    }

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
            throw new RuntimeException("Member can not borrow more book, there is limited");
        }
        $this->activeLoans++;
    }

    public function removeLoan(){
        if(!$this->activeLoans>0){
            throw new RuntimeException("There is not Loan active");
        }
        
        $this->activeLoans--;
    }


}

class Loan {

    private static int $autoIncrement = 1;

    private int $id;
    private Book $book;
    private Member $member;
    private DateTime $startDate;
    private ?DateTime $endDate = null;

    public function __construct(Book $book, Member $member){
        $this->id = self::$autoIncrement++;
        $this->book = $book;
        $this->member = $member;
        $this->startDate = new DateTime();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getBook(): Book {
        return $this->book;
    }

    public function getMember(): Member {
        return $this->member;
    }

    public function getStartDate(): DateTime {
        return $this->startDate;
    }

    public function getEndDate(): ?DateTime {
        return $this->endDate;
    }

    public function isActive(): bool {
        return $this->endDate === null;
    }

    public function close(): void {
        if(!$this->isActive()){
            throw new RuntimeException("Loan already closed");
        }
        $this->endDate = new DateTime();
    }
}

class Library {
    private array $books = [];
    private array $members = [];
    private array $loans = [];

    public function addBook(Book $book){

        $this->books[]=$book;
    }

    public function addMember(Member $member){
        $this->members[]=$member;
    }

    public function findBookById(int $id){
        foreach($this->books as $book){
            if($book->getId() === $id){
                return $book;
            }
        }
        return null;

    }

    public function findMemberById(int $id){
         foreach($this->members as $member){
            if($member->getId() === $id){
                return $member;
            }
        }
        return null;

    }

    public function borrowBook(int $bookId, int $memberId){
        $book=$this->findBookById($bookId);
        $member=$this->findMemberById($memberId);
        $loan = new Loan($book,$member);
        $this->loans[] = $loan;
        $book->markAsBorrowed();
        $member->addLoan($loan);
    }

    public function returnBook(int $bookId){
        foreach($this->loans as $loan){
        if($loan->getBook()->getId() === $bookId && $loan->isActive()){
            $loan->close();
            $loan->getBook()->markAsReturned();
            $loan->getMember()->removeLoan($loan);
            return;
        }
    }
    }

    public function getActiveLoans(){
         $active = [];
    foreach($this->loans as $loan){
        if($loan->isActive()){
            $active[] = $loan;
        }
    }
    return $active;
    }
}

$library = new Library();

$book1 = new Book(1, "Clean Code","santi");
$book2 = new Book(2, "Design Patterns","javi");

$member1 = new Member(1, "Santiago");
$member2 = new Member(2, "Javier");

$library->addBook($book1);
$library->addBook($book2);

$library->addMember($member1);
$library->addMember($member2);

$library->borrowBook(1, 1);
$library->borrowBook(2, 2);

$library->returnBook(1);

$activeLoans = $library->getActiveLoans();
var_dump($activeLoans);