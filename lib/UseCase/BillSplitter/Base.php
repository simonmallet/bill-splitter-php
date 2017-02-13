<?php

namespace lib\UseCase\BillSplitter;

use \lib\FileSystem\CSVFileReader;

class Base
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';
    private $fileReader;

    public function __construct(CSVFileReader $fileReader)
    {   
        $this->fileReader = $fileReader;
    }

    protected function readLine()
    {
        return $this->fileReader->read(self::ROW_BUFFER, self::COLUMN_SEPARATOR);
    }
}

