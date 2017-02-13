<?php

namespace lib\UseCase\BillSplitter;

use \lib\FileSystem\CSVFileReader;

class Base
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';

    /** @var CSVFileReader */
    private $fileReader;

    /**
     * @param CSVFileReader $fileReader
     * @return Base
     */
    public function __construct(CSVFileReader $fileReader)
    {   
        $this->fileReader = $fileReader;
    }

    /**
     * @return array
     */
    protected function readLine()
    {
        return $this->fileReader->read(self::ROW_BUFFER, self::COLUMN_SEPARATOR);
    }
}

