<?php

declare(strict_types=1);

namespace Tests;

use App\VendingMachine;
use PHPUnit\Framework\TestCase;

final class VendingMachineTest extends TestCase
{
    public function test_buy_juice_with_exact_change(): void
    {
        $machine = VendingMachine::default();

        $this->assertSame([], $machine->insertCoin(1));

        $this->assertSame(['JUICE'], $machine->selectItem('JUICE'));
    }
}