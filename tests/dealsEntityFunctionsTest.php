<?php

use PHPUnit\Framework\TestCase;
use App\Entity\Deal;

class test extends TestCase
{
    public function dealMock()
    {
        $deal = ['deal_unique' => '1'];
        $deal = ['title' => 'hi hi'];
        $deal = ['slug' => 'hi_hi'];
        $deal = ['img' => 'joke.jpg'];
        $deal = ['sold' => '100'];
        $deal = ['new_price' => '10'];
        $deal = ['from_price' => '12'];
        $deal = ['is_for_sale' => 'true'];
        $deal = ['is_new_today' => 'is_new_today'];
    }
    public function testPriceIsReturnedInTheRightFormat()
    {
        $deal = ['is_new_today' => true];
        $deal = new Deal($deal);

        $deal->setIsForSale(0);
        $this->assertTrue($deal->getIsForSale(), true);
    }
}