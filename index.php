<!DOCTYPE html>
<html>
<title>Topic Widge</title>
<body>

<h1>Enter Topic</h1>

<form  method="post" action="index.php?go"  id="searchform"> 
	<input  type="text" name="topic"> 
	<input  type="submit" name="submit" value="Search"> 
</form>

<?php

require 'vendor/autoload.php';

$topic = "";

	//Start a session
	session_start();

	// Initializing session things
	$topics_arr = isset($_SESSION["topics_arr"]) ? $_SESSION["topics_arr"] : [];

	//Is the form submitted?
	if(isset($_POST['submit'])) {
		if(isset($_GET['go'])) {
			if($_POST['topic']) {
				$topic=$_POST['topic'];
				echo "< br /> You entered " . $topic . "< br />";

				//add topic to session array
				array_push($_SESSION["topics_arr"], $topic);

				//make an instance of the topicWidge class
				$searched_topic = new TopicWidge\TopicWidge();
				//use the echo_topic method
				$searched_topic->echo_topic($topic);

				//start the recent search terms list
				echo "< br /> Recent search terms: < br />";
			}
		}
	}
	else {
		echo  "<p>Enter a topic, pretty please.</p>";
	}

	//Print out the array of searched topics in this session, most recent first and with HTML breaks
	$topics_recent = array_reverse($topics_arr, true);
	foreach($topics_recent as $t) {
		echo $t . "< br />";
	}

	// Use Guzzle to display the search results from the DO community tutorials
	use GuzzleHttp\Client;

	//create base url for request
	$client_tuts = new Client(['base_uri' => 'https://www.digitalocean.com/']);

	$response_tuts = $client_tuts->get('community/tutorials');

	$code = $response_tuts->getStatusCode(); // 200

	// Check if a header exists.
	if ($response_tuts->hasHeader('Content-Length')) {
	    echo "It exists";
	}


	// next step: add a session that tracks all the search terms in one session
	// homework: add https://packagist.org/packages/guzzlehttp/guzzle, get only the results
?>

</body>
</html>