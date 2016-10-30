Rails.application.routes.draw do
  # For details on the DSL available within this file, see http://guides.rubyonrails.org/routing.html
  
  #Making /search available as a URL
  get "search", to: "home#index"

  # everything in this block will be nested in the /api URL route
  # a namespace is just kind of a way to make folders or classes named, in this case, api
  # Rails expects a corresponding class namespace
  # e.g. a controller called communities_controller.rb in the controllers/api folder
  namespace :api do
  	resource :community, only: :show
  end

  # This handles the home page of the app. It sends the user to the HomeController controller and the index method
  root to: "home#index"

end