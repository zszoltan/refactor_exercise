<?php

namespace RefactorExercise\Exceptions;


class AmbiguousNumberOfParametersException extends \Exception {
    protected $numberOfParameters;
    protected $parameters;
    public function __construct($numberOfParameters, $parameters)
    {
        $this->numberOfParameters = $numberOfParameters;
    $this->parameters = $parameters;
        $this->message = 'Ambiguous number of parameters!';
    }

    public function getNumberOfParameters()
    {
        return $this->numberOfParameters;
    }
    public function getParameters()
    {
        return $this->parameters;
    }
}