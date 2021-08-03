<?php

use PHPUnit\Framework\TestCase;
use TomLutzenberger\CarSyncSsml\SsmlConstants;
use TomLutzenberger\CarSyncSsml\TagHelper;


class TagHelperTest extends TestCase
{

    public function testRegularTag() : void
    {
        $actual = TagHelper::tag('say-as', '12345', ['interpret-as'=>SsmlConstants::SAY_AS_TYPE_CARDINAL]);
        $expected = '<say-as interpret-as="cardinal">12345</say-as>';

        self::assertIsString($actual);
        self::assertEquals($expected, $actual);
    }

    public function testSelfClosingTag() : void
    {
        $actual = TagHelper::tag('break', '', ['time'=>'200ms']);
        $expected = '<break time="200ms" />';

        self::assertIsString($actual);
        self::assertEquals($expected, $actual);
    }
}
