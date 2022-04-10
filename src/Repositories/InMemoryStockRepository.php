<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Stock;
use RefactorExercise\Exceptions\InvalidJsonException;

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
        if (($stockRaw = json_decode($json)) == null) {
            throw new InvalidJsonException(json_last_error_msg(),$json);
        }

        $repository = new InMemoryStockRepository();
        foreach ($stockRaw as $productId => $quantity) {
            $repository->items[] = new Stock($productId, $quantity);
        }
        return $repository;
    }
}
