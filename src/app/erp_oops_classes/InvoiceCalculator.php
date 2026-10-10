<?php

namespace app\erp_oops_classes;

class InvoiceCalculator
{
    public function calculateInvoiceVat(array $lines):float
    {
        return array_sum(array_map(fn($line)=>round( ($line['unitPrice']*$line['quantity']) * 1.19,2), $lines));
    }

}