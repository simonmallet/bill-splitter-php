<?php

namespace lib\UseCase;

use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\UseCase\BillSplitter\Calculator;

class BillSplitter
{
    /** @var HeaderExtractor */
    private $headerExtractor;

    /** @var Calculator */
    private $calculator;

    /**
     * @param HeaderExtractor $headerExtractor
     * @param Calculator @calculator
     *
     * @return BillSplitter
     */
    public function __construct(HeaderExtractor $headerExtractor, Calculator $calculator)
    {
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

