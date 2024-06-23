<?php declare(strict_types=1);


use PHPUnit\Framework\TestCase;
use src\Cart;

class testCart extends TestCase
{
    public function testGetNetPriceIsCalculatedCorrectly()
    {
        //Setup
        require 'src/Cart.php';
        $cart = new Cart();
        $cart->price = 10;

        //Do Something
        $netPrice = $cart->getNetPrice();

        //Make Assertions
        $this->assertEquals(12, $netPrice);
    }
}