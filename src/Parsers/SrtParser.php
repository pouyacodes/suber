<?php

namespace Suber\Parsers;

use Generator;
use Suber\Parsers\ISubtitleType;
use Suber\Subtitle;
use Suber\SubtitleCollection;

class SrtParser implements ISubtitleType
{
    public function __construct()
    {
        date_default_timezone_set('UTC');
    }

    public function parse(string $text) : SubtitleCollection
    {
        // -------- remove the utf-8 BOM ----
        $text = str_replace("\xEF\xBB\xBF", '', $text); 
        $lines = explode(PHP_EOL, $text);
        $collection = new SubtitleCollection;
        $currentSubtitle = null;
    
        foreach ($lines as $line) {

            if($line) {

                if(ctype_digit($line)) {
                    $currentSubtitle = new Subtitle(0, 0, []);
                    $collection->add($currentSubtitle);
                }
                else if(preg_match("/^(?<from>.+?) --> (?<to>.+?)$/", $line, $matches)) {
                    $currentSubtitle->setFrom( $this->toUnixTimestamp($matches['from']) );
                    $currentSubtitle->setTo( $this->toUnixTimestamp($matches['to']) );
                } else {
                    $currentSubtitle->setTexts($line);
                }

            }
            
        }

        return $collection;
    }

    public function dumpSingle($subtitle) : string
    {
        $result = '';
        if($subtitle instanceof Subtitle) {
            $text = implode(PHP_EOL, $subtitle->getTexts());
            $time = sprintf("%s --> %s", $this->toTimeRepersent($subtitle->getFrom()), $this->toTimeRepersent($subtitle->getTo()) );
            $result = $time . PHP_EOL . $text . PHP_EOL;
        }
        return $result;
    }

    public function dump($collection = []) : string
    {
        $subtitles = [];

        $counter = 1;
        foreach($collection as $subtitle) {

            $result = $this->dumpSingle($subtitle);
            if ($result) {
                $subtitles []= $counter . PHP_EOL . $result;
                $counter++;
            }
        }

        return trim(implode(PHP_EOL, $subtitles));
    }

    public function dumpGenerator($collection = []) : Generator
    {
        $counter = 1;
        foreach($collection as $subtitle) {

            $result = $this->dumpSingle($subtitle);
            if ($result) {
                yield $counter . PHP_EOL . $result;
                $counter++;
            }
        }
    }

    private function toUnixTimestamp(string $timeString) 
    {
        $timestamp = 0;
        $units = [60, 3600, 86400, 2678400];
        $timeChunks = explode(':', $timeString);
        $seconds = str_replace(',', '.', array_pop($timeChunks));
        $timeChunks = array_reverse($timeChunks);

        for ($i = 0; $i < count($timeChunks); $i++) { 
            $timestamp += $timeChunks[$i] * $units[$i];
        }

        $timestamp += $seconds;
        return $timestamp;
    }

    private function toTimeRepersent(float $time)
    {
        $timeString = '';
        $timeChunks = explode('.', $time);
        $timeString = count($timeChunks) == 2 ? date('H:i:s,', $timeChunks[0]) . ($timeChunks[1] * 10 ** (3 - strlen($timeChunks[1]))) : date('H:i:s', $timeChunks[0]);
        return $timeString;
    }
}
