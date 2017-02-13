<?php

namespace lib\FileSystem;

class FileHandler
{
    private $resource = null;

    public function open($filename, $mode = 'r')
    {
        return $this->resource = @fopen($filename, $mode);
    }

    public function close()
    {
        if ($resource) {
            fclose($this->resource);
        }
    }

    public function getResource()
    {
        if ($this->resource) {
            return $this->resource;
        }
    }

    function __destruct()
    {
        $this->close();
    }
}

