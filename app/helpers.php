<?php

use Illuminate\Support\Arr;

/**
 * @param $class
 * @return array
 */
function getEnumValues($class): array
{
    return Arr::pluck($class::cases(), 'value');
}

