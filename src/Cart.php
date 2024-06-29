<?php declare(strict_types=1);

namespace App;

class Cart
{
    private float $price;
    private static float $tax = 1.2;

    public function getNetPrice()
    {
        return $this->price * self::$tax;
    }

    public static function setTax($tax)
    {
         self::$tax = $tax;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}