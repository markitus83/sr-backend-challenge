#!/usr/bin/env php
<?php

declare(strict_types=1);

echo 'Vending Maching CLI'.PHP_EOL;
echo 'Enter actions separated by commas.'.PHP_EOL;
echo 'Examples:'.PHP_EOL;
echo '  1, 0.25, 0.25, GET-SODA'.PHP_EOL;
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

    if ($items === []) {
        continue;
    }

    echo '-> '.implode(',', $items).PHP_EOL;
}
