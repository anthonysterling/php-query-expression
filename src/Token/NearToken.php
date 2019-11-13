<?php

namespace AnthonySterling\QueryExpression\Token;

use InvalidArgumentException;

class NearToken extends AbstractToken
{
    const UNIT_KM = 'km';
    const UNIT_M = 'm';

    protected $key = null;
    protected $latitude = null;
    protected $longitude = null;
    protected $distance = null;
    protected $unit = null;

    public function __construct($key, $latitude, $longitude, $distance, $unit = self::UNIT_KM)
    {
        $this->key = $key;
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
        $this->setDistance($distance);
        $this->setUnit($unit);
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getType()
    {
        return Token::NEAR;
    }

    public function getValue()
    {
        return sprintf(
            '%s,%s,%s,%s',
            $this->getLatitude(),
            $this->getLongitude(),
            $this->getDistance(),
            $this->getUnit()
        );
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    protected function setLatitude($latitude)
    {
        if (!is_numeric($latitude)) {
            throw new InvalidArgumentException('The $latitude must be numeric');
        }

        $latitude += 0;

        if (-90 > $latitude || $latitude > 90) {
            throw new InvalidArgumentException('$latitude must be between -90 and 90');
        }

        $this->latitude = $latitude;
    }

    protected function setLongitude($longitude)
    {
        if (!is_numeric($longitude)) {
            throw new InvalidArgumentException('The $longitude must be numeric');
        }

        $longitude += 0;

        if (-180 > $longitude || $longitude > 180) {
            throw new InvalidArgumentException('$longitude must be between -180 and 180');
        }

        $this->longitude = $longitude;
    }

    protected function setDistance($distance)
    {
        $this->distance = floatval($distance);
    }

    protected function setUnit($unit)
    {
        if (self::UNIT_KM !== $unit && self::UNIT_M !== $unit) {
            throw new InvalidArgumentException('The $unit must be either NearToken:UNIT_KM or NearToken:UNIT_M');
        }

        $this->unit = $unit;
    }

    public static function fromString($string)
    {
        $arguments = self::fromStringToArguments($string);

        $arguments['value'] = explode(',', $arguments['value']);

        if (3 !== count($arguments['value']) && 4 !== count($arguments['value'])) {
            throw new InvalidArgumentException(sprintf(
                'Token (NearToken) expects value to contain 3 or 4 arguments'
            ));
        }

        if (3 === count($arguments['value'])) {
            $arguments['value'][3] = self::UNIT_KM;
        }

        return new static(
            $arguments['key'],
            $arguments['value'][0],
            $arguments['value'][1],
            $arguments['value'][2],
            $arguments['value'][3]
        );
    }
}
