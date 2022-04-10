<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Order;

interface IOrderRepository
{
    function sort() :void;
    function insert(Order $order);
}