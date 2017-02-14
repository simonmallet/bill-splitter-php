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
     * @throws \RuntimeException
     */
    public function open($filename, $mode = 'r')
    {
        $this->resource = @fopen($filename, $mode);
        if (!$this->resource) {
            throw new \RuntimeException("File " . $filename . ' could not be found or is not writable');
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

