<?php

namespace AndyShi88\LaravelEloquentFlags;

use AndyShi88\LaravelEloquentFlags\Utils\Transformer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasFlags
{
    public function getFlagableAttributes(): array
    {
        return is_array($this->flagableColumns)
            ? array_keys($this->flagableColumns)
            : [];
    }

    public function getFlagableLabels(): array
    {
        return $this->flagableColumns;
    }

    private function isFlagableAttribute(string $key): bool
    {
        return in_array($key, $this->getFlagableAttributes());
    }

    public function setAttribute($key, $value)
    {

        if (! $this->isFlagableAttribute($key)) {
            return parent::setAttribute($key, $value);
        }

        return $this->setFlag($key, $value);
    }

    public function getAttribute($key)
    {

        if (! $this->isFlagableAttribute($key)) {
            return parent::getAttribute($key);
        }

        return $this->getFlag($key);
    }

    private function setFlag(string $key, array|null $value): self
    {
        $this->attributes[$key] = Transformer::toInteger($this->getFlagableLabels()[$key], $value);

        return $this;
    }

    private function getFlag(string $key)
    {
        return Transformer::toLabels($this->getFlagableLabels()[$key], $this->attributes[$key]);
    }

    public function scopeWhereSome(Builder $query, array $data): Builder
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);

        return $query->whereRaw(sprintf('%s & %d = %d', $data['column'], $value, $value));
    }

    public function scopeWhereIntersect(Builder $query, array $data, ?int $count = 1): Builder
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);
        if (in_array(DB::getDriverName(), ['mysql'])) {
            return $query->whereRaw(sprintf('bit_count(%s & %d) >= %d', $data['column'], $value, $count));
        }

        return $query->whereRaw(sprintf('%s & %d > 0', $data['column'], $value));
    }

    public function scopeWhereAll(Builder $query, array $data)
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);

        return $query->where($data['column'], $value);
    }
}
