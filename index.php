<?php

require_once __DIR__.'/vendor/autoload.php';

use \lib\FileSystem\FileHandler;
use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter;
use \lib\UseCase\BillSplitter\HeaderExtractor;
use \lib\UseCase\BillSplitter\Calculator;
use \lib\UseCase\BillSplitter\DataValidator;
use \lib\Template\MoneyOweDisplay;

$fileName = 'data/test1.txt';
$fileHandler = new FileHandler();

try {
    $fileHandle = $fileHandler->open($fileName);
} catch (\Exception $e) {
    echo $e->getMessage();
    die;
}

$fileReader = new CSVFileReader($fileHandler);
$dataValidator = new DataValidator();
$headerExtractor = new HeaderExtractor($fileReader, $dataValidator);
$calculator = new Calculator($fileReader, $dataValidator);

$billSplitter = new BillSplitter($headerExtractor, $calculator);

try {
    $splitData = $billSplitter->splitMoneyEqually();
} catch (\Exception $e) {
    echo $e->getMessage();
    die;
}

$display = new MoneyOweDisplay();
$display->display($splitData);
