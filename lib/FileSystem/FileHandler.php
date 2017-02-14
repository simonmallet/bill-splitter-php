<?php

namespace lib\FileSystem;

class FileHandler
{
    /** @var \Resource */
    private $resource = null;

    /**
     * @param string $filename
     * @param string $mode
     * @return \Resource
     */
    public function open($filename, $mode = 'r')
    {
        $this->resource = @fopen($filename, $mode);
        if (!$this->resource) {
            echo 'Could not open file: ' . $filename . '. Check your configuration and try again.';
            die;
        }
        return $this->resource;
    }

    /**
     * @return void
     */
    public function close()
    {
        if ($resource) {
            fclose($this->resource);
        }
    }

    /**
     * @return \Resource|void
     */
    public function getResource()
    {
        if ($this->resource) {
            return $this->resource;
        }
    }

    /**
     * @return void
     */
    function __destruct()
    {
        $this->close();
    }
}

