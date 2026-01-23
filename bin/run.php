#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use App\VendingMachine;

$vendingMachine = VendingMachine::default();

echo 'Vending Maching CLI'.PHP_EOL;
echo 'Enter actions separated by commas.'.PHP_EOL;
echo 'Examples:'.PHP_EOL;
echo '  1, 0.25, 0.25, GET-SODA'.PHP_EOL;
echo '  0.10, 0.10, RETURN-COIN'.PHP_EOL;
echo '  1, GET-WATER'.PHP_EOL;
echo '  SERVICE CHANGE 25=20 10=15 5=10 STOCK WATER=6 JUICE=6 SODA=6'.PHP_EOL;
echo 'Type \'exit\' to quit'.PHP_EOL;

while (true) {
    echo '>';
    $line = fgets(STDIN);

    if ($line === false) {
        break;
    }

    $line = trim($line);
    if ($line === '') {
        continue;
    }

    $lower = strtolower($line);
    if ($lower === 'exit' || $lower === 'quit') {
        break;
    }

    $normalized = str_replace(',', ' ', $line);
    $items = preg_split('/\s+/', trim($normalized)) ?: [];

    $serviceAction = null;
    $serviceChange = [];
    $serviceStock = [];

    $response = [];

    try {
        foreach ($items as $item) {
            $item = strtoupper($item);

            if ($item === '1') {
                $response = array_merge($response, $vendingMachine->insertCoin(100));
                continue;
            }

            if ($item === '0.25') {
                $response = array_merge($response, $vendingMachine->insertCoin(25));
                continue;
            }

            if ($item === '0.10') {
                $response = array_merge($response, $vendingMachine->insertCoin(10));
                continue;
            }

            if ($item === '0.05') {
                $response = array_merge($response, $vendingMachine->insertCoin(5));
                continue;
            }

            if ($item === 'RETURN-COIN') {
                $response = array_merge($response, $vendingMachine->returnCoin());
                continue;
            }

            if ($item === 'GET-WATER') {
                $response = array_merge($response, $vendingMachine->selectItem('WATER'));
                continue;
            }

            if ($item === 'GET-JUICE') {
                $response = array_merge($response, $vendingMachine->selectItem('JUICE'));
                continue;
            }

            if ($item === 'GET-SODA') {
                $response = array_merge($response, $vendingMachine->selectItem('SODA'));
                continue;
            }

            if ($item === 'SERVICE') {
                $serviceAction = null;
                $serviceChange = [];
                $serviceStock = [];
                continue;
            }

            if ($item === 'CHANGE') {
                $serviceAction = 'change';
                continue;
            }

            if ($item === 'STOCK') {
                $serviceAction = 'stock';
                continue;
            }

            if ($serviceAction === 'change' && str_contains($item, '=')) {
                [$coin, $count] = explode('=', $item, 2);
                $serviceChange[(int)$coin] = (int)$count;
                continue;
            }

            if ($serviceAction === 'stock' && str_contains($item, '=')) {
                [$item, $count] = explode('=', $item, 2);
                $serviceStock[$item] = (int)$count;
            }
        }

        if (!empty($serviceChange) || !empty($serviceStock)) {
            $vendingMachine->service($serviceChange, $serviceStock);
        }
    } catch (\InvalidArgumentException $invalidArgumentException) {
        echo 'Error: '.$invalidArgumentException->getMessage().PHP_EOL;
    }

    echo '-> '.implode(', ', $response).PHP_EOL;
}
