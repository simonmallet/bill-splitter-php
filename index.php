<?php

require_once __DIR__.'/vendor/autoload.php';

use \lib\FileSystem\FileHandler;
use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter;
use \lib\Template\MoneyOweDisplay;

$fileName = 'data/test2.txt';
$fileHandler = new FileHandler();

if (!$fileHandle = $fileHandler->open($fileName)) {
    echo 'Could not open file: ' . $fileName; die;
}

$fileReader = new CSVFileReader($fileHandler);

$billSplitter = new BillSplitter($fileReader);
$splitData = $billSplitter->splitMoneyEqually();

$display = new MoneyOweDisplay();
$display->display($splitData);
