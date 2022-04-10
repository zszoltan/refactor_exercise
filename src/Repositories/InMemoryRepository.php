<?php

namespace RefactorExercise\Repositories;

abstract class InMemoryRepository implements \IteratorAggregate ,IRepository
{
    protected $items = [];

    protected function __construct()
    {
    }

    public function getIterator(): \Traversable
    {
        yield from $this->items;
    }

    public function getAllItem(): array
    {
        return $this->items;
    }


}
