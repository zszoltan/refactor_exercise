<?php

namespace RefactorExercise\View;


class FulfillableOrdersView
{
    private $fulfillableOrders;
    private $ordersHeader;

    public function __construct(array $ordersHeader, array $fulfillableOrders)
    {
        $this->fulfillableOrders = $fulfillableOrders;
        $this->ordersHeader = $ordersHeader;
    }

    public function render()
    {
        foreach ($this->ordersHeader as $h) {
            echo str_pad($h, 20);
        }
        echo "\n";
        foreach ($this->ordersHeader as $h) {
            echo str_repeat('=', 20);
        }
        echo "\n";

        foreach ($this->fulfillableOrders as $item) {
            echo str_pad($item->getProductId(), 20);
            echo str_pad($item->getQuantity(), 20);
            echo str_pad($this->convertPriorityToString($item->getPriority()), 20);
            echo str_pad($item->getCreatedAt(), 20);
            echo "\n";
        }
    }
    private function convertPriorityToString($priority)
    {
        switch ($priority) {
            case 1:
                return 'low';
            case 2:
                return 'medium';
            case 3:
                return 'high';
            default:
                return 'unknow';
        }
    }
}
