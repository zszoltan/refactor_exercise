<?php

namespace RefactorExercise;
require __DIR__.'\\../vendor/autoload.php';

use Exception;
use RefactorExercise\Exceptions\AmbiguousNumberOfParametersException;
use RefactorExercise\Repositories\InMemoryOrderRepository;
use RefactorExercise\Repositories\InMemoryStockRepository;
use RefactorExercise\Services\OrderDataSourceProcessService;
use RefactorExercise\Services\FulfillableOrdersService;
use RefactorExercise\View\FulfillableOrdersView;
use RefactorExercise\Core\CsvDataSource;

try {
    if ($argc != 2) {
        throw new AmbiguousNumberOfParametersException($argc, $argv);
    }

    $stockRepository = InMemoryStockRepository::createFromJson($argv[1]);

    $orderRepository = new InMemoryOrderRepository();
    $csvProcessService = new OrderDataSourceProcessService($orderRepository, new CsvDataSource(__DIR__.'\\orders.csv'));
    $csvProcessService->process();
    $ordersH = $csvProcessService->getCsvHeaders();

    $orderRepository->sort();

    $fulfillableOrdersService = new FulfillableOrdersService($stockRepository,$orderRepository);

    $fulfillableOrdersView = new FulfillableOrdersView($ordersH,$fulfillableOrdersService->getFulfillableOrders());
    $fulfillableOrdersView->render();

} catch (Exception $e) {
    echo $e->getMessage();
    exit(1);
}
