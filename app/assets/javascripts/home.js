// Whenever any item with the name of topicsearch is submitted, alert hello
// Use this document ready function to avoid the javascript loading too quickly
$(document).ready(function() {
	$("#topicsearch").submit(function(event) {
		alert("hello");
		event.preventDefault();
	});
 });