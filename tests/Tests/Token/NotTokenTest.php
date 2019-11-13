<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class NotTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\NotToken($key, 'value');

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\NotToken('key', 'value');

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::NOT);
    }

    public function test_that_value_is_set()
    {
        $value = 'value';

        $token = new QueryExpression\Token\NotToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\NotToken::fromString('key;not=5');

        $this->assertInstanceOf(QueryExpression\Token\NotToken::class, $token);
    }
}
