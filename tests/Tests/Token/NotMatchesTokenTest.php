<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class NotMatchesTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\NotMatchesToken($key, 'value');

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\NotMatchesToken('key', 'value');

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::NOTMATCHES);
    }

    public function test_that_value_is_set()
    {
        $value = 'value';

        $token = new QueryExpression\Token\NotMatchesToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\NotMatchesToken::fromString('key;not-matches=[0-9]');

        $this->assertInstanceOf(QueryExpression\Token\NotMatchesToken::class, $token);
    }
}
