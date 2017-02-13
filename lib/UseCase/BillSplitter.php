<?php

namespace lib\UseCase;

use \lib\FileSystem\CSVFileReader;
use \lib\UseCase\BillSplitter\HeaderExtractor;

class BillSplitter
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';
    private $fileReader;
    private $totalPaidOverall = 0;
    private $headerExtractor;

    public function __construct(CSVFileReader $fileReader, HeaderExtractor $headerExtractor)
    {
        $this->fileReader = $fileReader;
        $this->headerExtractor = $headerExtractor;
    }

    public function splitMoneyEqually()
    {
        $data = $this->headerExtractor->getHeaderInformation();
        $this->calculateTotalPaidByEveryone($data);
        $this->calculateWhoPaysWhatToWho($data);
        return $data;
    }

    private function calculateTotalPaidByEveryone(&$data)
    {
        while ($row = $this->readLine()) {
            $position = 0;
            foreach($data as $name => $dataSheet) {
                $data[$name]['totalPaid'] += $row[$position];
                $this->totalPaidOverall += $row[$position];
                $position++;
            }
        }
    }

    private function calculateWhoPaysWhatToWho(&$data)
    {
        $averagePerPerson = $this->totalPaidOverall / count($data);

        foreach($data as $name => $dataSheet) {
            $data[$name]['balance'] = $averagePerPerson - $dataSheet['totalPaid'];
        }

        foreach($data as $name => $dataSheet) {
            if ($dataSheet['balance'] < 0) {
                $this->getMoneyFrom($data, $name, $dataSheet['balance']);
            }
        }
    }

    private function getMoneyFrom(&$data, $giveMoneyTo, $moneyRequired)
    {
        if ($moneyRequired >= 0) return;

        foreach ($data as $name => $dataSheet) {
            if ($dataSheet['balance'] > 0) {
                if (abs($moneyRequired) > $dataSheet['balance']) {
                    $data[$name]['result'][] = ['giveTo' => $giveMoneyTo, 'amount' => $dataSheet['balance']];
                    $data[$giveMoneyTo]['result'][] = ['receiveFrom' => $name, 'amount' => $dataSheet['balance']];
                    $data[$giveMoneyTo]['balance'] += $dataSheet['balance'];
                    $moneyRequired += $dataSheet['balance'];
                    $data[$name]['balance'] = 0;
                    return $this->getMoneyFrom($data, $giveMoneyTo, $moneyRequired);
                } else {
                    $data[$name]['result'][] = ['giveTo' => $giveMoneyTo, 'amount' => abs($moneyRequired)];
                    $data[$giveMoneyTo]['result'][] = ['receiveFrom' => $name, 'amount' => abs($moneyRequired)];
                    $data[$name]['balance'] += $moneyRequired;
                    $data[$giveMoneyTo]['balance'] -= $moneyRequired;
                    return;
                }
            }
        }
    }

    private function readLine()
    {
        return $this->fileReader->read(self::ROW_BUFFER, self::COLUMN_SEPARATOR);
    }
}

