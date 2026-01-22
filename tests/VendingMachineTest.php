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

        $this->assertSame([], $machine->insertCoin(100));

        $this->assertSame(['JUICE'], $machine->selectItem('JUICE'));
    }

    public function test_return_coin_returns_money(): void
    {
        $machine = VendingMachine::default();

        $this->assertSame([], $machine->insertCoin(10));
        $this->assertSame([], $machine->insertCoin(10));

        $this->assertSame(['0.10', '0.10'], $machine->returnCoin());
    }

    public function test_buy_water_without_exact_change()
    {
        $machine = VendingMachine::default();

        $this->assertSame([], $machine->insertCoin(100));

        $this->assertSame(['WATER', '0.25', '0.10'], $machine->selectItem('WATER'));
    }
}