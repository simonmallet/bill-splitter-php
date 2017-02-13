<?php

namespace lib\FileSystem;

class FileHandler
{
    public function open($filename, $mode = 'r')
    {
        return @fopen($filename, $mode);
    }
}

