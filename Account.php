<?php

class Account {

    public function __construct(
        private $accountNumber,
        private $owner,
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

    public function setBalance($balance){
        $this->balance=$balance;
    }

    public function deposit(float $amount){
        if($amount<=0){
            throw new InvalidArgumentException("Amount must be greater than 0");
        }
        $this->balance+=$amount;
    }

    public function withDraw(float $amount){
        if($amount>$this->balance){
            throw new RuntimeException("Verify your amount to withdraw");
        }
        $this->balance-=$amount;
    }

    public function getAccountType(){
        return "Account";
    }


}