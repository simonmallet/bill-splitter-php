<?php

namespace lib\UseCase;

use \lib\FileSystem\CSVFileReader;

class BillSplitter
{
    const ROW_BUFFER = 1028;
    const COLUMN_SEPARATOR = ';';
    private $fileReader;
    private $totalPaidOverall = 0;

    public function __construct(CSVFileReader $fileReader)
    {
        $this->fileReader = $fileReader;
    }

    public function splitMoneyEqually()
    {
        $data = $this->getHeaderInformation();
        $this->calculateTotalPaidByEveryone($data);
        $this->calculateWhoPaysWhatToWho($data);
        return $data;
    }

    private function getHeaderInformation()
    {
        $row = $this->readLine();
        foreach ($row as $key => $headerName) {
            $headerNames[$headerName]['totalPaid'] = 0;
        }
        return $headerNames;
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
            $data[$name]['owes'] = max($averagePerPerson - $data[$name]['totalPaid'], 0);
        }

        
    }

    private function readLine()
    {
        return $this->fileReader->read(self::ROW_BUFFER, self::COLUMN_SEPARATOR);
    }
}

