<?php

namespace Kathore\LaraFormik\Table\Filter;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class BaseFilter
{
    protected string $key;
    protected Closure $callback;

    public static function make($key): self
    {
        $instance = new static();
        $instance->key = $key;
        return $instance;
    }

    public function query(Closure $callback): self
    {
        $this->callback = $callback;
        return $this;
    }

    public function apply(Builder $query, $value): Builder
    {
        if ($this->callback) {
            call_user_func($this->callback, $query, $value);
        }
        return $query;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
