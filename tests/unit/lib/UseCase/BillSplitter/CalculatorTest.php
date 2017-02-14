<?php

namespace lib\UseCase\BillSplitter;

use PHPUnit\Framework\TestCase;
use \Phake;
use \lib\FileSystem\CSVFileReader;

class CalculatorTest extends TestCase
{
    /** @var CSVFileReader */
    private $csvFileReader;

    /** @var DataValidator */
    private $dataValidator;

    /** @var Calculator */
    private $calculator;

    public function setUp()
    {
        $this->csvFileReader = Phake::mock(CSVFileReader::class);
        $this->dataValidator = Phake::mock(DataValidator::class);

        $this->calculator = new Calculator($this->csvFileReader, $this->dataValidator);
    }

    public function testGivenThreeBillsWhenCalcTotalPaidIsCalledThenTotalPaidIsReturnedAlongWithModifiedDataPerPerson()
    {
        $expectedTotalPaid = 221;
        $moneyRowOne = [10, 20, 30];
        $moneyRowTwo = [0,  10, 30];
        $moneyRowThree = [11, 44, 66];
        $data = ['sam' => ['totalPaid' => 0], 'claude' => ['totalPaid' => 0], 'sophie' => ['totalPaid' => 0]];

        Phake::when($this->csvFileReader)->read(Base::ROW_BUFFER, Base::COLUMN_SEPARATOR)
            ->thenReturn($moneyRowOne)
            ->thenReturn($moneyRowTwo)
            ->thenReturn($moneyRowThree)
            ->thenReturn(null)
        ;
        $totalPaidByEveryone = $this->calculator->calculateTotalPaidByEveryone($data);
        $this->assertSame($expectedTotalPaid, $totalPaidByEveryone);
        $this->assertSame(21, $data['sam']['totalPaid']);
        $this->assertSame(74, $data['claude']['totalPaid']);
        $this->assertSame(126, $data['sophie']['totalPaid']);
    }

}

