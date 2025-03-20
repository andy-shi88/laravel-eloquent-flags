<?php

use AndyShi88\LaravelEloquentFlags\Utils\Transformer;

test('toBinaryValue should follow the flags order', function () {
    $a = ['a', 'b', 'c', 'd', 'e'];
    $b = ['b', 'e'];
    $result = Transformer::toInteger($a, $b);
    $this->assertEquals(18, $result);
});

test('toLabels should follow the flags order', function () {
    $a = ['a', 'b', 'c', 'd', 'e'];
    $b = '1010'; // b, d
    $result = Transformer::toLabels($a, bindec($b));
    $this->assertCount(2, $result);
    $this->assertEquals(['b', 'd'], $result);

    $a = ['a', 'b', 'c', 'd', 'e'];
    $b = '11101'; // a, c, d, e
    $result = Transformer::toLabels($a, bindec($b));
    $this->assertCount(4, $result);
    $this->assertEquals(['a', 'c', 'd', 'e'], $result);
});
