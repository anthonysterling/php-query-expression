<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class SortTokenTest extends PHPUnit_Framework_TestCase
{
    public function test_that_key_is_set()
    {
        $key = 'key';

        $token = new QueryExpression\Token\SortToken($key, QueryExpression\Token\SortToken::SORT_ASC);

        $this->assertEquals($key, $token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $token = new QueryExpression\Token\SortToken('key', QueryExpression\Token\SortToken::SORT_ASC);

        $this->assertEquals($token->getType(), QueryExpression\Token\Token::SORT);
    }

    public function test_that_value_is_set()
    {
        $value = QueryExpression\Token\SortToken::SORT_ASC;

        $token = new QueryExpression\Token\SortToken('key', $value);

        $this->assertEquals($value, $token->getValue());
    }

    /**
     *  @dataProvider data_for_test_that_value_is_always_converted_to_correct_sort_type
     */
    public function test_that_value_is_always_converted_to_correct_sort_type($value, $expected)
    {
        $token = new QueryExpression\Token\SortToken('key', $value);

        $this->assertInternalType('string', $token->getValue());
        $this->assertSame($expected, $token->getValue());
    }

    public function data_for_test_that_value_is_always_converted_to_correct_sort_type()
    {
        return [
            ['ASC', QueryExpression\Token\SortToken::SORT_ASC],
            ['asc', QueryExpression\Token\SortToken::SORT_ASC],
            [' ASC ', QueryExpression\Token\SortToken::SORT_ASC],
            [' asc ', QueryExpression\Token\SortToken::SORT_ASC],
            ['DESC', QueryExpression\Token\SortToken::SORT_DESC],
            ['desc', QueryExpression\Token\SortToken::SORT_DESC],
            [' DESC ', QueryExpression\Token\SortToken::SORT_DESC],
            [' desc ', QueryExpression\Token\SortToken::SORT_DESC],
        ];
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider data_for_test_that_invalid_value_throws_exception
     */
    public function test_that_invalid_value_throws_exception($value)
    {
        new QueryExpression\Token\SortToken('key', $value);
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
            ['ascending'],
            ['descending'],
            ['highest'],
            ['lowest'],
        ];
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\SortToken::fromString('key;sort=asc');

        $this->assertInstanceOf(QueryExpression\Token\SortToken::class, $token);
    }
}
