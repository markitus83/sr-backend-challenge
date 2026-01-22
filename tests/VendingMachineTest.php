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

    public function test_cannot_buy_item_if_out_of_stock()
    {
        $machine = VendingMachine::default();

        $machine->setStock('JUICE', 0);

        $machine->insertCoin(100);

        $this->assertSame([], $machine->selectItem('JUICE'));
    }

    public function test_not_vend_if_not_available_change()
    {
        $machine = VendingMachine::default();

        $machine->setChange(25, 0);
        $machine->setChange(10, 0);
        $machine->setChange(5, 0);

        $machine->insertCoin(100);

        $this->assertSame([], $machine->selectItem('WATER'));
    }
}