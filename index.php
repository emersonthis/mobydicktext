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

# Character count endpoint
$app->get('/c/{n}', function ($request, $response, $args) {

	include './characters.php';

    $min = strlen(array_values($characters)[0]);
    $max = strlen(end($characters));
    reset($characters);

    $matches = (!empty($characters[$args['c']])) ? $characters[$args['c']] : [];

    return (!empty($matches)) ? $response->write( $matches[array_rand($matches)] ) : '';
});

# Word count endpoint
$app->get('/w/{n}', function ($request, $response, $args) {

	include './words.php';
				# start with a capital       # non-whitespace then whitespace
	$pattern = '/[A-Z](\S+[\s\.]){' 		. intval($args['n']) . '}/';
	preg_match_all($pattern, $mobydick1_8, $matches);

	$i = ( !empty($matches) && !empty($matches[0]) ) ? mt_rand( 0, count($matches[0])-1 )  : 0;

    return $response->write($matches[0][$i]);
});

$app->run();
