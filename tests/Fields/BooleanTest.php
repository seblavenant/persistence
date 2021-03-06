<?php

namespace Spear\Silex\Persistence\Fields;

use Spear\Silex\Persistence\Field;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider providerTestConvertNoRights
     */
    public function testConvertNoRights($value, $expected)
    {
        $field = new Boolean();

        $convertedValue = $field->convert($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function providerTestConvertNoRights()
    {
        return array(
            'null' => array(null, null),
            'true' => array(true, true),
            'false' => array(false, false)
        );
    }

    /**
     * @dataProvider providerTestConvertAllowString
     */
    public function testConvertAllowString($value, $expected)
    {
        $field = (new Boolean())->allowStringValues();

        $convertedValue = $field->convert($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function providerTestConvertAllowString()
    {
        return array(
            'true' => array(true, true),
            'false' => array(false, false),
            '"0"' => array('0', false),
            '"1"' => array('1', true),
        );
    }

    /**
     * @dataProvider providerTestConvertAllowInteger
     */
    public function testConvertAllowInteger($value, $expected)
    {
        $field = (new Boolean())->allowIntegerValues();

        $convertedValue = $field->convert($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function providerTestConvertAllowInteger()
    {
        return array(
            'true' => array(true, true),
            'false' => array(false, false),
            '0' => array(0, false),
            '1' => array(1, true),
        );
    }

    /**
     * @dataProvider providerTestConvertFullRights
     */
    public function testConvertFullRights($value, $expected)
    {
        $field = (new Boolean())->allowIntegerValues()->allowStringValues();

        $convertedValue = $field->convert($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function providerTestConvertFullRights()
    {
        return array(
            'true' => array(true, true),
            'false' => array(false, false),
            '0' => array(0, false),
            '1' => array(1, true),
            '"0"' => array('0', false),
            '"1"' => array('1', true),
        );
    }

    /**
     * @dataProvider providerTestConvertWithExceptions
     * @expectedException \Spear\Silex\Persistence\Exceptions\InvalidDataException
     */
    public function testConvertWithExceptions(Field $field, $value)
    {
        $field->convert($value);
    }

    public function providerTestConvertWithExceptions()
    {
        $noRightsBoolean = new Boolean();
        $fullRightsBoolean = (new Boolean())->allowIntegerValues()->allowStringValues();
        $allowStringBoolean = (new Boolean())->allowStringValues();
        $allowIntegerBoolean = (new Boolean())->allowIntegerValues();

        return array(
            'Boolean full rights - "true"' => array($fullRightsBoolean, "true"),
            'Boolean full rights - "false"' => array($fullRightsBoolean, "false"),
            'Boolean allowStringValues - 0' => array($allowStringBoolean, 0),
            'Boolean allowStringValues - 1' => array($allowStringBoolean, 1),
            'Boolean allowIntegerValues - "0"' => array($allowIntegerBoolean, "0"),
            'Boolean allowIntegerValues - "1"' => array($allowIntegerBoolean, "1"),
            'Boolean no rights - 0' => array($noRightsBoolean, 0),
            'Boolean no rights - 1' => array($noRightsBoolean, 1),
            'Boolean no rights - "0"' => array($noRightsBoolean, "0"),
            'Boolean no rights - "1"' => array($noRightsBoolean, "1"),
            'Boolean allowStringValues - "true"' => array($allowStringBoolean, "true"),
            'Boolean allowStringValues - "false"' => array($allowStringBoolean, "false"),
            'Boolean allowIntegerValues - "true"' => array($allowIntegerBoolean, "true"),
            'Boolean allowIntegerValues - "false"' => array($allowIntegerBoolean, "false"),
            'Boolean no rights - "true"' => array($noRightsBoolean, "true"),
            'Boolean no rights - "false"' => array($noRightsBoolean, "false"),
            'Boolean full rights - array(true)' => array($noRightsBoolean, [true]),
            'Boolean full rights - "testString"' => array($noRightsBoolean, "testString"),
        );
    }
}
