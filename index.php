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

  if(isset($_POST['submit'])) {
    if(isset($_GET['go'])) {
      // I took out this input matching line
      // if(preg_match("/^[^a-z_\-0-9]/i", $_POST['topic'])) {
      if($_POST['topic']) {
        $topic=$_POST['topic'];
        echo $topic;

        //make an instance of the topicWidge class
        $searched_topic = new topicWidge($topic);
      }
    }
  }
  else {
    echo  "<p>Enter a topic, pretty please.</p>";
  }
?>

</body>
</html>