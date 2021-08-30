<?php

namespace Suber;

use Exception;
use Suber\Exceptions\NaturalNumberException;

class Subtitle
{
    private int $counter = 1;
    private int $from = 0;
    private int $to = 0;
    private string $text = "";

    public function __construct(int $fromTimestamp, int $toTimestamp, string $text, int $counter = 1)
    {
        $this->setCounter($counter);
        $this->setFrom($fromTimestamp);
        $this->setTo($toTimestamp);
        $this->setText($text);
    }

    public function getCounter() : int
    {
        return $this->counter;
    }

    public function setCounter(int $counter) : void
    {
        if($counter <= 0)
            throw new NaturalNumberException('$counter');
        $this->counter = $counter;
    }

    public function getFrom() : int
    {
        return $this->from;
    }

    public function setFrom(int $fromTimestamp) : void
    {
        if($fromTimestamp < 0)
            throw new NaturalNumberException('$fromTimestamp');
        $this->from = $fromTimestamp;
    }

    public function getTo() : int
    {
        return $this->to;
    }

    public function setTo(int $toTimestamp) : void
    {
        if($toTimestamp < 0)
            throw new NaturalNumberException('$toTimestamp');
        $this->to = $toTimestamp;
    }

    public function getText() : string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        if(empty($text))
            throw new Exception('$text must not be a empty text.');
        
        $this->text = trim($text);
    }

    public function __toString()
    {
        $formatedSubtitle = "";
        return $formatedSubtitle;
    }
    
}
