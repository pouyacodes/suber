<?php

namespace Suber\Parsers;

use Generator;
use Suber\Parsers\ISubtitleType;
use Suber\Subtitle;
use Suber\SubtitleCollection;

class SrtParser implements ISubtitleType
{

    public function parse(string $text): SubtitleCollection
    {
        // -------- remove the utf-8 BOM ----
        $text = str_replace("\xEF\xBB\xBF", '', $text);
        $lines = explode(PHP_EOL, $text);
        $collection = new SubtitleCollection;
        $currentSubtitle = null;

        foreach ($lines as $line) {

            if ($line) {

                if (ctype_digit($line)) {
                    $currentSubtitle = new Subtitle(0, 0, []);
                    $collection->add($currentSubtitle);
                } else if (preg_match("/^(?<from>.+?) --> (?<to>.+?)$/", $line, $matches)) {
                    $currentSubtitle && $currentSubtitle->setFrom($this->toUnixTimestamp($matches['from']));
                    $currentSubtitle && $currentSubtitle->setTo($this->toUnixTimestamp($matches['to']));
                } else {
                    $currentSubtitle && $currentSubtitle->setTexts($line);
                }
            }
        }

        return $collection;
    }

    public function dumpSingle($subtitle): string
    {
        $result = '';
        if ($subtitle instanceof Subtitle) {
            $text = implode(PHP_EOL, $subtitle->getTexts());
            $time = sprintf("%s --> %s", $this->toTimeRepersent($subtitle->getFrom()), $this->toTimeRepersent($subtitle->getTo()));
            $result = $time . PHP_EOL . $text . PHP_EOL;
        }
        return $result;
    }

    public function dump($collection = []): string
    {
        $subtitles = [];

        $counter = 1;
        foreach ($collection as $subtitle) {

            $result = $this->dumpSingle($subtitle);
            if ($result) {
                $subtitles[] = $counter . PHP_EOL . $result;
                $counter++;
            }
        }

        return trim(implode(PHP_EOL, $subtitles));
    }

    public function dumpGenerator($collection = []): Generator
    {
        $counter = 1;
        foreach ($collection as $subtitle) {

            $result = $this->dumpSingle($subtitle);
            if ($result) {
                yield $counter . PHP_EOL . $result;
                $counter++;
            }
        }
    }

    private function toUnixTimestamp(string $timeString)
    {
        $timeString = str_replace(",", ":", $timeString);
        $timestamp = 0;
        $timeChunks = explode(':', $timeString);
        $timestamp = mktime($timeChunks[0] ?? 0, $timeChunks[1] ?? 0, $timeChunks[2] ?? 0, 1, 1, 1970);
        $miliseconds = !empty($timeChunks[3]) ? $timeChunks[3] / 1000 : 0;
        $timestamp += $miliseconds;
        return $timestamp;
    }

    private function toTimeRepersent(float $time)
    {
        $timeString = '';
        $seconds = (int) $time;
        $miliseconds = $time - $seconds;
        $miliseconds = $miliseconds ? substr($miliseconds, 2) : 0;

        $timeUnits = [
            (int) ($seconds / 3600),
            (int) ($seconds % 3600 / 60),
            (int) ($seconds % 60)
        ];

        $timeUnits = array_map(function ($timeUnit) {
            if (strlen($timeUnit) == 1)
                return '0' . $timeUnit;
            return $timeUnit;
        }, $timeUnits);


        $timeString = implode(":", $timeUnits);

        if ($miliseconds)
            $timeString .= "," . $miliseconds * (10 ** (3 - strlen($miliseconds)));

        return $timeString;
    }
}
