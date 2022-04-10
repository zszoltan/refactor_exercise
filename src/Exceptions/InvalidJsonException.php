<?php

namespace RefactorExercise\Exceptions;

use Exception;

class InvalidJsonException extends Exception {
    protected $rawJson;
    public function __construct($rawJson)
    {
        $this->rawJson = $rawJson;
        $this->message = 'Invalid json!';
    }

    public function getRawJson()
    {
        return $this->rawJson;
    }
}