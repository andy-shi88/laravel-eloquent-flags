<?php

namespace AndyShi88\LaravelEloquentFlags\Tests\TestSupport;

use AndyShi88\LaravelEloquentFlags\HasFlags;
use AndyShi88\LaravelEloquentFlags\Interfaces\Flagable;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model implements Flagable
{
    use HasFlags;

    /**
     * flaggableColumns define which columns we want to handle with flagable
     * format:
     *  [
     *      'column' => [labels],
     *      'column' => [labels]
     *  ]
     */
    public $flagableColumns = [
        'flag_a' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
        'flag_b' => ['1', '2', '3', '4', '5', '6'],
    ];

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    public $flagable = ['flag_a', 'flag_b'];
}
