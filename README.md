# Suber
Working with subtitles in php

# Installation
1. First of all you must install [Composer](https://getcomposer.org/).
2. Then run `composer require pouyacodes/suber`

# Usage
Here are a simple usage of this package:
```PHP
<?php

require_once 'vendor/autoload.php'; // Put Composer autoloader here, this can be different on your system.
$content = file_get_contents("sample.srt"); // Read subtitle file's content to parse.
$parser = new SrtParser; // Instantiate of SrtParser
$subtitles = $parser->parse($content); // Pass content to parse.

foreach($subtitles as $subtitle) { // loop through it. In this example all subtitles will delay 0.5 seconds (500 milliseconds).
    $subtitle->setFrom( $subtitle->getFrom() + 0.5 );
    $subtitle->setTo( $subtitle->getTo() + 0.5 );
}

$content = $parser->dump($subtitles); // Pass subtitle collection to get dump raw contents.
file_put_contents("sample.fixed.srt", $content); // Save raw contents to file.


?>
```
