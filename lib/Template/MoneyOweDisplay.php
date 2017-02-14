<?php

namespace lib\Template;

class MoneyOweDisplay
{
    /**
     * @param array $data
     * @return void
     */
    public function display(array $data)
    {
        $displayData = "";

        foreach ($data as $name => $dataSheet) {
            $displayData .= '<b>'.ucfirst($name).'</b><br>';
            $displayData .= 'Paid in total: ' . $dataSheet['totalPaid'] . '<br>';
            
            if (isset($dataSheet['result'])) {
                foreach ($dataSheet['result'] as $result) {
                    foreach ($result as $giveOrReceive => $amount) {
                        $displayData .= $giveOrReceive . ' ' . ucfirst($amount) . ' ';
                    }
                    $displayData .= '<br>';
                }
            } else {
                $displayData .= 'This person does not owe or receive any money.<br>';
            }
            $displayData .= '<br>';
        }
        return $displayData;
    }
}

