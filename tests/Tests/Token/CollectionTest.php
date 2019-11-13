<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression\Token;
use AnthonySterling\QueryExpression\Token\Collection;
use PHPUnit_Framework_TestCase;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    public function test_that_collection_filters_non_tokens_on_construct()
    {
        $collection = new Collection([
            new Token\InToken('colour', ['red', 'amber', 'green']),
            false,
            new Token\IsEmptyToken('deleted', true),
        ]);

        $this->assertEquals(2, count($collection));
    }

    public function test_that_collection_filters_by_key()
    {
        $collection = new Collection([
            new Token\ContainsToken('bar', 'value'),
            new Token\InToken('foo', ['value']),
            new Token\ContainsToken('bar', 'value'),
        ]);

        $this->assertEquals(3, count($collection));
        $this->assertEquals(1, count($collection->filterByKey('foo')));
        $this->assertEquals(2, count($collection->filterByKey('bar')));
    }

    public function test_that_collection_filters_by_type()
    {
        $collection = new Collection([
            new Token\ContainsToken('key', 'value'),
            new Token\InToken('key', ['value']),
            new Token\ContainsToken('key', 'value'),
        ]);

        $this->assertEquals(3, count($collection));
        $this->assertEquals(1, count($collection->filterByType(Token\Token::IN)));
        $this->assertEquals(2, count($collection->filterByType(Token\Token::CONTAINS)));
    }

    public function test_that_collection_filters_by_unique()
    {
        $collection = new Collection([
            new Token\ContainsToken('key', 'value'),
            new Token\InToken('key', ['value']),
            new Token\BetweenToken('key', 1, 3),
            new Token\ContainsToken('key', 'value'),
        ]);

        $this->assertEquals(4, count($collection));
        $this->assertEquals(3, count($collection->filterByUnique()));
    }

    public function test_that_collection_can_implode()
    {
        $collection = new Collection([
            new Token\ContainsToken('fizz', 'value'),
            new Token\InToken('key', ['foo', 'bar']),
            new Token\BetweenToken('d', 1, 3),
            new Token\ContainsToken('buzz', 'value'),
        ]);

        $string = 'fizz;contains=value&key;in=foo,bar&d;between=1,3&buzz;contains=value';

        $this->assertEquals($string, $collection->implode());
        $this->assertEquals($string, (string) $collection);
    }

    public function test_that_collection_can_be_sorted_by_key()
    {
        $collection = new Collection([
            new Token\ContainsToken('c', 3),
            new Token\BetweenToken('d', 1, 3),
            new Token\InToken('a', ['foo', 'bar']),
            new Token\ContainsToken('b', 2),
        ]);

        $sorted = new Collection([
            new Token\InToken('a', ['foo', 'bar']),
            new Token\ContainsToken('b', 2),
            new Token\ContainsToken('c', 3),
            new Token\BetweenToken('d', 1, 3),
        ]);

        $collection->sort(function ($left, $right) {
            return strcmp($left->getKey(), $right->getKey());
        });

        $this->assertEquals((string) $sorted, (string) $collection);
    }

    public function test_that_collection_can_be_sorted_by_value()
    {
        $collection = new Collection([
            new Token\ContainsToken('c', 3),
            new Token\InToken('a', ['foo', 'bar']),
            new Token\ContainsToken('b', 2),
        ]);

        $sorted = new Collection([
            new Token\InToken('a', ['foo', 'bar']),
            new Token\ContainsToken('b', 2),
            new Token\ContainsToken('c', 3),
        ]);

        $collection->sort(function ($left, $right) {
            return strcmp($left->getKey(), $right->getKey());
        });

        $this->assertEquals((string) $sorted, (string) $collection);
    }

    public function test_that_collection_can_be_merged_into_another()
    {
        $collection = new Collection([
            new Token\InToken('a', ['foo', 'bar']),
            new Token\ContainsToken('b', 2),
            new Token\ContainsToken('c', 3),
        ]);

        $merged = $collection->merge(new Collection([
            new Token\BetweenToken('d', 1, 3),
        ]));

        $this->assertEquals(4, count($merged));
    }
}
