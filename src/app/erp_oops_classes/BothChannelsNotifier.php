<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class BothChannelsNotifier implements EmailNotifier, SmsNotifier
{
    public function sendEmail(string $to, float $invoiceTotal):void
    {
        echo "Email to {$to} : your invoice total is {$invoiceTotal}";
    }
    public function sendSms(string $message, int $phoneNumber):void
    {
        echo "SMS to {$phoneNumber} : {$message}";
    }
}