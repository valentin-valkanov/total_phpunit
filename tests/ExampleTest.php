<?php declare(strict_types=1);

namespace App\Tests;
use App\Cart;

class ExampleTest extends \PHPUnit\Framework\TestCase
{
    public  function testTwoStringsAreTheSame()
    {
        $string1 = 'garyclarketech';
        $string2 = 'garyclarketek';

        $this->assertFalse($string1 == $string2);
    }

    public function testProductIsCalculatedCorrectly()
    {
        require 'example-functions.php';
        $product = product(10, 2);

        $this->assertEquals(20, $product);
        $this->assertNotEquals(10, $product);
    }
    public function testSomeAssertions()
    {
        //Demo static vs $this
//        $this->assertFalse(2 == 1 );

        //assertArrayHasKer
        $testArray = ['foo' => 'bar'];
        $this->assertArrayHasKey('foo', $testArray);
        $this->assertArrayNotHasKey('zoo', $testArray);

        //assertContains
        $this->assertContains('bar', $testArray);
        $this->assertNotContains('zoo', $testArray);

        //assertStringContainsString
        $string = json_encode([
            'price' => '8.99',
            'date' => '2021-12-04'
        ]);
        $this->assertStringContainsString('"date":"2021-12-04"', $string);

        //assertInstanceOf
        $cart = new Cart();
        $this->assertInstanceOf(Cart::class, $cart);

        //assertCount
        $this->assertCount(1, $testArray);

        //assertEquals/assertSame
        $value = '100';
        $this->assertEquals(100, $value);
//        $this->assertSame(1, $value);

        //assertGreaterThan
        $this->assertGreaterThan(10, $value);

        //assertIsArray
        $this->assertIsArray($testArray);


    }

}