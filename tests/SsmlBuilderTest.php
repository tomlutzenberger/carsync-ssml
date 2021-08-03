<?php

use PHPUnit\Framework\TestCase;
use TomLutzenberger\CarSyncSsml\SsmlBuilder;
use TomLutzenberger\CarSyncSsml\SsmlConstants;


class SsmlBuilderTest extends TestCase
{

    /** @var \TomLutzenberger\CarSyncSsml\SsmlBuilder */
    private SsmlBuilder $builder;


    /**
     * @throws \ErrorException
     */
    public function testBuilder() : void
    {
        $this->builder
            ->say('Here are {0} samples.', [
                $this->builder->sayAs('SSML', SsmlConstants::SAY_AS_TYPE_CHARACTERS),
            ])
            ->say('I can pause {0}.', [
                $this->builder->pauseTime(3),
            ])
            ->say('I can play a sound {0}.', [
                $this->builder->audio('your wave file', 'https://www.example.com/MY_WAVE_FILE.wav'),
            ])
            ->say('I can speak in cardinals. Your position is {0} in line.', [
                $this->builder->sayAs('10', SsmlConstants::SAY_AS_TYPE_CARDINAL),
            ])
            ->say('Or I can speak in ordinals.')
            ->say('You are {0} in line.', [
                $this->builder->sayAs('10', SsmlConstants::SAY_AS_TYPE_ORDINAL),
            ])
            ->say('Or I can even speak in digits.')
            ->say('Your position in line is {0}.', [
                $this->builder->sayAs('10', SsmlConstants::SAY_AS_TYPE_DIGITS),
            ])
            ->say('I can also substitute phrases, like the {0}.', [
                $this->builder->sub('W3C', 'World Wide Web Consortium'),
            ])
            ->say('Finally, I can speak a paragraph with two sentences.')
            ->paragraph('{0}{1}', [
                $this->builder->sentence('This is sentence one.'),
                $this->builder->sentence('This is sentence two.'),
            ]);

        $actual = $this->builder->render();
        $expected = '<speak>'
            . 'Here are <say-as interpret-as="characters">SSML</say-as> samples. I can pause <break time="3s" />. '
            . 'I can play a sound <audio src="https://www.example.com/MY_WAVE_FILE.wav">your wave file</audio>. '
            . 'I can speak in cardinals. Your position is <say-as interpret-as="cardinal">10</say-as> in line. '
            . 'Or I can speak in ordinals. You are <say-as interpret-as="ordinal">10</say-as> in line. '
            . 'Or I can even speak in digits. Your position in line is <say-as interpret-as="digits">10</say-as>. '
            . 'I can also substitute phrases, like the <sub alias="World Wide Web Consortium">W3C</sub>. '
            . 'Finally, I can speak a paragraph with two sentences. '
            . '<p><s>This is sentence one.</s><s>This is sentence two.</s></p>'
            . '</speak>';

        self::assertIsString($actual);
        self::assertEquals($expected, $actual);
    }


    protected function setUp() : void
    {
        $this->builder = new SsmlBuilder();
    }


}
