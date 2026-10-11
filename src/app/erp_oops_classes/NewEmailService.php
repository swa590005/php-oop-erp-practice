<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class NewEmailService implements EmailNotifier
{
    public function sendEmail(string $to, float $invoiceTotal):void
    {
        echo "Mail to {$to} : your invoice total is {$invoiceTotal}";
    }
}