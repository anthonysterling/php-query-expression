<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class FactoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->factory = QueryExpression\Token\Factory::create();
    }

    public function test_that_factory_can_be_created()
    {
        $factory = QueryExpression\Token\Factory::create();

        $this->assertInstanceOf('AnthonySterling\QueryExpression\Token\Factory', $factory);
    }

    /**
     *  @dataProvider data_for_test_that_factory_can_create_tokens_from_strings
     */
    public function test_that_factory_can_create_tokens_from_strings($string, $type)
    {
        $token = $this->factory->fromString($string);

        $this->assertInstanceOf(sprintf('AnthonySterling\QueryExpression\Token\%s', $type), $token);
    }

    public function data_for_test_that_factory_can_create_tokens_from_strings()
    {
        return [
            ['key;is=value', 'IsToken'],
            ['key;not=value', 'NotToken'],
            ['key;between=1,5', 'BetweenToken'],
            ['key;near=54.9740,-1.6132,10,km', 'NearToken'],
            ['key;in=1,2,3,4,5', 'InToken'],
            ['key;not-in=1,2,3,4,5', 'NotInToken'],
            ['key;less-than=5', 'LessThanToken'],
            ['key;more-than=5', 'MoreThanToken'],
            ['key;is-or-less-than=5', 'IsOrLessThanToken'],
            ['key;is-or-more-than=5', 'IsOrMoreThanToken'],
            ['key;contains=value', 'ContainsToken'],
            ['key;contains=va;lu=e', 'ContainsToken'],
            ['key;not-contains=value', 'NotContainsToken'],
            ['key;matches=[0-9]', 'MatchesToken'],
            ['key;not-matches=[0-9]', 'NotMatchesToken'],
            ['key;is-empty=true', 'IsEmptyToken'],
        ];
    }
}
