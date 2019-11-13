<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class SortToken extends AbstractToken
{
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    protected $key = null;
    protected $value = null;

    public function __construct($key, $value)
    {
        $this->key = $key;

        $value = strtolower(trim($value));
        if (!in_array($value, [static::SORT_ASC, static::SORT_DESC])) {
            throw new InvalidArgumentException('$value must be either "asc" or "desc"');
        }

        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::SORT;
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function fromString($string)
    {
        $arguments = self::fromStringToArguments($string);

        return new static(
            $arguments['key'],
            $arguments['value']
        );
    }
}
