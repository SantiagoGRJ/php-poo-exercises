<?php

enum OrderStatus: string {
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
}

class Order {

    protected OrderStatus $status;

    public function __construct(
        protected int $id, 
        protected string $customerName, 
        protected float $totalAmount,
        ) {
            $this->status=OrderStatus::Pending;
        }

    public function getId(){
        return $this->id;
    }

    protected function setId($id){
        $this->id=$id;
    }

    public function getCustomerName(){
        return $this->customerName;
    }

    public function setCustomerName($customerName){
        $this->customerName=$customerName;
    }

    public function getTotalAmount(){
        return $this->totalAmount;
    }

    protected function setTotalAmount($totalAmount){
        $this->totalAmount=$totalAmount;
    }

    public function getStatus(){
        return $this->status;
    }


    public function pay(){
        if($this->status!==OrderStatus::Pending){
            throw new InvalidArgumentException("The order cannot be paid");
        }
        $this->status=OrderStatus::Paid;
    }

    public function cancel(){
        if($this->status!==OrderStatus::Pending){
            throw new InvalidArgumentException("The order cannot be cancelled");
        }
        $this->status=OrderStatus::Cancelled;
    }

    public function canBeCancelled(){
        return $this->status===OrderStatus::Pending;
    }



}

class OnlineOrder extends Order {

    protected $shoppingCost;
    protected $total;

    public function __construct(int $id, string $customerName, float $totalAmount,$shoppingCost)
    {
        $this->shoppingCost=$shoppingCost;
        parent::__construct($id, $customerName, $totalAmount);
    }

    protected function sumTotal(){
        $this->total=$this->getTotalAmount() + $this->shoppingCost;
    }

    public function cancel()
    {
        if(!$this->canBeCancelled()){

        }
    }
}