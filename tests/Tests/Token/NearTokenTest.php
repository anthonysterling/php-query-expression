<?php

namespace AnthonySterling\QueryExpression\Tests\Token;

use AnthonySterling\QueryExpression;
use PHPUnit_Framework_TestCase;

class NearTokenTest extends PHPUnit_Framework_TestCase
{
    protected $token;

    protected $key = 'foo';
    protected $latitude = 54.9740;
    protected $longitude = -1.6132;
    protected $distance = 10;

    protected function setUp()
    {
        $this->token = new QueryExpression\Token\NearToken(
            $this->key,
            $this->latitude,
            $this->longitude,
            $this->distance
        );
    }

    public function test_that_key_is_set()
    {
        $this->assertEquals($this->key, $this->token->getKey());
    }

    public function test_that_type_is_correct()
    {
        $this->assertEquals(QueryExpression\Token\Token::NEAR, $this->token->getType());
    }

    public function test_that_latitude_is_set()
    {
        $this->assertEquals($this->latitude, $this->token->getLatitude());
    }

    public function test_that_longitude_is_set()
    {
        $this->assertEquals($this->longitude, $this->token->getLongitude());
    }

    /**
     * @expectedException InvalidArgumentException
     * @dataProvider data_for_test_that_invalid_latitude_throws_exception
     */
    public function test_that_invalid_latitude_throws_exception($latitude)
    {
        new QueryExpression\Token\NearToken($this->key, $latitude, $this->longitude, $this->distance);
    }

    public function data_for_test_that_invalid_latitude_throws_exception()
    {
        return [
            [-360],
            [-270],
            [-180],
            [-135],
            [-91],
            [-90.1],
            [90.1],
            [91],
            [135],
            [180],
            [270],
            [360],
            [null],
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
     * @expectedException InvalidArgumentException
     * @dataProvider data_for_test_that_invalid_longitude_throws_exception
     */
    public function test_that_invalid_longitude_throws_exception($longitude)
    {
        new QueryExpression\Token\NearToken($this->key, $this->latitude, $longitude, $this->distance);
    }

    public function data_for_test_that_invalid_longitude_throws_exception()
    {
        return [
            [-360],
            [-270],
            [-181],
            [-180.1],
            [181],
            [180.1],
            [270],
            [360],
            [null],
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
     * @expectedException InvalidArgumentException
     */
    public function test_that_invalid_unit_throws_exception()
    {
        new QueryExpression\Token\NearToken($this->key, $this->latitude, $this->longitude, $this->distance, 'invalid.unit');
    }

    public function test_that_token_can_be_created_from_string()
    {
        $token = QueryExpression\Token\NearToken::fromString('key;near=54.9741,-1.6132,10,m');
        $this->assertInstanceOf(QueryExpression\Token\NearToken::class, $token);
        $this->assertSame('key;near=54.9741,-1.6132,10,m', (string) $token);

        $token = QueryExpression\Token\NearToken::fromString('key;near=54.9741,-1.6132,10');
        $this->assertInstanceOf(QueryExpression\Token\NearToken::class, $token);
        $this->assertSame('key;near=54.9741,-1.6132,10,km', (string) $token);
    }
}
