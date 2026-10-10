<?php
declare(strict_types=1);
namespace app\erp_oops_classes;
class InvoiceProcessor
{
    public function __construct(private InvoiceCalculator $invoiceCalculator,
    private GenerateCsv $csvGenerator,
    private SaveData $saveData,
    private EmailClass $emailClass
    ){
    }
    public function processInvoice(array $lines, string $emailAddress):void
    {
        $invoiceVatTotal = $this->invoiceCalculator->calculateInvoiceVat($lines);
        var_dump($invoiceVatTotal);
        $csv = $this->csvGenerator->generateCsv($lines);
        echo "<pre>$csv</pre>";
        $this->saveData->saveData($lines);
        $this->emailClass->sendEmail($emailAddress, $invoiceVatTotal);
    }
}