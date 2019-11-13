<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class IsEmptyToken extends AbstractToken
{
    protected $key = null;
    protected $value = null;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $this->toBool($value);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::ISEMPTY;
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

    protected function toBool($value)
    {
        $mappings = [
            ['value' => true,      'bool' => true],
            ['value' => 'true',    'bool' => true],
            ['value' => false,     'bool' => false],
            ['value' => 'false',   'bool' => false],
        ];

        if (is_string($value)) {
            $value = strtolower(trim($value));
        }

        foreach ($mappings as $mapping) {
            if ($mapping['value'] === $value) {
                return $mapping['bool'];
            }
        }

        throw new InvalidArgumentException('$value must be either true, false, "true", or "false"');
    }
}
