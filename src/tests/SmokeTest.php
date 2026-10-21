<?php
declare(strict_types=1);

namespace src\tests;

use PHPUnit\Framework\TestCase;

class SmokeTest extends TestCase
{
    public function testMultiplicationOfTwoNumbers(): void
    {
        $this->assertSame(10, 5 * 2);   // expected value first, actual value second
    }
}
