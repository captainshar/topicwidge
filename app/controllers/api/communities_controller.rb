class Api::CommunitiesController < ApplicationController

  def show
  	# shows the search term
  	# with the url in the style http://localhost:3000/api/community.json?term=howdy
  	# TODO: Scrape the community page and return the correct JSON for the search, using Nokogiri
#    render json: { term: params["term"] }
    require 'open-uri'
    @doc = Nokogiri::HTML(open("https://www.digitalocean.com/community/search?q=#{params["term"]}&type=tutorials"))
    @articles = @doc.css("div.feedable-details a:not(.series)")
    # Filter out questions with regex. The article['href'] part is what Nokogiri gives us
    # Regex uses =~ and surrounds the regex with forward slashes
    # @articles = @articles.reject { |article| article['href']=~/community\/questions\// }
    # Use the binding.pry to stop the program so you can mess around in the terminal
    # binding.pry
    respond_to do |format|
      format.html
      format.json { render :json => @articles.to_json }
    end
#    puts articles
  end
end