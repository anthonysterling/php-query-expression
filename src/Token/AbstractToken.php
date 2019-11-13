<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

abstract class AbstractToken implements Token
{
    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
        ];
    }

    public function __toString()
    {
        $token = $this->toArray();

        if (is_array($token['value'])) {
            $token['value'] = implode(',', $token['value']);
        }

        return sprintf(
            '%s;%s=%s',
            $token['key'],
            $token['type'],
            $token['value']
        );
    }

    protected static function fromStringToArguments($string)
    {
        preg_match_all('~^([^;]+);([^=]+)=(.+)$~i', $string, $matches, PREG_SET_ORDER);

        $arguments = $matches[0];

        if (4 !== count($arguments)) {
            throw new InvalidArgumentException(sprintf(
                '$string (%s) could not be parsed',
                $string
            ));
        }

        return [
            'key' => $arguments[1],
            'type' => $arguments[2],
            'value' => $arguments[3],
        ];
    }

    abstract public static function fromString($string);
}
