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

	include './mobydick1-8.php';
				# start with a capital letter.   # set length of following chars
	$pattern = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ].{' 		. ( intval($args['n']) -2 ) . '}\./';
	preg_match_all($pattern, $mobydick1_8, $matches);

	# if no matches with period at the end, try without
	if ( empty($matches[0]) ) {
		$pattern2 = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ].{' 		. ( intval($args['n']) -1 ) . '}/';
		preg_match_all($pattern2, $mobydick1_8, $matches);
	}

	$i = ( !empty($matches) && !empty($matches[0]) ) ? mt_rand( 0, count($matches[0])-1 )  : 0;

    return $response->write($matches[0][$i]);
});

# Word count endpoint
$app->get('/w/{n}', function ($request, $response, $args) {

	include './mobydick1-8.php';
				# start with a capital letter.   # set length of following chars
	$pattern = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ](\S+[\s]){' 		. intval($args['n']) . '}/';
	preg_match_all($pattern, $mobydick1_8, $matches);

	$i = ( !empty($matches) && !empty($matches[0]) ) ? mt_rand( 0, count($matches[0])-1 )  : 0;

    return $response->write($matches[0][$i]);
});

$app->run();
