<?php

include 'mobydick_wo_chapters.php';

$matches = [];

preg_match_all('/[A-Z][^\.!\?]*[\.!\?]/', $mobydick, $matches);

$characters = [];
$words = [];

foreach( $matches[0] as $match ) {

    // add to characters
    $length = mb_strlen($match);

    if (isset($words[$length])) {
        $characters[$length][] = $match;
    } else {
        $characters[$length] = [];
        $characters[$length][] = $match;
    }

    // add to words
    $wordCount = str_word_count($match, 0, '’');

    if (isset($words[$wordCount])) {
        $words[$wordCount][] = $match;
    } else {
        $words[$wordCount] = [];
        $words[$wordCount][] = $match;
    }


}

ksort($characters);
ksort($words);

file_put_contents('characters.php', '<?php $characters = ' . var_export($characters, true) . ';');
file_put_contents('words.php', '<?php $words = ' . var_export($words, true) . ';');
