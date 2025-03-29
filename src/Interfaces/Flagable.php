<?php

namespace AndyShi88\LaravelEloquentFlags\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface Flagable
{
    public function scopeWhereSome(Builder $query, array $data): Builder;

    public function scopeWhereIntersect(Builder $query, array $data, ?int $count): Builder;

    public function scopeWhereAll(Builder $query, array $data);
}
