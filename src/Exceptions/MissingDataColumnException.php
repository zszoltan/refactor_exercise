<?php

namespace RefactorExercise\Exceptions;

class MissingDataColumnException extends \Exception {

    private $missingColumn;
    public function __construct($missingColumn)
    {
        $this->missingColumn = $missingColumn;
        $this->message = 'Missing data source!';
    }

    public function getMissingColumn()
    {
        return $this->missingColumn;
    }

}