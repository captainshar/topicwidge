<?php

// This first section sets up resources like GuzzleHttp and Twig and a Session

// Use Composer's autoload feature for all my classes
require_once __DIR__.'/vendor/autoload.php';

// Use Guzzle to display the search results from the DO community tutorials
use GuzzleHttp\Client;

// Use Symfony's Response and Request classes
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Create a new Silex app
$app = new Silex\Application();

// enable debug mode
$app['debug'] = true;

// Twig for templates / views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// Makin' a session: a Silex Session
$app->register(new Silex\Provider\SessionServiceProvider());


// This is where the logic starts happening

// Create the GET request for the form
$app->get('/', function(Request $request) use ($app) {  
	
	// Always set the topic to an empty string
	$topic = "";

	// Initialize the array of recent topics if it's not already set
	// If topics_recent is set in this session, set it to the session array
	// If not, create an empty array
	// TODO: Refactor this to use the "has" method with the session variable
	if (($app['session']->get('topics_recent')) !== null) {
		$topics_recent = $app['session']->get('topics_recent');
	}
	else {
		$topics_recent = [];
	}

	// Always initialize the links array to empty
	$links_docommunity = [];

	// Catch the topic variable from the submission form in index.twig
	$topic = $request->query->get('topic');

	// Add the topic to the array of recent topics
	$topics_recent[] = $topic;

	// the session variable is its own thing; need to update that too
	$app['session']->set('topics_recent', $topics_recent);

	// finally, make a display version that reverses the order
	$topics_lifo = array_reverse($topics_recent, true);

	// Now that we have our search term and other vars, start doing things with the user data

	// Create base URL for request for a new Guzzle object
	$client_tuts = new Client(['base_uri' => 'https://www.digitalocean.com/']);

	// Add the search term to the URL
	$response_tuts = $client_tuts->get('community/tutorials' . '?q=' . $topic);

	// If I got a successful 200 response from the page, parse it 
	// Could check with'$code = $response_tuts->getStatusCode();'
	if ($response_tuts->getStatusCode() == 200) {
    	// echo "Request was successful<br/>";
    	
    	//Get the body of the page from Guzzle, could 'echo $body_tuts;'
    	$body_tuts = $response_tuts->getBody();  
    	// echo $body_tuts;

    	// Create a DOM parser object so I can wrangle all the HTML I just sucked in
		$dom = new DOMDocument();

		// Parse the HTML from the tutorial results page
		// The @ before the method call suppresses any warnings that
		// loadHTML might throw because of invalid HTML in the page.
		@$dom->loadHTML($body_tuts);

		// Use the xpath class so I can use the source page's class names while parsing
		$xpath = new DOMXpath($dom);
		// Contains all the divs with this class
  		$article_divs = $xpath->query('//div[@class="feedable-details"]');

		// All feedable-details links in an "array of arrays"
		// where each value is an array with href as key and link text as value
		$links = array();
		// Looping through every element in a "feedable-details" div
		foreach($article_divs as $div) {
			// Extract all the links
			$link_elements = $div->getElementsByTagName("a");
			// Looping through all the links in a single "feedable-details" div
			foreach($link_elements as $item) {
				// Extracting and sanitizing the href and text elements
			    $href =  $item->getAttribute("href");
			    $text = trim(preg_replace("/[\r\n]+/", " ", $item->nodeValue));
			    // Pushing the href and text elements to the $links array
			    $links[] = array(
			      'href' => 'https://www.digitalocean.com' . $href,
			      'text' => $text
			    );
			}
		}
		// Set the $links_docommunity variable to the search results from the DO Community page
		$links_docommunity = $links;
	}
	// Sanity checking some variables

	// var_dump($topics_recent);	
	// var_dump($links_docommunity);

 	// Render the Twig view to actually show things to the user

 	return $app['twig']->render('index.twig', [
		'topic' => $topic, // Sending the most recent search term
		'topics_lifo' => $topics_lifo, // Array of recent search terms
		'links_docommunity' => $links_docommunity, // Array of links from DO Community tutorial search results
	]);


   //TODO: Why does the code after the twig part not execute?

   //Is Twig clearing the topics_recent somehow?
   echo "Y u no execute?<br/>Final recent topics<br/>";
   var_dump($topics_recent);

});

// OMG I forgot to run the app :P
$app->run();
