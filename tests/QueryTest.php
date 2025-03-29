<?php

use AndyShi88\LaravelEloquentFlags\Tests\TestSupport\TestModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

uses(DatabaseTransactions::class);

beforeEach(function () {
    TestModel::create([
        'flag_a' => ['a', 'c', 'd', 'e'],
        'flag_b' => ['1', '3'],
    ]);
    TestModel::create([
        'flag_a' => ['d', 'e'],
        'flag_b' => ['1', '3'],
    ]);

    TestModel::create([
        'flag_a' => ['e'],
        'flag_b' => null,
    ]);
});

it('should be able to get rows that has the provided flags', function () {
    $rows = TestModel::whereSome([
        'column' => 'flag_a',
        'values' => ['a'],
    ])->get();
    $this->assertCount(1, $rows);
});

it('should be able to get rows that has the provided flags | multiple rows returned', function () {
    $rows = TestModel::whereSome([
        'column' => 'flag_a',
        'values' => ['d', 'e'],
    ])->get();
    $this->assertCount(2, $rows);
});

it('should be able to get rows that has the provided flags | multiple rows returned | order does not matter', function () {
    $rows = TestModel::whereSome([
        'column' => 'flag_a',
        'values' => ['e', 'd'],
    ])->get();
    $this->assertCount(2, $rows);
});

it('should be able to return rows with intersected value', function () {
    $rows = TestModel::whereIntersect([
        'column' => 'flag_a',
        'values' => ['e', 'd', 'a'],
    ])->get();
    $this->assertCount(3, $rows);
});

it('should be able to return rows with intersected value | with number of minimal intersection specified', function () {
    $rows = TestModel::whereIntersect([
        'column' => 'flag_a',
        'values' => ['e', 'd', 'a'],
    ], 2)->get();
    $this->assertCount(2, $rows);
})->skip(fn () => 'mysql' !== DB::getDriverName(), 'Only runs when using mysql');
