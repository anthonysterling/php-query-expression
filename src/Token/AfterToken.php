<?php

namespace AnthonySterling\QueryExpression\Token;

use DateTime;
use InvalidArgumentException;

class AfterToken extends AbstractToken
{
    protected $key = null;
    protected $value = null;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $this->toDate($value);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::AFTER;
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

    protected function toDate($value)
    {
        $exception = new InvalidArgumentException('$value cannot be converted to a valid date');

        if (!is_string($value)) {
            throw $exception;
        }

        $date = DateTime::createFromFormat('Y-m-d?H:i:s', $value);
        $errors = DateTime::getLastErrors();

        if (!$date || $errors['error_count']) {
            throw $exception;
        }

        return $date->format('Y-m-d\TH:i:s');
    }
}
