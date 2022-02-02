<?php

use PHPUnit\Framework\TestCase;
use App\Entity\Deal;

class test extends TestCase
{
//    public function dealMock()
//    {
//        $deal = ['deal_unique' => '1'];
//        $deal = ['title' => 'hi hi'];
//        $deal = ['slug' => 'hi_hi'];
//        $deal = ['img' => 'joke.jpg'];
//        $deal = ['sold' => '100'];
//        $deal = ['new_price' => '10'];
//        $deal = ['from_price' => '12'];
//        $deal = ['is_for_sale' => 'true'];
//        $deal = ['is_new_today' => 'is_new_today'];
//    }

//    public function testPriceIsReturnedInTheRightFormat()
//    {
//        $deal = ['is_new_today' => true];
//        $deal = new Deal($deal);
//
//        $deal->setIsForSale(0);
//        $this->assertTrue($deal->getIsForSale(), true);
//    }


    private const ZEROS_BEHIND_COMMA_PRICE = '00';

    const DEAL_MOCK =
        [
        'unique' => '1',
        'title' => 'hi hi',
        'slug' => 'hi_hi',
        'img' => 'joke.jpg',
        'sold' => '100',
        'price' => '11.12',
        'from' => '12',
        'is_for_sale' => 'true',
        'is_new_today' => 'is_new_today',
        ];

    public function newDeal()
    {
        return new Deal(self::DEAL_MOCK);
    }
    public function testIsForSaleIsTrue()
    {
        $newDeal = $this->newDeal();
        $this->assertTrue($newDeal->getIsForSale(), "This function is not true!");
    }

    public function testIfPriceIsCorrectAndAsHtml(): string
    {
        $newDeal = $this->newDeal();
        $price = $newDeal->getNewPrice();

        $formatted = number_format(floatval($price), 2);
        $seperate = explode(".", $formatted);

        if($seperate[0] === self::ZEROS_BEHIND_COMMA_PRICE)
        {
            $return = '<div class="before">&euro;' . $seperate[0] . '</div>';
            self::assertEquals('<div class="before">&euro;' . '11</div>', $return, 'There are no numbers after comma');
        }
        $return = '<div class="before">&euro;' . $seperate[0] . ',</div><div class="after">' . $seperate[1] . '</div>';
        self::assertEquals('<div class="before">&euro;' . '11,</div><div class="after">12</div>', $return, 'There are numbers after comma');

        return $return;
    }

    public function testIfDiscountHasRightFormat()
    {
        $newDeal = $this->newDeal();
        self::assertEquals('7', $newDeal->getPercentDiscount());
    }

}