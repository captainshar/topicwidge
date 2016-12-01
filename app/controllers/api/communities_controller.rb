class Api::CommunitiesController < ApplicationController

  BASE_COMMUNITY_URL = "https://www.digitalocean.com"

  def show
  	# shows the search term
  	# with the url in the style http://localhost:3000/api/community.json?term=howdy
  	# TODO: Scrape the community page and return the correct JSON for the search, using Nokogiri
#    render json: { term: params["term"] }
    require 'open-uri'
    
    @doc = Nokogiri::HTML(open("#{BASE_COMMUNITY_URL}/community/search?q=#{params["term"]}&type=tutorials"))
    @articles = @doc.css("div.feedable-details a:not(.series)")
    # Filter out questions with regex. The article['href'] part is what Nokogiri gives us
    # Regex uses =~ and surrounds the regex with forward slashes
    # @articles = @articles.reject { |article| article['href']=~/community\/questions\// }
    # Use the binding.pry to stop the program so you can mess around in the terminal
    # binding.pry
    respond_to do |format|
      format.html
      format.json do 
        # Pull out the Nokogiri elements we actually want and stuff them in a hash
        articles_hash = @articles.map do |article|
          {title: article.text, href: "#{BASE_COMMUNITY_URL}#{article['href']}" }
        end
        # Make the hash into JSON when the .json URL is called
        render :json => articles_hash.to_json
      end
    end
#    puts articles
  end
end