<?php

namespace TomLutzenberger\CarSyncSsml;

class TagHelper
{

    protected static array $selfClosingTags = [
        'break',
        'mark',
    ];


    public static function tag(string $tag, string $content, array $attributes = []) : string
    {
        $renderedAttributes = '';

        if (!empty($attributes)) {
            // Make sure that attributes are always in the same order
            ksort($attributes);

            $attributeList = [];

            foreach ($attributes as $key => $value) {
                $attributeList[] = sprintf('%s="%s"', $key, $value);
            }

            $renderedAttributes = ' ' . implode(' ', $attributeList);
        }

        if (in_array($tag, static::$selfClosingTags, true)) {
            return sprintf('<%s%s />', $tag, $renderedAttributes);
        }

        return sprintf('<%s%s>%s</%s>', $tag, $renderedAttributes, trim($content), $tag);
    }

}
