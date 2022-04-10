<?php

namespace RefactorExercise\Services;

interface IFulfillableOrdersService
{
    function getFulfillableOrders():array;
}