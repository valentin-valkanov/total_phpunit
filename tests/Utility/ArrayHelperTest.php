<?php declare(strict_types=1);

namespace App\Tests\Utility;

use App\Utility\ArrayHelper;
use PHPUnit\Framework\ActualValueIsNotAnObjectException;
use PHPUnit\Framework\TestCase;

class ArrayHelperTest extends TestCase
{
    public function testTheFlattenMethodReturnsFlattenedArray()
    {
        //Arrange
        $array = [
            'key_one' => 1,
            'key_two' => 2,
            'nested_array' =>[
                'key_three' => 3,
                'key_four' => 4
            ]
        ];

        //Act
        $flattenedArray = ArrayHelper::flatten($array);

        //Assert
        $this->assertEquals([
            'key_one' => 1,
            'key_two' => 2,
            'key_three' => 3,
            'key_four' => 4
        ],$flattenedArray );
    }
}