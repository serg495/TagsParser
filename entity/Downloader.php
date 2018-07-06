<?php

namespace Parser;


use Generator;
use GuzzleHttp\ClientInterface;

class Downloader implements DownloaderInterface
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function download(array $urls): Generator
    {
        foreach ($urls as $url) {
            $response = $this->client->request('get', $url);

            yield $response->getBody();
        }

    }
}