<?php

namespace lib\Template;

use PHPUnit\Framework\TestCase;
use \Phake;

class MoneyOweDisplayTest extends TestCase
{
    /** @var MoneyOweDisplay */
    private $moneyOweDisplay;


    public function setUp()
    {
        $this->moneyOweDisplay = new MoneyOweDisplay();
    }


    /**
     * @dataProvider dataProvider
     */
    public function testOpenWithAValidFileReturnsAResource($input, $expected)
    {
        $result = $this->moneyOweDisplay->display($input);

        $this->assertSame($expected, $result);
    }

    public function dataProvider()
    {
        $twoPeopleNoMoneyInput = [
            'simon' => [
                'totalPaid' => 0
            ],
            'caroline' => [
                'totalPaid' => 0
            ],
        ];

        $twoPeopleNoMoneyExpected = "<b>Simon</b><br>Paid in total: 0<br>This person does not owe or receive any money.<br><br><b>Caroline</b><br>Paid in total: 0<br>This person does not owe or receive any money.<br><br>";

        $threePeopleTwoWithMoneyInput = [
            'simon' => [
                'totalPaid' => 10,
                'result' => [
                    [
                        'giveTo' => 'caroline',
                        'amount' => 2.5
                    ]
                ]
            ],
            'caroline' => [
                'totalPaid' => 15,
                'result' => [
                    [
                        'receiveFrom' => 'simon',
                        'amount' => 2.5
                    ]
                ]
            ],
            'jim' => [
                'totalPaid' => 12.5
            ],
        ];

        $threePeopleTwoWithMoneyExpected = "<b>Simon</b><br>Paid in total: 10<br>giveTo Caroline amount 2.5 <br><br><b>Caroline</b><br>Paid in total: 15<br>receiveFrom Simon amount 2.5 <br><br><b>Jim</b><br>Paid in total: 12.5<br>This person does not owe or receive any money.<br><br>";

        return [
            [$twoPeopleNoMoneyInput, $twoPeopleNoMoneyExpected],
            [$threePeopleTwoWithMoneyInput, $threePeopleTwoWithMoneyExpected]
        ];
    }
}

