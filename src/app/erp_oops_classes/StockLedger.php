<?php
declare(strict_types=1);

namespace app\erp_oops_classes;

class StockLedger
{
    private int $stockLevel=0;

    public function receiveStock(int $quantity): void
    {
        $this->stockLevel += $quantity;
    }
    public function issueStock(int $quantity):void
    {
        if($this->stockLevel< $quantity)
        {
            throw new \InvalidArgumentException("Not enough stock");
        }else{
            $this->stockLevel -= $quantity;
        }
    }

    public function isLowStock(int $threshold):bool
    {
         return $this->getStockLevel() < $threshold;
    }
    public function getStockLevel():int
    {
        return $this->stockLevel;
    }
}