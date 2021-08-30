<?php

namespace Suber;

use iterable;
use Iterator;

class SubtitleCollection implements Iterator
{
    private array $collection = [];
    private int $counter = 0;

    public function add($subtitle) : void
    {
        if(is_array($subtitle)) {
            $counter = $subtitle['counter'] ?? ++$this->counter;
            $from = $subtitle['from'];
            $to = $subtitle['to'];
            $text = $subtitle['text'];
            $subtitle = new Subtitle($counter, $from, $to, $counter);
        }
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
        
    }

    public function next()
    {
        
    }

    public function rewind()
    {
        
    }

    public function key()
    {
        
    }

    public function valid()
    {
        
    }
}
