<?php

namespace Parser;

class TagsParser implements TagParserInterface, MetaTagsParserInterface
{
    const META_PATTERN = '/\<meta.*"(?P<prop>.*)".*"(?P<value>.*)"[^>]*>/';
    const TAG_PATTERN = '/<%s[^>]*>(?P<value>.*)<\/%s>/';

    public function getMetaContent(string $body): array
    {
        preg_match_all(self::META_PATTERN, $body, $matches);

        return array_combine($matches['prop'], $matches['value']);
    }

    public function getTagContent(string $tag, string $body): array
    {
        preg_match_all(sprintf(self::TAG_PATTERN, $tag, $tag), $body, $matches);

        return $matches['value'];
    }
}