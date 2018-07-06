<?php

namespace Tests;


use Parser\TagsParser;
use PHPUnit\Framework\TestCase;

class TagsParserTest extends TestCase
{
    public function test_get_meta_content()
    {
        $parser = new TagsParser;
        $meta = '<meta http-equiv="Content-Type" content="text/html" />';

        $this->assertSame("text/html", $parser->getMetaContent($meta)['Content-Type']);
    }

    public function test_get_tag_content()
    {
        $parser = new TagsParser;
        $tag = '<p>Content-Type</p>';

        $this->assertSame("Content-Type", $parser->getTagContent('p', $tag)[0]);
    }
}