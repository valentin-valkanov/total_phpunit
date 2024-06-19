<?php declare(strict_types=1);


class ExampleTest extends \PHPUnit\Framework\TestCase
{
    public  function testThatTwoStringsAreTheSame()
    {
        $string1 = 'garyclarketech';
        $string2 = 'garyclarketech';

        $this->assertSame($string1, $string2);
    }

}