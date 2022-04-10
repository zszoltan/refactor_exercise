<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Stock;
use RefactorExercise\Exceptions\InvalidJsonException;

class InMemoryStockRepository extends InMemoryRepository implements IStockRepository
{
    protected function __construct()
    {
        parent::__construct();
    }

    public function getItemByProductId($productId): Stock
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() == $productId)
                return $item;
        }
        return null;
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
