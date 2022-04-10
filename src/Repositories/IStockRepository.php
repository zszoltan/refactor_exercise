<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Stock;

interface IStockRepository
{
    function getItemByProductId($productId) : Stock;
}
