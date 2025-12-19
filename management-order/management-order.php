<?php

enum OrderStatus : string {
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

    protected function setStatus($status){
         $this->status=$status;
    }


    public function pay(){
        if($this->status!==OrderStatus::Pending){
            throw new RuntimeException("Order can not be paid");
        }
        $this->status=OrderStatus::Paid;
    }

    public function cancel(){
        if($this->status!==OrderStatus::Pending){
            throw new RuntimeException("Order can not be cancelled");
        }
        $this->status=OrderStatus::Cancelled;
    }

    public function canBeCancelled(){
        return $this->status===OrderStatus::Pending;
    }

    public function __toString() : string
    {
        return "Id: ". $this->id." Customer: ".$this->customerName." TotalAmount: ".$this->totalAmount." Status: ".$this->status->value;
    }



}

class OnlineOrder extends Order {

    private $shippingCost;
    

    public function __construct(int $id, string $customerName, float $totalAmount,float $shippingCost)
    {
        $this->shippingCost=$shippingCost;
        parent::__construct($id, $customerName, $totalAmount);
    }

    public function getTotalAmount(){
       return  $this->totalAmount + $this->shippingCost;
    }

    public function cancel()
    {
        if($this->status == OrderStatus::Paid){
            throw new RuntimeException("Paid online order can not be Cancelled");
        }
        parent::cancel();
    }
}

class InStoreOrder extends Order {

    public function cancel()
    {
        if($this->status === OrderStatus::Cancelled){
            throw new RuntimeException("The order is already cancelled");
        }
        $this->status=OrderStatus::Cancelled;
    }

    public function canBeCancelled()
    {
        return $this->getStatus() !== OrderStatus::Cancelled;
    }
    
}

class PickupOrder extends Order {

    private $pickupLocation;

    public function __construct(
        int $id,
        string $customerName,
        float $totalAmount,
        string $pickupLocation
    ) {
        $this->pickupLocation = $pickupLocation;
        parent::__construct($id, $customerName, $totalAmount);
    }

    public function getPickupLocation(): string
    {
        return $this->pickupLocation;
    }

    public function pay()
    {
        if($this->status === OrderStatus::Cancelled){
            throw new RuntimeException("Cancelled order can not be paid");
        }
        parent::pay();
    }

    public function canBeCancelled()
    {
        return $this->getStatus() !== OrderStatus::Paid ;
    }
}

class OrderManager {
    private array $orders = [];

    public function addOrder(Order $order){
        $this->validateId($order->getId());
        $this->orders[] = $order;
    }

    public function findOrderById(int $id){
        foreach($this->orders as $order){
            if($order->getId() === $id){
                return $order;
            }
        }
        return null;
    }

    public function payOrder(int $id){
         $order=$this->findOrderById($id);
           if (!$order) {
        throw new RuntimeException("Order not found");
        }
         $order->pay();

    }

    public function cancelOrder(int $id){
        $order=$this->findOrderById($id);
         if (!$order) {
        throw new RuntimeException("Order not found");
    }
        $order->cancel();
    }

    public function listOrders(){
        $text=" \n";
        foreach($this->orders as $order){
            $text.=$order." \n";
        }
        return $text;
    }

    public function getTotalPaidRevenue(){
        $total=0;
        foreach($this->orders as $order){
            if($order->getStatus() === OrderStatus::Paid){
                $total+=$order->getTotalAmount();
            }
        };
        return $total;
    }

    private function validateId(int $id){
         if($this->findOrderById($id)){
            throw new RuntimeException("Order not found");
         }
    }
}

$order = new OrderManager;

$order->addOrder(new OnlineOrder(1, "Santiago", 100, 20));
$order->addOrder(new InStoreOrder(2, "Javier", 50));
$order->addOrder(new PickupOrder(3, "Gomez", 80,"Mexico DF"));


echo $order->listOrders();

$order->payOrder(1);
$order->payOrder(2);

try {
    $order->cancelOrder(1);
} catch (RuntimeException $e) {
    echo $e->getMessage() . "\n";
}

$order->cancelOrder(2);

try {
    $order->payOrder(2);
} catch (RuntimeException $e) {
    echo $e->getMessage() . "\n";
}

$order->cancelOrder(3);

try {
    $order->payOrder(3);
} catch (RuntimeException $e) {
    echo $e->getMessage() . "\n";
}

echo $order->listOrders();
echo $order->getTotalPaidRevenue();