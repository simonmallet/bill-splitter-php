<?php

namespace lib\UseCase\BillSplitter;

use PHPUnit\Framework\TestCase;
use \Phake;
use \lib\FileSystem\CSVFileReader;

class HeaderExtractorTest extends TestCase
{
    /** @var CSVFileReader */
    private $csvFileReader;

    /** @var DataValidator */
    private $dataValidator;

    /** @var HeaderExtractor */
    private $headerExtractor;

    public function setUp()
    {
        $this->csvFileReader = Phake::mock(CSVFileReader::class);
        $this->dataValidator = Phake::mock(DataValidator::class);

        $this->headerExtractor = new HeaderExtractor($this->csvFileReader, $this->dataValidator);
    }

    public function testGetHeaderInformationCallsValidateAndReturnsHashWithNames()
    {
        $firstRowData = [
            'person1',
            'person2'
        ];
        $expectedHeaderNamesFormat = [
            'person1' => [
                'totalPaid' => 0
             ],
             'person2' => [
                'totalPaid' => 0
             ]
        ];
        Phake::when($this->csvFileReader)->read(Base::ROW_BUFFER, Base::COLUMN_SEPARATOR)->thenReturn($firstRowData);
        Phake::when($this->dataValidator)->validateHeaderFields($row);

        $result = $this->headerExtractor->getHeaderInformation();

        $this->assertSame($expectedHeaderNamesFormat, $result);
        Phake::verify($this->dataValidator)->validateHeaderFields($firstRowData);
    }
}

