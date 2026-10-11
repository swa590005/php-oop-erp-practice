<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class FakeEmailNotifier implements EmailNotifier
{
    private ?string $lastEmailAddress=null;
    private ?float $lastInvoiceTotal=null;
    public function sendEmail(string $to, float $invoiceTotal):void
    {
        $this->lastEmailAddress = $to;
        $this->lastInvoiceTotal = $invoiceTotal;
    }
    public function getLastEmailAddress():?string
    {
        return $this->lastEmailAddress;
    }
    public function getLastInvoiceTotal():?float
    {
        return $this->lastInvoiceTotal;
    }

}