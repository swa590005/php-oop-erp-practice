<?php
declare(strict_types=1);

namespace src\tests;

use app\erp_oops_classes\BulkDiscount;
use PHPUnit\Framework\TestCase;

class BulkDiscountTest extends TestCase
{
    public function testAmountBelow100(): void
    {
        $bulkDiscount = new BulkDiscount();
        $this->assertSame(40.00, $bulkDiscount->apply(40));
    }
    public function testAmountAbove100(): void
    {
        $bulkDiscount = new BulkDiscount();
        $this->assertSame(96.00, $bulkDiscount->apply(120));
    }
    public function testAmountEqualTo100(): void
    {
        $bulkDiscount = new BulkDiscount();
        $this->assertSame(80.00, $bulkDiscount->apply(100));
    }
}