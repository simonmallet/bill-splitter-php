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
        foreach ($data as $name => $dataSheet) {
            echo '<b>'.ucfirst($name).'</b><br>';
            echo 'Paid in total: ' . $dataSheet['totalPaid'] . '<br>';
            
            if (isset($dataSheet['result'])) {
                foreach ($dataSheet['result'] as $result) {
                    foreach ($result as $giveOrReceive => $amount) {
                        echo $giveOrReceive . ' ' . ucfirst($amount) . ' ';
                    }
                    echo '<br>';
                }
            } else {
                echo 'This person does not owe or receive any money.<br>';
            }
            echo '<br>';
        }
    }
}

