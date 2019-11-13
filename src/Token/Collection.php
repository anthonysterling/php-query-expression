<?php

namespace AnthonySterling\QueryExpression\Token;

use Closure;
use Countable;
use ArrayIterator;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate
{
    protected $tokens = [];

    public function __construct(array $tokens = [])
    {
        $this->tokens = array_filter($tokens, function ($token) {
            return $token instanceof Token;
        });
    }

    public function filter(Closure $filter)
    {
        return new static(array_filter($this->toArray(), $filter));
    }

    public function filterByKey($key)
    {
        return $this->filter(function ($token) use ($key) {
            return $token->getKey() === $key;
        });
    }

    public function filterByType($type)
    {
        return $this->filter(function ($token) use ($type) {
            return $token->getType() === $type;
        });
    }

    public function filterByUnique()
    {
        return new static(array_unique($this->toArray(), SORT_STRING));
    }

    public function each(Closure $callback)
    {
        array_map($callback, $this->tokens);

        return $this;
    }

    public function map(Closure $callback)
    {
        return new static(array_map(
            $callback,
            $this->toArray(),
            array_keys($this->toArray())
        ));
    }

    public function sort(Closure $callback)
    {
        uasort($this->tokens, $callback);

        return $this;
    }

    public function merge(Collection $collection)
    {
        return new static(array_merge(
            $this->toArray(),
            $collection->toArray()
        ));
    }

    public function isEmpty()
    {
        return 0 === count($this);
    }

    public function implode($glue = '&')
    {
        return implode($glue, $this->toArray());
    }

    public function count()
    {
        return count($this->toArray());
    }

    public function getIterator()
    {
        return new ArrayIterator($this->toArray());
    }

    public function __toString()
    {
        return $this->implode();
    }

    public function toArray()
    {
        return $this->tokens;
    }
}
