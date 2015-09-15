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

	if (session_status() == PHP_SESSION_NONE) {
    	session_start();
    	get_searched_topic();
    	echo  "<p>Enter a topic, pretty please.</p>";
	}
	else {

		$_SESSION["current_topic"] = 

		$_SESSION["topics_arr"] = array($_SESSION["current_topic"]);
					var_dump($_SESSION["session_topics_arr"])
					echo "Session variables are set.";
					print_r($_SESSION);
	}

	function get_searched_topic() {
		if(isset($_POST['submit'])) {
			if(isset($_GET['go'])) {
				// I took out this input matching line
				// if(preg_match("/^[^a-z_\-0-9]/i", $_POST['topic'])) {
				if($_POST['topic']) {
					$topic=$_POST['topic'];
					echo $topic;

					//make an instance of the topicWidge class
					$searched_topic = new TopicWidge\TopicWidge();
					//use the echo_topic method
					$searched_topic->echo_topic($topic);

					return $topic;
				}
			}
		}
		else {
			return null;
		}
	}

	// next step: add a session that tracks all the search terms in one session
	// homework: add https://packagist.org/packages/guzzlehttp/guzzle, get only the results
?>

</body>
</html>