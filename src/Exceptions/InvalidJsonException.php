<?php

namespace RefactorExercise\Exceptions;

class InvalidJsonException extends \Exception {

    protected $rawJson;
    protected $decodeErrorMessage;

    public function __construct($decodeErrorMessage,$rawJson)
    {
        $this->rawJson = $rawJson;
        $this->decodeErrorMessage =$decodeErrorMessage;
        $this->message = 'Invalid json!';
    }

    public function getRawJson()
    {
        return $this->rawJson;
    }
    public function getDecodeErrorMessage()
    {
        return $this->decodeErrorMessage;
    }
}