<?php

namespace App\EntityMapper;

use App\Entity\Property as PropertyEntity;

class Property
{
    const COL_POSTCODE = 3;
    const COL_PROPERTY_TYPE = 4;
    const COL_HOUSE_NUMBER_NAME = 7;
    const COL_UNIT_NAME = 8;
    const COL_STREET = 9;
    const COL_LOCALITY = 10;
    const COL_CITY = 11;
    const COL_DISTRICT = 12;
    const COL_COUNTY = 12;

    public function map(PropertyEntity $property, array $data) : PropertyEntity
    {
        $id = md5(trim($data[self::COL_POSTCODE]) . "-" . trim($data[self::COL_HOUSE_NUMBER_NAME]) . "-" . trim($data[self::COL_UNIT_NAME]));

        $property->setId($id);
        $property->setPostcode(trim($data[self::COL_POSTCODE]));
        $property->setPostcodeSearch(str_replace(" ", "", $data[self::COL_POSTCODE]));
        $property->setPropertyType(trim($data[self::COL_PROPERTY_TYPE]));
        $property->setHouseNumberOrName(trim($data[self::COL_HOUSE_NUMBER_NAME]));
        $property->setUnitName(trim($data[self::COL_UNIT_NAME]));
        $property->setStreet(trim($data[self::COL_STREET]));
        $property->setLocality(trim($data[self::COL_LOCALITY]));
        $property->setCity(trim($data[self::COL_CITY]));
        $property->setDistrict(trim($data[self::COL_LOCALITY]));
        $property->setCounty(trim($data[self::COL_COUNTY]));

        return $property;
    }
}