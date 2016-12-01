// Whenever any item with the name of topicsearch is submitted, alert hello
// Use this document ready function to avoid the javascript loading too quickly
$(document).ready(function() {
	//the submit block is everything that happens when the search "Submit" form is submitted
	$("#topicsearch").submit(function(event) {
		// Getting the searchterm
		// $("#searchterm").val() is the bit of text in the text box, using jQuery
		var searchterm = $("#searchterm").val();
		// This whole ajax block is to get the Community tutorial results
		$.ajax({
		    url: "api/community.json",
		    type: "GET",
		    data: {
		    	term: searchterm
		    }
		  }).done(function(articles) {
		  	var arrayLength = articles.length;
				for (var i = 0; i < arrayLength; i++) {
   				 //console.log(articles[i]);
   				 $('#community-results').append("<div><a href=\""+articles[i].href+"\">"+articles[i].title+"</a></div>")
   				 //TODO: Turn each element in the articles array into HTML and append to the
   				 //community-results div on the index.html.erb page
			}
//		    $('#community-results').html(body);
//		    console.log(articles);
		  }).fail(function(xhr, status, errorThrown) {
		  	$('#community-results').html('Something went wrong!');
		  })
		//Google Trends results fills in the iframe in the index.html.erb document
    	document.getElementById("trendsFrame").src = "http://www.google.com/trends/fetchComponent?hl=en-US&q=" + searchterm + "&cmpt=q&content=1&cid=TIMESERIES_GRAPH_0&export=5&w=640&h=330";
		event.preventDefault();
	});
 });
