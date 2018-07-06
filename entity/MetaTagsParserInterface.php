<?php

namespace Parser;


interface MetaTagsParserInterface
{
    public function getMetaContent(string $body): array;
}