<?php

namespace Suber;

use Exception;

class Subtitle
{
    private float $from = 0;
    private float $to = 0;
    private array $texts = [];

    public function __construct(float $from, float $to, array $texts)
    {
        $this->setFrom($from);
        $this->setTo($to);
        $this->setText($texts);
    }

    public function getFrom() : float
    {
        return $this->from;
    }

    public function setFrom(float $from) : void
    {
        if ($from < 0)
            throw new Exception('$from seconds must be grader or equals than 0');
        $this->from = $from;
    }

    public function getTo() : float
    {
        return $this->to;
    }

    public function setTo(float $to) : void
    {
        if ($to< 0)
            throw new Exception('$to seconds must be grader or equals than 0');
        $this->to = $to;
    }

    public function getText() : array
    {
        return $this->texts;
    }

    public function setText($texts): void
    {
        $texts = is_string($texts) ? [$texts] : $texts;
        
        foreach($texts as $text) {
            if(is_string($text))
                $this->texts []= $text;
        }
    }
}
