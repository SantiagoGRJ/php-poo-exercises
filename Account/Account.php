<?php

class Account {

    public function __construct(
        protected $accountNumber,
        protected $owner,
        private $balance
        ){}
    
    public function getAccountNumber(){
        return $this->accountNumber;
    }

    public function setAccountNumber($accountNumber){
        $this->accountNumber=$accountNumber;
    }

    public function getOwner(){
        return $this->owner;
    }
    
    public function setOwner($owner){
        $this->owner =$owner;
    }

    public function getBalance(){
        return $this->balance;
    }

    protected function setBalance($balance){
        $this->balance=$balance;
    }

    public function deposit(float $amount){
        if($amount<=0){
            throw new InvalidArgumentException("Amount must be greater than 0");
        }
        $this->balance+=$amount;
    }

    public function withDraw(float $amount){
        $this->validateWithDraw($amount);
        $this->balance-=$amount;
    }

    protected function validateWithDraw(float $amount){
       
         if ($amount > $this->balance) {
            throw new RuntimeException("Verify your amount to withdraw");
        }
    }

    protected function validateAmountWithDraw(float $amount){
         if($amount <= 0){
            throw new InvalidArgumentException("Amount must be greater than 0");
        }
    }

    public function getAccountType(){
        return "Account";
    }

    public function __toString()
    {
        return "Account: ".$this->accountNumber." owner: ".$this->owner." Type: ".$this->getAccountType()." balance: ".$this->balance;
    }
}

class SavingAccount extends Account {


    public function getAccountType()
    {
        return "Savings";
    }

    public function withDraw(float $amount){
        $this->validateAmountWithDraw($amount);
        $this->validateWithDraw($amount);
        $total= $this->getBalance() - $amount;
        if($total < 100){
            throw new InvalidArgumentException("You can not do a withdraw, balance would be the 100 money");
        }
        $this->setBalance($total);
    }
}

class CheckingAccount extends Account {

    public function getAccountType()
    {
        return "Checking";

    }

    public function withDraw(float $amount)
    {
        $this->validateAmountWithDraw($amount);
        $total = $this->getBalance() - $amount;

        if($total < - 500 ){
            throw new Exception("Overdraft limit exceeded");
        }
        $this->setBalance($total);
       
    }
}

class Bank {

    private array $accounts = [];

    public function addAccount(Account $account) {
             
        foreach($this->accounts as $accountf){
            if($accountf->getAccountNumber() === $account->getAccountNumber()){
                throw new InvalidArgumentException("AccountNumber is taken, try another different");
            }
        }
        $this->accounts[]=$account;
    }

    public function findAccount(string $accountNumber){
        
        foreach($this->accounts as $accountf){
            if($accountf->getAccountNumber() == $accountNumber){
                return $accountf;
            }

        }
        return null;
    }

    public function deposit(string $accountNumber, float $amount){
        $this->validateAmount($amount);
        $account=$this->findAccount($accountNumber);


        if(!$account){
            throw new RuntimeException("Account doesn´t exist or not found");
        }
        $account->deposit($amount);

    }

    public function withDraw(string $accountNumber, float $amount){
        $this->validateAmount($amount);
        $account=$this->findAccount($accountNumber);

         if(!$account){
            throw new RuntimeException("Account doesn´t exist or not found");
        }
        $account->withDraw($amount);



    }

    private function validateAmount(float $amount){
        if($amount <= 0){
            throw new InvalidArgumentException("Amount must be greater than o equal to 0");
        }
    }

    public function listAccounts(){
         $show = "".PHP_EOL;

    foreach ($this->accounts as $account) {
        $show .= $account . PHP_EOL;
    }

    return $show;
    }

}
$bank = new Bank;
$bank->addAccount(new Account("5467312893","santi",100));
$bank->addAccount(new SavingAccount("8192743675","javi",200));
$bank->addAccount(new CheckingAccount("7832954372","gomez",300));
var_dump($bank->listAccounts());
$bank->deposit("8192743675",100);
var_dump($bank->listAccounts());
$bank->withDraw("8192743675",201);
var_dump($bank->listAccounts());
$bank->deposit("7832954372",240);
var_dump($bank->listAccounts());
$bank->withDraw("7832954372",1040);

var_dump($bank->listAccounts());