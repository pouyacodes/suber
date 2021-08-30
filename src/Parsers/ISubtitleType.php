<?php

namespace Suber\Parsers;

use Suber\SubtitleCollection;

interface ISubtitleType
{
    public function parse(string $text) : SubtitleCollection;
    public function dump(SubtitleCollection $collection) : string;
}