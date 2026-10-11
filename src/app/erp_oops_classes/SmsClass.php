<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

class SmsClass implements SmsNotifier
{
    public function sendSms(string $message, int $phoneNumber):void
    {
        echo "SMS to {$phoneNumber} : {$message}";
    }
}