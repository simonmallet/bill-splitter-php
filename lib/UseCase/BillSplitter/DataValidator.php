<?php

namespace lib\UseCase\BillSplitter;

use lib\UseCase\BillSplitter\Exception\InvalidHeaderFieldException;
use lib\UseCase\BillSplitter\Exception\InvalidFieldException;
use lib\UseCase\BillSplitter\Exception\HeaderRowCannotBeEmptyException;

class DataValidator
{
    /**
     * @param array $data
     * @return void
     * @throws InvalidHeaderFieldException|HeaderRowCannotBeEmptyException
     */
    public function validateHeaderFields(array $data)
    {
        if ($this->isRowEmpty($data)) {
            throw new HeaderRowCannotBeEmptyException("The header row must contain values");
        }
        
        foreach ($data as $fieldHeader) {
            /** @todo support utf-8 chars, like accents. */
            if (!preg_match("/^[a-zA-Z]+$/", $fieldHeader)) {
                throw new InvalidHeaderFieldException("The header value '{$fieldHeader}' contains unsupported characters. It may contain only letters from A to Z.");
            }
        }
    }

    /**
     * @param array $data
     * @return void
     * @throws InvalidFieldException
     */
    public function validateMoneyField(array $data)
    {
        if ($this->isRowEmpty($data)) {
            return;
        }

        foreach ($data as $moneyField) {
            /** @todo support decimal numbers */
            if (!preg_match("/^[0-9]+$/", $moneyField)) {
                throw new InvalidFieldException("The amount '{$moneyField}' is invalid. It may contain only a number above zero without decimals.");
            }
        }
    }

    /**
     * @param array $row
     * @return bool
     */
    private function isRowEmpty($row)
    {
        return count($row) == 1 && empty($row[0]);
    }
}

