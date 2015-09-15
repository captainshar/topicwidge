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
	$topics_arr = isset($_SESSION["topics_arr"]) ? $_SESSION["topics_arr"] : array();

	//Is the form submitted?
	if(isset($_POST['submit'])) {
		if(isset($_GET['go'])) {
			if($_POST['topic']) {
				$topic=$_POST['topic'];
				echo nl2br("\n You entered " . $topic . "\n");

				//add topic to session array
				array_push($_SESSION["topics_arr"], $topic);

				//make an instance of the topicWidge class
				$searched_topic = new TopicWidge\TopicWidge();
				//use the echo_topic method
				$searched_topic->echo_topic($topic);

				//start the recent search terms list
				echo nl2br("\n Recent search terms: \n");
			}
		}
	}
	else {
		echo  "<p>Enter a topic, pretty please.</p>";
	}

	//Print out the array of searched topics in this session, most recent first and with HTML breaks
	$topics_recent = array_reverse($topics_arr, true);
	foreach($topics_recent as $key => $t) {
		echo nl2br($t . "\n");
	}


	// next step: add a session that tracks all the search terms in one session
	// homework: add https://packagist.org/packages/guzzlehttp/guzzle, get only the results
?>

</body>
</html>