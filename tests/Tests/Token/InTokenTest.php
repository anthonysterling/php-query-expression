<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class InTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\InToken($key, [1, 2, 3]);

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\InToken('key', [1, 2, 3]);

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::IN);
    }

    public function test_that_value_is_set()
    {
        $value = [1, 2, 3];

        $token = new QueryExpression\Token\InToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\InToken::fromString('key;in=1,5');

        $this->assertInstanceOf(QueryExpression\Token\InToken::class, $token);
    }
}
