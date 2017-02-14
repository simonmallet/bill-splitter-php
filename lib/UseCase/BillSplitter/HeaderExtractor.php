<?php

namespace lib\UseCase\BillSplitter;

class HeaderExtractor extends Base
{
    /**
     * @return array
     */
    public function getHeaderInformation()
    {
        $row = $this->readLine();
        $this->dataValidator->validateHeaderFields($row);

        foreach ($row as $key => $headerName) {
            $headerNames[$headerName]['totalPaid'] = 0;
        }
        return $headerNames;
    }
}

