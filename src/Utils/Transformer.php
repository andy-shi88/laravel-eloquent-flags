<?php

namespace AndyShi88\LaravelEloquentFlags\Utils;

class Transformer
{
    public static function toInteger(array $flags, array|null $flagValues): int|null
    {
        if (is_null($flagValues)) {
            return null;
        }
        $result = 0;
        foreach ($flagValues as $flagValue) {
            $index = array_search($flagValue, $flags);
            $result += pow(2, $index);
        }

        return $result;
    }

    public static function toLabels(array $flags, int|null $value): null|array
    {
        if (is_null($value)) {
            return null;
        }
        $result = [];
        $binString = decbin($value);
        $binArr = str_split($binString);
        $count = count($binArr);
        for ($i = 0; $i < $count; $i++) {
            if ($binArr[$i] === '1') {
                $result[] = $flags[$count - $i - 1];
            }
        }

        return array_reverse($result);
    }
}
