<?php
require 'vendor/autoload.php';

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);

$app = new Slim\App($c);

$app->get('/', function ($request, $response, $args) {
	return $response->write("
     “Oh, the rare old Whale, mid storm and gale
     In his ocean home will be
     A giant in might, where might is right,
     And King of the boundless sea.”
      —Whale Song.
	");
});

$app->get('/c/{n}', function ($request, $response, $args) {

	include './mobydick1-8.php';
	$pattern = '/[ABCDEFGHIJKLMNOPQRS].{' . ( intval($args['n']) -1 ) . '}/';
	preg_match_all($pattern, $mobydick1_8, $matches);

	$i = ( !empty($matches) && !empty($matches[0]) ) ? mt_rand( 0, count($matches[0]) ) - 1 : 0;

    return $response->write($matches[0][$i]);
});

$app->run();
