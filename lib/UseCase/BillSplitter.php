<?php

namespace lib\UseCase;

use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\UseCase\BillSplitter\Calculator;

class BillSplitter
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';
    private $fileReader;
    private $totalPaidOverall = 0;
    private $headerExtractor;
    private $calculator;

    public function __construct(CSVFileReader $fileReader, HeaderExtractor $headerExtractor, Calculator $calculator)
    {
        $this->fileReader = $fileReader;
        $this->headerExtractor = $headerExtractor;
        $this->calculator = $calculator;
    }

    public function splitMoneyEqually()
    {
        $data = $this->headerExtractor->getHeaderInformation();
        $totalPaidByEveryone = $this->calculator->calculateTotalPaidByEveryone($data);
        $this->calculator->calculateWhoPaysWhatToWho($data, $totalPaidByEveryone);
        return $data;
    }
}

