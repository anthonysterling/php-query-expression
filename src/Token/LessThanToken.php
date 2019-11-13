<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class LessThanToken extends AbstractToken
{
    protected $key = null;
    protected $value = null;

    public function __construct($key, $value)
    {
        $this->key = $key;

        if (!is_numeric($value)) {
            throw new InvalidArgumentException('The $value must be numeric');
        }

        $this->value = $value + 0;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::LESSTHAN;
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
