<?php

namespace Parser;

use Generator;

interface DownloaderInterface
{
    public function download(array $urls): Generator;
}