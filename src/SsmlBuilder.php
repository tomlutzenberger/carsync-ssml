<?php

namespace TomLutzenberger\CarSyncSsml;


use ErrorException;

/**
 * Class SsmlBuilder
 *
 *
 * @package   \TomLutzenberger\CarSyncSsml
 * @copyright 2021 Tom Lutzenberger
 * @author    Tom Lutzenberger <lutzenbergerthomas@gmail.com>
 *
 * Only tags that are common for Amazon Alexa AND Google Assistant are supported, which are:
 *
 * <speak>
 * <break>
 * <say-as>
 * <audio>
 * <p>
 * <s>
 * <sub>
 * <prosody>
 * <emphasis>
 */
class SsmlBuilder
{

    /** @var \TomLutzenberger\CarSyncSsml\Dialog[] */
    protected array $dialogs = [];


    public function say(string $text, array $segments = []) : SsmlBuilder
    {
        $renderedSegments = $this->getRenderedSegments($segments);
        $renderedText = $this->embedSegments($text, $renderedSegments);
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_PLAIN, '', trim($renderedText), []);

        return $this;
    }


    /**
     * @throws \ErrorException
     */
    public function sayAs(string $text, string $type, array $additionalAttributes = []) : SsmlBuilder
    {
        if (!in_array($type, SsmlConstants::SAY_AS_TYPES)) {
            throw new ErrorException('Invalid say-as type supplied: ' . $type);
        }

        $attributes = array_merge(['interpret-as' => $type], $additionalAttributes);
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_SAY_AS, $text, $attributes);
        return $this;
    }


    /**
     */
    public function paragraph(string $text, array $sentences = []) : SsmlBuilder
    {
        $renderedSegments = $this->getRenderedSegments($sentences);
        $renderedText = $this->embedSegments($text, $renderedSegments);

        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_PARAGRAPH, $renderedText, []);
        return $this;
    }


    public function sentence(string $text) : SsmlBuilder
    {
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_SENTENCE, $text, []);

        return $this;
    }


    public function pauseTime(int $length, string $unit = 's') : SsmlBuilder
    {
        $time = $length . trim($unit);
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_BREAK, '', ['time' => $time]);

        return $this;
    }


    /**
     * @throws \ErrorException
     */
    public function pauseStrength(string $strength = SsmlConstants::BREAK_STRENGTH_MEDIUM) : SsmlBuilder
    {
        if (!in_array($strength, SsmlConstants::BREAK_STRENGTHS)) {
            throw new ErrorException('Invalid break strength supplied');
        }

        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_BREAK, '', ['strength' => $strength]);

        return $this;
    }


    public function audio(string $text, string $fileUri, array $additionalAttributes = []) : SsmlBuilder
    {
        $attributes = array_merge(['src' => $fileUri], $additionalAttributes);
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_AUDIO, $text, $attributes);

        return $this;
    }


    public function sub(string $text, string $alias) : SsmlBuilder
    {
        $this->dialogs[] = new Dialog(SsmlConstants::TYPE_SSML, SsmlConstants::TAG_SUB, $text, ['alias' => $alias]);

        return $this;
    }


    /**
     * Renders the whole dialog queue and wraps it with a "speak" tag
     *
     * @return string
     */
    public function render() : string
    {
        $dialogList = [];

        foreach ($this->dialogs as $dialog) {
            if ($dialog->getType() === SsmlConstants::TYPE_PLAIN) {
                $dialogList[] = $dialog->getContent();
            } else {
                $dialogList[] = TagHelper::tag($dialog->getTag(), $dialog->getContent(), $dialog->getAttributes());
            }
        }

        $renderedDialog = implode(' ', $dialogList);

        return TagHelper::tag('speak', trim($renderedDialog));
    }


    /**
     * Pre-renders a segment (= sub-element)
     *
     * @param Dialog $segment
     * @return string
     */
    protected function renderSegment(Dialog $segment) : string
    {
        return TagHelper::tag($segment->getTag(), $segment->getContent(), $segment->getAttributes());
    }


    /**
     * Embeds a segment into a given text at the desired position.
     * This works via string replacement based on the array index of the segment.
     * The position has to be marked with the index wrapped in curly braces, e.g. "{0}"
     *
     * @param string $text
     * @param array  $segments
     * @return string[]
     */
    protected function embedSegments(string $text, array $segments)
    {
        $renderedText = $text;

        if (!empty($segments)) {
            foreach ($segments as $index => $segment) {
                $needle = '{' . $index . '}';
                $renderedText = str_replace($needle, $segment, $renderedText);
            }
        }

        return $renderedText;
    }


    /**
     * Extracts, renders and returns the rendered segments
     *
     * @param array $segments
     * @return array
     */
    protected function getRenderedSegments(array $segments) : array
    {
        $renderedSegments = [];

        if (!empty($segments)) {
            $dialogIndex = array_key_last($this->dialogs) - count($segments) + 1;
            $extractedSegments = array_splice($this->dialogs, $dialogIndex, count($segments));

            foreach ($extractedSegments as $segment) {
                $renderedSegments[] = $this->renderSegment($segment);
            }
            end($this->dialogs);
        }

        return $renderedSegments;
    }
}
