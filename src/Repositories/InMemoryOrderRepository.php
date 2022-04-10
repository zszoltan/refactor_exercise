<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Order;

class InMemoryOrderRepository extends InMemoryRepository implements IOrderRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function sort(): void
    {
        usort($this->items, function ($a, $b) {
            $pc = -1 * ($a->getPriority() <=> $b->getPriority());
            return $pc == 0 ? $a->getCreatedAt() <=> $b->getCreatedAt() : $pc;
        });
    }
    public function insert(Order $order): void
    {
       $this->items []= $order;
    }

    public static function createFromCsv($csvHandle): InMemoryOrderRepository
    {
        $repository = new InMemoryOrderRepository();
        $row = 1;
        if ($csvHandle !== false) {
            while (($data = fgetcsv($csvHandle)) !== false) {
                if ($row == 1) {
                    //$ordersH = $data;
                } else {
                    $repository->items[] = new Order($data[0], $data[1], $data[2], $data[3]);
                }
                $row++;
            }
        }
        return $repository;
    }
}
