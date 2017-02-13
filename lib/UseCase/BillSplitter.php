<?php

namespace lib\UseCase;

use \lib\FileSystem\CSVFileReader;

class BillSplitter
{
    private $fileReader;

    public function __construct(CSVFileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function doItAll()
    {
        while ($row = $this->fileReader->read(1028, ';')) {print_r($row);}
    }
}

