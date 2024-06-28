<?php declare(strict_types=1);

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Cart;

class CartTest extends TestCase
{
    public function testGetNetPriceIsCalculatedCorrectly()
    {
        //Setup

        $cart = new Cart();
        $cart->price = 10;

        //Do Something
        $netPrice = $cart->getNetPrice();

        //Make Assertions
        $this->assertEquals(12, $netPrice);
    }
}