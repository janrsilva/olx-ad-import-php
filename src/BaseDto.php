<?php

namespace Janrsilva\OlxAdImport;

class BaseDto
{
    static public function fromArray(array $array)
    {
        $dto = new static();
        foreach ($array as $key => $value) {
            // if has property with same name
            if (property_exists($dto, $key)) {
                $dto->$key = $value;
            }
        }
        return $dto;
    }

    public function toArray()
    {
        $dto = json_decode(json_encode($this), true);
        $array = [];
        foreach ($dto as $key => $value) {
            if (isset($value)) {
                $array[$key] = $value;
            }
        }
        return $array;
    }
}