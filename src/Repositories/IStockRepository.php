<?php

namespace RefactorExercise\Repositories;

use RefactorExercise\Models\Stock;

interface IStockRepository extends IRepository
{
    function getItemByProductId($productId) : Stock;
}
