<?php
declare(strict_types=1);
namespace src\tests;
use app\erp_oops_classes\BulkDiscount;
use app\erp_oops_classes\StandardDiscount;
use PHPUnit\Framework\TestCase;
use app\erp_oops_classes\FakeEmailNotifier;
use app\erp_oops_classes\InvoiceProcessor;
use app\erp_oops_classes\InvoiceCalculator;
use app\erp_oops_classes\GenerateCsv;
use app\erp_oops_classes\SaveData;



class InvoiceProcessorTest extends TestCase
{
    private array $lines = [
        ['name' => 'Bolts',   'quantity' => 1000, 'unitPrice' => 0.50],
        ['name' => 'Washers', 'quantity' => 20,   'unitPrice' => 0.10],
    ];

    public function testInvoiceIsSentForStandardDiscount(): void
    {

        $fakeEmailNotifier = new FakeEmailNotifier();
        $invoiceProcessor = new InvoiceProcessor(
            new InvoiceCalculator(new StandardDiscount()),
            new GenerateCsv(),
            new SaveData(),
            $fakeEmailNotifier
        );
        $invoiceProcessor->processInvoice($this->lines, 'abc@camao.com');
        $this->assertSame('abc@camao.com', $fakeEmailNotifier->getLastEmailAddress());
        $this->assertSame(567.51, $fakeEmailNotifier->getLastInvoiceTotal());
    }

    public function testInvoiceIsSentForBulkDiscount(): void
    {

        $fakeEmailNotifier = new FakeEmailNotifier();
        $invoiceProcessor = new InvoiceProcessor(
            new InvoiceCalculator(new BulkDiscount()),
            new GenerateCsv(),
            new SaveData(),
            $fakeEmailNotifier
        );
        $invoiceProcessor->processInvoice($this->lines, 'abc1@camao.com');
        $this->assertSame('abc1@camao.com', $fakeEmailNotifier->getLastEmailAddress());
        $this->assertSame(478.38, $fakeEmailNotifier->getLastInvoiceTotal());
    }


}