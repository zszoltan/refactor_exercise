<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Stock;

class InMemoryStockRepository
{
    protected $items;

    protected function __construct()
    {
        $this->items = [];
    }

    public function getItemByProductId($productId): Stock
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() == $productId)
                return $item;
        }
        return null;
    }
    public function getAllItem() : array
    {
        return $this->items;
    }

    public static function createFromJson($json) : InMemoryStockRepository
    {
        $repository = new InMemoryStockRepository();
        foreach ($json as $productId => $quantity) {
            $repository->items[] = new Stock($productId, $quantity);
        }
        return $repository;
    }
}
