<?php

namespace Janrsilva\OlxAdImport;

class AdCollection
{
    use AdsIteratorTrait;

    private $ads;

    public function __construct(Ad ...$ads)
    {
        $this->ads = $ads;
    }
}