<?php
require 'vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);

$app = new Slim\App($c);

# Homepage
$app->get('/', function ($request, $response, $args) {
	return $response->write(file_get_contents('./index.html'));
});

function makeHalvesSizes($n) {
    $halfALength;
    $halfBLength;

    if (  $n % 2 == 0 ) {
        $halfALength = ($n/2) - 1;
        $halfBLength = ($n/2);
    } else {
        $halfALength = floor($n/2);
        $halfBLength = floor($n/2);
    }

    return [$halfALength, $halfBLength];

}

function compositeStrings($array, $n) {

    $halfs = makeHalvesSizes($n);
    $halfA = getString($array, $halfs[0]);
    $halfB = getString($array, $halfs[1]);

    return "{$halfA} {$halfB}";
}

function compositeSentences($array, $n) {

    $halfs = makeHalvesSizes($n);
    $halfA = getSentence($array, $halfs[0]);
    $halfB = getSentence($array, $halfs[1]);

    return "{$halfA} {$halfB}";
}

function getString($array, $n) {

    $n = intval($n);

    if (isset($array[$n])) {
        return $array[$n][array_rand($array[$n])];
    } else {
        return compositeStrings($array, $n);
    }
}

//@TODO This should either by different or DRYed with getString
function getSentence($array, $n) {

    $n = intval($n);

    if (isset($array[$n])) {
        return $array[$n][array_rand($array[$n])];
    } else {
        return compositeSentences($array, $n);
    }
}


# Character count endpoint
$app->get('/c/{n}', function ($request, $response, $args) {

	include './characters.php';

    if ($args['n'] > 1000 || $args['n'] < 2) {
        die("Character parameter must be between 2 and 10000");
    }

    return $response->write( getString($characters, $args['n']) );
});

# Word count endpoint
$app->get('/w/{n}', function ($request, $response, $args) {

	include './words.php';

    if ($args['n'] > 1000 || $args['n'] < 1) {
        die("Word parameter must be between 1 and 1000");
    }

    $matches = (!empty($words[$args['n']])) ? $words[$args['n']] : [];

    return $response->write( getSentence($words, $args['n']) );
});

$app->run();
