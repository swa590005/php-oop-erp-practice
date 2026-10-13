<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class StandardDiscount extends Discount
{
    public function apply(float $amount):float
    {
        return $amount * 0.95;
    }
}