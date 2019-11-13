<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class BetweenToken extends AbstractToken
{
    protected $key = null;
    protected $lower = null;
    protected $upper = null;

    public function __construct($key, $lower, $upper)
    {
        $lower += 0;
        $upper += 0;

        if ($lower === $upper) {
            throw new InvalidArgumentException('$lower and $upper cannot be equal');
        }

        if ($lower > $upper) {
            throw new InvalidArgumentException('$lower must be lower than $upper');
        }

        $this->key = $key;
        $this->lower = $lower;
        $this->upper = $upper;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::BETWEEN;
    }

    public function getValue()
    {
        return [
            'lower' => $this->lower,
            'upper' => $this->upper,
        ];
    }

    public static function fromString($string)
    {
        $arguments = self::fromStringToArguments($string);

        $arguments['value'] = explode(',', $arguments['value']);

        if (2 !== count($arguments['value'])) {
            throw new InvalidArgumentException(sprintf(
                'Token (BetweenToken) expects value to contain 2 arguments'
            ));
        }

        return new static(
            $arguments['key'],
            $arguments['value'][0],
            $arguments['value'][1]
        );
    }
}
