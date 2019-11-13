<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class Factory
{
    protected $tokens = [
        Token::IS => 'IsToken',
        Token::NOT => 'NotToken',
        Token::BETWEEN => 'BetweenToken',
        Token::NEAR => 'NearToken',
        Token::IN => 'InToken',
        Token::NOTIN => 'NotInToken',
        Token::LESSTHAN => 'LessThanToken',
        Token::MORETHAN => 'MoreThanToken',
        Token::ISORLESSTHAN => 'IsOrLessThanToken',
        Token::ISORMORETHAN => 'IsOrMoreThanToken',
        Token::CONTAINS => 'ContainsToken',
        Token::NOTCONTAINS => 'NotContainsToken',
        Token::MATCHES => 'MatchesToken',
        Token::NOTMATCHES => 'NotMatchesToken',
        Token::ISEMPTY => 'IsEmptyToken',
    ];

    public static function create()
    {
        return new static();
    }

    public function fromString($string)
    {
        $arguments = preg_split('~;|=~', $string);

        if (!isset($arguments[1])) {
            throw new InvalidArgumentException(sprintf(
                '$string (%s) could not be parsed',
                $string
            ));
        }

        $token = $this->getTokenClassFromType($arguments[1]);

        return call_user_func_array(['AnthonySterling\\QueryExpression\\Token\\'.$token, 'fromString'], [$string]);
    }

    protected function getTokenClassFromType($type)
    {
        if (!array_key_exists($type, $this->tokens)) {
            throw new InvalidArgumentException(sprintf(
                '$type (%s) is invalid',
                $type
            ));
        }

        return $this->tokens[$type];
    }
}
