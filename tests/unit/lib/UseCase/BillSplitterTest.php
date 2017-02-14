<?php

namespace lib\UseCase;

use PHPUnit\Framework\TestCase;
use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\UseCase\BillSplitter\Calculator;
use \Phake;

class BillSplitterTest extends TestCase
{
    /** @var BillSplitter */
    private $billSplitter;

    /** @var HeaderExtractor */
    private $headerExtractor;

    /** @var Calculator */
    private $calculator;

    public function setUp()
    {
        $this->headerExtractor = Phake::mock(HeaderExtractor::class);
        $this->calculator = Phake::mock(Calculator::class);
        $this->billSplitter = new BillSplitter($this->headerExtractor, $this->calculator);
    }

    public function testSplitMoneyWillCallHeaderExtractorAndCalulatorAndReturnArray()
    {
        $headerInformation = ['headerInfo'];
        $totalPaidEveryone = 100;

        Phake::when($this->headerExtractor)->getHeaderInformation()->thenReturn($headerInformation);
        Phake::when($this->calculator)->calculateTotalPaidByEveryone($headerInformation)->thenReturn($totalPaidEveryone);
        Phake::when($this->calculator)->calculateWhoPaysWhatToWho($headerInformation, $totalPaidEveryone);

        $result = $this->billSplitter->splitMoneyEqually();

        $this->assertSame($headerInformation, $result);

        Phake::verify($this->headerExtractor)->getHeaderInformation();
        Phake::verify($this->calculator)->calculateTotalPaidByEveryone($headerInformation);
        Phake::verify($this->calculator)->calculateWhoPaysWhatToWho($headerInformation, $totalPaidEveryone);
    }
}

