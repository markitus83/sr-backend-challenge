<?php

declare(strict_types=1);

namespace App;
final class VendingMachine
{
    private float $credit = 0.0;

    private function __construct()
    {
    }

    public static function default(): self
    {
        return new self();
    }

    public function insertCoin(float $coin): array
    {
        $this->credit += $coin;
        return [];
    }

    public function selectItem(string $item): array
    {
        if ($item === 'JUICE' && $this->credit = 1.0) {
            $this->credit = 0;
            return ['JUICE'];
        }
        return [];
    }
}