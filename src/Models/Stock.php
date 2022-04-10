<?php

namespace RefactorExercise\Models;

class Stock
{
    private $productId;
    private $quantity;

    public function __construct($productId,$quantity)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getProductId()
    {
        return $this->productId;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
}
