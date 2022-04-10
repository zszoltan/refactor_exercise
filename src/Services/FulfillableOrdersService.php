<?php

namespace RefactorExercise\Services;

use RefactorExercise\Repositories\IOrderRepository;
use RefactorExercise\Repositories\IStockRepository;

class FulfillableOrdersService implements IFulfillableOrdersService
{
    private $stockRepository;
    private $orderRepository;
    public function __construct(IStockRepository $stockRepository, IOrderRepository $orderRepository)
    {
        $this->stockRepository = $stockRepository;
        $this->orderRepository = $orderRepository;
    }
    public function getFulfillableOrders(): array
    {
        $result = [];
        foreach ($this->orderRepository as $item) {
            $stock = $this->stockRepository->getItemByProductId($item->getProductId());
            if ($stock != null && $stock->getQuantity() >= $item->getQuantity()) {
                $result []= $item;
            }
        }
        return $result;

    }
}