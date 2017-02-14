<?php

namespace lib\FileSystem;

use PHPUnit\Framework\TestCase;
use \Phake;

class CSVFileReaderTest extends TestCase
{
    /** @var CSVFileReader */
    private $csvFileReader;

    public function setUp()
    {
        $fileHandler = Phake::mock(FileHandler::class);
        $this->csvFileReader = new CSVFileReader($fileHandler);
    }

    public function testOK()
    {
        $this->assertTrue(true);
    }
}

