<?php

namespace RefactorExercise;

require '../vendor/autoload.php';

use Exception;
use RefactorExercise\Exceptions\AmbiguousNumberOfParametersException;
use RefactorExercise\Repositories\InMemoryOrderRepository;
use RefactorExercise\Repositories\InMemoryStockRepository;

try {
    if ($argc != 2) {
        throw new AmbiguousNumberOfParametersException($argc, $argv);
    }

    $stockRepository = InMemoryStockRepository::createFromJson($argv[1]);

    $handle = fopen('orders.csv', 'r');

    $orderRepository = InMemoryOrderRepository::createFromCsv($handle);

    $orderRepository->sort();
    $ordersH = array('product_id', 'quantity', 'priority', 'created_at');

    foreach ($ordersH as $h) {
        echo str_pad($h, 20);
    }
    echo "\n";
    foreach ($ordersH as $h) {
        echo str_repeat('=', 20);
    }
    echo "\n";
    foreach ($orderRepository as $item) {
        $stock = $stockRepository->getItemByProductId($item->getProductId());
        if ($stock != null && $stock->getQuantity() >= $item->getQuantity()) {
            echo str_pad($item->getProductId(), 20);
            echo str_pad($item->getQuantity(), 20);
            $text = 'high';
            if ($item->getPriority() == 1) {
                $text = 'low';
            } else {
                if ($item->getPriority() == 2) {
                    $text = 'medium';
                }
            }
            echo str_pad($text, 20);

            echo str_pad($item->getCreatedAt(), 20);
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}
