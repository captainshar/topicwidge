Rails.application.routes.draw do
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  
  #Making /search available as a URL
  get "search", to: "home#index"

  # This handles the home page of the app. It sends the user to the HomeController controller and the index method
  root to: "home#index"

end