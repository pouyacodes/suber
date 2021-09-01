<?php

namespace Suber;

use Iterator;

class SubtitleCollection implements Iterator
{
    private array $collection = [];
    private int $position = 0;

    public function __construct()
    {
        $this->position = 0;
    }

    public function add(Subtitle $subtitle) : void
    {
        $this->collection []= $subtitle;
    }

    public function remove(Subtitle $subtitle) : void
    {
        $index = array_search($subtitle, $this->collection);
        if($index)
            unset($this->collection[$index]);
    }

    public function current()
    {
        return $this->collection[$this->position];
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return isset($this->collection[$this->position]);
    }
}
