<?php

require_once __DIR__.'/vendor/autoload.php';

use \lib\FileSystem\FileHandler;
use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter;

$fileName = 'data/test1.txt';
$fileHandler = new FileHandler();

if (!$fileHandle = $fileHandler->open($fileName)) {
    echo 'Could not open file: ' . $fileName; die;
}

$fileReader = new CSVFileReader($fileHandler);

$billSplitter = new BillSplitter($fileReader);
$billSplitter->doItAll();
