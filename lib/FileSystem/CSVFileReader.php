<?php

namespace lib\FileSystem;

class CSVFileReader
{
    private $fileHandle;

    public function __construct(FileHandler $fileHandle)
    {
        $this->fileHandle = $fileHandle;
    }

    public function read($length = 0, $delimiter = ',', $enclosure = '"', $escapeCharacter = "\\")
    {
        return fgetcsv($this->fileHandle->getResource(), $length, $delimiter, $enclosure, $escapeCharacter);
    }
}

