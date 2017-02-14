<?php

namespace lib\FileSystem;

use PHPUnit\Framework\TestCase;
use \Phake;

class CSVFileReaderTest extends TestCase
{
    /** @var CSVFileReader */
    private $csvFileReader;

    /** @var FileHandler */
    private $fileHandler;

    public function setUp()
    {
        $this->fileHandler = Phake::mock(FileHandler::class);
        $this->csvFileReader = new CSVFileReader($this->fileHandler);
    }

    public function testGivenAResourceWhenReadIsCalledThenReturnArray()
    {
        $resource = @fopen(dirname(dirname(dirname(__FILE__))).'/data/file.txt', 'r');
        \Phake::when($this->fileHandler)->getResource()->thenReturn($resource);

        $result = $this->csvFileReader->read();

        \Phake::verify($this->fileHandler)->getResource();
        $this->assertInternalType('array', $result);
    }
}

