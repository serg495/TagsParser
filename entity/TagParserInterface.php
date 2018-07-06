<?php

namespace Parser;

use Generator;


interface TagParserInterface
{
    public function getTagContent(string $tag, string $body): array;
}