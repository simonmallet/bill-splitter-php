<?php

namespace lib\UseCase;

use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\UseCase\BillSplitter\Calculator;

class BillSplitter
{
    /** @var CSVFileReader */
    private $fileReader;

    /** @var HeaderExtractor */
    private $headerExtractor;

    /** @var Calculator */
    private $calculator;

    /**
     * @param CSVFileReader $fileReader
     * @param HeaderExtractor $headerExtractor
     * @param Calculator @calculator
     *
     * @return BillSplitter
     */
    public function __construct(CSVFileReader $fileReader, HeaderExtractor $headerExtractor, Calculator $calculator)
    {
        $this->fileReader = $fileReader;
        $this->headerExtractor = $headerExtractor;
        $this->calculator = $calculator;
    }

    /**
     * @return array
     */
    public function splitMoneyEqually()
    {
        $data = $this->headerExtractor->getHeaderInformation();
        $totalPaidByEveryone = $this->calculator->calculateTotalPaidByEveryone($data);
        $this->calculator->calculateWhoPaysWhatToWho($data, $totalPaidByEveryone);
        return $data;
    }
}

