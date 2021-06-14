Rails.application.routes.draw do
  resources :users, except: [:new, :edit]
  post '/exchange', to: 'transactions#exchange'
end
