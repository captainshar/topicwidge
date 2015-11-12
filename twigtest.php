<?php

// Use Composer's autoload feature for all my classes
require_once __DIR__.'/vendor/autoload.php';

// Create a new Silex app
$app = new Silex\Application();

// enable debug mode
$app['debug'] = true;

// Twig for templates / views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->get('/twigtest.php', function(Request $request) use ($app) {  
	
	// Initialize the topic with a test string
	$topic = "watermelon";

	return $app['twig']->render('index.twig', [
      'topic' => $topic, // Sending the most recent search term
   ]);

});

$app->run();