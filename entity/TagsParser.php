<?php

namespace Parser;

use Generator;
use GuzzleHttp\Client;

class TagsParser
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    protected $parsedMetaContent = [];
    /**
     * @var array
     */
    protected $parsedTagContent = [];
    /**
     * @var array
     */
    protected $urls;
    /**
     * @var string
     */
    protected $pattern;

    public function __construct(array $urls)
    {
        foreach ($urls as $url) {
            $this->urls[] = [
                'name' => ucfirst($this->getUrlName($url)),
                'url' => $url
            ];
        }

        $this->client = new Client;
    }

    protected function getUrlName(string $url): string
    {
        $urlHost = parse_url($url, PHP_URL_HOST);
        $pos = strpos($urlHost, '.');
        $name = substr($urlHost, 0, $pos);

        return $name;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }

    protected function generateUrls(): Generator
    {
        foreach ($this->urls as $url) {
            yield $url;
        }
    }

    public function addUrl(string $url): void
    {
        $this->urls[] = [
            'name' => $this->getUrlName($url),
            'url' => $url
        ];
    }

    public function getMetaContent(): array
    {
        $this->pattern = '/\<meta.*"(?P<prop>.*)".*"(?P<value>.*)"[^>]*>/';

        foreach ($this->generateUrls() as $url) {
            preg_match_all($this->pattern, $this->getContent($url['url']), $matches);
            $meta = array_combine($matches['prop'], $matches['value']);
            $this->parsedMetaContent[$url['name']] = $meta;
        }

        return $this->parsedMetaContent;
    }

    public function getTagContent(string $tag): array
    {
        $this->pattern = $tagPattern = "/<${tag}[^>]*>(?P<value>.*)<\/${tag}>/";

        foreach ($this->generateUrls() as $url) {
            preg_match_all($this->pattern, $this->getContent($url['url']), $matches);
            $tag = $matches['value'];
            $this->parsedTagContent[$url['name']] = $tag;
        }

        return $this->parsedTagContent;
    }

    protected function getContent(string $url): string
    {
        $response = $this->client->get($url);
        $content = $response->getBody();

        return $content;
    }
}