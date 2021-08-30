<?php

namespace Suber\Parsers;

use Suber\Parsers\ISubtitleType;
use Suber\SubtitleCollection;

class SrtParser implements ISubtitleType
{
    public function parse(string $text) : SubtitleCollection
    {
        return new SubtitleCollection;
    }

    public function dump(SubtitleCollection $collection) : string
    {
        return '';
    }
}
