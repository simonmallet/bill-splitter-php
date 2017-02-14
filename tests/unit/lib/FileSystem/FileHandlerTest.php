<?php

namespace lib\FileSystem;

use PHPUnit\Framework\TestCase;
use \Phake;

class FileHandlerTest extends TestCase
{
    /** @var FileHandler */
    private $fileHandler;

    /** @var string */
    private $pathToFile;

    public function setUp()
    {
        $this->pathToFile = dirname(dirname(dirname(__FILE__))).'/data/file.txt';
        $this->fileHandler = new FileHandler();
    }

    public function testOpenWithAValidFileReturnsAResource()
    {
        $result = $this->openFile($this->pathToFile);

        $this->assertInternalType('resource', $result);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testOpenWithAnInvalidFileThrowsAnException()
    {
        $result = $this->openFile("def");
    }

    public function testGetResourceWillReturnTheOpenedResource()
    {
        $result = $this->openFile($this->pathToFile);

        $receivedResource = $this->fileHandler->getResource();
       
        $this->assertSame($result, $receivedResource);
    }

    /**
     * @param string $path
     * @return resource
     */
    private function openFile($path)
    {
        return $this->fileHandler->open($path);
    }
}

