<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class MoreThanTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\MoreThanToken($key, 1);

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\MoreThanToken('key', 1);

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::MORETHAN);
    }

    public function test_that_value_is_set()
    {
        $value = 1;

        $token = new QueryExpression\Token\MoreThanToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    /**
     *   @expectedException InvalidArgumentException
     *   @dataProvider data_for_test_that_exception_is_thrown_for_non_numeric_values
     */
    public function test_that_exception_is_thrown_for_non_numeric_values($value)
    {
        new QueryExpression\Token\MoreThanToken('key', $value);
    }

    public function data_for_test_that_exception_is_thrown_for_non_numeric_values()
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

    /**
     *  @dataProvider data_for_test_that_value_is_always_converted_to_correct_numeric_type
     */
    public function test_that_value_is_always_converted_to_correct_numeric_type($value, $expected)
    {
        $token = new QueryExpression\Token\MoreThanToken('key', $value);

        $this->assertSame($expected, $token->getValue());
    }

    public function data_for_test_that_value_is_always_converted_to_correct_numeric_type()
    {
        return [
            ['0', 0],
            ['-1', -1],
            ['1', 1],
            ['-1.0', -1.0],
            ['1.0', 1.0],
        ];
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\MoreThanToken::fromString('key;more-than=5');

        $this->assertInstanceOf(QueryExpression\Token\MoreThanToken::class, $token);
    }
}
