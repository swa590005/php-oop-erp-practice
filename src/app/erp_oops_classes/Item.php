<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class Item
{
    public function __construct(
        public readonly int $id,   // can't be changed after construction
        public readonly string $name,// can't be changed
        public int $stockLevel =0,
        public int $minimumStock = 10
    ){}
    public function needsReorder():bool
    {
        return $this->stockLevel < $this->minimumStock;
    }
}

