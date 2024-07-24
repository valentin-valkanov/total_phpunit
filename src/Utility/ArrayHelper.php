<?php declare(strict_types=1);

namespace App\Utility;

class ArrayHelper
{
    public static function flatten(array $array): array
    {
        return iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array)));
    }
}