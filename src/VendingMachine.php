<?php

declare(strict_types=1);

namespace App;
final class VendingMachine
{
    private int $credit = 0;
    private array $insertedCoins = [];
    private array $prices = ['WATER' => 65, 'JUICE' => 100, 'SODA' => 150];

    private function __construct()
    {
    }

    public static function default(): self
    {
        return new self();
    }

    public function insertCoin(int $coin): array
    {
        $this->credit += $coin;
        $this->insertedCoins[] = $coin;

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
        if (!isset($this->prices[$item])) {
            return [];
        }

        $price = $this->prices[$item];
        $change = $this->credit - $price;

        $response = [$item];

        foreach ($this->calculateChange($change) as $coin) {
            $response[] = $this->formatCoin($coin);
        }

        return $response;
    }

    private function calculateChange(int $amount): array
    {
        $coins = [];

        foreach ([25, 10, 5] as $coin) {
            while ($amount >= $coin) {
                $coins[] = $coin;
                $amount -= $coin;
            }
        }

        return $coins;
    }

    private function formatCoin(int $coin): string
    {
            return match($coin) {
                5 => '0.05',
                10 => '0.10',
                25 => '0.25',
                100 => '1.005'
            };
    }
}