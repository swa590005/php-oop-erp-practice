<?php
declare(strict_types=1);
namespace app\erp_oops_classes;

interface SmsNotifier
{
    public function sendSms(string $message, int $phoneNumber):void;

}