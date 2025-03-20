<?php

namespace AndyShi88\LaravelEloquentFlags\Tests\TestSupport;

use AndyShi88\LaravelEloquentFlags\HasFlags;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasFlags;

    public $flagableLabels = [
        'flag_a' => ['a', 'b', 'c', 'd', 'e', 'f', 'g'],
        'flag_b' => ['1', '2', '3', '4', '5', '6']
    ];

    public $flagableValues = [
        'flag_a',
        'flag_b',
    ];

    protected $table = 'test_models';

    protected $guarded = [];

    public $timestamps = false;

    public $flagable = ['flag_a', 'flag_b'];

    public function setFieldWithMutatorAttribute($value)
    {
        $this->attributes['field_with_mutator'] = $value;
    }

}