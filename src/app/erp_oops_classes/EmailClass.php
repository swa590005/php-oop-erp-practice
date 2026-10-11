<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class EmailClass implements EmailNotifier
{
    public function sendEmail(string $to, float $invoiceTotal):void
    {
        echo "Mail to {$to} : your invoice total is {$invoiceTotal}";
    }
}