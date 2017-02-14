<?php

namespace lib\UseCase\BillSplitter;

use PHPUnit\Framework\TestCase;
use \Phake;

class DataValidatorTest extends TestCase
{
    /** @var DataValidator */
    private $dataValidator;

    public function setUp()
    {
        $this->dataValidator = new DataValidator();
    }

    public function testGivenProperNamesWhenValidateHeaderFieldsThenReturnNull()
    {
        $data = ['bob', 'marie'];
        $result = $this->dataValidator->validateHeaderFields($data);
        $this->assertNull($result);
    }

    /**
     * @expectedException lib\UseCase\BillSplitter\Exception\HeaderRowCannotBeEmptyException
     */
    public function testGivenNoDataWhenValidateHeaderFieldsThenThrowsException()
    {
        $data = [null];
        $this->dataValidator->validateHeaderFields($data);
    }

    /**
     * @expectedException lib\UseCase\BillSplitter\Exception\InvalidHeaderFieldException
     */
    public function testGivenSecondFieldContainsNoLetterWhenValidateHeaderFieldsThenThrowException()
    {
        $data = ['maria', 'bob3'];
        $this->dataValidator->validateHeaderFields($data);
    }

    public function testGivenNoDataWhenValidateMoneyFieldThenDoNothing()
    {
        $data = [null];
        $this->assertNull($this->dataValidator->validateMoneyField($data));
    }
    
    public function testGivenProperDataWhenValidateMoneyFieldThenReturnNull()
    {
        $data = ['100', 200, 300];
        $this->assertNull($this->dataValidator->validateMoneyField($data));
    }

    /**
     * @expectedException lib\UseCase\BillSplitter\Exception\InvalidFieldException
     */
    public function testGivenInvalidDataInThirdFieldWhenValidateMoneyFieldThenThrowException()
    {
        $data = ['100', 200, 'carl', 200];
        $this->dataValidator->validateMoneyField($data);
    }
}

