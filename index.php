<?php

require_once __DIR__.'/vendor/autoload.php';

use \lib\FileSystem\FileHandler;
use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter;
use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\Template\MoneyOweDisplay;

$fileName = 'data/test2.txt';
$fileHandler = new FileHandler();

if (!$fileHandle = $fileHandler->open($fileName)) {
    echo 'Could not open file: ' . $fileName; die;
}

$fileReader = new CSVFileReader($fileHandler);
$headerExtractor = new HeaderExtractor($fileReader);

$billSplitter = new BillSplitter($fileReader, $headerExtractor);
$splitData = $billSplitter->splitMoneyEqually();

$display = new MoneyOweDisplay();
$display->display($splitData);
