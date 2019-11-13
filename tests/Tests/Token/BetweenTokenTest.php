<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class BetweenTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\IsToken($key, 'value');

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\BetweenToken('key', 1, 3);

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::BETWEEN);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_that_exception_is_thrown_for_lower_higher_than_upper()
    {
        new QueryExpression\Token\BetweenToken('key', 4, 3);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function test_that_exception_is_thrown_for_lower_equal_to_upper()
    {
        new QueryExpression\Token\BetweenToken('key', 1, 1);
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\BetweenToken::fromString('key;between=1,5');

        $this->assertInstanceOf(QueryExpression\Token\BetweenToken::class, $token);
    }
}
