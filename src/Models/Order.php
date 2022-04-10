<?php

namespace RefactorExercise\Models;

class Order
{
    private $productId;
    private $quantity;
    private $priority;
    private $createdAt;

    public function __construct($productId,$quantity,$priority,$createdAt)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->priority = $priority;
        $this->createdAt = $createdAt;
    }

    public function getProductId()
    {
        return $this->productId;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getPriority()
    {
        return $this->priority;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}