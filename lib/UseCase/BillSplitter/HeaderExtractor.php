<?php

namespace lib\UseCase\BillSplitter;

class HeaderExtractor extends Base
{
    public function getHeaderInformation()
    {
        $row = $this->readLine();
        foreach ($row as $key => $headerName) {
            $headerNames[$headerName]['totalPaid'] = 0;
        }
        return $headerNames;
    }
}

