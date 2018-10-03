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

function compositeStrings($array, $n) {

    $halfALength;
    $halfBLength;

    if (  $n % 2 == 0 ) {
        $halfALength = ($n/2) - 1;
        $halfBLength = ($n/2);
    } else {
        $halfALength = floor($n/2);
        $halfBLength = floor($n/2);
    }

    $halfA = getString($array, $halfALength);
    $halfB = getString($array, $halfBLength);

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

# Character count endpoint
$app->get('/c/{n}', function ($request, $response, $args) {

	include './characters.php';

    $min = strlen(array_values($characters)[0][0]);
    $max = strlen(end($characters)[0]);
    reset($characters);

    // @TODO validate size
    // var_dump($min);
    // var_dump($max);

    // $matches = (!empty($characters[$args['n']])) ? $characters[$args['n']] : compositeStrings($characters, $args['n']);
    // return (!empty($matches)) ? $response->write( $matches[array_rand($matches)] ) : '';

    return $response->write( getString($characters, $args['n']) );
});

# Word count endpoint
$app->get('/w/{n}', function ($request, $response, $args) {

	include './words.php';

    $min = strlen(array_values($words)[0][0]);
    $max = strlen(end($words)[0]);
    reset($words);

    // @TODO validate size
    // var_dump($min);
    // var_dump($max);

    $matches = (!empty($words[$args['n']])) ? $words[$args['n']] : [];

    return (!empty($matches)) ? $response->write( $matches[array_rand($matches)] ) : '';
});

$app->run();
