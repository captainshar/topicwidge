// Whenever any item with the name of topicsearch is submitted, alert hello
// Use this document ready function to avoid the javascript loading too quickly
$(document).ready(function() {
	$("#topicsearch").submit(function(event) {
		$.ajax({
		    url: "api/community.json",
		    type: "GET",
		    // $("#searchterm").val() is the bit of text in the text box
		    data: {
		    	term: $("#searchterm").val()
		    }
		  }).done(function(body) {
		    $('#community-results').html(body);
		  }).fail(function(xhr, status, errorThrown) {
		  	$('#community-results').html('Something went wrong!');
		  })
		event.preventDefault();
	});
 });