<?php

class BankAccount {

    private $balance=0;

    public function getBalance(){
        return $this->balance;
    }

    public function deposit($amount){
        $this->balance+=$amount;
    }
    public function withdraw($amount){
        if($amount<=0){
            throw new InvalidArgumentException("Amount is less than or equal to 0");
        }
        if($amount>$this->balance){
            throw new RuntimeException("Amount is greather than Balance");
        }
        $this->balance-=$amount;
        
    }
}
$bankAccount=new BankAccount;
$bankAccount->deposit(100);
echo $bankAccount->getBalance()."\n";
$bankAccount->withdraw(50);
echo $bankAccount->getBalance()."\n";

