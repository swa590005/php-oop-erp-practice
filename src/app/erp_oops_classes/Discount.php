<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

abstract class Discount
{
    abstract public function apply(float $amount):float;
}