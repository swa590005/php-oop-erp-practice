<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class PurchaseOrder
{
    private int $id;
    #[FieldLabel("Supplier Name")]
    private string $supplierName;
    #[FieldLabel("Total Amount")]
    private float $totalAmount;
    private OrderStatus $status = OrderStatus::Pending;
    private static int $nextId=1;
    public function __construct(int $id, string $supplierName, float $totalAmount)
    {
        $this->id = $id;
        $this->supplierName = $supplierName;
        $this->totalAmount = $totalAmount;
    }
    public function getTotalAmount():float
    {
        return $this->totalAmount;
    }
    public function describeStatus():string
    {
            return match($this->status){
                OrderStatus::Pending => "Pending",
                OrderStatus::Approved => "Approved",
                OrderStatus::Shipped => "Shipped",
                OrderStatus::Cancelled => "Cancelled",
                default => "Unknown",
            };
    }
    public function changeStatus(OrderStatus $status):void
    {
        $this->status = $status;
    }
    public function __get(string $name)
    {
        if($name === "statusLabel"){
            return $this->describeStatus();
        }
    }

    public function __set(string $name, $value)
    {
        if($name === "statusLabel"){
            $value = OrderStatus::from($value);
            $this->changeStatus($value);
        }else{
            throw new \Exception("Invalid property: $name");
        }
    }

    public function __call(string $name, array $arguments)
    {
        if(str_starts_with($name, "is")){
            $propertyName = (substr($name, 2));
            if ($this->status->name === $propertyName){
                return true;
            }
        }
        throw new \Exception("Method not found: $name");
    }

    public static function __callStatic(string $name, array $arguments)
    {
        if(str_starts_with($name, "create")){
            $supplierName = $arguments[0];
            $totalAmount = $arguments[1];
            $statusName =strtolower((substr($name, 6)));
            $status = OrderStatus::from($statusName);
            $purchaseOrder= new self(self::generateId(), $supplierName, $totalAmount);
            $purchaseOrder->changeStatus($status);
            return $purchaseOrder;
        }
        throw new \Exception("Static method not found: $name");
    }
    public static function generateId():int
    {
        return self::$nextId++;
    }

    public static function compareByTotalAmount(PurchaseOrder $a, PurchaseOrder $b):int
    {
        return $a->totalAmount <=> $b->totalAmount;
    }

    public static function formatLabel(self $purchaseOrder):string
    {
        return $purchaseOrder->supplierName."--".$purchaseOrder->totalAmount;
    }

}