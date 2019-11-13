<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class BeforeTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'updated_at';

        $token = new QueryExpression\Token\BeforeToken($key, '1980-01-29T08:30:45');

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\BeforeToken('updated_at', '1980-01-29T08:30:45');

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::BEFORE);
    }

    public function test_that_value_is_set()
    {
        $value = '1980-01-29T08:30:45';

        $token = new QueryExpression\Token\BeforeToken('updated_at', $value);

        $this->assertEquals($value, $token->getValue());
    }

    /**
     *   @expectedException InvalidArgumentException
     *   @dataProvider data_for_test_that_exception_is_thrown_for_non_parsable_values
     */
    public function test_that_exception_is_thrown_for_non_parsable_values($value)
    {
        new QueryExpression\Token\BeforeToken('key', $value);
    }

    public function data_for_test_that_exception_is_thrown_for_non_parsable_values()
    {
        return [
            [true],
            [false],
            [null],
            [''],
            ['string'],
            [[]],
            [(object) []],
        ];
    }

    public function test_that_token_can_be_created_from_string()
    {
        foreach (['updated_at;after=1980-01-29T08:30:45', 'updated_at;after=1980-01-29 08:30:45'] as $string) {
            $token = QueryExpression\Token\BeforeToken::fromString($string);
            $this->assertInstanceOf(QueryExpression\Token\BeforeToken::class, $token);
        }
    }
}
