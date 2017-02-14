<?php

namespace lib\UseCase\BillSplitter;

use \lib\FileSystem\CSVFileReader;

class Base
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';

    /** @var CSVFileReader */
    private $fileReader;

    /** @var DataValidator */
    public $dataValidator;

    /**
     * @param CSVFileReader $fileReader
     * @param DataValidator $dataValidator
     * @return Base
     */
    public function __construct(CSVFileReader $fileReader, DataValidator $dataValidator)
    {   
        $this->fileReader = $fileReader;
        $this->dataValidator = $dataValidator;
    }

    /**
     * @return array
     */
    protected function readLine()
    {
        return $this->fileReader->read(self::ROW_BUFFER, self::COLUMN_SEPARATOR);
    }
}

