<?php

namespace lib\FileSystem;

class CSVFileReader
{
    /** @var FileHandler */
    private $fileHandle;

    /**
     * @param FileHandler $fileHandle
     * @return FileHandler
     */
    public function __construct(FileHandler $fileHandle)
    {
        $this->fileHandle = $fileHandle;
    }

    /**
     * @param int $length
     * @param string $delimiter
     * @param string $enclosure
     * @param string $escapeCharacter
     * @return array
     */
    public function read($length = 0, $delimiter = ',', $enclosure = '"', $escapeCharacter = "\\")
    {
        return fgetcsv($this->fileHandle->getResource(), $length, $delimiter, $enclosure, $escapeCharacter);
    }
}

