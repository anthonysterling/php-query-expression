<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class IsEmptyTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\IsEmptyToken($key, true);

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\IsEmptyToken('key', true);

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::ISEMPTY);
    }

    public function test_that_value_is_set()
    {
        $value = true;

        $token = new QueryExpression\Token\IsEmptyToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    /**
     *  @dataProvider data_for_test_that_value_is_always_converted_to_correct_boolean_type
     */
    public function test_that_value_is_always_converted_to_correct_boolean_type($value, $expected)
    {
        $token = new QueryExpression\Token\IsEmptyToken('key', $value);

        $this->assertInternalType('boolean', $token->getValue());
        $this->assertSame($expected, $token->getValue());
    }

    public function data_for_test_that_value_is_always_converted_to_correct_boolean_type()
    {
        return [
            [true, true],
            ['true', true],
            [' true ', true],
            [' TRUE ', true],
            ['TRUE', true],
            ['True', true],
            [false, false],
            ['false', false],
            [' false ', false],
            [' FALSE ', false],
            ['FALSE', false],
            ['False', false],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider data_for_test_that_invalid_value_throws_exception
     */
    public function test_that_invalid_value_throws_exception($value)
    {
        new QueryExpression\Token\IsEmptyToken('key', $value);
    }

    public function data_for_test_that_invalid_value_throws_exception()
    {
        return [
            [1],
            ['1'],
            [0],
            ['0'],
            [null],
            ['null'],
            [''],
        ];
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\IsEmptyToken::fromString('key;is-empty=true');

        $this->assertInstanceOf(QueryExpression\Token\IsEmptyToken::class, $token);
    }
}
