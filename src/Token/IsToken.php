<?php

namespace AnthonySterling\QueryExpression\Token;

class IsToken extends AbstractToken
{
    protected $key = null;
    protected $value = null;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::IS;
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
