<?php

namespace lib\UseCase\BillSplitter;

class Calculator extends Base
{
    /**
     * @param  array $data
     * @return int   Total amount paid by everyone
     */
    public function calculateTotalPaidByEveryone(array &$data)
    {
        $totalPaidOverall = 0;
        while ($row = $this->readLine()) {
            $this->dataValidator->validateMoneyField($row);
            $position = 0;
            foreach($data as $name => $dataSheet) {
                $data[$name]['totalPaid'] += $row[$position];
                $totalPaidOverall += $row[$position];
                $position++;
            }
        }
        return $totalPaidOverall;
    }

    /**
     * @param array $data
     * @param int   $totalPaidOverall
     * @return void
     */
    public function calculateWhoPaysWhatToWho(array &$data, $totalPaidOverall)
    {
        $averagePerPerson = $totalPaidOverall / count($data);

        foreach($data as $name => $dataSheet) {
            $data[$name]['balance'] = $averagePerPerson - $dataSheet['totalPaid'];
        }

        foreach($data as $name => $dataSheet) {
            if ($dataSheet['balance'] < 0) {
                $this->getMoneyFrom($data, $name, $dataSheet['balance']);
            }
        }
    }

    /**
     * @param array $data
     * @param string $giveMoneyTo
     * @param int $moneyRequired
     * @return int|null
     */
    private function getMoneyFrom(array &$data, $giveMoneyTo, $moneyRequired)
    {
        /** @todo: Reduce complexity */
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
}

