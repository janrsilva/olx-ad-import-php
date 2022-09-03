<?php

namespace Janrsilva\OlxAdImport;

trait AdsIteratorTrait
{
    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->ads);
    }

    public function toArray()
    {
        return array_map(
            function ($ad) {
                return $ad->toArray();
            },
            $this->ads
        );
    }
}
