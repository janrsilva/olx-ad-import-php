<?php

namespace Janrsilva\OlxAdImport;

use IteratorAggregate;

class PublishedAdCollection implements IteratorAggregate
{
    use AdsIteratorTrait;

    private $ads;

    public function __construct(PublishedAd ...$ads)
    {
        $this->ads = $ads;
    }
}
