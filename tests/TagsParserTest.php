<?php

namespace Tests;


use Mockery;
use Parser\TagsParser;
use PHPUnit\Framework\TestCase;

class TagsParserTest extends TestCase
{
    public function test_url_name()
    {
        $url = 'http://php.net';
        $parser = new TagsParser([$url]);

        $mock = Mockery::mock($parser)->makePartial()->shouldAllowMockingProtectedMethods();
        $name = $mock->getUrlName($url);

        $this->assertSame('php', $name);
    }

    public function test_add_url()
    {
        $url = 'http://php.net';
        $parser = new TagsParser([$url]);

        $this->assertCount(1, $parser->getUrls());

        $parser->addUrl($url);

        $this->assertCount(2, $parser->getUrls());

    }

    public function test_get_meta_content()
    {
        $url = 'https://itproger.com/';
        $parser = new TagsParser([$url]);

        $this->assertGreaterThan(1, count($parser->getMetaContent()['Itproger']));
    }

    public function test_get_tag_content()
    {
        $url = 'http://php.net';
        $parser = new TagsParser([$url]);

        $this->assertGreaterThan(1, count($parser->getTagContent('p')['Php']));
    }
}