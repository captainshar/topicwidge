# TopicWidge checks any topic in specific Trello boards, Google search, Google Trends, Google analytics, and maybe more
require 'erb'

class TopicWidge

# only one input - the search term, which may be one or more words

# several outputs which get the output from external services
# I should probably make a separate class for each output so I can mix and match them

	def initialize
		# initialize @searchterm as an empty string
		@searchterm = String.new
	end

	attr_accessor :searchterm
	attr_reader :final_output

	# Set the @searchterm
	def searchterm_set
		
		# Ask for search term
		puts "What is your search term?"

		# Get user input
		s = gets.chomp

		# Update @searchterm
		@searchterm = s

		# Display user input
		puts "You searched for:"
		puts "#{@searchterm}"

	end

	# Display the search results; should work with any number of result vectors
	def results_display(s)

		# Run through all the result vectors
		@final_output = vectors_list(s)

	end

	# This is where you add more vectors that you can run the search through
	def vectors_list(s)

	end

end

# Make a new TopicWidge
tw_mercury = TopicWidge.new

# set the @searchterm with user input
searchterm_mercury = tw_mercury.searchterm_set()

# display results
results_mercury = tw_mercury.results_display(searchterm_mercury)