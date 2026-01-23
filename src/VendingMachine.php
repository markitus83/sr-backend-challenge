<?php

declare(strict_types=1);

namespace App;

final class VendingMachine
{
    private int $credit = 0;
    private array $insertedCoins = [];
    private array $prices = ['WATER' => 65, 'JUICE' => 100, 'SODA' => 150];
    private array $stock = ['WATER' => 10, 'JUICE' => 6, 'SODA' => 4];
    private array $change = [25 => 0, 10 => 0, 5 => 0];

    private function __construct()
    {
    }

    public static function default(): self
    {
        $self = new self();

        $self->change = [25 => 20, 10 => 20, 5 => 20];

        return $self;
    }

    public function insertCoin(int $coin): array
    {
        $this->credit += $coin;
        $this->insertedCoins[] = $coin;
        if (isset($this->change[$coin])) {
            $this->change[$coin]++;
        }

        return [];
    }

    public function returnCoin(): array
    {
        $response = [];
        foreach ($this->insertedCoins as $coin) {
            $response[] = $this->formatCoin($coin);
        }

        $this->credit = 0;
        $this->insertedCoins = [];

        return $response;
    }

    public function selectItem(string $item): array
    {
        if ($this->credit <= 0) {
            throw new \InvalidArgumentException('You are trying to buy with incorrect credit');
        }

        if (($this->stock[$item] ?? 0) <= 0) {
            return [];
        }

        if (!isset($this->prices[$item])) {
            return [];
        }

        $price = $this->prices[$item];
        $change = $this->credit - $price;
        $changeCoins = $this->calculateChange($change);

        if ($change > 0 && empty($changeCoins)) {
            return [];
        }

        $response = [$item];

        foreach ($this->calculateChange($change) as $coin) {
            $response[] = $this->formatCoin($coin);
        }

        $this->stock[$item]--;
        $this->credit = 0;
        $this->insertedCoins = [];

        return $response;
    }

    private function calculateChange(int $amount): array
    {
        $coins = [];
        $availableChange = $this->change;

        foreach ([25, 10, 5] as $coin) {
            while ($amount >= $coin && ($availableChange[$coin] ?? 0) > 0) {
                $coins[] = $coin;
                $availableChange[$coin]--;
                $amount -= $coin;
            }
        }

        return $coins;
    }

    public function setChange(int $coin, int $amount): void
    {
        if (!in_array($coin, [25, 10, 5], true)) {
            throw new \InvalidArgumentException('This coin is not available');
        }

        if ($coin < 0) {
            throw new \InvalidArgumentException('Change can\'t be negative');
        }

        $this->change[$coin] = $amount;
    }

    public function setStock(string $item, int $stock): void
    {
        if (!isset($this->stock[$item])) {
            throw new \InvalidArgumentException('This item not exist in this machine');
        }

        if ($stock < 0) {
            throw new \InvalidArgumentException('Stock can\'t be negative');
        }

        $this->stock[$item] = $stock;
    }

    public function service(array $change, array $stock): void
    {
        foreach ($change as $coin => $amount) {
            $this->setChange($coin, $amount);
        }

        foreach ($stock as $item => $count) {
            $this->setStock($item, $count);
        }
    }

    private function formatCoin(int $coin): string
    {
            return match($coin) {
                5 => '0.05',
                10 => '0.10',
                25 => '0.25',
                100 => '1.00'
            };
    }
}