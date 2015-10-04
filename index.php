<!DOCTYPE html>
<html>
<title>Topic Widge</title>
<body>

<h1>Enter Topic</h1>

<!-- Search form -->
<form  method="post" action="index.php?go"  id="searchform"> 
	<input  type="text" name="topic"> 
	<input  type="submit" name="submit" value="Search"> 
</form>

<?php

// Using Composer's autoload feature for all my classes
require_once __DIR__.'/vendor/autoload.php';

// Use Guzzle to display the search results from the DO community tutorials
use GuzzleHttp\Client;
// Use Symfony's Response class
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();

// enable debug mode
$app['debug'] = true;

// Twig for templates / views
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

// ... definitions

$app->post('/', function () {
    // Initialize the topic with an empty string
$topic = "";

	//Start a session
	session_start();

	// Initializing the "topics array" and checking for a saved array in the session
	$topics_arr = isset($_SESSION["topics_arr"]) ? $_SESSION["topics_arr"] : [];

	// Check session variables
	// Print_r ($_SESSION);

	// Is the form submitted?
	if(isset($_POST['submit'])) {
		if(isset($_GET['go'])) {
			if($_POST['topic']) {
				$topic=$_POST['topic'];
				echo "<br/> You entered " . $topic . "<br/>";

				// Add topic to topics array, update session array
				array_push($topics_arr, $topic);
				$_SESSION["topics_arr"] = $topics_arr;

				// Make an instance of the topicWidge class
				$searched_topic = new TopicWidge\TopicWidge();

				// Use the echo_topic method
				$searched_topic->echo_topic($topic);
			}
		}
	}
	// Request that the user enters a topic, if none is given
	else {
		echo  "<p>Enter a topic, pretty please.</p>";
	}

	// Create base URL for request
	$client_tuts = new Client(['base_uri' => 'https://www.digitalocean.com/']);

	// Add the search term to the URL
	$response_tuts = $client_tuts->get('community/tutorials' . '?q=' . $topic);

	// If I got a successful 200 response from the page, parse it 
	// Could check with'$code = $response_tuts->getStatusCode();'
	if ($response_tuts->getStatusCode() == 200) {
    	echo "Request was successful<br/>";
    	
    	//Get the body of the page from Guzzle, could 'echo $body_tuts;'
    	$body_tuts = $response_tuts->getBody();
    	

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

		// Show the $links array values, fully expanded
		print_r(array_values($links));

		// Make 'em links again

	}
	// Start the recent search terms list
	echo "<br/> Recent search terms: <br/>";
	// Print out the array of searched topics in this session, most recent first and with HTML breaks
	$topics_recent = array_reverse($topics_arr, true);
	// foreach($topics_recent as $t) {
	// 	echo $t . "<br/>";
	// }

	// Print_r ($_SESSION);

    return new Response(implode("<br/>", $topics_recent));
});

$app->run();




	// DONE: add a session that tracks all the search terms in one session
	// DONE: add https://packagist.org/packages/guzzlehttp/guzzle
	// DONE: Filter only the search results from Guzzle, use a class for this, use regex or http://php.net/manual/en/class.domdocument.php
	// DONE: Use Silex as a framework
	// TODO: Use Twig for templates
?>

</body>
</html>