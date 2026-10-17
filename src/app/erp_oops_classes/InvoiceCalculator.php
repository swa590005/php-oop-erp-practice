<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class InvoiceCalculator
{
    public function __construct(private Discount $discount)
    {}
    public function calculateInvoiceVat(array $lines):float
    {
        return array_sum(array_map(fn($line)=>round(($this->discount->apply($line['unitPrice']*$line['quantity'])) * 1.19,2), $lines));
    }

}