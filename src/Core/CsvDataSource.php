<?php

namespace RefactorExercise\Core;

class CsvDataSource implements IDataSource
{

    protected $filename;
    protected $fileHandle;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    public function readDataRow()
    {
        if ($this->fileHandle == null) {
            $this->fileHandle = fopen($this->filename, 'r');
        }
        while (($data = fgetcsv($this->fileHandle)) !== false) {
            return $data;
        }
        return false;
    }
}
