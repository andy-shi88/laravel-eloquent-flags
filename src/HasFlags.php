<?php

namespace AndyShi88\LaravelEloquentFlags;

use AndyShi88\LaravelEloquentFlags\Utils\Transformer;
use Illuminate\Database\Eloquent\Builder;

trait HasFlags
{
    // list of fields that's need to be stored as flag
    // protected array $flagableValues = [];
    // nested array of values map
    /**
     * [
     *   'flaggable_column' => ['flag_a', 'flag_b', 'flag_c']
     * ]
     */
    // protected array $flagableLabels = [];

    public function getFlagableAttributes(): array
    {
        return is_array($this->flagableValues)
            ? $this->flagableValues
            : [];
    }

    public function getFlagableLabels(): array
    {
        return $this->flagableLabels;
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

    public function setFlag(string $key, array|null $value): self
    {
        $this->attributes[$key] = Transformer::toInteger($this->getFlagableLabels()[$key], $value);
        return $this;
    }

    public function getFlag(string $key)
    {
        return Transformer::toLabels($this->getFlagableLabels()[$key], $this->attributes[$key]);
    }

    
    public function scopeWhereSome(Builder $query, array $data): Builder
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);
        return $query->whereRaw(sprintf('%s & %d = %d', $data['column'], $value, $value));
    }

    public function scopeWhereIntersect(Builder $query, array $data): Builder
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);
        return $query->whereRaw(sprintf('%s & %d > 0', $data['column'], $value));
    }


    public function scopeWhereAll(Builder $query, array $data)
    {
        $value = Transformer::toInteger($this->getFlagableLabels()[$data['column']], $data['values']);
        return $query->where($data['column'], $value);
    }
}
