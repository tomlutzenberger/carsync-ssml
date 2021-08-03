<?php

namespace TomLutzenberger\CarSyncSsml;

interface SsmlConstants
{

    public const TYPE_PLAIN = 'plain';
    public const TYPE_SSML = 'ssml';

    public const TAG_SPEAK = 'speak';
    public const TAG_BREAK = 'break';
    public const TAG_SAY_AS = 'say-as';
    public const TAG_AUDIO = 'audio';
    public const TAG_PARAGRAPH = 'p';
    public const TAG_SENTENCE = 's';
    public const TAG_SUB = 'sub';
    public const TAG_PROSODY = 'prosody';
    public const TAG_EMPHASIS = 'emphasis';

    public const TAGS = [
        self::TAG_SPEAK,
        self::TAG_BREAK,
        self::TAG_SAY_AS,
        self::TAG_AUDIO,
        self::TAG_PARAGRAPH,
        self::TAG_SENTENCE,
        self::TAG_SUB,
        self::TAG_PROSODY,
        self::TAG_EMPHASIS,
    ];

    // No pause should be outputted. This can be used to remove a pause that would normally occur (such as after a period).
    public const BREAK_STRENGTH_NONE = 'none';

    // No pause should be outputted (same as none).
    public const BREAK_STRENGTH_X_WEAK = 'x-weak';

    // Treat adjacent words as if separated by a single comma (equivalent to medium).
    public const BREAK_STRENGTH_WEAK = 'weak';

    // Treat adjacent words as if separated by a single comma.
    public const BREAK_STRENGTH_MEDIUM = 'medium';

    // Make a sentence break (equivalent to using the s tag).
    public const BREAK_STRENGTH_STRONG = 'strong';

    // Make a paragraph break (equivalent to using the p tag).
    public const BREAK_STRENGTH_X_STRONG = 'x-strong';

    public const BREAK_STRENGTHS = [
        self::BREAK_STRENGTH_NONE,
        self::BREAK_STRENGTH_X_WEAK,
        self::BREAK_STRENGTH_WEAK,
        self::BREAK_STRENGTH_MEDIUM,
        self::BREAK_STRENGTH_STRONG,
        self::BREAK_STRENGTH_X_STRONG,
    ];

    public const SAY_AS_TYPE_CARDINAL = 'cardinal';
    public const SAY_AS_TYPE_ORDINAL = 'ordinal';
    public const SAY_AS_TYPE_CHARACTERS = 'characters';
    public const SAY_AS_TYPE_DIGITS = 'digits';
    public const SAY_AS_TYPE_FRACTION = 'fraction';
    public const SAY_AS_TYPE_EXPLETIVE = 'expletive';
    public const SAY_AS_TYPE_BLEEP = 'bleep';
    public const SAY_AS_TYPE_UNIT = 'unit';
    public const SAY_AS_TYPE_VERBATIM = 'verbatim';
    public const SAY_AS_TYPE_SPELL_OUT = 'spell-out';
    public const SAY_AS_TYPE_DATE = 'date';
    public const SAY_AS_TYPE_TIME = 'time';

    public const SAY_AS_TYPES = [
        self::SAY_AS_TYPE_CARDINAL,
        self::SAY_AS_TYPE_ORDINAL,
        self::SAY_AS_TYPE_CHARACTERS,
        self::SAY_AS_TYPE_DIGITS,
        self::SAY_AS_TYPE_FRACTION,
        self::SAY_AS_TYPE_EXPLETIVE,
        self::SAY_AS_TYPE_BLEEP,
        self::SAY_AS_TYPE_UNIT,
        self::SAY_AS_TYPE_VERBATIM,
        self::SAY_AS_TYPE_SPELL_OUT,
        self::SAY_AS_TYPE_DATE,
        self::SAY_AS_TYPE_TIME,
    ];
}
