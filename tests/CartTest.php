<?php declare(strict_types=1);

namespace App\Tests;
use PHPUnit\Framework\TestCase;
use App\Cart;

class CartTest extends TestCase
{
    protected $cart;
    protected function setUp(): void
    {
        Cart::setTax(1.2);
        $this->cart = new Cart();
    }

    protected function tearDown(): void
    {
//        Cart::setTax(1.2);
    }

    public function testTheCartTaxValueCanBeChangedStatically()
    {
        //Setup

        $this->cart->price = 10;

        //Do something
        Cart::setTax(1.5);
        $netPrice = $this->cart->getNetPrice();

        //Make Assertions
        $this->assertEquals(15, $netPrice);
    }

    public function testGetNetPriceIsCalculatedCorrectly()
    {
        //Setup
        $this->cart->price = 10;

        //Do Something
        $netPrice = $this->cart->getNetPrice();

        //Make Assertions
        $this->assertEquals(12, $netPrice);
    }
}