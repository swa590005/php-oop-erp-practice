<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class BulkDiscount extends Discount
{
    public function apply(float $amount): float {
        if ($amount < 100) {
            return $amount;
        }
        return $amount * 0.80;                    // 20% off
    }
}