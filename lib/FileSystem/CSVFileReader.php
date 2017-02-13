<?php

namespace lib\FileSystem;

class CSVFileReader
{
    public function read($handle, $length = 0, $delimiter = ',', $enclosure = '"', $escapeCharacter = "\\")
    {
        return fgetcsv($handle, $length, $delimiter, $enclosure, $escapeCharacter);
    }
}

