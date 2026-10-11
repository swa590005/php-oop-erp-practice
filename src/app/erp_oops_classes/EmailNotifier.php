<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

interface EmailNotifier
{
    public function sendEmail(string $to, float $invoiceTotal):void;
}