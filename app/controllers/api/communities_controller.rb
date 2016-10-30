class Api::CommunitiesController < ApplicationController

  def show
  	# shows the search term
  	# with the url in the style http://localhost:3000/api/community.json?term=howdy
  	# TODO: Scrape the community page and return the correct JSON for the search, using Nokogiri
#    render json: { term: params["term"] }
    require 'open-uri'
    @doc = Nokogiri::HTML(open("https://www.digitalocean.com/community/search?q=coreos"))
    @articles = @doc.css("div.feedable-details a")
#    puts articles
  end
end